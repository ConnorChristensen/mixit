<?php
        //create an array for each value with an associated key and value pair
        $user = array(
            "name" => "",
            "error" => "",
            "pass" => false
        );
        $email = array(
            "address" => "",
            "error" => "",
            "pass" => false
        );
        $password = array(
            "name" => "",
            "error" => "",
            "pass" => false
        );
        $confirmPasswordError = "";

        //check if the name is a valid name containing letters and numbers only
        function validName($name) {
            if(!preg_match("/^[A-z\-_0-9]*$/", $name)) {
                return false;
            }
            return true;
        }
        
        //checks to see if the requested username is already taken
        function usernameInDB($name){
            $sql = "SELECT * FROM `Users` WHERE `username` = '$name'";
            $retval = mysqli_query($GLOBALS['conn'], $sql);
            if($retval && mysqli_num_rows($retval)){
                return true;
            }
            else{
                return false;
            }
        }

        //checks to see if the email is in use
        function emailInDB($email){
            $sql = "SELECT * FROM `Users` WHERE `email` = '$email'";
            $retval = mysqli_query($GLOBALS['conn'], $sql);
            if($retval && mysqli_num_rows($retval)){
                return true;
            }
            else{
                return false;
            }
            
        }


        //adds a user to the DB, parameters MUST BE GOOD
        function putUserIntoDB($username, $password, $email){
            $sql = "INSERT INTO `Users` (`username`, `password`, `email`) VALUES ('$username', '$password', '$email')";
            mysqli_query($GLOBALS['conn'], $sql);
        }

        function UserFeedbackError($info) {
            echo '<p class="error">'.$info.'</p>';
        }
        function UserFeedbackSuccess($info) {
            echo '<p class="success">'.$info.'</p>';
        }

        //checks if username is good
        if($_POST["userName"]) {
            $user["name"] = $_POST["userName"];
            if(strlen($user["name"]) < 5) {
                $user["error"] = "Username must be longer than 5 characters";
            }
            else if(!validName($user["name"])){
                $user["error"] = "Username must consist of only letters and numbers";
            }
            else if(usernameInDB(htmlspecialchars($user["name"]))){
                $user["error"] = "Desired username is aleady taken";
            }
            else {
                $user["pass"] = true;
            }
        }

        //checks if password is good
        if($_POST["password"]) {
            $password["name"] = $_POST["password"];
            if(strlen($password["name"]) < 5) {
                $password["error"] = "Password must be longer than 5 characters";
            }
            else {
                $password["pass"] = true;
            }
        }

        //checks if confirmed password matches password
        if(empty($_POST["confirmPassword"])){
            $password["pass"] = false;
        }
        else{
            //checks that password1 is equal to password2
            if(strcmp($_POST["password"], $_POST["confirmPassword"]) != 0){
                $confirmPasswordError = "Passwords do not match";
                $password["pass"] = false;
            }
            else{
                //password cleaning and encrypting with sha256 appended with username
                $password["name"] = hash('sha256',$_POST["password"].$first["name"]);
            }
        }

        //checks if email is valid
        if($_POST["email"]) {
            $email["address"] = $_POST["email"];
            if(!preg_match("/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/", $email["address"])) {
                $email["error"] = "That is not a proper email formatting";
            }
            else if(emailInDB(htmlspecialchars($email["address"]))){
                $email["error"] = "That email is already in use";
            }
            else {
                $email["pass"] = true;
            }
        }
        
        //adds values to database
        if($password["pass"] == true and $email["pass"] == true and $user["pass"] == true) {
            $goodName = htmlspecialchars($user["name"]);
            $goodPassword = htmlspecialchars($password["name"]);
            $goodEmail = htmlspecialchars($email["address"]);
            putUserIntoDB($goodName, $goodPassword, $goodEmail);
            if(usernameInDB($goodName)){
                UserFeedbackSuccess("Account Successfully made!");
                $_SESSION['login'] = 1;
                $_SESSION['username'] = $goodName;
                echo '<script>window.location=" '.$_SERVER['PHP_SELF'].' "; </script>';
            }
            else{
                UserFeedbackError("Oops! Something went wrong!");
            }
        }
    ?>