<?php

namespace Device\Model;

use Device\Model\Device;
use Application\DBConnection\DBConnection;

class Devicedao {

    private $dbGateway;

    public function __construct() {
        //put code to instantiate db connection
        $DB = new DBConnection();
        $this->dbGateway = $DB->DBConnect();
    }

    public function addDevice(Device $device) {

        $requete = $this->dbGateway->prepare("INSERT into deviceregistration
                (device_publicid, device_devicetoken, device_userid, device_type,
                device_createdon, device_modifiedon)
                values(:publicid, :token, :userid, :type, :createdon, :modifiedon)")
                or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'publicid' => $device->getPublicid(),
            'token' => $device->getDevicetoken(),
            'userid' => $device->getUserid(),
            'type' => $device->getType(),
            'createdon' => $device->getCreatedon(),
            'modifiedon' => $device->getModifiedon()
        ));
        
        $rowCount = $requete->fetchColumn();
        
        return $rowCount;
    }

    public function updateDevice(Device $device) {
        $requete = $this->dbGateway->prepare("UPDATE deviceregistration
                SET device_publicid =:publicid, 
                device_devicetoken=:token, 
                device_userid= :userid, 
                device_type=:type,
                device_createdon=:createdon,
                device_modifiedon =:modifiedon 
                WHERE device_publicid =:publicid")
                or die(print_r($this->dbGateway->error_info()));
        
        $requete->execute(array(
            'publicid' => $device->getPublicid(),
            'token' => $device->getDevicetoken(),
            'userid' => $device->getUserid(),
            'type' => $device->getType(),
            'createdon' => $device->getCreatedon(),
            'modifiedon' => $device->getModifiedon()
        ));
        
        $rowCount = $requete->fetchColumn();
        
        return $rowCount;
        
    }

    public function getDevicetestToken($deviceType, $token, $userid) {

        $sql = "";

        if ($deviceType == 1) {
            $sql = "select device_publicid from deviceregistration where device_userid= :userid LIMIT 1";
        } 
        else {
            $sql = "select device_publicid from deviceregistration where device_devicetoken= :token LIMIT 1";
        }

        $request = $this->dbGateway->prepare($sql)or die(print_r($this->dbGateway->error_info()));
        
        if ($deviceType == 1) {
            $request->execute(array(
                "userid"=>$userid
            ));
        }
        else{
            $request->execute(array(
                "token"=>$token
            ));
        }
        
        $result = $request->fetch(\PDO::FETCH_ASSOC);
        
        return $result;
    }

    //Creer un public id et verifier qu'il n'a pas deja a ete cree
    public function createRandomId() {
        
        $genId = $this->generateRandomString();
        $rowCount = $this->isPublicIdExist($genId);

        if ($rowCount == 0) {
            return $genId;
        } 
        else {
            return $this->createRandomId();
        }
    }
    
    //fonction de creation d'une string aleatoire - 30 caracteres separes par un - tous les 5 caracteres
    protected function generateRandomString($length = 30) {

        $original_string = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
        $original_string = implode("", $original_string);
        $creatdStr = substr(str_shuffle($original_string), 0, $length);

        return implode("-", str_split($creatdStr, 5));
    }

    
   protected function isPublicIdExist($publicId) {
        
        $sql = "SELECT device_publicid FROM deviceregistration WHERE device_publicid= :publicid;";
        //var_dump($sql);
        $request = $this->dbGateway->prepare($sql)or die(print_r($this->dbGateway->error_info()));
        $request->execute(array(
            'publicid'=>$publicId
        ));
        //var_dump($request);
	$request2 = $request->fetch(\PDO::FETCH_ASSOC);
        //$request2 = $request->fetch();
        if(!$request2){
           return 0;
        }
        else{
            $rowCount = $request->fetchColumn();
            return $rowCount;
        }
    }

}
