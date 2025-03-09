<?php
require('../database/config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Haile Hotel Wolaita</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
    
        table{
            margin:auto;
        }
        table,tr,th{
            padding: 20px;
            border:1px solid white;
        }
        tr{
            font-size:12px;
        }
        td{
            border:1px solid black;
            text-align:center;

    
        }
        th{
            background-color:black;
            color:white;
        }
        .header {
            background-color: #009136;
            color: white;
            padding: 20px;
        }

        .logo {
            width: 225px;
            height: 50px;
            object-fit: contain;
        }

        .header .titlee {
            font-size: 1.5rem;
            margin: 0;
        }

        .table-container {
            margin-top: 20px;
        }

        /* .btn-edit,
        .btn-delete {
            margin-right: 5px;
        } */



 
.table tr:hover {
    background-color: #f1f1f1;
}

    </style> 
</head>

<body class="dark:bg-slate-800 dark:text-black">
<Header class="w-full sticky  bg-slate-50 dark:bg-slate-700 top-0 z-10">
        <section class="ml-8 mr-8 flex flex-row justify-between items-center p-4">
           <div>
           </div>

            <div class="flex flex-row items-center gap-3">
                <div><img src="../img/Haile-Hotel-Wolaita-scaled.jpg" class="w-10 h-10 rounded-3xl " alt=""></div>
                <h1 class="text-3xl font-bold dark:text-white">Haile Hotel Wolaita</h1>
            </div> 
            <div>
        </div>
        </section>
    </Header>
    

    <?php if (isset($_GET['id']) && $_GET['id'] == 'rooms'): ?>
        <div class="container mx-auto p-4"> 
            <h1 class="text-center text-3xl p-2 dark:text-white">Rooms</h1>
            <table class="bg-slate-400">

                <thead>

                    <tr class="text-sm">
                        <th>ID</th>
                        <th>Type</th>
                        <th>Total Rooms</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Capacity</th>
                        <th>Amenities</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM rooms";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row["r_id"] . '</td>';
                            echo '<td>' . $row["type_id"] . '</td>';
                            echo '<td>' . $row["total_rooms"] . '</td>';
                            echo '<td>' . $row["status"] . '</td>';
                            echo '<td>' . $row["description"] . '</td>';
                            echo '<td>' . $row["price"] . '</td>';
                            echo '<td>' . $row["capacity"] . '</td>';
                            echo '<td>' . $row["amenities"] . '</td>';
                            echo '<td class="text-xs">' . $row["created_at"] . '</td>';
                            echo '<td class="text-xs">' . $row["updated_at"] . '</td>';
                            echo '<td> 
                                    <button onclick="edit(' . $row['r_id'] . ' , \'rooms\' );" class="bg-yellow-600 hover:bg-yellow-500 text-white font-bold rounded p-2 mt-4 mb-2">Edit</button>       
                                    <button onclick="del(' . $row['r_id'] . ' , \'rooms\' );" class="bg-red-500 hover:bg-red-600 text-white font-bold rounded p-2 mb-4">Delete</button>
                                </td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="14" class="text-center">No results found</td></tr>';
                    }
                    $conn->close();

                    ?>
                    <tr>
                        <td colspan="14" class="text-center">
                            <button onclick="add('rooms');" class="text-lg bg-green-900 text-white hover:opacity-90 text-center p-3 rounded-xl mt-3 mb-3">Add a New Room</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php elseif (isset($_GET['id']) && $_GET['id'] == 'menu'): ?>
       
        <div class="container mx-auto p-4">
            <h1 class="text-center text-3xl p-2 dark:text-white">Todays Menu</h1>
            <table class="bg-slate-400">
                <thead>
                    <tr class="text-sm">
                        <th>Id</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Display</th>
                        <th>Order Count</th>
                        <th>Course</th>
                        <th>Availability</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM menu";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row["id"] . '</td>';
                            echo '<td>' . $row["name"] . '</td>';
                            echo '<td>' . $row["description"] . '</td>';
                            echo '<td>' . $row["price"] . '</td>';
                            echo '<td><img src="' . $row["image"] . '" alt="' . $row["name"] . '" style="width: 100px; height: auto;"></td>';
                            echo '<td>' . $row["order_count"] . '</td>';
                            echo '<td>' . $row["course"] . '</td>';
                            echo '<td>' . $row["created_at"] . '</td>';
                            echo '<td>' . $row["updated_at"] . '</td>';
                            echo '<td> 
                            <button onclick="edit(' . $row['id'] . ' , \'menu\' );" class="bg-yellow-600 hover:bg-yellow-500 text-white font-bold rounded p-2 mt-4 mb-2">Edit</button>       
                            <button onclick="del(' . $row['id'] . ' , \'menu\' );" class="bg-red-500 hover:bg-red-600 text-white font-bold rounded p-2 mb-4">Delete</button>
                        </td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="11" class="text-center">No results found</td></tr>';
                    }

                    $conn->close();

                    ?>
                    <tr>
                        <td colspan="11" class="text-center">
                            <button onclick="add('menu');" class="text-lg bg-green-900 text-white hover:opacity-90 text-center p-3 rounded-xl mt-3 mb-3">Add a New Menu Item</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    <?php elseif (isset($_GET['id']) && $_GET['id'] == 'users'): ?>
        <div class="container mx-auto p-4"> 
            <h1 class="text-center text-3xl p-2 dark:text-white">Rooms</h1>
            <table class="bg-slate-400">
                <thead class="table-dark">
                <tr class="text-sm">
                        <th>User Id</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Role</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM users";
                    $result = $conn->query($sql);
                    $username = '';
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $username = $row["username"];
                            echo '<tr>';
                            echo '<td>' . $row["user_id"] . '</td>';
                            echo '<td>' . $row["username"] . '</td>';
                            echo '<td>' . $row["email"] . '</td>';
                            echo '<td>' . $row["firstname"] . '</td>';
                            echo '<td>' . $row["lastname"] . '</td>';
                            echo '<td>' . $row["role"] . '</td>';
                            echo '<td>' . $row["created_at"] . '</td>';
                            echo '<td>' . $row["updated_at"] . '</td>';
                            echo '<td>' . $row["status"] . '</td>';
                            echo '<td> 
                                <button onclick="edit(' . $row['user_id'] . ' , \'users\' );" class="bg-yellow-600 hover:bg-yellow-500 text-white font-bold rounded p-2 mt-4 mb-2">Edit</button>       
                            <button onclick="del(' . $row['user_id'] . ' , \'users\' );" class="bg-red-500 hover:bg-red-600 text-white font-bold rounded p-2 mb-4">Delete</button>
                        </td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="10" class="text-center">No results found</td></tr>';
                    }
                    $conn->close();

                    ?>

                    <tr>
                    <td colspan="10" class="text-center">
                            <button onclick="add('users');" class="text-lg bg-green-900 text-white hover:opacity-90 text-center p-3 rounded-xl mt-3 mb-3">Add a New System User</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    <?php endif; ?>
    <script>
        function edit(id, name) {
            window.location.href = 'edit.php?id=' + id + '&name=' + encodeURIComponent(name);
        }

        function del(id, name) {
            window.location.href = 'delete.php?id=' + id + '&name=' + encodeURIComponent(name);
        }

        function delu(id, name) {
            window.location.href = 'delete.php?id=' + encodeURIComponent(id) + '&name=' + encodeURIComponent(name);
        }

        function add(name) {
            window.location.href = 'add.php?name=' + encodeURIComponent(name);
        }

        function password(username) {
            window.location.href = 'c_password.php?username=' + encodeURIComponent(username);
        }
    </script>

</body>

</html>