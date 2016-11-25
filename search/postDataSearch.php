<?php

//build top 10 list
function top10(){
    $sql = "SELECT `name`, `photo` FROM `Bevs` WHERE `bevId` IN (
	           SELECT `bevId` FROM `Bev_Rating`
			     ORDER BY `likes` ASC) LIMIT 10";
    $retval = mysqli_query($GLOBALS['conn'], $sql);
    $topArr = array();
    $num = 0;
    foreach($retval as $row){
        //name in $row['name']
        //photo path from main directory in row['photo']
        //add to array
        $topArr[$num] = array(
            "name" => $row['name'],
            "photo" => $row['photo']
        );
        $num++;
    }
    return $topArr;
}

//build top 10 using a certain ingrediant
function top10Ingred(){
    $sql = "SELECT `name`, `photo` FROM `Bevs` WHERE Bevs.bevId IN (
	           SELECT Bev_Rating.bevId FROM `Bev_Rating`, Ingredients
                     WHERE Bev_Rating.bevId = Ingredients.bevId
                     AND Ingredients.name = 'banana'
			         ORDER BY `likes` ASC) LIMIT 10";
    $retval = mysqli_query($GLOBALS['conn'], $sql);
    $topArr = array();
    $num = 0;
    foreach($retval as $row){
        //name in $row['name']
        //photo path from main directory in row['photo']
        //add to array
        $topArr[$num] = array(
            "name" => $row['name'],
            "photo" => $row['photo']
        );
        $num++;
    }
    return $topArr;
}

//build top10 of a certain type
function top10Type(){
    $sql = "SELECT `name`, `photo` FROM `Bevs` WHERE `bevId` IN (
	           SELECT `bevId` FROM `Bev_Rating`
			     ORDER BY `likes` ASC) LIMIT 10";
    $retval = mysqli_query($GLOBALS['conn'], $sql);
    $topArr = array();
    $num = 0;
    foreach($retval as $row){
        //name in $row['name']
        //photo path from main directory in row['photo']
        //add to array
        $topArr[$num] = array(
            "name" => $row['name'],
            "photo" => $row['photo']
        );
        $num++;
    }
    return $topArr;
}

?>