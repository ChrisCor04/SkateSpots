<?php
$host = "c3cj4hehegopde.cluster-czrs8kj4isg7.us-east-1.rds.amazonaws.com";
$dbname = "d59rephvlc8q0t";
$user = "ufmufvbpcl003j";
$password = "p21d9f0ca2a74053de8eabece0e62f4181274bf0eb78ec8cedb1f5cc44f8bb882";

try {
    // Create a new PDO instance
    $conn = new PDO("pgsql:host=$host;dbname=$dbname;port=5432", $user, $password);
    
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get the JSON data from the request
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Check if required fields are provided
    if (empty($data['username']) || empty($data['password'])) {
        echo json_encode(['success' => false, 'message' => 'Username and password are required.']);
        exit();
    }
    
    // Prepare and execute the query to check for existing username
    $username = $data['username'];
    $password = $data['password'];
    
    $stmt = $conn->prepare("SELECT * FROM logindetails WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'Username already taken']);
        exit();
    }

    // Insert the new user into the database
    $stmt = $conn->prepare("INSERT INTO logindetails (username, password) VALUES (:username, :password)");
    $stmt->bindParam(':username', $username);
    
    // Hash the password before storing it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
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
