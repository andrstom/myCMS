<?php

declare(strict_types = 1);

namespace App\Model;

use Nette;
use App\Model\FileManager;

class EmployeesManager {

    use Nette\SmartObject;

    // set database details
    private const
            TABLE_ORGANISATION_EMPLOYEES = 'organisation_employees',
            COLUMN_ID = 'id',
            COLUMN_FIRSTNAME = 'firstname',
            COLUMN_LASTNAME = 'lastname',
            COLUMN_IMAGE = 'image',
            COLUMN_EMAIL = 'email',
            COLUMN_PHONE = 'phone',
            COLUMN_GSM = 'gsm',
            COLUMN_POSITION = 'position',
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
     * Add employee
     * @param type $logged_user
     * @param type $values
     * @throws EmployeesException
     */
    public function addEmployee($logged_user, $organisation_id, $values): void {

        try {

            // insert details into db
            $insert = $this->database->table(self::TABLE_ORGANISATION_EMPLOYEES)->insert([
                        'organisation_id' => $organisation_id,
                        self::COLUMN_FIRSTNAME => $values->firstname,
                        self::COLUMN_LASTNAME => $values->lastname,
                        self::COLUMN_POSITION => $values->position,
                        self::COLUMN_EMAIL => $values->email,
                        self::COLUMN_GSM => $values->gsm,
                        self::COLUMN_CREATOR => $logged_user->getIdentity()->getData()['email'],
                        self::COLUMN_CREATED_AT => time()
                    ]);
            // get last id
            $lastId = $insert->id;
            
        } catch (\PDOException $e) {
            throw new EmployeesException('Chyba při ukládání! (detail - \App\Model\OrganisationManager::addEmployee()) ' . $e->getMessage());
        }
        
        // upload image
        foreach ($values->formImages as $k => $formImage) {

            if ($formImage->image->hasFile()) {

                try {
                    // update url
                    $insertFoto = $this->database->table(self::TABLE_ORGANISATION_EMPLOYEES)->get($lastId)->update([
                            self::COLUMN_IMAGE => '/organisations/' . $organisation_id . '/image_employee_' . $lastId . $this->fileManager->getSuffix($formImage->image),
                        ]);

                    // upload
                    $upload = $this->fileManager->uploadEmployeeFoto($values, $formImage->image, $organisation_id, $lastId);

                } catch (\Exception $e) {
                    throw new EmployeesException('Chyba při nahrávání fotky parťáka (detail - \App\Model\OraganisationManager::addEmployee()->upload()) ' . $e->getMessage());
                }
            }
        }
    }
    
    /**
     * Edit Employee
     * @param type $logged_user
     * @param type $values
     * @throws EmployeesException
     */
    public function editEmployee($logged_user, $organisation_id, $employee_id, $values): void {

        try {
            // update article details
            $update = $this->database->table(self::TABLE_ORGANISATION_EMPLOYEES)->get($employee_id);
            
            $update->update([self::COLUMN_FIRSTNAME => $values->firstname,
                            self::COLUMN_LASTNAME => $values->lastname,
                            self::COLUMN_POSITION => $values->position,
                            self::COLUMN_EMAIL => $values->email,
                            self::COLUMN_GSM => $values->gsm,
                            self::COLUMN_EDITOR => $logged_user->getIdentity()->getData()['email'],
                            self::COLUMN_EDITED_AT => time()
                    ]);
            
        } catch (\Exception $e) {
            throw new EmployeesException('Chyba při ukládání parťáka! (detail - \App\Model\OrganisationManager::editEmployee()) ' . $e->getMessage());
        }
        
        // upload image
        foreach ($values->formImages as $k => $formImage) {

            if ($formImage->image->hasFile()) {

                try {

                    // update url
                    $updateFoto = $this->database->table(self::TABLE_ORGANISATION_EMPLOYEES)->get($employee_id)->update([
                            self::COLUMN_IMAGE => '/organisations/' . $organisation_id . '/image_employee_' . $employee_id . $this->fileManager->getSuffix($formImage->image),
                        ]);

                    // upload
                    $upload = $this->fileManager->uploadEmployeeFoto($values, $formImage->image, $organisation_id, $employee_id);

                } catch (\Exception $e) {
                    throw new EmployeesException('Chyba při nahrávání fotky parťáka (detail - \App\Model\OraganisationManager::editEmployee()->upload()) ' . $e->getMessage());
                }
            }
        }
    }
}

class EmployeesException extends \Exception {}