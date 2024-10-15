<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "websitelogin"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT name, address, submitter FROM spots ORDER BY created_at DESC"; 
$result = $conn->query($sql);

$spots = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $spots[] = $row;
    }
} else {
    echo json_encode([]); 
}

echo json_encode($spots); 
$conn->close();
?>