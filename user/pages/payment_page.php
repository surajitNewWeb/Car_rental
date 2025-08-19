<?php
include("../config/db.php");
if(!isset($_GET['order_id']) || !isset($_GET['booking_id'])){
    die("Invalid access");
}
$order_id = $_GET['order_id'];
$booking_id = $_GET['booking_id'];

$res = $con->query("SELECT total_price FROM bookings WHERE id='$booking_id'");
$booking = $res->fetch_assoc();
$total_price = $booking['total_price'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
<script>
var options = {
    key: "rzp_test_R6hOQbSqtIuWY2",
    amount: "<?php echo (int) round($total_price * 100); ?>",
    currency: "INR",
    name: "Car Rental Service",
    description: "Booking Payment #<?php echo $booking_id; ?>",
    order_id: "<?php echo $order_id; ?>",
    handler: function (response) {
        window.location.href = "verify_payment.php?booking_id=<?php echo $booking_id; ?>"
            + "&payment_id=" + encodeURIComponent(response.razorpay_payment_id)
            + "&signature="   + encodeURIComponent(response.razorpay_signature);
    },
    theme: { color: "#ffb020" }
};
var rzp = new Razorpay(options);
rzp.open(); // auto open
</script>
</body>
</html>
