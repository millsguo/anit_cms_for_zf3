<?php

namespace Confmgmt\Model;

use Confmgmt\Model\Confmgmt;
use Application\DBConnection\ParentDao;

class Confmgmtdao extends ParentDao{

    public function __construct() {
       
       parent::__construct(); 
        
    }

    public function getAllFichiers($dataType) {

        $count = 0;

        $requete = $this->dbGateway->prepare("
		SELECT *
		FROM confmgmt
		ORDER BY fichiers_nom
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute();

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);
        if (is_array($requete2)) {
            if ($dataType == "object") {
                //Put result in an array of objects
                $arrayOfFichierstep = array();
                
                foreach ($requete2 as $key => $value) {
                    
                    $arrayOfFichierstep[$count] = Confmgmt::fromArray($value);

                    $count++;
                }
                 
            }    
                //print_r($arrayOfFichierstep2);
                return $arrayOfFichierstep;
            } 
        
        elseif ($dataType == "array") {
                return $requete2;
            }
    }

    public function getFichiers($id) {

        $id = (int) $id;
        
        $requete = $this->dbGateway->prepare("
		SELECT * 
		FROM confmgmt
		WHERE fichiers_id = :id
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'id' => $id
        ));

        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);

        $fichiers = Confmgmt::fromArray($requete2);

        return $fichiers;
    }
    
    public function getFichiersByFilename($filename) {

        $requete = $this->dbGateway->prepare("
		SELECT * 
		FROM confmgmt
		WHERE fichiers_nom = :filename
                LIMIT 1
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'filename' => $filename
        ));

        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);

        $fichiers = Confmgmt::fromArray($requete2);

        return $fichiers;
    }
    
    public function saveFichiersFilename(Confmgmt $fichiers) {
        $id = (int) $fichiers->getId();
        $result = false;
        if ($id > 0) {

            $requete = $this->dbGateway->prepare("
				UPDATE confmgmt 
				SET fichiers_nom 	= :fichiers_nom
                                WHERE fichiers_id 	= :id
			")or die(print_r($this->dbGateway->errors_info()));
            
            $requete->bindParam(':id', $id, \PDO::PARAM_INT);
            $requete->bindParam(':fichiers_nom', $fichiers->getNom(), \PDO::PARAM_STR);
            $result = $requete->execute();
        }
        //var_dump($result);
        //exit;
        return $result;
    }

    public function saveFichiers(Confmgmt $fichiers) {

        $id = (int) $fichiers->getId();

        if ($id > 0) {

            $requete = $this->dbGateway->prepare("
				UPDATE confmgmt 
				SET fichiers_libelle 	= :fichiers_libelle,
                                fichiers_meta           = :fichiers_meta
				WHERE fichiers_id 	= :id
			")or die(print_r($this->dbGateway->errors_info()));

            $requete->execute(array(
                'fichiers_libelle' => $fichiers->getLibelle(),
                'fichiers_meta' => $fichiers->getMetaData(),
                'id' => $fichiers->getId()
            ));
        } else {
            //print_r($fichiers);
            //exit;
            $requete = $this->dbGateway->prepare("INSERT into confmgmt(fichiers_chemin, fichiers_nom, fichiers_type, fichiers_libelle, fichiers_meta, fichiers_thumbnail, fichiers_thumbnailpath) 
					values(:fichiers_chemin, :fichiers_nom, :fichiers_type, :fichiers_libelle, :fichiers_meta, :fichiers_thumbnail, :fichiers_thumbnailpath)")or die(print_r($this->dbGateway->error_info()));

            $requete->execute(array(
                'fichiers_chemin' => $fichiers->getChemin(),
                'fichiers_nom' => $fichiers->getNom(),
                'fichiers_type' => $fichiers->getType(),
                'fichiers_libelle' => $fichiers->getLibelle(),
                'fichiers_meta' => $fichiers->getMetaData(),
                'fichiers_thumbnail' => $fichiers->getThumbnail(),
                'fichiers_thumbnailpath' => $fichiers->getThumbnailpath()
            ));
        }
    }

    public function deleteFichiers($id) {

        $id = (int) $id;
        $requete = $this->dbGateway->prepare("
		DELETE FROM confmgmt WHERE fichiers_id = :id
		")or die(print_r($this->dbGateway->error_info()));

        $isDeleted = $requete->execute(array(
            'id' => $id
        ));
        //print_r($isDeleted);
        //exit;
        return $isDeleted;
    }
    
    public function deleteFichiersByFilename($filename) {

        $requete = $this->dbGateway->prepare("
            DELETE FROM confmgmt WHERE fichiers_nom = :filename
        ")or die(print_r($this->dbGateway->error_info()));
        
        $isDeleted = $requete->execute(array(
            'filename' => $filename
        ));
        
        return $isDeleted;
    }

}
