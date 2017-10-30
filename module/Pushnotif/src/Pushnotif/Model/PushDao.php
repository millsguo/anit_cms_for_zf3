<?php

namespace Pushnotif\Model;

use Application\DBConnection\DBConnection;

class PushDao {

    private $env = ''; // TEST ou PROD

    public function __construct() {
        $DB = new DBConnection();
        $this->dbGateway = $DB->DBConnect();
    }

    public function setEnvironement($env) {
        if ($env == 'PROD') {
            $this->env = 'PROD';
            return true;
        }
        if ($env == 'TEST') {
            $this->env = 'TEST';
            return true;
        }
        die('Environnement inconnu ' . __FILE__ . '(' . __LINE__ . ')');
    }

    /**
     * Enregistrement d'un Push en base
     */
    public function newPush($pushObj) {
        if (empty($this->env))
            die('Environnement inconnu ' . __FILE__ . '(' . __LINE__ . ')');

        $requete = $this->dbGateway->prepare("INSERT INTO pushnotification
			(pushnotify_publicid, pushnotify_env, 	pushnotify_type, 	pushnotify_appid, 	pushnotify_destination, 	pushnotify_destinationid,
			pushnotify_paylod, 	pushnotify_createdon, 	pushnotify_modifiedon, pushnotify_status, pushnotify_android, pushnotify_ios
			) VALUES (
			:publicid, :env, 			:pushtype, 				1, 					:destination, 				:destination_id,
			:paylodmsg, 		NOW(), 			NOW(), :status, :pushnotify_android, :pushnotify_ios
			)") or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'publicid' => '', // Toujour vide ???
            'env' => $this->env,
            'pushtype' => ($pushObj->type == 'deep' ? 2 : 1),
            'destination' => $pushObj->deepDestination,
            'destination_id' => json_encode($pushObj->deepCriteres[$pushObj->deepDestination]),
            'paylodmsg' => $pushObj->message,
            'status' => 'Erreur',
            'pushnotify_android' => '',
            'pushnotify_ios' => '',
        ));

        return $this->dbGateway->lastInsertId();
    }

    public function updateStatusPush($pushId = 0, $pushStatus = '', $reponseAndroid, $reponseiOS) {
        if (empty($this->env))
            die('Environnement inconnu ' . __FILE__ . '(' . __LINE__ . ')');

        $pushId = abs((int) $pushId);
        if ($pushId < 1)
            die('Identifiant de push inconnu');

        $requete = $this->dbGateway->prepare('UPDATE pushnotification SET
						pushnotify_status = :status,
						pushnotify_android = :notifyAndroid,
						pushnotify_ios = :notifyiOS
					WHERE
						pushnotify_id = :pushId');

        $requete->execute(array(
            'status' => $pushStatus,
            'notifyAndroid' => $reponseAndroid,
            'notifyiOS' => $reponseiOS,
            'pushId' => $pushId,
        ));

        return true;
    }

    public function getAll() {
        $pushH = array();
        $count = 0;
        $requete = $this->dbGateway->prepare("SELECT
				pushnotify_id AS pushId,
				pushnotify_env AS environement,
				DATE_FORMAT(pushnotify_modifiedon, '%d/%m/%Y %H:%i:%s') AS pushDate,
				pushnotify_paylod AS pushMsg,
				pushnotify_status AS pushStatus,

				pushnotify_type AS pushType,
				pushnotify_destination AS pushDestination,
				pushnotify_destinationid AS pushDestinationId,
				pushnotify_android AS pushAndroid,
				pushnotify_ios AS pushIOS
			FROM pushnotification
			ORDER BY pushnotify_id DESC") or die(print_r($this->dbGateway->error_info()));
        $requete->execute();
        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($requete2 as $value) {
            $pushH[] = $value;
        }
        return $pushH;
    }

    /**
     * Recuperation de la config du Push
     */
    public function getPushConfiguration() {
        //$config = array();
        $requete = $this->dbGateway->prepare("SELECT
				pushapp_androidkey,
				pushapp_ioslocate,
				pushapp_passphrase
			FROM pushapplication
			WHERE pushapp_id = 1");
        
        $requete->execute();
        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);
        /*
        foreach ($requete2 as $value) {
            $config = $value;
        }
         * 
         */
        return $requete2;
    }

    public function getAndroidDeviceToken() {
        if (empty($this->env))
            die('Environnement inconnu ' . __FILE__ . '(' . __LINE__ . ')');

        $tableSuffixe = '';
        if ($this->env == 'TEST')
            $tableSuffixe = 'test';

        $devices = array();
        $requete = $this->dbGateway->prepare("SELECT distinct device_devicetoken FROM deviceregistration" . $tableSuffixe . " WHERE device_type = 1");
        $requete->execute();
        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($requete2 as $v) {
            $devices[] = $v['device_devicetoken'];
        }
        return $devices;
    }

    public function getIOSDeviceToken() {
        if (empty($this->env))
            die('Environnement inconnu ' . __FILE__ . '(' . __LINE__ . ')');

        $tableSuffixe = '';
        if ($this->env == 'TEST')
            $tableSuffixe = 'test';

        $device = array();
        $requete = $this->dbGateway->prepare("SELECT distinct device_devicetoken FROM deviceregistration" . $tableSuffixe . " WHERE device_type = 2");
        $requete->execute();
        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($requete2 as $value) {
            $device[] = $value['device_devicetoken'];
        }
        return $device;
    }

}
