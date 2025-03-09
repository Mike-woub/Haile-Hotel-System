<?php
session_start();
include('database/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $otp = $_POST['otp'];
    $n_password = $_POST['n_password'];
    $c_password = $_POST['c_password'];

    // Validate the OTP
    $stmt = $conn->prepare('SELECT otp, otp_expiration FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $db_otp = $row['otp'];
        $otp_expiration = $row['otp_expiration'];

        // Check if OTP matches and is not expired
        if ($otp == $db_otp && strtotime($otp_expiration) > time()) {
            // Validate new password
            if ($n_password === $c_password) {
                // Update the password in the database
                $stmt = $conn->prepare('UPDATE users SET password = ?, otp = NULL, otp_expiration = NULL WHERE email = ?');
                $hashed_password = password_hash($n_password, PASSWORD_DEFAULT); // Hash the new password
                $stmt->bind_param('ss', $hashed_password, $email);
                if ($stmt->execute()) {
                    echo "<script>alert('Password changed successfully.'); window.location.href='login.html';</script>";
                } else {
                    echo "<script>alert('Error updating password.'); window.history.back();</script>";
                }
            } else {
                echo "<script>alert('Passwords do not match.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Invalid or expired OTP.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('User not found.'); window.history.back();</script>";
    }
}
?>