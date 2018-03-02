<?php

namespace Mobilews\Controller;

use Fichiers\Model\Fichiers;
use Fichiers\Model\Fichiersdao;
use Uploadmgmt\Controller\UploadmgmtController;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Rubrique\Model\RubriqueDao;
use Uploadmgmt\Model\Uploadmgmtdao;
use Siteprivate\Model\SiteprivateDao;
use Uploadmgmt\Model\Fileupload;
use ExtLib\Utils;
use ExtLib\MCrypt;
use Privatespacelogin\Model\PrivatespaceloginDao;
use ExtLib\FileManager;
use Zend\Mvc\I18n\Translator;
use Application\Factory\CacheDataListener;
use Fichiers\Model\FilesCategories;

class MobilewsController extends AbstractActionController
{

    private $cache;
    private $translator;
    protected $path;
    protected $paththumbnails;
    protected $savepath;

    public function __construct(CacheDataListener $cacheDataListener, Translator $translator)
    {
        $this->path = 'public/'.UploadmgmtController::$path;
        $this->paththumbnails = 'public/'.UploadmgmtController::$paththumbnails;
        $this->cache = $cacheDataListener;
        $this->translator = $translator;
    }

    /**
     * @return JsonModel
     *
     * input in json format :
     * username
     * password
     * token (the token is created when you create a private page)
     */
    public function authAction()
    {

        $request = $this->getRequest();

        if ($request->isPost()) {

            $siteprivateDao = new SiteprivateDao();
            $rubriqueDao = new RubriqueDao();

            $mcrypt = new MCrypt();
            $privatespaceloginDao = new PrivatespaceloginDao();

            //token has to be provided
            $mySpaceToken = $request->getPost('token');
            $utils = new Utils();
            $decypted = json_decode($mcrypt->decrypt($mySpaceToken));

            $page = $rubriqueDao->getRubriqueBySpaceToken($mySpaceToken, "object");
            $email = $utils->stripTags_replaceHtmlChar_trim($request->getPost('username'), true, true, false);
            $pwd = $utils->stripTags_replaceHtmlChar_trim($request->getPost('password'), true, true, false);

            $rowNb = $siteprivateDao->countLoginforAuthentication($decypted->spaceId, $email, $pwd);

            if ($rowNb == 0) {
                $error = $this->translator->translate('Veuillez recommencer le nom d\'utilisateur et/ou le mot de passe sont incorrects');
                $this->response->setStatusCode(401);
                return new JsonModel(array(
                    'error' => $error
                ));

            } elseif ($rowNb == 1) {

                $login = $privatespaceloginDao->getLoginByEmailAndPassword($email, $pwd);
                //TODO check number of row affected
                $privatespaceloginDao->updateLastConnection($login->getId());
                $pageNameArg = str_replace(".phtml", "", $page->getFilename());
                //var_dump($pageNameArg);
                //var_dump($decypted);
                //exit;
                $sessionData = array();
                $sessionData['loginId'] = $login->getId();
                $sessionData['loginEmail'] = $login->getEmail();
                $sessionData['spaceId'] = $decypted->spaceId;
                $sessionData['spaceName'] = $decypted->spaceName;
                $sessionData['pageName'] = $page->getFilename();
                $sessionData['pageId'] = $page->getId();
                //$sessionData['firstConnection'] = true;

                $loginaccess = new \Zend\Session\Container('myacl');
                $loginaccess->role = MyAclRoles::$GUEST;

                $loginaccess->userdata = $mcrypt->encrypt(
                    json_encode($sessionData));

                return new JsonModel(array(
                    'controller' => 'SitePrivate',
                    'action' => 'displayprivatepage',
                    'page' => $pageNameArg
                ));

            } else {
                $error = $this->translator->translate('Veuillez contacter l\'administrateur du site svp.');
                $this->response->setStatusCode(401);
                return new JsonModel(array(
                    'error' => $error
                ));
            }
        } else {
            $error = $this->translator->translate('Ce n\'est pas une requête POST');
            $this->response->setStatusCode(500);
            return new JsonModel(array(
                'error' => $error
            ));
        }
    }

