<?php

//create an array for each value with an associated key and value pair
$user = array(
    "name" => "",
    "pass" => false
);
$password = array(
    "name" => "",
    "pass" => false
);

//TODO: Create separate PHP file with common functions <----
function UserFeedbackError($info) {
    echo '<p class="error">'.$info.'</p>';
}
function UserFeedbackSuccess($info) {
    echo '<p class="success">'.$info.'</p>';
}
//check if name only contains letters and numbers
function validName($name) {
    if(!preg_match("/^[A-z\-_0-9]*$/", $name)) {
        return false;
    }
    return true;
}

//check to see if credentials are good
function tryToLogin($username, $password){
    $sql = "SELECT COUNT(`username`) FROM `Users` WHERE `username` = '$username' AND `password` = '$password'";
    $retval = mysqli_query($conn, $sql);
    if($retval > 0){
        return true;
    }
    else{
        return false;
    }
}

//check if username entered and is valid
if($_POST["userName"]) {
    $user["name"] = $_POST["userName"];
    if(strlen($user["name"]) < 5 && !validName($user["name"])) {
        UserFeedbackError("Not a valid username");
    }
    else {
        $user["pass"] = true;
    }
}

//check if password entered and is valid
if($_POST["password"]) {
    $password["name"] = $_POST["password"];
    if(strlen($password["name"]) < 5) {
        UserFeedbackError("Not a valid password");
    }
    else {
        $password["pass"] = true;
        $password["name"] = hash('sha256',$_POST["password"].$first["name"]);
    }
}
//check if valid creditials
if($user["pass"] == true && $password["pass"] == true){
    $goodUsername = htmlspecialchars($user["name"]);
    $goodPassword = htmlspecialchars($password["name"]);
    if(tryToLogin($goodUsername, $goodPassword)){
        $_SESSION["login"] = 1;
        UserFeedbackSuccess("Logged in");
        //TODO: INSERT REDIRECT  <-----
    }
    else{
        UserFeedbackError("Username or Password not correct");
    }
}


?>