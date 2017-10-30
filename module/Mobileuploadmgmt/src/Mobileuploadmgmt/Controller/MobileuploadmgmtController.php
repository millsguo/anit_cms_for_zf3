<?php
namespace Mobileuploadmgmt\Controller;

use Mobileuploadmgmt\Model\Photosmgmtdao;
use Mobileuploadmgmt\Model\Photosmgmt;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use ExtLib\Utils;

class MobileuploadmgmtController extends AbstractActionController {

    protected $sousrubriqueDao;
    protected $rubriqueDao;
    protected $translator;
    protected $path = 'public/filesbank/';
    protected $paththumbnails = 'public/filesbank/thumbnails/';

    public function indexAction() {
        $Photosmgmtdao = new Photosmgmtdao();
        return new ViewModel(array(
            'photos' => $Photosmgmtdao->getPhotoAValider()
        ));
    }

    public function valideeAction() {
        $Photosmgmtdao = new Photosmgmtdao();
        return new ViewModel(array(
            'photos' => $Photosmgmtdao->getPhotoValidees()
        ));
    }

    public function rotaterightAction() {
        $idPhoto = (int) $this->params()->fromRoute('id', 0);
        $Photosmgmt = new Photosmgmt();
        $Photosmgmt->photoRotate($idPhoto, -90);
        return new JsonModel(array(
            'etat' => 'ok',
        ));
    }

    public function rotateleftAction() {
        $idPhoto = (int) $this->params()->fromRoute('id', 0);
        $Photosmgmt = new Photosmgmt();
        $Photosmgmt->photoRotate($idPhoto, 90);
        return new JsonModel(array(
            'etat' => 'ok',
        ));
    }

    public function setvaliderAction() {
        $idPhoto = (int) $this->params()->fromRoute('id', 0);
        $Photosmgmt = new Photosmgmt();
        $Photosmgmt->photoChangeEtat($idPhoto, 'Valide');
        return new JsonModel(array(
            'etat' => 'ok',
        ));
    }

    public function setsupprimerAction() {
        $idPhoto = (int) $this->params()->fromRoute('id', 0);
        $Photosmgmt = new Photosmgmt();
        $Photosmgmt->photoChangeEtat($idPhoto, 'Supprimer');
        return new JsonModel(array(
            'etat' => 'ok',
        ));
    }

    public function updateAction() {
        $idPhoto = abs((int) $this->params()->fromRoute('id', 0));
        $commenter = $this->params()->fromPost('commenter');
        $status = $this->params()->fromPost('status');
        $Photosmgmtdao = new Photosmgmtdao();
        $Photosmgmtdao->update($idPhoto, array('commenter' => $commenter));
        if ($status == 0) {
            return $this->redirect()->toRoute(
                            'Photosmgmt', array(
                        'action' => 'index'
                            )
            );
        }
        return $this->redirect()->toRoute(
                        'Photosmgmt', array(
                    'action' => 'validee'
                        )
        );
    }

    /**
     * Public actions that has been used by the mobile app maccas
     */
    public function configurationAction() {
        //$urlConfiguration = "http://" . $_SERVER['SERVER_NAME'] . substr($_SERVER["REQUEST_URI"], 0, strrpos($_SERVER["REQUEST_URI"], '/')) . "/";
        $urlConfiguration = "http://" . $_SERVER['SERVER_NAME'];
        //var_dump($urlConfiguration);
        $uri = substr($_SERVER["REQUEST_URI"], 0, strrpos($_SERVER["REQUEST_URI"], '/')) . "/";
        //var_dump($uri);
        $uri = str_replace("/public/photosmgmt", "", $uri);
        $urlConfiguration=$urlConfiguration.$uri;
               
        if (!empty($urlConfiguration)) {
            $returnConfig = array();
            $returnConfig['Statut'] = true;
            $returnConfig['Url']['Vignette'] = $urlConfiguration . $this->paththumbnails;
            $returnConfig['Url']['Image'] = $urlConfiguration . $this->path;

            //return new JsonModel($returnConfig);
            return $this->getResponse()->setContent(json_encode($returnConfig));
        } else {
            return $this->getResponse()->setContent(json_encode(array('Statut' => false, 'Erreur' => array('code' => 503, 'message' => 'You need to set Configration path to get images'))));
        }
    }

    public function photolocationAction() {

        /* //useless
          $bodyhttpget = @file_get_contents('php://input');
          if ($bodyhttpget) {
          $json_value = json_decode($bodyhttpget, true);
          }
         * 
         */

        $Photosmgmtdao = new Photosmgmtdao();
        $result = $Photosmgmtdao->photoLocation();

        if (!$result) {
            return $this->getResponse()->setContent(json_encode(array('Statut' => false, 'Erreur' => array('code' => 503, 'message' => 'Empty rows'))));
        } else {
            $returnlocation = array();
            $returnlocation['Statut'] = true;
            $i = 0;
            foreach ($result as $row) {
                $returnlocation['PhotoLocations'][$i]['PhotoId'] = $row['photoId'];
                $returnlocation['PhotoLocations'][$i]['Latitude'] = $row['lat'];
                $returnlocation['PhotoLocations'][$i]['Longitude'] = $row['lng'];
                $i++;
            }

            return $this->getResponse()->setContent(json_encode($returnlocation));
        }
    }

