<?php
require_once 'env.php'

$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";
$conn = pg_connect($conn_string);

if (!$conn) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . pg_last_error()]);
    exit;
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
