<?php

declare(strict_types = 1);

namespace App\Model;

use Nette;
use App\Model\FileManager;


class FoodManager {

    use Nette\SmartObject;

    // set database details
    private const
            TABLE_ALERGENS = 'food_alergens',
            TABLE_MENU = 'food_menu',
            COLUMN_ID = 'id',
            COLUMN_DAY = 'day',
            COLUMN_WEEK = 'week',
            COLUMN_SHORT_NAME = 'short_name',
            COLUMN_LONG_NAME = 'long_name',
            COLUMN_IMAGE_URL = 'image_url',
            COLUMN_DETAIL = 'detail',
            COLUMN_BREAKFAST = 'breakfast',
            COLUMN_BREAKFAST_ALERGENS = 'breakfast_alergens',
            COLUMN_SOUP = 'soup',
            COLUMN_SOUP_ALERGENS = 'soup_alergens',
            COLUMN_MAIN_COURSE = 'main_course',
            COLUMN_MAIN_COURS_ALERGENS = 'main_course_alergens',
            COLUMN_SNACK = 'snack',
            COLUMN_SNACK_ALERGENS = 'snack_alergens',
            COLUMN_CREATOR = 'creator',
            COLUMN_CREATED_AT = 'created_at',
            COLUMN_EDITOR = 'editor',
            COLUMN_EDITED_AT = 'edited_at';

    /** @var Nette\Database\Context */
    private $database;
    
    /** @var App\Model\FileManager */
    private $fileManager;
    
    public function __construct(Nette\Database\Context $database,
                                FileManager $filemanager) {
        $this->database = $database;
        $this->fileManager = $filemanager;
    }

    /**
     * Add alergen
     * @param type $logged_user
     * @param type $values
     * @throws OrganisationException
     */
    public function addAlergen($logged_user, $values): void {

        try {

            // insert into db
            $insert = $this->database->table(self::TABLE_ALERGENS)->insert([
                        self::COLUMN_SHORT_NAME => $values->short_name,
                        self::COLUMN_LONG_NAME => $values->long_name,
                        self::COLUMN_DETAIL => $values->detail,
                        self::COLUMN_CREATOR => $logged_user->getIdentity()->getData()['email'],
                        self::COLUMN_CREATED_AT => time()
                        
                    ]);
            // get last id
            $lastId = $insert->id;
            
        } catch (\Exception $e) {
            throw new FoodException('Chyba při ukládání! (detail - \App\Model\FoodManager::addAlergen()) ' . $e->getMessage());
        }
        
        // upload image
        foreach ($values->formImages as $k => $formImage) {

            if ($formImage->image_url->hasFile()) {

                try {

                    // insert into db
                    $insertLogo = $this->database->table(self::TABLE_ALERGENS)->get($lastId)->update([
                            self::COLUMN_IMAGE_URL => '/img/food_menu/' . $this->fileManager->setFilename($formImage->image_url) . $this->fileManager->getSuffix($formImage->image_url),
                        ]);

                    // upload image
                    $upload = $this->fileManager->uploadAlergenImage($values, $formImage->image_url);

                } catch (\Exception $e) {
                    throw new FoodException('Chyba při nahrávání obrázku alergenu (detail - \App\Model\FoodManager::addAlergen()->uploadAlergenImage()) ' . $e->getMessage());
                }
            }
        }
    }
    
    /**
     * Edit alergen
     * @param type $logged_user
     * @param type $values
     * @param type $alergenId
     * @throws OrganisationException
     */
    public function editAlergen($logged_user, $alergenId, $values): void {

        try {
            // update article details
            $update = $this->database->table(self::TABLE_ALERGENS)->get($alergenId);
            $update->update([self::COLUMN_SHORT_NAME => $values->short_name,
                            self::COLUMN_LONG_NAME => $values->long_name,
                            self::COLUMN_DETAIL => $values->detail,
                            self::COLUMN_EDITOR => $logged_user->getIdentity()->getData()['email'],
                            self::COLUMN_EDITED_AT => time()
                    ]);
            
            // upload image
            foreach ($values->formImages as $k => $formImage) {
                
                if ($formImage->image_url->hasFile()) {
                    
                    try {
                        // update db
                        $updateLogo = $this->database->table(self::TABLE_ALERGENS)->get($alergenId)->update([
                                self::COLUMN_IMAGE_URL => '/img/food_menu/' . $this->fileManager->setFilename($formImage->image_url) . $this->fileManager->getSuffix($formImage->image_url),
                            ]);
                        
                        // upload
                        $upload = $this->fileManager->uploadAlergenImage($values, $formImage->image_url);

                    } catch (\Exception $e) {
                        throw new FoodException('Chyba při nahrávání obrázku alergenu (detail - \App\Model\FoodManager::editAlergen()->uploadAlergenImage()) ' . $e->getMessage());
                    }
                }
            }
            
        } catch (\Exception $e) {
            throw new FoodException('Chyba při ukládání! (detail - \App\Model\FoodManager::editAlergen()) ' . $e->getMessage());
        }
    }
    
