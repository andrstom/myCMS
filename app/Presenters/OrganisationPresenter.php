<?php

declare(strict_types = 1);

namespace App\Presenters;

use Nette;
use Nette\Utils\FileSystem;
use App\Forms;
use Nette\Application\UI\Form;
use App\Model\DbHandler;


class OrganisationPresenter extends BasePresenter {
    
    /** @persistent */
    public $backlink = '';
    
    /** @var type int */
    private $organisationId;
    
    /** @var type int */
    private $employeeId;
    
    /** @var type int */
    private $clientId;
    
     /** @var type int */
    private $sponsorId;
    
    /** @var type object */
    private $editOrganisation;
    
    /** @var type object */
    private $editEmployee;
    
    /** @var type object */
    private $editClient;
    
    /** @var type object */
    private $editSponsor;
    
    /** @var App\Model\DbHandler */
    public $dbHandler;
    
    /** @var App\Forms\OrganisationFormFactory */
    private $organisationFactory;
    
    /** @var App\Forms\EmployeesFormFactory */
    private $employeesFactory;
    
    /** @var App\Forms\OrganisationClientsFormFactory */
    private $clientFactory;
    
    /** @var App\Forms\OrganisationSponsorsFormFactory */
    private $sponsorFactory;
    
    public function __construct(DbHandler $dbHandler,
                                Forms\OrganisationFormFactory $organisationFactory,
                                Forms\EmployeesFormFactory $employeesFactory,
                                Forms\OrganisationClientsFormFactory $clientFactory,
                                Forms\OrganisationSponsorsFormFactory $sponsorFactory) {
            $this->dbHandler = $dbHandler;
            $this->organisationFactory = $organisationFactory;
            $this->employeesFactory = $employeesFactory;
            $this->clientFactory = $clientFactory;
            $this->sponsorFactory = $sponsorFactory;
        
    }

    /**
     * Render Default
     */
    public function renderDefault(): void {

        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage('Musíte se přihlásit!');
            $this->redirect('Sign:in');
        }

