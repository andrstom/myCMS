<?php

declare(strict_types = 1);

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;
use Nette\Forms\Container;
use App\Model;
use App\Model\FoodManager;
use App\Model\DbHandler;

final class FoodFormFactory {

    use Nette\SmartObject;

    /** @var FormFactory */
    private $factory;

    /** @var App\Model\FoodManager */
    private $foodManager;
    
    /** @var App\Model\DbHandler */
    private $dbHandler;
    
    private $user;

    public function __construct(FormFactory $factory,
                                FoodManager $foodManager,
                                User $user,
                                DbHandler $dbHandler) {
        $this->factory = $factory;
        $this->foodManager = $foodManager;
        $this->user = $user;
        $this->dbHandler = $dbHandler;
    }

    public function create($foodId, callable $onSuccess): Form {

        $form = $this->factory->create();

        $form = new Form;

        // set dafault number of samples
        $copies = 1;

        // set maximum samples
        $maxCopies = 20;

        $multiplier = $form->addMultiplier('formFoods', function (Container $container, Form $form) {
            
            $alergens = $this->dbHandler->getAlergens()->fetchPairs('short_name', 'long_name');
        
            $container->addText('day', 'Datum')
                    ->setType('date')
                    ->setRequired('Vyplnit datum')
                    ->setHtmlAttribute('class', 'form-control');

            $container->addText('breakfast', 'Snídaně')
                    ->setHtmlAttribute('class', 'form-control');

            $container->addCheckboxList('breakfast_alergens', 'Alergeny', $alergens);

            $container->addText('soup', 'Polévka')
                    ->setHtmlAttribute('class', 'form-control');

            $container->addCheckboxList('soup_alergens', 'Alergeny', $alergens);

            $container->addText('main_course', 'Hlavní chod')
                    ->setHtmlAttribute('class', 'form-control');

            $container->addCheckboxList('main_course_alergens', 'Alergeny', $alergens);

            $container->addText('snack', 'Svačinka')
                    ->setHtmlAttribute('class', 'form-control');

            $container->addCheckboxList('snack_alergens', 'Alergeny', $alergens);

        }, $copies, $maxCopies);
        
        $multiplier->addCreateButton('Přidat další den')
                ->setValidationScope([]);
        $multiplier->addCreateButton('Přidat 4 dny', 4)
                ->setValidationScope([]);
        $multiplier->addRemoveButton('Odebrat')
                ->addClass('col-lg-3 btn btn-danger');
        
        $form->addSubmit('send', 'Uložit')
                ->setHtmlAttribute('class', 'btn btn-primary col-lg-12');
        
        $form->onSuccess[] = function (Form $form, \stdClass $values) use ($foodId, $onSuccess): void {

            if(!$foodId) {
                
                // Add
                $this->foodManager->addFood($this->user, $values);
                
            } else {
                
                // Edit
                $this->foodManager->editFood($this->user, $foodId, $values);
                
            }

            $onSuccess();
        };
        return $form;
    }

}
