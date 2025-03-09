<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../../vendor/autoload.php';

// Define callback and return URLs
$callbackUrl = '  https://6c53-104-254-89-53.ngrok-free.app/haile-hotel-wolaita-final-year-project/build/php/resources/bcallback.php';
$returnUrl = '  https://6c53-104-254-89-53.ngrok-free.app/haile-hotel-wolaita-final-year-project/build/php/resources/thankyou.php';

// Retrieve parameters
$type_id = $_GET['room_id'] ?? '';
$email = $_GET['user_id'] ?? '';
$firstname = $_GET['firstname'] ?? '';
$lastname = $_GET['lastname'] ?? '';
$check_in_date = $_GET['checkin'] ?? ''; 
$check_out_date = $_GET['checkout'] ?? ''; 
$amount = $_GET['amount'] ?? ''; 
$order_type = $_GET['order_type'] ?? ''; 
$item_data = $_GET['item_data'] ?? null; // Retrieve item data

// Process item data
$items = [];
if ($item_data) {
    $items_array = explode(',', $item_data); // Split into items
    foreach ($items_array as $item) {
        list($id, $quantity) = explode(':', $item); // Split into ID and quantity
        $items[] = ['id' => $id, 'quantity' => $quantity]; // Store processed items
    }
}


// Generate a unique transaction reference
$transactionRef = bin2hex(random_bytes(16)); 

// Construct the callback URL with all necessary parameters
switch ($order_type){
    case 'room': $callbackUrlWithParams = $callbackUrl . '?transaction_ref=' . urlencode($transactionRef) .
    '&email=' . urlencode($email) .
    '&amount=' . urlencode($amount) .
    '&firstname=' . urlencode($firstname) .
    '&lastname=' . urlencode($lastname) .
    '&type_id=' . urlencode($type_id) .
    '&check_in_date=' . urlencode($check_in_date) .
    '&check_out_date=' . urlencode($check_out_date).
    '&ordertype=' . urlencode($order_type);
    break;
    
    case 'order':
     $callbackUrlWithParams = $callbackUrl . '?transaction_ref=' . urlencode($transactionRef) .
        '&email=' . urlencode($email) .
        '&amount=' . urlencode($amount) .
        '&firstname=' . urlencode($firstname) .
        '&lastname=' . urlencode($lastname) .
        '&ordertype=' . urlencode($order_type) .
        '&items=' . urlencode(json_encode($items)); // Encode items as JSON
    break;

}

// Create payment data based on order type
switch ($order_type) {
    case 'room':
        $postData = [
            'amount' => $amount,
            'currency' => 'ETB',
            'email' => $email,
            'first_name' => $firstname,
            'last_name' => $lastname,
            'tx_ref' => $transactionRef,
            'callback_url' => $callbackUrlWithParams,
            'return_url' => $returnUrl,
            'customization' => [
                'title' => 'Room Booking',
                'description' => 'Payment for room booking'
            ]
        ];
        // You can also include items in the postData if needed
        break;

    case 'order':
        $postData = [
            'amount' => $amount,
            'currency' => 'ETB',
            'email' => $email,
            'first_name' => $firstname,
            'last_name' => $lastname,
            'tx_ref' => $transactionRef,
            'callback_url' => $callbackUrlWithParams,
            'return_url' => $returnUrl,
            'customization' => [
                'title' => 'Food Order',
                'description' => 'Payment for Room Service'
            ]
        ];
        // You can also include items in the postData if needed
        break;

    default:
        echo "Invalid order type.";
        exit();
}

// Use cURL to initialize the transaction
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => 'https://api.chapa.co/v1/transaction/initialize',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode($postData),
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer CHASECK_TEST-q0kqx7kkQi45EJ3NhHYlYVWNoviWQILj',
        'Content-Type: application/json'
    ],
]);

$response = curl_exec($curl);
curl_close($curl);
$responseData = json_decode($response, true);

// Check the response from the payment API
if ($responseData['status'] === 'success') {
    // Redirect to Chapa payment page
    header("Location: " . $responseData['data']['checkout_url']);
    exit();
} else {
    // Handle error
    file_put_contents('payment_error_log.txt', json_encode($responseData['message']) . "\n", FILE_APPEND);
    echo "Error: " . htmlspecialchars(json_encode($responseData['message']));
}
?>