<?php
include("../Common/Header.php");
include("../Common/Footer.php");
include("../Common/Functions.php");

session_start();

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

//user info

//get User name    
$userID = $_SESSION["userID"];

$selectStudent = "SELECT * FROM User WHERE UserId = '$userID'";
$IDresult = mysqli_query($link, $selectStudent);


while($user = mysqli_fetch_row($IDresult)){
    $userName = $user[1];
}


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    //used for testing
    //print"<h1>confirmed</h1>";
    extract($_POST);

}

$remainingHours = 16 - $totalHours;

mysqli_close($link);

?>

<h1 style="text-align: center">My Albums</h1>
<br>
<div class="container">
    <form name="removeCourse" id="removeCourse" method="post" action="CurrentRegistration.php" >
    <div class="row">
    <p>Welcome <?php echo $userName?>! (Not you? Change user <a href="Login.php">here</a>).</p>
    </div>
        <div class="row">
            <div class="col-sm-2 col-sm-offset-10">
                <a href="AddAlbum.php">Create a new album</a>
            </div>
        </div>
    <div class="row">
        <label class="text-danger"><?php echo "$warning" ?></label>
        <br>
            <table class="table table-striped">
                <tr>
                    <th>Title</th><th>Date Uploaded</th><th>Number of Pictures</th><th>Accessibility</th><th></th>
                </tr>
                <?php 
                @$link = mysqli_connect('localhost', 'PHPSCRIPT', '1234', 'CST8257', 3306);
                
                $albums = "SELECT *
                    FROM Album
                    WHERE Owner_Id='$userId'";
                
                
                if($allAlbums = mysqli_query($link, $albums)){
                    while($album = mysqli_fetch_row($allAlbums)){
                        print "<tr>";
                        print "<td>$album[1]</td><td>$album[3]</td><td>PLACEHOLDER</td><td><select name='Accessibility'><//select></td><td><a href='MyAlbums.php'>Delete</a></td>";
                        print "</tr>";
                    }
                }
//                echo "<p>".count(mysqli_query($link, $albums))."</p>";
                echo "<p>".mysqli_query($link, $albums)."</p>";
                
                mysqli_close($link);

                ?>
            </table>
        </div>
        <div class="row">
                    <div class="col-sm-2 align-self-center">
                        <input type="button" value="Delete Selected" name='btnSubmit' class="btn btn-primary"  onclick="confirmDelete()">  
                    </div>
                    <div class="col-sm-2">
                        <input type="Submit" value="Clear" class = "btn btn-primary" name='btnReset'>
                    </div>
            </div>
    </form>
        <br>
</div>

<script>
function confirmDelete() {
        var removeCourse = document.getElementById("removeCourse");

    
    var confirmation = confirm("The selected registrations will be deleted!");
    if (confirmation === true) {
        removeCourse.submit();
        return true;

    } else {
        page.reload();
        return false;
    }
}
</script>
