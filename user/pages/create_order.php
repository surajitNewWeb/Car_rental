<?php
session_start();
include("../config/db.php");
require '../../vendor/autoload.php';

use Razorpay\Api\Api;

if (!isset($_SESSION['un'])) { header("location:login.php"); exit; }
if (!isset($_GET['booking_id'])) { exit("No booking selected"); }

$booking_id = (int) $_GET['booking_id'];
$user_id    = (int) $_SESSION['user_id'];

// Ensure the booking belongs to this user and is still payable
$sql = "SELECT id, total_price, payment_status, status FROM bookings WHERE id=? AND user_id=?";
$stmt = $con->prepare($sql);
$stmt->bind_param("ii", $booking_id, $user_id);
$stmt->execute();
$res = $stmt->get_result();
$booking = $res->fetch_assoc();
$stmt->close();

if (!$booking) exit("Booking not found");
if ($booking['payment_status'] === 'Paid') { header("Location: my_booking.php?id=$booking_id"); exit; }

$api = new Api("rzp_test_R6hOQbSqtIuWY2", "78b0NQPGm6AyFN2LMgiO1ggG");

$orderData = [
    'receipt'         => "BOOKING_" . $booking_id . "_RETRY_" . time(),
    'amount'          => (int) round($booking['total_price'] * 100),
    'currency'        => 'INR',
    'payment_capture' => 1
];

try {
    $razorpayOrder = $api->order->create($orderData);
    $order_id = $razorpayOrder['id'];

    $u = $con->prepare("UPDATE bookings SET razorpay_order_id=? WHERE id=?");
    $u->bind_param("si", $order_id, $booking_id);
    $u->execute();
    $u->close();

    header("Location: payment_page.php?order_id=".$order_id."&booking_id=".$booking_id);
    exit;
} catch (Exception $e) {
    exit("Unable to create Razorpay order: " . $e->getMessage());
}
