<?php

namespace Confmgmt\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Confmgmt\Model\Confmgmt;
use Confmgmt\Form\ConfmgmtForm;
use Confmgmt\Form\Confmgmtinputfilter as InputFilter;
use Confmgmt\Model\Confmgmtdao;
use ExtLib\FileManager;
use ExtLib\Utils;

class ConfmgmtController extends AbstractActionController {

    protected $fichiersDao;
    
    protected $path = 'public/maccasconfig/';
    protected $savepath = 'maccasconfig/';
    protected $savethumbnailpath = 'img/';
    protected $translator;
    protected $jsonext = array("json");
    protected $jsonimg = "json.png";
    
    public function indexAction() {

        $this->fichiersDao = new Confmgmtdao();
        
        $fichiers = $this->fichiersDao->getAllFichiers("object");
            
        return new ViewModel(array(
            'fichiers' => $fichiers
        ));
    }

    // Add content to this method:
    public function addAction() {

        $form = new ConfmgmtForm();
        $this->fichiersDao = new Confmgmtdao();

        $form->get('submit')->setValue($this->translator->translate('Ajouter'));
        $request = $this->getRequest();

        if ($request->isPost()) {

            $fichiers = new Confmgmt();

            $form->setInputFilter(new InputFilter());

            /** File * */
            $outils = new FileManager();
            //print_r($this->path.$_FILES['newfichier']['name']);
            //exit;
            if ($_FILES['newfichier']['name'] != "") {

                $tmp_file = $_FILES['newfichier']['tmp_name'];
                $extension = $outils->extractExtension($_FILES['newfichier']['name']);
                
                $fichieruploaded = "";

                if (!is_uploaded_file($tmp_file)) {

                    $error = $this->translator->translate("Le fichier est introuvable");

                    return new ViewModel(array(
                        'form' => $form,
                        'error' => $error
                    ));
                }

                // Tester si le fichier n'est pas trop gros < 5Mo
                if ($_FILES['newfichier']['size'] >= 5242880) {

                    $error = $this->translator->translate("La taille du fichier est supérieur à 5 Mo");
                    //print_r($error);
                    //exit;
                    return new ViewModel(array(
                        'form' => $form,
                        'error' => $error
                    ));
                }

                if (in_array(strtolower($extension), $this->jsonext) == false) {

                    $error = $this->translator->translate("Le fichier doit avoir l\'extension")." json";
                    //print_r($error);
                    //exit;
                    return new ViewModel(array(
                        'form' => $form,
                        'error' => $error
                    ));
                } 
                else {
                    
                    $utils = new Utils();
                    $resultUpload = array();
                    $fichieruploaded = '';
                    $thumbnailfilename ='';

                    if(in_array(strtolower($extension), $this->jsonext)==true){
                        //Upload du fichier mais si nom identique alors renommer le fichier existant
                        //array("filename"=>$newNameFichier, "deleteExisting"=>$isDeleted,"renameExisting"=>$renameExisting);
                        $resultUpload = $outils->uploadfiles($_FILES['newfichier'], $this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbnailfilename = $this->jsonimg;
                        $this->savethumbnailpath = 'img/';
                    }
                    
                    if($resultUpload["filename"][0] == true){
                        
                        if($resultUpload["deleteExisting"][0] == true){
                            $this->fichiersDao->deleteFichiersByFilename($resultUpload["deleteExisting"][1]);
                        }
                        elseif($resultUpload["renameExisting"][0] == true){
                            $fichier = new Confmgmt();
                            $fichier = $this->fichiersDao->getFichiersByFilename($resultUpload["filename"][1]);
                            $fichier->setNom($resultUpload["renameExisting"][1]);
                            $this->fichiersDao->saveFichiersFilename($fichier);
                        }
                    
                        $fichieruploaded = $resultUpload["filename"][1];
                        $fichier = new Confmgmt();

                        $fichier->setId($request->getPost('id'));
                        $fichier->setType($extension);
                        //$fichier['fichiers_nom'] = $_FILES['newfichier']['name'];
                        $fichier->setNom($fichieruploaded);
                        $fichier->setChemin($this->savepath);
                        $fichier->setLibelle($utils->stripTags_replaceHtmlChar_trim($request->getPost('libelle'), true, true, true));
                        $fichier->setMetaData($utils->stripTags_replaceHtmlChar_trim($request->getPost('metadata'), true, true, true));
                        $fichier->setThumbnail($thumbnailfilename);
                        $fichier->setThumbnailpath($this->savethumbnailpath);      
                        $this->fichiersDao->saveFichiers($fichier);

                        // Redirect to list of fichiers
                        return $this->redirect()->toRoute('Confmgmt');
                    }
                    else{
                        
                        $error = $this->translator->translate("Une erreur est survenue sur le serveur");
                        return new ViewModel(array(
                            'form' => $form,
                            'error' => $error
                        ));
                    }
                   
                }
            } else {
                $error = $this->translator->translate("Aucun fichier n'est sélectionné");
                //print_r($error);
                //exit;
                return new ViewModel(array(
                    'form' => $form,
                    'error' => $error
                ));
            }
        }
        //print_r("no error");
        //			exit;
        return array(
            'form' => $form,
            'error' => "no error");
    }

    // Add content to this method:
    public function editAction() {

        $form = new ConfmgmtForm();
        $this->fichiersDao = new Confmgmtdao();

        $form->get('submit')->setValue($this->translator->translate('Modifier'));
        $id = (int) $this->params()->fromRoute('id', 0);
        /*
        if (!$id) {
            return $this->redirect()->toRoute('Fichiers', array(
                        'action' => 'add'
            ));
        }
        */
        $fichier = $this->fichiersDao->getFichiers($id);
        
        $fichierId = $fichier->getId();

        if(!empty($id)){
            if (empty($fichierId)) {
                //return $this->getResponse()->setStatusCode(404);
                return $this->notFoundAction();
            }
        }
        
        $form->get('id')->setAttribute('value', $fichier->getId());
        $form->get('libelle')->setAttribute('value', htmlentities($fichier->getLibelle(), ENT_NOQUOTES, "ISO8859-15"));
        $form->get('metadata')->setAttribute('value', $fichier->getMetaData());
        
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            
            $utils = new Utils();
            $form->setInputFilter(new InputFilter());

            /* Save contenu from filled form -> must add image path */
            $fichier = new Confmgmt();

            $fichier->setId($request->getPost('id'));
            $fichier->setLibelle($utils->stripTags_replaceHtmlChar_trim($request->getPost('libelle'), true, true, true));
            $fichier->setMetaData($utils->stripTags_replaceHtmlChar_trim($request->getPost('metadata'), true, true, true));
            $this->fichiersDao->saveFichiers($fichier);
            
            // Redirect to list of fichiers
            return $this->redirect()->toRoute('Confmgmt');
        }
        
        return array(
            'form' => $form,
            'error' => "no error");
    }

    public function deleteAction() {

        $this->fichiersDao = new Confmgmtdao();
        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('Confmgmt');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {
            $isDeleted = false;
            $fichier = new Confmgmt();

            $del = $request->getPost('del', $this->translator->translate('Non'));

            if ($del == $this->translator->translate('Oui')) {
                $id = (int) $request->getPost('id');
                $fichier = $this->fichiersDao->getFichiers($id);
                $isDeleted = $this->fichiersDao->deleteFichiers($id);
            }
            if ($isDeleted == true) {
                
                $outils = new FileManager();
                //fichier, chemin
                $outils->deleteFile($fichier->getNom(), 'public/' . $fichier->getChemin());
                $outils->deleteFile($fichier->getThumbnail(), 'public/' . $fichier->getThumbnailpath());
            }

            // Redirect to list of fichiers
            return $this->redirect()->toRoute('Confmgmt');
        }

        $fichiers = $this->fichiersDao->getFichiers($id);

        return array(
            'id' => $id,
            'fichiers' => $fichiers
        );
    }

}
