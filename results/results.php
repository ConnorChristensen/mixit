<?php
    // Start the session
    session_start();

    $_SESSION['searched'] = 0;
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Results</title>
    <link rel="stylesheet" href="results.css">
</head>

<body>
   <?php
        //conects the database
        include('../databaseConnect.php');
    
        //logout functionality
        include('../logout.php');
    
        //check that the data is valid and query appropriately
        include('postDataResults.php');
    ?>
    <a href="../search/search.php" class="back">
        <div>Back</div>
    </a>
    <div class="resultsContainer">
        
        <?php
        
        generateHTMLOfQuery();
        
        ?>
        
        
    </div>
    <button onclick="requestLogOut()" id="logOut">Log Out</button>
        <?php
        //Inteded to work with logOut only
        //if there was a get request and the key call is inside get
        if($_SERVER['REQUEST_METHOD']=="GET" && array_key_exists('call', $_GET)){
            //get the function requesting to be called
            $function = $_GET['call'];
            //if it exists, call it
            if(function_exists($function)){
                call_user_func($function);
            }
        }
    ?>
</body>

</html>