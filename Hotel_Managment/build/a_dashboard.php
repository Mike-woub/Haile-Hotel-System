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
    <title>Central Dahboard</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body class="dark:text-white dark:bg-slate-600">
    <Header class="w-full sticky  bg-slate-50 dark:bg-slate-700 top-0 z-10">
        <section class="ml-8 mr-8 flex flex-row justify-between items-center p-4">
           <div>
            <button class=" md:hidden p-2" type="button" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation" onclick="toggleSidebar()">
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
    </Header>

    <div class="sidebar hidden dark:text-white md:block" id="sidebarMenu" aria-expanded="false">
        <div class="flex flex-col mb-auto">
             <!-- Display greeting message -->
             <p class="mx-auto font-bold text-lg text-white my-3">
                    Hello <?php echo $username; ?>
                </p>
          <!-- <p class="mx-auto font-bold text-lg text-gray-500 my-3"><?php echo "Hello ".htmlspecialchars($_SESSION['user_id']); ?></p> -->
          <a href="#" class="nav-link bg-green-500 text-white font-semibold active">
            <span class="text-2xl">&#8962;</span> Home
          </a>
          <a href="profile.php" class="nav-link font-semibold">Profile</a>
          <a href="about.html" class="nav-link font-semibold">About Us</a>
        </div>
      </div>
      

      <div class="content-wrapper">
        
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3  gap-12 lg:pb-10">
            
                <a href="#" onclick="forward('rooms');" class="card cursor-pointer hover:bg-cyan-50 flex flex-col  sm:max-h-80 items-center border border-slate-100 rounded-xl drop-shadow-2xl  bg-lime-100 dark:text-black ">

                    <img src="img/bed.jpg" alt="" class="w-full overflow-hidden rounded-xl ">
    
                    <p class="sm:mt-4">Rooms</p>
                    
                </a>
             
                <a href="#" onclick="forward('restaurant');"  class="card cursor-pointer hover:bg-cyan-50 flex flex-col  sm:max-h-80 items-center border border-slate-100 rounded-xl drop-shadow-2xl  bg-lime-100 dark:text-black ">

                    <img src="img/beauty.jpg" alt="" class="w-full overflow-hidden rounded-xl ">
    
                    <p class="sm:mt-4">Restaurant</p>
                    
                </a>
                <a class="card cursor-pointer hover:bg-cyan-50 flex flex-col  sm:max-h-80 items-center border border-slate-100 rounded-xl drop-shadow-2xl  bg-lime-100 dark:text-black ">

                    <img src="img/inv.jpg" alt="" class="w-full overflow-hidden rounded-xl ">
    
                    <p class="sm:mt-4">Inventory</p>
                    
                </a>
                <a  href="#" onclick="forward('reports');"  class="card cursor-pointer hover:bg-cyan-50 flex flex-col  sm:max-h-80 items-center border border-slate-100 rounded-xl drop-shadow-2xl  bg-lime-100 dark:text-black ">

                    <img src="img/rep.avif" alt="" class="w-full overflow-hidden rounded-xl ">
    
                    <p class="sm:mt-4">Reports</p>
                    
                </a>
                <a href="#" onclick="forward('users');" class="card cursor-pointer hover:bg-cyan-50 flex flex-col  sm:max-h-80 items-center border border-slate-100 rounded-xl drop-shadow-2xl  bg-lime-100 dark:text-black ">

                    <img src="img/system user.jpg" alt="" class="w-full overflow-hidden rounded-xl ">
    
                    <p class="sm:mt-4">System Users</p>
                    
                </a>
                <a class="card cursor-pointer hover:bg-cyan-50 flex flex-col  sm:max-h-80 items-center border border-slate-100 rounded-xl drop-shadow-2xl  bg-lime-100 dark:text-black ">

                    <img src="img/finance.jpg" alt="" class="w-full overflow-hidden rounded-xl ">
    
                    <p class="sm:mt-4">Finance</p>
                </a>
        </div>
      
      
    <script>
        function forward(id) {
            if (id === 'rooms') {
                window.location.href = 'php/handle_forward.php?id=' + id;
            }
            else if (id === 'restaurant') {
                window.location.href = 'menu.php?id=' + id;
            }
            else if (id === 'users') {
                window.location.href = 'php/handle_forward.php?id=' + id;
            }
            else if (id === 'reports') {
                window.location.href = 'reports.php?id=' + id;
            }
            else if (id === 'r_ent') {
                window.location.href = '../handle_forward.php?id=' + id;
            }
            else if (id === 'emp') {
                window.location.href = '../handle_forward.php?id=' + id;
            }
            else if (id === 'users') {
                window.location.href = '../handle_forward.php?id=' + id;
            }
        }
        function confirmLogout() {
            if (confirm("Are you sure you want to log out?")) {
                window.location.href = "../improved/logout.php";
            }
        }
        function toggleSidebar() {
  const sidebar = document.getElementById('sidebarMenu');
  sidebar.classList.toggle('hidden');
}
function confirmLogout() {
            if (confirm("Are you sure you want to log out?")) {
                window.location.href = "logout.php";
            }
        }

    </script>

  
</body>

</html>