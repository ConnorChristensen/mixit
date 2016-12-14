<?php
    define('DB_HOST', 'mysql.cs.orst.edu');
    //Robert's Database
//    define('DB_USER', 'cs340_rosenber');
//    define('DB_PASSWORD', '4321');
//    define('DB_NAME', 'cs340_rosenber');
    //Connor's Database
    define('DB_USER', 'cs340_chriconn');
    define('DB_PASSWORD', '4733');
    define('DB_NAME', 'cs340_chriconn');
    
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
    if($conn == false){
        die("Connection failed: " . mysqli_connection_error());
    }
	$GLOBALS['conn'] = $conn;
?>