<?php

namespace Mapcontent\Model;

use Contenu\Model\IContenu;

interface IMapcontent extends IContenu {
    public function getGpsInfoList();
    public function setGpsInfoList($_gpsInfo);
}


