<?php
require_once "config.php";
require_once "auth_resident.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Invalid request.");
}

$residentId = new MongoDB\BSON\ObjectId($_POST["user_id"]);

// Fetch current user
$email = $_SESSION['email'];
$user = $usersCollection->findOne(["email" => $email]);

if (!$user) {
    die("User not found.");
}

$userId = $user['_id'];

// HANDLE IMAGE UPLOAD
$uploadedImage = $_FILES['profile_image'] ?? null;
$existingImage = $_POST['existing_image'] ?? "";
$finalImageName = $existingImage;

if ($uploadedImage && $uploadedImage['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($uploadedImage['name'], PATHINFO_EXTENSION);
    $newFileName = uniqid("img_") . "." . $ext;
    $destination = "../uploads/residents/" . $newFileName;
    move_uploaded_file($uploadedImage["tmp_name"], $destination);
    $finalImageName = $newFileName;
}

// UPDATE RESIDENT BASIC INFO
$residentsCollection->updateOne(
    ["_id" => $residentId],
    ['$set' => [
        "first_name"     => $_POST["fname"],
        "middle_name"    => $_POST["mname"],
        "last_name"      => $_POST["lname"],
        "occupation"     => $_POST["occupation"],
        "contact"        => $_POST["contact"],
        "email"          => $_POST["email"],
        "civil_status"   => $_POST["civil_status"],
        "profile_image"  => $finalImageName,
    ]]
);

$old = $_POST['old_password'] ?? "";
$new = $_POST['new_password'] ?? "";
$confirm = $_POST['confirm_password'] ?? "";

if ($new !== "" && $new === $confirm) {

    $user = $usersCollection->findOne(['_id' => $userId]);

    if (!password_verify($old, $user['password'])) {
        die("<script>alert('Old password is incorrect.'); window.history.back();</script>");
    }

    $usersCollection->updateOne(
        ['_id' => $userId],
        ['$set' => ['password' => password_hash($new, PASSWORD_DEFAULT)]]
    );
}


$_SESSION['toast'] = ["msg" => "Profile updated successfully.", "type" => "success"];
header("Location: ../pages/resident/resident_dashboard.php?updated=true");
exit;
?>
