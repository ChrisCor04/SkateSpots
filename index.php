<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// PostgreSQL connection details
$host = "c3cj4hehegopde.cluster-czrs8kj4isg7.us-east-1.rds.amazonaws.com";
$port = "5432";
$dbname = "d59rephvlc8q0t";
$user = "ufmufvbpcl003j";
$password = "p21d9f0ca2a74053de8eabece0e62f4181274bf0eb78ec8cedb1f5cc44f8bb882";

// Connect to PostgreSQL database
$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";
$conn = pg_connect($conn_string);

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

// Initialize an empty message variable
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_btn'])) {
    // Escape user inputs
    $username = pg_escape_string($conn, $_POST['username']);
    $password = pg_escape_string($conn, $_POST['password']);

    // Prepare and execute the query to fetch user details
    $sql = "SELECT * FROM logindetails WHERE username = $1";
    $result = pg_query_params($conn, $sql, array($username));

    if (pg_num_rows($result) > 0) {
        $row = pg_fetch_assoc($result);
        $resultPassword = $row['password'];

        // Validate password using password_verify
        if (password_verify($password, $resultPassword)) {
            // Redirect to welcome page on successful login
            header('Location: welcome.html'); // Adjust path if necessary
            exit(); 
        } else {
            $message = 'Login invalid: Incorrect password';
        }
    } else {
        $message = 'User not found';
    }
}

pg_close($conn); 
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
        <form method="POST" action="login.php"> 
            <img src="images/SkateSpotsLogo.png" class="skateSpotsLogo">
            <h1>Login</h1>
            <?php if ($message): ?>
                <div class="error-message"><?php echo htmlspecialchars($message); ?></div>
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
