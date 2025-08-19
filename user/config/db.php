<?php
// Database connection
$con = mysqli_connect("localhost", "root", "", "car_rental");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>


