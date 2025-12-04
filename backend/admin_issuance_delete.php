<?php
// PATH FIXED: db_connect is in the same folder.
require_once 'db_connect.php'; 

header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['id']) || !is_numeric($input['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request ID for deletion.']);
    exit;
}

$id = $input['id'];

$sql = "DELETE FROM issuance_requests WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Issuance request deleted successfully!']);
    } else {
        echo json_encode(['status' => 'info', 'message' => 'No request found with that ID to delete.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database delete error: ' . $conn->error]);
}

$stmt->close();
$conn->close();
exit;
?>