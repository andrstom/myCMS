<?php

declare(strict_types = 1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Utils\FileSystem;
use App\Forms;
use App\Model\DbHandler;

final class GalleryPresenter extends BasePresenter {

    /** @persistent */
    public $backlink = '';
    
    /** @var type */
    private $albumId;
    
    /** @var type */
    private $imageId;
    
    /** @var type */
    private $edit;
    
    /** @var type */
    private $editImage;
    
    /** @var App\Model\DbHandler */
    private $dbHandler;
    
    /** @var App\Forms\GalleryFormFactory */
    private $galleryFactory;
    
    /** @var App\Forms\GalleryEditFormFactory */
    private $galleryEditFactory;
    
    /** @var App\Forms\GalleryAlbumFormFactory */
    private $galleryAlbumFactory;
    
    public function __construct(DbHandler $dbHandler,
                                Forms\GalleryFormFactory $galleryFactory,
                                Forms\GalleryEditFormFactory $galleryEditFactory,
                                Forms\GalleryAlbumFormFactory $galleryAlbumFactory) {
            $this->dbHandler = $dbHandler;
            $this->galleryFactory = $galleryFactory;
            $this->galleryEditFactory = $galleryEditFactory;
            $this->galleryAlbumFactory = $galleryAlbumFactory;
    }

    public function renderDefault(): void {

            // load images
            $this->template->images = $this->dbHandler->getImages()->order('created_at')->group('name');
            $this->template->imageAlbums = $this->dbHandler->getImageAlbum()->order('name ASC');

    }
    
    public function renderAddAlbum(): void {

            // load images
            $this->template->images = $this->dbHandler->getImages()->order('created_at')->group('name');
            $this->template->imageAlbums = $this->dbHandler->getImageAlbum()->order('name ASC');

    }
    
    /**
     * Gallery form factory.
     */
    protected function createComponentGalleryForm(): Form {
            return $this->galleryFactory->create(function (): void {
                    $this->restoreRequest($this->backlink);
                    $this->flashMessage('Uloženo.');
                    $this->redirect('Gallery:default');
                });
    }
    
    /**
     * Gallery edit form factory.
     */
    protected function createComponentGalleryEditForm(): Form {
            return $this->galleryEditFactory->create($this->imageId, function (): void {
                    $this->restoreRequest($this->backlink);
                    $this->flashMessage('Uloženo.');
                    $this->redirect('Gallery:default');
                });
    }
    
    /**
     * Gallery album form factory.
     */
    protected function createComponentGalleryAlbumForm(): Form {
            return $this->galleryAlbumFactory->create($this->albumId, function (): void {
                    $this->restoreRequest($this->backlink);
                    $this->flashMessage('Uloženo.');
                    $this->redirect('Gallery:addAlbum');
                });
    }
    
    /**
     * Edit album
     * @param type $id
     */
    public function actionEditAlbum($id): void {

            $this->albumId = $id;

            if (!$this->getUser()->isLoggedIn()) {
                $this->flashMessage('Musíte se přihlásit!');
                $this->redirect('Sign:in');
            }

            $edit = $this->dbHandler->getImageAlbum()->get($id);
            $this->edit = $edit;

            if (!$edit) {
                $this->error('Kategorie nebyla nalezena!');
            }

            $this['galleryAlbumForm']->setDefaults($edit->toArray());

            $this->template->galleryAlbums = $this->dbHandler->getImageAlbum()->get($id);
    }
    
    /**
     * Delete album
     * @param type $id
     */
    public function actionDeleteAlbum($id): void {

            if (!$this->getUser()->isLoggedIn()) {
                $this->redirect('Sign:in');
            }

            $deleteAlbum = $this->dbHandler->getImageAlbum()->get($id);
            if (!$deleteAlbum) {
                $this->error('Album nebyl nalezeno!');
            }

            // change category for exist images to default
            $images = $this->dbHandler->getImages();
            foreach ($images->where('album_id ?', $id) as $image) {
                $image->update(['album_id' => 1]);
            }

            // album with id = 1 is not possible to delete
            if ($id != 1) {
                $delete = $deleteAlbum->delete();
            }

            if ($delete) {
                $this->flashMessage('Album bylo odstraněno!', 'success');
                $this->redirect('Gallery:addAlbum');
            } else {
                $this->flashMessage('Album nelze odstranit!', 'danger');
                $this->redirect('Gallery:addAlbum');
            }
    }
    
    /**
     * Edit image
     * @param type $id
     */
    public function actionEditImage($id): void {
        
        $this->imageId = $id;
        
        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage('Musíte se přihlásit!');
            $this->redirect('Sign:in');
        }

        $editImage = $this->dbHandler->getImages()->get($id);
        $this->editImage = $editImage;

        if (!$editImage) {
            $this->error('Obrázek nebyl nalezen!');
        }

        $this['galleryEditForm']->setDefaults($editImage->toArray());
        
        $this->template->image = $this->dbHandler->getImages()->get($id);
    }
    
    /**
     * Delete image
     * @param type $id
     */
    public function actionDeleteImage($id): void {
        
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }

        $deleteImage = $this->dbHandler->getImages()->get($id);
        if (!$deleteImage) {
            
            $this->error('Obrázek nebyl nalezen!');
            
        }

        if(file_exists('.' . $deleteImage->url)){
           Filesystem::delete('.' . $deleteImage->url);
           Filesystem::delete('.' . $deleteImage->url_thumb);
        }

        $delete = $deleteImage->delete();
        if ($delete) {
            $this->flashMessage('Obrázek byl odstraněn!', 'success');
            $this->redirect('Gallery:default');
        } else {
            $this->flashMessage('CHYBA: Obrázek nelze odstranit!', 'danger');
            $this->redirect('Gallery:default');
        }
    }

}
