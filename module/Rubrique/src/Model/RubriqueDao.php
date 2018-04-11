<?php

namespace Rubrique\Model;

use Rubrique\Model\Rubrique;
use Application\DBConnection\ParentDao;

class RubriqueDao extends ParentDao {

    public function __construct() {
        parent::__construct();
    }

    public function getFirstRubrique($dataType) {
        $requete = $this->dbGateway->prepare("
		SELECT id, libelle, rang, scope, spaceId, filename, contactForm, messageForm, updateForm, fileuploadForm
                FROM rubrique
		ORDER BY rang
                LIMIT 1
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute();

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if ($dataType == "object") {

            $rubriqueObj = Rubrique::fromArray($requete2[0]);

            return $rubriqueObj;
        } elseif ($dataType == "array") {
            return $requete2;
        }
    }

    public function getFirstRubriqueBySpace($spaceId, $dataType) {
        $requete = $this->dbGateway->prepare("
		SELECT id, libelle, rang, scope, spaceId, filename, contactForm, messageForm, updateForm, fileuploadForm
                FROM rubrique
                WHERE spaceId = :spaceid 
		ORDER BY rang
                LIMIT 1
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'spaceid' => $spaceId
        ));

        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);

        if ($dataType == "object") {

            $rubriqueObj = Rubrique::fromArray($requete2);

            return $rubriqueObj;
        } elseif ($dataType == "array") {
            return $requete2;
        }
    }

    public function getRubriqueBySpaceToken($token, $dataType) {
        $requete = $this->dbGateway->prepare("
		SELECT rub.id, rub.libelle, rub.rang, rub.scope, rub.spaceId, rub.filename, rub.contactForm, rub.messageForm, rub.updateForm, rub.fileuploadForm
                FROM rubrique rub
                JOIN space s on s.space_id = rub.spaceId
                WHERE s.space_token = :token 
                ORDER BY rub.rang ASC
		LIMIT 1
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'token' => $token
        ));

        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);

        if ($dataType == "object") {

            $rubriqueObj = Rubrique::fromArray($requete2);
            return $rubriqueObj;
        } elseif ($dataType == "array") {
            return $requete2;
        }
    }

    public function getRubriqueByFilename($filename, $dataType) {
        $requete = $this->dbGateway->prepare("
		SELECT rub.id, rub.libelle, rub.rang, rub.scope, rub.spaceId, rub.filename, rub.contactForm, rub.messageForm, rub.updateForm, rub.fileuploadForm
                FROM rubrique rub
                WHERE rub.filename = :filename 
                LIMIT 1
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'filename' => $filename
        ));
        
        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);
        
        if ($dataType == "object") {

            $arrayOfRubrique = Rubrique::fromArray($requete2);
            return $arrayOfRubrique;
        } elseif ($dataType == "array") {
            return $requete2;
        }
    }

    public function getPrivateRubriqueByFilename($filename, $dataType) {
        $requete = $this->dbGateway->prepare("
		SELECT rub.id, rub.libelle, rub.rang, rub.scope, rub.spaceId, rub.filename, rub.contactForm, rub.messageForm, rub.updateForm, fileuploadForm
                FROM rubrique rub
                WHERE rub.filename = :filename AND rub.spaceId > 0
                LIMIT 1
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'filename' => $filename
        ));

        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);

        if ($dataType == "object") {

            $arrayOfRubrique = Rubrique::fromArray($requete2);
            return $arrayOfRubrique;
        } elseif ($dataType == "array") {
            return $requete2;
        }
    }

    public function getAllRubriques($dataType) {

        $count = 0;

        $requete = $this->dbGateway->prepare("
		SELECT id, libelle, rang, scope, spaceId, filename, contactForm, messageForm, updateForm, fileuploadForm
                FROM rubrique
		ORDER BY spaceId, rang
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute();

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if ($dataType == "object") {
            //Put result in an array of objects
            $arrayOfRubrique = array();

            if (is_array($requete2)) {
                foreach ($requete2 as $value) {
                    //print_r($value);
                    //put code to define an array of objects
                    $arrayOfRubrique[$count] = Rubrique::fromArray($value);
                    $count++;
                }
            }
            
            return $arrayOfRubrique;
        } elseif ($dataType == "array") {
            return $requete2;
        }
    }

    public function getAllRubriquesBySpaceId($spaceId, $dataType) {

        $count = 0;

        $requete = $this->dbGateway->prepare("
		SELECT id, libelle, rang, scope, spaceId, filename, contactForm, messageForm, updateForm, fileuploadForm
                FROM rubrique
                WHERE spaceId = :spaceId AND rang > -1
		ORDER BY rang
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'spaceId' => $spaceId
        ));

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if ($dataType == "object") {
            //Put result in an array of objects
            $arrayOfRubrique = array();

            if (is_array($requete2)) {
                foreach ($requete2 as $value) {
                    //print_r($value);
                    //put code to define an array of objects
                    $arrayOfRubrique[$count] = Rubrique::fromArray($value);
                    $count++;
                }
            }

            return $arrayOfRubrique;
        } elseif ($dataType == "array") {
            return $requete2;
        }
    }
    
    public function getAllRubriquesForAllPrivateSpaces($dataType) {

        $count = 0;

        $requete = $this->dbGateway->prepare("
		SELECT id, libelle, rang, scope, spaceId, filename, contactForm, messageForm, updateForm, fileuploadForm
                FROM rubrique
                WHERE spaceId > -1
		ORDER BY spaceId, rang
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute();

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if ($dataType == "object") {
            //Put result in an array of objects
            $arrayOfRubrique = array();

            if (is_array($requete2)) {
                foreach ($requete2 as $value) {
                    //print_r($value);
                    //put code to define an array of objects
                    $arrayOfRubrique[$count] = Rubrique::fromArray($value);
                    $count++;
                }
            }

            return $arrayOfRubrique;
        } elseif ($dataType == "array") {
            return $requete2;
        }
    }

    public function getRubrique($id) {
        $id = (int) $id;

        $requete = $this->dbGateway->prepare("
		SELECT id, libelle, rang, scope, spaceId, filename, contactForm, messageForm, updateForm, fileuploadForm
		FROM rubrique
		WHERE id = :id
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'id' => $id
        ));

        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);

        $rubrique = Rubrique::fromArray($requete2);
        return $rubrique;
    }

    public function getRubriqueByRang($rank, $dataType) {

        $requete = $this->dbGateway->prepare("
		SELECT id, libelle, rang, scope, spaceId, filename, contactForm, messageForm, updateForm, fileuploadForm
		FROM rubrique
		WHERE rang = :rank
                LIMIT 1
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'rank' => $rank
        ));

        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);

        if ($dataType == "object") {

            $rubrique = Rubrique::fromArray($requete2[0]);
            return $rubrique;
        } elseif ($dataType == "array") {
            return $requete2;
        }
    }

    public function saveRubrique(Rubrique $rubrique) {
        $id = (int) $rubrique->getId();

        if ($id > 0) {

            $requete = $this->dbGateway->prepare("
				UPDATE rubrique 
                                SET libelle= :libelle, rang= :rang, scope = :scope, spaceId = :spaceId, filename = :filename, 
                                contactForm = :contactForm, messageForm = :messageForm, updateForm = :updateForm, fileuploadForm=:fileuploadForm
                                WHERE id = :id
			")or die(print_r($this->dbGateway->errors_info()));

            $requete->execute(array(
                'id' => $id,
                'libelle' => $rubrique->getLibelle(),
                'rang' => $rubrique->getRang(),
                'scope' => $rubrique->getScope(),
                'spaceId' => $rubrique->getSpaceId(),
                'filename' => $rubrique->getFilename(),
                'contactForm' => $rubrique->getHasContactForm(),
                'messageForm' => $rubrique->getHasMessageForm(),
                'updateForm' => $rubrique->getHasUpdateForm(),
                'fileuploadForm' => $rubrique->gethasFileuploadForm()
            ));
        } else {
            $requete = $this->dbGateway->prepare("INSERT into rubrique(libelle, rang, scope, spaceId, filename, contactForm, messageForm, updateForm, fileuploadForm) 
					values(:libelle, :rang, :scope, :spaceId, :filename, :contactForm, :messageForm, :updateForm, :fileuploadForm)")or die(print_r($this->dbGateway->error_info()));

            $requete->execute(array(
                'libelle' => $rubrique->getLibelle(),
                'rang' => $rubrique->getRang(),
                'scope' => $rubrique->getScope(),
                'spaceId' => $rubrique->getSpaceId(),
                'filename' => $rubrique->getFilename(),
                'contactForm' => $rubrique->getHasContactForm(),
                'messageForm' => $rubrique->getHasMessageForm(),
                'updateForm' => $rubrique->getHasUpdateForm(),
                'fileuploadForm' => $rubrique->gethasFileuploadForm()
            ));

            $id = $this->dbGateway->lastInsertId();
            //exit;
            return $id;
        }
    }

    public function deleteRubrique($id) {

        $id = (int) $id;
        //echo $id;
        //fonction pour afficher la liste des tracteurs sous forme de tableau
        $requete = $this->dbGateway->prepare("
		DELETE FROM rubrique WHERE id = :id
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'id' => $id
        ));

        $requete = $this->dbGateway->prepare("
		DELETE FROM meta WHERE rubrique_id = :id
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'id' => $id
        ));
    }

}
