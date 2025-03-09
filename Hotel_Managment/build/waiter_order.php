<?php 
session_start(); 
require('database/config.php'); // Include your database configuration 

// Fetch all menu items from the database
$sql = "SELECT id, name, description, price, image, course FROM menu"; 
$stmt = $conn->prepare($sql); 
$stmt->execute(); 
$result = $stmt->get_result(); 

$menuItems = []; // Array to hold the menu items

// Organize menu items by category and course
while ($row = $result->fetch_assoc()) {
    $menuItems[$row['course']][] = $row; // Organize by category
    // $menuItems['courses'][$row['course']][] = $row; // Organize by course
}

$stmt->close();
?>

<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Central Dashboard</title> 
    <link rel="stylesheet" href="css/style.css"> 
    <link rel="stylesheet" href="css/styles.css"> 
    <style> 
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
            top: 50px; 
            right: 10px; 
            background-color: #fff; 
            color: #000; 
            padding: 10px; 
            border: 1px solid #ccc; 
            border-radius: 5px; 
            max-height: 300px; 
            overflow-y: auto; 
            z-index: 101; 
        } 
        li {
            margin-bottom: 5px;
        }
        #cart-list {
            margin: 0; 
            padding: 0; 
            list-style-position: inside; 
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

<div id="cart-items" class="cart-items hidden"> 
    <h2>Cart Items</h2> 
    <ol id="cart-list"></ol> 
    <div id="order-button" class="border rounded-md text-white hover:bg-cyan-850 bg-slate-600 text-center"></div> 
</div> 

<div class="content-wrapper-rooms"> 
    <!-- Display menu items categorized by Category -->
    <?php foreach ($menuItems as $category => $items): ?>
        <?php if ($category !== 'courses'): // Skip 'courses' key ?>
            <h1 class="text-4xl text-center mb-5 text-white underline underline-offset-4">
                <?php echo ucfirst($category); ?> Foods
            </h1>
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-12 lg:pb-10"> 
                <?php foreach ($items as $item): ?>
                    <div class="card flex flex-col sm:max-h-96 items-center border border-slate-100 rounded-xl drop-shadow-2xl bg-lime-100 dark:text-black menu-item"> 
                        <img src="<?php echo 'php/' . htmlspecialchars($item["image"]); ?>" alt="<?php echo htmlspecialchars($item["name"]); ?>" class="w-full overflow-hidden rounded-xl"> 
                        <p class="sm:mt-4"><?php echo 'Name: ' . htmlspecialchars($item["name"]); ?></p> 
                        <p class="sm:mt-4"><?php echo 'Description: ' . htmlspecialchars($item["description"]); ?></p> 
                        <p class="sm:mt-4"><?php echo 'Price: $' . htmlspecialchars($item["price"]); ?></p> 
                        <button onclick="addToCart(<?php echo $item['id']; ?>, '<?php echo htmlspecialchars($item["name"]); ?>', <?php echo htmlspecialchars($item["price"]); ?>)" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Add to Cart</button> 
                    </div> 
                <?php endforeach; ?>
            </div> 
        <?php endif; ?>
    <?php endforeach; ?>

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
                        <p class="sm:mt-4"><?php echo 'Description: ' . htmlspecialchars($item["description"]); ?></p> 
                        <p class="sm:mt-4"><?php echo 'Price: $' . htmlspecialchars($item["price"]); ?></p> 
                        <button onclick="addToCart(<?php echo $item['id']; ?>, '<?php echo htmlspecialchars($item["name"]); ?>', <?php echo htmlspecialchars($item["price"]); ?>)" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Add to Cart</button> 
                    </div> 
                <?php endforeach; ?>
            </div> 
        <?php endforeach; ?>
    <?php endif; ?>
</div> 

<script>
let cartCount = 0; 
let cartTotal = 0; 
let cartItems = []; 

function addToCart(id, name, price) { 
    const existingItem = cartItems.find(item => item.id === id); 
    if (existingItem) {
        existingItem.quantity += 1; // Increase quantity if item already exists
    } else {
        cartItems.push({ id, name, price, quantity: 1 }); // Add new item with quantity 1
    }
    cartCount++;
    cartTotal += price; 
    document.getElementById('cart-count').innerText = cartCount; 
    document.getElementById('cart-total').innerText = cartTotal.toFixed(2); 
    updateCartList(); 
    updateOrderButton(); 
    alert(`${name} has been added to your cart!`); // Feedback for successful addition
} 

function updateCartList() { 
    const cartList = document.getElementById('cart-list'); 
    cartList.innerHTML = ''; 
    cartItems.forEach(item => { 
        const listItem = document.createElement('li'); 
        listItem.innerHTML = `${item.name} - $${item.price.toFixed(2)} x ${item.quantity} 
        <button onclick="removeFromCart(${item.id})" class="bg-red-400 text-white p-1 text-sm rounded-xl">Remove</button>`; 
        cartList.appendChild(listItem); 
    }); 
}

function removeFromCart(id) { 
    const existingItem = cartItems.find(item => item.id === id);
    if (existingItem) {
        existingItem.quantity -= 1; // Decrease the quantity
        cartCount--;
        cartTotal -= existingItem.price; 
        if (existingItem.quantity <= 0) {
            cartItems = cartItems.filter(item => item.id !== id); // Remove item if quantity is zero
        }
    } 
    document.getElementById('cart-count').innerText = cartCount; 
    document.getElementById('cart-total').innerText = cartTotal.toFixed(2); 
    updateCartList(); 
    updateOrderButton(); 
}

function toggleCart() { 
    const cartItemsDiv = document.getElementById('cart-items'); 
    cartItemsDiv.classList.toggle('hidden'); 
}

function updateOrderButton() {
    const orderButtonDiv = document.getElementById('order-button');
    if (cartCount > 0) {
        orderButtonDiv.innerHTML = `<button onclick="placeOrder()">Order</button>`;
    } else {
        orderButtonDiv.innerHTML = ''; // Clear if no items
    }
}

function placeOrder() {
    let email = '<?php echo isset($user_id) ? $user_id : ''; ?>'; // Replace with actual email retrieval logic

    // Create a comma-separated list of item IDs and quantities
    let itemData = cartItems.map(item => `${item.id}:${item.quantity}`).join(',');

    // Ensure cartTotal is calculated correctly (total amount)
    let amount = cartTotal.toFixed(2); // Format to two decimal places

    // Redirect to the handle_order.php with necessary parameters
    window.location.href = 'waiter_order_handler.php?amount=' + encodeURIComponent(amount) + 
                           '&user_id=' + encodeURIComponent(email) + 
                           '&item_data=' + encodeURIComponent(itemData);
}

// Close the cart when clicking outside
document.addEventListener('click', function(event) {
    const cartDiv = document.querySelector('.cart');
    const cartItemsDiv = document.getElementById('cart-items');

    if (!cartDiv.contains(event.target) && !cartItemsDiv.contains(event.target)) {
        cartItemsDiv.classList.add('hidden');
    }
});
</script> 
</body> 
</html>