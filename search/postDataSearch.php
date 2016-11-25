<?php

//build top 10 list
function top10(){
    $sql = "SELECT `name`, `photo` FROM `Bevs` WHERE `bevId` IN (
	           SELECT `bevId` FROM `Bev_Rating`
			     ORDER BY `likes` ASC) LIMIT 10";
    $retval = mysqli_query($GLOBALS['conn'], $sql);

    
    while($row = mysql_fetch_assoc($retval)){
        //name in $row['name']
        //photo path from main directory in row['photo']
        //add to array
        
    }
    
}





?>