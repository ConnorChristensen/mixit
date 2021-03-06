<?php

//checks to see if the user has liked that drink
//true: they have
//false: they haven't
function likedAlready($username, $bevName){
    $sql = "SELECT * FROM User_Liked WHERE
            username = '$username' AND bevName = '$bevName'";
    $retval = mysqli_query($GLOBALS['conn'], $sql);
    if($retval && mysqli_num_rows($retval)){
        return true;
    }
    else{
        return false;
    }
}

//passes in bool value
//if true: adds the users like to the database
//else: removes the users like from the database
function likeBev(){
    $username = "";
    $bevName = "";
    $like = null;
    //if there was an actual bev name passed
    if(array_key_exists('bevName', $_POST) && $_POST['bevName'] != ""){
        $bevName = $_POST['bevName'];
        $_POST['bevName'] = '';
    }
    else{
        return;
    }
    //if there was an actual choice make
    if(array_key_exists('choice', $_POST) && $_POST['choice'] != ""){
        if($_POST['choice'] == "like"){
            //user is liking a drink
            $like = true;
        }
        else{
            //user is disliking a drink
            $like = false;
        }
        //reset choice to be empty string
        $_POST['choice'] = "";
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
    $sql = "";
    if($like){
        //like the beverage
        //check to see the user hasn't already liked it
        if(!likedAlready($username, $bevName)){
            $sql = "INSERT INTO User_Liked VALUES ('$username', '$bevName')";
        }
    }
    else{
        //unlike the beverage
        //check to see the user has actually liked it
        if(likedAlready($username, $bevName)){
            $sql = "DELETE FROM User_Liked WHERE username = '$username' AND bevName = '$bevName'";
        }
    }
    mysqli_query($GLOBALS['conn'], $sql);
}



//function to generate the query based on the posted information
//returns the sql query needed to generate the search results
function generateSearchQuery(){
    $sql = "SELECT DISTINCT(Bevs.bevName), type, glass, photo, description, instructions, ingredientList FROM Bevs, Ingredients WHERE Bevs.bevName = Ingredients.bevName";

        
    //get the wants
    $wants = $_POST['want'];

    //checks to see if the beginning of the subquery has been appended
    $startedSubquery = false;
    $needParen = false;
    foreach($wants as $ingred){
        if($ingred != ""){
            if(!$startedSubquery){
                $needParen = true;
                $startedSubquery = true;
                $sql = $sql." AND Bevs.bevName IN 
                        (SELECT Ingredients.bevName FROM Ingredients WHERE ingredName = '$ingred'";
            }
            else{
                $sql = $sql." OR ingredName = '$ingred'";
            }
        }
    }
    if($needParen){
        $sql = $sql.")";
        $needParen = false;
    }

    //reset the subquery flag
    $startedSubquery = false;

    //get the don't wants
    $dontWant = $_POST['dontWant'];
    foreach($dontWant as $ingred){
        if($ingred != ""){
            if(!$startedSubquery){
                $needParen = true;
                $startedSubquery = true;
                $sql = $sql." AND Bevs.bevName NOT IN 
                        (SELECT Ingredients.bevName FROM Ingredients WHERE ingredName = '$ingred'";
            }
            else{
                $sql = $sql." OR ingredName = '$ingred'";
            }
        }
    }
    if($needParen){
        $sql = $sql.")";
        $needParen = false;
    }
    
    if(!array_key_exists('unrestrict', $_POST) || $_POST['unrestrict'] == ''){
        $_POST['unrestrict'] = '';
        $startedSubquery = false;
        //restrict query to only the ingredients mentioned
        foreach($wants as $ingred){
            if($ingred != ""){
                if(!$startedSubquery){
                    $startedSubquery = true;
                    $sql = $sql." AND Bevs.bevName NOT IN 
                            (SELECT Ingredients.bevName FROM Ingredients WHERE ingredName != '$ingred'";
                    $needParen = true;
                }
                else{
                    $sql = $sql." AND ingredName != '$ingred'";
                }
            }
        }
        if($needParen){
            $sql = $sql.")";
            $needParen = false;
        }
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
            "name" => $row['bevName'],
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
        $backUpPhoto = 'http://www.kalahandi.info/wp-content/uploads/2016/05/sorry-image-not-available.png';
        
        
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
            $path = "../".$query[$x]['photo'];
            if(fopen($path,'r') == false){
                $card = $card.$backUpPhoto;
            }
            else{
                fclose($path);
                $card = $card.$path;
            }
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
        
        //add the type of drink
        $card = $card.'<h4>Type</h4>
                        <p>'.$query[$x]['type'].'</p>';
        
        //add the recommended glass
        $card = $card.'<h4>Glass</h4>
                        <p>'.$query[$x]['glass'].'</p>';
        
        //add the description
        $card = $card.'<h4>Description</h4>
                        <p>'.$description.'</p>';
        
        //add the instructions
        $card = $card.'<h4>Instructions</h4>
                        <p>'.$instructions.'</p>';
        
        //add in the like button
        //If already logged in
//        if(array_key_exists('login', $_SESSION)){
//            if($_SESSION['login'] == 1){
//                $card = $card.'<div class="unselected like">
//                            <div class="likeContainer">
//                            <img src="../images/icons/likeWhite.png">
//                            <img src="../images/icons/likeGreen.png">
//                            </div>
//                        </div>';
//            }
//        }
        
        
        //close card and echo it
        $card = $card.'</div>';
        echo $card;
    }
    
}

?>