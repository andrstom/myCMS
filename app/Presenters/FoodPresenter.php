<?php

declare(strict_types = 1);

namespace App\Presenters;

use Nette;
use Nette\Utils\FileSystem;
use App\Forms;
use Nette\Application\UI\Form;
use App\Model\DbHandler;


class FoodPresenter extends BasePresenter {
    
    /** @persistent */
    public $backlink = '';
    
    /** @var type int */
    private $alergenId;
    
    /** @var type int */
    private $foodId;

    /** @var type object */
    private $editAlergen;
    
    /** @var type object */
    private $editFood;
    
    /** @var App\Forms\AlergenFormFactory */
    private $alergenFactory;
    
    /** @var App\Forms\FoodFormFactory */
    private $foodFactory;
    
    /** @var App\Forms\FoodEditFormFactory */
    private $foodEditFactory;
    
    /** @var App\Model\DbHandler */
    public $dbHandler;
    
    
    public function __construct(DbHandler $dbHandler,
                                Forms\AlergenFormFactory $alergenFactory,
                                Forms\FoodFormFactory $foodFactory,
                                Forms\FoodEditFormFactory $foodEditFactory) {
            $this->dbHandler = $dbHandler;
            $this->alergenFactory = $alergenFactory;
            $this->foodFactory = $foodFactory;
            $this->foodEditFactory = $foodEditFactory;
    }


    /**
     * Default render
     * @param int $page
     */
    public function renderDefault(int $page = 1): void {

        $foods = $this->dbHandler->getFoods()->where('week >= ?', date('W', time()))->order('week ASC')->order('day ASC');

        // a do šablony pošleme pouze jejich část omezenou podle výpočtu metody page
        $lastPage = 0;
        $this->template->foods = $foods->page($page, 5, $lastPage);
        // a také potřebná data pro zobrazení možností stránkování
        $this->template->page = $page;
        $this->template->lastPage = $lastPage;
        
        $this->template->alergens = $this->dbHandler->getAlergens();

    }
    
    /**
     * Alergen form factory.
     */
    protected function createComponentAlergenForm(): Form {
        return $this->alergenFactory->create($this->alergenId, function (): void {
                    $this->restoreRequest($this->backlink);
                    $this->redirect('Food:default');
                });
    }
    
    /**
     * Food form factory.
     */
    protected function createComponentFoodForm(): Form {
        return $this->foodFactory->create($this->foodId,  function (): void {
                    $this->restoreRequest($this->backlink);
                    $this->redirect('Food:default');
                });
    }
    
    /**
     * Edit Food form factory.
     */
    protected function createComponentFoodEditForm(): Form {
        return $this->foodEditFactory->create($this->foodId,  function (): void {
                    $this->restoreRequest($this->backlink);
                    $this->redirect('Food:default');
                });
    }

    /**
     * Edit food
     * @param type $foodId
     */
    public function actionEditFood($foodId): void {
        
        $this->foodId = $foodId;
        
        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage('Musíte se přihlásit!');
            $this->redirect('Sign:in');
        }

        $editFood = $this->dbHandler->getFoods()->get($foodId);
        $this->editFood = $editFood;

        if (!$editFood) {

            $this->error('Denní nabídka nebyla nalezena!');
        }
        
        $day = date('Y-m-d', strtotime($editFood['day']->__toString()));
        
        
        // set default values into checkbox
        $this['foodEditForm']->setDefaults(['day' => $day]);
        
        if(!empty($editFood['breakfast_alergens'])) {
            $this['foodEditForm']->setDefaults(['breakfast_alergens' => explode(', ', $editFood['breakfast_alergens'])]);
        }
        
        if(!empty($editFood['soup_alergens'])) {
            $this['foodEditForm']->setDefaults(['soup_alergens' => explode(', ', $editFood['soup_alergens'])]);
        }
        
        if(!empty($editFood['main_course_alergens'])) {
            $this['foodEditForm']->setDefaults(['main_course_alergens' => explode(', ', $editFood['main_course_alergens'])]);
        }
        
        if(!empty($editFood['snack_alergens'])) {
            $this['foodEditForm']->setDefaults(['snack_alergens' => explode(', ', $editFood['snack_alergens'])]);
        }
        
        $formdata = $editFood->toArray();
        unset($formdata['day']);
        unset($formdata['breakfast_alergens']);
        unset($formdata['soup_alergens']);
        unset($formdata['main_course_alergens']);
        unset($formdata['snack_alergens']);
        
        // set default values into inputs (not for alergens)
        $this['foodEditForm']->setDefaults($formdata);


        $this->template->alergens = $this->dbHandler->getAlergens();
    }
    
    /**
     * Delete food
     * @param type $foodId
     */
    public function actionDeleteFood($foodId): void {
        
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }

        $deleteFood = $this->dbHandler->getFoods()->get($foodId);

        if (!$deleteFood) {
            $this->error('Denní nabídka nebyla nalezena!');
        }
        
        $delete = $deleteFood->delete();
        
        if ($delete) {
            $this->flashMessage('Denní nabídka byla smazána!', 'success');
            $this->redirect('Food:default');
        } else {
            $this->flashMessage('CHYBA: Denní nabídka nebyla smazána!', 'danger');
            $this->redirect('Food:default');
        }
    }
    
    /**
     * Edit food alergen
     * @param type $alergenId
     */
    public function actionEditAlergen($alergenId): void {
        
        $this->alergenId = $alergenId;
        
        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage('Musíte se přihlásit!');
            $this->redirect('Sign:in');
        }

        $editAlergen = $this->dbHandler->getAlergens()->get($alergenId);
        $this->editAlergen = $editAlergen;

        if (!$editAlergen) {

            $this->error('Denní nabídka nebyla nalezena!');
        }

        $this['alergenForm']->setDefaults($editAlergen->toArray());
        
    }
    
    /**
     * Delete food alergen
     * @param type $alergenId
     */
    public function actionDeleteAlergen($alergenId): void {
        
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }

        $deleteAlergen = $this->dbHandler->getAlergens()->get($alergenId);

        if (!$deleteAlergen) {
            $this->error('Alergen nebyl nalezen!');
        }
        
        // delete alergen image
        $deleteDir = FileSystem::delete('.' . $deleteAlergen->image_url);
        
        // delete image url from db
        $delete = $deleteAlergen->delete();
        
        if ($delete) {
            $this->flashMessage('Alergen byla smazán!', 'success');
            $this->redirect('Food:default');
        } else {
            $this->flashMessage('CHYBA: Alergen nebyl smazán!', 'danger');
            $this->redirect('Food:default');
        }
    }
    
}