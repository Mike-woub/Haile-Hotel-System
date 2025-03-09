<?php
include('../../database/config.php');
require '../../../vendor/autoload.php'; // Include PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function checkIdExists($conn, $table, $column, $id) {
    $stmt = $conn->prepare("SELECT 1 FROM $table WHERE $column = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows > 0;
}

function addRecord($conn, $table, $columns, $values, $types) {
    $sql = "INSERT INTO $table ($columns) VALUES (" . str_repeat('?,', count($values) - 1) . "?)";
    $stmt = $conn->prepare($sql);
    $name = sanitizeInput($_POST['what']);

    if ($stmt) {
        $stmt->bind_param($types, ...array_values($values));
        if ($stmt->execute()) {
            echo "<script>alert('Record added successfully.'); window.location.href='../handle_forward.php?id=$name';</script>";
        } else {
            echo "<script>alert('Couldn\'t add record: " . $stmt->error . "');</script>";
        }
    } else {
        echo "<script>alert('Prepare failed: " . $conn->error . "');</script>";
    }
    
}

$name = sanitizeInput($_POST['what']);

switch ($name) {
    case 'rooms':
        $total_rooms = isset($_POST['t_rooms']) ? sanitizeInput($_POST['t_rooms']) : NULL;
        $description = isset($_POST['description']) ? sanitizeInput($_POST['description']) : NULL;
        $amenities = isset($_POST['amenities']) ? sanitizeInput($_POST['amenities']) : NULL;
        $price = isset($_POST['price']) ? (int)$_POST['price'] : NULL;
        $type_id = isset($_POST['type_id']) ? (int)$_POST['type_id'] : NULL;
        $capacity = isset($_POST['capacity']) ? (int)$_POST['capacity'] : NULL;

        if (empty($type_id) && empty($total_rooms) && empty($price) && empty($description) && empty($capacity) && empty($amenities)) {
            echo "<script>alert('Nothing to add.');</script>";
            break;
        }

        if ($type_id !== NULL && !checkIdExists($conn, 'room_types', 'type_id', $type_id)) {
            echo "<script>alert('Type ID does not exist.');</script>";
            break;
        }

        $values = [
            'type_id' => $type_id,
            'total_rooms' => $total_rooms,
            'price' => $price,
            'description' => $description,
            'capacity' => $capacity,
            'amenities' => $amenities,
        ];

        echo addRecord($conn, 'rooms', 'type_id, total_rooms, price, description, capacity, amenities', $values, 'iiisis');
        break;

    case 'menu':
        $name = isset($_POST['name']) ? sanitizeInput($_POST['name']) : NULL;
        $description = isset($_POST['description']) ? sanitizeInput($_POST['description']) : NULL;
        $price = isset($_POST['price']) ? (float)$_POST['price'] : NULL;
        $category = isset($_POST['category']) ? sanitizeInput($_POST['category']) : NULL;
        $course = isset($_POST['course']) ? sanitizeInput($_POST['course']) : NULL;
        $availability = isset($_POST['availability']) ? (int)$_POST['availability'] : NULL;

        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $uploadDir = '../uploads/'; // Ensure this directory exists and is writable
            $uploadFile = $uploadDir . basename($_FILES['image']['name']);

            // Move the uploaded file
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                echo "<script>alert('Error uploading image.');</script>";
                break;
            }

            // Save the relative file path
            $relativeFilePath = 'uploads/' . basename($_FILES['image']['name']);
        } else {
            echo "<script>alert('No image uploaded or there was an upload error.');</script>";
            break;
        }

        if (empty($name) || empty($description) || empty($price) || empty($category) || empty($course) || $availability === NULL) {
            echo "<script>alert('Please fill in all fields.');</script>";
            break;
        }

        $menuValues = [
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'image' => $relativeFilePath,
            'category' => $category,
            'is_available' => $availability,
            'course' => $course,
        ];

        echo addRecord($conn, 'menu', 'name, description, price, image, category, is_available, course', $menuValues, 'ssdssss');
        break;

    case 'users':
        echo "hello";
        $first_name = isset($_POST['first_name']) ? sanitizeInput($_POST['first_name']) : NULL;
        $last_name = isset($_POST['last_name']) ? sanitizeInput($_POST['last_name']) : NULL;
        $email = isset($_POST['email']) ? sanitizeInput($_POST['email']) : NULL;
        $username = isset($_POST['username']) ? sanitizeInput($_POST['username']) : NULL;
        $password = isset($_POST['password']) ? sanitizeInput($_POST['password']) : NULL;
        $role = isset($_POST['role']) ? sanitizeInput($_POST['role']) : NULL;
        $status = isset($_POST['status']) ? sanitizeInput($_POST['status']) : NULL;

        if (empty($first_name) || empty($last_name) || empty($email) || empty($username) || empty($password) || empty($role) || $status === NULL) {
            echo "<script>alert('Please fill in all fields.');</script>";
            break;
        }

        // Hash the password before storing it
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $userValues = [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'username' => $username,
            'password' => $hashedPassword,
            'role' => $role,
            'status' => $status,
        ];

        echo addRecord($conn, 'users', 'firstname, lastname, email, username, password, role, status', $userValues, 'sssssss');
        

        break;

    default:
        echo "<script>alert('Invalid request.');</script>";
        break;
}

$conn->close();
?>