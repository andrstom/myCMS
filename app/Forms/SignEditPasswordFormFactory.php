<?php

declare(strict_types = 1);

namespace App\Forms;

use App\Model;
use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;
use App\Model\UserManager;

/**
 * Edit password form
 */
final class SignEditPasswordFormFactory {
    
    use Nette\SmartObject;

    private const PASSWORD_MIN_LENGTH = 6;

    /** @var App\Forms\FormFactory */
    private $factory;

    /** @var App\Model\UserManager */
    private $userManager;

    /** @var Nette\Security\User */
    private $user;

    private $editUser;
    
    public function __construct(FormFactory $factory,
                                UserManager $userManager,
                                User $user) {
            $this->factory = $factory;
            $this->userManager = $userManager;
            $this->user = $user;
    }

    public function create($userId, callable $onSuccess): Form {

        $form = $this->factory->create();

        // set array of roles
        $roles = array('Admin' => 'Admin', 'Basic' => 'Základní');

        $form = new Form;

        // Set form labels
        $form->addPassword('password', '* Heslo')
                ->setOption('description', sprintf('Alespoň %d znaků', self::PASSWORD_MIN_LENGTH))
                ->setRequired('Vyplňte heslo.')
                ->addRule($form::MIN_LENGTH, 'Heslo musí mýt alespoň 6 znaků!', self::PASSWORD_MIN_LENGTH);

        $form->addPassword('password2', '* Heslo znovu', 20)
                ->addConditionOn($form['password'], Form::VALID)
                ->setRequired('Vyplňte Heslo znovu')
                ->addRule(Form::EQUAL, 'Hesla se neshodují', $form['password']);

        $form->addSubmit('send', 'Uložit');

        $form->onSuccess[] = function (Form $form, \stdClass $values) use ($userId, $onSuccess): void {

            try {

                $this->userManager->editPassword($this->user, $values, $userId);
            } catch (Model\UserException $e) {

                $form->addError('Jejda - něco se zvrtlo! chyba(' . $e->getMessage() . ')');
                return;
            }
            $onSuccess();
        };

        return $form;
    }
}