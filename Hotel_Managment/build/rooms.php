<?php
session_start();
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null; 
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
           </div>

            <div class="flex flex-row items-center gap-3">
                <div><img src="img/Haile-Hotel-Wolaita-scaled.jpg" class="w-10 h-10 rounded-3xl " alt=""></div>
                <h1 class="text-3xl font-bold dark:text-white">Haile Hotel Wolaita</h1>
            </div> 
            <div>
        </div>
        </section>
    </Header>



      <div class="content-wrapper-rooms">
        <!-- <video autoplay muted loop class="video-background"> <source src="img/Haile-Hotels-Wolaita-Home-Page.mp4" type="video/mp4"> Your browser does not support the video tag. </video> -->
        <h1 class="text-4xl text-center mb-5">Rooms</h1>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-12 lg:pb-10">
            <a href="#" onclick="forward('2', '<?php echo htmlspecialchars($user_id); ?>');"  class="card cursor-pointer hover:bg-cyan-50 flex flex-col sm:max-h-96 items-center border border-slate-100 rounded-xl drop-shadow-2xl bg-lime-100 dark:text-black">
                <img src="img/std.jpg" alt="" class="w-full overflow-hidden rounded-xl">
                <p class="sm:mt-4">Standard Room</p>
            </a>
            <a href="#" onclick="forward('3', '<?php echo htmlspecialchars($user_id); ?>');"  class="card cursor-pointer hover:bg-cyan-50 flex flex-col sm:max-h-96 items-center border border-slate-100 rounded-xl drop-shadow-2xl bg-lime-100 dark:text-black">
                <img src="img/twin.jpg" alt="" class="w-full overflow-hidden rounded-xl">
                <p class="sm:mt-4">Standard Twin Room</p>
            </a>
            <a href="#" onclick="forward('4', '<?php echo htmlspecialchars($user_id); ?>');"  class="card cursor-pointer hover:bg-cyan-50 flex flex-col sm:max-h-96 items-center border border-slate-100 rounded-xl drop-shadow-2xl bg-lime-100 dark:text-black col-span-1 sm:col-span-2 lg:col-span-1">
                <img src="img/room2.jpg" alt="" class="w-full overflow-hidden rounded-xl">
                <p class="sm:mt-4">Semi Junior Suit</p>
            </a>
            <div class="col-span-1 sm:col-span-2 lg:grid lg:grid-cols-rooms lg:gap-4 lg:col-span-3 sm:max-h-96 mx-auto "> <a href="#" onclick="forward('1', '<?php echo htmlspecialchars($user_id); ?>');"  class="card cursor-pointer hover:bg-cyan-50 flex flex-col sm:max-h-96 items-center border border-slate-100 rounded-xl drop-shadow-2xl bg-lime-100 dark:text-black w-full col-span-1 sm:col-span-2 lg:col-span-1"> <img src="img/suit.jpg" alt="" class="w-full overflow-hidden rounded-xl"> <p class="sm:mt-4">Junior Suit</p> </a> 
                <p class="hidden lg:block">
            Enjoy A beautiful Stay at our Rooms!</p>
        </div>
        </div>
        
    
      
    <script>
        function forward(room_id, user_id) {
                window.location.href = 'reservation.php?room_id=' + room_id + '&user_id=' + user_id;
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