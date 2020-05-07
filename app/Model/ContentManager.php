<?php

declare(strict_types = 1);

namespace App\Model;

use Nette;
use App\Model\FileManager;

class ContentManager {

    use Nette\SmartObject;

    // set database details
    private const
            TABLE_SECTIONS = 'sections',
            TABLE_SECTIONS_DETAILS = 'sections_details',
            COLUMN_ID = 'id',
            COLUMN_SECTIONS_ID = 'sections_id',
            COLUMN_DETAIL_TITLE = 'detail_title',
            COLUMN_DETAIL_CONTENT = 'detail_content',
            COLUMN_DETAIL_IMAGE = 'detail_image',
            COLUMN_SECTION_TYPE = 'section_type',
            COLUMN_SECTION_PRIORITY = 'section_priority',
            COLUMN_SECTION_TITLE = 'section_title',
            COLUMN_SECTION_CONTENT = 'section_content',
            COLUMN_SECTION_IMAGE = 'section_image',
            COLUMN_SECTION_WIDTH = 'section_width',
            COLUMN_SECTION_COLUMNS = 'section_columns',
            COLUMN_CREATOR = 'creator',
            COLUMN_CREATED_AT = 'created_at',
            COLUMN_EDITOR = 'editor',
            COLUMN_EDITED_AT = 'edited_at',
            COLUMN_URL = 'url',
            COLUMN_URL_THUMB = 'url_thumb',
            COLUMN_FILE_TYPE = 'file_type';

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
     * Add section
     * @param type $logged_user
     * @param type $values
     * @throws SectionException
     */
    public function add($logged_user, $values): void {

        try {

            // insert details into db
            $insert = $this->database->table(self::TABLE_SECTIONS)->insert([
                        self::COLUMN_SECTION_TITLE => $values->section_title,
                        self::COLUMN_SECTION_CONTENT => $values->section_content,
                        self::COLUMN_SECTION_TYPE => $values->section_type,
                        self::COLUMN_SECTION_PRIORITY => $values->section_priority,
                        self::COLUMN_SECTION_WIDTH => $values->section_width,
                        self::COLUMN_SECTION_COLUMNS => $values->section_columns,
                        self::COLUMN_CREATOR => $logged_user->getIdentity()->getData()['email'],
                        self::COLUMN_CREATED_AT => time()
            ]);
            // get last id
            $lastId = $insert->id;
            
        } catch (\Exception $e) {
            throw new SectionException('Chyba při ukládání! (detail - \App\Model\ContentManager::add()) ' . $e->getMessage());
        }
        
        // upload image
        foreach ($values->formImages as $k => $formImage) {

            if ($formImage->image->hasFile()) {

                try {

                    // insert into db
                    $insertLogo = $this->database->table(self::TABLE_SECTIONS)->get($lastId)->update([
                        self::COLUMN_SECTION_IMAGE => '/sections/' . $lastId . '/logo' . $this->fileManager->getSuffix($formImage->image),
                    ]);

                    // upload image
                    $upload = $this->fileManager->uploadLogo($values, $formImage->image, $lastId);
                    
                } catch (\Exception $e) {
                    throw new SectionException('Chyba při nahrávání loga (detail - \App\Model\ContentManager::add()->upload()) ' . $e->getMessage());
                }
            }
        }
    }

    /**
     * Edit section
     * @param type $logged_user
     * @param type $values
     * @param type $sectionId
     * @throws SectionException
     */
    public function edit($logged_user, $sectionId, $values): void {

        try {
            // update details
            $update = $this->database->table(self::TABLE_SECTIONS)->get($sectionId);
            //dump($update);exit;
            $update->update([self::COLUMN_SECTION_TITLE => $values->section_title,
                        self::COLUMN_SECTION_CONTENT => $values->section_content,
                        self::COLUMN_SECTION_TYPE => $values->section_type,
                        self::COLUMN_SECTION_PRIORITY => $values->section_priority,
                        self::COLUMN_SECTION_WIDTH => $values->section_width,
                        self::COLUMN_SECTION_COLUMNS => $values->section_columns,
                        self::COLUMN_EDITOR => $logged_user->getIdentity()->getData()['email'],
                        self::COLUMN_EDITED_AT => time()
            ]);
            
        } catch (\Exception $e) {
            throw new SectionException('Chyba při ukládání! (detail - \App\Model\ContentManager::edit()) ' . $e->getMessage());
        }
        
        // upload image
        foreach ($values->formImages as $k => $formImage) {

            if ($formImage->image->hasFile()) {

                try {

                    // update db
                    $updateLogo = $this->database->table(self::TABLE_SECTIONS)->get($sectionId)->update([
                        self::COLUMN_SECTION_IMAGE => '/sections/' . $sectionId . '/logo' . $this->fileManager->getSuffix($formImage->image),
                    ]);

                    // upload
                    $upload = $this->fileManager->uploadLogo($values, $formImage->image, $sectionId);
                    
                } catch (\Exception $e) {
                    throw new SectionException('Chyba při nahrávání loga (detail - \App\Model\ContentManager::edit()->upload()) ' . $e->getMessage());
                }
            }
        }
    }

