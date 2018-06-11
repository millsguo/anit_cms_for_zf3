<?php

namespace Commentaire\Model;

use Message\Model\Message;

class Commentaire extends Message {

    protected $idContenu;
    protected $commentaireStatut;

    public function __construct() {
        parent::__construct();
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

}
