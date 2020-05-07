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

final class SectionFormFactory {

    use Nette\SmartObject;

    /** @var App\Forms\FormFactory */
    private $factory;

    /** @var App\Model\ContentManager */
    private $contentManager;
    
    /** @var App\Model\DbHandler */
    private $dbHandler;
    
    /** @var Nette\Security\User */
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

    public function create($sectionId, callable $onSuccess): Form {

        $section_names = array(
            'univ' => 'Universalní',
            'about' => 'O nás',
            'team' => 'Náš tým'
        );

        $section_width = array(
            '1' => '1/12',
            '2' => '2/12',
            '3' => '3/12',
            '4' => '4/12',
            '5' => '5/12',
            '6' => '6/12',
            '7' => '7/12',
            '8' => '8/12',
            '9' => '9/12',
            '10' => '10/12',
            '11' => '11/12',
            '12' => '12/12'
        );

        $section_columns = array(
            '12' => '1 detail',
            '6' => '2 detaily',
            '4' => '3 detaily',
            '3' => '4 detaily',
            '2' => '6 detailů'
        );


        $form = $this->factory->create();

        $form = new Form;

        // Set form labels
        $form->addText('section_title', 'Nadpis')
                ->setHtmlAttribute('class', 'form-control');

        $form->addTextarea('section_content', 'Obsah')
                ->setAttribute('rows', 20)
                ->setHtmlAttribute('class', 'form-control');

        $form->addSelect('section_type', '* Typ', $section_names)
                ->setRequired('Vyplňte Nadpis')
                ->setDefaultValue('univ')
                ->setHtmlAttribute('class', 'form-control');

        $form->addSelect('section_width', '* Šířka oddílu', $section_width)
                ->setOption('description', 'Určuje šířku oddílu na hlavní stránce (1/12 = 8%; 12/12 = 100%).')
                ->setRequired('Vyplňte Šířku')
                ->setDefaultValue(12)
                ->setHtmlAttribute('class', 'form-control');

        $form->addSelect('section_columns', '* Počet detailů v jednom řádku', $section_columns)
                ->setOption('description', 'Určuje počet detailů na jednom řádku.')
                ->setRequired('Vyplňte Počet detailů v jednom řádku')
                ->setDefaultValue(3)
                ->setHtmlAttribute('class', 'form-control');

        $form->addText('section_priority', '* Pořadí / priorita')
                ->setOption('description', 'Určuje pořadí oddílu na hlavní stránce.')
                ->setDefaultValue($this->dbHandler->getSections()->max('section_priority') + 1)
                ->setRequired('Vyplňte Nadpis')
                ->setHtmlAttribute('class', 'form-control');

        // set dafault number of samples
        $copies = 1;

        // set maximum samples
        $maxCopies = 1;

        $multiplier = $form->addMultiplier('formImages', function (Container $container, Form $form) {

            $container->addUpload('image', 'Obrázek: ')
                    ->setHtmlAttribute('class', 'form-control')
                    ->addRule(Form::IMAGE, 'Musí být JPEG, PNG nebo GIF.')
                    ->addRule(Form::MAX_FILE_SIZE, 'Maximální velikost souboru je 5 MB.', 5000 * 1024);
        }, $copies, $maxCopies);

        $form->addSubmit('send', 'Uložit')
                ->setHtmlAttribute('class', 'btn btn-primary col-lg-12');

        $form->onSuccess[] = function (Form $form, \stdClass $values) use ($sectionId, $onSuccess): void {

            if (!$sectionId) {

                // Add
                $this->contentManager->add($this->user, $values);
            } else {

                // Edit
                $this->contentManager->edit($this->user, $sectionId, $values);
            }

            $onSuccess();
        };
        return $form;
    }
}