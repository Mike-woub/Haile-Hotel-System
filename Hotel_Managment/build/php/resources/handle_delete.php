<?php
include('../../database/config.php');

function handleError($message)
{
    echo "<script>alert('Error: " . addslashes($message) . "'); window.history.back();</script>";
    exit;
}

$id = isset($_POST['id']) ? $_POST['id'] : null;
$name = isset($_POST['name']) ? $_POST['name'] : null;
$un = isset($_POST['un']) ? $_POST['un'] : null;

if ($id === null || empty($name)) {
    handleError("Invalid input.");
}

$table = '';
$idColumn = '';

switch ($name) {
    case 'rooms':
        $table = 'rooms';
        $idColumn = 'r_id';
        break;
    case 'menu':
        $table = 'menu';
        $idColumn = 'id';
        break;
    case 'users':
        $table = 'users';
        $idColumn = 'user_id';
        break;
    default:
        handleError("Invalid name provided.");
}

$sql = "DELETE FROM $table WHERE $idColumn = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    handleError("Database error: " . $conn->error);
}

$bindType = 'i';
$stmt->bind_param($bindType, $id);

if ($stmt->execute()) {
    echo "<script>alert('" . ucfirst($table) . " deleted successfully.'); window.location.href='../handle_forward.php?id=$name';</script>";
} else {
    handleError("Could not delete record: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>
