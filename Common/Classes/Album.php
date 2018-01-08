<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Album {
    private $access;
    private $id;
    public $date;
    private $description;
    private $owner;
    
    function __construct($access, $id, $date, $description, $owner) {
        $this->access = $access;
        $this->id = $id;
        $this->date = $date;
        $this->description = $description;
        $this->owner = $owner;
    }
    
    public static function getPictures(){
        $pictures = array();
        $files = scandir($this->id/ALBUM_THUMBNAILS_DIR);
        $numFiles = count($files);
        if ($numFiles > 2){    
            for ($i = 2; $i < $numFiles; $i++){                                 
                $ind = strrpos($files[$i], "/");
                $fileName = str_replace(' ', '_',(substr($files[$i], $ind)));
                str_replace(' ', '_', $fileName);
                $picture = new Picture($fileName, $i);
                array_push($pictures, $picture);
            }
        }
        return $pictures;
    }
    
        public function getId(){
        return $this->id;
    }

    
}

