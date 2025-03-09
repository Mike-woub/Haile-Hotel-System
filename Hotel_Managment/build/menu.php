<?php 
session_start(); 
require('database/config.php'); // Include your database configuration 

// Fetch all menu items from the database
$sql = "SELECT id, name, description, price, image, order_count, course FROM menu"; 
$stmt = $conn->prepare($sql); 
$stmt->execute(); 
$result = $stmt->get_result(); 

$menuItems = []; // Array to hold the menu items

// Organize menu items by category and course
while ($row = $result->fetch_assoc()) {
    $menuItems['courses'][$row['course']][] = $row; // Organize by course
}

$stmt->close();
?>

<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Menu</title> 
    <link rel="stylesheet" href="css/style.css"> 
    <link rel="stylesheet" href="css/styles.css"> 
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
                        <p class="sm:mt-4"><?php echo 'Description: ' . htmlspecialchars($item["description"]); ?></p> 
                        <p class="sm:mt-4"><?php echo 'Price: $' . htmlspecialchars($item["price"]); ?></p> 
                    </div> 
                <?php endforeach; ?>
            </div> 
        <?php endforeach; ?>
    <?php endif; ?>
</div> 

<script>
    // Your existing JavaScript code can be removed or retained as needed
    // ...
</script> 
</body> 
</html>