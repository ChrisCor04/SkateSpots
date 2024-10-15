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

<?php
$conn = mysqli_connect("localhost", "root", "", "websitelogin"); 

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_btn'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM logindetails WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $resultPassword = $row['password'];

        if ($password === $resultPassword) {
            header('Location: welcome.html');
            exit(); 
        } else {
            echo "<script>alert('Login invalid: Incorrect password');</script>";
        }
    } else {
        echo "<script>alert('User not found');</script>";
    }
}

mysqli_close($conn); 
?>