<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("location:login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Book Rental</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;600;700&family=Caveat:wght@500;700&display=swap" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="/car_rental/user/assets/css/style.css">
</head>
<body>

  <!-- NAV -->
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
      <a class="navbar-brand" href="/car_rental/index.php">
        <img src="/car_rental/user/assets/images/logo.jpg" alt="logo" height="40">
      </a>

      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
        <i class="fa fa-bars" style="color:#fff;"></i>
      </button>

      <div class="collapse navbar-collapse" id="navMain">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link active" href="/car_rental/user/pages/dashboard.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="/car_rental/user/pages/vehical.php">Vehical</a></li>
          <li class="nav-item"><a class="nav-link" href="/car_rental/user/pages/my_booking.php">Booking Details</a></li>
          <li class="nav-item"><a class="nav-link" href="/car_rental/user/pages/profile.php">Profile</a></li>
        </ul>

        <div class="d-flex align-items-center gap-3">
          <span class="text-light">
            <i class="fa-regular fa-user me-1"></i>
            <?php echo htmlspecialchars($_SESSION['username']); ?>
          </span>
          <a href="/car_rental/user/pages/logout.php" class="btn btn-sm btn-danger"
             onclick="return confirm('Are you sure you want to logout?');">
             Log out
          </a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
