<?php

declare(strict_types = 1);

namespace App\Model;

use Nette;
use App\Model\FileManager;

class OrganisationManager {

    use Nette\SmartObject;

    // set database details
    private const
            TABLE_ORGANISATION = 'organisation',
            COLUMN_SHORT_NAME = 'short_name',
            COLUMN_NAME = 'name',
            COLUMN_LOGO = 'logo',
            COLUMN_EMAIL = 'email',
            COLUMN_PHONE = 'phone',
            COLUMN_GSM = 'gsm',
            COLUMN_STREET = 'street',
            COLUMN_CITY = 'city',
            COLUMN_POSTAL = 'postal',
            COLUMN_ICO = 'ico',
            COLUMN_DIC = 'dic',
            COLUMN_ACCOUNT = 'account',
            COLUMN_SPONSORS = 'sponsors',
            COLUMN_CLIENTS = 'clients',
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
     * Load organisation info
     * @return \Nette\Database\Table\Selection
     */
    public function getOrganisation(): Nette\Database\Table\Selection {

        return $this->database->table(self::TABLE_ORGANISATION)->fetch();
    }

    /**
     * Add oraganisation
     * @param type $logged_user
     * @param type $values
     * @throws OrganisationException
     */
    public function add($logged_user, $values): void {

        try {

            // insert details into db
            $insert = $this->database->table(self::TABLE_ORGANISATION)->insert([
                        self::COLUMN_SHORT_NAME => $values->short_name,
                        self::COLUMN_NAME => $values->name,
                        self::COLUMN_EMAIL => $values->email,
                        self::COLUMN_PHONE => $values->phone,
                        self::COLUMN_GSM => $values->gsm,
                        self::COLUMN_STREET => $values->street,
                        self::COLUMN_CITY => $values->city,
                        self::COLUMN_POSTAL => $values->postal,
                        self::COLUMN_ICO => $values->ico,
                        self::COLUMN_DIC => $values->dic,
                        self::COLUMN_ACCOUNT => $values->account,
                        self::COLUMN_SPONSORS => $values->sponsors,
                        self::COLUMN_CLIENTS => $values->clients,
                        self::COLUMN_CREATOR => $logged_user->getIdentity()->getData()['email'],
                        self::COLUMN_CREATED_AT => time()
                        
                    ]);
            // get last id
            $lastId = $insert->id;
            
        } catch (\Exception $e) {
            throw new OrganisationException('Chyba při ukládání! (detail - \App\Model\OrganisationManager::add()) ' . $e->getMessage());
        }
        
        // upload image
        foreach ($values->formImages as $k => $formImage) {

            if ($formImage->image->hasFile()) {

                try {

                    // insert into db
                    $insertLogo = $this->database->table(self::TABLE_ORGANISATION)->get($lastId)->update([
                            self::COLUMN_LOGO => '/organisations/' . $lastId . '/main_logo' . $this->fileManager->getSuffix($formImage->image),
                        ]);

                    // upload image
                    $upload = $this->fileManager->uploadOrganisationLogo($values, $formImage->image, $lastId);

                } catch (\Exception $e) {
                    throw new OrganisationException('Chyba při nahrávání loga (detail - \App\Model\OraganisationManager::add()->upload()) ' . $e->getMessage());
                }
            }
        }
    }
    
    /**
     * Edit oraganisation
     * @param type $logged_user
     * @param type $values
     * @param type $organisation_id
     * @throws OrganisationException
     */
    public function edit($logged_user, $organisation_id, $values): void {

        try {
            // update details
            $update = $this->database->table(self::TABLE_ORGANISATION)->get($organisation_id);
            $update->update([self::COLUMN_SHORT_NAME => $values->short_name,
                            self::COLUMN_NAME => $values->name,
                            self::COLUMN_EMAIL => $values->email,
                            self::COLUMN_PHONE => $values->phone,
                            self::COLUMN_GSM => $values->gsm,
                            self::COLUMN_STREET => $values->street,
                            self::COLUMN_CITY => $values->city,
                            self::COLUMN_POSTAL => $values->postal,
                            self::COLUMN_ICO => $values->ico,
                            self::COLUMN_DIC => $values->dic,
                            self::COLUMN_ACCOUNT => $values->account,
                            self::COLUMN_SPONSORS => $values->sponsors,
                            self::COLUMN_CLIENTS => $values->clients,
                            self::COLUMN_EDITOR => $logged_user->getIdentity()->getData()['email'],
                            self::COLUMN_EDITED_AT => time()
                    ]);
            
        } catch (\Exception $e) {
            throw new OrganisationException('Chyba při ukládání! (detail - \App\Model\OrganisationManager::edit()) ' . $e->getMessage());
        }
        
        // upload image
        foreach ($values->formImages as $k => $formImage) {

            if ($formImage->image->hasFile()) {

                try {
                    // update db
                    $updateLogo = $this->database->table(self::TABLE_ORGANISATION)->get($organisation_id)->update([
                            self::COLUMN_LOGO => '/organisations/' . $organisation_id . '/main_logo' . $this->fileManager->getSuffix($formImage->image),
                        ]);

                    // upload
                    $upload = $this->fileManager->uploadOrganisationLogo($values, $formImage->image, $organisation_id);

                } catch (\Exception $e) {
                    throw new OrganisationException('Chyba při nahrávání loga (detail - \App\Model\OraganisationManager::edit()->upload()) ' . $e->getMessage());
                }
            }
        }
    }
}

class OrganisationException extends \Exception {}