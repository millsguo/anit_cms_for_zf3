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

    //first hydrator strategy
    public static function fromArray($row) {
        $instance = new self();
        $instance->exchangeArray($row);
        return $instance;
    }

    private function exchangeArray($data) {

        if (isset($data['id_access'])) {
            $this->setId($data['id_access']);
        }
        if (isset($data['user_access'])) {
            $this->setUser($data['user_access']);
        }
        if (isset($data['pwd_access'])) {
            $this->setPwd($data['pwd_access']);
        }
        if (isset($data['role_access'])) {
            $this->setRole($data['role_access']);
        }
        if (isset($data['csrf_access'])) {
            $this->setCsrf($data['csrf_access']);
        }
        if (isset($data['honeypot_access'])) {
            $this->setHoneypot($data['honeypot_access']);
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
        if (isset($data['username'])) {
            $this->setUser($data['username']);
        }
        if (isset($data['password'])) {
            $this->setPwd($data['password']);
        }
        if (isset($data['prevent'])) {
            $this->setCsrf($data['prevent']);
        }
        if (isset($data['sweethoney'])) {
            $this->setHoneypot($data['sweethoney']);
        }
    }

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
