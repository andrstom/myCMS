<?php

declare(strict_types = 1);

namespace App\Model;

use Nette;
use Nette\Utils\FileSystem;
use Nette\Utils\Image;

class FileManager {

    use Nette\SmartObject;

    private const
            ROOT = __DIR__,
            DIR_IMAGES = '/img/galerie/',
            DIR_IMAGES_THUMB = '/img/galerie/thumb/',
            DIR_FILES = '/files/',
            DIR_FILES_THUMB = '/files/thumb/',
            DIR_SECTIONS = '/sections/',
            FILE_ERROR = 'Soubor je poškozen!';

    /** @var type */
    private $file;

    /* @var thumb */
    private $thumb;

    public function getTempname($file) {
        
        return $file->getTemporaryFile();
    }

    public function getSuffix($file) {

        return strtolower(mb_substr($file->getSanitizedName(), strrpos($file->getSanitizedName(), ".")));
    }

    /*
     * @var Image
     * return image|false
     */

    public function isImage($file) {

        if ($file->isImage() and $file->isOk()) {
            $this->file = $file;
            return $this->file;
        } else {
            return false;
        }
    }

    public function setPath($file) {

        if ($this->isImage($file)) {
            return self::DIR_IMAGES;
        } else {
            return self::DIR_FILES;
        }
    }

    public function setPathThumb($file) {

        if ($this->isImage($file)) {
            return self::DIR_IMAGES_THUMB;
        } else {
            return self::DIR_FILES_THUMB;
        }
    }

    public function setFilename($file) {

        return basename(strtolower($file->getSanitizedName()), $this->getSuffix($file));
    }

    /**
     * Upload image
     * @param type $file
     * @return boolean
     */
    public function uploadImage($file) {

        if ($file->isImage($file)) {

            // Save img and thum or redirect
            if (!file_exists($this->setPath($file) . $this->setFilename($file) . $this->getSuffix($file)) ||
                    !file_exists($this->setPathThumb($file) . $this->setFilename($file) . '_thumb' . $this->getSuffix($file))) {

                $filename = $this->setFilename($file);
            } else {
                $filename = $this->setFilename($file) . '_kopie';
            }

            // Upload image
            $this->file->move("." . $this->setPath($file) . $filename . $this->getSuffix($file));

            // Resize and thumbnail create
            $image = Image::fromFile("." . $this->setPath($file) . $filename . $this->getSuffix($file));
            $thumb = $image;

            // rezize image
            if ($image->getWidth() > $image->getHeight()) {
                $image->resize(1024, NULL);
                $thumb->resize(512, NULL);
            } else {
                $image->resize(NULL, 1024);
                $thumb->resize(NULL, 512);
            }

            // Sharping
            $image->sharpen();
            $thumb->sharpen();

            $saveImage = $image->save("." . $this->setPath($file) . $filename . $this->getSuffix($file));
            $saveThumb = $thumb->save("." . $this->setPathThumb($file) . $filename . $this->getSuffix($file));
        }
    }

    /**
     * Upload files
     * @param type $file
     * @return boolean
     */
    public function uploadFile($file) {

        // Upload file
        if (!file_exists($this->setPath($file) . $this->setFilename($file) . $this->getSuffix($file))) {

            $this->file->move($this->setPath($file) . $this->setFilename($file) . $this->getSuffix($file));
        }
    }

    /**
     * Upload organisation logo
     * 
     * @param type $values
     * @param type $file
     * @param type $id
     * @return boolean
     */
    public function uploadOrganisationLogo($values, $file, $id) {

        if ($file->isImage($file)) {

            $dir = './organisations/' . $id;
            FileSystem::createDir($dir);

            $path = $dir . '/main_logo' . $this->getSuffix($file);

            // Upload file
            $upload = $file->move($path);

            // Resize and thumbnail create
            $image = Image::fromFile($path);

            // rezize image
            if ($image->getWidth() > $image->getHeight()) {
                $image->resize(256, NULL);
            } else {
                $image->resize(NULL, 256);
            }

            // Sharping
            $image->sharpen();

            $saveImage = $image->save($path);

            return true;
        }
    }

    /**
     * Upload section logo
     * 
     * @param type $values
     * @param type $file
     * @param type $id
     * @return boolean
     */
    public function uploadLogo($values, $file, $id) {

        if ($file->isImage($file)) {

            $dir = './sections/' . $id;
            FileSystem::createDir($dir);

            $path = $dir . '/logo' . $this->getSuffix($file);

            // Upload file
            $upload = $file->move($path);

            // Resize and thumbnail create
            $image = Image::fromFile($path);

            // rezize image
            if ($image->getWidth() > $image->getHeight()) {
                $image->resize(255, NULL);
            } else {
                $image->resize(NULL, 255);
            }

            // Sharping
            $image->sharpen();

            $saveImage = $image->save($path);

            return true;
        }
    }

