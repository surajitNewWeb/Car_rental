<?php
session_start();
include("admin_inc/db.php");

if(!isset($_SESSION['user_id'])){
    header("location: login.php");
    exit;
}

// ✅ Check if id is passed
if(!isset($_GET['id']) || empty($_GET['id'])){
    die("Error: Vehicle ID not provided in URL");
}

$id = intval($_GET['id']);

// ✅ Fetch vehicle details
$sql = "SELECT * FROM vehical WHERE id='$id'";
$res = mysqli_query($con, $sql);

// If no vehicle found
if(mysqli_num_rows($res) == 0){
    die("Error: Vehicle not found");
}

$data = mysqli_fetch_assoc($res);

if(isset($_POST['update'])){
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $type = $_POST['type'];
    $seats = $_POST['seats'];
    $price = $_POST['price'];
    $transmission = $_POST['transmission'];
    $status = $_POST['status'];

    // Image Update
    if(!empty($_FILES['image']['name'])){
        $buf = $_FILES['image']['tmp_name'];
        $fn = time().$_FILES['image']['name'];
        move_uploaded_file($buf,"assets/images/".$fn);

        // delete old image
        if(!empty($data['image']) && file_exists("assets/images/".$data['image'])){
            unlink("assets/images/".$data['image']);
        }

        $imageSql = ", image='$fn'";
    } else {
        $imageSql = "";
    }

    $upd = "UPDATE vehical SET 
              name='$name', 
              brand='$brand', 
              type='$type', 
              seats='$seats', 
              price='$price', 
              transmission='$transmission', 
              status='$status'
              $imageSql
            WHERE id='$id'";

    if(mysqli_query($con, $upd)){
        header("location:view_vehical.php?msg=updated");
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
  <title>Edit Vehicle</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Fonts & Icons -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

  <!-- Custom styles -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <style>
    .form-container {
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 5px 18px rgba(0, 0, 0, 0.1);
      max-width: 700px;
      margin: 0 auto;
    }

    .form-container h2 {
      font-size: 26px;
      font-weight: 700;
      margin-bottom: 25px;
      color: #ffb700ff;
      text-align: center;
    }

    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }

    .form-group label {
      font-weight: 600;
      color: #444;
      margin-bottom: 6px;
    }

    .form-group input,
    .form-group select {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 15px;
    }

    .form-group input:focus,
    .form-group select:focus {
      outline: none;
      border-color: #4e73df;
      box-shadow: 0 0 5px rgba(78, 115, 223, 0.4);
    }

    .thumb {
      border-radius: 8px;
      margin: 10px 0;
      border: 1px solid #ddd;
      padding: 5px;
      width: 120px;
    }

    .btn-submit {
      background: #ddb83eff;
      color: #fff;
      font-weight: bold;
      padding: 12px;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      cursor: pointer;
      transition: 0.3s;
      width: 100%;
      margin-top: 20px;
    }

    .btn-submit:hover {
      background: #ffb300ff;
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
      <div id="content">

        <!-- Topbar -->
        <?php include("admin_inc/header.php"); ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <h1 class="h3 mb-4 text-gray-800">Update Vehicle</h1>

          <div class="form-container">
            <h2>Edit Vehicle Details</h2>
            <form method="POST" enctype="multipart/form-data">
              <div class="form-grid">
                <div class="form-group">
                  <label>Car Name</label>
                  <input type="text" name="name" value="<?php echo $data['name']; ?>" required>
                </div>

                <div class="form-group">
                  <label>Brand</label>
                  <input type="text" name="brand" value="<?php echo $data['brand']; ?>" required>
                </div>

                <div class="form-group">
                  <label>Type</label>
                  <select name="type" required>
                    <option <?php if($data['type']=="SUV" ) echo "selected" ; ?>>SUV</option>
                    <option <?php if($data['type']=="Sedan" ) echo "selected" ; ?>>Sedan</option>
                    <option <?php if($data['type']=="Hatchback" ) echo "selected" ; ?>>Hatchback</option>
                    <option <?php if($data['type']=="Convertible" ) echo "selected" ; ?>>Convertible</option>
                  </select>
                </div>

                <div class="form-group">
                  <label>Seats</label>
                  <input type="number" name="seats" value="<?php echo $data['seats']; ?>" required>
                </div>

                <div class="form-group">
                  <label>Price (per day)</label>
                  <input type="number" name="price" value="<?php echo $data['price']; ?>" required>
                </div>

                <div class="form-group">
                  <label>Transmission</label>
                  <select name="transmission" required>
                    <option <?php if($data['transmission']=="Manual" ) echo "selected" ; ?>>Manual</option>
                    <option <?php if($data['transmission']=="Automatic" ) echo "selected" ; ?>>Automatic</option>
                  </select>
                </div>

                <div class="form-group">
                  <label>Status</label>
                  <select name="status" required>
                    <option <?php if($data['status']=="Avilable" ) echo "selected" ; ?>>Avilable</option>
                    <option <?php if($data['status']=="Uavilable" ) echo "selected" ; ?>>Uavilable</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label>Current Image</label><br>
                <img src="assets/images/<?php echo $data['image']; ?>" class="thumb">
                <input type="file" name="image">
              </div>

              <button type="submit" name="update" class="btn-submit">Update Vehicle</button>
            </form>
          </div>
        </div>
      </div>
      <!-- Footer -->
  <?php include("admin_inc/footer.php"); ?>
    </div>

  </div>
  
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