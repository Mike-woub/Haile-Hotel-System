<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../../vendor/autoload.php';
require '../../database/config.php'; // Include your database connection file

use Chapa\Chapa;

// Initialize Chapa with your test secret key
$chapa = new Chapa('CHASECK_TEST-q0kqx7kkQi45EJ3NhHYlYVWNoviWQILj');

// Create a connection to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "haile";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Error connecting to Database: " . $conn->connect_error);
}

// Get the transaction reference and other details from the callback URL
$transactionRef = $_GET['transaction_ref'] ?? '';
$email = $_GET['email'] ?? 'no email';
$firstname = $_GET['firstname'] ?? 'no firstname';
$lastname = $_GET['lastname'] ?? 'no lastname';
$amount = $_GET['amount'] ?? '';
$items = $_GET['items'] ?? '';
$type_id = $_GET['type_id'] ?? '';
$order_type = $_GET['ordertype'] ?? '';
$checkinDate = $_GET['check_in_date'] ?? '';
$checkoutDate = $_GET['check_out_date'] ?? '';



// Log the incoming request
$response = $chapa->verify($transactionRef);
$data = $response->getData();
if($order_type == 'room'){
file_put_contents('callback_log.txt', "Transaction Ref: $transactionRef\n", FILE_APPEND);
file_put_contents('callback_log.txt', "Email: $email\n", FILE_APPEND);
file_put_contents('callback_log.txt', "First Name: $firstname\n", FILE_APPEND);
file_put_contents('callback_log.txt', "Last Name: $lastname\n", FILE_APPEND);
file_put_contents('callback_log.txt', "Amount: $amount\n", FILE_APPEND);
file_put_contents('callback_log.txt', "Type ID: $type_id\n", FILE_APPEND);
file_put_contents('callback_log.txt', "Check-in Date: $checkinDate\n", FILE_APPEND);
file_put_contents('callback_log.txt', "Check-out Date: $checkoutDate\n", FILE_APPEND);
file_put_contents('ordertype_log.txt', "Order Type: $order_type\n", FILE_APPEND);
file_put_contents('callback_log.txt', "Payment successful: " . json_encode($data) . "\n", FILE_APPEND);

}
else if ($order_type == 'order'){
    file_put_contents('order_log.txt', "Transaction Ref: $transactionRef\n", FILE_APPEND);
file_put_contents('order_log.txt', "Email: $email\n", FILE_APPEND);
file_put_contents('order_log.txt', "First Name: $firstname\n", FILE_APPEND);
file_put_contents('order_log.txt', "Last Name: $lastname\n", FILE_APPEND);
file_put_contents('order_log.txt', "Amount: $amount\n", FILE_APPEND);
file_put_contents('ordertype_log.txt', "Order Type: $order_type\n", FILE_APPEND);
file_put_contents('order_log.txt', "Items: $items\n", FILE_APPEND);
}

// Verify the transaction


if ($response->getStatusCode() == 200) {
    // Payment was successful
    $data = $response->getData();

    // Redirect to the thank-you page without parameters
    header("Location:  https://6c53-104-254-89-53.ngrok-free.app/haile-hotel-wolaita-final-year-project/build/php/resources/thankyou.php");
    exit();
} else {
    // Payment failed
    $errorMessage = $response->getMessage();
    // Log the error
    file_put_contents('callback_log.txt', "Error: " . json_encode($errorMessage) . "\n", FILE_APPEND);
    echo "Error: " . htmlspecialchars($errorMessage); // Escape output for safety
}

// Close the connection
$conn->close();
?>