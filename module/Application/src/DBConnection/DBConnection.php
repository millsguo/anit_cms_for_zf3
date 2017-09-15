<?php

namespace Application\DBConnection;

final class DBConnection {

    private $mySqlHost = "localhost";
    private $mySqlDbname = "atnightandintransportation";
    private $mySqlUsername = "root";
    private $mySqlPassword = "root";

    //MySql
    public function DBConnect() {
        $db = new \PDO('mysql:host='.$this->mySqlHost.';dbname='.$this->mySqlDbname,$this->mySqlUsername,$this->mySqlPassword);
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
        //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        return $db;
    }

}

?>