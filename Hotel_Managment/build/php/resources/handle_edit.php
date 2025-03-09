<?php
include('../../database/config.php');

$value = $_POST['inp'] ?? null;
$type = $_POST['what'] ?? null;
$name = $_POST['name'] ?? null;
$change = $_POST['change'] ?? null;
$id = (int) ($_POST['id'] ?? 0);

function executeUpdate($conn, $table, $column, $value, $id, $id_column)
{
    $sql = "UPDATE $table SET $column = ? WHERE $id_column = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "<script>alert('Prepare failed: " . addslashes($conn->error) . "');</script>";
        return false;
    }

    if (is_numeric($value)) {
        $stmt->bind_param("ii", $value, $id);
    } else {
        $stmt->bind_param("si", $value, $id);
    }

    if (!$stmt->execute()) {
        echo "<script>alert('Execute failed: " . addslashes($stmt->error) . "');</script>";
        return false;
    }

    $stmt->close();
    return true;
}

function checkIdExists($conn, $table, $column, $value)
{
    $stmt = $conn->prepare("SELECT * FROM $table WHERE $column = ?");
    $stmt->bind_param("i", $value);
    $stmt->execute();
    return $stmt->get_result()->num_rows > 0;
}

function checkUnExists($conn, $table, $column, $value)
{
    $stmt = $conn->prepare("SELECT * FROM $table WHERE $column = ?");
    $stmt->bind_param("s", $value);
    $stmt->execute();
    return $stmt->get_result()->num_rows > 0;
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    if ($value === null || $type === null || $name === null || $id <= 0) {
        echo "<script>alert('Invalid input.');</script>";
        exit;
    }
}

function checkTypeExists($conn, $type_id)
{
    return checkIdExists($conn, 'room_types', 'type_id', $type_id);
}

