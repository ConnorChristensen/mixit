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
</body>

</html>