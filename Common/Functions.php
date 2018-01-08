<?php
    include("/ConstantsAndSettings.php");

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//function to reset validation
//dont know how to call it from within html

@$link = mysqli_connect('localhost', 'PHPSCRIPT', '1234', 'CST8257', 3306);

function resetValidation() {
    global $invalid;
    foreach ((array) $invalid as $item) {
        $item = "";
    }
    session_destroy();
}

//array add function
function validationArray ($item){
    global $invalid;
    if (empty($invalid)){
        $invalid = array($item);
    }
    else{
        array_push($invalid, $item);
    }
    return $invalid;
}

//update inputs function to remove whitespace
function removeWhiteSpace ($item){
    $item = str_replace(" ","",$item);
    return $_item;
}

//REGULAR EXPRESSIONS ----------------------------------------------------------
$postalCodeRegex = '/[a-z][0-9][a-z]\s*[0-9][a-z][0-9]/i';
$phoneNumberRegex = '/[2-9]\d{2}-[2-9]\d{2}-\d{4}$/';
$emailRegex = '\b[a-zA-Z0-9._%+-]+@(([a-zA-Z0-9-]+)\.)+[a-zA-Z]{2,4}\b';


// VALIDATION FUNCTIONS---------------------------------------------------------

Function ValidateID($studentID){
    @$link = mysqli_connect('localhost', 'PHPSCRIPT', '1234', 'CST8257', 3306);
    $selectStudent = "SELECT * FROM User WHERE UserId = '$studentID'";
    $result = mysqli_query($link, $selectStudent);
    if (!trim($studentID) == "" && !mysqli_fetch_row($result)==NULL){
        $validatedID = "User ID already exists in database";
    }
    elseif (trim($studentID, ' ') == ""){
        $validatedID = "User ID cannot be blank";
    }
    else {
        $validatedID = "";
    }
    return $validatedID;
    mysqli_close($link);
}

function ValidateName($name) {
    if (!$name == "") {
        //$name = $_POST["name"];
//        $name = ", " . $name . ", ";
        $valid = "true";
        $nameValidator = " ";
    } else {
        $nameValidator = "Name cannot be blank.";
        validationArray ($nameValidator);
    }
    return $nameValidator;
    }
    
function ValidatePhone($pNumber) {
    $phoneNumberRegex = '/[2-9]\d{2}-[2-9]\d{2}-\d{4}$/';
    if (!$pNumber == "" && preg_match($phoneNumberRegex, $pNumber)) {
        //$pNumber = $_POST["pNumber"];
        $valid = "true";
        $pNumberValidator = " ";
    } else {
        $pNumberValidator = "Phone number cannot be blank and must be in format NNN-NNN-NNNN.";
        validationArray ($pNumberValidator);
    }
    return $pNumberValidator;
    }

function ValidatePW($password) {
    $pwRegex = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/';
    if (!$password == "" && preg_match($pwRegex, $password)) {
        $valid = "true";
        $passwordValidator = " ";
    } else {
        $passwordValidator = "Password must be at least 6 characters long, contain an uppercase letter, lowercase letter, a number, and cannot be blank.";
        validationArray ($nameValidator);
    }
    return $passwordValidator;
    }

function ValidatePW2($password, $password2) {
    if ($password === $password2) {
        $valid = "true";
        $password2Validator = " ";
    } else {
        $password2Validator = "Passwords do not match";
        validationArray ($nameValidator);
    }
    return $password2Validator;
    }
    
    mysqli_close($link);

    
    //PICTURE FUNCTIONS --------------------------------------------------------
    
function save_uploaded_file($destinationPath)
{
	if (!file_exists($destinationPath))
	{
		mkdir($destinationPath);
	}
	
	$tempFilePath = $_FILES['picUpload']['tmp_name'];
	$filePath = $destinationPath."/".$_FILES['picUpload']['name'];
	
	$pathInfo = pathinfo($filePath);
	$dir = $pathInfo['dirname'];
	//$fileName = $pathInfo['filename'];
        $fileName = str_replace(' ', '_', $pathInfo['filename']);               //first file in directory isnt having spaces replaced?
	$ext = $pathInfo['extension'];
	
	//make sure not to overwrite existing files 
	$i="";
	while (file_exists($filePath))
	{	
		$i++;
		$filePath = $dir."/".$fileName."_".$i.".".$ext;
	}
	move_uploaded_file($tempFilePath, $filePath);
	
	return $filePath;
}