    /**
     * TO DO identification
     * @return \Zend\View\Model\JsonModel
     * input in Post :
     * newfile(the file to upload)
     * comment (text)
     * author (text)
     * userid (text)
     * email (text)
     * lat (text)
     * lng (text)
     * status ('wait' => '0', 'validate' => '1', 'delete' => '2')
     *
     * by default the file uploaded will be renamed if a file with the same name already exists
     */
    public function uploadfileAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {

            $outils = new FileManager();
            $uploadmgmtdao = new Uploadmgmtdao();
            $filesDao = new Uploadmgmtdao();
            $savethumbnailpath = 'img';

            if ($_FILES['newfile']['name'] != "") {

                $extension = $outils->extractExtension($_FILES['newfile']['name']);
                $fichieruploaded = "";

                if (!is_uploaded_file($_FILES['newfile']['tmp_name'])) {

                    $error = $this->translator->translate("Le fichier est inaccessible");
                    $this->response->setStatusCode(500);
                    return new JsonModel(array(
                        'error' => $error
                    ));
                }

                // Test file size
                if ($_FILES['newfile']['size'] >= 10483760) {

                    $error = $this->translator->translate("La taille du fichier est supérieur à 10 Mo");
                    $this->response->setStatusCode(500);
                    return new JsonModel(array(
                        'error' => $error
                    ));
                }

                if (in_array(strtolower($extension), FilesCategories::$listeextension) == false) {
                    $error = $this->translator->translate("Le fichier doit avoir l\'extension") . " 'jpg','jpeg', 'png', 'bmp', 'doc', 'docx', 'rtf', 'txt', 'xls', 'xlsx', 
                    'ppt', 'pptx', 'pdf', 'epub', 'odt', 'ods', 'mp4', 'mkv', 'ogv', 'mp3', 'wav', 'ogg', 'gz', 'zip', 'tar'";
                    $this->response->setStatusCode(500);
                    return new JsonModel(array(
                        'error' => $error
                    ));
                } else {
                    $utils = new Utils();
                    $resultUpload = array();
                    $fichieruploaded = '';
                    $thumbnailfilename = '';

                    //By default if a file already exists, it will be renamed
                    if (in_array(strtolower($extension), FilesCategories::$imgList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfile'], $this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbname = "thumb";
                        $thumbname .= $outils->formatNameFile($_FILES['newfile']['name']);
                        //a thumbnail is created only if it is a jpeg or a png image
                        if (in_array(strtolower($extension), array('jpg', 'jpeg', 'png')) == true) {
                            $thumbnailfilename = $outils->reduit_fichier($resultUpload["filename"][1], $thumbname, 150, 200, $this->path, $this->paththumbnails, ""); //create thumbnail
                        }
                        $savethumbnailpath = UploadmgmtController::$paththumbnails;
                    } elseif (in_array(strtolower($extension), FilesCategories::$wordList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfile'], $this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbnailfilename = FilesCategories::$wordImg;
                        $savethumbnailpath = 'img/';
                    } elseif (in_array(strtolower($extension), FilesCategories::$documentList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfile'], $this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbnailfilename = FilesCategories::$documentImg;
                        $savethumbnailpath = 'img/';
                    } elseif (in_array(strtolower($extension), FilesCategories::$excelList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfile'], $this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbnailfilename = FilesCategories::$excelImg;
                        $savethumbnailpath = 'img/';
                    } elseif (in_array(strtolower($extension), FilesCategories::$audioList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfile'], $this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbnailfilename = FilesCategories::$audioImg;
                        $savethumbnailpath = 'img/';
                    } elseif (in_array(strtolower($extension), FilesCategories::$videoList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfile'], $this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbnailfilename = FilesCategories::$videoImg;
                        $savethumbnailpath = 'img/';
                    } elseif (in_array(strtolower($extension), FilesCategories::$presentationList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfile'], $this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbnailfilename = FilesCategories::$presentationImg;
                        $savethumbnailpath = 'img/';
                    } elseif (in_array(strtolower($extension), FilesCategories::$archiveList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfile'], $this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbnailfilename = FilesCategories::$archiveImg;
                        $savethumbnailpath = 'img/';
                    }

                    if ($resultUpload["filename"][0]) {

                        if ($resultUpload["renameExisting"][0] == true) {
                            $file = $filesDao->getFileByFilename($resultUpload["filename"][1]);
                            $file->setName($resultUpload["renameExisting"][1]);
                            $filesDao->saveFileupload($file);
                        }

                        $fileuploaded = $resultUpload["filename"][1];

                        $file = new Fileupload();
                        $file->setType($extension);
                        $file->setName($fileuploaded);
                        $file->setPath(UploadmgmtController::$path);
                        $file->setThumbnail($thumbnailfilename);
                        $file->setThumbnailpath($savethumbnailpath);
                        $file->setComment($utils->stripTags_replaceHtmlChar_trim($request->getPost('comment'), true, true, true));
                        $file->setAuthor($utils->stripTags_replaceHtmlChar_trim($request->getPost('author'), true, true, true));
                        $file->setEmail($utils->stripTags_replaceHtmlChar_trim($request->getPost('email'), true, true, true));
                        $file->setUserid($utils->stripTags_replaceHtmlChar_trim($request->getPost('userid'), true, true, true));
                        $file->setLat($utils->stripTags_replaceHtmlChar_trim($request->getPost('lat'), true, true, true));
                        $file->setLng($utils->stripTags_replaceHtmlChar_trim($request->getPost('lng'), true, true, true));
                        $file->setStatus($utils->stripTags_replaceHtmlChar_trim($request->getPost('status'), true, true, true));
                        $uploadmgmtdao->saveFileupload($file);

                        // Redirect to list of fichiers
                        return new JsonModel(array(
                            'status' => $this->translator->translate("OK")
                        ));
                    } else {
                        $error = $this->translator->translate("Une erreur est survenue sur le serveur");
                        $this->response->setStatusCode(500);
                        return new JsonModel(array(
                            'error' => $error
                        ));
                    }
                }
            } else {
                $error = $this->translator->translate("Aucun fichier n'est sélectionné");
                //print_r($error);
                //exit;
                $this->response->setStatusCode(500);
                return new JsonModel(array(
                    'error' => $error
                ));
            }
        } else {
            $error = $this->translator->translate('Ce n\'est pas une requête POST');
            $this->response->setStatusCode(500);
            return new JsonModel(array(
                'error' => $error
            ));
        }
    }
}
