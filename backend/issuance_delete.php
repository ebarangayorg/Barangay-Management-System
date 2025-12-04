<?php
require_once "config.php"; // MongoDB connection
session_start();

header("Content-Type: application/json");

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

// Decode JSON from fetch
$input = json_decode(file_get_contents('php://input'), true);
$id = $input['id'] ?? null;
$resident_email = $_SESSION['email'];

if (!$id) {
    echo json_encode(["status" => "error", "message" => "Missing request ID."]);
    exit;
}

try {
    // Convert the string ID back to MongoDB's ObjectId
    $objectId = new MongoDB\BSON\ObjectId($id);

    // Criteria: Match the ID AND the resident's email (for security: resident can only delete their own request)
    $result = $issuanceCollection->deleteOne([
        '_id' => $objectId,
        'resident_email' => $resident_email
    ]);

    if ($result->getDeletedCount() > 0) {
        echo json_encode(["status" => "success", "message" => "Request successfully cancelled."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Request not found or you don't have permission to cancel it."]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}