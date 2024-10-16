<?php
$host = "your_host"; // Replace with your host
$dbname = "your_dbname"; // Replace with your database name
$user = "your_user"; // Replace with your database user
$password = "your_password"; // Replace with your database password

try {
    // Create a new PDO instance
    $conn = new PDO("pgsql:host=$host;dbname=$dbname;port=5432", $user, $password);
    
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get the JSON data from the request
    $data = json_decode(file_get_contents('php://input'), true);

    // Debugging: Log the received data
    error_log("Received data: " . print_r($data, true));
    
    // Check if required fields are provided
    if (empty($data['username']) || empty($data['password'])) {
        echo json_encode(['success' => false, 'message' => 'Username and password are required.']);
        exit();
    }

    // Prepare and execute the query to check for existing username
    $username = $data['username'];
    
    $stmt = $conn->prepare("SELECT * FROM logindetails WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    // Debugging: Log the number of rows found for the username
    error_log("Username check: " . $username . " | Rows found: " . $stmt->rowCount());

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'Username already taken']);
        exit();
    }

    // Hash the password before storing it
    $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
    
    // Debugging: Log the hashed password (remove this in production)
    error_log("Hashed Password: " . $hashedPassword);

    // Insert the new user into the database
    $stmt = $conn->prepare("INSERT INTO logindetails (username, password) VALUES (:username, :password)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPassword);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error creating account']);
    }

} catch (PDOException $e) {
    // Handle database connection errors
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
}
?>
