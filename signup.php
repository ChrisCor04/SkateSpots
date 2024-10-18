<?php

require_once 'env.php' //Get the environment variables from env.php


try {
    $conn = new PDO("pgsql:host=$host;dbname=$dbname;port=5432", $user, $password); //Eastablish a PDO connection to the PostgreSQL database using user and password
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Set PDO to error mode for better handling

    // Read the  POST data and change it from JSON into an  array.
    $data = json_decode(file_get_contents('php://input'), true);

    //Make sure both the username and password are present, if not return error mesage
    if (empty($data['username']) || empty($data['password'])) {
        echo json_encode(['success' => false, 'message' => 'Username and password are required.']);
        exit();
    }
    
    $username = $data['username']; //Stores username data
    
    $stmt = $conn->prepare("SELECT * FROM logindetails WHERE username = :username"); //Prepares username to check if it exists mroe than once in the database
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) { //Check if username exists if so return error
        echo json_encode(['success' => false, 'message' => 'Username already taken']);
        exit();
    }

    
    //Prepares a statement to insert the new username and hashed password into the database. 
    $stmt = $conn->prepare("INSERT INTO logindetails (username, password) VALUES (:username, :password)");
    $stmt->bindParam(':username', $username);

    //Hash the password for better security
    $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
    $stmt->bindParam(':password', $hashedPassword);

    
    //Insert the user information and return success message if it worked, or error message if it didn't
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error creating account']);
    }

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
}
?>
