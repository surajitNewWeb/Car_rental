<?php include("dash_head.php"); ?>
<?php
include("../config/db.php"); 
if (!isset($_SESSION['un'])) {
    header("location:login.php");
    exit;
}

if(!isset($_GET['id'])){
    die("No car selected!");
}

$car_id = $_GET['id'];
$sel = "SELECT * FROM vehical WHERE id='$car_id'";
$res = $con->query($sel);

if($res->num_rows == 0){
    die("Car not found!");
}
$car = $res->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Book Car - <?php echo $car['name']; ?></title>
<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- FontAwesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
:root {
    --bg-1: #071022;
    --bg-2: #0f2940;
    --accent: #ffb020;
    --accent-2: #c17d00;
    --muted: #8b98a6;
    --card: #ffffff;
    --glass: rgba(255, 255, 255, 0.06);
}

body { 
    background: var(--bg-1); 
    font-family: 'DM Sans', sans-serif; 
    color: var(--card); 
}

.booking-container { 
    max-width: 1000px; 
    margin: 50px auto; 
}

.card-booking { 
    background: var(--bg-2); 
    border-radius: 20px; 
    padding: 30px; 
    display: flex; 
    flex-wrap: wrap; 
    gap: 30px; 
    box-shadow: 0 8px 30px rgba(0,0,0,0.5); 
}

.car-img img { 
    border-radius: 15px; 
    width: 100%; 
    max-height: 400px; 
    object-fit: cover; 
    border: 3px solid var(--accent); 
}

.car-info { flex: 1; min-width: 300px; }
.car-info h2 { font-size: 32px; color: var(--accent); margin-bottom: 20px; }
.car-info p { font-size: 16px; margin: 8px 0; color: var(--muted); }
.car-info i { color: var(--accent-2); margin-right: 8px; }

.form-control { 
    background: var(--glass); 
    color: var(--card); 
    border: 1px solid var(--accent); 
    border-radius: 10px; 
}
.form-label { font-weight: 600; color: var(--accent); }

.total-price { 
    font-weight: bold; 
    font-size: 1.5em; 
    margin-top: 20px; 
    color: var(--accent); 
}

.btn-primary { 
    background: linear-gradient(45deg, var(--accent), var(--accent-2)); 
    border: none; 
    padding: 12px; 
    font-size: 18px; 
    font-weight: bold; 
    border-radius: 12px; 
    width: 100%; 
    margin-top: 15px; 
    transition: 0.3s ease-in-out; 
}
.btn-primary:hover { 
    transform: scale(1.05); 
    background: linear-gradient(45deg, var(--accent-2), var(--accent)); 
}

@media(max-width:768px){ 
    .card-booking { flex-direction: column; } 
}
</style>
</head>
<body>

<div class="container booking-container">
    <div class="card-booking">
        <!-- Car Image -->
        <div class="col-md-6 car-img">
            <img src="../../admin/assets/images/<?php echo $car['image']; ?>" alt="<?php echo $car['name']; ?>">
        </div>

        <!-- Car Info & Booking Form -->
        <div class="col-md-6 car-info">
            <h2><?php echo $car['name']; ?></h2>
            <p><i class="fa-solid fa-car"></i> Brand: <?php echo $car['brand']; ?></p>
            <p><i class="fa-solid fa-list"></i> Type: <?php echo $car['type']; ?></p>
            <p><i class="fa-solid fa-chair"></i> Seats: <?php echo $car['seats']; ?></p>
            <p><i class="fa-solid fa-signal"></i> Status: <?php echo $car['status']; ?></p>
            <p><i class="fa-solid fa-gear"></i> Transmission: <?php echo $car['transmission']; ?></p>
            <p><i class="fa-solid fa-dollar-sign"></i> Price per day: ₹<?php echo $car['price']; ?></p>

            <form method="POST" action="confirm_booking.php" class="mt-4">
                <input type="hidden" name="car_id" value="<?php echo $car['id']; ?>">
                <input type="hidden" name="price_per_day" id="price_per_day" value="<?php echo $car['price']; ?>">
                <input type="hidden" name="total_price" id="total_price" value="0">

                <div class="mb-3">
                    <label class="form-label">Pickup Date:</label>
                    <input type="date" name="pickup_date" id="pickup_date" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Return Date:</label>
                    <input type="date" name="return_date" id="return_date" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Payment Method:</label>
                    <select name="payment_method" id="payment_method" class="form-control" required>
                        <option value="Razorpay">Pay Online (Razorpay)</option>
                        <option value="COD">Cash on Delivery</option>
                    </select>
                </div>

                <p class="total-price">
                    <span id="daysCount">0</span> days × ₹<?php echo $car['price']; ?> = 
                    ₹<span id="totalPrice">0</span>
                </p>
                <a href=""><button type="submit" class="btn btn-primary">Confirm Booking</button></a>
            </form>
        </div>
    </div>
</div>
<?php include("../includes/footer.php"); ?>

<script>
const pickup = document.getElementById('pickup_date');
const ret = document.getElementById('return_date');
const totalElem = document.getElementById('totalPrice');
const daysElem = document.getElementById('daysCount');
const price = parseFloat(document.getElementById('price_per_day').value);
const totalInput = document.getElementById('total_price');

function calcTotal(){
    const pd = new Date(pickup.value);
    const rd = new Date(ret.value);
    if(pd && rd && rd >= pd){
        const days = Math.ceil((rd - pd)/(1000*60*60*24)) + 1;
        const total = days * price;
        daysElem.innerText = days;
        totalElem.innerText = total.toFixed(2);
        totalInput.value = total;
    } else {
        daysElem.innerText = 0;
        totalElem.innerText = 0;
        totalInput.value = 0;
    }
}

pickup.addEventListener('change', calcTotal);
ret.addEventListener('change', calcTotal);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
