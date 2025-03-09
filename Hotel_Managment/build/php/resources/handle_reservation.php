<?php
require('../../database/config.php');
$reserve = $_POST['reserve'] ?? null;
if (isset($reserve)) {
    // Retrieve the room ID and other data
    $roomId = $_POST['room_id'] ?? '';
    $userId = $_POST['user_id'] ?? '';
    $checkin = $_POST['checkin'] ?? '';
    $checkout = $_POST['checkout'] ?? '';
    $amount = $_POST['amount'] ?? '';
    $ordertype = 'room';

if (isset($_POST['user_id']) && $_POST['user_id'] != null) {
    
    $stmt = $conn->prepare("SELECT firstname, lastname FROM users WHERE email = ?"); // Assuming user_id is the email
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }
    $userId = $_POST['user_id'] ?? '';
    $stmt->bind_param('s', $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $firstname = htmlspecialchars($row['firstname']);
        $lastname = htmlspecialchars($row['lastname']);
    } else {
        echo "No user found with the provided email.";
    }
      // Redirect to booking.php with the required parameters
      header("Location: booking.php?room_id=" . urlencode($roomId) . "&user_id=" . urlencode($userId) . "&order_type=" . urlencode($ordertype). "&amount=" . urlencode($amount). "&firstname=" . urlencode($firstname). "&lastname=" . urlencode($lastname) . "&checkin=" . urlencode($checkin) . "&checkout=" . urlencode($checkout));
      exit();

    $stmt->close();
} else {
    echo "<script>alert('You Need to Log in to Be able to reserve a Room'); window.location.href='../../login.html';</script>";
}
  
}
?>