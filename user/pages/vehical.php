<?php include("dash_head.php"); ?>
<?php
 include("../config/db.php"); 
if (!isset($_SESSION['un'])) {
    header("location:login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Car Rental - Filter & Modal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <!-- FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;600;700&family=Caveat:wght@500;700&display=swap"
    rel="stylesheet">

  <!-- custom css -->
  <link rel="stylesheet" href="../assets/css/vehical.css">
</head>

<body>

  <!-- Filters -->
  <div class="filter-bar">
    <input type="text" id="searchInput" placeholder="Search by name...">
    <select id="typeFilter">
      <option value="">All Types</option>
      <option value="SUV">SUV</option>
      <option value="Sedan">Sedan</option>
      <option value="Hatchback">Hatchback</option>
    </select>
    <select id="brandFilter">
      <option value="">All Brands</option>
      <option value="Toyota">Toyota</option>
      <option value="Honda">Honda</option>
      <option value="Suzuki">Suzuki</option>
    </select>
    <label for="priceRange">Max Price: ₹<span id="priceValue">100</span></label>
    <input type="range" id="priceRange" min="0" max="200" value="100">
  </div>

  <!-- Car Grid -->
  <div class="car-grid" id="carGrid">
    <?php
    $sel = "SELECT * FROM vehical";
    $rs = $con->query($sel);
    while ($row = $rs->fetch_assoc()) {
    ?>
    <div class="car-card" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['name']; ?>"
      data-brand="<?php echo $row['brand']; ?>" data-type="<?php echo $row['type']; ?>"
      data-price="<?php echo $row['price']; ?>" data-seats="<?php echo $row['seats']; ?>"
      data-fuel="<?php echo $row['status']; ?>" data-transmission="<?php echo $row['transmission']; ?>">

      <img src="/car_rental/admin/assets/images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
      <div class="info">
        <h3>
          <?php echo $row['name']; ?>
        </h3>
        <div class="icons">
          <p><i class="fa-solid fa-car"></i>
            <?php echo $row['brand']; ?>
          </p>
          <p><i class="fa-solid fa-list"></i>
            <?php echo $row['type']; ?>
          </p>
          <p><i class="fa-solid fa-chair"></i>
            <?php echo $row['seats']; ?>
          </p>
          <p><i class="fa-solid fa-signal"></i>
            <?php echo $row['status']; ?>
          </p>
          <p><i class="fa-solid fa-gear"></i>
            <?php echo $row['transmission']; ?>
          </p>
        </div>
        <div class="price">₹
          <?php echo $row['price']; ?> /day
        </div>
        <button class="view-btn" onclick="openModal(this)">View Details</button>
      </div>
    </div>
    <?php } ?>
  </div>

  <!-- Modal -->
  <div class="modal" id="carModal">
    <div class="modal-content">
      <span class="close" id="closeModalBtn">&times;</span>
      <div class="modal-body">
        <div class="modal-left">
          <img id="modalImage" src="" alt="Car Image">
        </div>
        <div class="modal-right">
          <h2 id="modalTitle"></h2>
          <p class="modal-price">₹<span id="modalPrice"></span>/day</p>
          <div class="modal-specs">
            <p><i class="fa-solid fa-car"></i>Brand: <span id="modalBrand"></span></p>
            <p><i class="fa-solid fa-list"></i> Types: <span id="modalType"></span></p>
            <p><i class="fa-solid fa-chair"></i> Seats: <span id="modalSeats"></span></p>
            <p><i class="fa-solid fa-gear"></i> Transmission: <span id="modalTransmission"></span></p>
            <p><i class="fa-solid fa-signal"></i> Status: <span id="modalStatus"></span></p>
          </div>
          <p class="modal-description">Flagship car with premium interior, ADAS, and wireless CarPlay.</p>
          <div style="display:flex; gap:10px;">
            <a href="" id="bookNowBtn" class="btn-book">Book Now</a>
            <button id="shareBtn" class="btn-book">Share</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include("../includes/footer.php"); ?>

  <script src="../assets/js/vehical.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>