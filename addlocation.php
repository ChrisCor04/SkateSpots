<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "websitelogin"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $submitter = $_POST['submitter'] ?: 'Anonymous';

    $sql = "INSERT INTO spots (name, address, submitter) VALUES ('$name', '$address', '$submitter')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Spot added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
    }
    exit; 
}

$conn->close();
?>
