<?php
declare(strict_types = 1);

namespace App\Model;

use Nette;

class DbHandler {

    use Nette\SmartObject;

    /**
     * @var Nette\Database\Context
     */
    private $database;

    public function __construct(Nette\Database\Context $database) {
        $this->database = $database;
    }

    /**
     * Get Users
     * @return object
     */
    public function getUsers() {
        return $this->database->table('users');
    }

    /**
     * Get Articles
     * @return object
     */
    public function getArticles() {
        return $this->database->table('articles');
    }

    /**
     * Get Images
     * @return object
     */
    public function getImages() {
        return $this->database->table('gallery');
    }

    /**
     * Get Image categories
     * @return object
     */
    public function getImageAlbum() {
        return $this->database->table('gallery_album');
    }

    /**
     * Get other files
     * @return object
     */
    public function getFiles() {
        return $this->database->table('files');
    }

    /**
     * Get organisations
     * @return object
     */
    public function getOrganisations() {
        return $this->database->table('organisation');
    }

    /**
     * Get organisation employees
     * @return object
     */
    public function getOrganisationEmployees() {
        return $this->database->table('organisation_employees');
    }

    /**
     * Get organisation clients
     * @return object
     */
    public function getOrganisationClients() {
        return $this->database->table('organisation_clients');
    }

    /**
     * Get organisation sponsors
     * @return object
     */
    public function getOrganisationSponsors() {
        return $this->database->table('organisation_sponsors');
    }

    /**
     * Get registred emails for newsletter
     * @return object
     */
    public function getNewsletter() {
        return $this->database->table('newsletter');
    }

    /**
     * Get sections
     * @return object
     */
    public function getSections() {
        return $this->database->table('sections');
    }

    /**
     * Get sections details
     * @return object
     */
    public function getSectionsDetails() {
        return $this->database->table('sections_details');
    }

    /**
     * Get alergens
     * @return object
     */
    public function getAlergens() {
        return $this->database->table('food_alergens');
    }

    /**
     * Get foods
     * @return object
     */
    public function getFoods() {
        return $this->database->table('food_menu');
    }

}
