<?php
namespace Device\Model;

class Device {
    
    private $id;
    private $publicid;
    private $deviceToken;
    private $userId;
    private $type;
    private $createDon;
    private $modifieDon;
    
    
    public function __construct() {
        
    }

    private function exchangeArray($data) {

        if (isset($data['device_id'])) {
            $this->setId($data['device_id']);
        }
        if (isset($data['device_publicid'])) {
            $this->setPublicid($data['device_publicid']);
        }
        if (isset($data['device_devicetoken'])) {
            $this->setDevicetoken($data['device_devicetoken']);
        }
        if (isset($data['device_userid'])) {
            $this->setUserid($data['device_userid']);
        }
        if (isset($data['device_type'])) {
            $this->setType($data['device_type']);
        }
        if (isset($data['device_createdon'])) {
            $this->setCreatedon($data['device_createdon']);
        }
        if (isset($data['device_modifiedon'])) {
            $this->setModifiedon($data['device_modifiedon']);
        }
    }
    
   
    
    public function getId(){
        return $this->id;
    }
    
    public function setId($_id){
        $this->id=$_id;
    }
    
    public function getPublicid(){
        return $this->publicid;
    }
    
    public function setPublicid($_publicid){
        $this->publicid=$_publicid;
    }
    
    public function getDevicetoken(){
        return $this->deviceToken;
    }
    
    public function setDevicetoken($_deviceToken){
        $this->deviceToken=$_deviceToken;
    }
    
    public function getUserid(){
        return $this->userId;
    }
    
    public function setUserid($_userId){
        $this->userId=$_userId;
    }
    
    public function getType(){
        return $this->type;
    }
    
    public function setType($_type){
        $this->type=$_type;
    }
    
    public function getCreatedon(){
        return $this->createDon;
    }
    
    public function setCreatedon($_createDon){
        $this->createDon=$_createDon;
    }
    
    public function getModifiedon(){
        return $this->modifieDon;
    }
    
    public function setModifiedon($_modifiedon){
        $this->modifieDon=$_modifiedon;
    }
    
}

