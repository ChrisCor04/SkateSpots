<?php
//Debugging Commands
ob_start(); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once 'env.php' //Load environment variables from env.php

$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password"; //Connect to the PostgreSQL database
$conn = pg_connect($conn_string);

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_btn'])) {
    $username = pg_escape_string($conn, $_POST['username']);//Sets query up to search for username and pass info
    $password = pg_escape_string($conn, $_POST['password']);//to make sure login info is correct

    $sql = "SELECT * FROM logindetails WHERE username = $1"; 
    $result = pg_query_params($conn, $sql, array($username));

    if (pg_num_rows($result) > 0) {
        $row = pg_fetch_assoc($result); //Fetch the user information
        $resultPassword = $row['password'];//Verify the password was correct

        if (password_verify($password, $resultPassword)) {
            header('Location: welcome.html'); //If successful you are redierected to the welcome screen
            exit(); 
        } else {
            $message = 'Login invalid: Incorrect password';
        }
    } else {
        $message = 'User not found'; 
    }
}

pg_close($conn); 
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="background">
        <form method="POST" action="index.php"> 
            <img src="images/SkateSpotsLogo.png" class="skateSpotsLogo">
            <h1>Login</h1>
            <?php if ($message): ?>
                <div class="error-message"><?php echo htmlspecialchars($message); ?></div> <!-- Display an error message if the login fails-->
            <?php endif; ?>
            <div class="inputContainer">
                <input type="text" class="username" placeholder="Username" name="username" required>
                <img src="images/usericon.png" class="userImg">
            </div>
            <div class="inputContainer">
                <input type="password" class="password" placeholder="Password" name="password" required>
                <img src="images/lockicon.png" class="passImg">
            </div>
            <div>
                <input type="submit" class="loginBtn" value="Login" name="login_btn">
            </div>
            <div class="signup">
                Don't have an account?  
                <br>
                <a href="signup.html">Sign Up</a>
            </div>
        </form>
    </div>
</body>
</html>
