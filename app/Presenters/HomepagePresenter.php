<?php

declare(strict_types = 1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\Forms;
use App\Model\ArticlesManager;
use App\Model\DbHandler;

final class HomepagePresenter extends BasePresenter {

    /** @persistent */
    public $backlink = '';
    
    /** @var App\Model\ArticlesManager */
    private $articlesManager;
    
    /** @var App\Forms\NewsletterFormFactory */
    private $newsletterFactory;
    
    /** @var App\Model\DbHandler */
    private $dbHandler;
    
    public function __construct(ArticlesManager $articlesManager,
                                DbHandler $dbHandler,
                                Forms\NewsletterFormFactory $newsletterFactory) {
            $this->articlesManager = $articlesManager;
            $this->dbHandler = $dbHandler;
            $this->newsletterFactory = $newsletterFactory;
    }

    public function renderDefault(int $page = 1): void {

        // load articles
        $articles = $this->articlesManager->getArticles();
        
        // a do šablony pošleme pouze jejich část omezenou podle výpočtu metody page
        $lastPage = 0;
        $this->template->articles = $articles->page($page, 6, $lastPage);
        // a také potřebná data pro zobrazení možností stránkování
        $this->template->page = $page;
        $this->template->lastPage = $lastPage;
        
        // load images
        $this->template->images = $this->dbHandler->getImages()->order('created_at')->group('name');
        
        // load organisation
        $this->template->organisation = $this->dbHandler->getOrganisations()->get(1);
        
        // load organisation
        $this->template->sections = $this->dbHandler->getSections();
        
        // load section "about"
        $this->template->sectionsAbout = $this->dbHandler->getSections()->where('section_type', 'about')->order('section_priority ASC');
        
        // load section "univ"
        $this->template->sectionsUniv = $this->dbHandler->getSections()->where('section_type', 'univ')->order('section_priority ASC');

        // load image categories
        $this->template->imageAlbums = $this->dbHandler->getImageAlbum()->order('name ASC');
        
        // load sponzors
        $this->template->sponsors = $this->dbHandler->getOrganisationSponsors();
        
        // load clients
        $this->template->clients = $this->dbHandler->getOrganisationClients();
    }
    
    /**
     * Newsletter form factory.
     */
    protected function createComponentNewsletterForm(): Form {
        return $this->newsletterFactory->create(function (): void {
                    $this->restoreRequest($this->backlink);
                    $this->flashMessage('Skvělé, Váš email jsme zaregistrovali. Aktivujte ho pomocí odkazu, který jsem Vám právě odeslali do emailu. Děkujeme.', 'success');
                    $this->redirect('Homepage:default');
                });
    }
}
