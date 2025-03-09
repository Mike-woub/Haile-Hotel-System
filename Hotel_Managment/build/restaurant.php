<!-- <?php
session_start();
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null; 
?> -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/styles.css">
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
<section id="content" class="min-h-svh " style=" background-image: linear-gradient(rgba(4, 9, 30, 0.7), rgba(4, 9, 30, 0.7)), url(img/hw.jpg); background-repeat: no-repeat; background-size: cover; background-position: left;"> 
    <div>
        <h1 class="text-center text-3xl text-white p-4 m-4 underline underline-offset-8 font-serif">Restaurant</h1>

    </div>
    <div class="sidebar hidden dark:text-white md:block bg-slate-700" id="sidebarMenu" aria-expanded="false">
        <div class="flex flex-col mb-auto">
          <!-- <p class="mx-auto font-bold text-lg text-gray-500 my-3"><?php echo "Hello ".htmlspecialchars($_SESSION['user_id']); ?></p> -->
          <a href="#" class="nav-link bg-green-500 text-white font-semibold active text-center align-middle" >
            <span class="text-2xl">&#8962;</span>   Menu
          </a>
          <a href="foods.php?course=breakfast&user_id=<?php echo $user_id; ?>" class="nav-link font-semibold text-center align-middle">Breakfast</a>
          <a href="foods.php?course=vegetarian%20corner&user_id=<?php echo $user_id; ?>" class="nav-link font-semibold text-center align-middle">Vegetarian</a>
          <a href="foods.php?course=desert&user_id=<?php echo $user_id; ?>" class="nav-link font-semibold text-center align-middle">Desert's</a>
          <a href="foods.php?course=kid's%20corner&user_id=<?php echo $user_id; ?>" class="nav-link font-semibold text-center align-middle">Kids Corner</a>
          <a href="foods.php?course=&user_id=<?php echo $user_id; ?>" class="nav-link font-semibold text-center align-middle">Drinks</a>
          <a href="recommendations.php?&user_id=<?php echo $user_id; ?>" class="nav-link font-semibold text-center align-middle">Recipie Recommendation</a>
          <a href="previous_orders.php?user_id=<?php echo $user_id; ?>" class="nav-link font-semibold text-center align-middle">Previous Orders</a>
        </div>
      </div>
    

      <div class="content-wrapper">
  
        
          <div class="grid grid-cols-1 sm:grid-cols-gdashboard md:grid-cols-gdashboard lg:grid-cols-gdashboard  gap-12 gap-y-14 lg:pb-10 ">
            
             
                <a  href="foods.php?course=menu&user_id=<?php echo $user_id; ?>" class="card cursor-pointer hover:bg-cyan-50 flex flex-col  sm:max-h-80 items-center border border-slate-100 rounded-xl drop-shadow-2xl  bg-lime-100 dark:text-black ">

                    <img src="img/f2.jpg" alt="" class="w-full overflow-hidden rounded-xl ">
    
                    <p class="sm:mt-4">Full Menu</p>
                 </a>
                 <p class=" text-pretty text-justify font-serif text-l max-w-xl">Browse our Diverse full Menu</p>   

                 
                <a  href="foods.php?course=ethiopian%20traditional%20food&user_id=<?php echo $user_id; ?>" class="card cursor-pointer hover:bg-cyan-50 flex flex-col  sm:max-h-80 items-center border border-slate-100 rounded-xl drop-shadow-2xl  bg-lime-100 dark:text-black ">

                <img src="img/f1.jpg" alt="" class="w-full overflow-hidden rounded-xl ">

                <p class="sm:mt-4">Traditional Foods</p>

                </a>
                <p class=" text-pretty text-justify font-serif text-l max-w-xl">Browse Ethiopian Foods</p>
        
                <a  href="foods.php?course=snacks%20corner&user_id=<?php echo $user_id; ?>" class="card cursor-pointer hover:bg-cyan-50 flex flex-col  sm:max-h-80 items-center border border-slate-100 rounded-xl drop-shadow-2xl  bg-lime-100 dark:text-black ">

                    <img src="img/f3.webp" alt="" class="w-full overflow-hidden rounded-xl ">
    
                    <p class="sm:mt-4">Fast Food Court</p>
                    
                </a>
                <p class=" text-pretty text-justify font-serif text-l max-w-xl">Browse Fast Foods</p> 
               
              
            <!-- <div class="col">
              <div class="card">
                <button onclick="forward('r_prog');" class="btn card-img-top">
                  <img src="img/beau.jpg" class="w-full h-auto" alt="Research Programs">
                </button>
                <div class="card-body">
                  <h5 class="text-center mt-3">other</h5>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card">
                <button onclick="forward('r_ent');" class="btn card-img-top">
                  <img src="img/food.jpg" class="w-full h-auto" alt="Research Entities">
                </button>
                <div class="card-body">
                  <h5 class="text-center mt-3">other 2</h5>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card">
                <button onclick="forward('emp');" class="btn card-img-top">
                  <img src="../../eiar_photos/p10.avif" class="w-full h-auto" alt="other">
                </button>
                <div class="card-body">
                  <h5 class="text-center mt-3">last</h5>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card">
                <button onclick="forward('users');" class="btn card-img-top">
                  <img src="../../eiar_photos/p30.webp" class="w-full h-auto" alt="other">
                </button>
                <div class="card-body">
                  <h5 class="text-center mt-3">lastets</h5>
                </div>
              </div>
            </div>
          </div> -->
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
        function forward(id) {
            if (id === 'r_center') {
                window.location.href = '../handle_forward.php?id=' + id;
            }
            else if (id === 'r_dir') {
                window.location.href = '../handle_forward.php?id=' + id;
            }
            else if (id === 'r_dep') {
                window.location.href = '../handle_forward.php?id=' + id;
            }
            else if (id === 'r_prog') {
                window.location.href = '../handle_forward.php?id=' + id;
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

    </script>

  
</body>

</html>