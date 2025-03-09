<?php
require('../database/config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/edit.css">
    <title>Edit Research Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            background-color: gainsboro;
        }

        .header {
            background-color: #009136;
            color: white;
            padding: 20px;
            border-bottom: 1px solid #dee2e6;
        }

        .logo {
            width: 225px;
            height: 50px;
            object-fit: contain;
        }

        .header .titlee {
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0;
        }

        .content {
            margin: 30px 0 40px 0;
            max-width: 800px;
            padding: 10px 20px 0 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            background-color: #ffffff;
            box-shadow: 0 0 20px grey;

        }

        table {
            width: 100%;
        }

        table th,
        table td {
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        table th {
            width: 25%;
        }

        .btn-success,
        .btn-secondary {
            width: 100%;
            margin-top: 15px;
        }

        .change input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }

        .change input[type="submit"] {
            width: 100%;
            padding: 10px;
        }

        #error {
            color: red;
            font-size: 0.9rem;
            margin-top: 10px;
        }

        .change {
            display: none;
            opacity:0;
            margin-top: 20px;
        }

        .change2 {
            display: none;
            opacity:0;
            margin-top: 20px;
        }
        <style>
        #toast {
            visibility: hidden;
            min-width: 250px;
            margin-left: -125px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 2px;
            padding: 16px;
            position: fixed;
            z-index: 1;
            left: 50%;
            bottom: 30px;
            font-size: 17px;
        }

        #toast.show {
            visibility: visible;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        @keyframes fadein {
            from { bottom: 0; opacity: 0; }
            to { bottom: 30px; opacity: 1; }
        }

        @keyframes fadeout {
            from { bottom: 30px; opacity: 1; }
            to { bottom: 0; opacity: 0; }
        }
    </style>
    </style>
</head>

