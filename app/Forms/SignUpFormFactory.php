<?php

declare(strict_types = 1);

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;
use App\Model;
use App\Model\UserManager;
use App\Model\DbHandler;

final class SignUpFormFactory {

    use Nette\SmartObject;

    private

    const PASSWORD_MIN_LENGTH = 6;

    /** @var App\Forms\FormFactory */
    private $factory;

    /** @var App\Model\UserManager */
    private $userManager;
    
    /** @var App\Model\DbHandler */
    private $dbHandler;
    
    /** @var Nette\Security\User */
    private $user;

    public function __construct(FormFactory $factory,
                                UserManager $userManager,
                                User $user,
                                DbHandler $dbHandler) {
        $this->factory = $factory;
        $this->userManager = $userManager;
        $this->user = $user;
        $this->dbHandler = $dbHandler;
    }

    public function create(callable $onSuccess): Form {

        $form = $this->factory->create();

        $form = new Form;

        // Set form labels
        $form->addText('firstname', 'Jméno');

        $form->addText('lastname', 'Příjmení');

        $form->addText('email', '* E-mail', 55)
                ->setHtmlType('email')
                ->setOption('description', 'Slouží pro přihlášení do aplikace! Na tuto adresu bude odeslán aktivační email!')
                ->setRequired('Vyplňte Email')
                ->addRule(Form::EMAIL, 'Neplatná emailová adresa')
                ->addRule(function ($control) {
                    return !$this->dbHandler->getUsers()->where('email = ?', $control->value)->fetch();
                }, 'Jejda, email už je obsazený!');

        if ($this->user->isInRole('Admin')) {
            $form->addSelect('role', 'Oprávnění', ['Admin' => 'Admin', 'Super' => 'Super', 'Zakladni' => 'Zakladni']);
        }

        $form->addPassword('password', '* Heslo')
                ->setOption('description', sprintf('Alespoň %d znaků', self::PASSWORD_MIN_LENGTH))
                ->setRequired('Vyplňte heslo.')
                ->addRule($form::MIN_LENGTH, 'Heslo musí mýt alespoň 6 znaků!', self::PASSWORD_MIN_LENGTH);

        $form->addPassword('password2', '* Heslo znovu', 20)
                ->addConditionOn($form['password'], Form::VALID)
                ->setRequired('Vyplňte Heslo znovu')
                ->addRule(Form::EQUAL, 'Hesla se neshodují', $form['password']);

        $form->addSubmit('send', 'Uložit')
                ->setHtmlAttribute('class', 'btn btn-primary');

        $form->onSuccess[] = function (Form $form, \stdClass $values) use ($onSuccess): void {
            try {

                $this->userManager->add($this->user, $values);
            } catch (Model\DuplicateNameException $e) {

                $form['email']->addError('Jejda - email (' . $values->email . ') je u nás už zaregistrovný!');
                return;
            }
            $onSuccess();
        };

        return $form;
    }
}