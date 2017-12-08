<?php

namespace Uploadmgmt\Controller;

use Uploadmgmt\Model\Uploadmgmtdao;
use Uploadmgmt\Model\Photosmgmt;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class UploadmgmtController extends AbstractActionController
{
    protected $path = 'public/uploadedfilesbank/';
    protected $paththumbnails = 'public/uploadedfilesbank/thumbnails/';

    protected $translator;
    protected $cache;
/*
    public function __construct(CacheDataListener $cacheDataListener, Translator $translator)
    {
        echo 'test1';
        $this->cache = $cacheDataListener;
        $this->translator = $translator;
        echo 'test2';
        //exit;
    }
*/
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
        $Photosmgmt->photoRotate($idPhoto, -90);
        return new JsonModel(array(
            'status' => 'ok'
        ));
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
        $Photosmgmt = new Photosmgmt();
        $Photosmgmt->photoChangeEtat($idPhoto, 'validate');
        return new JsonModel(array(
            'status' => 'ok',
        ));
    }

    public function deletefileAction()
    {
        $idPhoto = (int)$this->params()->fromRoute('id', 0);
        $Photosmgmt = new Photosmgmt();
        $Photosmgmt->photoChangeEtat($idPhoto, 'delete');
        return new JsonModel(array(
            'status' => 'ok',
        ));
    }

    public function updateAction()
    {
        $idPhoto = abs((int)$this->params()->fromRoute('id', 0));
        $commenter = $this->params()->fromPost('commenter');
        $status = $this->params()->fromPost('status');
        $photosmgmtdao = new Uploadmgmtdao();
        $photosmgmtdao->update($idPhoto, array('commenter' => $commenter));
        $action = 'index';
        if ($status == 1) {
            $action = validatephotos;
        }
        return $this->redirect()->toRoute(
            'uploadmgmt', array(
                'action' => $action
            )
        );
    }

    public function getallphotosAction()
    {
        $photosmgmtdao = new Uploadmgmtdao();

        $jsonValue = array();
        $start = 0;
        $mid = "";
        //Ok I agree, old fashion way to do the job...
        $bodyhttpget = @file_get_contents('php://input');
        if ((bool)$bodyhttpget == true) {
            $jsonValue = json_decode($bodyhttpget, true);
        } else {
            $json_value['page'] = '1';
        }

        if ($jsonValue['page'] == '1' || $jsonValue['page'] < 1) {
            $start = 0;
        } else {
            $start = ($jsonValue['page'] - 1) * 30;
        }

        if (isset($jsonValue['photoIds']) && !empty($jsonValue['photoIds'])) {

            $mid = ' and p.photoId IN(' . implode(',', $jsonValue['photoIds']) . ') ';
        }

        $result = $photosmgmtdao->getAllPhotos($mid, $start);

        if (!$result) {
            return $this->getResponse()->setContent(json_encode(array('status' => false, 'erroR' => array('code' => 502, 'message' => 'Empty rows'))));
        } else {
            $returnPhotos = array();
            $photos = array();

            $returnPhotos['Statut'] = true;

            foreach ($result as $row) {
                $rows['creationDate'] = date('Y-m-d', strtotime($row['creationDate']));
                $rows['id'] = $row['id'];
                $rows['thumbnail'] = $row['thumbnail'];
                $rows['name'] = $row['name'];
                $rows['comment'] = $row['comment'];
                $rows['author'] = $row['author'];
               // $rows['Date'] = $row['Date'];
                $rows['lat'] = $row['lat'];
                $rows['lng'] = $row['lng'];
                $photos[] = $rows;
            }

            $returnPhotos['photos'] = $photos;

            return $this->getResponse()->setContent(json_encode($returnPhotos));
        }
    }

    public function backtooriginalAction()
    {

        $photosmgmtdao = new Uploadmgmtdao();
        $idPhoto = (int)$this->params()->fromRoute('id', 0);
        $photo = $photosmgmtdao->getPhoto($idPhoto);
        $photosmgmt = new Photosmgmt();
        $result = $photosmgmt->photoBackToOriginal($photo['Image'], $photo['Vignette']);

        return $this->getResponse()->setContent(json_encode($result));
    }

}
