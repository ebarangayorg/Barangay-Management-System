<?php
// backend/db_connect.php

// Set the header immediately to ensure all output is treated as JSON, 
// even if a fatal error occurs in the connection process.
header('Content-Type: application/json');

if (!class_exists('MongoDB\Client')) {
    die(json_encode(['error' => 'FATAL: MongoDB PHP Driver is not installed or enabled.']));
}

try {
    // --- Configuration ---
    $mongo_uri = "mongodb://localhost:27017"; 
    $db_name = "bms_db"; 

    // Create the MongoDB Client
    $mongoClient = new MongoDB\Client($mongo_uri);

    // Select the Database
    $database = $mongoClient->selectDatabase($db_name);

} catch (Exception $e) {
    die(json_encode(['error' => 'MongoDB Connection failed: ' . $e->getMessage()]));
}

// NOTE: Leave the closing ?> tag OFF