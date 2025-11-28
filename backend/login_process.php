<?php 
session_start(); 
require_once 'config.php'; 

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

$postedRole = trim($_POST['role'] ?? '');
$isResidentForm = $postedRole === '';

if (empty($email) || empty($password)) {
    echo "<script>alert('Email and password are required'); window.history.back();</script>";
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('Invalid email format'); window.history.back();</script>";
    exit();
}

$user = $usersCollection->findOne(['email' => $email]);

if (!$user) {
    echo "<script>alert('User not found'); window.history.back();</script>";
    exit();
}

$stored = isset($user['password']) ? (string)$user['password'] : '';

if ($stored === '') {
    echo "<script>alert('Account has no password set'); window.history.back();</script>";
    exit();
}

if (!password_verify($password, $stored)) {
    echo "<script>alert('Incorrect password'); window.history.back();</script>";
    exit();
}

$userRole = isset($user['role']) ? $user['role'] : 'Resident';

if ($isResidentForm) {
    if ($userRole === 'Barangay Staff') {
        echo "<script>alert('Invalid role for this login form. Use Administrator Login.'); window.location.href='../resident_login.php';</script>";
        exit();
    }
} else {
    // Role posted (admin form)
    if ($postedRole !== '' && $userRole !== $postedRole) {
        echo "<script>alert('Invalid role for this account'); window.history.back();</script>";
        exit();
    }
}

session_regenerate_id(true);
$_SESSION['email'] = $user['email'];
$_SESSION['role'] = $userRole;
$_SESSION['user_id'] = (string)$user['_id'];  
$_SESSION['username'] = $user['email']; 

if ($userRole === 'Resident' && $user['status'] === 'Pending') {
    echo "<script>alert('Account not yet approved. Please wait for admin approval.'); window.history.back();</script>";
    exit();
}

if ($userRole === 'Barangay Staff') {
    header("Location: ../pages/admin/admin_dashboard.php");
} else {
    header("Location: ../pages/resident/resident_dashboard.php");
}
exit();


?>
