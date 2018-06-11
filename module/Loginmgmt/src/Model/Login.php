<?php

namespace Loginmgmt\Model;

class Login {

    protected $id;
    protected $user;
    protected $pwd;
    protected $role;
    protected $csrf;
    protected $honeypot;

    public function __construct() {}

    public function setId($_id) {
        $this->id = $_id;
    }

    public function getId() {
        return $this->id;
    }

    public function setUser($_user) {
        $this->user = $_user;
    }

    public function getUser() {
        return $this->user;
    }
    
    public function setPwd($_pwd) {
        $this->pwd = $_pwd;
    }
    
    public function getPwd() {
        return $this->pwd;
    }
    
    public function setRole($_role) {
        $this->role = $_role;
    }
    
    public function getRole() {
        return $this->role;
    }

    public function getCsrf() {
        return $this->csrf;
    }
    
    public function setCsrf($_csrf) {
        $this->csrf = $_csrf;
    }
    
    public function getHoneypot() {
        return $this->honeypot;
    }
    
    public function setHoneypot($_honeypot) {
        $this->honeypot = $_honeypot;
    }

    // Add the following method:
    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
