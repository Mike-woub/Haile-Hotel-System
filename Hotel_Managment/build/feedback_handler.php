<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('database/config.php'); // Include your database configuration

$email = $_SESSION['user_id'] ?? '';

if (empty($email)) {
    die("User is not logged in.");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $feedback = $_POST['feedback'] ?? '';

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO feedbacks (user, feedback) VALUES (?, ?)");
    

        // Bind and execute the feedback insert
        $stmt->bind_param("ss", $email, $feedback);
        $stmt->execute();
        $stmt->close();

    $stmt = $conn->prepare("SELECT role FROM users where email = ? ");
    

    $stmt->bind_param("s", $email);
    
    // Execute the statement
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();

    // Check if any row returned
    if ($result->num_rows > 0) {
        // Fetch the role
        $row = $result->fetch_assoc();
        $role = $row['role'];
       if($role === 'guest'){
        echo "<script>alert('Thank you for your feedback our guest!'); window.location.href='guest.php?user_id=" . urlencode($email) . "';</script>";
       }
       elseif($role === 'h_chef'){
        echo "<script>alert('Thank you for your feedback Dear Head Chef!'); window.location.href='chef_dashboard.php?user_id=" . urlencode($email) . "';</script>";
       }
       elseif($role === 'waiter'){
        echo "<script>alert('Thank you for your feedback Dear waiter!'); window.location.href='waiter.php?user_id=" . urlencode($email) . "';</script>";
       }
    } else {
        echo "No user found with that email.";
    }
        $stmt->close();


        

        
}