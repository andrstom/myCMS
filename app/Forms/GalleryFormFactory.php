<?php

declare(strict_types = 1);

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;
use Nette\Forms\Container;
use App\Model\GalleryManager;
use App\Model\DbHandler;

final class GalleryFormFactory {

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
    public function create(callable $onSuccess): Form {
        
        $form = $this->factory->create();
        
        // set dafault number of samples
        $copies = 1;

        // set maximum samples
        $maxCopies = 50;

        $multiplier = $form->addMultiplier('formImages', function (Container $container, Form $form) {

            $container->addUpload('image', 'Obrázek')
                    ->setHtmlAttribute('class', 'col-lg-12')
                    ->addRule(Form::MAX_FILE_SIZE, 'Maximální velikost souboru je 5 MB.', 5000 * 1024);

            $container->addText('description', 'Popis obrázku')
                    ->setHtmlAttribute('class', 'col-lg-12');
            
            $container->addSelect('album_id', 'Album:', $this->dbHandler->getImageAlbum()->fetchPairs('id', 'name'));

        }, $copies, $maxCopies);

        $multiplier->addCreateButton('Přidat')
                ->setValidationScope([])
                ->addClass('col-lg-3');
        $multiplier->addCreateButton('Přidat (5x)', 5)
                ->setValidationScope([])
                ->addClass('col-lg-3');
        $multiplier->addRemoveButton('X')
                ->addClass('col-lg-3 btn btn-danger');
        
        $form->addSubmit('send', 'Uložit')
                ->setHtmlAttribute('class', 'col-lg-12');

        $form->onSuccess[] = function (Form $form, \stdClass $values) use ($onSuccess): void {

            // Add image
            $this->galleryManager->addImage($this->user, $values);

            $onSuccess();
        };

        return $form;
    }

}
