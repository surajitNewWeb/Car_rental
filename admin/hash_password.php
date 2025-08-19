<?php
include("admin_inc/db.php");

// Current plain text password
$plain_password = "1234";

// Hash the password
$hashed = password_hash($plain_password, PASSWORD_DEFAULT);

// Update the password in the database
$con->query("UPDATE admin SET password='$hashed' WHERE email='surajit@gmail.com'");
echo "Password hashed successfully!";
?>
