<?php

//include_once "ConstantsAndSettings.php";
include("/../ConstantsAndSettings.php");

class Picture {
    private $fileName;
    private $id;
    public $title;
    private $albumId;
    private $date;
    private $description;
    
    public static function getPictures(){
        $pictures = array();
        $files = scandir(ALBUM_THUMBNAILS_DIR);
        $numFiles = count($files);
        if ($numFiles > 2){                                                     // 0 was 2 before as Wei wrote it
            for ($i = 2; $i < $numFiles; $i++){                                 // 0 was 2 before as Wei wrote it
                $ind = strrpos($files[$i], "/");
                //$fileName = substr($files[$i], $ind);
                $fileName = str_replace(' ', '_',(substr($files[$i], $ind)));
                str_replace(' ', '_', $fileName);
                $picture = new Picture($fileName, $i);
                array_push($pictures, $picture);
                //$pictures["$i"] = $picture;
            }
        }
        return $pictures;
        
    }
    
    public function __construct($fileName, $id, $title, $albumId, $date, $description) {
        //$this->fileName = $fileName;
        $this->fileName = str_replace(' ', '_', $fileName);
        $this->id = $id;
        $this->title = $title;
        $this->albumId = $albumId;
        $this->date = $date;
        $this->description = $description;
    }
    public function getId(){
        return $this->id;
    }
    public function getName(){
        $ind = strrpos($this->fileName, ".");
        $name = substr($this->fileName, 0, $ind);
        return $name;
    }
    public function getAlbumFilePath(){
        return ALBUM_PICTURES_DIR."/".$this->fileName;
    }
    public function getThumbnailFilePath(){
        return ALBUM_THUMBNAILS_DIR."/".$this->fileName;
    }
    public function getOriginalFilePath(){
        return ORIGINAL_PICTURES_DIR."/".$this->fileName;
    }
    
}


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