function resamplePicture($filePath, $destinationPath, $maxWidth, $maxHeight)
{
	if (!file_exists($destinationPath))
	{
		mkdir($destinationPath);
	}

	$imageDetails = getimagesize($filePath);
	
	$originalResource = null;
	if ($imageDetails[2] == IMAGETYPE_JPEG) 
	{
		$originalResource = imagecreatefromjpeg($filePath);
	} 
	elseif ($imageDetails[2] == IMAGETYPE_PNG) 
	{
		$originalResource = imagecreatefrompng($filePath);
	} 
	elseif ($imageDetails[2] == IMAGETYPE_GIF) 
	{
		$originalResource = imagecreatefromgif($filePath);
	}
	$widthRatio = $imageDetails[0] / $maxWidth;
	$heightRatio = $imageDetails[1] / $maxHeight;
	$ratio = max($widthRatio, $heightRatio);
	
	$newWidth = $imageDetails[0] / $ratio;
	$newHeight = $imageDetails[1] / $ratio;
	
	$newImage = imagecreatetruecolor($newWidth, $newHeight);
	
	$success = imagecopyresampled($newImage, $originalResource, 0, 0, 0, 0, $newWidth, $newHeight, $imageDetails[0], $imageDetails[1]);
	
	if (!$success)
	{
		imagedestroy(newImage);
		imagedestroy(originalResource);
		return "";
	}
	$pathInfo = pathinfo($filePath);
	$newFilePath = $destinationPath."/".$pathInfo['filename'];
	if ($imageDetails[2] == IMAGETYPE_JPEG) 
	{
		$newFilePath .= ".jpg";
		$success = imagejpeg($newImage, $newFilePath, 100);
	} 
	elseif ($imageDetails[2] == IMAGETYPE_PNG) 
	{
		$newFilePath .= ".png";
		$success = imagepng($newImage, $newFilePath, 0);
	} 
	elseif ($imageDetails[2] == IMAGETYPE_GIF) 
	{
		$newFilePath .= ".gif";
		$success = imagegif($newImage, $newFilePath);
	}
	
	imagedestroy($newImage);
	imagedestroy($originalResource);
	
	if (!$success)
	{
		return "";
	}
	else
	{
		return newFilePath;
	}
}

function rotateImage($filePath, $degrees)
{
	$imageDetails = getimagesize($filePath);
	
	$originalResource = null;
	if ($imageDetails[2] == IMAGETYPE_JPEG) 
	{
		$originalResource = imagecreatefromjpeg($filePath);
	} 
	elseif ($imageDetails[2] == IMAGETYPE_PNG) 
	{
		$originalResource = imagecreatefrompng($filePath);
	} 
	elseif ($imageDetails[2] == IMAGETYPE_GIF) 
	{
		$originalResource = imagecreatefromgif($filePath);
	}
	
	$rotatedResource = imagerotate($originalResource, $degrees, 0);
	
	if ($imageDetails[2] == IMAGETYPE_JPEG) 
	{
		$success = imagejpeg($rotatedResource, $filePath, 100);
	} 
	elseif ($imageDetails[2] == IMAGETYPE_PNG) 
	{
		$success = imagepng($rotatedResource, $filePath, 0);
	} 
	elseif ($imageDetails[2] == IMAGETYPE_GIF) 
	{
		$success = imagegif($rotatedResource, $filePath);
	}
	
	imagedestroy($rotatedResource);
	imagedestroy($originalResource);
}

function downloadFile($filePath){
    $fileName = basename($filePath);
    $fileLength = filesize($filePath);
    
    header("Content-type: image/octet-stream");
    header("content-Disposition: attachment; filename = \"$fileName\"");
    header("Content-Length: $fileLength");
    header("Content-Description: File Transfer");
    header("Expires: 0");
    header("Cache-Control: must-revalidate");
    header("Pragma: private");
    
    ob_clean();
    flush();
    readfile($filePath);
    flush();
}