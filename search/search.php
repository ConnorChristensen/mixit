<?php
// Start the session
session_start();
?>
<!DOCTYPE html>

<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,400" rel="stylesheet">
    <script src="search.js"></script>
	<title>Search</title>
	<link rel="stylesheet" href="search.css">
</head>

<body>
   <?php
    
        //logout functionality
        include('../logout.php');
    
        //conects the database
        include('../databaseConnect.php');
        
        //check that the data is valid and query appropriately
        include('postDataSearch.php');
    ?>
    <a href="../index.php" class="back">
        <div>Back</div>
    </a>
   
    <div class="wrapper">
        <div class="search">
            <div class="by">
                <h2 class="name">Name</h2>
                <h2 class="ingrediants">Ingrediants</h2>
            </div>
            <div class="feilds">
                <form method="POST" action="search.php">
                    <div class="inputFeilds">
                        <div class="have">
                            <h2>I have</h2>
                            <input type="text" name="want[]" placeholder="Drink">
                            <input type="text" name="want[]" placeholder="Drink">
                            <input type="text" name="want[]" placeholder="Drink">
                        </div>
                        <div class="dontWant">
                            <h2>I don't want</h2>
                            <input type="text" name="dontWant[]" placeholder="Drink">
                            <input type="text" name="dontWant[]" placeholder="Drink">
                            <input type="text" name="dontWant[]" placeholder="Drink">
                        </div>
                    </div>
                    <input type="submit" name="submit" value="submit" id="submit">
                </div>
            </div>
        </div>
    </div>
    <div class="topTens">
       <?php
       //if user logged in, print their liked bevs
       if(array_key_exists('login', $_SESSION)){
            if($_SESSION['login'] == 1 && array_key_exists('username', $_SESSION)){
                echo '<h2>Liked Drinks</h2>';
                $liked = getUserLiked($_SESSION['username']);
                //if they've liked something, print liked
                //otherwise tell them they haven't liked things yet!
                if(count($liked) > 0){
                    echo '<div class="list">';

                    //output info for favorites using template
                    printArr($liked);
                    echo '</div>';
                }
                else{
                    echo "<h3>You haven't liked anything yet!</h3>";
                }
            }
       }
       ?>
        <h2>Top 10</h2>
        <div class="list">
            <div class="scrollContainer">
                <?php

                //get top 10 bevs
                $topAll = top10();
                //output info for top 10 using template
                printArr($topAll);
                ?>
             </div>
        </div>
        <h2>Top 10 coctails</h2>
        <div class="list">
           <div class="scrollContainer">
            <?php

            //get top 10 bevs of a type, cocktail hardcoded right now
            //TODO: make type not hard-coded <--
            $topType = top10Type();
            //output info for top 10
            printArr($topType);

            ?>
            </div>
        </div>
        <h2>Top 10 with Banana</h2>
        <div class="list">
           <div class="scrollContainer">
            <?php
            //get top 10 bevs using a particular ingredient, banana at the moment
            //TODO: make ingredient not hard-coded <--
            $topIngred = top10Ingred();
            //output info for top 10
            printArr($topIngred);
            ?>
            </div>
        </div>
    </div>
    
</body>

</html>