if ($name == 'rooms') {
    if ($type == 'id') {
        if (checkIdExists($conn, 'rooms', 'r_id', (int)$value)) {
            echo "<script>alert('Id already exists for another record');</script>";
        } else {
            if (executeUpdate($conn, 'rooms', 'r_id', (int)$value, $id, 'r_id')) {
                echo "<script>alert('Updated successfully'); window.location.href='../handle_forward.php?id=$name';</script>";
            } else {
                echo "<script>alert('Update failed: " . addslashes($conn->error) . "');</script>";
            }
        }
    } elseif ($type == 'type_id') {
        if ($value != NULL) {
            if (checkTypeExists($conn, $value)) {
                if (executeUpdate($conn, 'rooms', 'type_id', (int)$value, $id, 'r_id')) {
                    echo "<script>alert('Room Type updated successfully'); window.location.href='../handle_forward.php?id=$name';</script>";
                } else {
                    echo "<script>alert('Update failed: " . addslashes($conn->error) . "');</script>";
                }
            } else {
                echo "<script>alert('Room Type does not exist.');</script>";
            }
        } else {
            if (executeUpdate($conn, 'rooms', 'type_id', $value, $id, 'r_id')) {
                echo "<script>alert('type_id is set to NULL'); window.location.href='../handle_forward.php?id=$name';</script>";
            } else {
                echo "<script>alert('Update failed: " . addslashes($conn->error) . "');</script>";
            }
        }
    } elseif ($type == 'total_rooms') {
        if (executeUpdate($conn, 'rooms', 'total_rooms', (int)$value, $id, 'r_id')) {
            echo "<script>alert('Total number of Rooms is updated'); window.location.href='../handle_forward.php?id=$name';</script>";
        } else {
            echo "<script>alert('Update failed: " . addslashes($conn->error) . "');</script>";
        }
    } elseif ($type == 'description') {
        if (executeUpdate($conn, 'rooms', 'description', $value, $id, 'r_id')) {
            echo "<script>alert('Room Description updated successfully'); window.location.href='../handle_forward.php?id=$name';</script>";
        } else {
            echo "<script>alert('Update failed: " . addslashes($conn->error) . "');</script>";
        }
    } elseif ($type == 'price') {
        if (executeUpdate($conn, 'rooms', 'price', (int)$value, $id, 'r_id')) {
            echo "<script>alert('Price of the Room updated successfully'); window.location.href='../handle_forward.php?id=$name';</script>";
        } else {
            echo "<script>alert('Update failed: " . addslashes($conn->error) . "');</script>";
        }
    } elseif ($type == 'capacity') {
        if (executeUpdate($conn, 'rooms', 'capacity', (int)$value, $id, 'r_id')) {
            echo "<script>alert('Capacity of the Room updated successfully'); window.location.href='../handle_forward.php?id=$name';</script>";
        } else {
            echo "<script>alert('Update failed: " . addslashes($conn->error) . "');</script>";
        }
    } elseif ($type == 'amenities') {
        if (executeUpdate($conn, 'rooms', 'amenities', $value, $id, 'r_id')) {
            echo "<script>alert('Amenities updated successfully'); window.location.href='../handle_forward.php?id=$name';</script>";
        } else {
            echo "<script>alert('Update failed: " . addslashes($conn->error) . "');</script>";
        }
    }

} elseif ($name == 'menu') {
    if ($type == 'id') {
        if (checkIdExists($conn, 'menu', 'id', (int)$value)) {
            echo "<script>alert('Id already exists for another record');</script>";
        } else {
            if (executeUpdate($conn, 'menu', 'id', (int)$value, $id, 'id')) {
                echo "<script>alert('Updated successfully'); window.location.href='../handle_forward.php?id=$name';</script>";
            } else {
                echo "<script>alert('Update failed: " . addslashes($conn->error) . "');</script>";
            }
        }
    } elseif ($type == 'name') {
        if ($value != NULL) {
            if (executeUpdate($conn, 'menu', 'name', $value, $id, 'id')) {
                echo "<script>alert('Menu item name updated successfully'); window.location.href='../handle_forward.php?id=$name';</script>";
            } else {
                echo "<script>alert('Update failed: " . addslashes($conn->error) . "');</script>";
            }
        } else {
            echo "<script>alert('Update failed: Invalid name');</script>";
        }
    } elseif ($type == 'description') {
        if (executeUpdate($conn, 'menu', 'description', $value, $id, 'id')) {
            echo "<script>alert('Menu item Description updated successfully'); window.location.href='../handle_forward.php?id=$name';</script>";
        } else {
            echo "<script>alert('Update failed: " . addslashes($conn->error) . "');</script>";
        }
    } elseif ($type == 'price') {
        if (executeUpdate($conn, 'menu', 'price', (int)$value, $id, 'id')) {
            echo "<script>alert('Price of the Menu item updated successfully'); window.location.href='../handle_forward.php?id=$name';</script>";
        } else {
            echo "<script>alert('Update failed: " . addslashes($conn->error) . "');</script>";
        }
    } elseif ($type == 'category') {
        if (executeUpdate($conn, 'menu', 'category', $value, $id, 'id')) {
            echo "<script>alert('Category of the menu item updated successfully'); window.location.href='../handle_forward.php?id=$name';</script>";
        } else {
            echo "<script>alert('Update failed: " . addslashes($conn->error) . "');</script>";
        }
    } elseif ($type == 'is_available') {
        if (executeUpdate($conn, 'menu', 'is_available', (int)$value, $id, 'id')) {
            echo "<script>alert('Availability of the Menu Item updated successfully'); window.location.href='../handle_forward.php?id=$name';</script>";
        } else {
            echo "<script>alert('Update failed: " . addslashes($conn->error) . "');</script>";
        }
    } elseif ($type == 'course') {
        if (executeUpdate($conn, 'menu', 'course', $value, $id, 'id')) {
            echo "<script>alert('Course of the Menu Item updated successfully'); window.location.href='../handle_forward.php?id=$name';</script>";
        } else {
            echo "<script>alert('Update failed: " . addslashes($conn->error) . "');</script>";
        }
    }

} elseif ($name == 'users') {
    if ($type == 'user_id') {
        if ($value != NULL) {
            if (checkIdExists($conn, 'users', 'user_id', (int)$value)) {
                echo "<script>alert('Id already exists for another record');</script>";
            } else {
                if (checkManagerExists($conn, (int)$value)) {
                    if (executeUpdate($conn, 'users', 'user_id', (int)$value, $id, 'user_id')) {
                        echo "<script>alert('User\'s id updated successfully'); window.location.href='../handle_forward.php?id=$name';</script>";
                    } else {
                        echo "<script>alert('Update failed: " . addslashes($conn->error) . "');</script>";
                    }
                } else {
                    echo "<script>alert('An employee with that Id does not exist.');</script>";
                }
            }
        } else {
            if (executeUpdate($conn, 'users', 'user_id', NULL, $id, 'user_id')) {
                echo "<script>alert('User\'s id is set to NULL'); window.location.href='../handle_forward.php?id=$name';</script>";
            } else {
                echo "<script>alert('Update failed: " . addslashes($conn->error) . "');</script>";
            }
        }
    } elseif ($type == 'username') {
        if (checkUnExists($conn, 'users', 'username', $value)) {
            echo "<script>alert('Username already exists for another record');</script>";
        } else {
            if (executeUpdate($conn, 'users', 'username', $value, $id, 'user_id')) {
                echo "<script>alert('Username updated successfully'); window.location.href='../handle_forward.php?id=$name';</script>";
            } else {
                echo "<script>alert('Update failed: " . addslashes($conn->error) . "');</script>";
            }
        }
    } elseif ($type == 'firstname') {
        if (executeUpdate($conn, 'users', 'firstname', $value, $id, 'user_id')) {
            echo "<script>alert('Firstname updated successfully'); window.location.href='../handle_forward.php?id=$name';</script>";
        } else {
            echo "<script>alert('Update failed: " . addslashes($conn->error) . "');</script>";
        }
    } elseif ($type == 'lastname') {
        if (executeUpdate($conn, 'users', 'lastname', $value, $id, 'user_id')) {
            echo "<script>alert('Lastname updated successfully'); window.location.href='../handle_forward.php?id=$name';</script>";
        } else {
            echo "<script>alert('Update failed: " . addslashes($conn->error) . "');</script>";
        }
    } elseif ($change == 'role') {
        if (executeUpdate($conn, 'users', 'role', $value, $id, 'user_id')) {
            echo "<script>alert('Role updated successfully'); window.location.href='../handle_forward.php?id=$name';</script>";
        } else {
            echo "<script>alert('Update failed: " . addslashes($conn->error) . "');</script>";
        }
    } elseif ($change == 'status') {
        if (executeUpdate($conn, 'users', 'status', $value, $id, 'user_id')) {
            echo "<script>alert('Status updated successfully'); window.location.href='../handle_forward.php?id=$name';</script>";
        } else {
            echo "<script>alert('Update failed: " . addslashes($conn->error) . "');</script>";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0; // Get the user ID
    $change = isset($_POST['change']) ? $_POST['change'] : ''; // Get the change type

    if ($change == 'status') {
        $value = isset($_POST['stat']) ? $_POST['stat'] : ''; // Get the selected status value
        
        if (executeUpdate($conn, 'users', 'status', $value, $id, 'user_id')) {
            echo "<script>alert('Status updated successfully'); window.location.href='../handle_forward.php?id=$name';</script>";
        } else {
            echo "<script>alert('Update failed: " . addslashes($conn->error) . "');</script>";
        }
    } elseif ($change == 'role') {
        $val = isset($_POST['stat']) ? $_POST['stat'] : ''; // Get the selected status value
        if ($value === '') {
            echo "<script>alert('No value received for role.');</script>";
        } else {
            if (executeUpdate($conn, 'users', 'role', $val, $id, 'user_id')) {
                echo "<script>alert('Role updated successfully'); window.location.href='../handle_forward.php?id=$name';</script>";
            } else {
                echo "<script>alert('Update failed: " . addslashes($conn->error) . "');</script>";
            }
        }
    } elseif ($change == 'image') {
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $uploadDir = '../uploads/'; // Ensure this directory exists and is writable
            $uploadFile = $uploadDir . basename($_FILES['image']['name']);

            // Move the uploaded file
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                echo "<script>alert('Error uploading image.');</script>";
            }

            // Save the relative file path
            $relativeFilePath = 'uploads/' . basename($_FILES['image']['name']);
        } else {
            echo "<script>alert('No image uploaded or there was an upload error.');</script>";
        }
        if (executeUpdate($conn, 'menu', 'image', $relativeFilePath, $id, 'id')) {
            echo "<script>alert('Display image updated successfully'); window.location.href='../handle_forward.php?id=$name';</script>";
        } else {
            echo "<script>alert('Update failed: " . addslashes($conn->error) . "');</script>";
        }
    }
}

$conn->close();
?>