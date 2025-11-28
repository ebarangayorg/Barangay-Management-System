<?php
require "config.php";

if (isset($_GET["id"])) {
    $officialsCollection->deleteOne([
        "_id" => new MongoDB\BSON\ObjectId($_GET["id"])
    ]);

    header("Location: ../pages/admin/admin_officials.php");
    exit();
}
?>