<?php

namespace Mapcontent\Model;

use Contenu\Model\Contenu;
use Mapcontent\Model\GpsInfo;

class Mapcontent extends Contenu implements IMapcontent {

    protected $gpsInfoList;

    public function __construct() {
        parent::__construct();
    }

    public function getGpsInfoList()
    {
        return $this->gpsInfoList;
    }

    public function setGpsInfoList($_gpsInfoList)
    {
        $gpsInfos = array();
        //print_r($_gpsInfoList);
        //exit;
        foreach($_gpsInfoList as $value) {
            //print_r($value);
            $gpsInfo['latitude'] = $value->latitude;
            $gpsInfo['longitude'] = $value->longitude;
            $gpsInfo['description'] = $value->description;
            array_push($gpsInfos, $gpsInfo);
        }

        $this->gpsInfoList = json_encode($gpsInfos);
    }
}
