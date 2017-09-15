<?php

namespace Rubrique\Model;


class Rubrique {

    protected $id;
    protected $libelle;
    protected $position;
    protected $scope;
    protected $spaceId;
    protected $filename;
    protected $hasContactForm;
    protected $hasMessageForm;
    protected $hasUpdateForm;

    public function __construct() {
        
    }

    //first hydrator strategy
    public static function fromArray($row) {
        $instance = new self();
        $instance->exchangeArray($row);
        //print_r($instance);
        //exit;
        return $instance;
    }

    private function exchangeArray($data) {

        if (isset($data['id'])) {
            $this->setId($data['id']);
        }
        if (isset($data['libelle'])) {
            $this->setLibelle($data['libelle']);
        }
        if (isset($data['rang'])) {
            $this->setRang($data['rang']);
        }
        if (isset($data['scope'])) {
            $this->setScope($data['scope']);
        }
        if (isset($data['spaceId'])) {
            $this->setSpaceId($data['spaceId']);
        }
        if (isset($data['filename'])) {
            $this->setFilename($data['filename']);
        }
        if (isset($data['contactForm'])) {
            $this->setHasContactForm($data['contactForm']);
        }
        if (isset($data['messageForm'])) {
            $this->setHasMessageForm($data['messageForm']);
        }
        if (isset($data['updateForm'])) {
            $this->setHasUpdateForm($data['updateForm']);
        }
    }

    public function setId($_id) {
        $this->id = $_id;
    }

    public function getId() {
        return $this->id;
    }

    public function setLibelle($_libelle) {
        $this->libelle = $_libelle;
    }

    public function getLibelle() {
        return $this->libelle;
    }

    public function setRang($_position) {
        $this->position = $_position;
    }

    public function getRang() {
        return $this->position;
    }

    public function setScope($_scope) {
        $this->scope = $_scope;
    }

    public function getScope() {
        return $this->scope;
    }

    public function setSpaceId($_privatespace_id) {
        $this->spaceId = $_privatespace_id;
    }

    public function getSpaceId() {
        return $this->spaceId;
    }
    
    public function setFilename($_filename) {
        $this->filename = $_filename;
    }

    public function getFilename() {
        return $this->filename;
    }
    
    public function setHasContactForm($_hasContactForm){
        $this->hasContactForm = $_hasContactForm;
    }
    
    public function getHasContactForm(){
        return $this->hasContactForm;
    }
    
    public function setHasMessageForm($_hasMessageForm){
        $this->hasMessageForm = $_hasMessageForm;
    }
    
    public function getHasMessageForm(){
        return $this->hasMessageForm;
    }
    
    public function setHasUpdateForm($_hasUpdateForm){
        $this->hasUpdateForm = $_hasUpdateForm;
    }
    
    public function getHasUpdateForm(){
        return $this->hasUpdateForm;
    }
    
    // Add the following method:
    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
