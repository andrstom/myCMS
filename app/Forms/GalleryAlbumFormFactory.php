<?php

declare(strict_types = 1);

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;
use Nette\Forms\Container;
use App\Model\GalleryManager;

final class GalleryAlbumFormFactory {

    use Nette\SmartObject;

    /** @var App\Forms\FormFactory */
    private $factory;

    /** @var Nette\Security\User */
    private $user;

    /** @var App\Model\GalleryManager */
    private $galleryManager;


    public function __construct(FormFactory $factory,
                                User $user,
                                GalleryManager $galleryManager) {
        $this->factory = $factory;
        $this->user = $user;
        $this->galleryManager = $galleryManager;
    }

    /**
     * Create form
     * @param type $albumId
     * @param \App\Forms\callable $onSuccess
     * @return Form
     */
    public function create($albumId, callable $onSuccess): Form {
        
        $form = $this->factory->create();
        
        $form->addText('name', 'Název')
                ->setRequired('Vyplňte Název');

        $form->addSubmit('send', 'Uložit')
                ->setHtmlAttribute('class', 'col-lg-12');

        $form->onSuccess[] = function (Form $form, \stdClass $values) use ($albumId, $onSuccess): void {

            if (!$albumId) {
                // Add image category
                $this->galleryManager->addAlbum($this->user, $values);
            } else {
                // edit image category
                $this->galleryManager->editAlbum($this->user, $albumId, $values);
            }
            $onSuccess();
        };

        return $form;
    }

}
