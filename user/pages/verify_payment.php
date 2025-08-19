<?php
session_start();
include("../config/db.php");
require '../../vendor/autoload.php';

use Razorpay\Api\Api;

if (!isset($_SESSION['un'])) { header("location:login.php"); exit; }
if (!isset($_GET['booking_id'], $_GET['payment_id'], $_GET['signature'])) {
    exit("Invalid verification request");
}

$booking_id = (int) $_GET['booking_id'];
$payment_id = $_GET['payment_id'];
$signature  = $_GET['signature'];

// Get order_id from DB (source of truth)
$stmt = $con->prepare("SELECT razorpay_order_id FROM bookings WHERE id=?");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$stmt->bind_result($order_id);
$stmt->fetch();
$stmt->close();

if (!$order_id) exit("Order not found for this booking");

$api = new Api("rzp_test_R6hOQbSqtIuWY2", "78b0NQPGm6AyFN2LMgiO1ggG");

try {
    // Verify signature
    $api->utility->verifyPaymentSignature([
        'razorpay_order_id'   => $order_id,
        'razorpay_payment_id' => $payment_id,
        'razorpay_signature'  => $signature
    ]);

    // Optionally, fetch payment and double-check status
    $payment = $api->payment->fetch($payment_id);
    if ($payment->status !== 'captured') {
        // If something odd, treat as failed
        $upd = $con->prepare("UPDATE bookings SET payment_status='Failed' WHERE id=?");
        $upd->bind_param("i", $booking_id);
        $upd->execute();
        $upd->close();
        header("Location: my_booking.php?id=$booking_id&status=failed");
        exit;
    }

    // Mark as paid + confirmed
    $upd = $con->prepare("UPDATE bookings 
                          SET payment_status='Paid', status='Confirmed', payment_id=? 
                          WHERE id=?");
    $upd->bind_param("si", $payment_id, $booking_id);
    $upd->execute();
    $upd->close();

    header("Location: my_booking.php?id=$booking_id&status=success");
    exit;

} catch (Exception $e) {
    // Signature invalid or API error
    $upd = $con->prepare("UPDATE bookings SET payment_status='Failed' WHERE id=?");
    $upd->bind_param("i", $booking_id);
    $upd->execute();
    $upd->close();

    exit("Payment verification failed: " . $e->getMessage());
}
