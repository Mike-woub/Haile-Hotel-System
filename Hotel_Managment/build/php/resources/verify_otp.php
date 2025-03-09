<?php
require('../../database/config.php');

function sanitizeInput($data)
{
    return htmlspecialchars(trim($data));
}

$email = sanitizeInput($_POST['email'] ?? '');
$otp = sanitizeInput($_POST['otp'] ?? '');

if (empty($email) || empty($otp)) {
    echo json_encode(["success" => false, "message" => "All fields are required."]);
    exit();
}

// Check the database connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
    exit();
}

// Prepare the SQL statement
$stmt = $conn->prepare('SELECT * FROM users WHERE email = ? AND otp = ? AND otp_expiration > NOW() AND status = "inactive"');
if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
    exit();
}

$stmt->bind_param('ss', $email, $otp);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $stmt = $conn->prepare('UPDATE users SET status = "active", otp = NULL, otp_expiration = NULL WHERE email = ?');
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        exit();
    }
    $stmt->bind_param('s', $email);
    $stmt->execute();
    echo json_encode(["success" => true, "message" => "Email verified successfully!"]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid or expired OTP."]);
}

$stmt->close();
$conn->close();
?>