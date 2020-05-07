<?php

declare(strict_types = 1);

namespace App\Model;

use Nette;
use Nette\Security\Passwords;
use Nette\Security\IIdentity;
use App\Model\EmailManager;


class UserManager implements Nette\Security\IAuthenticator {

    use Nette\SmartObject;

    private const
            TABLE_USERS = 'users',
            COLUMN_ID = 'id',
            COLUMN_FIRSTNAME = 'firstname',
            COLUMN_LASTNAME = 'lastname',
            COLUMN_PASSWORD_HASH = 'password',
            COLUMN_EMAIL = 'email',
            COLUMN_STREET = 'street',
            COLUMN_CITY = 'city',
            COLUMN_POSTAL = 'postal',
            COLUMN_GSM = 'gsm',
            COLUMN_NOTICE = 'notice',
            COLUMN_ROLE = 'role',
            COLUMN_ACTIVE = 'active',
            COLUMN_TOKEN = 'token',
            COLUMN_CREATOR = 'creator',
            COLUMN_CREATED_AT = 'created_at',
            COLUMN_EDITOR = 'editor',
            COLUMN_EDITED_AT = 'edited_at';
    
    /** @var Nette\Database\Context */
    private $database;
    
    /** @var Nette\Security\Passwords */
    private $passwords;
    
    /** @var App\Model\EmailManager */
    private $emailManager;

    public function __construct(Nette\Database\Context $database,
                                Passwords $passwords,
                                EmailManager $emailManager) {
            $this->database = $database;
            $this->passwords = $passwords;
            $this->emailManager = $emailManager;
    }


    /**
     * Performs an authentication.
     * @param array $credentials
     * @return \Nette\Security\IIdentity
     * @throws Nette\Security\AuthenticationException
     */
    public function authenticate(array $credentials): Nette\Security\IIdentity {
        
        [$email, $password] = $credentials;

        $row = $this->database->table(self::TABLE_USERS)
                ->where(self::COLUMN_EMAIL, $email)
                ->where(self::COLUMN_ACTIVE, 'ANO')
                ->fetch();

        if (!$row) {
            
            throw new Nette\Security\AuthenticationException('Neznámý email.', self::IDENTITY_NOT_FOUND);
            
        } elseif (!$this->passwords->verify($password, $row[self::COLUMN_PASSWORD_HASH])) {
            
            throw new Nette\Security\AuthenticationException('Nesprávné heslo.', self::INVALID_CREDENTIAL);
            
        } elseif ($this->passwords->needsRehash($row[self::COLUMN_PASSWORD_HASH])) {
            
            $row->update([
                self::COLUMN_PASSWORD_HASH => $this->passwords->hash($password),
            ]);
        }

        $arr = $row->toArray();
        unset($arr[self::COLUMN_PASSWORD_HASH]);
        
        return new Nette\Security\Identity($row[self::COLUMN_ID], $row[self::COLUMN_ROLE], $arr);
    }

    /**
     * Add new user.
     * @param type $logged_user
     * @param type $values
     * @throws DuplicateNameException
     * @throws NewsletterException
     */
    public function add($logged_user, $values): void {
        
        Nette\Utils\Validators::assert($values->email, 'email');
        
        $token = sha1('registration_time' . time());
        
        // set the "Zakladni" role when trying to insert a new user by a user other than ADMIN
        if (empty($values->role)){
            $values->role = 'Zakladni';
        }

        try {
            $this->database->table(self::TABLE_USERS)->insert([
                self::COLUMN_FIRSTNAME => $values->firstname,
                self::COLUMN_LASTNAME => $values->lastname,
                self::COLUMN_EMAIL => $values->email,
                self::COLUMN_PASSWORD_HASH => $this->passwords->hash($values->password),
                self::COLUMN_ROLE => $values->role,
                self::COLUMN_ACTIVE => 'NE',
                self::COLUMN_TOKEN => $token,
                self::COLUMN_CREATOR => $logged_user->isLoggedIn() ? $logged_user->getIdentity()->getData()['email'] : $email,
                self::COLUMN_CREATED_AT => time(),
            ]);
        } catch (Nette\Database\UniqueConstraintViolationException $e) {
            throw new DuplicateNameException;
        }
        
        // send registration email
        try {
            
            $this->emailManager->sendUserRegistration($values->email, $token);
            
        } catch (\Exception $e) {
            throw new NewsletterException('Chyba při odeslání registračního emailu! (detail - \App\Model\UserManeger::add()) (' . $e->getMessage() . ')');
        }
    }
    
    /**
     * Edit user
     * @param type $logged_user
     * @param type $values
     * @param type $userId
     * @throws UserException
     */
    public function edit($logged_user, $values, $userId): void {

        Nette\Utils\Validators::assert($values->email, 'email');

        try { 
            // update user by ADMIN role
            if ($logged_user->isInRole('Admin')) {
                $this->database->table(self::TABLE_USERS)->get($userId)->update([
                    self::COLUMN_ROLE => $values->role,
                    self::COLUMN_ACTIVE => $values->active,
                ]);
            }
            
            // update user by any user
            $this->database->table(self::TABLE_USERS)->get($userId)->update([
                self::COLUMN_FIRSTNAME => $values->firstname,
                self::COLUMN_LASTNAME => $values->lastname,
                self::COLUMN_EMAIL => $values->email,
                self::COLUMN_EDITOR => $logged_user->getIdentity()->getData()['email'],
                self::COLUMN_EDITED_AT => time(),
            ]);
            
           
        } catch (Nette\Database\UniqueConstraintViolationException $e) {
            throw new UserException('Chyba při změně uživatele (detail - \App\Model\UserManager::edit()) ' . $e->getMessage());
        }
    }

    
    /**
     * Edit user password
     * @param type $logged_user
     * @param type $values
     * @param type $userId
     * @throws UserException
     */
    public function editPassword($logged_user, $values, $userId): void {

        try {
            $this->database->table(self::TABLE_USERS)->get($userId)->update([
                self::COLUMN_PASSWORD_HASH => $this->passwords->hash($values->password),
                self::COLUMN_EDITOR => $logged_user->getIdentity()->getData()['email'],
                self::COLUMN_EDITED_AT => time(),
            ]);
        } catch (UserException $e) {
            throw new UserException('Chyba při změně hesla (detail - \App\Model\UserManager::editPassword()) ' . $e->getMessage());
        }
    }
}

class DuplicateNameException extends \Exception {}
class UserException extends \Exception {}