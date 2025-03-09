<?php
require('../database/config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Delete Research Center</title>
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
            text-align: center;
            flex-grow: 1;
        }

        .content {
            margin-top: 40px;
            max-width: 600px;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            background-color: #ffffff;
            text-align: center;
            box-shadow: 0 0 20px grey;
        }

        table {
            width: 100%;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        table th {
            width: 30%;
        }

        .btn-danger {
            width: 100%;
        }

        @media (max-width: 768px) {
            .header .titlee {
                font-size: 1.2rem;
            }

            table th,
            table td {
                display: block;
                text-align: right;
            }

            table th::after {
                content: ":";
                margin-left: 5px;
            }

            .btn-danger {
                width: 100%;
            }
        }
    </style>
</head>

<body class="dark:bg-slate-400 dark:text-white">
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
                    <h2 class="mb-4 text-success bg-white rounded p-3">Room Details</h2>
                    <table class="table table-bordered">
                        <tr>
                            <th colspan="2">Room</th>
                        </tr>
                        <tr>
                            <?php
                            $sql = 'SELECT * FROM rooms WHERE r_id =' . $_GET['id'];
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo  '<tr> <th>Id</th> <td>' . $row["r_id"] . '</td></tr>';

                                    echo  '<tr> <th>Type</th> <td>' . $row["type_id"] . '</td></tr>';

                                    echo  '<tr> <th>Total Rooms</th> <td>' . $row["total_rooms"] . '</td></tr>';

                                    echo  '<tr> <th>Rooms</th> <td>' . $row["status"] . '</td></tr>';

                                    echo  '<tr> <th>Ocuppier</th> <td>' . $row["occupied_by"] . '</td></tr>';

                                    echo  '<tr> <th>Desccription</th> <td>' . $row["description"] . '</td> </tr>';
                                    echo  '<tr> <th>Price</th> <td>' . $row["price"] . '</td> </tr>';
                                    echo  '<tr> <th>Capacity</th> <td>' . $row["capacity"] . '</td> </tr>';
                                    echo  '<tr> <th>Amenities</th> <td>' . $row["amenities"] . '</td> </tr>';
                                    echo '<tr><td colspan="2" style="text-align:center;"> <button onclick="del();" class="delete btn btn-danger fw-semibold fs-5">Delete</button> </td> </tr>';
                                }
                            }
                            ?>
                <?php elseif ($_GET['name'] == 'menu'): ?>
                    <h2 class="mb-4 text-success bg-white rounded p-3">Menu Item Details</h2>
                    <table class="table table-bordered">
                        <tr>
                            <th colspan="2">Menu Item</th>
                        </tr>
                        <tr>
                            <?php
                            $sql = 'SELECT * FROM menu WHERE id =' . $_GET['id'];
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo  '<tr> <th>Id</th> <td>' . $row["id"] . '</td></tr>';

                                    echo  '<tr> <th>Name</th> <td>' . $row["name"] . '</td></tr>';

                                    echo  '<tr> <th>Description</th> <td>' . $row["description"] . '</td></tr>';

                                    echo  '<tr> <th>Price</th> <td>' . $row["price"] . '</td></tr>';

                                    echo  '<tr> <th>Display</th> <td><img src="' . $row["image"] . '" alt="' . $row["name"] . '" style="width: 100px; height: auto;"></td></tr>';

                                    echo  '<tr> <th>Category</th> <td>' . $row["category"] . '</td> </tr>';
                                    echo  '<tr> <th>Availability</th> <td>' . $row["is_available"] . '</td> </tr>';
                                    echo  '<tr> <th>Course</th> <td>' . $row["course"] . '</td> </tr>';
                                    echo  '<tr> <th>Created at</th> <td>' . $row["created_at"] . '</td> </tr>';
                                    echo  '<tr> <th>Updated at</th> <td>' . $row["updated_at"] . '</td> </tr>';
                                    echo '<tr><td colspan="2" style="text-align:center;"> <button onclick="del();" class="delete btn btn-danger fw-semibold fs-5">Delete</button> </td> </tr>';
                                }
                            }
                            ?>
                        </tr>
                <?php elseif ($_GET['name'] == 'users'): ?>
                    <h2 class="mb-4 text-success bg-white rounded p-3">User Details</h2>
                    <table class="table table-bordered">
                        <tr>
                            <th colspan="2">User</th>
                        </tr>
                        <tr>
                            <?php
                            $sql = 'SELECT * FROM users WHERE user_id =' . $_GET['id'];
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo  '<tr> <th>Id</th> <td>' . $row["user_id"] . '</td></tr>';

                                    echo  '<tr> <th>Email</th> <td>' . $row["email"] . '</td></tr>';

                                    echo  '<tr> <th>First Name</th> <td>' . $row["firstname"] . '</td></tr>';

                                    echo  '<tr> <th>Last Name</th> <td>' . $row["lastname"] . '</td></tr>';

                                    echo  '<tr> <th>Role</th> <td>' . $row["role"] . '</td></tr>';

                                    echo  '<tr> <th>Created at</th> <td>' . $row["created_at"] . '</td> </tr>';

                                    echo  '<tr> <th>Updated at</th> <td>' . $row["updated_at"] . '</td> </tr>';

                                    echo  '<tr> <th>Status</th> <td>' . $row["status"] . '</td></tr>'; 

                                    echo '<tr><td colspan="2" style="text-align:center;"> <button onclick="del();" class="delete btn btn-danger fw-semibold fs-5">Delete</button> </td> </tr>';
                                }
                            }
                            ?>
                        </tr>
                    </table>
            
                <?php endif; ?>
            <?php endif; ?>

            <div class="change">
                <form action="resources/handle_delete.php" method="post" id="del_form">
                    <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>">
                    <input type="hidden" name="name" value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>">
                    <input type="hidden" name="un" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
                </form>
            </div>
        </div>
        <script>
            function del() {
                if (confirm("Are you sure you want to delete this Record, you can not undo this")) {
                    let form = document.getElementById('del_form');
                    form.submit();
                } else {
                    return false;
                }
            }
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </div>
</body>

</html>