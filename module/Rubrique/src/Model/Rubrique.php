<?php

namespace Rubrique\Model;

use Rubrique\Model\Mapper\RubriqueMapper as Mapper;


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
    protected $hasFileuploadForm;
    protected $publishing;

    public function __construct() {}

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

    public function setHasFileuploadForm($_hasFileuploadForm){
        $this->hasFileuploadForm = $_hasFileuploadForm;
    }

    public function gethasFileuploadForm(){
        return $this->hasFileuploadForm;
    }

    public function setPublishing($_topublish){
        $this->publishing = $_topublish;
    }

    public function getPublishing(){
        return $this->publishing;
    }
}
