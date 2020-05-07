<?php

declare(strict_types = 1);

namespace App\Model;

use Nette;
use App\Model\FileManager;

class GalleryManager {

    use Nette\SmartObject;

    // set database details
    private const
            TABLE_GALLERY = 'gallery',
            TABLE_GALLERY_ALBUM = 'gallery_album',
            COLUMN_ID = 'id',
            COLUMN_SHORT_NAME = 'short_name',
            COLUMN_NAME = 'name',
            COLUMN_DESCRIPTION = 'description',
            COLUMN_ALBUM_ID = 'album_id',
            COLUMN_URL = 'url',
            COLUMN_URL_THUMB = 'url_thumb',
            COLUMN_VISIBLE = 'visible',
            COLUMN_CREATOR = 'creator',
            COLUMN_CREATED_AT = 'created_at',
            COLUMN_EDITOR = 'editor',
            COLUMN_EDITED_AT = 'edited_at',
            IMAGE_FORMAT = array('.jpg', '.jpeg', '.png', '.gif', '.JPG', '.JPEG', '.PNG', '.GIF');

    /** @var Nette\Database\Context */
    private $database;
    
    /** @var App\Model\FileManager */
    private $fileManager;
    
    
    public function __construct(Nette\Database\Context $database,
                                FileManager $fileManager) {
            $this->database = $database;
            $this->fileManager = $fileManager;
    }

    public function diacriticSubstract($text) {

        $characters = Array(
            'ä' => 'a', 'Ä' => 'A', 'á' => 'a', 'Á' => 'A', 'à' => 'a', 'À' => 'A', 'ã' => 'a', 'Ã' => 'A', 'â' => 'a', 'Â' => 'A',
            'č' => 'c', 'Č' => 'C', 'ć' => 'c', 'Ć' => 'C',
            'ď' => 'd', 'Ď' => 'D',
            'ě' => 'e', 'Ě' => 'E', 'é' => 'e', 'É' => 'E', 'ë' => 'e', 'Ë' => 'E', 'è' => 'e', 'È' => 'E', 'ê' => 'e', 'Ê' => 'E',
            'í' => 'i', 'Í' => 'I', 'ï' => 'i', 'Ï' => 'I', 'ì' => 'i', 'Ì' => 'I', 'î' => 'i', 'Î' => 'I',
            'ľ' => 'l', 'Ľ' => 'L', 'ĺ' => 'l', 'Ĺ' => 'L',
            'ń' => 'n', 'Ń' => 'N', 'ň' => 'n', 'Ň' => 'N', 'ñ' => 'n', 'Ñ' => 'N',
            'ó' => 'o', 'Ó' => 'O', 'ö' => 'o', 'Ö' => 'O', 'ô' => 'o', 'Ô' => 'O', 'ò' => 'o', 'Ò' => 'O', 'õ' => 'o', 'Õ' => 'O', 'ő' => 'o', 'Ő' => 'O',
            'ř' => 'r', 'Ř' => 'R', 'ŕ' => 'r', 'Ŕ' => 'R',
            'š' => 's', 'Š' => 'S', 'ś' => 's', 'Ś' => 'S',
            'ť' => 't', 'Ť' => 'T',
            'ú' => 'u', 'Ú' => 'U', 'ů' => 'u', 'Ů' => 'U', 'ü' => 'u', 'Ü' => 'U', 'ù' => 'u', 'Ù' => 'U', 'ũ' => 'u', 'Ũ' => 'U', 'û' => 'u', 'Û' => 'U',
            'ý' => 'y', 'Ý' => 'Y', 'ž' => 'z', 'Ž' => 'Z', 'ź' => 'z', 'Ź' => 'Z'
        );

        return strtr($text, $characters);
    }

