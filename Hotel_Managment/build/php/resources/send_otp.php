<?php
session_start();
require('../../database/config.php');
require '../../../vendor/autoload.php'; // Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: change_password.php");
        exit();
    }

    // Generate OTP
    $otp = rand(100000, 999999); // 6-digit OTP
    $otp_expiration = date('Y-m-d H:i:s', strtotime('+1 hour')); // OTP expiration time

    // Update OTP in the database
    $stmt = $conn->prepare('UPDATE users SET otp = ?, otp_expiration = ? WHERE email = ?');
    $stmt->bind_param('sss', $otp, $otp_expiration, $email);
    $stmt->execute();

    // Send OTP to user's email
    $mail = new PHPMailer(true); // Make sure to include PHPMailer
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'soberlyhigh@gmail.com'; // SMTP username
        $mail->Password = 'qqbmrmhavvfcjhud'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('soberlyhigh@gmail.com', 'Haile Hotel');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body = "Your OTP code is: $otp";
        $mail->send();

        // Set session variable to indicate OTP has been sent
        $_SESSION['otp_sent'] = true;
        echo "<script>alert('OTP has been sent to your email.');</script>";
        // Redirect back to the main page
        header("Location: ../../change_password_ui.php?email=" . urlencode($email));
        exit(); // Always call exit after header redirection
    } catch (Exception $e) {
        $_SESSION['error'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        echo "<script>alert('OTP has not been sent to your email.');</script>";
        header("Location: ../../change_password_ui.php?email=" . urlencode($email));
        exit();
    }
}
?>