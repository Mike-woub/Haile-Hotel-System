<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "haile";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data from the database
$sql = "SELECT user_id, username, preferences, email FROM users";
$result = $conn->query($sql);

$user_profiles = [];

// Clear the contents of the JSON file before populating it
file_put_contents('users.json', ''); // This effectively empties the file

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $user_id = (int)$row["user_id"]; // Cast user_id to integer
        $email = $row["email"];

        // Fetch order history from food_orders table
        $order_sql = "SELECT items FROM food_orders WHERE email = '$email'";
        $order_result = $conn->query($order_sql);

        $order_history = [];
        if ($order_result->num_rows > 0) {
            while ($order_row = $order_result->fetch_assoc()) {
                $items = json_decode($order_row["items"], true);
                foreach ($items as $item) {
                    $item_id = $item["id"];

                    // Fetch item name from menu table
                    $menu_sql = "SELECT name FROM menu WHERE id = $item_id";
                    $menu_result = $conn->query($menu_sql);
                    if ($menu_result->num_rows > 0) {
                        $menu_row = $menu_result->fetch_assoc();
                        $order_history[] = $menu_row["name"];
                    }
                }
            }
        }

        $user_profiles[] = [
            "user_id" => $user_id, // Now stored as an integer
            "name" => $row["username"],
            "preferences" => explode(",", $row["preferences"]),
            "order_history" => $order_history
        ];
    }
} else {
    echo "0 results";
}

// Close the connection
$conn->close();

// Write user profiles to JSON file with JSON_NUMERIC_CHECK
file_put_contents('users.json', json_encode($user_profiles, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK));

echo "User profiles have been populated successfully.";
?>