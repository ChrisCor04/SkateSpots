<?php
$conn = mysqli_connect("localhost", "root", "", "websitelogin");

if (!$conn) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

$data = json_decode(file_get_contents('php://input'), true);

$username = mysqli_real_escape_string($conn, $data['username']);
$password = mysqli_real_escape_string($conn, $data['password']);

$sql = "SELECT * FROM logindetails WHERE username = '$username'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo json_encode(['success' => false, 'message' => 'Username already taken']);
    exit();
}

$sql = "INSERT INTO logindetails (username, password) VALUES ('$username', '$password')";
if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error creating account']);
}

mysqli_close($conn);
?>