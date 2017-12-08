<?php

namespace Uploadmgmt\Model;

use Application\DBConnection\Anitmobdao;
use Uploadmgmt\Fileupload;

class Uploadmgmtdao extends AnitmobDao {

    private static $fields = "p.filesupload_id as id, p.filesupload_name as name, p.filesupload_path as path, p.filesupload_type as type,".
    "p.filesupload_comment as comment, p.filesupload_status as status, p.filesupload_thumbnail as thumbnail, p.filesupload_thumbnailpath as thumbnailpath,".
    "p.filesupload_author as author, p.filesupload_userid as userid, p.filesupload_email as email, p.filesupload_date as creationdate,".
    "p.filesupload_lat as lat, p.filesupload_lng as lng";

    public function getPhoto($idPhoto = 0) {
        $requete = $this->dbGateway->prepare('SELECT '. $this::$fields .' FROM filesupload p WHERE filesupload_id=' . abs((int) $idPhoto)) or die(print_r($this->dbGateway->error_info()));
        $requete->execute();
        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);
        //die('<pre>'.print_r($requete2,true).'</pre>');
        return $requete2;
    }

    public function getPhotoWaitStatus() {
        $requete = $this->dbGateway->prepare('SELECT '.$this::$fields.' FROM filesupload p WHERE p.filesupload_status=0 ORDER BY p.Date DESC')
        or die(print_r($this->dbGateway->error_info()));
        $requete->execute();
        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);
        return $requete2;
    }

    public function getPhotoValidateStatus() {
        $requete = $this->dbGateway->prepare('SELECT '.$this::$fields.' filesupload p WHERE p.filesupload_status=1 ORDER BY p.Date DESC') or die(print_r($this->dbGateway->error_info()));
        $requete->execute();
        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);
        return $requete2;
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
        $requete = $this->dbGateway->prepare($sql) or die(print_r($this->dbGateway->error_info()));
        $reqIsOK = $requete->execute();
        return $reqIsOK;
    }
*/
    public function update($idPhoto = 0, $params = array()) {
        $idPhoto = abs((int) $idPhoto);
        if ($idPhoto < 1) {
            die(json_encode(array('error'=>$this->translate('numero de photo invalide ' . __LINE__))));
        }
        $sql = 'UPDATE filesupload SET filesupload_comment=:commenter WHERE filesupload_id=:idPhoto';
        $requete = $this->dbGateway->prepare($sql) or die(print_r($this->dbGateway->error_info()));
        $reqIsOK = $requete->execute(array(
            'commenter' => $params['commenter'],
            'idPhoto' => $idPhoto
        ));
        return $reqIsOK;
    }

    public function getAllPhotos($sqlpart, $start){
        
        $sql = "SELECT ". $this::$fields
                . " FROM filesupload p where p.filesupload_status=1 " . $sqlpart
                . " ORDER BY p.fileupload_date DESC "
                . " LIMIT " . $start . ", 30";

        $requete = $this->dbGateway->prepare($sql)or die(print_r($this->dbGateway->error_info()));
        $reqIsOK = $requete->execute();
        
        if ($reqIsOK) {
            
            $result = $requete->fetchAll(\PDO::FETCH_ASSOC);
            
            if(count($result)>0){
               return $result; 
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

    /**
     * @param Fileupload $fileupload
     * @return bool
     *
     *
     */
    public function saveFileupload(Fileupload $fileupload){
        $sql ="INSERT INTO filesupload SET filesupload_name=:name
            . ,filesupload_type=:type, filesupload_comment=:comment,
            . , filesupload_status=:status, filesupload_thumbnail=:thumbnail,
            . , fileupload_date= :filedate ,filesupload_thumbnailpath=:thumbnailpath
            . ,fileupload_path=:path
            . , filesupload_author=:author, filesupload_userid=:userid
            . , filesupload_email=:email, filesupload_lat=:lat
            . , filesupload_lng=:lng";
        $requete = $this->dbGateway->prepare($sql)or die(print_r($this->dbGateway->error_info()));
        $reqIsOK = $requete->execute(
            array(
                "name"=>$fileupload->getName(),
                "path"=>$fileupload->getPath(),
                "type"=>$fileupload->getType(),
                "comment"=>$fileupload->getComment(),
                "status"=>$fileupload->getStatus(),
                "thumbnail"=>$fileupload->getThumbnail(),
                "thumbnailpath"=>$fileupload->getThumbnailpath(),
                "filedate"=>$fileupload->getDate(),
                "author"=>$fileupload->getAuthor(),
                "userid"=>$fileupload->getUserid(),
                "email"=>$fileupload->getEmail(),
                "lat"=>$fileupload->getLat(),
                "lng"=>$fileupload->getLng()
            )
        );
        $isOk = false;
        if($reqIsOK && $requete->fetchColumn()>0){
            $isOk = true;
        }
        return $isOk;
    }

}
