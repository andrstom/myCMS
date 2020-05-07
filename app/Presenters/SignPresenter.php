<?php

declare(strict_types = 1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\Passwords;
use App\Forms;

final class SignPresenter extends BasePresenter {

    use Nette\SmartObject;
    
    private 
            const DEFAULT_PASSWORD = '123psw321';
    
    /** @persistent */
    public $backlink = '';
    
    /** @var type */
    private $userId;
    
    /** @var type */
    private $editUser;
    
    /** @var Nette\Database\Context */
    private $database;
    
    /** @var Passwords */
    private $passwords;
    
    /** @var Forms\SignInFormFactory */
    private $signInFactory;

    /** @var Forms\SignUpFormFactory */
    private $signUpFactory;
    
    /** @var Forms\SignEditFormFactory */
    private $signEditFactory;
    
    /** @var Forms\SignEditPasswordFormFactory */
    private $signEditPasswordFactory;
    
    public function __construct(Nette\Database\Context $database,
                                Passwords $passwords,
                                Forms\SignInFormFactory $signInFactory,
                                Forms\SignUpFormFactory $signUpFactory,
                                Forms\SignEditFormFactory $signEditFactory,
                                Forms\SignEditPasswordFormFactory $signEditPasswordFactory) {
        $this->database = $database;
        $this->passwords = $passwords;
        $this->signInFactory = $signInFactory;
        $this->signUpFactory = $signUpFactory;
        $this->signEditFactory = $signEditFactory;
        $this->signEditPasswordFactory = $signEditPasswordFactory;
    }
    
    public function renderDefault(): void {

        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage('Musíte se přihlásit!');
            $this->redirect('Sign:in');
        }

        $this->template->webusers = $this->database->table('users');
        $this->template->loggedUser = $this->database->table('users')->get($this->getUser()->id);

    }
    
    public function renderUp(): void {

        if (!$this->getUser()->isInRole('Admin')) {
            $this->flashMessage('Nemáte dostatečné oprávnění!');
            $this->redirect('Sign:default');
        }

        $this->template->webuser = $this->editUser;

    }
    
    public function renderEdit(): void {

        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage('Musíte se přihlásit!');
            $this->redirect('Sign:in');
        }

        $this->template->webuser = $this->editUser;

    }

    /**
     * Sign-in form factory.
     */
    protected function createComponentSignInForm(): Form {
        return $this->signInFactory->create(function (): void {
                    $this->restoreRequest($this->backlink);
                    $this->redirect('Homepage:');
                });
    }

    /**
     * Sign-up form factory.
     */
    protected function createComponentSignUpForm(): Form {
        return $this->signUpFactory->create(function (): void {
                    $this->flashMessage('Nový uživatel byl úspěšně přidán. Aktivujte účet kliknutím na odkaz v emailu, který byl odeslán na použitou adresu.');
                    $this->redirect('Sign:default');
                });
    }

    /**
     * Edit user form factory.
     */
    protected function createComponentSignEditForm(): Form {
        
        return $this->signEditFactory->create($this->editUser->id, function(): void {
                    $this->flashMessage('Změna uživatele byla úspěšná.');
                    $this->redirect('Sign:default');
                });
    }
    
    /**
     * Edit password form factory.
     */
    protected function createComponentSignEditPasswordForm(): Form {
        
        return $this->signEditPasswordFactory->create($this->editUser->id, function(): void {
                    $this->flashMessage('Změna hesla byla úspěšná.');
                    $this->redirect('Sign:default');
                });
    }

    /**
     * Edit user
     * @param type $userId
     */
    public function actionEdit($userId): void {
        
        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage('Musíte se přihlásit!');
            $this->redirect('Sign:in');
        }

        $editUser = $this->database->table('users')->get($userId);
        $this->editUser = $editUser;
        
        if (!$editUser) {

            $this->error('Uživatel nebyl nalezen');
        }
        
        $this['signEditForm']->setDefaults($editUser->toArray());
        
    }
    
    /**
     * Reset password
     * @param type $userId
     */
    public function actionResetPassword($userId): void {
        
        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage('Musíte se přihlásit!');
            $this->redirect('Sign:in');
        }

        $resetPassword = $this->database->table('users')->get($userId);

        if (!$resetPassword) {
            $this->error('Uživatel nebyl nalezen');
        }

        // delete from db
        $update = $resetPassword->update(['password' => $this->passwords->hash(self::DEFAULT_PASSWORD)]);
        
        if ($update) {
            $this->flashMessage('Heslo bylo resetováno!', 'success');
            $this->redirect('Sign:default');
        } else {
            $this->flashMessage('CHYBA: Heslo nebylo resetováno!', 'danger');
            $this->redirect('Sign:default');
        }
    }
    
    /**
     * Delete user
     * @param type $userId
     */
    public function actionDelete($userId): void {
        
        if (!$this->getUser()->isLoggedIn() && !$this->getUser()->isInRole('Admin')) {
            $this->flashMessage('Musíte se přihlásit!');
            $this->redirect('Sign:in');
        }

        $deleteUser = $this->database->table('users')->get($userId);

        if (!$deleteUser) {
            $this->error('Uživatel nebyl nalezen');
        }

        // delete from db
        $delete = $deleteUser->delete();
        
        if ($delete) {
            $this->flashMessage('Uživatel byl smazán!', 'success');
            $this->redirect('Sign:default');
        } else {
            $this->flashMessage('CHYBA: Uživatel nebyl smazán!', 'danger');
            $this->redirect('Sign:default');
        }
    }
    
    /**
     * User email confirmation
     * @param type $token
     */
    public function actionUserConfirmation($token): void {

            $confirmEmail = $this->database->table('users')->where('token ?', $token)->fetch();

            if (!$confirmEmail) {
                $this->error('Uživatel nelze ověřit - neexistuje!');
            }

            // update 'active'
            $confirm = $confirmEmail->update(['active' => 'ANO']);
            
            if ($confirm) {
                $this->flashMessage('Účet ' . $confirmEmail->email . ' byl aktivován!', 'success');
                $this->redirect('Homepage:default');
            } else {
                $this->flashMessage('CHYBA: Účet nelze aktivovat!', 'danger');
                $this->redirect('Homepage:default');
            }
    }
    
    /**
     * Sign out
     */
    public function actionOut(): void {
        
        $this->getUser()->logout();
        
        // redirect and message
        $this->flashMessage('Odhlášení bylo úspěšné.');
        $this->redirect('Homepage:default');
    }

}
