<?php

//function to log out the user
//resets the session, refreshes current page
function logOut(){
    if(array_key_exists('login', $_SESSION)){
        if($_SESSION['login'] == 1){
            //reset session
            $_SESSION['login'] = 0;
            $_SESSION['username'] = "";
        }
    }
    //refresh
    echo '<script>window.location=" '.$_SERVER['PHP_SELF'].' "; </script>';
}


?>