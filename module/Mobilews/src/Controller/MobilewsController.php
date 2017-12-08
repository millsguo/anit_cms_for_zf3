<?php

namespace Mobilews\Controller;

use Fichiers\Model\Fichiers;
use Fichiers\Model\Fichiersdao;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Rubrique\Model\RubriqueDao;
use Uploadmgmt\Model\Uploadmgmtdao;
use Siteprivate\Model\SiteprivateDao;
use Uploadmgmt\Fileupload;
use ExtLib\Utils;
use ExtLib\MCrypt;
use Privatespacelogin\Model\PrivatespaceloginDao;
use ExtLib\FileManager;

class MobilewsController extends AbstractActionController
{
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
            $utils = new Utils();
            $mcrypt = new MCrypt();
            $privatespaceloginDao = new PrivatespaceloginDao();

            //token has to be provided
            $mySpaceToken = $request->getPost('token');
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
            $error = $this->translator->translate('Veuillez rafraichir la page et recommencer svp.');
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
        $uploadmgmtdao = new Uploadmgmtdao();
        $filesDao = new Fichiersdao();
        $request = $this->getRequest();

        if ($request->isPost()) {

            /** File * */
            $outils = new FileManager();

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
                        $thumbname = "thumb" . $_FILES['newfile']['name'];
                        //a thumbnail is created only if it is a jpeg or a png image
                        if (in_array(strtolower($extension), array('jpg', 'jpeg', 'png')) == true) {
                            $thumbnailfilename = $outils->reduit_fichier($resultUpload["filename"][1], $thumbname, 150, 200, $this->path, $this->path, ""); //Redimensionnement vignette
                        }
                        $this->savethumbnailpath = $this->savepath;
                    } elseif (in_array(strtolower($extension), FilesCategories::$wordList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfile'], $this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbnailfilename = FilesCategories::$wordImg;
                        $this->savethumbnailpath = 'img/';
                    } elseif (in_array(strtolower($extension), FilesCategories::$documentList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfile'], $this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbnailfilename = FilesCategories::$documentImg;
                        $this->savethumbnailpath = 'img/';
                    } elseif (in_array(strtolower($extension), FilesCategories::$excelList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfile'], $this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbnailfilename = FilesCategories::$excelImg;
                        $this->savethumbnailpath = 'img/';
                    } elseif (in_array(strtolower($extension), FilesCategories::$audioList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfile'], $this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbnailfilename = FilesCategories::$audioImg;
                        $this->savethumbnailpath = 'img/';
                    } elseif (in_array(strtolower($extension), FilesCategories::$videoList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfile'], $this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbnailfilename = FilesCategories::$videoImg;
                        $this->savethumbnailpath = 'img/';
                    } elseif (in_array(strtolower($extension), FilesCategories::$presentationList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfile'], $this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbnailfilename = FilesCategories::$presentationImg;
                        $this->savethumbnailpath = 'img/';
                    } elseif (in_array(strtolower($extension), FilesCategories::$archiveList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfile'], $this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbnailfilename = FilesCategories::$archiveImg;
                        $this->savethumbnailpath = 'img/';
                    }

                    if ($resultUpload["filename"][0] == true) {

                        //if ($resultUpload["deleteExisting"][0] == true) {
                        //    $filesDao->deleteFichiersByFilename($resultUpload["deleteExisting"][1]);
                        //}
                        if ($resultUpload["renameExisting"][0] == true) {
                            $file = new Fichiers();
                            $file = $filesDao->getFichiersByFilename($resultUpload["filename"][1]);
                            $file->setNom($resultUpload["renameExisting"][1]);
                            $filesDao->saveFichiersFilename($file);
                        }

                        $fileuploaded = $resultUpload["filename"][1];
                        $file = new Fileupload();

                        $file->setType($extension);
                        //$file['fichiers_nom'] = $_FILES['newfile']['name'];
                        //mecanique pour le nom du ficher
                        $file->setName($fileuploaded);
                        $file->setPath($this->savepath);
                        $file->setThumbnail($thumbnailfilename);
                        $file->setThumbnailpath($this->savethumbnailpath);
                        $file->setComment($utils->stripTags_replaceHtmlChar_trim($request->getPost('comment'), true, true, true));
                        $file->setAuthor($utils->stripTags_replaceHtmlChar_trim($request->getPost('author'), true, true, true));
                        $file->setDate(time());
                        $file->setEmail($utils->stripTags_replaceHtmlChar_trim($request->getPost('email'), true, true, true));
                        $file->setUserid($utils->stripTags_replaceHtmlChar_trim($request->getPost('userid'), true, true, true));
                        $file->setLat($utils->stripTags_replaceHtmlChar_trim($request->getPost('lat'), true, true, true));
                        $file->setLng($utils->stripTags_replaceHtmlChar_trim($request->getPost('lng'), true, true, true));
                        $status = int($request->getPost('status'));

                        if($status<0 && $status >2){
                            $this->response->setStatusCode(500);
                            return new JsonModel(array(
                                'error' => $this->translator->translate("Le statut envoyé n'est pas correct")
                            ));
                        } else {
                            $file->setStatus($status);
                        }

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
        }
    }

}
