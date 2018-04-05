<?php

namespace Commentaire\Model;

use Message\Model\Message;

class Commentaire extends Message {

    protected $idContenu;
    protected $commentaireStatut;

    //heriter la classe de message et ajouter statut et idcontenu

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

        if (isset($data['commentaire_id'])) {
            $this->setId($data['commentaire_id']);
        }
        if (isset($data['commentaire_row1'])) {
            $this->setRow1($data['commentaire_row1']);
        }
        if (isset($data['commentaire_row2'])) {
            $this->setRow2($data['commentaire_row2']);
        }
        if (isset($data['commentaire_row3'])) {
            $this->setRow3($data['commentaire_row3']);
        }
        if (isset($data['commentaire_row4'])) {
            $this->setRow4($data['commentaire_row4']);
        }
        if (isset($data['commentaire_msg'])) {
            $this->setMessage($data['commentaire_msg']);
        }
        if (isset($data['commentaire_position'])) {
            $this->setRang($data['commentaire_position']);
        }
        if (isset($data['commentaire_type'])) {
            $this->setType($data['commentaire_type']);
        }
        if (isset($data['commentaire_date'])) {
            $this->setDate($data['commentaire_date']);
        }
        if (isset($data['commentaire_contenuid'])) {
            $this->setContenuId($data['commentaire_contenuid']);
        }
        if (isset($data['commentaire_status'])) {
            $this->setCommentaireStatut($data['commentaire_status']);
        }

    }
    
    protected function exchangeForm($data) {
        
        parent::exchangeForm($data);
        if (isset($data['commentaire_contenuid'])) {
            $this->setContenuId($data['commentaire_contenuid']);
        }
        if (isset($data['commentaire_status'])) {
            $this->setCommentaireStatut($data['commentaire_status']);
        }
        if (isset($data['commentaire_type'])) {
            $this->setType($data['commentaire_type']);
        }
    }

    public function setContenuId($_id) {
        $this->idContenu = $_id;
    }

    public function getContenuId() {
        return $this->idContenu;
    }
    public function setCommentaireStatut($_commentaireStatut) {
        $this->commentaireStatut = $_commentaireStatut;
    }

    public function getCommentaireStatut() {
        return $this->commentaireStatut;
    }

    // Add the following method:
    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
