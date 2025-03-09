<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('database/config.php');

// Initialize the status variable
$status = isset($_GET['order_id']) ? $_GET['order_id'] : 'all';

// Build the SQL query based on the status
if ($status === 'pending') {
    $query = "SELECT transaction_ref, items, total_amount, order_date, status FROM food_orders WHERE status = ?";
} elseif ($status === 'completed') {
    $query = "SELECT transaction_ref, items, total_amount, order_date, status FROM food_orders WHERE status = ?";
} else {
    $query = "SELECT transaction_ref, items, total_amount, order_date, status FROM food_orders WHERE status IN ('pending', 'completed')";
}

$ordersStmt = $conn->prepare($query);

// Bind the parameter if the status is either pending or completed
if ($status === 'pending' || $status === 'completed') {
    $ordersStmt->bind_param("s", $status);
}

$ordersStmt->execute();
$ordersResult = $ordersStmt->get_result();

$previousOrders = [];
while ($row = $ordersResult->fetch_assoc()) {
    $previousOrders[] = $row;
}

$ordersStmt->close();
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
            <h1 class="text-3xl mb-10">
                <?php 
                    if ($status === 'pending') {
                        echo 'Pending Food Orders';
                    } elseif ($status === 'completed') {
                        echo 'Completed Food Orders';
                    } else {
                        echo 'All Food Orders';
                    }
                ?>
            </h1>
            <?php if (empty($previousOrders)): ?>
                <p>NO food orders are currently available.</p>
            <?php else: ?>
                <table class="table-auto w-full text-left">
                    <thead>
                        <tr>
                            <th>Transaction Reference</th>
                            <th>Items</th>
                            <th>Total Amount Paid</th>
                            <th>Order Date</th>
                            <th>Status</th>
                            <th>Action</th>
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
                                <td>
                                    <?php if ($order['status'] === 'pending'): ?>
                                        <form method="POST" action="confirm_order.php" onsubmit="return confirm('Are you sure you want to confirm this order?');">
                                            <input type="hidden" name="transaction_ref" value="<?php echo htmlspecialchars($order['transaction_ref']); ?>">
                                            <button type="submit" class="bg-green-200 text-black p-1 rounded text-sm hover:text-cyan-900">Confirm</button>
                                        </form>
                                    <?php else: ?>
                                        <span>View</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>