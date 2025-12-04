<?php
require_once "config.php"; // MongoDB connection
session_start();

header("Content-Type: application/json");

if (!isset($_SESSION['email'])) {
    echo json_encode(["status" => "error", "message" => "Not logged in"]);
    exit;
}

// Decode JSON from fetch
$input = json_decode(file_get_contents('php://input'), true);

$data = [
    "resident_email" => $_SESSION['email'],
    "resident_name"  => $_SESSION['fullname'] ?? "Resident",
    "document_type"  => $input['document_type'] ?? "",
    "purpose"        => $input['purpose'] ?? "",
    "status"         => "Pending",
    "request_date"   => date("Y-m-d"),
    "request_time"   => date("H:i:s")
];

try {
    $issuanceCollection->insertOne($data);
    echo json_encode(["status" => "success", "message" => "Request submitted"]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}