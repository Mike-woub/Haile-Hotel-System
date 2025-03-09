<?php
session_start();
require('database/config.php'); // Include your database configuration

// Check for URL parameters
$course = isset($_GET['course']) ? $_GET['course'] : null;
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;

// Fetch menu items from the database based on the parameters
if ($course) {
    if ($course == 'menu') {
        $sql = "SELECT id, name, description, price, image, course FROM menu";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result(); // Get the result set
        $menuItems = []; // Array to hold the menu items

        // Organize menu items by category and course
        while ($row = $result->fetch_assoc()) {
            $menuItems['courses'][$row['course']][] = $row; // Organize by course
        }
    } else {
        $sql = "SELECT id, name, description, price, image, course FROM menu WHERE course = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $course);
        $stmt->execute();
        $result = $stmt->get_result(); // Get the result set
    }
} else {
    echo "No valid parameters provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($course); ?> Foods</title>
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
<body class="dark:text-black dark:bg-slate-600">
<header class="w-full sticky bg-slate-50 dark:bg-slate-700 top-0 z-10">
    <section class="ml-8 mr-8 flex flex-row justify-center items-center p-4">
        <div class="flex flex-row items-center gap-3">
            <div><img src="img/Haile-Hotel-Wolaita-scaled.jpg" class="w-10 h-10 rounded-3xl" alt=""></div>
            <h1 class="text-3xl font-bold dark:text-white">Haile Hotel Wolaita</h1>
        </div>
    </section>
</header>

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

<div class="content-wrapper-rooms">
    <?php if ($course): ?>
        <h1 class="text-4xl text-center mb-5 text-white underline underline-offset-4">
            <?php echo $course == 'menu' ? "Menu" :  $course; ?>
        </h1>
        <?php if ($course == "menu"): ?>
            <div class="content-wrapper-rooms">
                <!-- Display menu items categorized by Course -->
                <?php if (isset($menuItems['courses'])): ?>
                    <?php foreach ($menuItems['courses'] as $course => $items): ?>
                        <h1 class="text-4xl text-center mb-5 text-white underline underline-offset-4">
                            <?php echo ucfirst($course); ?> Menu
                        </h1>
                        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-12 lg:pb-10">
                            <?php foreach ($items as $item): ?>
                                <div class="card flex flex-col sm:max-h-96 items-center border border-slate-100 rounded-xl drop-shadow-2xl bg-lime-100 dark:text-black menu-item">
                                    <img src="<?php echo 'php/' . htmlspecialchars($item["image"]); ?>" alt="<?php echo htmlspecialchars($item["name"]); ?>" class="w-full overflow-hidden rounded-xl">
                                    <p class="sm:mt-4"><?php echo 'Name: ' . htmlspecialchars($item["name"]); ?></p>
                                    <!-- <p class="sm:mt-4"><?php echo 'Description: ' . htmlspecialchars($item["description"]); ?></p> -->
                                    <p class="sm:mt-4">Price: $<span class="item-price"><?php echo htmlspecialchars($item["price"]); ?></span></p>
                                    <div class="flex items-center mt-2">
                                        <button onclick="changeQuantity('<?php echo $item['id']; ?>', -1)" class="bg-red-400 text-white p-1 text-sm rounded-xl">-</button>
                                        <span id="quantity-<?php echo $item['id']; ?>" class="mx-2">1</span>
                                        <button onclick="changeQuantity('<?php echo $item['id']; ?>', 1)" class="bg-green-400 text-white p-1 text-sm rounded-xl">+</button>
                                    </div>
                                    <button onclick="addToCart('<?php echo $item['id']; ?>', '<?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>', <?php echo htmlspecialchars($item['price'], ENT_QUOTES, 'UTF-8'); ?>)" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Add to Cart</button>

                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">No menu items found.</p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-12 lg:pb-10">
                <?php if ($result->num_rows > 0): ?>
                    <?php define('IMAGE_DIR', 'php/'); ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php $imagePath = IMAGE_DIR . htmlspecialchars($row["image"]); ?>
                        <div class="card flex flex-col sm:max-h-96 items-center border border-slate-100 rounded-xl drop-shadow-2xl bg-lime-100 dark:text-black menu-item">
                            <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($row["name"]); ?>" class="w-full h-5/6 overflow-hidden rounded-xl">
                            <p class="sm:mt-4"><?php echo 'Name: ' . htmlspecialchars($row["name"]); ?></p>
                            <!-- <p class="sm:mt-4"><?php echo 'Description: ' . htmlspecialchars($row["description"]); ?></p> -->
                            <p class="sm:mt-4">Price: $<span class="item-price"><?php echo htmlspecialchars($row["price"]); ?></span></p>
                            <div class="flex items-center mt-2">
                                <button onclick="changeQuantity('<?php echo $row['id']; ?>', -1)" class="bg-red-400 text-white p-1 text-sm rounded-xl">-</button>
                                <span id="quantity-<?php echo $row['id']; ?>" class="mx-2">1</span>
                                <button onclick="changeQuantity('<?php echo $row['id']; ?>', 1)" class="bg-green-400 text-white p-1 text-sm rounded-xl">+</button>
                            </div>
                            <button onclick="addToCart(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8'); ?>', <?php echo htmlspecialchars($row["price"], ENT_QUOTES, 'UTF-8'); ?>)" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Add to Cart</button>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-center">No menu items found.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<div class="toast" id="toast">Item added to cart!</div>

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
    console.log(`Current cart items:`, cartItems); // Log current cart items
    console.log(`ID passed to changeCartQuantity: ${id}`); // Log the id passed
    const existingItem = cartItems.find(item => item.id === String(id)); // Convert id to string for comparison
    console.log(existingItem ? existingItem : `${id} not found`); // Log found item or not found message

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