        $this->template->organisations = $this->dbHandler->getOrganisations();

    }
    
    /**
     * Render Edit
     * @param type $id
     */
    public function renderEdit($id): void {

        $this->template->organisation = $this->dbHandler->getOrganisations()->get($id);
        $this->template->employees = $this->dbHandler->getOrganisationEmployees()->where('organisation_id ?', $id);
        $this->template->clients = $this->dbHandler->getOrganisationClients()->where('organisation_id ?', $id);
        $this->template->sponsors = $this->dbHandler->getOrganisationSponsors()->where('organisation_id ?', $id);

    }
    
    /**
     * Organisation form factory.
     */
    protected function createComponentOrganisationForm(): Form {
        
        return $this->organisationFactory->create($this->organisationId, function (): void {
                    $this->restoreRequest($this->backlink);
                    $this->redirect('Organisation:default');
                });
    }
    
    /**
     * Employees form factory.
     */
    protected function createComponentEmployeesForm(): Form {
        return $this->employeesFactory->create($this->organisationId, $this->employeeId,  function (): void {
                    $this->restoreRequest($this->backlink);
                    $this->redirect('Organisation:edit?id=' . $this->organisationId);
                });
    }
    
    /**
     * Clients form factory.
     */
    protected function createComponentClientsForm(): Form {
        return $this->clientFactory->create($this->organisationId, $this->clientId,  function (): void {
                    $this->restoreRequest($this->backlink);
                    $this->redirect('Organisation:edit?id=' . $this->organisationId);
                });
    }
    
    /**
     * Sponsors form factory.
     */
    protected function createComponentSponsorsForm(): Form {
        return $this->sponsorFactory->create($this->organisationId, $this->sponsorId,  function (): void {
                    $this->restoreRequest($this->backlink);
                    $this->redirect('Organisation:edit?id=' . $this->organisationId);
                });
    }
    
    /**
     * Edit organisation
     * @param type $id
     */
    public function actionEdit($id): void {
        
        $this->organisationId = $id;
        
        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage('Musíte se přihlásit!');
            $this->redirect('Sign:in');
        }

        $editOrganisation = $this->dbHandler->getOrganisations()->get($id);
        $this->editOrganisation = $editOrganisation;

        if (!$editOrganisation) {

            $this->error('Organizace nebyla nalezena');
        }

        $this['organisationForm']->setDefaults($editOrganisation->toArray());
        
        $this->template->organisation = $this->dbHandler->getOrganisations()->get($id);

    }
    
    /**
     * Delete organisation
     * @param type $id
     */
    public function actionDelete($id): void {
        
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }

        $deleteOrganisation = $this->dbHandler->getOrganisations()->get($id);

        if (!$deleteOrganisation) {
            $this->error('Organizace nebyla nalezena');
        }
        // delete folder (files)
        $deleteDir = FileSystem::delete('./organisations/' . $id);
        
        // delete image url from db
        $delete = $deleteOrganisation->delete();
        
        if ($delete) {
            $this->flashMessage('Organizace byla smazána!', 'success');
            $this->redirect('Organisation:default');
        } else {
            $this->flashMessage('CHYBA: Organizace nebyla smazána!', 'danger');
            $this->redirect('Organisation:default');
        }
    }
    
    /**
     * Edit client
     * @param type $id
     */
    public function actionEditClient($organisationId, $clientId): void {
        
        $this->organisationId = $organisationId;
        $this->clientId = $clientId;
        
        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage('Musíte se přihlásit!');
            $this->redirect('Sign:in');
        }

        $editClient = $this->dbHandler->getOrganisationClients()->get($clientId);
        $this->editOrganisation = $editClient;

        if (!$editClient) {

            $this->error('Klient nebyl nalezen');
        }

        $this['clientsForm']->setDefaults($editClient->toArray());
        
        $this->template->client = $this->dbHandler->getOrganisationClients()->get($clientId);

    }
    
    /**
     * Delete client
     * @param type $id
     */
    public function actionDeleteClient($id): void {
        
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }

        $deleteClient = $this->dbHandler->getOrganisationClients()->get($id);

        if (!$deleteClient) {
            $this->error('Klient nebyl nalezena');
        }
        // delete image file
        if ($deleteClient->image_url) {
            $deleteDir = FileSystem::delete('.' . $deleteClient->image_url);
        }
        
        // delete image url from db
        $delete = $deleteClient->delete();
        
        if ($delete) {
            $this->flashMessage('Klient byl smazán!', 'success');
            $this->redirect('Organisation:edit?id=' . $deleteClient->organisation_id);
        } else {
            $this->flashMessage('CHYBA: Klient nebyl smazán!', 'danger');
            $this->redirect('Organisation:edit?id=' . $deleteClient->organisation_id);
        }
    }
    
    /**
     * Edit sponsor
     * @param type $id
     */
    public function actionEditSponsor($organisationId, $sponsorId): void {
        
        $this->organisationId = $organisationId;
        $this->sponsorId = $sponsorId;
        
        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage('Musíte se přihlásit!');
            $this->redirect('Sign:in');
        }

        $editSponsor = $this->dbHandler->getOrganisationSponsors()->get($sponsorId);
        $this->editOrganisation = $editSponsor;

        if (!$editSponsor) {

            $this->error('Sponzor nebyl nalezen');
        }

        $this['sponsorsForm']->setDefaults($editSponsor->toArray());
        
        $this->template->sponsor = $this->dbHandler->getOrganisationSponsors()->get($sponsorId);

    }
    
    /**
     * Delete organisation
     * @param type $id
     */
    public function actionDeleteSponsor($id): void {
        
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }

        $deleteSponsor = $this->dbHandler->getOrganisationSponsors()->get($id);

        if (!$deleteSponsor) {
            $this->error('Sponzor nebyla nalezena');
        }
        // delete image file
        if ($deleteClient->image_url) {
            $deleteDir = FileSystem::delete('.' . $deleteSponsor->image_url);
        }
        // delete image url from db
        $delete = $deleteSponsor->delete();
        
        if ($delete) {
            $this->flashMessage('Sponzor byl smazán!', 'success');
            $this->redirect('Organisation:edit?id=' . $deleteSponsor->organisation_id);
        } else {
            $this->flashMessage('CHYBA: Sponzor nebyl smazán!', 'danger');
            $this->redirect('Organisation:edit?id=' . $deleteSponsor->organisation_id);
        }
    }
    
}
