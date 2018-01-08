<?php
include("../Common/Header.php");
include("../Common/Footer.php");
include("../Common/Functions.php");

if (!isset($btnLogin)) {
    session_destroy();
}

extract($_POST);

if (isset($_SESSION["userID"])){
    $studentID = $_SESSION["userID"];
}
else{
    $studentID = "";
}

if (isset($_SESSION["name"])){
    $name = $_SESSION["name"];
}
else{
    $name = "";
}

if (isset($_SESSION["pNumber"])){
    $pNumber = $_SESSION["pNumber"];
}
else{
    $pNumber = "";
}


if (isset($btnLogin)) {
    
//    $invalid = array();
    
    $name = trim($_POST["name"]);
    $studentID = (string) $_POST["userID"];
    $pNumber = (string) $_POST["pNumber"];
    $password = (string) $_POST["password"];
    $password2 = (string) $_POST["password2"];
    //$email = (string) $_POST["email"];

    @$link = mysqli_connect('localhost', 'PHPSCRIPT', '1234', 'CST8257', 3306);

    if (!$link)  {
        die('System is currently unavailable, please try later.' );
    }
    
    $_SESSION["name"] = $name;
    $_SESSION["userID"] = $studentID;
    $_SESSION["pNumber"] = $pNumber;

//    $selectStudent = "SELECT * FROM Student WHERE studentId = '$studentID'";
//    $result = mysqli_query($link, $selectStudent);
//    if (mysqli_fetch_row($result)==NULL){
//        $validatedID = "Null";
//    }

    //individual validations
    $validatedName = ValidateName($name);
    $validatedID = ValidateID($userId);
    $validatedPhone = ValidatePhone($pNumber);
    $validatedPW = ValidatePW($password);
    $validatedPW2 = ValidatePW2($password, $password2);
    
    //ValidateName($name);
    


    
    
    if (count($invalid) > 0 || $valid == 1) {
        //$valid = 1;
        //echo 'invalid';

    } else {
//        $insertStudent = "INSERT INTO student VALUES( ‘$id’, ‘$name’, ‘$phone’, ‘$pin’)";
        $insertUser = "INSERT INTO User VALUES('$userId', '$name', '$pNumber', '$password')";
        mysqli_query($link, $insertUser );
        
        
        header("Location: Index.php");
    }
    
    mysqli_close($link);
    
}

    //FUNCTION FOR RESET BUTTON
elseif (isset($btnReset)) {
    resetValidation();
    //session_destroy();
    header('Location: NewUser.php');
}

?>


<body>
       <div id="form1" class="form-group" style = "opacity: <?php echo $valid ?>">
            <div class="container align-self-start">
                <div class="row">
                    <div class="col-sm-4 align-self-start">
                    <h1 style="text-align: center">Sign Up</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 align-self-start">
                        <h5>All fields are required</h5>
                    </div>
                </div>
                </div>
            <br>
                <div clas="row">
                <form  action= 'NewUser.php' method='post' class="form-horizontal">
                    <div class="container">
                        <div class="form-group">
                            <div class="col-sm-2 algin-self-start">
                                <label style="margin-bottom: 2rem" class="h5">User ID:</label><br>
                                </div>
                            <div class="col-sm-3 algin-self-center">
                                <input style="margin-bottom: 1.5rem" type="text" name="userId" class="form-control" value = <?php echo $userId?>> 
                            </div>
                            <div class="col-sm-7 algin-self-end">
                                <p style="margin-bottom: 3rem" class="text-danger"><?php echo $validatedID;?></p>
                            </div>
                            
                            </div>
                        <div class="form-group">
                            <div class="col-sm-2 algin-self-start">
                                <label style="margin-bottom: 2rem" class="h5">Name: </label><br>
                                </div>
                            <div class="col-sm-3 algin-self-center">
                                <input style="margin-bottom: 1.5rem" type="text" name="name" class="form-control" value = <?php echo $name?>> 
                            </div>
                            <div class="col-sm-7 algin-self-end">
                                <p style="margin-bottom: 3rem" class="text-danger"><?php echo $validatedName;?></p>
                            </div>
                            
                            </div>
                        <div class="form-group">
                            <div class="col-sm-2 algin-self-start">
                                <label style="margin-bottom: 2rem" class="h5">Phone Number:<br>(NNN-NNN-NNNN) </label><br>
                                </div>
                            <div class="col-sm-3 algin-self-center">
                                <input style="margin-bottom: 1.5rem" type="text" name="pNumber" class="form-control" value = <?php echo $pNumber?>> 
                            </div>
                            <div class="col-sm-7 algin-self-end">
                                <p style="margin-bottom: 3rem" class="text-danger"><?php echo $validatedPhone;?></p>
                            </div>
                            
                            </div>
                        <div class="form-group">
                            <div class="col-sm-2 algin-self-start">
                                <label style="margin-bottom: 2rem" class="h5">Password: </label>
                                </div>
                            <div class="col-sm-3 algin-self-center">
                                <input style="margin-bottom: 1.5rem" type="password" name="password" class="form-control">  
                            </div>
                            <div class="col-sm-7 algin-self-end">
                                <p class="text-danger"><?php echo $validatedPW;?></p>
                            </div>
                            
                            </div>
                        <div class="form-group">
                            <div class="col-sm-2 algin-self-start">
                                <label style="margin-bottom: 2rem" class="h5">Password Again: </label>
                                </div>
                            <div class="col-sm-3 algin-self-center">
                                <input style="margin-bottom: 1.5rem" type="password" name="password2" class="form-control">  
                            </div>
                            <div class="col-sm-7 algin-self-end">
                                <p class="text-danger"><?php echo $validatedPW2;?></p>
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
