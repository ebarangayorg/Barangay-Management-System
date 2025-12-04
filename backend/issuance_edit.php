<?php
// Start session to access user email for security checks
session_start(); 
require 'config.php'; // Includes your MongoDB connection logic
header('Content-Type: application/json');

// --- SECURITY CHECK 1: Must be logged in ---
if (!isset($_SESSION['email'])) {
    echo json_encode(['status' => 'error', 'message' => 'Authentication required. Please log in.']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

// Check for required data: ID and the new purpose
if (!$data || empty($data['id']) || !isset($data['purpose'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid or missing request data (ID or Purpose).']);
    exit;
}

$id = $data['id'];
$newPurpose = $data['purpose'];
$residentEmail = $_SESSION['email']; // The email of the currently logged-in user

try {
    $collection = $client->bms_db->issuances;

    // --- SECURE AND CONDITIONAL UPDATE CRITERIA ---
    $result = $collection->updateOne(
        [
            // 1. Target the specific request ID
            '_id' => new MongoDB\BSON\ObjectId($id),
            // 2. Only allow modification if the request belongs to the logged-in user
            'resident_email' => $residentEmail,
            // 3. Only allow modification if the request status is 'Pending'
            'status' => 'Pending' 
        ],
        [
            // Set the new purpose field
            '$set' => [
                'purpose' => $newPurpose,
                'last_updated_by_resident' => date("Y-m-d H:i:s") 
            ]
        ]
    );

    if ($result->getModifiedCount() > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Request purpose updated successfully.']);
    } elseif ($result->getMatchedCount() > 0) {
        echo json_encode(['status' => 'info', 'message' => 'Request not modified (no changes were made).']);
    } else {
        // No document matched the criteria (ID/Email/Pending status mismatch)
        echo json_encode(['status' => 'error', 'message' => 'Update failed. The request may be processed or does not belong to your account.']);
    }

} catch (MongoDB\Driver\Exception\Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred: ' . $e->getMessage()]);
}

?>