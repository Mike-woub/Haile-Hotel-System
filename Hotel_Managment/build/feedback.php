<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database configuration if needed
// include('database/config.php'); // Uncomment if you need database connection

$email = $_GET['user_id'] ?? '';
$_SESSION['user_id']=$email;

if (empty($email)) {
    die("User is not logged in.");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $feedback = $_POST['feedback'] ?? '';

    // Here you would typically save the feedback to the database
    // $stmt = $conn->prepare("INSERT INTO feedback (email, feedback) VALUES (?, ?)");
    // $stmt->bind_param("ss", $email, $feedback);
    // $stmt->execute();
    // $stmt->close();
    
    echo "<script>alert('Thank you for your feedback!');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provide Feedback</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        textarea {
            width: 100%;
            height: 150px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            resize: none;
            color:black;
        }
        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #218838;
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
    <h1 class="text-4xl text-center mb-5 mt-6">Provide Feedback</h1>

        <div class="container">
            <h1>Provide Feedback</h1>
            <form method="post" action="feedback_handler.php">
                <textarea name="feedback" placeholder="Your feedback here..." required></textarea>
                <button type="submit">Submit Feedback</button>
            </form>
        </div>
    </main>
</body>
</html>