<?php

require_once 'env.php'


$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";

$conn = pg_connect($conn_string);

if (!$conn) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . pg_last_error()]));
}

header('Content-Type: application/json');

$sql = "SELECT name, address, submitter FROM spots ORDER BY created_at DESC"; 
$result = pg_query($conn, $sql);

$spots = [];
if ($result) {
    while ($row = pg_fetch_assoc($result)) {
        $spots[] = $row;
    }
}

echo json_encode(['success' => true, 'spots' => $spots]); 

pg_close($conn);
?>
