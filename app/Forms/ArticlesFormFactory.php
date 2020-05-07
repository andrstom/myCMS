<?php

declare(strict_types = 1);

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Forms\Container;
use Nette\Security\User;
use App\Model\ArticlesManager;
use App\Model\EmailManager;

final class ArticlesFormFactory {

    use Nette\SmartObject;

    /** @var FormFactory */
    private $factory;

    /** @var User */
    private $user;

    /** @var Nette\Database\Context */
    private $database;

    /** @var App\Model\ArticlesManager */
    private $articlesManager;

    /** @var App\Model\EmailManager */
    private $emailManager;

    public function __construct(Nette\Database\Context $database,
                                FormFactory $factory,
                                User $user,
                                ArticlesManager $articlesManager,
                                EmailManager $emailManager) {
        $this->database = $database;
        $this->factory = $factory;
        $this->user = $user;
        $this->articlesManager = $articlesManager;
        $this->emailManager = $emailManager;
    }

    /**
     * Create article form
     * @param type $article_id
     * @param \App\Forms\callable $onSuccess
     * @return Form
     */
    public function create($articleId, callable $onSuccess): Form {

        $form = $this->factory->create();

        $form->addText('title', 'Nadpis')
                ->setRequired('Vyplňte Nadpis');

        $form->addTextArea('content', 'Obsah')
                ->setAttribute('rows', 15);

        // set dafault number of samples
        $copies = 1;

        // set maximum samples
        $maxCopies = 50;

        $multiplier = $form->addMultiplier('formImages', function (Container $container, Form $form) {

            $container->addUpload('image', 'Obrázek:')
                    ->setHtmlAttribute('class', 'col-lg-12')
                    ->addRule(Form::MAX_FILE_SIZE, 'Maximální velikost souboru je 5 MB.', 5000 * 1024);

            $container->addText('description', 'Popis obrázku:')
                    ->setHtmlAttribute('class', 'col-lg-12');

            $container->addSelect('album_id', 'Kategorie:', $this->database->table('gallery_album')->fetchPairs('id', 'name'));
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

        $form->onSuccess[] = function (Form $form, \stdClass $values) use ($articleId, $onSuccess): void {


            if (!$articleId) {

                // Add article
                $this->articlesManager->add($this->user, $values);
            } else {

                // Edit article
                $this->articlesManager->edit($this->user, $values, $articleId);
            }
            $onSuccess();
        };

        return $form;
    }

}
