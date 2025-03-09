<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('database/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transactionRef = $_POST['transaction_ref'];

    // Update the order status to 'completed'
    $updateStmt = $conn->prepare("UPDATE food_orders SET status = ? WHERE transaction_ref = ?");
    $completedStatus = 'completed';

    if ($updateStmt) {
        $updateStmt->bind_param("ss", $completedStatus, $transactionRef);
        if ($updateStmt->execute()) {
            // Redirect back to previous orders page with success message
            header("Location: orders.php?message=Order confirmed successfully.");
            exit;
        } else {
            echo "Error updating status: " . $updateStmt->error;
        }
        $updateStmt->close();
    } else {
        echo "Error preparing statement.";
    }
}

$conn->close();
?>