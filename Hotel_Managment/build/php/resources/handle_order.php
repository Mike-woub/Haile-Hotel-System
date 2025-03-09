<?php
require('../../database/config.php');




    $userId = $_GET['user_id'] ?? '';
    $ordertype = $_GET['order_type'] ?? '';
    $itemdata = $_GET['item_data'] ?? '';
    $amount = $_GET['amount'] ?? '';

    if (!empty($userId)) {
        // Prepare the SQL statement to fetch user details
        $stmt = $conn->prepare("SELECT firstname, lastname FROM users WHERE email = ?");
        if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
        }

        // Bind and execute the statement
        $stmt->bind_param('s', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $firstname = htmlspecialchars($row['firstname']);
            $lastname = htmlspecialchars($row['lastname']);
        } else {
            echo "No user found with the provided email.";
            exit; // Stop execution if user is not found
        }

        $stmt->close();
        header("Location: booking.php?amount=" . urlencode($amount) . 
           "&user_id=" . urlencode($userId) . 
           "&item_data=" . urlencode($itemdata) . 
           "&firstname=" . urlencode($firstname) . 
           "&lastname=" . urlencode($lastname) . 
           "&order_type=" . urlencode($ordertype));
    exit();
    } else {
        echo "<script>alert('You Need to Log in to Be able to ordder food and beverages'); window.location.href='../../login.html';</script>";
        exit; // Stop execution if user ID is missing
    }

    // Redirect to booking.php with the required parameters
    
?>