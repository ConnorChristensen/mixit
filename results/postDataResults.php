<?php

//function to generate the query based on the posted information
//returns the sql query needed to generate the search results
function generateSearchQuery(){
    
}

//function to query the database based upon the user's choices on the search page
//returns an array of containing the information of each row
function queryDB(){
    //get the query of the information
    $sql = generateSearchQuery();
    $retval = mysqli_query($GLOBALS['conn'], $sql);
    
    $topArr = array();
    $rowNum = 0;
    
    //put the info in an array for use
    foreach($retval as $row){
        //name in $row['name']
        //type in $row['type']
        //glass in $row['glass']
        //photo link in $row['link']
        //description link in $row['description']
        //instructions link in $row['instructions']
        //ingredients link in $row['ingredientList']
        $topArr[$rowNum] array(
            "name" => $row['name'],
            "type" => $row['type'],
            "glass" => $row['glass'],
            "photo" => $row['photo'],
            "description" => $row['description'],
            "instructions" => $row['instructions'],
            "ingredients" => $ow['ingredientList']
        );
        $rowNum++;
    }
    
    return $topArr;
    
}

//read the ingredients from the file
function readIngredients($drinkName){
    
}

//read the instructions from the file
function readInstructions($drinkName){
    
}

//read the descriptions from the file
function readDescriptions($drinkName){
    
}

//function to output the results of the query formatted correctly
function generateHTMLOfQuery(){
    
}



?>