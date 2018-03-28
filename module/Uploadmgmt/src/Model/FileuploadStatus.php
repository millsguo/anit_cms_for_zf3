<?php

namespace Uploadmgmt\Model;

class FileuploadStatus
{
    public static $WAITING = 'waiting';
    public static $VALIDATED = 'validated';
    public static $REFUSED = 'refused';
    public static $OBSOLETE = 'obsolete';

    public static $FILE_STATUS_LIST = array(
        'waiting' => 'waiting', 'validated' => 'validated', 'refused' => 'refused', 'obsolete' => 'obsolete'
    );

}