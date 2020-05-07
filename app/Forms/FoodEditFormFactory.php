<?php

declare(strict_types = 1);

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;
use App\Model;
use App\Model\FoodManager;
use App\Model\DbHandler;

final class FoodEditFormFactory {

    use Nette\SmartObject;

    /** @var FormFactory */
    private $factory;

    /** @var Model\FoodManager */
    private $foodManager;
    
    /** @var Model\DbHandler */
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

        $alergens = $this->dbHandler->getAlergens()->fetchPairs('short_name', 'long_name');

        $form->addText('day', 'Datum')
                ->setType('date')
                ->setRequired('Vyplnit datum')
                ->setHtmlAttribute('class', 'form-control');

        $form->addText('breakfast', 'Snídaně')
                ->setHtmlAttribute('class', 'form-control');

        $form->addCheckboxList('breakfast_alergens', 'Alergeny', $alergens);

        $form->addText('soup', 'Polévka')
                ->setHtmlAttribute('class', 'form-control');

        $form->addCheckboxList('soup_alergens', 'Alergeny', $alergens);

        $form->addText('main_course', 'Hlavní chod')
                ->setHtmlAttribute('class', 'form-control');

        $form->addCheckboxList('main_course_alergens', 'Alergeny', $alergens);

        $form->addText('snack', 'Svačinka')
                ->setHtmlAttribute('class', 'form-control');

        $form->addCheckboxList('snack_alergens', 'Alergeny', $alergens);

        
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
