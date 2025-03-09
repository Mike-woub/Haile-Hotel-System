<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('database/config.php');

// Initialize the order_id variable
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : 'all';

// Initialize the query and total amount variable
$query = "";
$totalAmount = 0; // Initialize total amount variable

// Build the SQL query based on the order type
if ($order_id === 'food_orders') {
    $query = "SELECT transaction_ref, items, total_amount AS amount, order_date AS created_at, status, 'Food Order' AS order_type FROM food_orders";
} elseif ($order_id === 'rooms') {
    $query = "SELECT transaction_ref, room_type AS items, amount, created_at, status, 'Room Reservation' AS order_type FROM reservations"; 
} else {
    // For 'all' orders, combine both food orders and room reservations
    $query = "SELECT transaction_ref, items, total_amount AS amount, order_date AS created_at, status, 'Food Order' AS order_type FROM food_orders 
              UNION ALL 
              SELECT transaction_ref, room_type AS items, amount, created_at, status, 'Room Reservation' AS order_type FROM reservations"; 
}

$ordersStmt = $conn->prepare($query);
if (!$ordersStmt) {
    die("Query preparation failed: " . $conn->error);
}

$ordersStmt->execute();
$ordersResult = $ordersStmt->get_result();

$previousOrders = [];
while ($row = $ordersResult->fetch_assoc()) {
    $previousOrders[] = $row;
    $totalAmount += $row['amount']; // Add to total amount
}

$ordersStmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Previous Orders</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
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
    <script>
        async function downloadPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            doc.text("Previous Orders Report", 10, 10);
            let y = 20;

            const headers = ["Transaction Ref", "Items", "Total Amount Paid", "Order Date", "Order Type"];
            const data = <?php echo json_encode($previousOrders); ?>.map(order => [
                order.transaction_ref,
                order.items,
                order.amount,
                order.created_at,
                order.order_type
            ]);

            doc.autoTable({
                head: [headers],
                body: data,
                startY: y,
                theme: 'grid',
            });

            doc.save("previous_orders_report.pdf");
        }
    </script>
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
                    if ($order_id === 'food_orders') {
                        echo 'Food Orders';
                    } elseif ($order_id === 'rooms') {
                        echo 'Room Reservations';
                    } else {
                        echo 'All Orders';
                    }
                ?>
            </h1>
            <button onclick="downloadPDF()" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">Generate Report for This file</button>
            <?php if (empty($previousOrders)): ?>
                <p>No orders are currently available.</p>
            <?php else: ?>
                <table class="table-auto w-full text-left">
                    <thead>
                        <tr>
                            <th>Transaction Reference</th>
                            <th>Items</th>
                            <th>Total Amount Paid</th>
                            <th>Order Date</th>
                            <th>Order Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($previousOrders as $order): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['transaction_ref']); ?></td>
                                <td><?php echo htmlspecialchars($order['items']); ?></td>
                                <td><?php echo htmlspecialchars($order['amount']); ?></td>
                                <td><?php echo htmlspecialchars($order['created_at']); ?></td>
                                <td><?php echo htmlspecialchars($order['order_type']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="2"><strong>Total Amount:</strong></td>
                            <td><?php echo htmlspecialchars($totalAmount); ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>