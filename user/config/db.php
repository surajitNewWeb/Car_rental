<?php
$host = "localhost";   // Database Hostname (check in cPanel)
$user = "root";             // Database Username
$pass = "";         // Database Password (get from cPanel -> MySQL Databases)
$db   = "car_rental";  // Database Name

$con = mysqli_connect($host, $user, $pass, $db);

// Check connection
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
