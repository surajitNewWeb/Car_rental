<?php
session_start();
include("../config/db.php");

// check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

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
