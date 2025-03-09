<?php
$servername ="localhost";
$username="root";
$password="";
$dbname="haile";

$conn =new mysqli($servername, $username, $password, $dbname);

if($conn -> connect_error){
    die ("Error connecting to Database". $conn ->connect_error);
}
else {
    return $conn;
}

?>
