<?php

declare(strict_types = 1);

namespace App\Presenters;

use Nette;
use Nette\Utils\FileSystem;
use Nette\Application\UI\Form;
use App\Forms;
use App\Model\DbHandler;


class ContentPresenter extends BasePresenter {
    
    /** @persistent */
    public $backlink = '';
    
    /** @var type int */
    private $sectionId;
    
    /** @var type int */
    private $sectionDetailId;
    
    /** @var type object */
    private $editSection;
    
    /** @var type object */
    private $editSectionDetail;
    
    /** @var App\Model\DbHandler */
    public $dbHandler;
    
    /** @var App\Forms\SectionFormFactory */
    private $sectionFactory;
    
    /** @var App\Forms\SectionDetailFormFactory */
    private $sectionDetailFactory;
    
    public function __construct(DbHandler $dbHandler,
                                Forms\SectionFormFactory $sectionFactory,
                                Forms\SectionDetailFormFactory $sectionDetailFactory) {
        $this->dbHandler = $dbHandler;
        $this->sectionFactory = $sectionFactory;
        $this->sectionDetailFactory = $sectionDetailFactory;
    }

    public function renderDefault(): void {

        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage('Musíte se přihlásit!');
            $this->redirect('Sign:in');
        }

        $this->template->sections = $this->dbHandler->getSections();
        $this->template->images = $this->dbHandler->getImages();
    }
    
    public function renderEdit($id): void {

        $this->template->sections = $this->dbHandler->getSections()->get($id);
        $this->template->sectionsDetails = $this->dbHandler->getSectionsDetails()->where('sections_id ?', $id);
    }
    
    public function renderEditDetail($sectionId, $sectionDetailId): void {

        $this->template->section = $this->dbHandler->getSections()->get($sectionId);
        $this->template->sectionDetail = $this->dbHandler->getSectionsDetails()->get($sectionDetailId);
    }
    
    /**
     * Section form factory.
     */
    protected function createComponentSectionForm(): Form {
        
        return $this->sectionFactory->create($this->sectionId, function (): void {
                    $this->restoreRequest($this->backlink);
                    $this->redirect('Content:');
                });
    }
    
    /**
     * Section detail form factory.
     */
    protected function createComponentSectionDetailForm(): Form {
        return $this->sectionDetailFactory->create($this->sectionId, $this->sectionDetailId,  function (): void {
                    $this->restoreRequest($this->backlink);
                    $this->redirect('Content:edit?id=' . $this->sectionId);
                });
    }
    
    /**
     * Edit section
     * @param type $id
     */
    public function actionEdit($id): void {
        
        $this->sectionId = $id;
        
        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage('Musíte se přihlásit!');
            $this->redirect('Sign:in');
        }

        $editSection = $this->dbHandler->getSections()->get($id);
        $this->editSection = $editSection;

        if (!$editSection) {

            $this->error('Oddíl nenalezen!');
        }

        $this['sectionForm']->setDefaults($editSection->toArray());
        
        $this->template->section = $this->dbHandler->getSections()->get($id);
        $this->template->sectionDetails = $this->dbHandler->getSectionsDetails()->where('sections_id ?', $id);
        $this->template->images = $this->dbHandler->getImages();
    }
    
    /**
     * Delete section
     * @param type $id
     */
    public function actionDelete($id): void {
        
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }

        $deleteSection = $this->dbHandler->getSections()->get($id);

        if (!$deleteSection) {
            $this->error('Oddíl nenalezen!');
        }
        
        // delete folder (files)
        $deleteDir = FileSystem::delete('./sections/' . $id);
        
        // delete from db
        $delete = $deleteSection->delete();
        
        if ($delete) {
            $this->flashMessage('Oddíl byl smazán!', 'success');
            $this->redirect('Content:default');
        } else {
            $this->flashMessage('CHYBA: Oddíl nebyl smazán!', 'danger');
            $this->redirect('Content:default');
        }
    }
    
    /**
     * Delete section logo
     * @param type $id
     */
    public function actionDeleteSectionLogo($id): void {
        
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }

        $deleteSectionLogo = $this->dbHandler->getSections()->get($id);
        if (!$deleteSectionLogo) {
            $this->error('Obrázek oddílu nenalezen!');
        }
        
        if ($deleteSectionLogo->section_image) {
            $deleteDir = FileSystem::delete('.' . $deleteSectionLogo->section_image);
        }
        
        // set empty value as default
        $delete = $deleteSectionLogo->update(['section_image' => '']);
        
        if ($delete) {
            $this->flashMessage('Obrázek oddílu byl smazán!', 'success');
            $this->redirect('Content:default');
        } else {
            $this->flashMessage('CHYBA: Obrázek oddílu nebyl smazán!', 'danger');
            $this->redirect('Content:default');
        }
    }
    
    /**
     * Edit section detail
     * @param type $id
     */
    public function actionEditDetail($sectionId, $sectionDetailId): void {
        
        $this->sectionId = $sectionId;
        $this->sectionDetailId = $sectionDetailId;
        
        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage('Musíte se přihlásit!');
            $this->redirect('Sign:in');
        }

        $editSectionDetail = $this->dbHandler->getSectionsDetails()->get($sectionDetailId);
        $this->editSectionDetail = $editSectionDetail;

        if (!$editSectionDetail) {

            $this->error('Detail nenalezen!');
        }

        $this['sectionDetailForm']->setDefaults($editSectionDetail->toArray());
        
        $this->template->section = $this->dbHandler->getSections()->get($sectionId);
        $this->template->sectionDetail = $this->dbHandler->getSectionsDetails()->get($sectionDetailId);
        $this->template->images = $this->dbHandler->getImages();
    }
    
    /**
     * Delete section detail
     * @param type $id
     */
    public function actionDeleteDetail($sectionId, $sectionDetailId): void {
        
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }

        $deleteSectionDetail = $this->dbHandler->getSectionsDetails()->get($sectionDetailId);

        if (!$deleteSectionDetail) {
            $this->error('Detail nebyl nalezen');
        }
        
        $delete = $deleteSectionDetail->delete();
        $deleteImageJpg = FileSystem::delete('./sections/' . $sectionId. '/image_detail_' . $sectionDetailId . '.jpg');
        $deleteImagePng = FileSystem::delete('./sections/' . $sectionId. '/image_detail_' . $sectionDetailId . '.png');
        $deleteImageGif = FileSystem::delete('./sections/' . $sectionId. '/image_detail_' . $sectionDetailId . '.gif');
        
        if ($delete) {
            $this->flashMessage('Detail byl smazán!', 'success');
            $this->redirect('Content:edit?id=' . $sectionId);
        } else {
            $this->flashMessage('CHYBA: Detail nebyl smazán!', 'danger');
            $this->redirect('Content:edit?id=' . $sectionId);
        }
    }
    
    
}
