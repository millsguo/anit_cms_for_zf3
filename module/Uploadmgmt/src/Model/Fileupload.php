<?php

namespace Uploadmgmt\Model;

class Fileupload
{
    private $id;
    private $name;
    private $path;
    private $type;
    private $comment;
    private $status;
    private $thumbnail;
    private $thumbnailpath;
    private $author;
    private $userid;
    private $email;
    private $date;
    private $lat;
    private $lng;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @param mixed $thumbnail
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @return mixed
     */
    public function getThumbnailpath()
    {
        return $this->thumbnailpath;
    }

    /**
     * @param mixed $thumbnailpath
     */
    public function setThumbnailpath($thumbnailpath)
    {
        $this->thumbnailpath = $thumbnailpath;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @param mixed $userid
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param mixed $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * @return mixed
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @param mixed $lng
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
    }

    public static function fromArray($row)
    {
        $instance = new self();
        $instance->exchangeArray($row);

        return $instance;
    }

    /*
     * private static $fields = "p.filesupload_id as id, p.filesupload_name as name, p.filesupload_path as path, p.filesupload_type as type," .
    "p.filesupload_comment as comment, p.filesupload_status as status, p.filesupload_thumbnail as thumbnail, p.filesupload_thumbnailpath as thumbnailpath," .
    "p.filesupload_author as author, p.filesupload_userid as userid, p.filesupload_email as email, p.filesupload_date as creationdate," .
    "p.filesupload_lat as lat, p.filesupload_lng as lng";
     */

    private function exchangeArray($data)
    {
        if (isset($data['id'])) {
            $this->setId($data['id']);
        }
        if (isset($data['name'])) {
            $this->setName($data['name']);
        }
        if (isset($data['path'])) {
            $this->setPath($data['path']);
        }
        if (isset($data['type'])) {
            $this->setType($data['type']);
        }
        if (isset($data['comment'])) {
            $this->setComment($data['comment']);
        }
        if (isset($data['status'])) {
            $this->setStatus($data['status']);
        }
        if (isset($data['thumbnailpath'])) {
            $this->setThumbnailpath($data['thumbnailpath']);
        }
        if (isset($data['thumbnail'])) {
            $this->setThumbnail($data['thumbnail']);
        }
        if (isset($data['author'])) {
            $this->setAuthor($data['author']);
        }
        if (isset($data['userid'])) {
            $this->setUserid($data['userid']);
        }
        if (isset($data['email'])) {
            $this->setEmail($data['email']);
        }
        if (isset($data['creationdate'])) {
            $this->setDate($data['creationdate']);
        }
        if (isset($data['lat'])) {
            $this->setLat($data['lat']);
        }
        if (isset($data['lng'])) {
            $this->setLng($data['lng']);
        }
    }

}