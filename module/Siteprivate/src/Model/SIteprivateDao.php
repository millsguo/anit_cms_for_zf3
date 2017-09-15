<?php

namespace Siteprivate\Model;

use Application\DBConnection\ParentDao;
use Privatespacelogin\Model\PrivatespaceloginDao;

class SiteprivateDao extends PrivatespaceloginDao {

    public function __construct() {
        parent::__construct();
    }

    public function countLoginforAuthentication($spaceId, $email, $pwd) {
        //print_r($spaceId.' '.$email.' '.$pwd);
        $requete = $this->dbGateway->prepare("
		SELECT COUNT(privatespacelogin_email)
		FROM privatespacelogin
		WHERE space_id_fk = :spaceId 
                AND privatespacelogin_email = :email
                AND privatespacelogin_pwd = :pwd
                ")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'spaceId' => $spaceId,
            'email' => $email,
            'pwd' => $pwd
        ));
        //print_r($requete->fetchColumn());
        //print_r((int) $requete->fetchColumn());
        //exit;
        return (int)$requete->fetchColumn();
    }

}
