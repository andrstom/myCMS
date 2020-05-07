<?php

declare(strict_types = 1);

namespace App\Model;

use Nette;
use App\Forms\ArticlesFormFactory;
use App\Model\FileManager;
use App\Model\EmailManager;
use App\Model\GalleryManager;

class ArticlesManager {

    use Nette\SmartObject;

    // set database details
    private const
            TABLE_ARTICLES = 'articles',
            TABLE_ARTICLES_GALLERY = 'articles_gallery',
            TABLE_GALLERY = 'gallery',
            TABLE_NEWSLETTER = 'newsletter',
            COLUMN_ID = 'id',
            COLUMN_TITLE = 'title',
            COLUMN_CONTENT = 'content',
            COLUMN_ARTICLES_ID = 'articles_id',
            COLUMN_GALLERY_ID = 'gallery_id',
            COLUMN_NAME = 'name',
            COLUMN_EMAIL = 'email',
            COLUMN_DESCRIPTION = 'description',
            COLUMN_ALBUM_ID = 'album_id',
            COLUMN_URL = 'url',
            COLUMN_URL_THUMB = 'url_thumb',
            COLUMN_CONFIRMED = 'confirmed',
            COLUMN_TOKEN = 'token',
            COLUMN_CREATOR = 'creator',
            COLUMN_CREATED_AT = 'created_at',
            COLUMN_EDITOR = 'editor',
            COLUMN_EDITED_AT = 'edited_at';

    /** @var Nette\Database\Context */
    private $database;
    
    /** @var App\Model\FileManager */
    private $fileManager;
    
    /** @var App\Model\EmailManager */
    private $emailManager;
    
    /** @var App\Model\GalleryManager */
    private $galleryManager;
    
    public function __construct(Nette\Database\Context $database,
                                FileManager $fileManager,
                                EmailManager $emailManager,
                                GalleryManager $galleryManager) {
            $this->database = $database;
            $this->fileManager = $fileManager;
            $this->emailManager = $emailManager;
            $this->galleryManager = $galleryManager;
    }

    /*
     * Load articles from db
     */

    public function getArticles(): Nette\Database\Table\Selection {

        return $this->database->table('articles')
                        ->where('created_at < ?', time())
                        ->order('created_at DESC');
    }

    /**
     * Adds new article and upload images
     * @param type $logged_user
     * @param type $values
     * @throws ArticleException
     */
    public function add($logged_user, $values): void {

        try {

            // insert article details into db
            $insertArticle = $this->database->table(self::TABLE_ARTICLES)->insert([
                self::COLUMN_TITLE => $values->title,
                self::COLUMN_CONTENT => $values->content,
                self::COLUMN_CREATOR => $logged_user->getIdentity()->getData()['email'],
                self::COLUMN_CREATED_AT => time()
            ]);
            
            // get last id
            $lastArticleId = $insertArticle->id;
        } catch (\Exception $e) {
            throw new ArticleException('Chyba při ukládání článku! (detail - \App\Model\ArticleManeger::add()->insertArticle ' . $e->getMessage() . ')');
        }

        // upload and insert details into db
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
                    throw new ArticleException('Chyba při uploadu souboru ' . $filename . ' (detail - \App\Model\ArticleManeger::add()->uploadImage())' . $e->getMessage());
                }

                // insert details into db
                try {

                    $insertImage = $this->database->table(self::TABLE_GALLERY)->insert([
                        self::COLUMN_NAME => $filename,
                        self::COLUMN_DESCRIPTION => $formImage->description,
                        self::COLUMN_ALBUM_ID => $formImage->album_id,
                        self::COLUMN_URL => $url,
                        self::COLUMN_URL_THUMB => $urlThumb,
                        self::COLUMN_CREATOR => $logged_user->getIdentity()->getData()['email'],
                        self::COLUMN_CREATED_AT => time()
                    ]);
                    $lastImageId = $insertImage->id;
                } catch (\Exception $e) {
                    throw new ArticleException('Chyba při ukládání obrázku do databáze (detail - \App\Model\ArticleManeger::add()->insertImage)' . $e->getMessage());
                }

                // insert IMAGE_ID and ARTICLE_ID into db
                try {

                    $insertArticeImage = $this->database->table(self::TABLE_ARTICLES_GALLERY)->insert([
                        self::COLUMN_ARTICLES_ID => $lastArticleId,
                        self::COLUMN_GALLERY_ID => $lastImageId
                    ]);
                } catch (\Exception $e) {
                    throw new ArticleException('Chyba při ukládání aktuality a obrázku do databáze (detail - \App\Model\ArticleManeger::add()->insertArticleImage)' . $e->getMessage());
                }
            }
        }

        // send newsletter
        try {

            $this->emailManager->sendNewsleter($lastArticleId);
        } catch (\Exception $e) {
            throw new NewsletterException('Chyba při odeslání newsletru! (detail - \App\Model\ArticleManeger::add())' . $e->getMessage());
        }
    }

    /**
     * Edit article and images
     * @param type $logged_user
     * @param type $values
     * @param type $articleId
     * @throws ArticleException
     */
    public function edit($logged_user, $values, $articleId): void {

        // update article details
        try {

            $article = $this->database->table('articles')->get($articleId);
            $article->update([self::COLUMN_TITLE => $values->title,
                self::COLUMN_CONTENT => $values->content,
                self::COLUMN_EDITOR => $logged_user->getIdentity()->getData()['email'],
                self::COLUMN_EDITED_AT => time()
            ]);
        } catch (\Exception $e) {
            throw new ArticleException('Chyba při ukládání článku do db! (detail - \App\Model\ArticleManeger::edit())' . $e->getMessage());
        }

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
                    throw new ArticleException('Chyba při uploadu souboru (detail - \App\Model\ArticleManeger::add()->uploadImage())' . $e->getMessage());
                }

                // insert details into db
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
                    throw new ArticleException('Chyba při ukládání souboru do db (detail - \App\Model\ArticleManeger::add()->upload())' . $e->getMessage());
                }

                // insert IMAGE_ID and ARTICLE_ID into db
                try {
                    $insertArticeImage = $this->database->table(self::TABLE_ARTICLES_GALLERY)->insert([
                        self::COLUMN_ARTICLES_ID => $articleId,
                        self::COLUMN_GALLERY_ID => $insertImage->id
                    ]);
                } catch (\Exception $e) {
                    throw new ArticleException('Chyba při ukládání aktuality a obrázku do databáze (detail - \App\Model\ArticleManeger::add()->insertArticleImage)' . $e->getMessage());
                }
            }
        }
    }

    /**
     * Add newsletter
     * @param type $email
     * @throws ArticleException
     */
    public function newsletter($values): void {

        $token = sha1('confirm_time' . time());

        Nette\Utils\Validators::assert($values->email, 'email');

        try {

            $this->emailManager->sendNewsleterRegistration($values->email, $token);
        } catch (\Exception $e) {
            throw new NewsletterException('Chyba při registraci emailu! (detail - \App\Model\ArticleManeger::newsletter())' . $e->getMessage());
        }
    }
}

class ArticleException extends \Exception {}
class NewsletterException extends \Exception {}
