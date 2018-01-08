<?php
include("../Common/Header.php");
include("../Common/Footer.php");
include("../Common/Picture.php");
include("../Common/Functions.php");

$destination = ORIGINAL_PICTURES_DIR;

$pictures = Picture::getPictures();

if (empty(scandir($destination)) || count($pictures) <= 0){                                              
    $imageTitle = "Image directory is empty. Upload pictures to view them on this page.";
}

$action = $_GET["Action"];

if ($_GET["Id"] != null){
    $selectedImageId = $_GET["Id"];
}
else {
    if (count($pictures==0)){
        $selectedImageId = 0;
    }
    else{
        $selectedImageId = $pictures[0]->getId();
    }
}

$selectedImage = $pictures[$selectedImageId];


?>



<div class="container">
    <h1 style="text-align: center;"><?php echo "$imageTitle" ?></h1>
    <br>
    <div class="container-fluid"><h1><?php echo "$message" ?></h1>
        
    <form action="MyPictures.php" method="get" style="background-color: lightgray;">
    <?php
    if (!empty($pictures)){
        //var_dump($pictures);
        //exit;

        if ($selectedImageId != null){
            $bigPath = $pictures[$selectedImageId]->getAlbumFilePath();
        }
        else{
            $selectedImageId = 0;
            $bigPath = $pictures[$selectedImageId]->getAlbumFilePath();
        }
        
        $id = $selectedImageId;
        
        echo "<div style=\"position: relative;\" class=\"img-container\">";
        echo "<img class=\"img-responsive center-block\" src=$bigPath></img>";
        echo "<a href=\"MyPictures.php?Id=$id&Action=rotateLeft\" class=\"glyphicon glyphicon-repeat gly-flip-horizontal\"></a>";
        echo "<a href=\"MyPictures.php?Id=$id&Action=rotateRight\" class=\"glyphicon glyphicon-repeat\"></a>";
        echo "<a href=\"MyPictures.php?Id=$id&Action=download\" class=\"glyphicon glyphicon-download-alt\"></a>";
        echo "<a href=\"MyPictures.php?Id=$id&Action=delete\" class=\"glyphicon glyphicon-trash\"></a>";
        echo "</div>";
    }
    
    if ($action === "rotateLeft"){
        rotateImage($pictures[$selectedImageId]->getOriginalFilePath(), 90);
        rotateImage($pictures[$selectedImageId]->getThumbnailFilePath(), 90);
        rotateImage($pictures[$selectedImageId]->getAlbumFilePath(), 90);
        header("Location: MyPictures.php?Id=$id");
    }
    
    if ($action === "rotateRight"){
        rotateImage($pictures[$selectedImageId]->getOriginalFilePath(), -90);
        rotateImage($pictures[$selectedImageId]->getThumbnailFilePath(), -90);
        rotateImage($pictures[$selectedImageId]->getAlbumFilePath(), -90);
        header("Location: MyPictures.php?Id=$id");
    }
    
    if ($action === "download"){
        downloadFile($pictures[$selectedImageId]->getOriginalFilePath());
        header("Location: MyPictures.php?Id=$id");
    }
    
    if ($action === "delete"){
        
        for ($j = count($pictures)-1; $j > -1; $j--){
            if ($pictures[$j]->getId()-2 == $selectedImageId){
                unlink($pictures[$j]->getOriginalFilePath());
                unlink($pictures[$j]->getThumbnailFilePath());
                unlink($pictures[$j]->getAlbumFilePath());
            }
            header("Location: MyPictures.php?");
        }
        
    }
    
    ?>
    </div>
    <br>
    <br>
    <br>
    <div class="scrollmenu">
        <?php 
        $files = scandir($destination);
        
        foreach ($pictures as $picture){
            $path = $picture->getThumbnailFilePath();
            $id = $picture->getId() - 2;
            echo "<a href=\"MyPictures.php?Id=$id\"><img style=\"display: inline-block; float: none;\" src=$path></a>";
        }
        
        ?>
    </div>
   </form> 
</div>



