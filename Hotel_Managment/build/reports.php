<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('database/config.php');

// Fetch reservation history (checked out)
$historyStmt = $conn->prepare("SELECT * FROM feedbacks");
$historyStmt->execute();
$historyResult = $historyStmt->get_result();

$feedbacks = [];
while ($row = $historyResult->fetch_assoc()) {
    $feedbacks[] = $row;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
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

        function downloadPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            doc.text("User Feedback Reports", 10, 10);
            let y = 20;

            const headers = ["Report Id", "User", "Feedback", "Created at"];
            const data = <?php echo json_encode($feedbacks); ?>.map(feedback => [
                feedback.f_id,
                feedback.user,
                feedback.feedback,
                feedback.created_at
            ]);

            doc.autoTable({
                head: [headers],
                body: data,
                startY: y
            });

            doc.save("feedback_reports.pdf");
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
            <h1 class="text-3xl mb-10">User Feedback Reports</h1>
            <button onclick="downloadPDF()" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">Download as PDF</button>
            <table class="table-auto w-full text-left">
                <thead>
                    <tr>
                        <th>Report Id</th>
                        <th>User</th>
                        <th>Feedback</th>
                        <th>Created at</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($feedbacks as $feedback): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($feedback['f_id']); ?></td>
                            <td><?php echo htmlspecialchars($feedback['user']); ?></td>
                            <td><?php echo htmlspecialchars($feedback['feedback']); ?></td>
                            <td><?php echo htmlspecialchars($feedback['created_at']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table> 
        </div>
    </main>
</body>
</html>
