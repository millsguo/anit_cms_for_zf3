<?php

// module/Contenu/src/Contenu/Model/Contenu.php:

namespace Message\Model;

class Message {

    protected $id;
    protected $row1;
    protected $row2;
    protected $row3;
    protected $row4;
    protected $message;
    protected $rang;
    protected $type;
    protected $timestamp;


    public function __construct() {
        
    }

    public function setId($_id) {
        $this->id = $_id;
    }

    public function getId() {
        return $this->id;
    }

    public function setRow1($_row1) {
        $this->row1 = $_row1;
    }

    public function getRow1() {
        return $this->row1;
    }

    public function setRow2($_row2) {
        $this->row2 = $_row2;
    }

    public function getRow2() {
        return $this->row2;
    }

    public function setRow3($_row3) {
        $this->row3 = $_row3;
    }

    public function getRow3() {
        return $this->row3;
    }
    
    public function setRow4($_row4) {
        $this->row4 = $_row4;
    }

    public function getRow4() {
        return $this->row4;
    }

    public function getMessage() {
        return $this->message;
    }

    public function setMessage($_message) {
        $this->message = $_message;
    }

    public function getRang() {
        return $this->rang;
    }

    public function setRang($_rang) {
        $this->rang = $_rang;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($_type) {
        $this->type = $_type;
    }

    public function getDate() {
        return $this->timestamp;
    }

    public function setDate($_timestamp) {
        $this->timestamp = $_timestamp;
    }
    
    // Add the following method:
    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
