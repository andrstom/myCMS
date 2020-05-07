<?php

declare(strict_types = 1);

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Forms\Container;
use Nette\Security\User;
use App\Model;
use App\Model\ArticlesManager;
use App\Model\DbHandler;

final class NewsletterFormFactory {

    use Nette\SmartObject;

    /** @var App\Forms\FormFactory */
    private $factory;

    /** @var Nette\Security\User */
    private $user;

    /** @var App\Model\ArticlesManager */
    private $articlesManager;

    /** @var App\Model\DbHandler */
    private $dbHandler;

    public function __construct(FormFactory $factory,
                                User $user,
                                ArticlesManager $articlesManager,
                                DbHandler $dbHandler) {
        $this->factory = $factory;
        $this->user = $user;
        $this->articlesManager = $articlesManager;
        $this->dbHandler = $dbHandler;
    }

    /**
     * Create newsletter form
     * @param \App\Forms\callable $onSuccess
     * @return Form
     */
    public function create(callable $onSuccess): Form {

        $form = $this->factory->create();

        $form->addEmail('email', '')
                ->setAttribute('placeholder', '@')
                ->setRequired('Vyplňte email')
                ->addRule(function ($control) {
                    return !$this->dbHandler->getNewsletter()->where('email = ?', $control->value)->fetch();
                }, 'Jejda, email už je přihlášen!');

        $form->addSubmit('send', 'Chci odebírat aktuality')
                ->setAttribute('class', 'btn btn-theme');

        $form->onSuccess[] = function (Form $form, \stdClass $values) use ($onSuccess): void {

            try {
                // Add
                $this->articlesManager->newsletter($values);
            } catch (Model\UserManager\DuplicateNameException $e) {

                $form['email']->addError('Jejda - email (' . $values->email . ') je u nás už zaregistrovný!');
                return;
            }
            $onSuccess();
        };

        return $form;
    }
}