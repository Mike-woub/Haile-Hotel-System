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

// Fetch current reservations from the database
$currentStmt = $conn->prepare("SELECT transaction_ref, room_type, check_in_date, check_out_date, amount, status FROM reservations WHERE email = ? AND status = 'checked in'");
$currentStmt->bind_param("s", $email);
$currentStmt->execute();
$currentResult = $currentStmt->get_result();

$currentReservations = [];
while ($row = $currentResult->fetch_assoc()) {
    $currentReservations[] = $row;
}

$currentStmt->close();

// Fetch reservation history (checked out)
$historyStmt = $conn->prepare("SELECT transaction_ref, room_type, check_in_date, check_out_date, amount, status FROM reservations WHERE email = ? AND status = 'checked out'");
$historyStmt->bind_param("s", $email);
$historyStmt->execute();
$historyResult = $historyStmt->get_result();

$reservationHistory = [];
while ($row = $historyResult->fetch_assoc()) {
    $reservationHistory[] = $row;
}

$historyStmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Current Reservations</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/styles.css">
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
    <script>
        function confirmCheckout(event) {
            if (!confirm("Are you sure you want to check out? The payment won't be refunded.")) {
                event.preventDefault();
            }
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
            <h1 class="text-3xl mb-10">Current Reservations</h1>
            <?php if (empty($currentReservations)): ?>
                <p>No current reservations checked in.</p>
            <?php else: ?>
                <table class="table-auto w-full text-left">
                    <thead>
                        <tr>
                            <th>Transaction Reference</th>
                            <th>Room Type</th>
                            <th>Check-in Date</th>
                            <th>Check-out Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($currentReservations as $reservation): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($reservation['transaction_ref']); ?></td>
                                <td><?php echo htmlspecialchars($reservation['room_type']); ?></td>
                                <td><?php echo htmlspecialchars($reservation['check_in_date']); ?></td>
                                <td><?php echo htmlspecialchars($reservation['check_out_date']); ?></td>
                                <td><?php echo htmlspecialchars($reservation['amount']); ?></td>
                                <td><?php echo htmlspecialchars($reservation['status']); ?></td>
                                <td><a href="checkout.php?transaction_ref=<?php echo urlencode($reservation['transaction_ref']); ?>&room_type=<?php echo urlencode($reservation['room_type']); ?>" class="cursor-pointer text-red-700 hover:text-red-600 font-bold" onclick="confirmCheckout(event)">Checkout</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <h1 class="text-3xl mt-10 mb-5">Reservation History</h1>
            <?php if (empty($reservationHistory)): ?>
                <p>No reservation history available.</p>
            <?php else: ?>
                <table class="table-auto w-full text-left">
                    <thead>
                        <tr>
                            <th>Transaction Reference</th>
                            <th>Room Type</th>
                            <th>Check-in Date</th>
                            <th>Check-out Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservationHistory as $history): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($history['transaction_ref']); ?></td>
                                <td><?php echo htmlspecialchars($history['room_type']); ?></td>
                                <td><?php echo htmlspecialchars($history['check_in_date']); ?></td>
                                <td><?php echo htmlspecialchars($history['check_out_date']); ?></td>
                                <td><?php echo htmlspecialchars($history['amount']); ?></td>
                                <td><?php echo htmlspecialchars($history['status']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>