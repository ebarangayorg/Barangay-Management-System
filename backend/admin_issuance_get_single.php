<?php
// backend/admin_issuance_get_single.php
require_once 'db_connect.php'; 

header('Content-Type: application/json');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(['error' => 'Invalid request ID provided.']);
    exit;
}

$issuanceCollection = $database->selectCollection('issuances');
$residentCollection = $database->selectCollection('residents');

try {
    // FIX: Convert the string ID from the URL parameter into a MongoDB ObjectId for primary lookup
    $objectId = new MongoDB\BSON\ObjectId($_GET['id']);
    
    // 1. Find the issuance request
    $request = $issuanceCollection->findOne(['_id' => $objectId]);

    if (!$request) {
        echo json_encode(['error' => 'Issuance request not found.']);
        exit;
    }

    $request = (array) $request; 
    
    // FIX: Convert the primary _id to string 'id' for the modal
    $request['id'] = (string) $request['_id']; 

    // 2. CRITICAL FIX: Use resident_email for lookup
    $residentEmailToLookup = $request['resident_email'];

    // Find resident details by email
    $resident = $residentCollection->findOne(['email' => $residentEmailToLookup]);
    
    // Add resident name 
    $request['resident_name'] = $resident ? $resident['full_name'] : $request['resident_name'];
    $request['resident_db_id'] = $resident ? (string) $resident['_id'] : null;

    echo json_encode($request);

} catch (MongoDB\Driver\Exception\InvalidArgumentException $e) {
    echo json_encode(['error' => 'Invalid ID format for MongoDB.']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'MongoDB Query Error: ' . $e->getMessage()]);
}

exit;