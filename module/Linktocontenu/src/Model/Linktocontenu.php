<?php

namespace Linktocontenu\Model;

use Contenu\Model\IContenu;
use Sousrubrique\Model\Sousrubrique;
use Rubrique\Model\Rubrique;

class Linktocontenu implements IContenu{

    protected $id;
    protected $position;
    protected $title;
    protected $subtitle;
    protected $section;
    protected $html;
    protected $image;
    protected $image2;
    protected $type;
    
    protected $linktopage;
    protected $contenu;
    protected $linktosection;

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

    protected function exchangeArray($data) {
        
        if (isset($data['id'])) {
            $this->setId($data['id']);
        }
        if (isset($data['contenuobj'])) {
            $this->setContenu($data['contenuobj']);
        }
        if (isset($data['position'])) {
            $this->setRang($data['position']);
        }
        if (isset($data['title'])) {
            $this->setTitre($data['title']);
        }
        if (isset($data['subtitle'])) {
            $this->setSousTitre($data['subtitle']);
        }
        /*
        if (isset($data['page'])){
            $this->setRubrique($data['page']);
        }
         * 
         */
        if (isset($data['section'])) {
            $this->setSousrubrique($data['section']);
        }
        if (isset($data['html'])) {
            $this->setContenuHtml($data['html']);
        }
        if (isset($data['image'])) {
            $this->setImage($data['image']);
        }
        if (isset($data['image2'])) {
            $this->setImage2($data['image2']);
        }
        if(isset($data['type'])){
            $this->setType($data['type']);
        }
        
        if (isset($data['linktopage'])) {
            $this->setLinktopage($data['linktopage']);
        }
         
        
        if (isset($data['linktosection'])) {
            $this->setLinktosection($data['linktosection']);
        }
    }

    public function setId($_id) {
        $this->id = $_id;
    }

    public function getId() {
        return $this->id;
    }
    
    public function setContenu(IContenu $_contenu) {
        $this->contenu = $_contenu;
    }
    
    public function getRang() {
        return $this->position;
    }

    public function setRang($_position) {
        $this->position = $_position;
    }

    public function getContenu() {
        return $this->contenu;
    }

    public function setTitre($_title) {
        $this->title = $_title;
    }

    public function getTitre() {
        return $this->title;
    }

    public function setSousTitre($_subtitle) {
        $this->subtitle = $_subtitle;
    }

    public function getSousTitre() {
        return $this->subtitle;
    }
/*
    public function setRubrique(Rubrique $_page) {
        $this->page = $_page;
    }
    
    public function getRubrique() {
        return $this->page;
    }
*/    
    public function setSousrubrique(SousRubrique $_section) {
        $this->section = $_section;
    }

    public function getSousrubrique() {
        return $this->section;
    }

    public function getContenuHtml() {
        return $this->html;
    }

    public function setContenuHtml($_html) {
        $this->html = $_html;
    }
  
    public function getImage() {
        return $this->image;
    }

    public function setImage($_image) {
        $this->image = $_image;
    }
    
    public function getImage2() {
        return $this->image2;
    }

    public function setImage2($_image2) {
        $this->image2 = $_image2;
    }
    
    public function getType(){
        return $this->type;
    }
    
    public function setType($_type) {
        $this->type = $_type;
    }
   
    public function getLinktopage(){
        return $this->linktopage;
    }
    
    public function setLinktopage($_linktopage){
        $this->linktopage = $_linktopage;
    }
     
    
    public function getLinktosection(){
        return $this->linktosection;
    }
    public function setLinktosection($_linktosection){
        $this->linktosection = $_linktosection;
    }
   
    // Add the following method:
    public function getArrayCopy() {
        return get_object_vars($this);
    }

    

}
