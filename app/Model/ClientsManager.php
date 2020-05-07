<?php

declare(strict_types = 1);

namespace App\Model;

use Nette;
use App\Model\FileManager;

class ClientsManager {

    use Nette\SmartObject;

    // set database details
    private const
            TABLE_ORGANISATION_CLIENTS = 'organisation_clients',
            COLUMN_ID = 'id',
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
     * Add Client
     * @param type $logged_user
     * @param type $values
     * @throws ClientsException
     */
    public function addClient($logged_user, $organisation_id, $values): void {

        try {

            // insert details into db
            $insert = $this->database->table(self::TABLE_ORGANISATION_CLIENTS)->insert([
                        'organisation_id' => $organisation_id,
                        self::COLUMN_NAME => $values->name,
                        self::COLUMN_LINK => $values->link,
                        self::COLUMN_CREATOR => $logged_user->getIdentity()->getData()['email'],
                        self::COLUMN_CREATED_AT => time()
                    ]);
            // get last id
            $lastId = $insert->id;
            
        } catch (\PDOException $e) {
            throw new ClientsException('Chyba při ukládání! (detail - \App\Model\ClientsManager::addClient()) ' . $e->getMessage());
        }
        
        // upload image
        foreach ($values->formImages as $k => $formImage) {

            if ($formImage->image->hasFile()) {

                try {
                    // update url
                    $insertImage = $this->database->table(self::TABLE_ORGANISATION_CLIENTS)->get($lastId)->update([
                            self::COLUMN_IMAGE_URL => '/organisations/' . $organisation_id . '/image_client_' . $lastId . $this->fileManager->getSuffix($formImage->image),
                        ]);

                    // upload
                    $upload = $this->fileManager->uploadClientLogo($values, $formImage->image, $organisation_id, $lastId);

                } catch (\Exception $e) {
                    throw new ClientsException('Chyba při nahrávání loga (detail - \App\Model\ClientsManager::addClient()->upload()) ' . $e->getMessage());
                }
            }
        }
    }
    
    /**
     * Edit Client
     * @param type $logged_user
     * @param type $values
     * @throws ClientsException
     */
    public function editClient($logged_user, $organisation_id, $client_id, $values): void {

        try {
            // update article details
            $update = $this->database->table(self::TABLE_ORGANISATION_CLIENTS)->get($client_id);
            
            $update->update([self::COLUMN_NAME => $values->name,
                            self::COLUMN_LINK => $values->link,
                            self::COLUMN_EDITOR => $logged_user->getIdentity()->getData()['email'],
                            self::COLUMN_EDITED_AT => time()
                    ]);
        } catch (\Exception $e) {
            throw new ClientsException('Chyba při ukládání parťáka! (detail - \App\Model\ClientsManager::editClient()) ' . $e->getMessage());
        }
            
        // upload image
        foreach ($values->formImages as $k => $formImage) {

            if ($formImage->image->hasFile()) {

                try {

                    // update url
                    $updateImage = $this->database->table(self::TABLE_ORGANISATION_CLIENTS)->get($client_id)->update([
                                self::COLUMN_IMAGE_URL => '/organisations/' . $organisation_id . '/image_client_' . $client_id . $this->fileManager->getSuffix($formImage->image),
                            ]);

                    // upload
                    $upload = $this->fileManager->uploadClientLogo($values, $formImage->image, $organisation_id, $client_id);

                } catch (\Exception $e) {
                    throw new ClientsException('Chyba při nahrávání loga (detail - \App\Model\ClientsManager::editClient()->uploadClientLogo()) ' . $e->getMessage());
                }
            }
        }
    }
    
}

class ClientsException extends \Exception {}