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


?>