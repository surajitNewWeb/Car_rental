<?php
session_start();
include("admin_inc/db.php");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location:login.php"); // redirect if not logged in
    exit();
}

// If logged in, you can access admin details
$adminName  = $_SESSION['admin_name'];
$adminEmail = $_SESSION['admin_email'];
?>
<?php
if(isset($_POST['save'])){
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $type = $_POST['type'];
    $seats = $_POST['seats'];
    $price = $_POST['price'];
    $transmission = $_POST['transmission'];
    $status = $_POST['status'];

    // ✅ Image Upload
    $fn = "";
    if(!empty($_FILES['image']['name'])){
        $buf = $_FILES['image']['tmp_name'];
        $fn = time().$_FILES['image']['name'];
        move_uploaded_file($buf,"assets/images/".$fn);
    }

    $ins = "INSERT INTO vehical (name, brand, type, seats, price, transmission, status, image) 
            VALUES ('$name', '$brand', '$type', '$seats', '$price', '$transmission', '$status', '$fn')";

    if(mysqli_query($con, $ins)){
        header("location:view_vehical.php?msg=added");
        exit;
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Add Vehicle - Car Rental Dashboard</title>

  <!-- Fonts & Icons -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

  <!-- Custom styles -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <style>
    .form-container {
      background: #fff;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      max-width: 700px;
      margin: 30px auto;
    }
    .form-container h2 {
      font-size: 24px;
      margin-bottom: 25px;
      font-weight: 700;
      color: #f1ac0bff;
      text-align: center;
    }
    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }
    .form-group {
      display: flex;
      flex-direction: column;
    }
    .form-group label {
      font-weight: 600;
      margin-bottom: 6px;
      color: #444;
    }
    .form-group input,
    .form-group select {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }
    .btn-submit {
      margin-top: 25px;
      padding: 12px 20px;
      border: none;
      border-radius: 10px;
      background: #ddb12bff;
      color: #fff;
      font-weight: bold;
      font-size: 16px;
      cursor: pointer;
      transition: 0.3s;
      display: block;
      width: 100%;
    }
    .btn-submit:hover {
      background: #f3be01ff;
    }
  </style>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php include("admin_inc/sidebar.php"); ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php include("admin_inc/header.php"); ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <h1 class="h3 mb-4 text-gray-800">Add Vehicle</h1>
          <div class="form-container">
            <h2>Add New Vehicle</h2>
            <form method="POST" enctype="multipart/form-data">
              <div class="form-grid">
                <div class="form-group">
                  <label>Car Name</label>
                  <input type="text" name="name" required>
                </div>
                <div class="form-group">
                  <label>Brand</label>
                  <input type="text" name="brand" required>
                </div>
                <div class="form-group">
                  <label>Type</label>
                  <select name="type" required>
                    <option value="SUV">SUV</option>
                    <option value="Sedan">Sedan</option>
                    <option value="Hatchback">Hatchback</option>
                    <option value="Convertible">Convertible</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Seats</label>
                  <input type="number" name="seats" required>
                </div>
                <div class="form-group">
                  <label>Price per Day ($)</label>
                  <input type="number" name="price" required>
                </div>
                <div class="form-group">
                  <label>Transmission</label>
                  <select name="transmission" required>
                    <option value="Manual">Manual</option>
                    <option value="Automatic">Automatic</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Status</label>
                  <select name="status" required>
                    <option value="Available">Available</option>
                    <option value="Unavailable">Unavailable</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Car Image</label>
                  <input type="file" name="image" required>
                </div>
              </div>
              <button type="submit" name="save" class="btn-submit">Add Car</button>
            </form>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php include("admin_inc/footer.php"); ?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal -->
  <?php include("admin_inc/logout_modal.php"); ?>
  <!-- End Logout Modal -->

  <!-- JS -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/sb-admin-2.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- OR Bootstrap 5 JS (if you are using Bootstrap 5) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
