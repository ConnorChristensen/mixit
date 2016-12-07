<?php

//tells session user searched so it redirects
//checks to see if the user submitted
if(isset($_POST['submit'])){
    $_SESSION['searched'] = 1;
    echo '<script>window.location=" '.$_SERVER['PHP_SELF'].' "; </script>';
}

//prints the arrays for the search page
//array must be in form array[rowNumber]['name' OR 'photo']
//  > Intended to be used by output of top10 functions
function printArr($arr){
    for($x=0; $x<count($arr); $x++){
        $item = '<div class="item"><div class="imgContainer"><img src="';
        //if there is no photo path, use this image
        if($arr[$x]["photo"] == null){
            $item = $item.'http://s2.dmcdn.net/Ub1O8/1280x720-mCQ.jpg';
        }
        else{
            $item = $item . $arr[$x]['photo'];
        }
        $item = $item. '" alt=""></div><h4>'.$arr[$x]['name'].'</h4></div>';
        echo $item;
    }
}

//build top 10 list
//returns an array of each row of the result query arr[row][column]
function top10(){
    //get top 10 of all drinks
    $sql = "SELECT `name`, `photo` FROM `Bevs` WHERE `bevId` IN (
	           SELECT `bevId` FROM `Bev_Likes`
			     ORDER BY `likes` ASC) LIMIT 10";
    $retval = mysqli_query($GLOBALS['conn'], $sql);
    $topArr = array();
    $rowNum = 0;
    //put it in an array for use
    foreach($retval as $row){
        //name in $row['name']
        //photo path from main directory in row['photo']
        //add to array
        $topArr[$rowNum] = array(
            "name" => $row['name'],
            "photo" => $row['photo']
        );
        $rowNum++;
    }
    return $topArr;
}

//build top 10 using a certain ingrediant
//returns an array of each row of the result query arr[row][column]
function top10Ingred(){
    //get top 10 using a banana
    //TODO: generalize to use a variable <--
    $sql = "SELECT `name`, `photo` FROM `Bevs` WHERE Bevs.bevId IN (
	           SELECT Bev_Likes.bevId FROM `Bev_Likes`, Ingredients
                     WHERE Bev_Likes.bevId = Ingredients.bevId
                     AND Ingredients.name = 'banana'
			         ORDER BY `likes` ASC) LIMIT 10";
    $retval = mysqli_query($GLOBALS['conn'], $sql);
    $topArr = array();
    $rowNum = 0;
    //put it in an array for use
    foreach($retval as $row){
        //name in $row['name']
        //photo path from main directory in row['photo']
        //add to array
        $topArr[$rowNum] = array(
            "name" => $row['name'],
            "photo" => $row['photo']
        );
        $rowNum++;
    }
    return $topArr;
}

//build top10 of a certain type
//returns an array of each row of the result query arr[row][column]
function top10Type(){
    //get top 10 of cocktails
    //TODO: generalize to use a variable <--
    $sql = "SELECT `name`, `photo` FROM `Bevs` WHERE Bevs.bevId IN (
	           SELECT Bev_Likes.bevId FROM `Bev_Likes`, Type
                     WHERE Bev_Likes.bevId = Type.bevId
                     AND Type.name = 'cocktail'
			         ORDER BY `likes` ASC) LIMIT 10";
    $retval = mysqli_query($GLOBALS['conn'], $sql);
    $topArr = array();
    $rowNum = 0;
    //put it in an array for use
    foreach($retval as $row){
        //name in $row['name']
        //photo path from main directory in row['photo']
        //add to array
        $topArr[$rowNum] = array(
            "name" => $row['name'],
            "photo" => $row['photo']
        );
        $rowNum++;
    }
    return $topArr;
}

//build arr of user's liked drinks
//returns an array of each row of the result query arr[row][column]
function getUserLiked($username){
    //get user's liked
    $sql = "SELECT `name`, `photo` FROM `Bevs` WHERE Bevs.bevId IN (
	           SELECT User_Ratings.bevId FROM User_Ratings
                    WHERE User_Ratings.username = '$username'
                    AND User_Ratings.rating = 1)";
    $retval = mysqli_query($GLOBALS['conn'], $sql);
    $liked = array();
    $rowNum = 0;
    //put it in an array for use
    foreach($retval as $row){
        //name in $row['name']
        //photo path from main directory in row['photo']
        //add to array
        $liked[$rowNum] = array(
            "name" => $row['name'],
            "photo" => $row['photo']
        );
        $rowNum++;
    }
    return $liked;
}

?>
























