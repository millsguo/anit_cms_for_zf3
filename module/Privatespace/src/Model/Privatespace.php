<?php

namespace Privatespace\Model;

class Privatespace {

    protected $id;
    protected $name;
    protected $token;
    
    public function __construct() {}

    //first hydrator strategy
    public static function fromArray($row) {
        $instance = new self();
        $instance->exchangeArray($row);
        return $instance;
    }

    private function exchangeArray($data) {

        if (isset($data['space_id'])) {
            $this->setId($data['space_id']);
        }
        if (isset($data['space_name'])) {
            $this->setName($data['space_name']);
        }
        if (isset($data['space_token'])) {
            $this->setToken($data['space_token']);
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
        if (isset($data['name'])) {
            $this->setName($data['name']);
        }
    }

    public function setId($_id) {
        $this->id = $_id;
    }

    public function getId() {
        return $this->id;
    }

    public function setName($_name) {
        $this->name = $_name;
    }

    public function getName() {
        return $this->name;
    }
    
    public function getToken(){
        return $this->token;
    }
    
    public function setToken($_token) {
        $this->token = $_token;
    }
    
    // Add the following method:
    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
