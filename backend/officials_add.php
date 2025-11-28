<?php
require_once "config.php";

$name = $_POST["name"];
$position = $_POST["position"];

$filename = "";

if (!empty($_FILES["photo"]["name"])) {
    $filename = time() . "_" . basename($_FILES["photo"]["name"]);
    $target = "../assets/officials/" . $filename;
    move_uploaded_file($_FILES["photo"]["tmp_name"], $target);
}

$officialsCollection->insertOne([
    "name"   => $name,
    "position" => $position,
    "image"   => $filename,
    "status"  => "active",
]);

header("Location: ../pages/admin/admin_officials.php");
exit;
?>