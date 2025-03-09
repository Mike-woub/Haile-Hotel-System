<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../../database/config.php');

// Initialize parameters
$transactionRef = '';
$email = 'no email';
$firstname = 'no First Name';
$lastname = 'no Last Name';
$amount = '';
$room_type = '';
$checkinDate = '';
$checkoutDate = '';
$status = 'checked in';

// Determine order type from ordertype_log.txt
$order_type = '';
if (file_exists('ordertype_log.txt')) {
    $logContents = file_get_contents('ordertype_log.txt');
    $lines = explode("\n", trim($logContents));
    $lastLine = end($lines); // Get the last line

    if (strpos($lastLine, 'Order Type: ') !== false) {
        $order_type = trim(str_replace('Order Type: ', '', $lastLine));
    }
}

// Read from the appropriate log based on order type
if ($order_type === 'room') {
    // Read the log file for room details
    if (file_exists('callback_log.txt')) {
        $logContents = file_get_contents('callback_log.txt');
        $lines = explode("\n", trim($logContents));
        $lastEntries = [];

        foreach (array_reverse($lines) as $line) {
            if (!empty(trim($line))) {
                $lastEntries[] = $line;
                if (count($lastEntries) >= 10) {
                    break;
                }
            }
        }

        // Parse the last entries for room details
        $parameters = [];
        if ($lastEntries) {
            foreach ($lastEntries as $entry) {
                if (strpos($entry, ': ') !== false) {
                    list($key, $value) = explode(': ', $entry, 2);
                    $parameters[trim($key)] = trim($value);
                }
            }
        }

        // Access room reservation parameters
        $transactionRef = $parameters['Transaction Ref'] ?? '';
        $email = $parameters['Email'] ?? 'no email';
        $firstname = $parameters['First Name'] ?? 'no First Name';
        $lastname = $parameters['Last Name'] ?? 'no Last Name';
        $amount = $parameters['Amount'] ?? '';
        $room_type = $parameters['Type ID'] ?? '';
        $checkinDate = $parameters['Check-in Date'] ?? '';
        $checkoutDate = $parameters['Check-out Date'] ?? '';
        $_SESSION['user_id']=$email;
    }
    $message = "Thank you for your reservation! Here are your details:";

    // Update the database with reservation or order details
    $stmt = $conn->prepare("INSERT INTO reservations (transaction_ref, email, room_type, check_in_date, check_out_date, amount, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $transactionRef, $email, $room_type, $checkinDate, $checkoutDate, $amount, $status);

    if ($stmt->execute()) {
        // Successfully inserted
    } else {
        // Handle the error
        error_log("Database insertion error: " . $stmt->error);
    }

    // Close the statement
    $stmt->close();

    // Fetch total_available from rooms table and decrement it by 1 if it's a room reservation
    if ($room_type && $order_type === 'room') {
        $stmt = $conn->prepare("SELECT total_available FROM rooms WHERE type_id = ?");
        $stmt->bind_param("s", $room_type);
        $stmt->execute();
        $result = $stmt->get_result();
        $room = $result->fetch_assoc();
        $total_available = $room['total_available'] - 1;
        $stmt->close();

        // Update the rooms table with the new total_available
        $stmt = $conn->prepare("UPDATE rooms SET total_available = ? WHERE type_id = ?");
        $stmt->bind_param("is", $total_available, $room_type);

        if ($stmt->execute()) {
            // Successfully updated
        } else {
            // Handle the error
            error_log("Database update error: " . $stmt->error);
        }

        // Close the statement
        $stmt->close();
    }

} elseif ($order_type === 'order') {
    // Read the order log file for order details
    if (file_exists('order_log.txt')) {
        $orderLogContents = file_get_contents('order_log.txt');
        $orderLines = explode("\n", trim($orderLogContents));
        $orderEntries = [];

        // Read the last few entries
        foreach (array_reverse($orderLines) as $line) {
            if (!empty(trim($line))) {
                $orderEntries[] = $line;
                if (count($orderEntries) >= 6) {
                    break;
                }
            }
        }

        // Parse the last entries for order details
        $orderParameters = [];
        if ($orderEntries) {
            foreach ($orderEntries as $entry) {
                if (strpos($entry, ': ') !== false) {
                    list($key, $value) = explode(': ', $entry, 2);
                    $orderParameters[trim($key)] = trim($value);
                }
            }
        }

        // Access order details
        $transactionRef = $orderParameters['Transaction Ref'] ?? '';
        $email = $orderParameters['Email'] ?? 'no email';
        $_SESSION['user_id'] = $email;
        $firstname = $orderParameters['First Name'] ?? 'no First Name';
        $lastname = $orderParameters['Last Name'] ?? 'no Last Name';
        $amount = $orderParameters['Amount'] ?? '0';
        $items = json_decode($orderParameters['Items'] ?? '[]', true); // Decode JSON items

        // Prepare the JSON encoded items
        $jsonItems = json_encode($items);
        $status = 'pending';

        // Check if the food order already exists
        $stmt = $conn->prepare("SELECT COUNT(*) FROM food_orders WHERE transaction_ref = ?");
        $stmt->bind_param("s", $transactionRef);
        $stmt->execute();
        $stmt->bind_result($orderCount);
        $stmt->fetch();
        $stmt->close();

        if ($orderCount == 0) { // Only insert if it doesn't already exist
            // Prepare to insert the food order into the food_orders table
            $stmt = $conn->prepare("INSERT INTO food_orders (transaction_ref, email, first_name, last_name, items, total_amount, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssds", $transactionRef, $email, $firstname, $lastname, $jsonItems, $amount, $status);

            if ($stmt->execute()) {
                // Successfully inserted
            } else {
                // Handle the error
                error_log("Database insertion error: " . $stmt->error);
            }

            // Close the statement
            $stmt->close();
        } else {
            // Instead of exiting, just log that the order was already processed
            error_log("This order has already been processed: " . $transactionRef);
        }
    } else {
        echo "Order log file does not exist.";
        exit;
    }

    $message = "Thank you for your Food Order! Here are your Order details:";
}

// Prepare item details for display
$itemDetails = [];
if ($order_type === 'order' && !empty($items)) {
    foreach ($items as $item) {
        $itemId = $item['id'];
        $quantity = $item['quantity'];

        // Fetch item name from the database
        $stmt = $conn->prepare("SELECT name FROM menu WHERE id = ?");
        $stmt->bind_param("s", $itemId);
        $stmt->execute();
        $result = $stmt->get_result();
        $itemData = $result->fetch_assoc();
        $itemName = $itemData['name'] ?? 'Unknown Item';

        $itemDetails[] = "$itemName (Quantity: $quantity)";
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <link rel="stylesheet" href="../../css/style.css">
    <style>
      /* Apply border radius to the entire table */
      table {
          border: 1px solid white;
          border-collapse: separate; /* Ensure border-radius works */
          border-spacing: 0; /* Remove spacing between cells */
          border-radius: 10px;
          overflow: hidden; /* Ensure rounded corners are visible */
          padding: 8px;
          text-align: center;
      }

      /* Apply border radius to table header */
      th {
          border: 1px solid black;
          background-color: white;
          color: black;
          padding: 10px;
      }

      /* Apply border radius to table cells */
      td {
          font-size: 12px;
          padding: 12px;
          border: 1px solid black;
          background-color: white;
          color: black;
          padding: 10px;
      }

      /* Apply border radius to the first and last cells in the first row */
      tr:first-child th:first-child {
          border-top-left-radius: 10px;
      }

      tr:first-child th:last-child {
          border-top-right-radius: 10px;
      }

      /* Apply border radius to the first and last cells in the last row */
      tr:last-child td:first-child {
          border-bottom-left-radius: 10px;
      }

      tr:last-child td:last-child {
          border-bottom-right-radius: 10px;
      }

      caption {
          font-size: 24px;
      }
    </style>
</head>
<body class="dark:text-white dark:bg-slate-600">
    <header class="w-full sticky bg-slate-50 dark:bg-slate-700 top-0 z-10">
        <section class="ml-8 mr-8 flex flex-row justify-center items-center p-4">
            <div class="flex flex-row items-center gap-3">
                <div><img src="../../img/Haile-Hotel-Wolaita-scaled.jpg" class="w-10 h-10 rounded-3xl" alt=""></div>
                <h1 class="text-3xl font-bold dark:text-white">Haile Hotel Wolaita</h1>
            </div>
        </section>
    </header>
    <main>
        <div class="max-w-4xl mx-auto items-center text-center">
            <?php if ($order_type == 'room'): ?>
                <h1 class="text-3xl mb-10"><?php echo htmlspecialchars($message); ?></h1>
                <table class="table-auto w-full text-left">
                    <thead>
                        <tr>
                            <th>Transaction Reference</th>
                            <th>Email</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Room Type</th>
                            <th>Check-in Date</th>
                            <th>Check-out Date</th>
                            <th>Amount Paid</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo htmlspecialchars($transactionRef); ?></td>
                            <td><?php echo htmlspecialchars($email); ?></td>
                            <td><?php echo htmlspecialchars($firstname); ?></td>
                            <td><?php echo htmlspecialchars($lastname); ?></td>
                            <td><?php echo htmlspecialchars($room_type); ?></td>
                            <td><?php echo htmlspecialchars($checkinDate); ?></td>
                            <td><?php echo htmlspecialchars($checkoutDate); ?></td>
                            <td><?php echo htmlspecialchars($amount); ?></td>
                        </tr>
                    </tbody>
                </table>

            <?php elseif ($order_type == 'order'): ?>
                <h1 class="text-3xl mb-10"><?php echo htmlspecialchars($message); ?></h1>
                <table class="table-auto w-full text-left">
                    <thead>
                        <tr>
                            <th>Transaction Reference</th>
                            <th>Email</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Items</th>
                            <th>Amount Paid</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo htmlspecialchars($transactionRef); ?></td>
                            <td><?php echo htmlspecialchars($email); ?></td>
                            <td><?php echo htmlspecialchars($firstname); ?></td>
                            <td><?php echo htmlspecialchars($lastname); ?></td>
                            <td><?php echo htmlspecialchars(implode(', ', $itemDetails)); ?></td>
                            <td><?php echo htmlspecialchars($amount); ?></td>
                            <td><?php echo 'Pending'; ?></td>
                        </tr>
                    </tbody>
                </table>
            <?php endif; ?>
            <a href="../../guest.php" class="mt-10 text-cyan-300 hover:text-cyan-200">GO Back?</a>
        </div>
    </main>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>