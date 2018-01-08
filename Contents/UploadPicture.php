<?php
include("../Common/Header.php");
include("../Common/Footer.php");
include("../Common/Classes/Picture.php");
include("../Common/Functions.php");
include("../Common/ConstantsAndSettings.php");

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (isset($_POST['btnUpload'])) 
{
    
    $destination = ORIGINAL_PICTURES_DIR;
        
    if (!file_exists($destination))
    {
            mkdir($destination);
    }
    for ($j = 0; $j < count($_FILES['picUpload']['tmp_name']); $j++)
    {
        if ($_FILES['picUpload']['error'][$j] == 0)
        {
                $fileTempPath = $_FILES['picUpload']['tmp_name'][$j];
                $_FILES['picUpload']['name'][$j] = str_replace(' ', '_', $_FILES['picUpload']['name'][$j]); //should replace all whitespace with '_'
                $filePath = $destination."/".$_FILES['picUpload']['name'][$j];

                $pathInfo = pathinfo($filePath);
                $dir = $pathInfo['dirname'];
                //$fileName = $pathInfo['filename'];
                $fileName = str_replace(' ', '_', $pathInfo['filename']);       //should replace all whitespace with '_'
                $ext = $pathInfo['extension'];

                $i="";
                while (file_exists($filePath))
                {	
                        $i++;
                        $filePath = $dir."/".$fileName."_".$i.".".$ext;
                }
                move_uploaded_file($fileTempPath, $filePath);
                resamplePicture($filePath, ALBUM_THUMBNAILS_DIR, THUMB_MAX_WIDTH, THUMB_MAX_HEIGHT);
                resamplePicture($filePath, ALBUM_PICTURES_DIR, IMAGE_MAX_WIDTH, IMAGE_MAX_HEIGHT);
        }
        elseif ($_FILES['picUpload']['error'][$j]  == 1)
        {			
                $error = "$fileName is too large<br/>";
        }
        elseif ($_FILES['picUpload']['error'][$j]  == 4)
        {
                $error = "No upload file specified<br/>"; 
        }
        else
        {
                $error = "Error happened while uploading the file(s). Try again late<br/>"; 
        }
    }
}
?>

<div class="container">
    <h1 style="text-align: center;">Upload Pictures</h1>
    <br>
    <p>Accepted picture types: JPG (JPEG), GIF, and PNG.</p>
    <br>
    <p>You can upload multiple pictures at the same time by pressing the shift 
        key while uploading pictures</p>
    <br>
    <p style="color: red;"><?php echo "$error" ?></p>
    <form action="UploadPicture.php" method="post"  enctype="multipart/form-data" accept="image/jpg, png, gif" style="background-color: lightgray;" >
        File to Upload:&nbsp; <input type="file" name="picUpload[]" multiple size="40"/>
        
        
        <br/><br/>
		<input type="submit" name="btnUpload" value="Upload" />
		&nbsp; &nbsp; &nbsp;<input type="reset" name="btnReset" value="Clear" />
   </form> 
   </form> 
</div>