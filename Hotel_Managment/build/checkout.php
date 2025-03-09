<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('database/config.php');

$transactionRef = $_GET['transaction_ref'] ?? '';
$room_type = $_GET['room_type'] ?? '';

if (empty($transactionRef) || empty($room_type)) {
    die("Transaction reference and room type are required.");
}

// Update the reservation status to "checked out"
$stmt = $conn->prepare("UPDATE reservations SET status = 'checked out' WHERE transaction_ref = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("s", $transactionRef);

if ($stmt->execute()) {
    // Successfully updated
} else {
    // Handle the error
    error_log("Database update error: " . $stmt->error);
}

// Close the statement
$stmt->close();

// Fetch total_available from rooms table and increment it by 1
$stmt = $conn->prepare("SELECT total_available FROM rooms WHERE type_id = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("s", $room_type);
$stmt->execute();
$result = $stmt->get_result();
$room = $result->fetch_assoc();
$total_available = $room['total_available'] + 1;
$stmt->close();

// Update the rooms table with the new total_available
$stmt = $conn->prepare("UPDATE rooms SET total_available = ? WHERE type_id = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("is", $total_available, $room_type);

if ($stmt->execute()) {
    // Successfully updated
} else {
    // Handle the error
    error_log("Database update error: " . $stmt->error);
}

// Close the statement
$stmt->close();

// Redirect to a confirmation page
header("Location: checkout_confirmation.php");
exit();
?>
