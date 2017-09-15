<?php

namespace Privatespacelogin\Model;

use Privatespace\Model\Privatespace;
use Privatespace\Model\PrivatespaceDao;

class Privatespacelogin {

    protected $id;
    protected $pwd;
    protected $email;
    protected $firstname;
    protected $lastname;
    protected $company;
    protected $streetnumber;
    protected $streetline_1;
    protected $streetline_2;
    protected $streetline_3;
    protected $zipcode;
    protected $city;
    protected $mobilephone;
    protected $homephone;
    protected $website;
    protected $space;
    protected $isValidate;

    public function __construct() {}

    //first hydrator strategy
    public static function fromArray($row) {
        $instance = new self();
        $instance->exchangeArray($row);
        return $instance;
    }
    
    private function exchangeArray($data) {

        if (isset($data['privatespacelogin_id'])) {
            $this->setId($data['privatespacelogin_id']);
        }
        if (isset($data['privatespacelogin_email'])) {
            $this->setEmail($data['privatespacelogin_email']);
        }
        if (isset($data['privatespacelogin_pwd'])) {
            $this->setPwd($data['privatespacelogin_pwd']);
        }
        if (isset($data['privatespacelogin_validate'])){
            $this->setIsValidate($data['privatespacelogin_validate']);
        }
        if (isset($data['privatespacelogin_firstname'])) {
            $this->setFirstname($data['privatespacelogin_firstname']);
        }
        if (isset($data['privatespacelogin_lastname'])) {
            $this->setLastname($data['privatespacelogin_lastname']);
        }
        if (isset($data['privatespacelogin_company'])) {
            $this->setCompany($data['privatespacelogin_company']);
        }
        if (isset($data['privatespacelogin_streetnumber'])) {
            $this->setStreetnumber($data['privatespacelogin_streetnumber']);
        }
        if (isset($data['privatespacelogin_streetline_1'])) {
            $this->setStreetline_1($data['privatespacelogin_streetline_1']);
        }
        if (isset($data['privatespacelogin_streetline_2'])) {
            $this->setstreetline_2($data['privatespacelogin_streetline_2']);
        }
        if (isset($data['privatespacelogin_streetline_3'])) {
            $this->setstreetline_3($data['privatespacelogin_streetline_3']);
        }
        if (isset($data['privatespacelogin_zipcode'])) {
            $this->setZipcode($data['privatespacelogin_zipcode']);
        }
        if (isset($data['privatespacelogin_city'])) {
            $this->setCity($data['privatespacelogin_city']);
        }
        if (isset($data['privatespacelogin_homephone'])) {
            $this->setHomephone($data['privatespacelogin_homephone']);
        }
        if (isset($data['privatespacelogin_mobilephone'])) {
            $this->setMobilephone($data['privatespacelogin_mobilephone']);
        }
        if (isset($data['privatespacelogin_website'])) {
            $this->setWebsite($data['privatespacelogin_website']);
        }
        if (isset($data['space_id_fk'])) {
            $spaceDao = new PrivatespaceDao();
            $this->space = $spaceDao->getSpace($data['space_id_fk']);
            //var_dump($this->space);
            //exit;
            $this->setSpace($this->space);
        }
        if(isset($data['privatespacelogin_validate'])){
            $this->setIsValidate($data['privatespacelogin_validate']);
        }
    }
    
    public static function fromForm($row) {
        $instance = new self();
        $instance->exchangeForm($row);
        return $instance;
    }
    
