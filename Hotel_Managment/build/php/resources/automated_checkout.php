<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../../database/config.php');

// Get the current date and time
$currentDateTime = date('Y-m-d H:i:s');

// Fetch reservations that need to be checked out
$stmt = $conn->prepare("SELECT transaction_ref, room_type FROM reservations WHERE check_out_date <= ? AND status = 'checked in'");
$stmt->bind_param("s", $currentDateTime);
$stmt->execute();
$result = $stmt->get_result();

while ($reservation = $result->fetch_assoc()) {
    $transactionRef = $reservation['transaction_ref'];
    $room_type = $reservation['room_type'];

    // Update the reservation status to "checked out"
    $updateStmt = $conn->prepare("UPDATE reservations SET status = 'checked out' WHERE transaction_ref = ?");
    $updateStmt->bind_param("s", $transactionRef);
    $updateStmt->execute();
    $updateStmt->close();

    // Fetch total_available from rooms table and increment it by 1
    $roomStmt = $conn->prepare("SELECT total_available FROM rooms WHERE type_id = ?");
    $roomStmt->bind_param("s", $room_type);
    $roomStmt->execute();
    $roomResult = $roomStmt->get_result();
    $room = $roomResult->fetch_assoc();
    $total_available = $room['total_available'] + 1;
    $roomStmt->close();

    // Update the rooms table with the new total_available
    $updateRoomStmt = $conn->prepare("UPDATE rooms SET total_available = ? WHERE type_id = ?");
    $updateRoomStmt->bind_param("is", $total_available, $room_type);
    $updateRoomStmt->execute();
    $updateRoomStmt->close();
}

$stmt->close();
$conn->close();
?>
