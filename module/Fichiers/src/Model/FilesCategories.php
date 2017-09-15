<?php

namespace Fichiers\Model;

class FilesCategories{
     
    public static $listeextension = array('jpg', 'jpeg', 'png', 'bmp', 'gif', 'svg', 'doc', 'docx', 'rtf', 'txt', 'xls', 'xlsx', 
        'csv','ppt', 'pptx', 'pdf', 'epub', 'odt', 'ods', 'mp4', 'mkv', 'ogv', 'mp3', 'wav', 'ogg', 'zip', 'gz', 'tar');
    public static $imgList = array('jpg', 'jpeg', 'png', 'bmp', 'gif', 'svg');
    public static $wordList = array('doc', 'docx', 'odt', 'rtf', 'txt');
    public static $excelList = array('xls', 'xlsx', 'ods', 'csv');
    public static $presentationList = array('ppt', 'pptx', 'odp');
    public static $audioList = array('mp3', 'wav', 'ogg');
    public static $videoList = array('mp4', 'mkv', 'ogv');
    public static $documentList = array('pdf', 'epub');
    public static $archiveList = array('gz', 'zip', 'tar');
    
    public static $wordImg = 'word.png';
    public static $documentImg = 'pdf.png';
    public static $excelImg= 'excel.png';
    public static $audioImg= 'audio.png';
    public static $videoImg= 'video.png';
    public static $presentationImg= 'powerpoint.png';
    public static $archiveImg = 'zipfile.png';
}
