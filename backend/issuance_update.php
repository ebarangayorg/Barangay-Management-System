<?php
// backend/issuance_update.php
require 'config.php'; // Ensure this path is correct for your MongoDB client setup
header('Content-Type: application/json');

// 1. Get JSON input from the frontend
$input = file_get_contents('php://input');
$data = json_decode($input, true);

$requestId = $data['id'] ?? null;
$newStatus = trim($data['status'] ?? '');

if (!$requestId || !$newStatus) {
    echo json_encode(['status' => 'error', 'message' => 'Missing Request ID or new Status.']);
    exit;
}

try {
    // !!! CRITICAL FIX: Convert the string ID into a MongoDB ObjectId 
    $objectId = new MongoDB\BSON\ObjectId($requestId);
    
    $collection = $client->bms_db->issuances;
    
    // 2. Perform the update operation
    $updateResult = $collection->updateOne(
        // Use the BSON ObjectId for the filter
        ['_id' => $objectId], 
        // Set the new status
        ['$set' => ['status' => $newStatus]]
    );

    if ($updateResult->getModifiedCount() === 1) {
        echo json_encode(['status' => 'success', 'message' => "Request ID {$requestId} status successfully updated to '{$newStatus}'.", 'modifiedCount' => $updateResult->getModifiedCount()]);
    } else {
        echo json_encode(['status' => 'info', 'message' => "Status update processed, but 0 records were modified (Status may be unchanged or ID not found).", 'modifiedCount' => $updateResult->getModifiedCount()]);
    }

} catch (MongoDB\Driver\Exception\InvalidArgumentException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid Request ID format.']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>