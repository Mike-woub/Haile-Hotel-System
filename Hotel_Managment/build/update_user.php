<?php
session_start();
include('database/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Update username
    if ($username) {
        $stmt = $conn->prepare("UPDATE users SET username = ? WHERE email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->close();
    }

    // Update password
    if ($password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashedPassword, $email);
        $stmt->execute();
        $stmt->close();
    }

    // Redirect or show a message
    echo "<script>alert('Profile updated successfully.'); window.location.href='profile.php';</script>";
}

$conn->close();
?>