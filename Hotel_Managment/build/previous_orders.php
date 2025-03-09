<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('database/config.php');

$email = $_GET['user_id'] ?? '';

if (empty($email)) {
    die("User is not logged in.");
}

// Fetch previous food orders from the database
$ordersStmt = $conn->prepare("SELECT transaction_ref, items, total_amount, order_date, status FROM food_orders WHERE email = ?");
$ordersStmt->bind_param("s", $email);
$ordersStmt->execute();
$ordersResult = $ordersStmt->get_result();

$previousOrders = [];
while ($row = $ordersResult->fetch_assoc()) {
    $previousOrders[] = $row;
}

$ordersStmt->close();

// If you close the connection before, you'll need to reopen it
if ($conn) {
    // No need to close the connection here; we'll use it below
} else {
    die("Database connection error.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Previous Food Orders</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        /* Apply border radius to the entire table */
        table {
            border: 1px solid white;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 10px;
            overflow: hidden;
            padding: 8px;
            text-align: center;
        }

        th {
            border: 1px solid black;
            background-color: white;
            color: black;
            padding: 10px;
        }

        td {
            font-size: 12px;
            padding: 12px;
            border: 1px solid black;
            background-color: white;
            color: black;
            padding: 10px;
        }

        tr:first-child th:first-child {
            border-top-left-radius: 10px;
        }

        tr:first-child th:last-child {
            border-top-right-radius: 10px;
        }

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
                <div><img src="img/Haile-Hotel-Wolaita-scaled.jpg" class="w-10 h-10 rounded-3xl" alt=""></div>
                <h1 class="text-3xl font-bold dark:text-white">Haile Hotel Wolaita</h1>
            </div>
        </section>
    </header>
    <main>
        <div class="max-w-4xl mx-auto items-center text-center">
            <h1 class="text-3xl mb-10">Previous Food Orders</h1>
            <?php if (empty($previousOrders)): ?>
                <p>No previous food orders available.</p>
            <?php else: ?>
                <table class="table-auto w-full text-left">
                    <thead>
                        <tr>
                            <th>Transaction Reference</th>
                            <th>Items</th>
                            <th>Total Amount Paid</th>
                            <th>Order Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($previousOrders as $order): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['transaction_ref']); ?></td>
                                <td>
                                    <?php 
                                    // Decode the items and fetch names
                                    $items = json_decode($order['items'], true);
                                    $itemNames = [];
                                    
                                    if (is_array($items)) {
                                        foreach ($items as $item) {
                                            $itemId = $item['id'];
                                            $itemQuantity = $item['quantity'];

                                            // Fetch item name from the menu_items table
                                            $nameStmt = $conn->prepare("SELECT name FROM menu WHERE id = ?");
                                            if ($nameStmt) {
                                                $nameStmt->bind_param("s", $itemId);
                                                $nameStmt->execute();
                                                $nameResult = $nameStmt->get_result();

                                                if ($nameRow = $nameResult->fetch_assoc()) {
                                                    $itemNames[] = htmlspecialchars($nameRow['name']) . " (Quantity: " . htmlspecialchars($itemQuantity) . ")";
                                                }

                                                $nameStmt->close();
                                            } else {
                                                echo "Error preparing statement.";
                                            }
                                        }
                                    } else {
                                        echo "Invalid items data";
                                    }

                                    echo implode("<br>", $itemNames);
                                    ?>
                                </td>
                                <td><?php echo htmlspecialchars($order['total_amount']); ?></td>
                                <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                                <td><?php echo htmlspecialchars($order['status']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>