    /**
     * Add food
     * @param type $logged_user
     * @param type $foods
     * @throws FoodException
     */
    public function addFood($logged_user, $foods): void {
        
        foreach($foods as $food) {
            foreach($food as $course) {
                
                // convert alergens array to string
                $breakfast_alergens = "";
                foreach($course->breakfast_alergens as $alergen) {
                    $breakfast_alergens .= $alergen . ", ";
                }
                
                $soup_alergens = "";
                foreach($course->soup_alergens as $alergen) {
                    $soup_alergens .= $alergen . ", ";
                }
                
                $main_course_alergens = "";
                foreach($course->main_course_alergens as $alergen) {
                    $main_course_alergens .= $alergen . ", ";
                }
                
                $snack_alergens = "";
                foreach($course->snack_alergens as $alergen) {
                    $snack_alergens .= $alergen . ", ";
                }

                try {

                    // insert into db
                    $insert = $this->database->table(self::TABLE_MENU)->insert([
                            self::COLUMN_DAY => $course->day,
                            self::COLUMN_WEEK => date("W", $course->day),
                            self::COLUMN_BREAKFAST => $course->breakfast,
                            self::COLUMN_BREAKFAST_ALERGENS => rtrim($breakfast_alergens, ', '),
                            self::COLUMN_SOUP => $course->soup,
                            self::COLUMN_SOUP_ALERGENS => rtrim($soup_alergens, ', '),
                            self::COLUMN_MAIN_COURSE => $course->main_course,
                            self::COLUMN_MAIN_COURS_ALERGENS => rtrim($main_course_alergens, ', '),
                            self::COLUMN_SNACK => $course->snack,
                            self::COLUMN_SNACK_ALERGENS => rtrim($snack_alergens, ', '),
                            self::COLUMN_CREATOR => $logged_user->getIdentity()->getData()['email'],
                            self::COLUMN_CREATED_AT => time()

                        ]);

                } catch (\Exception $e) {
                    throw new FoodException('Chyba při ukládání! (detail - \App\Model\FoodManager::addFood()) ' . $e->getMessage());
                }

            }
        }
        
    }
    
    /**
     * Edit food
     * @param type $logged_user
     * @param type $values
     * @param type $foodId
     * @throws FoodException
     */
    public function editFood($logged_user, $foodId, $values): void {

        // convert alergens array to string
        $breakfast_alergens = "";
        foreach($values->breakfast_alergens as $alergen) {
            $breakfast_alergens .= $alergen . ", ";
        }

        $soup_alergens = "";
        foreach($values->soup_alergens as $alergen) {
            $soup_alergens .= $alergen . ", ";
        }

        $main_course_alergens = "";
        foreach($values->main_course_alergens as $alergen) {
            $main_course_alergens .= $alergen . ", ";
        }

        $snack_alergens = "";
        foreach($values->snack_alergens as $alergen) {
            $snack_alergens .= $alergen . ", ";
        }
        
        try {
            // update
            $update = $this->database->table(self::TABLE_MENU)->get($foodId);
            $update->update([self::COLUMN_DAY => $values->day,
                            self::COLUMN_WEEK => date("W", strtotime($values->day)),
                            self::COLUMN_BREAKFAST => $values->breakfast,
                            self::COLUMN_BREAKFAST_ALERGENS => rtrim($breakfast_alergens, ', '),
                            self::COLUMN_SOUP => $values->soup,
                            self::COLUMN_SOUP_ALERGENS => rtrim($soup_alergens, ', '),
                            self::COLUMN_MAIN_COURSE => $values->main_course,
                            self::COLUMN_MAIN_COURS_ALERGENS => rtrim($main_course_alergens, ', '),
                            self::COLUMN_SNACK => $values->snack,
                            self::COLUMN_SNACK_ALERGENS => rtrim($snack_alergens, ', '),
                            self::COLUMN_EDITOR => $logged_user->getIdentity()->getData()['email'],
                            self::COLUMN_EDITED_AT => time()
                    ]);
            
        } catch (\Exception $e) {
            throw new FoodException('Chyba při ukládání! (detail - \App\Model\FoodManager::editFood()) ' . $e->getMessage());
        }
    }

}

class FoodException extends \Exception {}