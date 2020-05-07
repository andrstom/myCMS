<?php

declare(strict_types = 1);

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;

final class SignInFormFactory {

    use Nette\SmartObject;

    /** @var App\Forms\FormFactory */
    private $factory;

    /** @var Nette\Security\User */
    private $user;

    public function __construct(FormFactory $factory,
                                User $user) {
        $this->factory = $factory;
        $this->user = $user;
    }

    public function create(callable $onSuccess): Form {

        $form = $this->factory->create();

        $form->addText('email', 'Email')
                ->setHtmlType('email')
                ->setRequired('Vyplňte Email')
                ->addRule(Form::EMAIL, 'Neplatný formát emailu!');

        $form->addPassword('password', 'Heslo')
                ->setRequired('Zadejte heslo!');

        $form->addCheckbox('remember', 'Zůstat přihlášený (10 dní)');

        $form->addSubmit('send', 'Přihlásit');

        $form->onSuccess[] = function (Form $form, \stdClass $values) use ($onSuccess): void {
            try {

                $this->user->setExpiration($values->remember ? '10 days' : '20 minutes');
                $this->user->login($values->email, $values->password);
            } catch (Nette\Security\AuthenticationException $e) {

                $form->addError('Uuups, chyba v emailu nebo heslu! (Nebo není účet aktivován)');
                return;
            }
            $onSuccess();
        };

        return $form;
    }
}