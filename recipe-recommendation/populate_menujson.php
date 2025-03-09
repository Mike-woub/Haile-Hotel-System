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

// Fetch data from the database
$sql = "SELECT name, description, price, course, IFNULL(order_count, 0) AS order_count FROM menu"; // Use IFNULL to handle null values
$result = $conn->query($sql);

$menuItems = array();

// Clear the contents of the JSON file before populating it
file_put_contents('menu.json', ''); // This effectively empties the file

if ($result->num_rows > 0) {
    // Process each row and add to the array
    while($row = $result->fetch_assoc()) {
        $item = array(
            "dish_name" => $row["name"],
            "ingredients" => explode(", ", $row["description"]),
            "price" => (float)$row["price"], // Convert to float
            "course" => $row["course"],
            "order_count" => (int)$row["order_count"] // Convert to integer
        );
        array_push($menuItems, $item);
    }
} else {
    echo "No records found.";
}

// Encode the array into JSON format
$jsonData = json_encode($menuItems, JSON_PRETTY_PRINT);

// Save JSON data to a file
file_put_contents('menu.json', $jsonData);

echo "Data successfully written to menu.json.";

// Close connection
$conn->close();
?>