<?php

declare(strict_types = 1);

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;
use Nette\Forms\Container;
use App\Model;
use App\Model\EmployeesManager;
use App\Model\DbHandler;

final class EmployeesFormFactory {

    use Nette\SmartObject;

    /** @var FormFactory */
    private $factory;

    /** @var App\Model\EmployeesManager */
    private $employeesManager;
    
    /** @var App\Model\DbHandler */
    private $dbHandler;
    
    private $user;

    public function __construct(FormFactory $factory,
                                EmployeesManager $employeesManager,
                                User $user,
                                DbHandler $dbHandler) {
        $this->factory = $factory;
        $this->employeesManager = $employeesManager;
        $this->user = $user;
        $this->dbHandler = $dbHandler;
    }

    public function create($organisationId, $employeeId, callable $onSuccess): Form {

        $form = $this->factory->create();

        $form = new Form;

        // Set form labels
        $form->addText('firstname', '* Jméno')
                ->setRequired('Vyplňte Jméno')
                ->setHtmlAttribute('class', 'form-control');
        
        $form->addText('lastname', '* Příjmení')
                ->setRequired('Vyplňte Příjmení')
                ->setHtmlAttribute('class', 'form-control');
        
        $form->addText('position', '* Pozice')
                ->setRequired('Vyplňte Pozici')
                ->setHtmlAttribute('class', 'form-control');
        
        $form->addText('email', 'Email')
                ->setHtmlType('email')
                ->addRule(Form::EMAIL, 'Neplatná emailová adresa')
                ->setHtmlAttribute('class', 'form-control');
        
        $form->addText('gsm', 'Telefon')
                ->setHtmlAttribute('class', 'form-control');
        
        // set dafault number of samples
        $copies = 1;

        // set maximum samples
        $maxCopies = 1;

        $multiplier = $form->addMultiplier('formImages', function (Container $container, Form $form) {

            $container->addUpload('image', 'Fotka parťáka (přípona jpg/JPG):')
                    ->setHtmlAttribute('class', 'form-control')
                    ->addRule(Form::IMAGE, 'Musí být JPEG, PNG nebo GIF.')
                    ->addRule(Form::MAX_FILE_SIZE, 'Maximální velikost souboru je 5 MB.', 5000 * 1024);

        }, $copies, $maxCopies);

        
        $form->addSubmit('send', 'Uložit')
                ->setHtmlAttribute('class', 'btn btn-primary col-lg-12');
        
        $form->onSuccess[] = function (Form $form, \stdClass $values) use ($organisationId, $employeeId, $onSuccess): void {

            if(!$employeeId) {
                
                // Add
                $this->employeesManager->addEmployee($this->user, $organisationId, $values);
                
            } else {
                
                // Edit
                $this->employeesManager->editEmployee($this->user, $organisationId, $employeeId, $values);
                
            }

            $onSuccess();
        };
        return $form;
    }

}
