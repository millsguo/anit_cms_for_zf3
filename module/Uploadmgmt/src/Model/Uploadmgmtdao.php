<?php

namespace Uploadmgmt\Model;

use Application\DBConnection\Anitmobdao;
use Uploadmgmt\Model\Fileupload;

class Uploadmgmtdao extends AnitmobDao
{
    private static $fields = "p.filesupload_id as id, p.filesupload_name as name, p.filesupload_path as path, p.filesupload_type as type," .
    "p.filesupload_comment as comment, p.filesupload_status as status, p.filesupload_thumbnail as thumbnail, p.filesupload_thumbnailpath as thumbnailpath," .
    "p.filesupload_author as author, p.filesupload_userid as userid, p.filesupload_email as email, p.filesupload_date as creationdate," .
    "p.filesupload_lat as lat, p.filesupload_lng as lng";

    public function getPhoto($idPhoto = 0)
    {
        $query = $this->dbGateway->prepare('SELECT ' . $this::$fields . ' FROM filesupload p WHERE filesupload_id=' . abs((int)$idPhoto))
        or die(print_r($this->dbGateway->error_info()));
        $query->execute();
        return $query->fetch(\PDO::FETCH_ASSOC);
    }

    public function getPhotoWaitStatus()
    {
        $query = $this->dbGateway->prepare('SELECT ' . $this::$fields . ' FROM filesupload p WHERE p.filesupload_status=0 ORDER BY p.filesupload_date DESC')
        or die(print_r($this->dbGateway->error_info()));
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPhotoValidateStatus()
    {
        $query = $this->dbGateway->prepare('SELECT ' . $this::$fields . ' FROM filesupload p WHERE p.filesupload_status=1 ORDER BY p.filesupload_date DESC')
        or die(print_r($this->dbGateway->error_info()));
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /*
        public function setStatus($idPhoto = 0, $status = 0) {
            $status = abs((int) $status);
            $idPhoto = abs((int) $idPhoto);
            if ($status < 1) {
                die('Status non autorisé ' . __LINE__);
            }
            if ($idPhoto < 1) {
                die('numero de photo invalide ' . __LINE__);
            }
            $sql = 'UPDATE filesupload SET filesupload_status=' . $status . ' WHERE filesupload_id=' . $idPhoto;
            $query = $this->dbGateway->prepare($sql) or die(print_r($this->dbGateway->error_info()));
            $reqIsOK = $query->execute();
            return $reqIsOK;
        }
    */
    public function updateComment($idPhoto = 0, $params = array())
    {
        $idPhoto = abs((int)$idPhoto);
        if ($idPhoto < 1) {
            die(json_encode(array('error' => $this->translate('numero de photo invalide ' . __LINE__))));
        }
        $sql = 'UPDATE filesupload SET filesupload_comment=:commenter WHERE filesupload_id=:idPhoto';
        $query = $this->dbGateway->prepare($sql) or die(print_r($this->dbGateway->error_info()));
        $reqIsOK = $query->execute(array(
            'commenter' => $params['commenter'],
            'idPhoto' => $idPhoto
        ));
        return $reqIsOK;
    }

    public function getAllPhotos($sqlpart, $start)
    {
        $sql = "SELECT " . $this::$fields
            . " FROM filesupload p where p.filesupload_status=1 " . $sqlpart
            . " ORDER BY p.fileupload_date DESC "
            . " LIMIT " . $start . ", 30";

        $query = $this->dbGateway->prepare($sql) or die(print_r($this->dbGateway->error_info()));
        $reqIsOK = $query->execute();

        if ($reqIsOK) {

            $result = $query->fetchAll(\PDO::FETCH_ASSOC);

            if (count($result) > 0) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getFileByFilename(string $filename)
    {
        $query = $this->dbGateway->prepare("
		SELECT " . self::$fields ." 
		FROM filesupload p
		WHERE p.filesupload_name = :filename
        LIMIT 1
		") or die(print_r($this->dbGateway->error_info()));

        $query->execute(array(
            'filename' => $filename
        ));

        $result = $query->fetch(\PDO::FETCH_ASSOC);

        return Fileupload::fromArray($result);
    }

    /**
     * @param Fileupload $fileupload
     * @return bool
     *
     *
     */
    public function saveFileupload(Fileupload $fileupload)
    {
        $id = (int)$fileupload->getId();

        if ($id > 0) {
            $query = $this->dbGateway->prepare("
				UPDATE filesupload 
				SET filesupload_name 	= :name,
				filesupload_date = :filedate
				WHERE filesupload_id 	= :id
			") or die(print_r($this->dbGateway->errors_info()));

            $query->execute(array(
                'name' => $fileupload->getName(),
                'filedate' => $fileupload->getDate(),//date ( string $format [, int $timestamp = time() ] )
                'id' => $fileupload->getId()
            ));
        } else {
            //print_r($fileupload);
            $query = $this->dbGateway->prepare("INSERT INTO filesupload(
            filesupload_name, filesupload_type, filesupload_comment,
            filesupload_status, filesupload_thumbnail,
            filesupload_date,filesupload_thumbnailpath,
            filesupload_path,
            filesupload_author, filesupload_userid,
            filesupload_email, filesupload_lat,
            filesupload_lng) 
            values(:name,
            :type,
            :comment,:status,:thumbnail, :filedate, :thumbnailpath, :path, :author,:userid, :email,:lat,:lng)")
            or die(print_r($this->dbGateway->error_info()));

            $reqIsOK = $query->execute(
                array(
                    "name" => $fileupload->getName(),
                    "path" => $fileupload->getPath(),
                    "type" => $fileupload->getType(),
                    "comment" => $fileupload->getComment(),
                    "status" => $fileupload->getStatus(),
                    "filedate" => $fileupload->getDate(),
                    "thumbnail" => $fileupload->getThumbnail(),
                    "thumbnailpath" => $fileupload->getThumbnailpath(),
                    "author" => $fileupload->getAuthor(),
                    "userid" => $fileupload->getUserid(),
                    "email" => $fileupload->getEmail(),
                    "lat" => $fileupload->getLat(),
                    "lng" => $fileupload->getLng()
                )
            );
            //exit;
            $isOk = false;
            if ($reqIsOK && $query->fetchColumn() > 0) {
                $isOk = true;
            }
            return $isOk;
        }
    }

    /*
     * public function saveFichiers(Fichiers $fichiers)
    {

        $id = (int)$fichiers->getId();

        if ($id > 0) {

            $query = $this->dbGateway->prepare("
				UPDATE fichiers
				SET fichiers_libelle 	= :fichiers_libelle,
                                fichiers_meta           = :fichiers_meta
				WHERE fichiers_id 	= :id
			") or die(print_r($this->dbGateway->errors_info()));

            $query->execute(array(
                'fichiers_libelle' => $fichiers->getLibelle(),
                'fichiers_meta' => $fichiers->getMetaData(),
                'id' => $fichiers->getId()
            ));
        } else {
            //print_r($fichiers);
            //exit;
            $query = $this->dbGateway->prepare("INSERT into fichiers(fichiers_chemin, fichiers_nom, fichiers_type, fichiers_libelle, fichiers_meta, fichiers_thumbnail, fichiers_thumbnailpath)
					values(:fichiers_chemin, :fichiers_nom, :fichiers_type, :fichiers_libelle, :fichiers_meta, :fichiers_thumbnail, :fichiers_thumbnailpath)") or die(print_r($this->dbGateway->error_info()));

            $query->execute(array(
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
     */

}
