<?php
namespace Mobileuploadmgmt\Model;

use Mobileuploadmgmt\Model\Photosmgmtdao;

class Photosmgmt {

    protected $id;
    protected $libelle;
    protected $rang;
    protected $rubrique;
    protected $etat = array(
        'Attente' => '0',
        'Valide' => '1',
        'Supprimer' => '2',
    );

    public function __construct() {
        
    }

    public function photoRotate($idPhoto, $angle) {

        $phPath = 'public/filesbank/';
        $viPath = 'public/filesbank/thumbnails/';

        $Photosmgmtdao = new Photosmgmtdao();
        $photo = $Photosmgmtdao->getPhoto($idPhoto);
        $phName = $photo['Image'];
        $viName = $photo['Vignette'];

        $info = getimagesize($phPath . $phName);

        if ($info['mime'] == 'image/jpeg') {
            $imagePh = imagecreatefromjpeg($phPath . $phName);
            $imageVi = imagecreatefromjpeg($viPath . $viName);
        } elseif ($info['mime'] == 'image/png') {
            $imagePh = imagecreatefrompng($phPath . $phName);
            $imageVi = imagecreatefrompng($viPath . $viName);
        } else {
            die('erreur format de fichier');
        }

        $rotatePh = imagerotate($imagePh, $angle, 0);
        $rotateVi = imagerotate($imageVi, $angle, 0);

        $phOri = $phPath . substr($phName, 0, strrpos($phName, '.')) . '.Ori' . substr($phName, strrpos($phName, '.'));
        if (!is_file($phOri)) {
            $filter = new \Zend\Filter\File\Rename(array(
                "target" => $phOri,
                "overwrite" => false
            ));
            $filter->filter($phPath . $phName);
        }

        $viOri = $viPath . substr($viName, 0, strrpos($viName, '.')) . '.Ori' . substr($viName, strrpos($viName, '.'));
        if (!is_file($viOri)) {
            $filter = new \Zend\Filter\File\Rename(array(
                "target" => $viOri,
                "overwrite" => false
            ));
            $filter->filter($viPath . $viName);
        }

        // Enregistrement de l'image.
        if ($info['mime'] == 'image/jpeg') {
            imagejpeg($rotatePh, $phPath . $phName, 100);
            imagejpeg($rotateVi, $viPath . $viName, 100);
        }
        if ($info['mime'] == 'image/png') {
            imagepng($rotatePh, $phPath . $phName, 100);
            imagepng($rotateVi, $viPath . $viName, 100);
        }
    }

    public function photoChangeEtat($idPhoto, $statusName) {
        //die('<p>'.__FILE__.'('.__LINE__.')</p><pre>'.print_r($statusName,true).'</pre>');
        $statusId = 0;
        $idPhoto = (int) $idPhoto;
        if ($idPhoto < 1) {
            return false;
        }
        if (!isset($this->etat[$statusName])) {
            return false;
        }
        $statusId = $this->etat[$statusName];
        $Photosmgmtdao = new Photosmgmtdao();
        $Photosmgmtdao->setEtat($idPhoto, $statusId);
        return true;
    }

    public function photoBackToOriginal($phName, $viName) {

        try {

            $phPath = 'public/filesbank/';
            $viPath = 'public/filesbank/thumbnails/';

            $phOri = $phPath . substr($phName, 0, strrpos($phName, '.')) . '.Ori' . substr($phName, strrpos($phName, '.'));

            if (is_file($phOri)) {

                $this->deletePhoto($phPath . $phName);

                $filter = new \Zend\Filter\File\Rename(array(
                    "target" => $phPath . $phName,
                    "overwrite" => false
                ));

                $filterTxt = $filter->filter($phOri);
            }


            $viOri = $viPath . substr($viName, 0, strrpos($viName, '.')) . '.Ori' . substr($viName, strrpos($viName, '.'));

            if (is_file($viOri)) {

                $this->deletePhoto($viPath . $viName);

                $filter = new \Zend\Filter\File\Rename(array(
                    "target" => $viPath . $viName,
                    "overwrite" => false
                ));

                $filterTxt = $filter->filter($viOri);
            }

            return array("state" => "ok",
                "error" => "none");
        } 
        catch (\Exception $e) {
            return array("state" => "ko",
                "error" => $e);
        }
    }

    private function deletePhoto($pathToFile) {
        if (is_file($pathToFile)) {
            $unlinkTxt = unlink($pathToFile);
            return $unlinkTxt;
            //var_dump($unlinkTxt);
        }
    }

}
