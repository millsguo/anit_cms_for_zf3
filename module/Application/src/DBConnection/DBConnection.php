<?php

namespace Application\DBConnection;

/**
 * Class DBConnection
 * @package Application\DBConnection
 */
final class DBConnection {

    /**
     * @var string
     */
    private $mySqlHost = "localhost";
    /**
     * @var string
     */
    private $mySqlDbname = "atnightandintransportation";
    /**
     * @var string
     */
    private $mySqlUsername = "root";
    /**
     * @var string
     */
    private $mySqlPassword = "";


    /**
     * @return \PDO
     */
    public function DBConnect() {
        $db = new \PDO('mysql:host='.$this->mySqlHost.';dbname='.$this->mySqlDbname,$this->mySqlUsername,$this->mySqlPassword);
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
        //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }

}

?>