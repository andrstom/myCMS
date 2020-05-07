<?php

declare(strict_types = 1);

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;
use App\Model\GalleryManager;
use App\Model\DbHandler;

final class GalleryEditFormFactory {

    use Nette\SmartObject;

    /** @var FormFactory */
    private $factory;

    /** @var User */
    private $user;

    /** @var App\Model\DbHandler */
    private $dbHandler;
    
    /** @var App\Model\GalleryManager */
    private $galleryManager;

    
    public function __construct(DbHandler $dbHandler,
                                FormFactory $factory,
                                User $user,
                                GalleryManager $galleryManager) {
                $this->dbHandler = $dbHandler;
                $this->factory = $factory;
                $this->user = $user;
                $this->galleryManager = $galleryManager;
    }

    /**
     * Create form
     * @param \App\Forms\callable $onSuccess
     * @return Form
     */
    public function create($imageId, callable $onSuccess): Form {
        
        $form = $this->factory->create();
        
        $form->addText('description', 'Popis obrázku')
                    ->setHtmlAttribute('class', 'col-lg-12');
            
        $form->addSelect('album_id', 'Album', $this->dbHandler->getImageAlbum()->fetchPairs('id', 'name'));

        $form->addSubmit('send', 'Uložit')
                ->setHtmlAttribute('class', 'col-lg-12');

        $form->onSuccess[] = function (Form $form, \stdClass $values) use ($imageId, $onSuccess): void {

            // edit image
            $this->galleryManager->editImage($this->user, $values, $imageId);

            $onSuccess();
        };

        return $form;
    }

}
