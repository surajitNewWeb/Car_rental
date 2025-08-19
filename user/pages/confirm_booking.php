<?php
session_start();
include("../config/db.php");
require '../../vendor/autoload.php';

use Razorpay\Api\Api;

if(!isset($_SESSION['un'])) {
    header("location:login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $car_id = $_POST['car_id'];
    $pickup_date = $_POST['pickup_date'];
    $return_date = $_POST['return_date'];
    $total_price = $_POST['total_price'];
    $payment_method = $_POST['payment_method'];

    $days = (strtotime($return_date) - strtotime($pickup_date))/(60*60*24) + 1;

    $sql = "INSERT INTO bookings (user_id, car_id, pickup_date, return_date, total_days, total_price, payment_method, status, payment_status)
            VALUES ('$user_id','$car_id','$pickup_date','$return_date','$days','$total_price','$payment_method','Pending','Pending')";
    
    if($con->query($sql)){
        $booking_id = $con->insert_id;

        if($payment_method == "COD"){
            header("Location: my_booking.php?id=$booking_id");
            exit;
        }
        else {
            $api = new Api("rzp_test_R6hOQbSqtIuWY2", "78b0NQPGm6AyFN2LMgiO1ggG");

            $orderData = [
                'receipt'         => (string)$booking_id,
                'amount'          => $total_price * 100,
                'currency'        => 'INR',
                'payment_capture' => 1
            ];
            
            $razorpayOrder = $api->order->create($orderData);
            $order_id = $razorpayOrder['id'];

            $con->query("UPDATE bookings SET razorpay_order_id='$order_id' WHERE id='$booking_id'");

            header("Location: payment_page.php?order_id=$order_id&booking_id=$booking_id");
            exit;
        }
    } else {
        echo "Error: " . $con->error;
    }
}
?>
