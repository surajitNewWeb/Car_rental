<?php
include("dash_head.php");
include("../config/db.php");

// Check login
if(!isset($_SESSION['user_id'])){
    header("location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$message = "";

// Fetch user details
$user_sql = "SELECT * FROM users WHERE id='$user_id'";
$user_res = mysqli_query($con, $user_sql);
$user = mysqli_fetch_assoc($user_res);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'])) {
    $booking_id = intval($_POST['booking_id']);
    $user_id = $_SESSION['user_id'];

    // delete only if booking belongs to this user
    $sel = "DELETE FROM bookings WHERE id = ? AND user_id = ?";
    $stmt = $con->prepare($sel);
    $stmt->bind_param("ii", $booking_id, $user_id);

    if ($stmt->execute()) {
        header("Location: my_booking.php?msg=Booking+deleted+successfully");
        exit;
    } else {
        header("Location: my_booking.php?error=Failed+to+delete+booking");
        exit;
    }
} else {
    header("Location: my_booking.php");
    exit;
}
