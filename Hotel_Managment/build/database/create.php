<?php
$servername="localhost";
$username="root";
$password="";
$dbname="haile";

$conn= new mysqli($servername,$username,$password,$dbname);
if($conn -> connect_error){
    die("error estabilishing connection". $conn -> connect_error);
}
$sql1="CREATE TABLE rooms (
    r_id INT PRIMARY KEY AUTO_INCREMENT,
    r_type VARCHAR(60),
    status INT,
    description VARCHAR(220),
    price DECIMAL(10, 2),
    capacity INT,
    amenities VARCHAR(255),

    total_rooms INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

);

";
$sql2="CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(60) UNIQUE,
    password VARCHAR(255),
    role VARCHAR(30),
    username VARCHAR(50) UNIQUE,
    firstname VARCHAR(50),
    lastname VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    status ENUM('active', 'inactive') DEFAULT 'inactive',
    otp VARCHAR(10) NULL,
    otp_expiration TIMESTAMP NULL
);
";

$sql4="CREATE TABLE inventory(
    id int PRIMARY KEY,
    i_type VARCHAR(30),
    in_Stock INT,
)";
$sql11 = "CREATE TABLE reservations (
    reservation_id INT PRIMARY KEY AUTO_INCREMENT,
    room_id INT,
    user_id INT,
    check_in DATE,
    check_out DATE,
    status ENUM('booked', 'checked_in', 'checked_out', 'cancelled') DEFAULT 'booked',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (room_id) REFERENCES rooms(r_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);";



$sql7="CREATE TABLE room_types (
    type_id INT PRIMARY KEY AUTO_INCREMENT,
    type_name VARCHAR(60),
    total_rooms INT
);
";
$sql99="CREATE TABLE feedbacks (
    f_id INT PRIMARY KEY AUTO_INCREMENT,
    user INT,  -- Assuming you have a users table with user IDs
    feedback TEXT,  -- Allows for longer feedback
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Track submission time
);

";
$sql49="CREATE TABLE menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    category VARCHAR(100),
    is_available BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
";

$sql77="CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transaction_ref VARCHAR(32) NOT NULL UNIQUE, -- Ensure transaction_ref is unique
    email VARCHAR(255) NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    room_type VARCHAR(255) NOT NULL,
    check_in_date DATE NOT NULL,
    check_out_date DATE NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'pending', -- Default status for new reservations
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP -- Track updates
);
";
$sql177="CREATE TABLE food_orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    transaction_ref VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    items JSON NOT NULL, -- Storing items as JSON
    total_amount DECIMAL(10, 2) NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
";

$sql188="ALTER TABLE food_orders
ADD COLUMN status VARCHAR(50) NOT NULL DEFAULT 'pending'
;";

$sql3="ALTER TABLE guest
ADD FOREIGN KEY (room)
REFERENCES rooms(r_id) 
ON DELETE SET NULL;
";
$sql39="ALTER TABLE users ADD checked_in TIMESTAMP DEFAULT CURRENT_TIMESTAMP;
";

// $sql63="ALTER TABLE users
// ADD FOREIGN KEY (emp_id)
// REFERENCES employee(emp_id) 
// ON DELETE SET NULL;
// ";
// $sql73="ALTER TABLE users
// ADD COLUMN role VARCHAR(30);
// ";
// $sql33=" CREATE DATABASE EIAR
// ";
// $sql4="
// ALTER TABLE employee AUTO_INCREMENT = 2;
// ";

$sql5 = "ALTER TABLE users
ADD COLUMN preferences VARCHAR (60);
";
$sql92="ALTER TABLE rooms
ADD COLUMN total_available INT
;";

$sql6 = "ALTER TABLE rooms
MODIFY COLUMN type_id INT AFTER r_id;
";

$sql8="ALTER TABLE menu
ADD COLUMN order_count INT
;";

$sql9="INSERT INTO rooms (type_id, status, description, price, capacity, amenities, booked_from, booked_to)
VALUES
(1, 1, NULL, 'Standard Room with city view', 5009.00, 'Wi-Fi, TV, Mini-bar, Ocean view'),
(2, 0, NULL, 'Twin Room with city view', 5500.00, 'Wi-Fi, TV, Mini-bar, City view', NULL, NULL),
(3, 1, NULL, 'Junior Suit with garden and Mountain view', 6000.00, 'Wi-Fi, TV, Garden view');
";
$sql10="INSERT INTO room_types (type_name, total_rooms)
VALUES
('Junior Suite', 5),
('Semi Junior Suite', 5),
('Standard Room', 40),
('Twin Room', 20);
";

$drop="DROP TABLE users;";

$user="INSERT INTO users (email, password, role, username, last_login, status)
VALUES ('soberlyhigh@gmail.com', 'hashed_password_here', 'admin', 'johndoe', NULL, 'active');";
if($conn->query($sql5) === TRUE){
    echo "created UU";
}
else{
    echo "there is a problem creating your table mf" .$conn -> error;
}

?>