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

final class OrganisationDetailFormFactory {

    use Nette\SmartObject;

    /** @var App\Forms\FormFactory */
    private $factory;

    /** @var Model\OrganisationManager */
    private $organisationManager;
    
    /** @var Model\DbHandler */
    private $dbHandler;
    
    /** @var type Nette\Security\User */
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

    public function create($organisation_id, $organisationDetail_id, callable $onSuccess): Form {

        $form = $this->factory->create();

        $form = new Form;

        // Set form labels
        $form->addText('title', '* Nadpis')
                ->setRequired('Vyplňte Nadpis')
                ->setHtmlAttribute('class', 'form-control');

        $form->addTextarea('content', 'Popis')
                ->setAttribute('rows', 10)
                ->setHtmlAttribute('class', 'form-control');

        // set dafault number of samples
        $copies = 1;

        // set maximum samples
        $maxCopies = 1;

        $multiplier = $form->addMultiplier('formImages', function (Container $container, Form $form) {

            $container->addUpload('image', 'Obrázek')
                    ->setHtmlAttribute('class', 'form-control')
                    ->addRule(Form::IMAGE, 'Musí být JPEG, PNG nebo GIF.')
                    ->addRule(Form::MAX_FILE_SIZE, 'Maximální velikost souboru je 5 MB.', 5000 * 1024);
        }, $copies, $maxCopies);

        $form->addSubmit('send', 'Uložit')
                ->setHtmlAttribute('class', 'btn btn-primary col-lg-12');

        $form->onSuccess[] = function (Form $form, \stdClass $values) use ($organisation_id, $organisationDetail_id, $onSuccess): void {

            if (!$organisationDetail_id) {

                // Add
                $this->organisationManager->addDetail($this->user, $organisation_id, $values);
            } else {

                // Edit
                $this->organisationManager->editDetail($this->user, $organisation_id, $organisationDetail_id, $values);
            }

            $onSuccess();
        };
        return $form;
    }
}