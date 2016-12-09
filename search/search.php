<?php
// Start the session
session_start();

if(array_key_exists('searched', $_SESSION)){
    if($_SESSION['searched'] == 1){
        header("location: ../results/results.php");
    }
}
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
<!--
            <div class="by">
                <h2 class="name">Name</h2>
                <h2 class="ingrediants">Ingrediants</h2>
            </div>
-->
            <form method="POST" action="../results/results.php">
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
                <label class="control">
                    <input type="checkbox" name="unrestrict"/>
                    Click here to allow any drink that contains items in the "I have" category
                </label>
                <input type="submit" name="submit" value="submit" id="submit">
            </form>
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
                    echo '<div class="scrollContainer">';
                    //output info for favorites using template
                    printArr($liked);
                    echo '</div>';
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
    <script>
    function requestLogOut(){
        jQuery.ajax({
            type: "GET",
            url: "search.php",
            data: "call=logOut",
            success: function(){
                window.location.reload();
            }
        });
    }
    </script>
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
