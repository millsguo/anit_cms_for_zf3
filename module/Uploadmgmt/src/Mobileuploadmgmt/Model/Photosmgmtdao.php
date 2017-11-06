<?php

namespace Photosmgmt\Model;

//use Sousrubrique\Model\Sousrubrique;
use Application\DBConnection\DBConnection;

class Photosmgmtdao {

    protected $dbGateway;

    public function __construct() {
        //put code to instantiate db connection
        $DB = new DBConnection();
        $this->dbGateway = $DB->DBConnect();
    }

    public function getPhoto($idPhoto = 0) {
        $requete = $this->dbGateway->prepare('SELECT * FROM photo WHERE photoId=' . abs((int) $idPhoto)) or die(print_r($this->dbGateway->error_info()));
        $requete->execute();
        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);
        //die('<pre>'.print_r($requete2,true).'</pre>');
        return $requete2;
    }

    public function getPhotoAValider() {
        $requete = $this->dbGateway->prepare('SELECT * FROM photo p WHERE p.status=0 ORDER BY p.Date DESC') or die(print_r($this->dbGateway->error_info()));
        $requete->execute();
        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);
        return $requete2;
    }

    public function getPhotoValidees() {
        $requete = $this->dbGateway->prepare('SELECT * FROM photo p WHERE p.status=1 ORDER BY p.Date DESC') or die(print_r($this->dbGateway->error_info()));
        $requete->execute();
        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);
        return $requete2;
    }

    public function setEtat($idPhoto = 0, $status = 0) {
        $status = abs((int) $status);
        $idPhoto = abs((int) $idPhoto);
        if ($status < 1)
            die('Status non autoris� ' . __LINE__);
        if ($idPhoto < 1)
            die('numero de photo invalide ' . __LINE__);
        $sql = 'UPDATE photo SET status=' . $status . ' WHERE photoId=' . $idPhoto;
        $requete = $this->dbGateway->prepare($sql) or die(print_r($this->dbGateway->error_info()));
        $reqIsOK = $requete->execute();
        return $reqIsOK;
    }

    public function update($idPhoto = 0, $params = array()) {
        $idPhoto = abs((int) $idPhoto);
        if ($idPhoto < 1)
            die('numero de photo invalide ' . __LINE__);
        $sql = 'UPDATE photo SET commenter=:commenter WHERE photoId=:idPhoto';
        $requete = $this->dbGateway->prepare($sql) or die(print_r($this->dbGateway->error_info()));
        $reqIsOK = $requete->execute(array(
            'commenter' => $params['commenter'],
            'idPhoto' => $idPhoto
        ));
        return $reqIsOK;
    }
    
    public function photoLocation(){
        $sql = "SELECT photoId, lat, lng FROM photo where status=1 and lat!=''";
        $requete = $this->dbGateway->prepare($sql)or die(print_r($this->dbGateway->error_info()));
        $reqIsOK = $requete->execute();
        
        if($reqIsOK){
            $result = $requete->fetchAll(\PDO::FETCH_ASSOC);
            
            if(count($result)>0){
               return $result; 
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }
    
    public function getAllPhotos($sqlpart, $start){
        
        $sql = "SELECT p.ID, p.Vignette, p.Image, p.Commenter, p.Auteur, p.Date, p.lat, p.lng "
                . "FROM photo p where status=1 " . $sqlpart. " "
                . "ORDER BY p.Date DESC "
                . "LIMIT " . $start . ", 30";

        $requete = $this->dbGateway->prepare($sql)or die(print_r($this->dbGateway->error_info()));
        $reqIsOK = $requete->execute();
        
        if ($reqIsOK) {
            
            $result = $requete->fetchAll(\PDO::FETCH_ASSOC);
            
            if(count($result)>0){
               return $result; 
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }
    
    public function addPhoto($filename, $ext, $json_value){
        $sql ="INSERT INTO photo SET Image='" . $filename . "', ext='" . $ext . "', Commenter='" . $json_value['Commenter'] . "', status=0, Vignette='" . $filename . "', Auteur='" . $json_value['Auteur'] . "', NIA='" . $json_value['NIA'] . "', Email='" . $json_value['Email'] . "', ID='" . $json_value['ID'] . "', lat='" . $json_value['GPS']['Latitude'] . "', lng='" . $json_value['GPS']['Longitude'] . "'";
        $requete = $this->dbGateway->prepare($sql)or die(print_r($this->dbGateway->error_info()));
        $reqIsOK = $requete->execute();
        
        if($reqIsOK && $requete->rowCount()>0){
            return true;
        }
        else{
            return false;
        }
    }

}
