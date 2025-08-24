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

// ✅ Fetch user bookings
$sql = "SELECT b.id, b.pickup_date, b.return_date, b.total_price, b.payment_status, 
               b.payment_method, v.name AS car_name, v.brand, v.image
        FROM bookings b
        JOIN vehical v ON b.car_id = v.id
        WHERE b.user_id = '$user_id'
        ORDER BY b.created_at DESC";
$result = mysqli_query($con, $sql);

// ✅ Calculate stats
$total_rentals = mysqli_num_rows($result);
$active_rentals = 0;
$total_spent = 0;
$bookings = [];
while ($row = mysqli_fetch_assoc($result)) {
    $bookings[] = $row;
    if ($row['payment_status'] == 'Paid') {
        $total_spent += $row['total_price'];
    } else {
        $active_rentals++;
    }
}

// ✅ Handle delete request
if (isset($_POST['delete_booking'])) {
    $booking_id = (int) $_POST['booking_id'];
    mysqli_query($con, "DELETE FROM bookings WHERE id='$booking_id' AND user_id='$user_id'");
    header("Location: my_booking.php?deleted=1");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Rentals</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap + FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    :root {
      --bg-1: #071022;
      --bg-2: #0f2940;
      --accent: #ffb020;
      --accent-2: #d38f29;
      --muted: #8b98a6;
      --card: #ffffff;
      --glass: rgba(255, 255, 255, 0.06);
    }

    body { 
      background: var(--bg-1); 
      color: #fff; 
      font-family: 'Segoe UI', sans-serif; 
    }

    h2 span { color: var(--accent); }

    .stats-card {
      background: var(--bg-2); border-radius: 14px; padding: 20px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.3); text-align: center;
      color: #fff;
    }
    .stats-card h3 { font-size: 1.6rem; margin: 0; color: var(--accent); }
    .stats-card p { color: var(--muted); margin: 0; }

    .rental-card {
      background: var(--bg-2); border-radius: 14px; 
      box-shadow: 0 4px 14px rgba(0,0,0,0.4);
      overflow: hidden; margin-bottom: 20px;
      color: #fff;
    }
    .rental-card img { width: 100%; max-height: 180px; object-fit: cover; }
    .rental-card .content { padding: 16px; }

    .status-badge {
      padding: 4px 10px; border-radius: 6px; font-size: 0.8rem; font-weight: 600;
    }
    .status-pending { background: rgba(255, 176, 32, 0.15); color: var(--accent); }
    .status-confirmed { background: rgba(40, 167, 69, 0.15); color: #22c55e; }

    .btn-action { border-radius: 8px; font-weight: 500; border: none; }
    .btn-pay { background: var(--accent); color: #000; }
    .btn-pay:hover { background: var(--accent-2); color: #fff; }
    .btn-delete { background: #ef4444; color: #fff; }
    .btn-delete:hover { background: #c53030; }
    
    .alert { border-radius: 10px; }
  </style>
</head>
<body>

<div class="container py-4">
  <h2 class="text-center mb-4">My <span>Booking</span></h2>
  <p class="text-center text-light mb-5">Manage your car bookings and track rental history</p>

  <!-- ✅ Stats -->
  <div class="row text-center mb-5">
    <div class="col-md-4 mb-3">
      <div class="stats-card">
        <h3><?php echo $total_rentals; ?></h3>
        <p>Total Rentals</p>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="stats-card">
        <h3><?php echo $active_rentals; ?></h3>
        <p>Active</p>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="stats-card">
        <h3>₹<?php echo number_format($total_spent); ?></h3>
        <p>Total Spent</p>
      </div>
    </div>
  </div>

  <!-- ✅ Bookings -->
  <?php if (isset($_GET['deleted'])): ?>
    <div class="alert alert-success text-center bg-success text-white"><i class="fas fa-check-circle"></i> Booking deleted successfully!</div>
  <?php endif; ?>

  <?php if (count($bookings) > 0): ?>
    <?php foreach ($bookings as $row): ?>
      <div class="rental-card">
        <div class="row g-0">
          <div class="col-md-4">
            <img src="/car_rental/admin/assets/images/<?php echo $row['image']; ?>" alt="Car">
          </div>
          <div class="col-md-8">
            <div class="content">
              <!-- Status -->
              <?php if ($row['payment_status'] == 'Paid'): ?>
                <span class="status-badge status-confirmed">Confirmed</span>
              <?php else: ?>
                <span class="status-badge status-pending">Pending</span>
              <?php endif; ?>

              <h5 class="mt-2 text-accent"><?php echo $row['brand'] . " " . $row['car_name']; ?></h5>
              <p class="mb-1"><i class="fas fa-calendar-alt"></i> Pickup: <?php echo $row['pickup_date']; ?></p>
              <p class="mb-1"><i class="fas fa-calendar-check"></i> Return: <?php echo $row['return_date']; ?></p>
              <p class="mb-1"><i class="fas fa-wallet"></i> Payment: <?php echo $row['payment_method']; ?></p>
              <p class="fw-bold text-warning">₹<?php echo $row['total_price']; ?></p>

              <!-- Actions -->
              <div class="d-flex gap-2 mt-3">
                <?php if ($row['payment_status'] != 'Paid'): ?>
                  <a href="create_order.php?booking_id=<?php echo $row['id']; ?>" class="btn btn-pay btn-action flex-fill">Pay Now</a>
                <?php endif; ?>

                <form method="POST" onsubmit="return confirm('Delete this booking?');" class="flex-fill">
                  <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
                  <button type="submit" name="delete_booking" class="btn btn-delete btn-action w-100">Delete</button>
                </form>
              </div>

            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="alert alert-info text-center bg-dark text-white border-0"><i class="fas fa-info-circle"></i> No bookings found.</div>
  <?php endif; ?>
</div>

<?php include("../includes/footer.php"); ?>
</body>
</html>
