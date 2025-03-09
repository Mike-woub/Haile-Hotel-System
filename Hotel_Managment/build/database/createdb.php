<?php
$servername ="localhost";
$username="root";
$password="";

$conn=new mysqli($servername, $username, $password);
if($conn -> connect_error){
    die("connection failed". $conn -> connect_error);
}

$sql = "CREATE DATABASE haile";
if ($conn -> query($sql) === TRUE ){
    echo "Database Created successfully";
}
else{
    echo "Error creating db: " .$conn -> error;
}
$conn->close();
?>
