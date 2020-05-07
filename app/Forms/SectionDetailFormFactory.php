<?php

declare(strict_types = 1);

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;
use Nette\Forms\Container;
use App\Model;
use App\Model\ContentManager;
use App\Model\DbHandler;

final class SectionDetailFormFactory {

    use Nette\SmartObject;

    /** @var FormFactory */
    private $factory;

    /** @var App\Model\ContentManager */
    private $contentManager;
    
    /** @var App\Model\DbHandler */
    private $dbHandler;
    
    /** @var type Nette\Security\User */
    private $user;

    public function __construct(FormFactory $factory,
                                ContentManager $contentManager,
                                User $user,
                                DbHandler $dbHandler) {
        $this->factory = $factory;
        $this->contentManager = $contentManager;
        $this->user = $user;
        $this->dbHandler = $dbHandler;
    }

    public function create($sectionId, $sectionDetailId, callable $onSuccess): Form {

        $form = $this->factory->create();

        $form = new Form;

        // Set form labels
        $form->addText('detail_title', 'Nadpis')
                ->setHtmlAttribute('class', 'form-control');

        $form->addTextarea('detail_content', 'Obsah')
                ->setAttribute('rows', 10)
                ->setHtmlAttribute('class', 'form-control');

        // set dafault number of samples
        $copies = 1;

        // set maximum samples
        $maxCopies = 1;

        $multiplier = $form->addMultiplier('formImages', function (Container $container, Form $form) {

            $container->addUpload('image', 'Obrázek')
                    ->setHtmlAttribute('class', 'form-control')
                    ->addRule(Form::IMAGE, 'Musí být JPEG, PNG nebo GIF.')
                    ->addRule(Form::MAX_FILE_SIZE, 'Maximální velikost souboru je 5 MB.', 5000 * 1024);
        }, $copies, $maxCopies);

        $form->addSubmit('send', 'Uložit')
                ->setHtmlAttribute('class', 'btn btn-primary col-lg-12');

        $form->onSuccess[] = function (Form $form, \stdClass $values) use ($sectionId, $sectionDetailId, $onSuccess): void {

            if (!$sectionDetailId) {

                // Add
                $this->contentManager->addDetail($this->user, $sectionId, $values);
            } else {

                // Edit
                $this->contentManager->editDetail($this->user, $sectionId, $sectionDetailId, $values);
            }

            $onSuccess();
        };
        return $form;
    }
}