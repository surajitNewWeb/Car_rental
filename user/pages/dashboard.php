<?php
include("dash_head.php");
include("../config/db.php");

// Check login
if(!isset($_SESSION['user_id'])){
    header("location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch username
$user_sql = "SELECT username FROM users WHERE id='$user_id'";
$user_res = mysqli_query($con, $user_sql);
$user_row = mysqli_fetch_assoc($user_res);
$user_name = $user_row['username'] ?? "Guest";

// Fetch user stats
$total_bookings = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM bookings WHERE user_id='$user_id'"))['total'] ?? 0;
$upcoming_bookings = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM bookings WHERE user_id='$user_id' AND pickup_date >= CURDATE()"))['total'] ?? 0;
$total_spent = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(total_price) AS total FROM bookings WHERE user_id='$user_id' AND status='Confirmed'"))['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Dashboard</title>
   <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <style>
    body { background:#071022; color:#fff; font-family:'DM Sans',sans-serif; }
    .card {
        background:#0f2940;
        border-radius:12px;
        padding:20px;
        margin-bottom:20px;
        box-shadow:0 4px 15px rgba(0,0,0,0.5);
    }
    h2 { color:#ffb020; margin:20px 0; }
    .welcome { font-size:1.3rem; margin-bottom:20px; }
    .btn-custom {
        background:#ffb020; color:#071022; font-weight:bold;
        border-radius:8px; padding:10px 20px; text-decoration:none;
    }
    .btn-custom:hover { background:#d98c00; color:#fff; }
    .stat { font-size:2rem; font-weight:bold; color:#3ad7c0; margin-bottom:5px; }
    .stat-label { color:#8b98a6; font-size:0.9rem; }
  </style>
</head>
<body>
<div class="container mt-4">
  <h2>User Dashboard</h2>
  <p class="welcome">Welcome back, <strong><?php echo htmlspecialchars($user_name); ?></strong> 👋</p>

  <div class="row mb-4">
    <div class="col-md-4">
      <div class="card text-center">
        <div class="stat"><?= $total_bookings ?></div>
        <div class="stat-label">Total Bookings</div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-center">
        <div class="stat"><?= $upcoming_bookings ?></div>
        <div class="stat-label">Upcoming Bookings</div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-center">
        <div class="stat">₹<?= number_format($total_spent,2) ?></div>
        <div class="stat-label">Total Spent</div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-4">
      <div class="card text-center">
        <h4>📖 My Bookings</h4>
        <p>View and manage your car bookings.</p>
        <a href="my_booking.php" class="btn-custom">Go</a>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-center">
        <h4>🚘 Available Cars</h4>
        <p>Browse and rent your next ride.</p>
        <a href="vehical.php" class="btn-custom">Browse</a>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-center">
        <h4>⚙️ Profile Settings</h4>
        <p>Update your account information.</p>
        <a href="profile.php" class="btn-custom">Edit</a>
      </div>
    </div>
  </div>
</div>

<?php include("../includes/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