<body class="dark:bg-slate-400 ">
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
    <div class="container d-flex justify-content-center">
    <div class="content bg-light">

            <?php if (isset($_GET['id']) && isset($_GET['name'])): ?>
                <?php if ($_GET['name'] == 'rooms'): ?>
                    <h2 class="mb-4 p-3 text-success bg-white rounded text-center">Edit Room Details</h2>
                    <?php
                    echo '<table class="table table-bordered">';
                    echo '<thead><tr><th colspan="2">Room</th><th>Action</th></tr></thead><tbody>';

                    $sql = 'SELECT * FROM rooms WHERE r_id = ' . intval($_GET['id']);
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr><th>Room Id</th><td>' . htmlspecialchars($row["r_id"]) . '</td>';
                            echo '<td><button onclick="edit(' . $row['r_id'] . ', \'r_id\');" class="edit btn btn-secondary">Edit</button></td></tr>';
                            echo '<tr><th>Room Type</th><td>' . htmlspecialchars($row["type_id"]) . '</td>';
                            echo '<td><button onclick="edit(' . $row['r_id'] . ', \'r_type\');" class="edit btn btn-secondary">Edit</button></td></tr>';
                            echo '<tr><th>Total Rooms</th><td>' . htmlspecialchars($row["total_rooms"]) . '</td>';
                            echo '<td><button onclick="edit(' . $row['r_id'] . ', \'t_rooms\');" class="edit btn btn-secondary">Edit</button></td></tr>';
                            echo '<tr><th>Description</th><td>' . htmlspecialchars($row["description"]) . '</td>';
                            echo '<td><button onclick="edit(' . $row['r_id'] . ', \'description\');" class="edit btn btn-secondary">Edit</button></td></tr>';
                            echo '<tr><th>Price</th><td>' . htmlspecialchars($row["price"]) . '</td>';
                            echo '<td><button onclick="edit(' . $row['r_id'] . ', \'price\');" class="edit btn btn-secondary">Edit</button></td></tr>';
                            echo '<tr><th>Capacity</th><td>' . htmlspecialchars($row["capacity"]) . '</td>';
                            echo '<td><button onclick="edit(' . $row['r_id'] . ', \'capacity\');" class="edit btn btn-secondary">Edit</button></td></tr>';
                            echo '<tr><th>Amenities</th><td>' . htmlspecialchars($row["amenities"]) . '</td>';
                            echo '<td><button onclick="edit(' . $row['r_id'] . ', \'amenities\');" class="edit btn btn-secondary">Edit</button></td></tr>';
                        }
                    }
                    echo '</tbody></table>';
                    ?>
                <?php elseif ($_GET['name'] == 'menu'): ?>
                    <h2 class="mb-4 p-3 text-success bg-white rounded text-center">Edit Menu Item Details</h2>
                    <?php
                    echo '<table class="table table-bordered">';
                    echo '<thead><tr><th colspan="2" class="text-center" >Menu Item</th><th>Action</th></tr></thead><tbody>';

                    $sql = 'SELECT * FROM menu WHERE id = ' . intval($_GET['id']);
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr><th>Menu Id</th><td>' . htmlspecialchars($row["id"]) . '</td>';
                            echo '<td><button onclick="edit(' . $row['id'] . ', \'id\');" class="edit btn btn-secondary">Edit</button></td></tr>';
                            echo '<tr><th>Name</th><td>' . htmlspecialchars($row["name"]) . '</td>';
                            echo '<td><button onclick="edit(' . $row['id'] . ', \'name\');" class="edit btn btn-secondary">Edit</button></td></tr>';
                            echo '<tr><th>Description</th><td>' . htmlspecialchars($row["description"]) . '</td>';
                            echo '<td><button onclick="edit(' . $row['id'] . ', \'description\');" class="edit btn btn-secondary">Edit</button></td></tr>';
                            echo '<tr><th>Price</th><td>' . htmlspecialchars($row["price"]) . '</td>';
                            echo '<td><button onclick="edit(' . $row['id'] . ', \'price\');" class="edit btn btn-secondary">Edit</button></td></tr>';
                            echo '<tr><th>Display</th><td><img src="' . $row["image"] . '" alt="' . $row["name"] . '" style="width: 100px; height: auto;"></td>';
                            echo '<td><button onclick="edit(' . $row['id'] . ', \'image\');" class="edit btn btn-secondary">Edit</button></td></tr>';
                            echo '<tr><th>Availability</th><td>' . htmlspecialchars($row["is_available"]) . '</td>';
                            echo '<td><button onclick="edit(' . $row['id'] . ', \'is_available\');" class="edit btn btn-secondary">Edit</button></td></tr>';
                            echo '<tr><th>Course</th><td>' . htmlspecialchars($row["course"]) . '</td>';
                            echo '<td><button onclick="edit(' . $row['id'] . ', \'course\');" class="edit btn btn-secondary">Edit</button></td></tr>';
                        }
                    }
                    echo '</tbody></table>';
                    ?>
                
                <?php elseif ($_GET['name'] == 'users'): ?>
                    <h2 class="mb-4 p-3 text-success bg-white rounded">Edit User Details</h2>
                    <?php
                    echo '<table class="table table-bordered">';
                    echo '<thead><tr><th colspan="2">Users</th><th>Action</th></tr></thead><tbody>';

                    $sql = 'SELECT * FROM users WHERE user_id = ' . intval($_GET['id']);
                    $result = $conn->query($sql);
                    $username = '';
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            echo '<tr><th>User Id</th><td>' . htmlspecialchars($row["user_id"]) . '</td>';
                            echo '<td><button onclick="edit(' . $row['user_id'] . ', \'user_id\');" class="edit btn btn-secondary">Edit</button></td></tr>';

                            echo '<tr><th>Username</th><td>' . htmlspecialchars($row["username"]) . '</td>';
                            echo '<td><button onclick="edit(' . $row['user_id'] . ', \'username\');" class="edit btn btn-secondary">Edit</button></td></tr>';
                            
                            echo '<tr><th>First Name</th><td>' . htmlspecialchars($row["firstname"]) . '</td>';
                            echo '<td><button onclick="edit(' . $row['user_id'] . ', \'firstname\');" class="edit btn btn-secondary">Edit</button></td></tr>';
                            
                            echo '<tr><th>Last Name</th><td>' . htmlspecialchars($row["lastname"]) . '</td>';
                            echo '<td><button onclick="edit(' . $row['user_id'] . ', \'lastname\');" class="edit btn btn-secondary">Edit</button></td></tr>';
                           
                            echo '<tr><th>Status</th><td>' . htmlspecialchars($row["status"]) . '</td>';
                            echo '<td><button onclick="edit(' . $row['user_id'] . ', \'status\');" class="edit btn btn-secondary">Edit</button></td></tr>';

                            echo '<tr><th>User Role</th><td>' . htmlspecialchars($row["role"]) . '</td>';
                            echo '<td><button onclick="edit(' . $row["user_id"] . ', \'role\');" class="edit btn btn-secondary">Edit</button></td></tr>';

                            $username = $row["username"];
                        }
                    }
                    echo '</tbody></table>';
                    ?>
                <?php endif; ?>
            <?php else: ?>
                <p>Please provide valid parameters.</p>
            <?php endif; ?>

            <div class="change my-4">
                <form action="resources/handle_edit.php" method="post" id="change_form" onsubmit="return update();">
                    <div class="mb-3">
                        <label for="inp" id="text" class="form-label">New Value</label>
                        <input type="text" name="inp" id="change" placeholder="new value" class="form-control mb-2">
                    </div>
                    <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>">
                    <input type="hidden" name="name" value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>">

                    <div class="mb-3">
                        <input type="text" name="what" id="type" class="form-control mb-2">
                    </div>
                    <input type="submit" value="Update" class="btn btn-success fw-bold">
                    <p id="error" class="text-danger mt-2"></p>
                </form>
            </div>

            <div class="change2 my-4">
                <form action="resources/handle_edit.php" method="post" style="background-color:blak;">
                    <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>">
                    <input type="hidden" name="change" value="role">
                    <input type="hidden" name="name" value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>">
                    <div class="mb-3">
                        <label for="admin" class="form-label">New Role: </label>
                        <select name="stat" id="stat" class="form-select" >
                            <option value="admin" selected>admin</option>
                            <option value="guest">Guest</option>
                            <option value="h_chef">Head Chef</option>
                            <option value="waiter">Waiter</option>
                            <option value="f_head">Finance Head</option>
                        </select>
                    </div>
                    <input type="submit" value="Change" class="btn btn-success fw-bold">
                </form>
            </div>
            <div class="change3 my-4 hidden">
                <form action="resources/handle_edit.php" method="post">
                    <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>">
                    <input type="hidden" name="change" value="status">
                    <input type="hidden" name="name" value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>">
                    <div class="mb-3">
                        <label for="admin" class="form-label">New Status: </label>
                        <select name="stat" id="stat" class="form-select" >
                            <option value="active" selected>Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <input type="submit" value="Change" class="btn btn-success fw-bold">
                </form>
            </div>
            <div class="change4 my-4 hidden">
                <form action="resources/handle_edit.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>">
                    <input type="hidden" name="change" value="image">
                    <input type="hidden" name="name" value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>">
                    <div class="mb-3">
                        <label for="image" class="form-label">Select Image: </label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
                    </div>
                    <input type="submit" value="Upload" class="btn btn-success fw-bold">
                </form>
            </div>

        </div>
    </div>
    <div id="toast"></div>

    <script>
          function showToast(message) {
        const toast = document.getElementById("toast");
        toast.innerText = message;
        toast.className = "show";
        setTimeout(() => { toast.className = toast.className.replace("show", ""); }, 3000);
    }
        let type = document.getElementById('type');
        type.style.display = "none";
        function edit(id, what) {
    let change = document.querySelector('.change');
    let change2 = document.querySelector('.change2');
    let change3 = document.querySelector('.change3');
    let change4 = document.querySelector('.change4');
    let text = document.getElementById('text');
    let err = document.getElementById('error');
    let type = document.getElementById('type');
    var num = /^[0-9]+$/;

    change2.style.opacity = 0;
    change2.style.display = "none";
    change3.style.opacity = 0;
    change3.style.display = "none";
    change4.style.opacity = 0;
    change4.style.display = "none";
    change.style.display = "block";
    change.style.opacity = 1;

    if (what === 'r_id') {
        change.style.display = "bolck";
        change.style.opacity = 1;
        change3.style.display = "none";
        change3.style.opacity = 0;
        change2.style.display = "none";
        change2.style.opacity = 0;
        change4.style.display = "none";
        change4.style.opacity = 0;
        text.innerHTML = "Change Room ID";
    } else if (what === 'r_type') {
        change.style.display = "bolck";
        change.style.opacity = 1;
        change3.style.display = "none";
        change3.style.opacity = 0;
        change2.style.display = "none";
        change2.style.opacity = 0;
        change4.style.display = "none";
        change4.style.opacity = 0;
        text.innerHTML = "Change Room Type";
    } else if (what === 't_rooms') {
        change.style.display = "bolck";
        change.style.opacity = 1;
        change3.style.display = "none";
        change3.style.opacity = 0;
        change2.style.display = "none";
        change2.style.opacity = 0;
        change4.style.display = "none";
        change4.style.opacity = 0;
        text.innerHTML = "Update Number of Total Rooms";
    } else if (what === 'amenities') {
        change.style.display = "bolck";
        change.style.opacity = 1;
        change3.style.display = "none";
        change3.style.opacity = 0;
        change2.style.display = "none";
        change2.style.opacity = 0;
        change4.style.display = "none";
        change4.style.opacity = 0;
        text.innerHTML = "Update Amenities";
    } else if (what === 'price') {
        change.style.display = "bolck";
        change.style.opacity = 1;
        change3.style.display = "none";
        change3.style.opacity = 0;
        change2.style.display = "none";
        change2.style.opacity = 0;
        change4.style.display = "none";
        change4.style.opacity = 0;
        text.innerHTML = "Change Price";
    } else if (what === 'capacity') {
        change.style.display = "bolck";
        change.style.opacity = 1;
        change3.style.display = "none";
        change3.style.opacity = 0;
        change2.style.display = "none";
        change2.style.opacity = 0;
        change4.style.display = "none";
        change4.style.opacity = 0;
        text.innerHTML = "Change Capacity";
    } else if (what === 'description') {
        change.style.display = "bolck";
        change.style.opacity = 1;
        change3.style.display = "none";
        change3.style.opacity = 0;
        change2.style.display = "none";
        change2.style.opacity = 0;
        change4.style.display = "none";
        change4.style.opacity = 0;
        text.innerHTML = "Change Description";
    }
    else if (what === 'name') {
        change.style.display = "bolck";
        change.style.opacity = 1;
        change3.style.display = "none";
        change3.style.opacity = 0;
        change2.style.display = "none";
        change2.style.opacity = 0;
        change4.style.display = "none";
        change4.style.opacity = 0;
        text.innerHTML = "Change Name";
    }
    else if (what === 'id') {
        change.style.display = "bolck";
        change.style.opacity = 1;
        change3.style.display = "none";
        change3.style.opacity = 0;
        change2.style.display = "none";
        change2.style.opacity = 0;
        change4.style.display = "none";
        change4.style.opacity = 0;
        text.innerHTML = "Change Id";
    }
    else if (what === 'category') {
        change.style.display = "bolck";
        change.style.opacity = 1;
        change3.style.display = "none";
        change3.style.opacity = 0;
        change2.style.display = "none";
        change2.style.opacity = 0;
        change4.style.display = "none";
        change4.style.opacity = 0;
        text.innerHTML = "Change Category";
    }
    else if (what === 'is_available') {
        change.style.display = "bolck";
        change.style.opacity = 1;
        change3.style.display = "none";
        change3.style.opacity = 0;
        change2.style.display = "none";
        change2.style.opacity = 0;
        change4.style.display = "none";
        change4.style.opacity = 0;
        text.innerHTML = "Change Availability";
    }
    else if (what === 'course') {
        change.style.display = "bolck";
        change.style.opacity = 1;
        change3.style.display = "none";
        change3.style.opacity = 0;
        change2.style.display = "none";
        change2.style.opacity = 0;
        change4.style.display = "none";
        change4.style.opacity = 0;
        text.innerHTML = "Change Course";
    }
    else if (what === 'user_id') {
        change.style.display = "bolck";
        change.style.opacity = 1;
        change3.style.display = "none";
        change3.style.opacity = 0;
        change2.style.display = "none";
        change2.style.opacity = 0;
        change4.style.display = "none";
        change4.style.opacity = 0;
        text.innerHTML = "Change UserId";
    }
    else if (what === 'username') {
        change.style.display = "bolck";
        change.style.opacity = 1;
        change3.style.display = "none";
        change3.style.opacity = 0;
        change2.style.display = "none";
        change2.style.opacity = 0;
        change4.style.display = "none";
        change4.style.opacity = 0;
        text.innerHTML = "Change UserName";
    }
    else if (what === 'firstname') {
        change.style.display = "bolck";
        change.style.opacity = 1;
        change3.style.display = "none";
        change3.style.opacity = 0;
        change2.style.display = "none";
        change2.style.opacity = 0;
        change4.style.display = "none";
        change4.style.opacity = 0;
        text.innerHTML = "Change First Name";
    }
    else if (what === 'lastname') {
        change.style.display = "bolck";
        change.style.opacity = 1;
        change3.style.display = "none";
        change3.style.opacity = 0;
        change2.style.display = "none";
        change2.style.opacity = 0;
        change4.style.display = "none";
        change4.style.opacity = 0;
        text.innerHTML = "Change Last Name";
    }
    else if (what === 'role') {
        change.style.display = "none";
        change.style.opacity = 0;
        change3.style.display = "none";
        change3.style.opacity = 0;
        change4.style.display = "none";
        change4.style.opacity = 0;
        change2.style.display = "block";
        change2.style.opacity = 1;
    }
    else if (what === 'status') {
        change.style.display = "none";
        change.style.opacity = 0;
        change3.style.display = "block";
        change3.style.opacity = 1;
        change2.style.display = "none";
        change2.style.opacity = 0;
        change4.style.display = "none";
        change4.style.opacity = 0;
    }
    else if (what === 'image') {
        change.style.display = "none";
        change.style.opacity = 0;
        change3.style.display = "none";
        change3.style.opacity = 0;
        change2.style.display = "none";
        change2.style.opacity = 0;
        change4.style.display = "block";
        change4.style.opacity = 1;
    }
}