    private function exchangeForm($data) {

        if (isset($data['id'])) {
            $this->setId($data['id']);
        }
        if (isset($data['email'])) {
            $this->setEmail($data['email']);
        }
        if (isset($data['pwd'])) {
            $this->setPwd($data['pwd']);
        }
        if (isset($data['firstname'])) {
            $this->setFirstname($data['firstname']);
        }
        if (isset($data['lastname'])) {
            $this->setLastname($data['lastname']);
        }
        if (isset($data['company'])) {
            $this->setCompany($data['company']);
        }
        if (isset($data['streetnumber'])) {
            $this->setStreetnumber($data['streetnumber']);
        }
        if (isset($data['streetline_1'])) {
            $this->setStreetline_1($data['streetline_1']);
        }
        if (isset($data['streetline_2'])) {
            $this->setstreetline_2($data['streetline_2']);
        }
        if (isset($data['streetline_3'])) {
            $this->setstreetline_3($data['streetline_3']);
        }
        if (isset($data['zipcode'])) {
            $this->setZipcode($data['zipcode']);
        }
        if (isset($data['city'])) {
            $this->setCity($data['city']);
        }
        if (isset($data['homephone'])) {
            $this->setHomephone($data['homephone']);
        }
        if (isset($data['mobilephone'])) {
            $this->setMobilephone($data['mobilephone']);
        }
        if (isset($data['website'])) {
            $this->setWebsite($data['website']);
        }
        if (isset($data['spacesList'])) {
            
            $spaceDao = new PrivatespaceDao();
            $this->space = $spaceDao->getSpace($data['spacesList']);
            
            $this->setSpace($this->space);
        }
        if(isset($data['validate'])){
            $this->setIsValidate($data['validate']);
        }
    }

    public function setId($_id) {
        $this->id = $_id;
    }

    public function getId() {
        return $this->id;
    }

    public function setEmail($_email) {
        $this->email = $_email;
    }

    public function getEmail() {
        return $this->email;
    }
    
    public function setPwd($_pwd) {
        $this->pwd = $_pwd;
    }

    public function getPwd() {
        return $this->pwd;
    }
    
    public function setIsValidate($_validate) {
        $this->isValidate = $_validate;
    }

    public function getIsValidate() {
        return $this->isValidate;
    }
    
    public function setFirstname($_firstname) {
        $this->firstname = $_firstname;
    }
    
    public function getFirstname() {
        return $this->firstname;
    }
    
    public function setLastname($_lastname) {
        $this->lastname = $_lastname;
    }
    
    public function getLastname() {
        return $this->lastname;
    }

    public function getCompany() {
        return $this->company;
    }
    
    public function setCompany($_company) {
        $this->company = $_company;
    }
    
    public function getStreetnumber() {
        return $this->streetnumber;
    }
    
    public function setStreetnumber($_streetnumber) {
        $this->streetnumber = $_streetnumber;
    }
   
    public function getStreetline_1() {
        return $this->streetline_1;
    }
    
    public function setStreetline_1($_streetline1) {
        $this->streetline_1 = $_streetline1;
    }
    
    public function getStreetline_2() {
       return $this->streetline_2;
    }
    
    public function setStreetline_2($_streetline2) {
        $this->streetline_2 = $_streetline2;
    }
    
    public function getStreetline_3() {
        return $this->streetline_3;
    }
    
    public function setStreetline_3($_streetline3) {
        $this->streetline_3 = $_streetline3;
    }
    
    public function setZipcode($_zipcode) {
        $this->zipcode = $_zipcode;
    }
    
    public function getZipcode() {
        return $this->zipcode;
    }
    
    public function getCity() {
        return $this->city;
    }
    
    public function setCity($_city) {
        $this->city = $_city;
    }
    
    public function getMobilephone() {
        return $this->mobilephone;
    }
    
    public function setMobilephone($_mobilephone) {
        $this->mobilephone = $_mobilephone;
    }
    
    public function setHomephone($_homephone) {
        $this->homephone = $_homephone;
    }
    
    public function getHomephone() {
        return $this->homephone;
    }
    
    public function getWebsite() {
        return $this->website;
    }
    
    public function setWebsite($_website) {
        $this->website = $_website;
    }
    
    public function getSpace() {
        return $this->space;
    }
    
    public function setSpace(Privatespace $_space) {
        $this->space = $_space;
    }

    // Add the following method:
    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
