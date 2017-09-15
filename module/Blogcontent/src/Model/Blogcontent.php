<?php

// module/Contenu/src/Contenu/Model/Contenu.php:

namespace Blogcontent\Model;

use Contenu\Model\Contenu;
use Sousrubrique\Model\Sousrubrique;
use Blogcontent\Model\IBlogcontent;


class Blogcontent extends Contenu implements IBlogcontent{

    protected $author;
    protected $themes;
    protected $blogDate;
    protected $text1;
    protected $text2;
    protected $text3;

    public function __construct() {
        parent::__construct();
    }

    //first hydrator strategy
    public static function fromArray($row) {
        $instance = new self();
        $instance->exchangeArray($row);
        return $instance;
    }
    
    //first hydrator strategy
    public static function fromForm($row) {
        $instance = new self();
        $instance->exchangeForm($row);
        
        return $instance;
    }

    protected function exchangeArray($data) {

        parent::exchangeArray($data);
        if (isset($data['author'])) {
            $this->setAuthor($data['author']);
        }
        if (isset($data['themes'])) {
            $this->setThemes($data['themes']);
        }
        if (isset($data['blogdate'])) {
            $this->setDate($data['blogdate']);
        }
        if (isset($data['text1'])) {
            $this->setText1($data['text1']);
        }
        if (isset($data['text2'])) {
            $this->setText2($data['text2']);
        }
        if (isset($data['text3'])) {
            $this->setText3($data['text3']);
        } 
         
    }
    
    public static function to_json($data){
        $json = array();
        $count =0;
        foreach ($data as $value) {
        
            if (isset($value['contenu_id'])) {
                $json[$count]["blogid"]=$value['contenu_id'];
            }
            if (isset($value['titre'])) {
                $json[$count]["blogtitre"] =$value['titre'];
            }
            if (isset($value['soustitre'])) {
                $json[$count]["blogsoustitre"]=$value['soustitre'];
            }
            if (isset($value['contenuhtml'])) {
                $json[$count]["blogcontenu"]=$value['contenuhtml'];
            }
            if (isset($value['rang'])) {
               $json[$count]["blogposition"]=$value['rang'];
            }
            if (isset($value['image'])) {
                $json[$count]["blogimage"]=$value['image'];
            }
            if (isset($value['image2'])) {
                $json[$count]["blogimage2"]=$value['image2'];
            }
            if (isset($value['sousrubriques_id'])) {
                $json[$count]["blogsousrubrique"]=$value['sousrubriques_id'];
            }
            if (isset($value['type'])) {
                $json[$count]["blogtype"]=$value['type'];
            }
            if (isset($value['author'])) {
                $json[$count]["blogauthor"]=$value['author'];
            }
            if (isset($value['themes'])) {
                $json[$count]["blogthemes"]=$value['themes'];
            }
            if (isset($value['contenu_date'])) {
                $json[$count]["blogdate"]=$value['contenu_date'];
            }
            if (isset($value['othertext1'])) {
                $json[$count]["blogtext1"]=$value['othertext1'];
            }
            if (isset($value['othertext2'])) {
                $json[$count]["blogtext2"]=$value['othertext2'];
            }
            if (isset($value['othertext3'])) {
                $json[$count]["blogtext3"]=$value['othertext3'];
            }
            $count++;
        }
        
        return $json;
    }
    
    protected function exchangeForm($data) {
       
        //Right now, there's no difference with exchangeArray but it could change in the future
       parent::exchangeArray($data);
       if (isset($data['author'])) {
            $this->setAuthor($data['author']);
        }
        if (isset($data['themes'])) {
            $this->setThemes($data['themes']);
        }
        if (isset($data['blogdate'])) {
            $this->setDate($data['blogdate']);
        }
        if (isset($data['text1'])) {
            $this->setText1($data['text1']);
        }
        if (isset($data['text2'])) {
            $this->setText2($data['text2']);
        }
        if (isset($data['text3'])) {
            $this->setText3($data['text3']);
        }
    }
    
    public function getAuthor(){
        return $this->author;
    }

    public function setAuthor($_author){
        $this->author=$_author;
    }

    public function getThemes(){
        return $this->themes;
    }

    public function setThemes($_themes){
        $this->themes=$_themes;
    }            

    public function getDate(){
        return $this->blogDate;
    }

    public function setDate($_blogDate){
        $this->blogDate=$_blogDate;
    }

    public function getText1(){
        return $this->text1;
    }

    public function setText1($_text1){
        $this->text1=$_text1;
    }

    public function getText2(){
        return $this->text2;
    }

    public function setText2($_text2){
        $this->text2=$_text2;
    }

    public function getText3(){
        return $this->text3;
    }

    public function setText3($_text3){
        $this->text3=$_text3;
    }

    // Add the following method:
    public function getArrayCopy() {
       return get_object_vars($this);
    }

}
