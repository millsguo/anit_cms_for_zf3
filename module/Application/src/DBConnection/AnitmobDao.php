<?php
namespace Application\DBConnection;

use Application\DBConnection\DBConnectionanitmob;
 
class Anitmobdao{
     
    protected $dbGateway;
     
    public function __construct() {
         //put code to instantiate db connection
        $DB = new DBConnectionanitmob();
        $this->dbGateway = $DB->DBConnect();
    }
}

