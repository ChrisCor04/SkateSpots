<?php

require_once 'env.php' //load environment variables from env.php


$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password"; //Create the connection to the PostgreSQL database

$conn = pg_connect($conn_string); //Connect to the database

if (!$conn) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . pg_last_error()]));
}

header('Content-Type: application/json');//Make the program is sending a JSON message to the client

$sql = "SELECT name, address, submitter FROM spots ORDER BY created_at DESC"; //Fetch all spots
$result = pg_query($conn, $sql);

$spots = []; //Initialize an array to hold all of the fetched spots
if ($result) {
    while ($row = pg_fetch_assoc($result)) { //loop through the results of fetch and add the rows to the spots array
        $spots[] = $row;
    }
}

echo json_encode(['success' => true, 'spots' => $spots]); //Outputs the spots as a response in JSON with a success status

pg_close($conn);
?>
