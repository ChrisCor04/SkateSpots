<?php
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = pg_escape_string($conn, $_POST['name']);
    $address = pg_escape_string($conn, $_POST['address']);
    $submitter = pg_escape_string($conn, $_POST['submitter'] ?: 'Anonymous');

    $sql = "INSERT INTO spots (name, address, submitter) VALUES ('$name', '$address', '$submitter')";

    $result = pg_query($conn, $sql);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Spot added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . pg_last_error($conn)]);
    }
    exit; 
}

pg_close($conn);
?>
