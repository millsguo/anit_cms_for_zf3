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

    //first hydrator strategy
    public static function fromArray($row) {
        $instance = new self();
        $instance->exchangeArray($row);
        //print_r($instance);
        //exit;
        return $instance;
    }
    
    //first hydrator strategy
    public static function fromForm($row) {
        $instance = new self();
        $instance->exchangeForm($row);
        //print_r($instance);
        //exit;
        return $instance;
    }

    protected function exchangeArray($data) {

        if (isset($data['message_id'])) {
            $this->setId($data['message_id']);
        }
        if (isset($data['message_row1'])) {
            $this->setRow1($data['message_row1']);
        }
        if (isset($data['message_row2'])) {
            $this->setRow2($data['message_row2']);
        }
        if (isset($data['message_row3'])) {
            $this->setRow3($data['message_row3']);
        }
        if (isset($data['message_row4'])) {
            $this->setRow4($data['message_row4']);
        }
        if (isset($data['message_msg'])) {
            $this->setMessage($data['message_msg']);
        }
        /*
        if (isset($data['message_position'])) {
            $this->setRang($data['message_position']);
        }
         * 
         */
        if (isset($data['message_type'])) {
            $this->setType($data['message_type']);
        }
        if (isset($data['message_date'])) {
            $this->setDate($data['message_date']);
        }
    }
    
    protected function exchangeForm($data) {

        if (isset($data['id'])) {
            $this->setId($data['id']);
        }
        if (isset($data['row1'])) {
            $this->setRow1($data['row1']);
        }
        if (isset($data['row2'])) {
            $this->setRow2($data['row2']);
        }
        if (isset($data['row3'])) {
            $this->setRow3($data['row3']);
        }
        if (isset($data['row4'])) {
            $this->setRow4($data['row4']);
        }
        if (isset($data['msg'])) {
            $this->setMessage($data['msg']);
        }
        if (isset($data['type'])) {
            $this->setType($data['type']);
        }    
        if (isset($data['position'])) {
            $this->setRang($data['position']);
        }
        if (isset($data['timestamp'])) {
            $this->setDate($data['timestamp']);
        }
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
