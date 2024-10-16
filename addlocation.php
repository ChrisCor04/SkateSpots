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
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . pg_last_error()]);
    exit;
}

// Set the content type for JSON response
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Use prepared statements for inserting data
    $name = $_POST['name'] ?? '';
    $address = $_POST['address'] ?? '';
    $submitter = $_POST['submitter'] ?? 'Anonymous';

    $sql = "INSERT INTO spots (name, address, submitter) VALUES ($1, $2, $3)";
    $result = pg_query_params($conn, $sql, array($name, $address, $submitter));

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Spot added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . pg_last_error($conn)]);
    }
    exit; 
}

pg_close($conn);
?>
