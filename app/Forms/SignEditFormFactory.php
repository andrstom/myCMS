<?php

declare(strict_types = 1);

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;
use App\Model;
use App\Model\UserManager;

/**
 * Edit user form
 */
final class SignEditFormFactory {
    
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

        $form = new Form;

        // Set form labels
        $form->addText('firstname', 'Jméno', 55);

        $form->addText('lastname', 'Příjmení', 55);

        $form->addText('email', '* E-mail', 55)
                ->setHtmlType('email')
                ->setOption('description', 'Slouží pro příhášení do aplikace!')
                ->setRequired('Vyplňte Email')
                ->addRule(Form::EMAIL, 'Neplatná emailová adresa');

        if ($this->user->isInRole('Admin')) {
            $form->addSelect('role', 'Oprávnění', ['Admin' => 'Admin', 'Super' => 'Super', 'Zakladni' => 'Zakladni']);
            $form->addSelect('active', 'Aktivní', ['ANO' => 'ANO', 'NE' => 'NE']);
        }

        $form->addSubmit('send', 'Uložit');

        $form->onSuccess[] = function (Form $form, \stdClass $values) use ($userId, $onSuccess): void {

            try {

                $this->userManager->edit($this->user, $values, $userId);
            } catch (Model\DuplicateNameException $e) {

                $form->addError('Jejda - něco se zvrtlo! chyba(' . $e->getMessage() . ')');
                return;
            }
            $onSuccess();
        };

        return $form;
    }
}