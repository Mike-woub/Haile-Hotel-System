<?php
session_start();

// Get email from the query parameter
$email = isset($_GET['user_id']) ? $_GET['user_id'] : null;

// Database connection details
$servername = "localhost"; // or your server name
$username = "root"; // your database username
$password = ""; // your database password
$dbname = "haile"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement to fetch user ID based on email
if ($email) {
    $stmt = $conn->prepare("SELECT user_id, preferences FROM users WHERE email = ?");
    $stmt->bind_param("s", $email); // 's' specifies the variable type => 'string'

    // Execute the statement
    $stmt->execute();

    // Bind the result
    $stmt->bind_result($user_id, $preferences);

    // Fetch the result
    if ($stmt->fetch()) {
        // Check if preferences exist
        if (!empty($preferences)) {
            // User ID fetched successfully, now define the API endpoint and parameters
            $num_recommendations = 3; // Number of recommendations
            $url = "http://bbb0-104-254-89-53.ngrok-free.app/recommend?user_id=$user_id&num_recommendations=$num_recommendations";

            // Make the API request using file_get_contents
            $response = @file_get_contents($url); // Suppress warnings with @

            // Check if the request was successful
            if ($response === false) {
                echo "Failed to fetch recommendations.";
                $recommendations = [];
            } else {
                $recommendations = json_decode($response, true);
               // echo $recommendations;
            }
        } else {
            // No preferences found, show the form to input preferences
            $showForm = true;
        }
    } else {
        // Handle case where user not found
        echo "User not found.";
        exit;
    }

    // Close statement
    $stmt->close();
} else {
    echo "No email provided.";
    exit;
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Recommendations</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }
        .content {
            position: relative;
            z-index: 1;
        }
        .menu-item {
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .menu-item:hover {
            background-color: rgba(200, 240, 255, 0.5);
        }
        .cart {
            position: fixed;
            top: 0px;
            z-index: 100;
            right: 10px;
            background-color: #333;
            color: white;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
        }
        .hidden {
            display: none;
        }
        .cart-items {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.9);
            color: #000;
            padding: 20px;
            z-index: 101;
            display: none; /* Initially hidden */
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            overflow-y: auto;
        }
        li {
            margin-bottom: 5px;
        }
        #cart-list {
            margin: 0;
            padding: 0;
            list-style-position: inside;
        }
        .close-cart {
            cursor: pointer;
            color: red;
            float: right;
            font-size: 24px;
        }
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #333;
            color: white;
            padding: 10px;
            border-radius: 5px;
            display: none;
            z-index: 1000;
        }
    </style>
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
            <div><img src="img/Haile-Hotel-Wolaita-scaled.jpg" class="w-10 h-10 rounded-3xl" alt=""></div>
            <h1 class="text-3xl font-bold dark:text-white">Haile Hotel Wolaita</h1>
        </div>
        <div>
            <button id="logout" class="text-xl cursor-pointer inline-block" onclick="confirmLogout()">
                Logout
            </button>
        </div>
    </section>
</header>

<section id="content" class="min-h-screen" style="background-image: linear-gradient(rgba(4, 9, 30, 0.7), rgba(4, 9, 30, 0.7)), url(img/hw.jpg); background-repeat: no-repeat; background-size: cover; background-position: left;">
    <div>
        <h1 class="text-center text-3xl text-white p-4 m-4 underline underline-offset-8 font-serif">Recipe Recommendations</h1>
    </div>

    <div class="cart" onclick="toggleCart()">
        <p>Cart: <span id="cart-count">0</span> items</p>
        <p>Total: $<span id="cart-total">0.00</span></p>
    </div>

    <div id="cart-items" class="cart-items">
        <span class="close-cart" onclick="closeCart(event)">✖</span>
        <h2>Cart Items</h2>
        <ol id="cart-list"></ol>
        <div id="order-button" class="border rounded-md text-white hover:bg-cyan-850 bg-slate-600 text-center"></div>
    </div>

    <div class="content-wrapper text-black">
        <?php if (isset($showForm) && $showForm): ?>
            <div class="preferences-form">
                <h2 class="text-white">Please enter your preferences:</h2>
                <form method="POST" action="insert_preferences.php">
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
                    <textarea name="preferences" rows="4" placeholder="Enter your preferences here..."></textarea>
                    <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Submit Preferences</button>
                </form>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 gap-y-14 lg:pb-10">
                <?php if (!empty($recommendations)): ?>
                    <?php foreach ($recommendations as $recipe): ?>
                        <?php
                        include('database/config.php');

                        $sql = "SELECT name, description, image, price FROM menu WHERE name = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("s", $recipe);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $dish = $result->fetch_assoc();
                        ?>
                        <?php if ($dish): ?>
                            <div class="card cursor-pointer hover:bg-cyan-50 flex flex-col sm:max-h-80 items-center border border-slate-100 rounded-xl drop-shadow-2xl bg-lime-100 dark:text-black">
                                <img src="<?php echo htmlspecialchars($dish['image']); ?>" alt="<?php echo htmlspecialchars($dish['name']); ?>" class="w-full overflow-hidden rounded-xl">
                                <p class="sm:mt-4 text-center font-bold"><?php echo htmlspecialchars($dish['name']); ?></p>
                                <p class="text-sm text-gray-600"><?php echo htmlspecialchars($dish['description']); ?></p>
                                <p class="text-lg font-bold">$<?php echo htmlspecialchars($dish['price']); ?></p>
                                <div class="flex items-center mt-2">
                                    <button onclick="changeQuantity('<?php echo $dish['id']; ?>', -1)" class="bg-red-400 text-white p-1 text-sm rounded-xl">-</button>
                                    <span id="quantity-<?php echo $dish['id']; ?>" class="mx-2">1</span>
                                    <button onclick="changeQuantity('<?php echo $dish['id']; ?>', 1)" class="bg-green-400 text-white p-1 text-sm rounded-xl">+</button>
                                </div>
                                <button onclick="addToCart('<?php echo $dish['id']; ?>', '<?php echo htmlspecialchars($dish['name'], ENT_QUOTES, 'UTF-8'); ?>', <?php echo htmlspecialchars($dish['price'], ENT_QUOTES, 'UTF-8'); ?>)" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Add to Cart</button>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-white">No recommendations found.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

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

