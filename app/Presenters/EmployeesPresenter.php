<?php

declare(strict_types = 1);

namespace App\Presenters;

use Nette;
use Nette\Utils\FileSystem;
use Nette\Application\UI\Form;
use App\Forms;
use App\Model\DbHandler;


class EmployeesPresenter extends BasePresenter {
    
    /** @persistent */
    public $backlink = '';
    
    /** @var type int */
    private $organisationId;
    
    /** @var type int */
    private $employeeId;
    
    /** @var type object */
    private $editEmployee;
    
    /** @var App\Model\DbHandler */
    public $dbHandler;
    
    /** @var App\Forms\EmployeesFormFactory */
    private $employeesFactory;
    
    public function __construct(DbHandler $dbHandler,
                                Forms\EmployeesFormFactory $employeesFactory) {
        $this->dbHandler = $dbHandler;
        $this->employeesFactory = $employeesFactory;
    }

    public function renderDefault(): void {

        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage('Musíte se přihlásit!');
            $this->redirect('Sign:in');
        }

        $this->template->employees = $this->dbHandler->getOrganisationEmployees();
        $this->template->organisations = $this->dbHandler->getOrganisations();
    }
    
    public function renderEdit($organisationId, $employeeId): void {
        
        $this->template->organisation = $this->dbHandler->getOrganisations()->get($organisationId);
        $this->template->employee = $this->dbHandler->getOrganisationEmployees()->get($employeeId);

    }
    

    /**
     * Employees form factory.
     */
    protected function createComponentEmployeesForm(): Form {
        return $this->employeesFactory->create($this->organisationId, $this->employeeId,  function (): void {
                    $this->restoreRequest($this->backlink);
                    $this->flashMessage('Změna byla úspěžná!', 'success');
                    $this->redirect('Organisation:edit?id=' . $this->organisationId);
                });
    }
    
    /**
     * Edit Employee
     * @param type $id
     */
    public function actionEdit($organisationId, $employeeId): void {
        
        $this->organisationId = $organisationId;
        $this->employeeId = $employeeId;
        
        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage('Musíte se přihlásit!');
            $this->redirect('Sign:in');
        }

        $editEmployee = $this->dbHandler->getOrganisationEmployees()->get($employeeId);
        $this->editEmployee = $editEmployee;

        if (!$editEmployee) {

            $this->error('Tento parťák již neexistuje!');
        }

        $this['employeesForm']->setDefaults($editEmployee->toArray());
        
        $this->template->employee = $this->dbHandler->getOrganisationEmployees()->get($employeeId);

    }
    
    /**
     * Delete Employee
     * @param type $id
     */
    public function actionDelete($employeeId): void {
        
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }
        
        $deleteEmployee = $this->dbHandler->getOrganisationEmployees()->get($employeeId);

        if (!$deleteEmployee) {
            $this->error('Tento parťák nebyl nalezen.');
        }
        
        $delete = $deleteEmployee->delete();
        $deleteImage = FileSystem::delete('./organisations/' . $deleteEmployee->organisation_id . '/image_employee_' . $employeeId . '.jpg');
        $deleteImage = FileSystem::delete('./organisations/' . $deleteEmployee->organisation_id . '/image_employee_' . $employeeId . '.png');
        $deleteImage = FileSystem::delete('./organisations/' . $deleteEmployee->organisation_id . '/image_employee_' . $employeeId . '.gif');
        
        if ($delete) {
            $this->flashMessage('Parťák byl smazán!', 'success');
            $this->redirect('Organisation:edit?id=' . $deleteEmployee->organisation_id);
        } else {
            $this->flashMessage('CHYBA: Parťák nebyl smazán!', 'danger');
            $this->redirect('Organisation:edit?id=' . $deleteEmployee->organisation_id);
        }
    }
}