    /**
     * Upload image and insert image details into db
     * @param type $logged_user
     * @param type $values
     * @throws GalleryException
     */
    public function addImage($logged_user, $values): void {

        // upload image and insert image details into db
        foreach ($values->formImages as $k => $formImage) {

            if ($formImage->image->hasFile()) {

                $path = $this->fileManager->setPath($formImage->image);
                $pathThumb = $this->fileManager->setPathThumb($formImage->image);
                $filename = $this->fileManager->setFilename($formImage->image) . $this->fileManager->getSuffix($formImage->image);
                $url = $path . $filename;
                $urlThumb = $pathThumb . $filename;

                // upload image
                try {

                    $upload = $this->fileManager->uploadImage($formImage->image);
                } catch (\Exception $e) {
                    throw new GalleryException('Chyba při nahrávání souboru ' . $filename . ' (detail - \App\Model\GalleryManeger::add()->upload())' . $e->getMessage() . '\n');
                }

                // insert into db
                try {
                    $insertImage = $this->database->table(self::TABLE_GALLERY)->insert([
                        self::COLUMN_NAME => $filename,
                        self::COLUMN_DESCRIPTION => $formImage->description,
                        self::COLUMN_ALBUM_ID => $formImage->album_id,
                        self::COLUMN_URL => $url,
                        self::COLUMN_URL_THUMB => $urlThumb,
                        self::COLUMN_CREATOR => $logged_user->getIdentity()->getData()['email'],
                    ]);
                } catch (\Exception $e) {
                    throw new GalleryException('Chyba při ukládání obrázku do databáze (detail - \App\Model\GalleryManeger::add()->insertImage)' . $e->getMessage() . '\n');
                }
            }
        }
    }

    /**
     * Edit image details
     * @param type $logged_user
     * @param type $values
     * @param type $imageId
     * @throws GalleryException
     */
    public function editImage($logged_user, $values, $imageId): void {

        // update category db
        try {

            $updateImage = $this->database->table(self::TABLE_GALLERY)->get($imageId);
            $update = $updateImage->update([
                self::COLUMN_DESCRIPTION => $values->description,
                self::COLUMN_ALBUM_ID => $values->album_id
            ]);
        } catch (\Exception $e) {
            throw new GalleryException('Změnu obrázku nelze provést! (detail - \App\Model\GalleryManeger::addCategory())' . $e->getMessage() . '\n');
        }
    }

    /**
     * Add album
     * @param type $logged_user
     * @param type $values
     * @throws GalleryException
     */
    public function addAlbum($logged_user, $values): void {

        // sanitize name to short-name
        $short_name = strtolower(str_replace(' ', '-', $this->diacriticSubstract($values->name)));

        // insert into db
        try {
            $insertAlbum = $this->database->table(self::TABLE_GALLERY_ALBUM)->insert([
                self::COLUMN_SHORT_NAME => $short_name,
                self::COLUMN_NAME => $values->name
            ]);
        } catch (\Exception $e) {
            throw new GalleryException('Chyba při vkládání kategorie do databáze (detail - \App\Model\GalleryManeger::addAlbum())' . $e->getMessage() . '\n');
        }
    }

    /**
     * Edit album
     * @param type $logged_user
     * @param type $albumId
     * @param type $values
     * @throws GalleryException
     */
    public function editAlbum($logged_user, $albumId, $values): void {

        // sanitize name to short-name
        $short_name = strtolower(str_replace(' ', '-', $this->diacriticSubstract($values->name)));

        // update category db
        try {

            $updateAlbum = $this->database->table(self::TABLE_GALLERY_ALBUM)->get($albumId);
            $update = $updateAlbum->update([
                self::COLUMN_SHORT_NAME => $short_name,
                self::COLUMN_NAME => $values->name
            ]);
        } catch (\Exception $e) {
            throw new GalleryException('Chyba při ukládání změny do databáze (detail - \App\Model\GalleryManeger::editAlbum())' . $e->getMessage() . '\n');
        }
    }
}

class GalleryException extends \Exception {}
