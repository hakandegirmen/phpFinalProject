<?php
include("../Common/Header.php");
include("../Common/Footer.php");
include("../Common/Functions.php");

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (!isset($_SESSION["login"])){
    header('Location: Login.php');
}

extract($_POST);

@$link = mysqli_connect('localhost', 'PHPSCRIPT', '1234', 'CST8257', 3306);

//student info

//get student name    
$userID = $_SESSION["userID"];


$selectStudent = "SELECT * FROM User WHERE UserId = '$userID'";
$IDresult = mysqli_query($link, $selectStudent);


while($student = mysqli_fetch_row($IDresult)){
    $userName = $student[1];
}


//get student's total weekly hours
$hours = "SELECT * 
    FROM Course 
    INNER JOIN Registration 
    ON Course.CourseCode = Registration.CourseCode 
    WHERE Registration.StudentId='$studentID'
    AND Registration.SemesterCode='$semester'";
$hrsResult = mysqli_query($link, $hours);

while($weeklyHours = mysqli_fetch_row($hrsResult)){
    $totalHours += $weeklyHours[2];
}

if (isset($btnSubmit)){
    $date = getdate()["year"]."-".getdate()["mon"]."-".getdate()["mday"];
    //maybe create a new album object here?
    //echo "<p>".$date."</p>";
    
    
    //check if title already exists
    $selectAlbum = "SELECT * FROM Album WHERE Title = '$title'
            AND Owner_Id = '$userID'";
    $result = mysqli_query($link, $selectAlbum);
    if (!trim($userID) == "" && !mysqli_fetch_row($result)==NULL){
        $validatedTitle = "Album tile for this user already exists in database";
    }
    elseif (trim($title, ' ') == ""){
        $validatedTitle = "Title cannot be blank";
    }
    else{
        $addAlbum = "INSERT INTO Album VALUES('NULL', '$title', '$description', '$date', '$userID', '$type')";
        mysqli_query($link, $addAlbum);
        header('Location: AddAlbum.php');
    }
    

}

mysqli_close($link);
?>

<h1 style="text-align: center">Add New Album</h1>
<br>
<div class="container">
    <form name="addAlbum" id="addAlbum" method="post" action="AddAlbum.php">
    <div class="row">
    <p>Welcome <?php echo $userName?>! (Not you? Change user <a href="Login.php">here</a>)</p>
    </div>
            <div class="row">

    <div class="form-group">
        <div class="col-sm-2 algin-self-start">
            <label style="margin-bottom: 2rem" class="h5">Title:</label><br>
        </div>
        <div class="col-sm-3 algin-self-center">
            <input style="margin-bottom: 1.5rem" type="text" name="title" class="form-control" value = <?php echo $title?>> 
        </div>
        <div class="col-sm-7 algin-self-end">
            <p style="margin-bottom: 3rem" class="text-danger"><?php echo $validatedTitle;?></p>
        </div>

    </div>
            </div>
            <div class="row">

        <div class="form-group">
            <div class="col-sm-2 algin-self-start">
            <label style="margin-bottom: 2rem" class="h5">Accessibility:</label><br>
        </div>
        <div class="col-sm-4">
            <select id="semester" name="type" class="form-control" value="semester">
                <?php 
                @$link = mysqli_connect('localhost', 'PHPSCRIPT', '1234', 'CST8257', 3306);

                $accessibilities = "SELECT * FROM Accessibility";
                
                if($result = mysqli_query($link, $accessibilities)){

                    while($accessibility = mysqli_fetch_row($result)){
                        print "<option value=$accessibility[0]>$accessibility[1]</option>";
                    }
                }
                
                mysqli_close($link);

                ?>
              </select>
            </div>
        <br>
        <label class="text-danger"><?php echo "$warning" ?></label>
        </div>
            </div>
        
        <div class="row">

    <div class="form-group">
        <div class="col-sm-2 algin-self-start">
            <label style="margin-bottom: 2rem" class="h5">Description:</label><br>
        </div>
        <div class="col-sm-4 algin-self-center">
            <textarea style="margin-bottom: 1.5rem" name="description" type="text" rows="10" name="title" class="form-control" value = <?php echo $description?>><?php echo $description?></textarea> 
        </div>
        <div class="col-sm-7 algin-self-end">
            <p style="margin-bottom: 3rem" class="text-danger"><?php echo $validatedName;?></p>
        </div>

    </div>
            </div>
        
        <div class="row">
                    <div class="col-sm-2 algin-self-center">
                        <input type="submit" value="Submit" name='btnSubmit' class="btn btn-primary">  
                    </div>
                    <div class="col-sm-2">
                        <input type="reset" value="Clear" class = "btn btn-primary" name='btnReset'>
                    </div>
            </div>
    </form>
        <br>
</div>

<script>
//function semesterChange() {
//    var semesterForm = document.getElementById("selectCourse");
//   semesterForm.submit();
//}
</script>
