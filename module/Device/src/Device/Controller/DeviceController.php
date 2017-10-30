<?php
namespace Device\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Device\Model\Devicedao;
use Device\Model\Devicetestdao;
use Device\Model\Device;

class DeviceController extends AbstractActionController {

    public function registerprodAction() {

        $deviceDao = new Devicedao();
        $code = array();
        $rowCount = 0;
        $current_date = date('Y-m-d H:i:s');
        
        // Device id
        $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : '';
        // Registration Name while downloading App
        $userid = isset($_REQUEST['userid']) ? $_REQUEST['userid'] : '';
        // devicetype: 1 - Android, 2 - IOS
        $devicetype = isset($_REQUEST['deviceid']) ? $_REQUEST['deviceid'] : '';
        
        $publicid1 = '';
        
        //check if the token is alreay in the database
        $selectToken = $deviceDao->getDevicetestToken($devicetype, $token, $userid);
        
        if (!empty($selectToken)) {
            $publicid1 = $selectToken['device_publicid'];
        }
        
        if (!empty($token)) {
            $device = new Device();
            $device->setUserid($userid);
            $device->setDevicetoken($token);
            $device->setType($devicetype);
            $device->setCreatedon($current_date);
            $device->setModifiedon($current_date);
            
            if (empty($publicid1)) {
                $publicid = $deviceDao->createRandomId();
                $device->setPublicid($publicid);
                $rowCount = $deviceDao->addDevice($device);
            } 
            else {
                $device->setPublicid($publicid1);
                $rowCount = $deviceDao->updateDevice($device);
            }
            
            if ($rowCount>0) {
                $code = array('code' => 'success');
            } else {
                $code = array('code' => 'failure');
            }
        } 
        else {
            $code = array('code' => null);
        }
        
        return $this->getResponse()->setContent(json_encode($code));
    }
    
    public function registertestAction() {

        $deviceDao = new Devicetestdao();
        $code = array();
        $rowCount = 0;
        $current_date = date('Y-m-d H:i:s');
        
        // Device id
        $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : '';
        // Registration Name while downloading App
        $userid = isset($_REQUEST['userid']) ? $_REQUEST['userid'] : '';
        // devicetype: 1 - Android, 2 - IOS
        $devicetype = isset($_REQUEST['deviceid']) ? $_REQUEST['deviceid'] : '';
        
        $publicid1 = '';
        
        //check if the token is alreay in the database
        $selectToken = $deviceDao->getDevicetestToken($devicetype, $token, $userid);
        
        if (!empty($selectToken)) {
            $publicid1 = $selectToken['device_publicid'];
        }
        
        if (!empty($token)) {
            $device = new Device();
            $device->setUserid($userid);
            $device->setDevicetoken($token);
            $device->setType($devicetype);
            $device->setCreatedon($current_date);
            $device->setModifiedon($current_date);
            
            if (empty($publicid1)) {
                $publicid = $deviceDao->createRandomId();
                $device->setPublicid($publicid);
                $rowCount = $deviceDao->addDevicetest($device);
            } 
            else {
                $device->setPublicid($publicid1);
                $rowCount = $deviceDao->updateDevicetest($device);
            }
            
            if ($rowCount>0) {
                $code = array('code' => 'success');
            } else {
                $code = array('code' => 'failure');
            }
        } 
        else {
            $code = array('code' => null);
        }
        
        return $this->getResponse()->setContent(json_encode($code));
    }

}
