<?php
// Database connection details
$host = "c3cj4hehegopde.cluster-czrs8kj4isg7.us-east-1.rds.amazonaws.com";
$dbname = "d59rephvlc8q0t";
$user = "ufmufvbpcl003j"; 
$password = "p21d9f0ca2a74053de8eabece0e62f4181274bf0eb78ec8cedb1f5cc44f8bb882";
$port = "5432"; // Default PostgreSQL port

// Create connection string
$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";

// Connect to the PostgreSQL database
$conn = pg_connect($conn_string);

if (!$conn) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . pg_last_error()]));
}

// Set content type to JSON
header('Content-Type: application/json');

// Prepare SQL query
$sql = "SELECT name, address, submitter FROM spots ORDER BY created_at DESC"; 
$result = pg_query($conn, $sql);

$spots = [];
if ($result) {
    while ($row = pg_fetch_assoc($result)) {
        $spots[] = $row;
    }
}

// Return JSON response
echo json_encode(['success' => true, 'spots' => $spots]); 

// Close the connection
pg_close($conn);
?>
