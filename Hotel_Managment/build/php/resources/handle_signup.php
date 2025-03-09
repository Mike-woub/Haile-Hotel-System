<?php
require('../../database/config.php');
require '../../../vendor/autoload.php'; // Include PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

define('VALID_ROLES', ['guest', 'admin', 'h_chef', 'waiter', 'finance_h']);

function sanitizeInput($data)
{
    return htmlspecialchars(trim($data));
}

$email = sanitizeInput($_POST['email'] ?? '');
$username = sanitizeInput($_POST['username'] ?? '');
$firstname = sanitizeInput($_POST['firstname'] ?? '');
$lastname = sanitizeInput($_POST['lastname'] ?? '');
$password = sanitizeInput($_POST['password'] ?? '');
$role = sanitizeInput($_POST['role'] ?? '');

if (empty($email) || empty($password) || empty($role) || empty($username)) {
    echo json_encode(["success" => false, "message" => "All fields are required."]);
    exit();
}

if (!in_array($role, VALID_ROLES)) {
    echo json_encode(["success" => false, "message" => "Invalid role specified."]);
    exit();
}

$stmt = $conn->prepare('SELECT * FROM users WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "Email already exists. Please choose a different email."]);
    exit();
}

$stmt = $conn->prepare('SELECT * FROM users WHERE username = ?');
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "Username already exists. Please choose a different username."]);
    exit();
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$otp = rand(100000, 999999); // Generate a 6-digit OTP
$otp_expiration = date('Y-m-d H:i:s', strtotime('+1 hour')); // OTP expiration time

$stmt = $conn->prepare('INSERT INTO users (email, password, role, username, firstname, lastname, status, otp, otp_expiration) VALUES (?, ?, ?, ?, ?, ?, "inactive", ?, ?)');
$stmt->bind_param('ssssssss', $email, $hashedPassword, $role, $username, $firstname, $lastname, $otp, $otp_expiration);

if ($stmt->execute()) {
    // Send OTP to user's email
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true;
        $mail->Username = 'soberlyhigh@gmail.com'; // SMTP username
        $mail->Password = 'qqbmrmhavvfcjhud'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('soberlyhigh@gmail.com', 'Mikiyas Woubshet');
        $mail->addAddress($email); // Add a recipient

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Your OTP Code';
        $mail->Body    = "Your OTP code is: $otp";

        $mail->send();
        // Redirect to OTP verification form
        echo json_encode(["success" => true, "message" => "Registration successful. Redirecting to OTP verification..."]);
        exit();
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
        exit();
    }
} else {
    echo json_encode(["success" => false, "message" => "Registration failed. Please try again."]);
}

$stmt->close();
$conn->close();
?>