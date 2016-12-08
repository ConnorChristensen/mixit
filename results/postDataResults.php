<?php

//passes in bool value
//if true: adds the users like to the database
//else: removes the users like from the database
function likeBev($like){
    $username = "";
    $bevName = "";
    //if there was an actual bev name passed
    if(array_key_exists('bevName', $_POST) && $_POST['bevName'] != ""){
        $bevName = $_POST['bevName'];
        $_POST['bevName'] = '';
    }
    else{
        return;
    }
    //if the user is properly logged in
    if(array_key_exists('username', $_SESSION) && $_SESSION['username'] != ""){
        $username = $_SESSION['username'];
    }
    else{
        return;
    }
    if($like){
        //like the beverage
        //TODO: Implement SQL
    }
    else{
        //unlike the beverage
        //TODO: Implement SQL
    } 
}



//function to generate the query based on the posted information
//returns the sql query needed to generate the search results
function generateSearchQuery(){
    $sql = "SELECT DISTINCT(Bevs.bevName), type, glass, photo, description, instructions, ingredientList FROM Bevs, Ingredients WHERE Bevs.bevName = Ingredients.bevName";
    $wants = null;

        
    //get the wants
    $wants = $_POST['want'];

    //checks to see if the beginning of the subquery has been appended
    $startedSubquery = false;

    foreach($wants as $ingred){
        if($ingred != ""){
            if(!$startedSubquery){
                $startedSubquery = true;
                $sql = $sql." AND Bevs.bevName IN 
                        (SELECT Ingredients.bevName FROM Ingredients WHERE ingredName = '$ingred'";
            }
            else{
                $sql = $sql." OR ingredName = '$ingred'";
            }
        }
    }
    $sql = $sql.")";

    //reset the subquery flag
    $startedSubquery = false;

    //get the don't wants
    $dontWant = $_POST['dontWant'];
    foreach($dontWant as $ingred){
        if($ingred != ""){
            if(!$startedSubquery){
                $startedSubquery = true;
                $sql = $sql." AND Bevs.bevName NOT IN 
                        (SELECT Ingredients.bevName FROM Ingredients WHERE ingredName = '$ingred'";
            }
            else{
                $sql = $sql." OR ingredName = '$ingred'";
            }
        }
    }
    $sql = $sql.")";
    
    if($_POST['restrict']){
        $startedSubquery = false;
        //restrict query to only the ingredients mentioned
        foreach($want as $ingred){
            if($ingred != ""){
                if(!$startedSubquery){
                    $startedSubquery = true;
                    $sql = $sql." AND Bevs.bevName IN 
                            (SELECT Ingredients.bevName FROM Ingredients WHERE NOT (ingredName = '$ingred')";
                }
                else{
                    $sql = $sql." OR ingredName = '$ingred'";
                }
            }
        }
        $sql = $sql.")";
    }
        

    
    return $sql;
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
        $query[$rowNum] = array(
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
    $filepath = '../database_info/'.$filepath;
    $myfile = fopen($filepath, "r");
    $ingredients = array();
    if($myfile == false){
        $ingredients[0] = "Ingredients not available";
    }
    else{
        $itr = 0;
        while(!feof($myfile)){
            $ingred = fgets($myfile);
            if($ingred != ""){
                $ingredients[$itr] = $ingred;
            }
            $itr++;
        }
    }
    return $ingredients;
}

//read the instructions from the file
function readInstructions($filepath){
    $filepath = '../database_info/'.$filepath;
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
    $filepath = '../database_info/'.$filepath;
    $myfile = fopen($filepath, "r");
    $description = "";
    if($myfile == false){
        return "Description not available";
    }
    else{
        $description = fread($myfile, filesize($filepath));
    }
    fclose($myfile);
    return $description;
}

//function to output the results of the query formatted correctly
function generateHTMLOfQuery(){
    $query = queryDB();
    
    for($x=0; $x < count($query); $x++){

        $ingredients = readIngredients($query[$x]['ingredients']);
        $description = readDescriptions($query[$x]['description']);
        $instructions = readInstructions($query[$x]['instructions']);
        $backUpPhoto = 'https://i.ytimg.com/vi/dQw4w9WgXcQ/hqdefault.jpg';
        
        
        //var containing the drink card
        $card = '<div class="drinkCard">
                    <div class="imgContainer">
                        <img src="';
        
        //if an image exists, use it
        //otherwise use the back-up
        if($query[$x]['photo'] == null){
            $card = $card.$backUpPhoto;
        }
        else{
            $card = $card.'../images/'.$query[$x]['photo'];
        }
               
        $card = $card.'">
                </div>
                    <h2>'.$query[$x]['name'].'</h2>
                    <h4>Ingredients</h4>';
                 
        //get all the ingredients
        $card = $card.'<ul>';
        for($y=0; $y<count($ingredients); $y++){
            $card = $card.'<li>'.$ingredients[$y].'</li>';
        }
        $card = $card.'</ul>';
        
        //add the description
        $card = $card.'<h4>Description</h4>
                        <p>'.$description.'</p>';
        
        //add the instructions
        $card = $card.'<h4>Instructions</h4>
                        <p>'.$instructions.'</p>';
        
        //add in the like button
        $card = $card.'<div class="unselected like">
                            <div class="likeContainer">
                            <img src="../images/icons/likeWhite.png">
                            <img src="../images/icons/likeGreen.png">
                            </div>
                        </div>';
        
        //close card and echo it
        $card = $card.'</div>';
        echo $card;
    }
    
}

?>