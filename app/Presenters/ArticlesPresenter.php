<?php

declare(strict_types = 1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\Forms;
use App\Model\DbHandler;
use App\Model\ArticlesManager;

final class ArticlesPresenter extends BasePresenter {

    /** @persistent */
    public $backlink = '';
    
    /** var type object */
    public $editArticle;
    
    /** var type int */
    public $articleId;
    
    /** @var App\Model\DbHandler */
    public $dbHandler;
    
    /** @var App\Forms\ArticlesFormFactory */
    private $articlesFactory;
    
    /** @var App\Model\ArticlesManager */
    private $articlesManager;
    
    public function __construct(Forms\ArticlesFormFactory $articlesFactory,
                                DbHandler $dbHandler,
                                ArticlesManager $articlesManager) {
            $this->articlesFactory = $articlesFactory;
            $this->dbHandler = $dbHandler;
            $this->articlesManager = $articlesManager;
    }
    
    
    public function renderDefault(int $page = 1): void {

            // load articles
            $articles = $this->articlesManager->getArticles();

            // select articles into tamplate by paginator parameters
            $lastPage = 0;
            $this->template->articles = $articles->page($page, 6, $lastPage);

            /*
             * paginator values
             * actutal page
             * $page = actual page
             * $lastPage = last page
             */ 
            $this->template->page = $page;
            $this->template->lastPage = $lastPage;

            // load organisation
            $this->template->organisation = $this->dbHandler->getOrganisations()->get(1);
            
            // load images
            $this->template->images = $this->dbHandler->getImages();

            // load files
            $this->template->files = $this->dbHandler->getFiles();
    }
    
    /**
     * @param type $id
     */
    public function renderShow($id): void {

            $this->template->article = $this->articlesManager->getArticles()->get($id);
            $this->template->organisation = $this->dbHandler->getOrganisations()->get(1);
            $this->template->images = $this->dbHandler->getImages();
            $this->template->files = $this->dbHandler->getFiles();
    }
    
    
    /**
     * Articles form factory.
     */
    protected function createComponentArticlesForm(): Form {
            return $this->articlesFactory->create($this->articleId, function (): void {
                    $this->restoreRequest($this->backlink);
                    $this->flashMessage('Článek byl uložen.', 'success');
                    $this->redirect('Articles:default');
                });
    }

    public function actionEditArticle($id): void {
        
            $this->articleId = $id;

            if (!$this->getUser()->isLoggedIn()) {
                $this->flashMessage('Musíte se přihlásit!');
                $this->redirect('Sign:in');
            }

            $editArticle = $this->dbHandler->getArticles()->get($id);
            $this->editArticle = $editArticle;

            if (!$editArticle) {

                $this->error('Článek nebyl nalezen');
            }

            $this['articlesForm']->setDefaults($editArticle->toArray());

            $this->template->article = $this->articlesManager->getArticles()->get($id);
            $this->template->images = $this->dbHandler->getImages();
    }
    
    /**
     * Delete article
     * @param type $id
     */
    public function actionDeleteArticle($id): void {
        
            if (!$this->getUser()->isLoggedIn()) {
                $this->redirect('Sign:in');
            }

            $deleteArticle = $this->dbHandler->getArticles()->get($id);
            if (!$deleteArticle) {
                $this->error('Článek nebyl nalezen');
            }

            $delete = $deleteArticle->delete();
            if ($delete) {
                $this->flashMessage('Článek byl smazán!', 'success');
                $this->redirect('Homepage:default');
            } else {
                $this->flashMessage('CHYBA: článek nebyl smazán!', 'danger');
                $this->redirect('Homepage:default');
            }
    }
    
    /**
     * Email confirmation
     * @param type $token
     */
    public function actionNewsletterEmailConfirmation($token): void {

            $confirmEmail = $this->dbHandler->getNewsletter()->where('token ?', $token)->fetch();

            if (!$confirmEmail) {
                $this->error('Email nelze ověřit - neexistuje!');
            }

            $confirm = $confirmEmail->update(['confirmed' => 'ANO']);
            if ($confirm) {
                $this->flashMessage('Ověření emailu proběhlo úspěšně!', 'success');
                $this->redirect('Homepage:default');
            } else {
                $this->flashMessage('CHYBA: Ověření emailu nebylo úspěšné!', 'danger');
                $this->redirect('Homepage:default');
            }
    }
    
    /**
     * Unsubscribe email
     * @param type $email
     */
    public function actionUnsubscribe($email): void {

            $deleteEmail = $this->dbHandler->getNewsletter()->where('email ?', $email)->fetch();

            if (!$deleteEmail) {
                $this->error('Email nebyl nalezen');
            }

            $delete = $deleteEmail->delete();
            if ($delete) {
                $this->flashMessage('Email byl odstraněn z odběru aktualit!', 'success');
                $this->redirect('Homepage:default');
            } else {
                $this->flashMessage('CHYBA: Email nebyl odstraněn z odběru aktualit!', 'danger');
                $this->redirect('Homepage:default');
            }
    }
}
