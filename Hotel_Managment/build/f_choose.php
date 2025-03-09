<?php
//session_start();
//$user_id = $_GET["user_id"];
?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Central Dahboard</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/styles.css">
    <style> .video-background {
         position: fixed; 
         top: 0; left: 0; 
         width: 100%;
         height: 100%; 
         object-fit: cover;
         z-index: -1; } 
    .content {
         position:relative; 
         z-index: 1; } </style>
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
               
                <button id="logout" class="text-xl cursor-pointer inline-block">
                    Logout
                </button>
        </div>
        </section>
    </Header>



      <div class="content-wrapper-rooms">
        <!-- <video autoplay muted loop class="video-background"> <source src="img/Haile-Hotels-Wolaita-Home-Page.mp4" type="video/mp4"> Your browser does not support the video tag. </video> -->
        <h1 class="text-4xl text-center mb-5">Choose Transactions</h1>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-12 lg:pb-10">
            <a href="#" onclick="forward('rooms');"  class="card cursor-pointer hover:bg-cyan-50 flex flex-col sm:max-h-96 items-center border border-slate-100 rounded-xl drop-shadow-2xl bg-lime-100 dark:text-black">
                <img src="img/std.jpg" alt="" class="w-full overflow-hidden rounded-xl">
                <p class="sm:mt-4">Room Reservations</p>
            </a>
            <a href="#" onclick="forward('food_orders');"  class="card cursor-pointer hover:bg-cyan-50 flex flex-col sm:max-h-96 items-center border border-slate-100 rounded-xl drop-shadow-2xl bg-lime-100 dark:text-black">
                <img src="img/f3.jpg" alt="" class="w-full overflow-hidden rounded-xl">
                <p class="sm:mt-4">Food Orders</p>
            </a>
            <a href="#" onclick="forward('all');"  class="card cursor-pointer hover:bg-cyan-50 flex flex-col sm:max-h-96 items-center border border-slate-100 rounded-xl drop-shadow-2xl bg-lime-100 dark:text-black col-span-1 sm:col-span-2 lg:col-span-1">
                <img src="img/fi.jpg" alt="" class="w-full overflow-hidden rounded-xl">
                <p class="sm:mt-4">All Transactions History</p>
            </a>
        </div>
        
    
      
    <script>
        function forward(order_id) {
                window.location.href = 'f_show.php?order_id=' + order_id;
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

    </script>

  
</body>

</html>