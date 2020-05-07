<?php

declare(strict_types = 1);

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;
use Nette\Forms\Container;
use App\Model;
use App\Model\FoodManager;
use App\Model\DbHandler;

final class AlergenFormFactory {

    use Nette\SmartObject;

    /** @var FormFactory */
    private $factory;

    /** @var App\Model\FoodManager */
    private $foodManager;

    /** @var App\Model\DbHandler */
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

    public function create($alergenId, callable $onSuccess): Form {

        $form = $this->factory->create();

        $form = new Form;

        $form->addText('short_name', '* Krátký název')
                ->setRequired('Vyplňte Krátký název')
                ->setHtmlAttribute('class', 'form-control');

        $form->addText('long_name', '* Dlouhý název')
                ->setRequired('Vyplňte Dlouhý název')
                ->setHtmlAttribute('class', 'form-control');

        $form->addTextArea('detail', 'Popis')
                ->setHtmlAttribute('class', 'form-control');

        // set dafault number of samples
        $copies = 1;

        // set maximum samples
        $maxCopies = 1;

        $multiplier = $form->addMultiplier('formImages', function (Container $container, Form $form) {

            $container->addUpload('image_url', 'Obrázek')
                    ->setHtmlAttribute('class', 'form-control')
                    ->addRule(Form::IMAGE, 'Musí být JPEG, PNG nebo GIF.')
                    ->addRule(Form::MAX_FILE_SIZE, 'Maximální velikost souboru je 5 MB.', 5000 * 1024);
        }, $copies, $maxCopies);

        $form->addSubmit('send', 'Uložit')
                ->setHtmlAttribute('class', 'btn btn-primary col-lg-12');

        $form->onSuccess[] = function (Form $form, \stdClass $values) use ($alergenId, $onSuccess): void {

            if (!$alergenId) {

                // Add
                $this->foodManager->addAlergen($this->user, $values);
            } else {

                // Edit
                $this->foodManager->editAlergen($this->user, $alergenId, $values);
            }

            $onSuccess();
        };
        return $form;
    }

}
