<?php

declare(strict_types = 1);

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;
use Nette\Forms\Container;
use App\Model;
use App\Model\SponsorsManager;
use App\Model\DbHandler;

final class OrganisationSponsorsFormFactory {

    use Nette\SmartObject;

    /** @var App\Forms\FormFactory */
    private $factory;

    /** @var App\Model\SponsorsManager */
    private $sponzorsManager;
    
    /** @var App\Model\DbHandler */
    private $dbHandler;
    
    /** @var Nette\Security\User */
    private $user;

    public function __construct(FormFactory $factory,
                                SponsorsManager $sponzorsManager,
                                User $user,
                                DbHandler $dbHandler) {
        $this->factory = $factory;
        $this->sponzorsManager = $sponzorsManager;
        $this->user = $user;
        $this->dbHandler = $dbHandler;
    }

    public function create($organisation_id, $organisationSponsor_id, callable $onSuccess): Form {

        $form = $this->factory->create();

        $form = new Form;

        // Set form labels
        $form->addText('name', '* Název')
                ->setRequired('Vyplňte Název')
                ->setHtmlAttribute('class', 'form-control');
        
        $form->addText('link', 'Odkaz na web (vč. http:// nebo https://)')
                ->setHtmlAttribute('class', 'form-control');

        // set dafault number of samples
        $copies = 1;

        // set maximum samples
        $maxCopies = 1;

        $multiplier = $form->addMultiplier('formImages', function (Container $container, Form $form) {

            $container->addUpload('image', 'Logo sponzora')
                    ->setHtmlAttribute('class', 'form-control')
                    ->addRule(Form::IMAGE, 'Musí být JPEG, PNG nebo GIF.')
                    ->addRule(Form::MAX_FILE_SIZE, 'Maximální velikost souboru je 5 MB.', 5000 * 1024);

        }, $copies, $maxCopies);

        
        $form->addSubmit('send', 'Uložit')
                ->setHtmlAttribute('class', 'btn btn-primary col-lg-12');
        
        $form->onSuccess[] = function (Form $form, \stdClass $values) use ($organisation_id, $organisationSponsor_id, $onSuccess): void {

            if(!$organisationSponsor_id) {
                
                // Add
                $this->sponzorsManager->addSponsor($this->user, $organisation_id, $values);
                
            } else {
                
                // Edit
                $this->sponzorsManager->editSponsor($this->user, $organisation_id, $organisationSponsor_id, $values);
                
            }

            $onSuccess();
        };
        return $form;
    }

}
