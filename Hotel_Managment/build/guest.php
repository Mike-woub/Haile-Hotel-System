<?php
session_start();
require('database/config.php'); // Ensure you include your database connection

$username = "Guest"; // Default username

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch username from the database
    $stmt = $conn->prepare("SELECT username FROM users WHERE email = ?"); // Assuming user_id is the email
    $stmt->bind_param('s', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = htmlspecialchars($row['username']);
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body class="dark:text-white dark:bg-slate-600">
    <header class="w-full sticky bg-slate-50 dark:bg-slate-700 top-0 z-10">
        <section class="ml-8 mr-8 flex flex-row justify-between items-center p-4">
            <div>
                <button class="md:hidden p-2" type="button" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation" onclick="toggleSidebar()">
                    &#9776;
                </button>
            </div>

            <div class="flex flex-row items-center gap-3">
                <div><img src="img/Haile-Hotel-Wolaita-scaled.jpg" class="w-10 h-10 rounded-3xl " alt=""></div>
                <h1 class="text-3xl font-bold dark:text-white">Haile Hotel Wolaita</h1>
            </div>
            <div>
                <button id="logout" class="text-xl cursor-pointer inline-block" onclick="confirmLogout()">
                    Logout
                </button>
            </div>
        </section>
    </header>

    <section id="content" class="min-h-svh" style="background-image: linear-gradient(rgba(4, 9, 30, 0.7), rgba(4, 9, 30, 0.7)), url(img/hw.jpg); background-repeat: no-repeat; background-size: cover; background-position: left;"> 
        <div class="sidebar hidden dark:text-white md:block bg-slate-700" id="sidebarMenu" aria-expanded="false">
            <div class="flex flex-col mb-auto">
                <!-- Display greeting message -->
                <p class="mx-auto font-bold text-lg text-white my-3">
                    Hello <?php echo $username; ?>
                </p>
                <a href="index.php" class="nav-link bg-green-500 text-white font-semibold active">
                    <span class="text-2xl">&#8962;</span> Home
                </a>
                <a href="reservations.php?user_id=<?php echo htmlspecialchars($user_id); ?>" class="nav-link bg-green-500 text-white font-semibold active">
                     Reservations
                </a>
                <a href="profile.php?user_id=<?php echo htmlspecialchars($user_id); ?>"  class="nav-link font-semibold">Profile</a>
                <a href="../../about_us.html" class="nav-link font-semibold">About Us</a>
                <a href="../../contact_us.html" class="nav-link font-semibold">Contact Us</a>
            </div>
        </div>

        <div class="content-wrapper">
            <div class="grid grid-cols-1 sm:grid-cols-gdashboard md:grid-cols-gdashboard lg:grid-cols-gdashboard gap-12 gap-y-14 lg:pb-10">
                <a href="rooms.php?user_id=<?php echo htmlspecialchars($user_id); ?>" class="card cursor-pointer hover:bg-cyan-50 flex flex-col sm:max-h-80 items-center border border-slate-100 rounded-xl drop-shadow-2xl bg-lime-100 dark:text-black">
                    <img src="img/bed.jpg" alt="" class="w-full overflow-hidden rounded-xl">
                    <p class="sm:mt-4">Rooms</p>
                </a>
                <p class="text-pretty text-justify font-serif text-l max-w-xl">Browse our Available Rooms, Reserve Online</p>
                
                <a href="restaurant.php?user_id=<?php echo htmlspecialchars($user_id); ?>" class="card cursor-pointer hover:bg-cyan-50 flex flex-col sm:max-h-80 items-center border border-slate-100 rounded-xl drop-shadow-2xl bg-lime-100 dark:text-black">
                    <img src="img/beauty.jpg" alt="" class="w-full overflow-hidden rounded-xl">
                    <p class="sm:mt-4">Restaurant</p>
                </a>
                <p class="text-pretty text-justify font-serif text-l max-w-xl">Browse Our Diverse Menu, Order Online , and Access Our Recipie Reccomendation Engine</p>   

                <a  href="feedback.php?user_id=<?php echo htmlspecialchars($user_id); ?>" class="card cursor-pointer hover:bg-cyan-50 flex flex-col sm:max-h-80 items-center border border-slate-100 rounded-xl drop-shadow-2xl bg-lime-100 dark:text-black">
                    <img src="img/rep.avif" alt="" class="w-full overflow-hidden rounded-xl">
                    <p class="sm:mt-4">Provide Feedback</p>
                </a>
                <p class="text-pretty text-justify font-serif text-l max-w-xl">Provide us with your Feedbacks and Help the Hotel Improve</p> 
            </div>
        </div>
    </section>

    <footer class="bg-slate-700 text-white text-xl" id="footer">
        <section class="max-w-4xl mx-auto p-4 flex flex-col sm:flex-row sm:justify-between">
            <address>
                <h2>Haile Hotel and Resorts.</h2>
                Wolaita Sodo<br>
                Around Ajip, 12345-5555<br>
                Email: <a>HaileHotel@gmail.com</a><br>
                Phone: <a href="tel:+1555555555">(555) 555-5555</a>
            </address>
            <nav class="hidden md:flex flex-col gap-2" aria-label="footer">
                <a href="#rockets" class="hover:opacity-90">Home</a>
                <a href="#testimonials" class="hover:opacity-90">About</a>
                <a href="#Contact" class="hover:opacity-90">Contact Us</a>
            </nav>
            <div class="flex flex-col sm:gap-2">
                <p class="text-right">Copyright &copy; <span id="year">2024</span></p>
                <p class="text-right">All Rights Reserved</p>
            </div>
        </section>
    </footer>

    <script>
        function confirmLogout() {
            if (confirm("Are you sure you want to log out?")) {
                window.location.href = "logout.php";
            }
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebarMenu');
            sidebar.classList.toggle('hidden');
        }
    </script>

</body>

</html>