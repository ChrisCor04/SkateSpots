<?php
require_once 'env.php' //Load the environment variables from env.php

//Create the connection to PostgreSQL
$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";
$conn = pg_connect($conn_string);


//Make sure the database connection worked
if (!$conn) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . pg_last_error()]);
    exit;
}

header('Content-Type: application/json'); //Set the response to readble JSON format

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Get the POST data, submitter is set to Anonymous by default
    $name = $_POST['name'] ?? '';
    $address = $_POST['address'] ?? '';
    $submitter = $_POST['submitter'] ?? 'Anonymous';

    //Sets up the SQL query to import the new spot into the database
    $sql = "INSERT INTO spots (name, address, submitter) VALUES ($1, $2, $3)";
    $result = pg_query_params($conn, $sql, array($name, $address, $submitter));

    //Check to see that the insert query was successful                                       
    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Spot added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . pg_last_error($conn)]);
    }
    exit; 
}

pg_close($conn); //Close the database connection
?>
