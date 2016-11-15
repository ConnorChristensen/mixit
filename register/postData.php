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

        //quick function to check if the name is a valid name with just english letters
        function validName($name) {
            if(!preg_match("/^[A-Za-z]*$/", $name)) {
                return false;
            }
            return true;
        }

        function UserFeedbackError($info) {
            echo '<p class="error">'.$info.'</p>';
        }
        function UserFeedbackSuccess($info) {
            echo '<p class="success">'.$info.'</p>';
        }

        if($_POST["userName"]) {
            $user["name"] = $_POST["userName"];
            if(strlen($user["name"]) < 5) {
                $user["error"] = "Username must be longer than 5 characters";
            }
            else {
                $user["pass"] = true;
            }
        }

        if($_POST["password"]) {
            $password["name"] = $_POST["password"];
            if(strlen($password["name"]) < 5) {
                $password["error"] = "Password must be longer than 5 characters";
            }
            else {
                $password["pass"] = true;
            }
        }


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


        if($_POST["email"]) {
            $email["address"] = $_POST["email"];
            if(!preg_match("/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/", $email["address"])) {
                $email["error"] = "That is not a proper email formatting";
            }
            else {
                $email["pass"] = true;
            }
        }

        if($password["pass"] == true and $email["pass"] == true and $user["pass"] == true) {
            $firstName = htmlspecialchars($first["name"]);
            $lastName = htmlspecialchars($last["name"]);
            $passwordNew = $password["name"];
            $emailAddress = htmlspecialchars($email["address"]);
            $userName = htmlspecialchars($user["name"]);
            $ageNumber = $age["number"];

            $sql = "SELECT 1 FROM `Users` WHERE `Email` = '$emailAddress'";
            $retval = mysqli_query($conn, $sql);
            if ($retval && mysqli_num_rows($retval) > 0) {
                UserFeedbackError("That email address is already taken");
            }
            else {
                //Check user name
                $retval = mysqli_query($conn, $sql);
                if ($retval && mysqli_num_rows($retval) > 0) {
                    UserFeedbackError("That username is already taken");
                }
                else {
                    //sql query
                    $retval = mysqli_query($conn, $sql);


                    if($retval) {
                        UserFeedbackSuccess("The data has been posted");
                    }
                    else {
                        UserFeedbackError("There was an error pushing the changes to the database");
                    }
                }
            }

        }
    ?>