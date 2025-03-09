<?php
require('../database/config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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

        .form-container {
            margin: 40px 0;
            max-width: 600px;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            background-color: #ffffff;
            box-shadow: 0 0 20px grey;
        }

        .form-container .form-label {
            font-weight: bold;
            flex: 0 0 30%;
            max-width: 30%;
        }

        .form-container .form-control {
            flex: 1;
        }

        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 17px;
        }

        .form-container .btn-success {
            width: 100%;
        }
    </style>
</head>

<body class="dark:bg-slate-400">
    <header class="w-full sticky bg-slate-50 dark:bg-slate-700 top-0 z-10">
        <section class="ml-8 mr-8 flex flex-row justify-between items-center p-4">
            <div></div>
            <div class="flex flex-row items-center gap-3">
                <div><img src="../img/Haile-Hotel-Wolaita-scaled.jpg" class="w-10 h-10 rounded-3xl" alt=""></div>
                <h1 class="text-3xl font-bold dark:text-white">Haile Hotel Wolaita</h1>
            </div>
            <div></div>
        </section>
    </header>

    <div class="container d-flex justify-content-center">
        <div class="form-container bg-light">
            <form action="resources/handle_add.php" method="post" id="add_form" onsubmit="return add();" enctype="multipart/form-data">
                <?php if (isset($_GET['name'])): ?>
                    <input type="hidden" name="what" value="<?php echo htmlspecialchars($_GET['name']); ?>">
                    <?php if ($_GET['name'] == 'rooms'): ?>
                        <h2 class="text-center rounded p-3 text-success bg-white">Add a New Room</h2>

                        <div class="form-group">
                            <label for="type_id" class="form-label">Input Type: </label>
                            <input type="text" name="type_id" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="t_rooms" class="form-label">Input Number of Total Rooms: </label>
                            <input type="text" name="t_rooms" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="price" class="form-label">Input Price: </label>
                            <input type="text" name="price" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="description" class="form-label">Input Description: </label>
                            <input type="text" name="description" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="capacity" class="form-label">Input Capacity: </label>
                            <input type="text" name="capacity" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="amenities" class="form-label">Input Amenities: </label>
                            <input type="text" name="amenities" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success fw-semibold fs-5">Add</button>

                    <?php elseif ($_GET['name'] == 'menu'): ?>

                        <h2 class="text-center rounded p-3 text-success bg-white">Add a New Menu Item</h2>

                        <div class="form-group">
                            <label for="name" class="form-label">Input Name: </label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="description" class="form-label">Input Description: </label>
                            <input type="text" name="description" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="price" class="form-label">Input Price: </label>
                            <input type="text" name="price" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="image" class="form-label">Upload Image: </label>
                            <input type="file" name="image" class="form-control" accept="image/*" required>
                        </div>
                        <div class="form-group">
                            <label for="category" class="form-label">Input Category: </label>
                            <input type="text" name="category" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="availability" class="form-label">Input Availability: </label>
                            <select name="availability" class="form-control" required>
                                <option value="1">Available</option>
                                <option value="0">Not Available</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="course" class="form-label">Course: </label>
                            <input type="text" name="course" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success fw-semibold fs-5">Add</button>

                    <?php elseif ($_GET['name'] == 'users'): ?>

                        <h2 class="text-center rounded p-3 text-success bg-white">Add a New User</h2>

                        <div class="form-group">
                            <label for="first_name" class="form-label">First Name: </label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="form-label">Last Name: </label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Input Email: </label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="username" class="form-label">Input Username: </label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Input Password: </label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="role" class="form-label">Select Role: </label>
                            <select name="role" class="form-control" required>
                                <option value="h_chef">Head Chef</option>
                                <option value="guest">Guest</option>
                                <option value="admin">Admin</option>
                                <option value="waiter">Waiter</option>
                                <option value="f_head">Finance Head</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status" class="form-label">Input Status: </label>
                            <select name="status" class="form-control" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success fw-semibold fs-5">Add User</button>
                    <?php endif; ?>
                <?php endif; ?>
            </form>

            <script>
                function add() {
                    var name = document.forms['add_form']['name'];

                    if (name && name.value.length === 0) {
                        name.placeholder = "Name cannot be empty";
                        alert("Name cannot be empty");
                        name.classList.add('validate');
                        return false;
                    } else {
                        return true;
                    }
                }
            </script>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

        </div>
    </div>
</body>

</html>