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
	<title>Search</title>
	<link rel="stylesheet" href="search.css">
</head>

<body>
   <?php
        //conects the database
        include('../databaseConnect.php');
        
        //check that the data is valid and query appropriately
        include('postDataSearch.php');
    ?>
   
    <div class="wrapper">
        <div class="search">
            <div class="by">
                <h2 class="name">Name</h2>
                <h2 class="ingrediants">Ingrediants</h2>
            </div>
            <div class="feilds">
                <div class="have">
                    <h2>I have</h2>
                    <form action="">
                        <input type="text" placeholder="Drink">
                        <input type="text" placeholder="Drink">
                        <input type="text" placeholder="Drink">
                    </form>
<!--
                    <div class="plusMinus">
                        <p>-</p>
                        <p>+</p>
                    </div>
-->
                </div>
                <div class="dontWant">
                    <h2>I don't want</h2>
                    <form action="">
                        <input type="text" placeholder="Drink">
                        <input type="text" placeholder="Drink">
                        <input type="text" placeholder="Drink">
                    </form>
                </div>
            </div>
            <button class="query">
                search
            </button>
        </div>
    </div>
    <div class="topTens">
            <h2>Top 10</h2>
            <div class="list">
               <?php
                //get top 10 bevs
                $topAll = top10();
                //output info for top 10
                for($x=0; $x<10; $x++){
                    $item = '<div class="item"><div class="imgContainer"><img src="';
                    if($topAll[$x]["photo"] == null){
                        $item = $item.'http://s2.dmcdn.net/Ub1O8/1280x720-mCQ.jpg';
                    }
                    else{
                        $item = $item . $topAll[$x]['photo'];
                    }
                    $item = $item. '" alt=""></div><h4>'.$topAll[$x]['name'].'</h4></div>';
                    echo $item;
                }
                ?>
 
            </div>
            <h2>Top 10 coctails</h2>
            <div class="list">
                    <div class="item">
                    <div class="imgContainer">
                        <img src="https://s3.amazonaws.com/liquor/wp-content/uploads/2011/04/15150034/dirty-martini-720x720-recipe.jpg" alt="">
                    </div>
                    <h4>Vodka Martini</h4>
                </div>
            </div>
            <h2>Top 10 with Gin</h2>
            <div class="list">
                    <div class="item">
                    <div class="imgContainer">
                        <img src="https://s3.amazonaws.com/liquor/wp-content/uploads/2011/04/15150034/dirty-martini-720x720-recipe.jpg" alt="">
                    </div>
                    <h4>Vodka Martini</h4>
                </div>
            </div>
    </div>
</body>

</html>