    /**
     * Upload section detail image
     * 
     * @param type $values
     * @param type $file
     * @param type $sectionId
     * @param type $sectionDetailId
     * @return boolean
     */
    public function uploadDetailLogo($values, $file, $sectionId, $sectionDetailId) {

        if ($file->isImage($file)) {

            $dir = './sections/' . $sectionId;
            FileSystem::createDir($dir);

            $path = $dir . '/image_detail_' . $sectionDetailId . $this->getSuffix($file);

            // Upload file
            $upload = $file->move($path);

            // Resize and thumbnail create
            $image = Image::fromFile($path);

            // rezize image
            if ($image->getWidth() > $image->getHeight()) {
                $image->resize(512, NULL);
            } else {
                $image->resize(NULL, 512);
            }

            // Sharping
            $image->sharpen();

            $saveImage = $image->save($path);

            return true;
        }
    }

    /**
     * Upload employee image
     * 
     * @param type $values
     * @param type $file
     * @param type $organisation_id
     * @param type $employee_id
     * @return boolean
     */
    public function uploadEmployeeFoto($values, $file, $organisation_id, $employee_id) {

        if ($file->isImage($file)) {

            $dir = './organisations/' . $organisation_id;
            FileSystem::createDir($dir);

            $path = $dir . '/image_employee_' . $employee_id . $this->getSuffix($file);

            // Upload file
            $upload = $file->move($path);

            // Resize and thumbnail create
            $image = Image::fromFile($path);

            // rezize image
            if ($image->getWidth() > $image->getHeight()) {
                $image->resize(255, NULL);
            } else {
                $image->resize(NULL, 255);
            }

            // Sharping
            $image->sharpen();

            $saveImage = $image->save($path);

            return true;
        }
    }

    /**
     * Upload client image
     * 
     * @param type $values
     * @param type $file
     * @param type $organisation_id
     * @param type $client_id
     * @return boolean
     */
    public function uploadClientLogo($values, $file, $organisation_id, $client_id) {

        if ($file->isImage($file)) {

            $dir = './organisations/' . $organisation_id;
            FileSystem::createDir($dir);

            $path = $dir . '/image_client_' . $client_id . $this->getSuffix($file);

            // Upload file
            $upload = $file->move($path);

            // Resize and thumbnail create
            $image = Image::fromFile($path);

            // rezize image
            if ($image->getWidth() > $image->getHeight()) {
                $image->resize(250, NULL);
            } else {
                $image->resize(NULL, 250);
            }

            // Sharping
            $image->sharpen();

            $saveImage = $image->save($path);

            return true;
        }
    }

    /**
     * Upload sponsor image
     * 
     * @param type $values
     * @param type $file
     * @param type $organisation_id
     * @param type $sponsor_id
     * @return boolean
     */
    public function uploadSponsorLogo($values, $file, $organisation_id, $sponsor_id) {

        if ($file->isImage($file)) {

            $dir = './organisations/' . $organisation_id;
            FileSystem::createDir($dir);

            $path = $dir . '/image_sponsor_' . $sponsor_id . $this->getSuffix($file);

            // Upload file
            $upload = $file->move($path);

            // Resize and thumbnail create
            $image = Image::fromFile($path);

            // rezize image
            if ($image->getWidth() > $image->getHeight()) {
                $image->resize(250, NULL);
            } else {
                $image->resize(NULL, 250);
            }

            // Sharping
            $image->sharpen();

            $saveImage = $image->save($path);

            return true;
        }
    }

    /**
     * Upload alergen image
     * 
     * @param type $values
     * @param type $file
     * @param type $id
     * @return boolean
     */
    public function uploadAlergenImage($values, $file) {

        if ($file->isImage($file)) {

            $path = './img/food_menu/' . $this->setFilename($file) . $this->getSuffix($file);

            // Upload file
            $upload = $file->move($path);

            // Resize and thumbnail create
            $image = Image::fromFile($path);

            // rezize image
            if ($image->getWidth() > $image->getHeight()) {
                $image->resize(256, NULL);
            } else {
                $image->resize(NULL, 256);
            }

            // Sharping
            $image->sharpen();

            $saveImage = $image->save($path);

            return true;
        }
    }

}
