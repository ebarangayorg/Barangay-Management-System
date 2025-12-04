<?php
// backend/admin_issuance_get.php
require_once 'db_connect.php'; 

header('Content-Type: application/json');

// Using 'issuances' and 'residents' collections as confirmed
$issuanceCollection = $database->selectCollection('issuances'); 
$residentCollection = $database->selectCollection('residents');

$data = [];

try {
    // 1. Fetch all issuance documents
    $cursor = $issuanceCollection->find([], ['sort' => ['request_date' => -1]]);
    $issuanceRequests = $cursor->toArray();

    if (empty($issuanceRequests)) {
        echo json_encode([]); // Return empty array if no documents found
        exit;
    }

    // 2. Process and join data
    foreach ($issuanceRequests as $req) {
        $request = (array) $req;

        // FIX 1: Convert primary MongoDB ObjectId (_id) to string 'id' for JavaScript
        $request['id'] = (string) $request['_id']; 
        
        // FIX 2: Use resident_email for lookup instead of resident_id
        $residentEmailToLookup = $request['resident_email'];
        
        // Lookup the resident by their email address in the 'residents' collection
        $resident = $residentCollection->findOne(['email' => $residentEmailToLookup]);

        // Add the resident's full name (if found)
        $request['resident_name'] = $resident ? $resident['full_name'] : $request['resident_name'];
        
        // Optionally pass the resident's MongoDB ID if needed later
        $request['resident_db_id'] = $resident ? (string) $resident['_id'] : null;

        $data[] = $request;
    }
    
    echo json_encode($data);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'MongoDB Query Error: ' . $e->getMessage()]);
}

exit;