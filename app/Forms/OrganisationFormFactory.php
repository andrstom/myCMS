<?php

declare(strict_types = 1);

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;
use Nette\Forms\Container;
use App\Model;
use App\Model\OrganisationManager;
use App\Model\DbHandler;

final class OrganisationFormFactory {

    use Nette\SmartObject;

    /** @var App\Forms\FormFactory */
    private $factory;

    /** @var App\Model\OrganisationManager */
    private $organisationManager;
    
    /** @var App\Model\DbHandler */
    private $dbHandler;
    
    /** @var Nette\Security\User */
    private $user;

    public function __construct(FormFactory $factory,
                                OrganisationManager $organisationManager,
                                User $user,
                                DbHandler $dbHandler) {
        $this->factory = $factory;
        $this->organisationManager = $organisationManager;
        $this->user = $user;
        $this->dbHandler = $dbHandler;
    }

    public function create($organisation_id, callable $onSuccess): Form {

        $form = $this->factory->create();

        $form = new Form;

        $form->addText('short_name', '* Krátký název')
                ->setRequired('Vyplňte Krátký název')
                ->setHtmlAttribute('class', 'form-control');

        $form->addText('name', '* Dlouhý název')
                ->setRequired('Vyplňte Dlouhý název')
                ->setHtmlAttribute('class', 'form-control');

        // set dafault number of samples
        $copies = 1;

        // set maximum samples
        $maxCopies = 1;

        $multiplier = $form->addMultiplier('formImages', function (Container $container, Form $form) {

            $container->addUpload('image', 'Logo')
                    ->setHtmlAttribute('class', 'form-control')
                    ->addRule(Form::IMAGE, 'Musí být JPEG, PNG nebo GIF.')
                    ->addRule(Form::MAX_FILE_SIZE, 'Maximální velikost souboru je 5 MB.', 5000 * 1024);
        }, $copies, $maxCopies);

        $form->addText('email', 'E-mail')
                ->setHtmlType('email')
                ->addRule(Form::EMAIL, 'Neplatná emailová adresa')
                ->setHtmlAttribute('class', 'form-control');

        $form->addText('phone', 'Pevná linka')
                ->setHtmlAttribute('class', 'form-control');

        $form->addText('gsm', 'GSM')
                ->setHtmlAttribute('class', 'form-control');

        $form->addText('street', '* Ulice, č.p.')
                ->setRequired('Vyplňte Ulice, č.p.')
                ->setHtmlAttribute('class', 'form-control');

        $form->addText('city', '* Město/Obec')
                ->setRequired('Vyplňte Město/Obec')
                ->setHtmlAttribute('class', 'form-control');

        $form->addText('postal', '* PSČ')
                ->setRequired('Vyplňte PSČ')
                ->setHtmlAttribute('class', 'form-control');

        $form->addText('ico', 'IČ')
                ->setHtmlAttribute('class', 'form-control');

        $form->addText('dic', 'DIČ')
                ->setHtmlAttribute('class', 'form-control');

        $form->addText('account', 'Bankovní účet')
                ->setHtmlAttribute('class', 'form-control');

        $form->addSelect('sponsors', 'Zobrazit sponzory', ['ANO' => 'ANO', 'NE' => 'NE'])
                ->setHtmlAttribute('class', 'form-control');

        $form->addSelect('clients', 'Zobrazit klienty', ['ANO' => 'ANO', 'NE' => 'NE'])
                ->setHtmlAttribute('class', 'form-control');

        $form->addSubmit('send', 'Uložit')
                ->setHtmlAttribute('class', 'btn btn-primary col-lg-12');

        $form->onSuccess[] = function (Form $form, \stdClass $values) use ($organisation_id, $onSuccess): void {

            if (!$organisation_id) {

                // Add
                $this->organisationManager->add($this->user, $values);
            } else {

                // Edit
                $this->organisationManager->edit($this->user, $organisation_id, $values);
            }

            $onSuccess();
        };
        return $form;
    }
}