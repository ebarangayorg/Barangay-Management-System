<?php
require_once "../backend/config.php"; // your MongoDB connection

header("Content-Type: application/json");

$response = ["status" => "error", "data" => [], "message" => ""];

try {
    $announcements = $announcementCollection
        ->find([], ['sort' => ['date' => -1, 'time' => -1]]);

    $data = [];
    foreach ($announcements as $ann) {
        $data[] = [
            "id" => (string)$ann['_id'],
            "title" => $ann['title'] ?? '',
            "location" => $ann['location'] ?? '',
            "date" => $ann['date'] ?? '',
            "time" => $ann['time'] ?? ''
        ];
    }

    $response['status'] = "success";
    $response['data'] = $data;

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
exit;