<div class="toast" id="toast">dish added to cart!</div>

<script>
let user_id = '<?php echo $user_id; ?>'; // Replace with actual user ID logic
let cartCount = 0;
let cartTotal = 0;
let cartItems = [];

function showToast(message) {
    const toast = document.getElementById('toast');
    toast.innerText = message;
    toast.style.display = 'block';
    setTimeout(() => {
        toast.style.display = 'none';
    }, 3000);
}

function changeQuantity(id, change) {
    const quantityElement = document.getElementById(`quantity-${id}`);
    let currentQuantity = parseInt(quantityElement.innerText);

    // Update quantity based on change
    currentQuantity += change;

    // Ensure quantity doesn't go below 1
    if (currentQuantity < 1) {
        currentQuantity = 1;
    }

    // Update the display
    quantityElement.innerText = currentQuantity;
}

function addToCart(id, name, price) {
    const quantityElement = document.getElementById(`quantity-${id}`);
    const quantity = parseInt(quantityElement.innerText);

    // Ensure ID is a string
    id = String(id);

    const existingItem = cartItems.find(item => item.id === id); // Compare IDs as strings
    if (existingItem) {
        existingItem.quantity += quantity; // Update quantity if already in cart
        showToast("Item quantity updated in cart.");
    } else {
        cartItems.push({ id, name, price, quantity }); // Add new item with quantity
        cartCount += quantity; // Update cart count
        cartTotal += price * quantity; // Update total
        showToast("Item added to cart.");
    }
    
    updateCartDisplay();
}

function updateCartDisplay() {
    document.getElementById('cart-count').innerText = cartCount;
    document.getElementById('cart-total').innerText = cartTotal.toFixed(2);
    updateCartList();
    updateOrderButton();
}

function updateCartList() {
    const cartList = document.getElementById('cart-list');
    cartList.innerHTML = '';
    cartItems.forEach(item => {
        const listItem = document.createElement('li');
        listItem.innerHTML = `${item.name} - $${item.price.toFixed(2)} x ${item.quantity}
        <button onclick="changeCartQuantity(parseInt(${item.id}), -1)" class="bg-red-400 text-white p-1 text-sm rounded-xl">-</button>
        <button onclick="changeCartQuantity(parseInt(${item.id}), 1)" class="bg-green-400 text-white p-1 text-sm rounded-xl">+</button>
        <button onclick="removeFromCart(${item.id})" class="bg-yellow-400 text-white p-1 text-sm rounded-xl">Remove</button>`;
        cartList.appendChild(listItem);
    });
}

function changeCartQuantity(id, change) {
    const existingItem = cartItems.find(item => item.id === String(id)); // Convert id to string for comparison

    if (existingItem) {
        existingItem.quantity += change;

        if (existingItem.quantity < 1) {
            cartItems = cartItems.filter(item => item.id !== String(id)); // Ensure id is a string when filtering
            showToast("Item removed from cart.");
        } else {
            showToast("Item quantity updated.");
        }

        // Update cart count and total
        cartCount += change; 
        cartTotal += change * existingItem.price; // Update total
    }
    updateCartDisplay();
}

function removeFromCart(id) {
    const existingItem = cartItems.find(item => item.id === String(id)); // Convert id to string for comparison
    if (existingItem) {
        cartCount -= existingItem.quantity; // Update cart count
        cartTotal -= existingItem.price * existingItem.quantity; // Update total
        cartItems = cartItems.filter(item => item.id !== String(id)); // Ensure id is a string when filtering
        showToast("Item removed from cart.");
        updateCartDisplay();
    } else {
        console.error(`Item with id ${id} not found in cart.`); // Debugging log for not found items
    }
}

function closeCart(event) {
    event.stopPropagation();
    const cartItemsDiv = document.getElementById('cart-items');
    cartItemsDiv.style.display = 'none'; // Hide the cart
}

function toggleCart() {
    const cartItemsDiv = document.getElementById('cart-items');
    if (cartItemsDiv.style.display === 'none' || cartItemsDiv.style.display === '') {
        cartItemsDiv.style.display = 'flex'; // Show the cart
        updateCartDisplay(); // Update display when showing the cart
    } else {
        cartItemsDiv.style.display = 'none'; // Hide the cart
    }
}

function updateOrderButton() {
    const orderButtonDiv = document.getElementById('order-button');
    if (cartCount > 0) {
        orderButtonDiv.innerHTML = `<button onclick="placeOrder()">Order</button>`;
    } else {
        orderButtonDiv.innerHTML = '';
    }
}

function placeOrder() {
    let order_type = 'order';
    let email = user_id;

    let itemData = cartItems.map(item => `${item.id}:${item.quantity}`).join(',');

    let amount = cartTotal.toFixed(2);

    window.location.href = 'php/resources/handle_order.php?amount=' + encodeURIComponent(amount) + 
                           '&user_id=' + encodeURIComponent(email) + 
                           '&order_type=' + encodeURIComponent(order_type) + 
                           '&item_data=' + encodeURIComponent(itemData);
}
</script>
</body>
</html>