function update() {
    let text = document.getElementById('text');
    let change = document.getElementById('change');
    let err = document.getElementById('error');
    let type = document.getElementById('type');
    var num = /^[0-9]+$/;

    if (text.innerHTML === "Change Room ID") {
        if (change.value.length === 0 || !num.test(change.value)) {
            err.innerHTML = "please input a valid id";
            return false;
        } else {
            type.value = "r_id";
            return true;
        }
    } else if (text.innerHTML === "Change UserId") {
        if (change.value.length === 0 || !num.test(change.value)) {
            err.innerHTML = "please input a valid id";
            return false;
        } else {
            type.value = "user_id";
            return true;
        }
    }  
    
    if (text.innerHTML === "Change Id") {
        if (change.value.length === 0 || !num.test(change.value)) {
            err.innerHTML = "please input a valid id";
            return false;
        } else {
            type.value = "id";
            return true;
        }
    }
    
    else if (text.innerHTML === "Change Name") {
        if (change.value.length === 0) {
            err.innerHTML = "please input a valid name";
            return false;
        } else {
            type.value = "name";
            return true;
        }
    }
    else if (text.innerHTML === "Change UserName") {
        if (change.value.length === 0) {
            err.innerHTML = "please input a valid Username";
            return false;
        } else {
            type.value = "username";
            return true;
        }
    }
    
    else if (text.innerHTML === "Change First Name") {
        if (change.value.length === 0) {
            err.innerHTML = "please input a valid First name";
            return false;
        } else {
            type.value = "firstname";
            return true;
        }
    }
    
    else if (text.innerHTML === "Change Last Name") {
        if (change.value.length === 0) {
            err.innerHTML = "please input a valid Last name";
            return false;
        } else {
            type.value = "lastname";
            return true;
        }
    }
    else if (text.innerHTML === "Change Status") {
        if (change.value.length === 0) {
            err.innerHTML = "please input a valid name";
            return false;
        } else {
            type.value = "status";
            return true;
        }
    }
    
    else if (text.innerHTML === "Change Room Type") {
        if (change.value.length === 0) {
            if (confirm("Do you want the room type to be empty?")) {
                type.value = "type_id";
                return true;
            } else {
                alert("Fill in the room_type then");
                return false;
            }
        } else if (!num.test(change.value)) {
            err.innerHTML = "please input a valid value";
            return false;
        } else {
            type.value = "type_id"; 
            return true;
        }
    } else if (text.innerHTML === "Update Number of Total Rooms") {
        if (change.value.length === 0 || !num.test(change.value)) {
            err.innerHTML = "please input a valid value";
            return false;
        } else {
            type.value = "total_rooms";
            return true;
        }
    } else if (text.innerHTML === "Change Description") {
        if (change.value.length === 0) {
            if (confirm("Do you want the Description to be empty?")) {
                type.value = "description";
                return true;
            } else {
                alert("Fill in the Description then");
                return false;
            }
        }
        type.value = "description";
        return true;
    } else if (text.innerHTML === "Change Course") {
        if (change.value.length === 0) {
            if (confirm("Do you want the Course type to be empty?")) {
                type.value = "course";
                return true;
            } else {
                alert("Fill in the course then");
                return false;
            }
        }
        type.value = "course";
        return true;
    }else if (text.innerHTML === "Change Price") {
        if (change.value.length === 0 || !num.test(change.value)) {
            err.innerHTML = "please input a valid value";
            return false;
        } else {
            type.value = "price";
            return true;
        }
    }else if (text.innerHTML === "Change Availability") {
        if (change.value.length === 0 || !num.test(change.value)) {
            err.innerHTML = "please input a valid value";
            return false;
        } else {
            type.value = "is_available";
            return true;
        }
    }  
    
    else if (text.innerHTML === "Change Capacity") {
        if (change.value.length === 0 || !num.test(change.value)) {
            err.innerHTML = "please input a valid value";
            return false;
        } else {
            type.value = "capacity";
            return true;
        }
    } else if (text.innerHTML === "Update Amenities") {
        if (change.value.length === 0) {
            if (confirm("Do you want the Amenities to be empty?")) {
                type.value = "amenities";
                return true;
            } else {
                alert("Fill in the Amenities then");
                return false;
            }
        }
        type.value = "amenities";
        return true;
    }
    else if (text.innerHTML === "Change Category") {
        if (change.value.length === 0) {
            if (confirm("Do you want the Category to be empty?")) {
                type.value = "category";
                return true;
            } else {
                alert("Fill in the category then");
                return false;
            }
        }
        type.value = "category";
        return true;
    }
}

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></scrip>

</body>

</html>