    public function getallphotosAction() {

        $Photosmgmtdao = new Photosmgmtdao();

        $json_value = array();
        $start = 0;
        $mid ="";

        $bodyhttpget = @file_get_contents('php://input');
        if ((bool) $bodyhttpget == true) {
            $json_value = json_decode($bodyhttpget, true);
        } else {
            $json_value['page'] = '1';
        }

        if ($json_value['page'] == '1' || $json_value['page'] < 1) {
            $start = 0;
        } else {
            $start = ($json_value['page'] - 1 ) * 30;
        }

        if (isset($json_value['photoIds']) && !empty($json_value['photoIds'])) {

            $mid = ' and p.photoId IN(' . implode(',', $json_value['photoIds']) . ') ';
        }

        $result = $Photosmgmtdao->getAllPhotos($mid, $start);

        if (!$result) {
            return $this->getResponse()->setContent(json_encode(array('Statut' => false, 'Erreur' => array('code' => 502, 'message' => 'Empty rows'))));
        } 
        else {
            $returnPhotos = array();
            $CommunityPhotos = array();

            $returnPhotos['Statut'] = true;

            foreach ($result as $row) {
                $rows['Date'] = date('Y-m-d', strtotime($row['Date']));
                $rows['ID'] = $row['ID'];
                $rows['Vignette'] = $row['Vignette'];
                $rows['Image'] = $row['Image'];
                $rows['Commenter'] = $row['Commenter'];
                $rows['Auteur'] = $row['Auteur'];
                $rows['Date'] = $row['Date'];
                $rows['GPS']['Latitude'] = $row['lat'];
                $rows['GPS']['Longitude'] = $row['lng'];
                $CommunityPhotos[] = $rows;
            }

            $returnPhotos['CommunityPhotos'] = $CommunityPhotos;

            return $this->getResponse()->setContent(json_encode($returnPhotos));
        }
    }

    public function uploadphotoAction() {
        
        $Photosmgmtdao = new Photosmgmtdao();
        $bodyhttpget = @file_get_contents('php://input');
        
        if ((bool)$bodyhttpget == false) {
            return $this->getResponse()->setContent(json_encode(array('Statut' => false, 'Erreur' => array('code' => 502, 'message' => 'Request Null'))));
        }
        
        $json_value = json_decode($bodyhttpget, true);
        
        if (empty($json_value['Image'])) {
            return $this->getResponse()->setContent(json_encode(array('Statut' => false, 'Erreur' => array('code' => 505, 'message' => 'Empty Image'))));
           
        }
        if (empty($json_value['Auteur'])) {
            return $this->getResponse()->setContent(json_encode(array('Statut' => false, 'Erreur' => array('code' => 506, 'message' => 'Empty Auteur'))));
        }
        if (!empty($json_value['ID'])) {
            $time = time();
            $filename = $json_value['ID'] . '_' . $time . ".jpg";
            $imagepath = $this->path . $json_value['ID'] . '_' . $time . ".jpg";
            $thaimagepath = $this->paththumbnails . $json_value['ID'] . '_' . $time . ".jpg";
            $thump_width = 125;
            $ext = "image/jpeg";
            $content = base64_decode($json_value['Image']);
            $img = imagecreatefromstring($content);
            imagejpeg($img, $imagepath, 100);
            $width = imagesx($img);
            $height = imagesy($img);
            $new_width = $thump_width;
            $new_height = floor($height * ($thump_width / $width));
            $tmp_img = imagecreatetruecolor($new_width, $new_height);
            imagecopyresized($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            imagejpeg($tmp_img, $thaimagepath, 100);
            imagedestroy($tmp_img);
            imagedestroy($img);
            
            $insertPhoto = $Photosmgmtdao->addPhoto($filename, $ext, $json_value);
            
            if (!$insertPhoto) {
                return $this->getResponse()->setContent(json_encode(array('Statut' => false, 'Erreur' => array('code' => 500, 'message' => 'Error in Uploading Photos'))));
            } else {
                return $this->getResponse()->setContent(json_encode(array('Statut' => true)));              
            }
        } 
        else {
            return $this->getResponse()->setContent(json_encode(array('Statut' => false, 'Erreur' => array('code' => 501, 'message' => 'Empty Image id'))));
        }
    }
    
    public function backtooriginalAction(){
        
        $photosmgmtdao = new Photosmgmtdao();
        $idPhoto = (int) $this->params()->fromRoute('id', 0);
        $photo = $photosmgmtdao->getPhoto($idPhoto);
        $photosmgmt = new Photosmgmt();
        $result = $photosmgmt->photoBackToOriginal($photo['Image'], $photo['Vignette']);
        
        return $this->getResponse()->setContent(json_encode($result));
    }

}
