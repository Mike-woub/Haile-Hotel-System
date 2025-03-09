<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/style.css">
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
    <main class="mt-6">
        <h2 class="text-3xl font-semibold text-center mb-4 underline underline-offset-4">Room Details</h2>
        
        <div class="p-12 min-h-screen">
            <div class="col-span-1 sm:col-span-2 lg:grid lg:grid-cols-reservation lg:gap-8 sm:max-h-96 mx-auto"> 
                <div class="min-h-96">
                    <div class="card cursor-pointer hover:bg-cyan-50 flex flex-col sm:max-h-96 items-center border border-slate-100 rounded-xl drop-shadow-2xl bg-lime-100 dark:text-black w-full col-span-1 sm:col-span-2 lg:col-span-1"> 
                        <?php if (isset($_GET['room_id'])): ?>
                            <?php if ($_GET['room_id'] == '1'): ?>
                                <img src="img/suit.jpg" alt="" class="w-full overflow-hidden rounded-xl"> 
                                <p class="sm:mt-4">Junior Suit</p>
                            <?php elseif ($_GET['room_id'] == '2'): ?>
                                <img src="img/std.jpg" alt="" class="w-full overflow-hidden rounded-xl"> 
                                <p class="sm:mt-4">Standard Room</p>
                            <?php elseif ($_GET['room_id'] == '3'): ?>
                                <img src="img/twin.jpg" alt="" class="w-full overflow-hidden rounded-xl"> 
                                <p class="sm:mt-4">Twin Room</p>
                            <?php elseif ($_GET['room_id'] == '4'): ?>
                                <img src="img/room2.jpg" alt="" class="w-full overflow-hidden rounded-xl"> 
                                <p class="sm:mt-4">Semi Junior Suit</p>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="p-2 font-sans font-thin">
                    <?php if (isset($_GET['room_id'])): ?>
                        <?php if ($_GET['room_id'] == '1'): ?>
                           <table>
                                <caption>Details</caption>
                                <tr>
                                    <th>Room Type</th>
                                    <th>Price</th>
                                    <th>Number Of People</th>
                                    <th>Amenities</th>
                                    <th>Description</th>
                                </tr>
                                <tr>
                                    <td>Junior-Suit</td>
                                    <td>3200</td>
                                    <td>2</td>
                                    <td>Wifi, Mountain View</td>
                                    <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Odit impedit libero animi cum? Necessitatibus error nesciunt possimus quo quis sapiente soluta ea ducimus porro mollitia. Consequuntur ducimus laudantium iste modi!</td>
                                </tr>
                           </table>
                        <?php elseif ($_GET['room_id'] == '4'): ?>
                            <table>
                                <caption>Details</caption>
                                <tr>
                                    <th>Room Type</th>
                                    <th>Price</th>
                                    <th>Number Of People</th>
                                    <th>Amenities</th>
                                    <th>Description</th>
                                </tr>
                                <tr>
                                    <td>Semi-Suit</td>
                                    <td>2600</td>
                                    <td>2</td>
                                    <td>Wifi, Mountain View</td>
                                    <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Odit impedit libero animi cum? Necessitatibus error nesciunt possimus quo quis sapiente soluta ea ducimus porro mollitia. Consequuntur ducimus laudantium iste modi!</td>
                                </tr>
                           </table>
                        <?php elseif ($_GET['room_id'] == '2'): ?>
                            <table>
                                <caption>Details</caption>
                                <tr>
                                    <th>Room Type</th>
                                    <th>Price</th>
                                    <th>Number Of People</th>
                                    <th>Amenities</th>
                                    <th>Description</th>
                                </tr>
                                <tr>
                                    <td>Standard</td>
                                    <td>2200</td>
                                    <td>2</td>
                                    <td>Wifi, Mountain View</td>
                                    <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Odit impedit libero animi cum? Necessitatibus error nesciunt possimus quo quis sapiente soluta ea ducimus porro mollitia. Consequuntur ducimus laudantium iste modi!</td>
                                </tr>
                           </table>
                        <?php elseif ($_GET['room_id'] == '3'): ?>
                            <table>
                                <caption>Details</caption>
                                <tr>
                                    <th>Room Type</th>
                                    <th>Price</th>
                                    <th>Number Of People</th>
                                    <th>Amenities</th>
                                    <th>Description</th>
                                </tr>
                                <tr>
                                    <td>Twin-Room</td>
                                    <td>2700</td>
                                    <td>2</td>
                                    <td>Wifi, Mountain View</td>
                                    <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Odit impedit libero animi cum? Necessitatibus error nesciunt possimus quo quis sapiente soluta ea ducimus porro mollitia. Consequuntur ducimus laudantium iste modi!</td>
                                </tr>
                           </table>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            <h2 class="text-3xl font-semibold mt-12 text-center underline underline-offset-4">Make a Reservation</h2>
            <div class="mt-4 max-w-4xl mx-auto">
                <form action="php/resources/handle_reservation.php?room_id=<?php echo urlencode($_GET['room_id']); ?>" method="post" class="bg-white p-6 rounded-lg shadow-md text-black pb-16 mx-auto">
                    <input type="hidden" name="room_id" value="<?php echo htmlspecialchars($_GET['room_id']); ?>"> <!-- Hidden field to store room ID -->
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_GET['user_id']); ?>"> <!-- Hidden field to store user ID -->
                    <div class="mb-4">
                        <label for="checkin" class="block text-sm font-medium text-gray-700">Check-in Date</label>
                        <input type="date" id="checkin" name="checkin" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div class="mb-4">
                        <label for="checkout" class="block text-sm font-medium text-gray-700">Check-out Date</label>
                        <input type="date" id="checkout" name="checkout" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600" name="reserve">Reserve Now</button>
                </form>
            </div>
        </div>
    </main>
    <footer class="bg-slate-700 text-white text-xl" id="footer">
        <section class="max-w-4xl mx-auto p-4 flex flex-col sm:flex-row sm:justify-between">
            <address>
                <h2>Haile Hotel and Resorts.</h2>
                Wolaita Sodo<br>
                Around Ajip, 12345-5555<br>
                Email: <a href="mailto:HaileHotel@gmail.com">HaileHotel@gmail.com</a><br>
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
        document.addEventListener('DOMContentLoaded', function() {
            var today = new Date().toISOString().split('T')[0];
            var checkin = document.getElementById('checkin');
            var checkout = document.getElementById('checkout');

            checkin.setAttribute('min', today);

            checkin.addEventListener('change', function() {
                var checkinDate = new Date(checkin.value);
                checkinDate.setDate(checkinDate.getDate() + 1);
                var minCheckoutDate = checkinDate.toISOString().split('T')[0];
                checkout.setAttribute('min', minCheckoutDate);
            });

            // Form validation before submission
            document.querySelector('form').addEventListener('submit', function(event) {
                if (!checkin.value || !checkout.value) {
                    event.preventDefault(); // Prevent submission
                    alert("Please fill in both check-in and check-out dates."); // Alert the user
                } else if (new Date(checkout.value) < new Date(checkin.value)) {
                    event.preventDefault(); // Prevent submission
                    alert("Check-out date must be after check-in date."); // Alert the user
                }
            });
        });
    </script>
</body>
</html> take the image displaying logic from here