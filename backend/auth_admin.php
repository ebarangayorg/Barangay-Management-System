<?php
session_start();

if (!isset($_SESSION['email']) || !isset($_SESSION['role'])) {
    header("Location: ../../admin_login.php");
    exit;
}

if ($_SESSION['role'] !== 'Barangay Staff') {
    $_SESSION['toast'] = ["msg" => "You are not authorized to access that page.", "type" => "error"];
    header("Location: ../../index.php");
    exit;
}

?>
