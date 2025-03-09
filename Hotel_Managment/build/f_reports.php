<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('database/config.php');

// Fetch data from reservations and food_orders
$query = "
    SELECT 
        r.transaction_ref AS transaction_ref,
        r.email AS email,
        r.amount AS amount,
        r.created_at AS created_at,
        'room' AS type
    FROM 
        reservations r
    
    UNION ALL
    
    SELECT 
        f.transaction_ref AS transaction_ref,
        f.email AS email,
        f.total_amount AS amount,
        f.order_date     AS created_at,
        'food_order' AS type
    FROM 
        food_orders f
";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Query preparation failed: " . $conn->error);
}

if (!$stmt->execute()) {
    die("Query execution failed: " . $stmt->error);
}

$stmt->store_result(); // Store the result set
$result = $stmt->get_result(); // Get the result

if (!$result) {
    die("Query result retrieval failed: " . $stmt->error);
}

$transactions = [];
while ($row = $result->fetch_assoc()) {
    $transactions[] = $row;
}


$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Reports</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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

        /* Table header and cells styles */
        th, td {
            border: 1px solid black;
            background-color: white;
            color: black;
            padding: 10px;
        }

        th {
            font-weight: bold;
        }

        caption {
            font-size: 24px;
        }
    </style>
    <script>
        function downloadPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            doc.text("Transaction Reports", 10, 10);
            let y = 20;

            const headers = ["Transaction Reference", "Email", "Amount", "Created At", "Type"];
            const data = <?php echo json_encode($transactions); ?>.map(transaction => [
                transaction.transaction_ref,
                transaction.email,
                transaction.amount,
                transaction.created_at,
                transaction.type
            ]);

            doc.autoTable({
                head: [headers],
                body: data,
                startY: y
            });

            doc.save("transaction_reports.pdf");
        }
    </script>
</head>
<body>
    <header>
        <h1>Transaction Reports</h1>
    </header>
    <main>
        <div class="max-w-4xl mx-auto items-center text-center">
            <h1 class="text-3xl mb-10">Transaction Reports</h1>
            <button onclick="downloadPDF()" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">Download as PDF</button>
            <table class="table-auto w-full text-left">
                <thead>
                    <tr>
                        <th>Transaction Reference</th>
                        <th>Email</th>
                        <th>Amount</th>
                        <th>Created At</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $transaction): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($transaction['transaction_ref']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['email']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['amount']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['created_at']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['type']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table> 
        </div>
    </main>
</body>
</html>