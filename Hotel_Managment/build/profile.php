<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('database/config.php');

$email = $_GET['user_id'] ?? '';
$user_id = $_SESSION['user_id'];

// Fetch user info from the database
if (isset($_GET['user_id'])) {
    $userStmt = $conn->prepare("SELECT email, username, firstname, lastname FROM users WHERE email = ?");
    $userStmt->bind_param("s", $email);
    $userStmt->execute();
    $userResult = $userStmt->get_result();
    $userInfo = $userResult->fetch_assoc();
    $userStmt->close();
} elseif (isset($_SESSION['user_id'])) {
    $userStmt = $conn->prepare("SELECT email, username, firstname, lastname FROM users WHERE email = ?");
    $userStmt->bind_param("s", $user_id);
    $userStmt->execute();
    $userResult = $userStmt->get_result();
    $userInfo = $userResult->fetch_assoc();
    $userStmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body class="dark:bg-slate-600">
    <header class="w-full sticky bg-slate-50 dark:bg-slate-700 top-0 z-10">
        <section class="ml-8 mr-8 flex flex-row justify-center items-center p-4">
            <div class="flex flex-row items-center gap-3">
                <div><img src="img/Haile-Hotel-Wolaita-scaled.jpg" class="w-10 h-10 rounded-3xl" alt=""></div>
                <h1 class="text-3xl font-bold dark:text-white">Haile Hotel Wolaita</h1>
            </div>
        </section>
    </header>
    <main>
        <div class="container">
            <h1>User Profile</h1>
            <?php if ($userInfo): ?>
                <table>
                    <tr>
                        <th>Email</th>
                        <td><?php echo htmlspecialchars($userInfo['email']); ?></td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td>
                            <form action="update_user.php" method="post">
                                <input type="hidden" name="email" value="<?php echo htmlspecialchars($userInfo['email']); ?>">
                                <input type="text" name="username" value="<?php echo htmlspecialchars($userInfo['username']); ?>" required>
                                <input type="submit" value="Update" class="text-cyan-500 border border-green-700 rounded-xl p-2 hover:text-cyan-400 cursor-pointer">
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <th>Password</th>
                        <td>
                            <form action="update_user.php" method="post">
                                <input type="hidden" name="email" value="<?php echo htmlspecialchars($userInfo['email']); ?>">
                                <input type="password" name="password" placeholder="New Password" required>
                                <input type="submit" value="Change Password" class="text-cyan-500 border border-green-700 rounded-xl p-2 hover:text-cyan-400 cursor-pointer">
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <th>First Name</th>
                        <td><?php echo htmlspecialchars($userInfo['firstname']); ?></td>
                    </tr>
                    <tr>
                        <th>Last Name</th>
                        <td><?php echo htmlspecialchars($userInfo['lastname']); ?></td>
                    </tr>
                </table>
            <?php else: ?>
                <p>No user information found.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>