    /**
     * Add section detail
     * @param type $logged_user
     * @param type $values
     * @throws SectionException
     */
    public function addDetail($logged_user, $sectionId, $values): void {

        try {

            // insert details into db
            $insert = $this->database->table(self::TABLE_SECTIONS_DETAILS)->insert([
                        self::COLUMN_SECTIONS_ID => $sectionId,
                        self::COLUMN_DETAIL_TITLE => $values->detail_title,
                        self::COLUMN_DETAIL_CONTENT => $values->detail_content,
                        self::COLUMN_CREATOR => $logged_user->getIdentity()->getData()['email'],
                        self::COLUMN_CREATED_AT => time()
            ]);
            // get last id
            $lastId = $insert->id;
            
        } catch (\Exception $e) {
            throw new SectionException('Chyba při ukládání! (detail - \App\Model\ContentManager::addDetail()) ' . $e->getMessage());
        }
        
        // upload image
        foreach ($values->formImages as $k => $formImage) {

            if ($formImage->image->hasFile()) {

                try {

                    // insert into db
                    $insertLogo = $this->database->table(self::TABLE_SECTIONS_DETAILS)->get($lastId)->update([
                        self::COLUMN_DETAIL_IMAGE => '/sections/' . $sectionId . '/image_detail_' . $lastId . $this->fileManager->getSuffix($formImage->image),
                    ]);

                    // upload image
                    $upload = $this->fileManager->uploadDetailLogo($values, $formImage->image, $sectionId, $lastId);
                    
                } catch (\Exception $e) {
                    throw new SectionException('Chyba při nahrávání obrázku (detail - \App\Model\ContentManager::addDetail()->upload()) ' . $e->getMessage());
                }
            }
        }
    }

    /**
     * Edit section detail
     * @param type $logged_user
     * @param type $values
     * @param type $sectionId
     * @param type $sectionDetailId
     * @throws SectionException
     */
    public function editDetail($logged_user, $sectionId, $sectionDetailId, $values): void {

        try {
            // update details
            $update = $this->database->table(self::TABLE_SECTIONS_DETAILS)->get($sectionDetailId);

            $update->update([self::COLUMN_SECTIONS_ID => $sectionId,
                        self::COLUMN_DETAIL_TITLE => $values->detail_title,
                        self::COLUMN_DETAIL_CONTENT => $values->detail_content,
                        self::COLUMN_EDITOR => $logged_user->getIdentity()->getData()['email'],
                        self::COLUMN_EDITED_AT => time()
            ]);
            
        } catch (\Exception $e) {
            throw new SectionException('Chyba při ukládání! (detail - \App\Model\ContentManager::editDetail()) ' . $e->getMessage());
        }
        
        // upload image
        foreach ($values->formImages as $k => $formImage) {

            if ($formImage->image->hasFile()) {

                try {

                    // update db
                    $updateLogo = $this->database->table(self::TABLE_SECTIONS_DETAILS)->get($sectionDetailId)->update([
                        self::COLUMN_DETAIL_IMAGE => '/sections/' . $sectionId . '/image_detail_' . $sectionDetailId . $this->fileManager->getSuffix($formImage->image),
                    ]);

                    // upload
                    $upload = $this->fileManager->uploadDetailLogo($values, $formImage->image, $sectionId, $sectionDetailId);
                    
                } catch (\Exception $e) {
                    throw new SectionException('Chyba při nahrávání loga (detail - \App\Model\ContentManager::editDetail()->upload()) ' . $e->getMessage());
                }
            }
        }
    }
}

class SectionException extends \Exception {}