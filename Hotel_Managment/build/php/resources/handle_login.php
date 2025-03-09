<?php
session_start();
require('../../database/config.php');
require '../../../vendor/autoload.php'; // Include PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sanitizeInput($data)
{
    return htmlspecialchars(trim($data));
}

$email = sanitizeInput($_POST['email'] ?? '');
$password = sanitizeInput($_POST['password'] ?? '');

if (empty($email) || empty($password)) {
    echo json_encode(["success" => false, "message" => "All fields are required."]);
    exit();
}

$stmt = $conn->prepare('SELECT * FROM users WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Check user status
    if ($user['status'] == 'inactive') {
        // Generate OTP
        $otp = rand(100000, 999999); // 6-digit OTP
        $otp_expiration = date('Y-m-d H:i:s', strtotime('+1 hour')); // OTP expiration time

        // Update OTP in the database
        $stmt = $conn->prepare('UPDATE users SET otp = ?, otp_expiration = ? WHERE email = ?');
        $stmt->bind_param('sss', $otp, $otp_expiration, $email);
        $stmt->execute();

        // Send OTP to user's email
        $mail = new PHPMailer(true);
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
            $mail->Body    = "Your OTP code is: $otp";

            $mail->send();
            echo json_encode(["success" => true, "message" => "OTP sent to your email."]);
            exit();
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
            exit();
        }
    } else {
        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_id'] = $user['email'];

            // Redirect based on user role
            switch ($user['role']) {
                case 'guest':
                    echo json_encode(["success" => true, "message" => "Login successful!"  ,"redirect" => "guest.php"]);
                    break;
                case 'admin':
                    echo json_encode(["success" => true, "message" => "Login successful!"  ,"redirect" => "a_dashboard.php"]);
                    break;
                case 'h_chef':
                    echo json_encode(["success" => true,"message" => "Login successful!"  , "redirect" => "chef_dashboard.php"]);
                    break;
                case 'waiter':
                    echo json_encode(["success" => true, "message" => "Login successful!"  ,"redirect" => "waiter.php"]);
                    break;
                case 'f_head':
                    echo json_encode(["success" => true, "message" => "Login successful!"  ,"redirect" => "f_head_dashboard.php"]);
                    break;
                default:
                    echo json_encode(["success" => false, "message" => "Invalid user role."]);
                    exit();
            }
            exit();
        } else {
            echo json_encode(["success" => false, "message" => "Incorrect password. Please try again."]);
        }
    }
} else {
    echo json_encode(["success" => false, "message" => "User not found. Please check your email."]);
}

$stmt->close();
$conn->close();
?>