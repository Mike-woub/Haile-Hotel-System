<?php
session_start();
include('database/config.php'); // Ensure this path is correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user ID and preferences from the form submission
    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $preferences = isset($_POST['preferences']) ? trim($_POST['preferences']) : '';

    // Validate input
    if ($user_id > 0 && !empty($preferences)) {
        // Prepare SQL statement to update preferences
        $stmt = $conn->prepare("UPDATE users SET preferences = ? WHERE user_id = ?");
        $stmt->bind_param("si", $preferences, $user_id);

        if ($stmt->execute()) {
            // Redirect back to the recommendations page
            header("Location: restaurant.php?user_id=" . urlencode($user_id));
            exit;
        } else {
            echo "Error updating preferences: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    } else {
        echo "Invalid user ID or preferences.";
    }
} else {
    echo "Invalid request method.";
}

// Close the database connection
$conn->close();
?>