<?php
// Database connection
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

// Truncate the table to remove all existing records and reset the auto-increment ID
$truncate_sql = "TRUNCATE TABLE menu";
if ($conn->query($truncate_sql) === TRUE) {
    echo "Table cleaned successfully.\n";
} else {
    echo "Error cleaning table: " . $conn->error . "\n";
}

// Reset the auto-increment value
$reset_auto_increment_sql = "ALTER TABLE menu AUTO_INCREMENT = 1";
if ($conn->query($reset_auto_increment_sql) === TRUE) {
    echo "Auto-increment ID reset successfully.\n";
} else {
    echo "Error resetting auto-increment ID: " . $conn->error . "\n";
}

// Read JSON file
$jsonData = file_get_contents('menu.json');
$menuItems = json_decode($jsonData, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die("Error parsing JSON: " . json_last_error_msg());
}

// Insert data into the database
foreach ($menuItems as $index => $item) {
    $name = $conn->real_escape_string($item['dish_name']);
    $description = $conn->real_escape_string(implode(", ", $item['ingredients']));
    $price = $conn->real_escape_string($item['price']);
    $course = $conn->real_escape_string($item['course']);
    
    $sql = "INSERT INTO menu (name, description, price, course) VALUES ('$name', '$description', '$price', '$course')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully for $name\n";
    } else {
        echo "Error: " . $sql . "\n" . $conn->error . "\n";
    }
    
    // Log each processed item
    echo "Processed item $index: $name\n";
}

// Close connection
$conn->close();
?>
