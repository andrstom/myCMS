<?php

declare(strict_types = 1);

namespace App\Model;

use Nette;
use App\Model\FileManager;

class SponsorsManager {

    use Nette\SmartObject;

    // set database details
    private const
            TABLE_ORGANISATION_SPONSORS = 'organisation_sponsors',
            COLUMN_NAME = 'name',
            COLUMN_LINK = 'link',
            COLUMN_IMAGE_URL = 'image_url',
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
     * Add Sponsor
     * @param type $logged_user
     * @param type $values
     * @throws SponsorsException
     */
    public function addSponsor($logged_user, $organisation_id, $values): void {

        try {

            // insert details into db
            $insert = $this->database->table(self::TABLE_ORGANISATION_SPONSORS)->insert([
                'organisation_id' => $organisation_id,
                self::COLUMN_NAME => $values->name,
                self::COLUMN_LINK => $values->link,
                self::COLUMN_CREATOR => $logged_user->getIdentity()->getData()['email'],
                self::COLUMN_CREATED_AT => time()
            ]);
            // get last id
            $lastId = $insert->id;
        } catch (\PDOException $e) {
            throw new SponsorsException('Chyba při ukládání! (detail - \App\Model\SponsorsManager::addSponsor()) ' . $e->getMessage());
        }

        // upload image
        foreach ($values->formImages as $k => $formImage) {

            if ($formImage->image->hasFile()) {

                try {
                    // update url
                    $insertImage = $this->database->table(self::TABLE_ORGANISATION_SPONSORS)->get($lastId)->update([
                        self::COLUMN_IMAGE_URL => '/organisations/' . $organisation_id . '/image_sponsor_' . $lastId . $this->fileManager->getSuffix($formImage->image),
                    ]);

                    // upload
                    $upload = $this->fileManager->uploadSponsorLogo($values, $formImage->image, $organisation_id, $lastId);
                } catch (\Exception $e) {
                    throw new SponsorsException('Chyba při nahrávání loga (detail - \App\Model\SponsorsManager::addSponsor()->upload()) ' . $e->getMessage());
                }
            }
        }
    }

    /**
     * Edit Sponsor
     * @param type $logged_user
     * @param type $values
     * @throws SponsorsException
     */
    public function editSponsor($logged_user, $organisation_id, $sponsor_id, $values): void {

        try {
            // update article details
            $update = $this->database->table(self::TABLE_ORGANISATION_SPONSORS)->get($sponsor_id);

            $update->update([self::COLUMN_NAME => $values->name,
                self::COLUMN_LINK => $values->link,
                self::COLUMN_EDITOR => $logged_user->getIdentity()->getData()['email'],
                self::COLUMN_EDITED_AT => time()
            ]);
        } catch (\Exception $e) {
            throw new SponsorsException('Chyba při ukládání parťáka! (detail - \App\Model\SponsorsManager::editSponsor()) ' . $e->getMessage());
        }

        // upload image
        foreach ($values->formImages as $k => $formImage) {

            if ($formImage->image->hasFile()) {

                try {

                    // update url
                    $updateImage = $this->database->table(self::TABLE_ORGANISATION_SPONSORS)->get($sponsor_id)->update([
                        self::COLUMN_IMAGE_URL => '/organisations/' . $organisation_id . '/image_sponsor_' . $sponsor_id . $this->fileManager->getSuffix($formImage->image),
                    ]);

                    // upload
                    $upload = $this->fileManager->uploadSponsorLogo($values, $formImage->image, $organisation_id, $sponsor_id);
                } catch (\Exception $e) {
                    throw new SponsorsException('Chyba při nahrávání loga (detail - \App\Model\SponsorsManager::editSponsor()->upload()) ' . $e->getMessage());
                }
            }
        }
    }

}

class SponsorsException extends \Exception {}
