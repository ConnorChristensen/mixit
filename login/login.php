<?php
// Start the session
session_start();

//If already logged in, redirect
if(array_key_exists('login', $_SESSION)){
    if($_SESSION['login'] == 1){
        header("location: ../search/search.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width'>
	<title>Enter Info</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script type="text/javascript" src="login.js"></script>
	<link rel="stylesheet" href="login.css">
</head>

<body>
   <a href="../index.php" class="linkContainer">
        <div>Back</div>
    </a>
    
	<?php
        //conects the database
        include('../databaseConnect.php');
        //check that the data is valid and post it if it is
        include('postDataLogin.php');
    ?>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h1>Login</h1>

        <label for="userName">User Name</label>
        <input id="userName" type="text" name="userName" class="textBox required">
        <span class="error" id="userNameError">
            <?php echo $user["error"]; ?>
        </span>

        <label for="password">Password</label>
        <input id="password" type="password" name="password" class="textBox required">
        <span class="error" id="passwordError">
            <?php echo $password["error"]; ?>
        </span>
        
        <div style="text-align: center">
            <input type="submit" value="submit" id="submit">
        </div>
    </form>
    <?php
        mysqli_close($conn);
    ?>
</body>

</html>
