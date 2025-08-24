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
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Car Rental Dashboard</title>

  <!-- Fonts & Icons -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900"
    rel="stylesheet">

  <!-- Custom styles -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
   <link href="assets/css/style.css" rel="stylesheet">
  <link href="assets/css/view.css" rel="stylesheet">
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
          <h1 class="h3 mb-4 text-gray-800">View Vehical</h1>
           <table>
            <a class="bnt btn-add" href="add_vehical.php">Add-vehical</a>
            <thead>
              <tr>
                <th>Name</th>
                <th>Image</th>
                <th>Brand</th>
                <th>Type</th>
                <th>Seats</th>
                <th>Status</th>
                <th>Transmission</th>
                <th>Price/Day</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $sel="SELECT * FROM vehical";
               $rs=$con->query($sel);
               while($row=$rs->fetch_assoc()) {
               ?>
              <tr>
                <td>
                  <?php echo $row['name']; ?>
                </td>
                <td><img class="thumb" src="assets/images/<?php echo $row['image']; ?>"
                    alt="<?php echo $row['name']; ?>"></td>
                <td><span class="brand">
                    <?php echo $row['brand']; ?>
                  </span></td>
                <td>
                  <?php echo $row['type']; ?>
                </td>
                <td>
                  <?php echo $row['seats']; ?>
                </td>
                <td>
                  <?php echo $row['status']; ?>
                </td>
                <td class="transmission">
                  <?php echo $row['transmission']; ?>
                </td>
                <td class="price">$
                  <?php echo $row['price']; ?>/day
                </td>
                <td>
                  <a href="upd.php?id=<?php echo $row['id']; ?>"><button class="btn btn-update">Update</button></a>

                  <a onclick="return confirm('Are you sure to delete');" href="delcat.php?did=<?php echo $row['id']; ?>"><button class="btn btn-delete">Delete</button></a>
                </td>
              </tr>
              <?php } ?>

            </tbody>
          </table>
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
</body>
</html>
