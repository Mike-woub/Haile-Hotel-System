<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 


//Extract necessary values
$transactionRef = 2345678; // Use the transaction reference from the response
$email = "SOberlyhigh@gmail.com";
$amount = 2000;
$type_id = '1'; // Example room type (make sure this is correct)
$check_in_date = '2025-01-20'; // Example check-in date
$check_out_date = '2025-01-25'; // Example check-out date
     $thankYouUrl = "https://42b7-104-223-103-73.ngrok-free.app/haile-hotel-wolaita-final-year-project/build/php/resources/hello.php" .
     "?transaction_ref=" . urlencode($transactionRef) .
     "&email=" . urlencode($email) .
     "&amount=" . urlencode($amount) .
     "&type_id=" . urlencode($type_id) .
     "&check_in_date=" . urlencode($check_in_date) .
     "&check_out_date=" . urlencode($check_out_date);

     header("Location: " . $thankYouUrl);
    
    ?>
</body>
</html>