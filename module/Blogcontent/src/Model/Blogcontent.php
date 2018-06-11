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
