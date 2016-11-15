<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width'>
	<title>Enter Info</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script type="text/javascript" src="register.js"></script>
	<link rel="stylesheet" href="register.css">
</head>

<body>
    <div class="linkContainer">
        <a href="../index.php">Back</a>
    </div>
    
	<?php
        //conects the database
        include('databaseConnect.php');
        //if the table doesn't exist, then create it
        include('createTable.php');
        //check that the data is valid and post it if it is
        include('postData.php');
    ?>

    <h3>All white bars are required feilds</h3>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h1>Register</h1>

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

        <label for="confirmPassword">Confirm Password</label>
        <input id="confirmPassword" type="password" name="confirmPassword" class="textBox required">
        <span class="error" id="confirmPasswordError">
            <?php echo $confirmPasswordError; ?>
        </span>

        <label for="email">Email</label>
        <input id="email" type="text" name="email" class="textBox required">
        <span class="error" id="emailError">
            <?php echo $email["error"]; ?>
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
