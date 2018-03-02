<?php

namespace Uploadmgmt\Controller;

use Uploadmgmt\Model\FileuploadStatus;
use Uploadmgmt\Model\Uploadmgmtdao;
use Uploadmgmt\Model\Photosmgmt;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Mvc\I18n\Translator;
use Application\Factory\CacheDataListener;

class UploadmgmtController extends AbstractActionController
{
    public static $path = 'uploadedfilesbank/';
    public static $paththumbnails = 'uploadedfilesbank/thumbnails/';

    protected $translator;
    protected $cache;

    public function __construct(CacheDataListener $cacheDataListener, Translator $translator)
    {
        $this->cache = $cacheDataListener;
        $this->translator = $translator;
    }

    public function indexAction()
    {

        $photosmgmtdao = new Uploadmgmtdao();
        return new ViewModel(array(
            'photos' => $photosmgmtdao->getPhotoWaitStatus()
        ));
    }

    public function validatedfilesAction()
    {
        $photosmgmtdao = new Uploadmgmtdao();
        return new ViewModel(array(
            'photos' => $photosmgmtdao->getPhotoValidateStatus()
        ));
    }

    public function rotaterightAction()
    {
        $idPhoto = (int)$this->params()->fromRoute('id', 0);
        $Photosmgmt = new Photosmgmt();
        if ($Photosmgmt->photoRotate($idPhoto, -90)) {
            return new JsonModel(array(
                'status' => 'ok'
            ));
        } else {
            $this->response->setStatusCode(500);
            return new JsonModel(array(
                'error' => $this->util->translate('erreur format de fichier'))
            );
        }
    }

    public function rotateleftAction()
    {
        $idPhoto = (int)$this->params()->fromRoute('id', 0);
        $Photosmgmt = new Photosmgmt();
        $Photosmgmt->photoRotate($idPhoto, 90);
        return new JsonModel(array(
            'status' => 'ok'
        ));
    }

    public function validatefileAction()
    {
        $idPhoto = (int)$this->params()->fromRoute('id', 0);
        $uploadfilemgmtDao = new Uploadmgmtdao();
        $uploadfilemgmtDao->updateStatus($idPhoto, FileuploadStatus::$VALIDATED);
        return new JsonModel(array(
            'status' => 'ok',
        ));
    }

    public function deletefileAction()
    {
        $idFile = (int)$this->params()->fromRoute('id', 0);
        $photosmgmt = new Photosmgmt();
        $fileuploadmgmtdao = new Uploadmgmtdao();
        if (!isset($idFile) || ($idFile < 1)) {
            return $this->getResponse()->setContent(json_encode(array('status' => false, 'error' => array('code' => 502, 'message' => 'numéro de photo invalide ou Statut non autorisé'))));
        }

        if ($fileuploadmgmtdao->updateStatus($idFile, FileuploadStatus::$REFUSED)) {
            $file = $fileuploadmgmtdao->getPhoto($idFile);
            $photosmgmt->deleteFile('public/' . $file['path'] . '/' . $file['name']);
            $photosmgmt->deleteFile('public/' . $file['thumbnailpath'] . '/' . $file['thumbnail']);
            $photosmgmt->deleteOriTypePhoto('public/' . $file['path'], $file['name']);
            $photosmgmt->deleteOriTypePhoto('public/' . $file['thumbnailpath'], $file['thumbnail']);
            $fileuploadmgmtdao->updateStatus($idFile, FileuploadStatus::$REFUSED);
        } else {
            //TODO set http status to 502
            return $this->getResponse()
                ->setContent(json_encode(array('status' => false, 'error' => array('code' => 502, 'message' => 'ko'))));
        }
        return new JsonModel(array(
            'status' => 'ok',
        ));
    }

    public function updateAction()
    {
        $idPhoto = (int)$this->params()->fromRoute('id', 0);
        $commenter = $this->params()->fromPost('commenter');
        $status = $this->params()->fromPost('status');
        $photosmgmtdao = new Uploadmgmtdao();
        //TODO manage error
        $photosmgmtdao->updateComment($idPhoto, array('commenter' => $commenter));
        $action = 'index';
        if (strcmp($status, FileuploadStatus::$VALIDATED) == 0) {
            $action = 'validatedfiles';
        }
        return $this->redirect()->toRoute(
            'Uploadmgmt', array(
                'action' => $action
            )
        );
    }

    public function backtooriginalAction()
    {
        $photosmgmtdao = new Uploadmgmtdao();
        $idPhoto = (int)$this->params()->fromRoute('id', 0);
        $photo = $photosmgmtdao->getPhoto($idPhoto);
        $photosmgmt = new Photosmgmt();

        //TODO manage error and apply http status 502
        $result = $photosmgmt->photoBackToOriginal($photo);

        return $this->getResponse()->setContent(json_encode($result));
    }

}
