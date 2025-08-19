<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location:login.php");
    exit();
}
?>

<?php
include("admin_inc/db.php");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch summary data
$total_bookings = $con->query("SELECT COUNT(*) AS total FROM bookings")->fetch_assoc()['total'];
$total_vehicles = $con->query("SELECT COUNT(*) AS total FROM vehical")->fetch_assoc()['total'];
$total_customers = $con->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
$total_revenue = $con->query("SELECT SUM(total_price) AS revenue FROM bookings WHERE status='Confirmed'")->fetch_assoc()['revenue'] ?? 0;

// Fetch bookings per month for chart
$booking_months = $con->query("
    SELECT MONTH(pickup_date) AS month, COUNT(*) AS total
    FROM bookings
    GROUP BY MONTH(pickup_date)
    ORDER BY MONTH(pickup_date)
")->fetch_all(MYSQLI_ASSOC);

// Prepare labels & data for JS
$labels = [];
$dataBookings = [];
foreach($booking_months as $bm){
    $labels[] = date('M', mktime(0,0,0,$bm['month'],1));
    $dataBookings[] = $bm['total'];
}

// Vehicle status counts (Removed Maintenance)
$rented_count = $con->query("SELECT COUNT(*) AS total FROM bookings WHERE status='Confirmed'")->fetch_assoc()['total'];
$available_count = $total_vehicles - $rented_count;

$vehicle_status = [
    'Available' => $available_count,
    'Rented' => $rented_count
];

// Recent reservations
$recent_reservations = $con->query("
    SELECT b.id, u.username, v.name AS vehicle_name, b.pickup_date, b.return_date, b.status
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    JOIN vehical v ON b.car_id = v.id
    ORDER BY b.created_at DESC
    LIMIT 5
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Car Rental Dashboard</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body id="page-top">
  <div id="wrapper">
    <?php include("admin_inc/sidebar.php"); ?>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php include("admin_inc/header.php"); ?>
        <div class="container-fluid">

          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="add_vehical.php" class="d-none d-sm-inline-block btn btn-sm btn-custom shadow-sm">
              <i class="fas fa-plus fa-sm text-white-50"></i> Add Vehicle
            </a>
          </div>

          <div class="row">
            <!-- Total Bookings -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Bookings</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_bookings ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-calendar-check fa-2x text-gray-300"></i></div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Total Vehicles -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Available Vehicles</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_vehicles ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-car fa-2x text-gray-300"></i></div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Customers -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Customers</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_customers ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-users fa-2x text-gray-300"></i></div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Revenue -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Revenue</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">$<?= number_format($total_revenue,2) ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-dollar-sign fa-2x text-gray-300"></i></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <!-- Bookings Chart -->
            <div class="col-xl-8 col-lg-7">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Bookings Overview</h6>
                </div>
                <div class="card-body">
                  <div class="chart-area">
                    <canvas id="bookingsChart"></canvas>
                  </div>
                </div>
              </div>
            </div>

            <!-- Vehicles Status Pie Chart -->
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Vehicle Status</h6>
                </div>
                <div class="card-body">
                  <div class="chart-pie pt-4">
                    <canvas id="vehiclesPieChart"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Recent Reservations Table -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Recent Reservations</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Booking ID</th>
                      <th>Customer</th>
                      <th>Vehicle</th>
                      <th>Pickup</th>
                      <th>Return</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php while($row = $recent_reservations->fetch_assoc()): ?>
                    <tr>
                      <td>#<?= $row['id'] ?></td>
                      <td><?= $row['username'] ?></td>
                      <td><?= $row['vehicle_name'] ?></td>
                      <td><?= $row['pickup_date'] ?></td>
                      <td><?= $row['return_date'] ?></td>
                      <td>
                        <?php 
                          $status_class = $row['status'] == 'Confirmed' ? 'success' : ($row['status']=='Cancelled' ? 'danger' : 'warning');
                        ?>
                        <span class="badge badge-<?= $status_class ?>"><?= $row['status'] ?></span>
                      </td>
                    </tr>
                    <?php endwhile; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
      </div>
      
    </div>
  </div>
  <?php include("admin_inc/footer.php"); ?>

 <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal -->
  <?php include("admin_inc/logout_modal.php"); ?>
  <!-- End Logout Modal -->


  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/sb-admin-2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- OR Bootstrap 5 JS (if you are using Bootstrap 5) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>


  <script>
    // Bookings Overview Line Chart
    const ctxBookings = document.getElementById('bookingsChart').getContext('2d');
    new Chart(ctxBookings, {
      type: 'line',
      data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
          label: "Bookings",
          data: <?= json_encode($dataBookings) ?>,
          borderColor: "#ffb020",
          backgroundColor: "rgba(255, 176, 32, 0.2)",
          fill: true,
          tension: 0.3
        }]
      }
    });

    // Vehicles Status Pie Chart
    const ctxVehicles = document.getElementById('vehiclesPieChart').getContext('2d');
    new Chart(ctxVehicles, {
      type: 'doughnut',
      data: {
        labels: <?= json_encode(array_keys($vehicle_status)) ?>,
        datasets: [{
          data: <?= json_encode(array_values($vehicle_status)) ?>,
          backgroundColor: ["#3ad7c0", "#ffb020"]
        }]
      }
    });
  </script>

</body>
</html>
