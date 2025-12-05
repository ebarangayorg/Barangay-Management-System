<?php
require __DIR__ . '/../vendor/autoload.php';

try {
    $client = new MongoDB\Client("mongodb://localhost:27017");

    $database = $client->bms_db;

    $usersCollection = $database->users;
    $residentsCollection = $database->residents;
    $officialsCollection = $database->officials;
    $contactsCollection = $database->contacts;
    $incidentsCollection = $database->incidents;
    $announcementCollection = $database->announcements;
    $issuanceCollection = $database->issuances; 
} catch (Exception $e) {
    die("Error connecting to MongoDB: " . $e->getMessage());
}
?>