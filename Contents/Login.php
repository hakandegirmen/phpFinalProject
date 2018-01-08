<?php
include("../Common/Header.php");
include("../Common/Footer.php");
include("../Common/Functions.php");

if (!isset($btnLogin)) {
    //session_destroy();
}

extract($_POST);

if (isset($_SESSION["userID"])){
    $userID = $_SESSION["userID"];
}
else{
    $userID = "";
}

if (isset($btnLogin)) {
    
//    $invalid = array();
    
    $name = trim($_POST["name"]);
    $userID = (string) $_POST["userID"];
    $pNumber = (string) $_POST["pNumber"];
    $password = (string) $_POST["password"];
    $password2 = (string) $_POST["password2"];
    //$email = (string) $_POST["email"];

    @$link = mysqli_connect('localhost', 'PHPSCRIPT', '1234', 'CST8257', 3306);

    if (!$link)  {
        die('System is currently unavailable, please try later.' );
    }
    
    $_SESSION["userID"] = $userID;

    //validations
    $selectStudent = "SELECT UserId FROM User WHERE UserId = '$userID'";
    $selectPassword = "SELECT password FROM User WHERE UserId = '$userID'";
    $IDresult = mysqli_query($link, $selectStudent);
    $PWresult = mysqli_query($link, $selectPassword);
    
    while($studentPass = mysqli_fetch_row($PWresult)){
        $realPassword = $studentPass[0];
        
    }
    
    if (trim($userID) == "" || mysqli_fetch_row($IDresult)==NULL){
        $validated = "Student ID is blank or does not exists in database";
    }
    
    elseif(trim($password) == "" || $realPassword!=$password){
        $validated = "Password is blank or does not match user name";
    }

    elseif($realPassword==$password){
        $_SESSION["userID"] = $userID;
        $_SESSION["login"] = "true";
        header('Location: Index.php');
    }
    mysqli_close($link);
    
}

    //FUNCTION FOR RESET BUTTON
elseif (isset($btnReset)) {
    resetValidation();
    //session_destroy();
    header('Location: Login.php');
}

?>


<body>
       <div id="form1" class="form-group" style = "opacity: <?php echo $valid ?>">
            <div class="container align-self-start">
                <div class="row">
                    <div class="col-sm-4 align-self-start">
                    <h1 style="text-align: center">Log in</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 align-self-start">
                        <h5>You need to <a href="NewUser.php">sign up</a> if you are a new user.</h5>
                    </div>
                    <br>
                </div>
                </div>
            <br>
                <div clas="row">
                <form  action= 'Login.php' method='post' class="form-horizontal">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-7 algin-self-end">
                                <p class="text-danger"><?php echo $validated;?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2 algin-self-start">
                                <label style="margin-bottom: 2rem" class="h5">Student ID:</label><br>
                                </div>
                            <div class="col-sm-3 algin-self-center">
                                <input style="margin-bottom: 1.5rem" type="text" name="userID" class="form-control" value = <?php echo $userID?>> 
                            </div>
                            
                            </div>
                       
                        <div class="form-group">
                            <div class="col-sm-2 algin-self-start">
                                <label style="margin-bottom: 2rem" class="h5">Password: </label>
                                </div>
                            <div class="col-sm-3 algin-self-center">
                                <input style="margin-bottom: 1.5rem" type="password" name="password" class="form-control">  
                            </div>
                            
                            </div>
                        
                <div class="row">
                    <div class="col-sm-2 algin-self-center">
                        <input type="submit" value="Submit" name='btnLogin' class="btn btn-primary">  
                    </div>
                    <div class="col-sm-2">
                        <input type="Submit" value="Clear" class = "btn btn-primary" name='btnReset'>
                    </div>
                        </div>
                        
                    </div>
                </form>
            
         </div>   
        </div>
    </body>
