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
    
    $query = array();
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
        $query[$rowNum] array(
            "name" => $row['name'],
            "type" => $row['type'],
            "glass" => $row['glass'],
            "photo" => $row['photo'],
            "description" => $row['description'],
            "instructions" => $row['instructions'],
            "ingredients" => $row['ingredientList']
        );
        $rowNum++;
    }
    
    return $query;
    
}

//replaces spaces with underscores
function spacesToUnderscores($string){
    for($x=0; $x<strlen($string); $x++){
        if($string[x] == " "){
            $string[x] = "_";
        }
    }
    return $string;
}

//read the ingredients from the file
function readIngredients($filepath){
    $myfile = fopen($filepath, "r");
    $ingredients = array();
    if($myfile == false){
        ingredients[0] = "Ingredients not available";
    }
    else{
        $itr = 0;
        while(!feof($myfile)){
            ingredients[$itr] = fgets($myfile);
        }
    }
    return ingredients;
}

//read the instructions from the file
function readInstructions($filepath){
    $myfile = fopen($filepath, "r");
    $instructions = "";
    if($myfile == false){
        return "Instructions not available";
    }
    else{
        $instructions = fread($myfile, filesize($filepath));
    }
    fclose($myfile);
    return $instructions;
}

//read the descriptions from the file
function readDescriptions($filepath){
    $myfile = fopen($filepath, "r");
    $description = "";
    if($myfile == false){
        return "Description not available";
    }
    else{
        $instructions = fread($myfile, filesize($filepath));
    }
    fclose($myfile);
    return $description;
}

//function to output the results of the query formatted correctly
function generateHTMLOfQuery(){
    $query = queryDB();
    for($itr=0; $itr < count($query); $x++){
        $ingredients = readIngredients($query[$x]['ingredients']);
        $description = readDescriptions($query[$x]['description']);
        $instructions = readInstructions($query[$x]['instructions']);
        $backUpPhoto = 'http://s2.dmcdn.net/Ub1O8/1280x720-mCQ.jpg';
        
        
        //var containing the drink card
        $card = '<div class="drinkCard">
                    <div class="imgContainer">
                        <img src="';
        $card = $card.$query[$x]['photo'].'" alt = "';
        $card = $card.$backUpPhoto;
        $card = $card.'">
                </div>
                    <h2>'.$query[$x]['name'].'</h2>
                    <h4>Ingredients</h4>'
                    
        //get all the ingredients
        $card = $card.'<ul>';
        for($x=0; $x<count($ingredients); $x++){
            $card = $card.'<li>'.$ingredients[$x].'</li>';
        }
        $card = $card.'</ul>';
        
        //add the description
        $card = $card.'<h4>Description</h4>
                        <p>'.$description.'</p>';
        
        //add the instructions
        $card = $card.'<h4>Instructions</h4>
                        <p>'.$instructions.'</p>';
        
        //close card and echo it
        $card = $card.'</div>';
        echo $card;
    }
}

?>