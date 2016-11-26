<?php

//build top 10 list
//returns an array of each row of the result query arr[row][column]
function top10(){
    //get top 10 of all drinks
    $sql = "SELECT `name`, `photo` FROM `Bevs` WHERE `bevId` IN (
	           SELECT `bevId` FROM `Bev_Rating`
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
	           SELECT Bev_Rating.bevId FROM `Bev_Rating`, Ingredients
                     WHERE Bev_Rating.bevId = Ingredients.bevId
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
	           SELECT Bev_Rating.bevId FROM `Bev_Rating`, Type
                     WHERE Bev_Rating.bevId = Type.bevId
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
























