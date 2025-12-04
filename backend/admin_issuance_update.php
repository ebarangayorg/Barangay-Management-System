<?php
// PATH FIXED: db_connect is in the same folder.
require_once 'db_connect.php'; 

header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['id']) || !is_numeric($input['id']) || !isset($input['status'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data provided for update.']);
    exit;
}

$id = $input['id'];
$status = $input['status'];

// Optional: Validate status values
$valid_statuses = ['Pending', 'Approved', 'Ready for Pickup', 'Rejected'];
if (!in_array($status, $valid_statuses)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid status value.']);
    exit;
}

$sql = "UPDATE issuance_requests SET status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status, $id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Request status updated successfully!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database update error: ' . $conn->error]);
}

$stmt->close();
$conn->close();
exit;
?>