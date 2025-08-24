
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php include("user/includes/topbar.php");  ?>
<?php include("user/config/db.php"); ?>
  <!-- HERO -->
  <section class="hero">
    <div class="hero-inner container">

      <div class="hero-copy">

        <h1>Enjoy your life with our comfortable car</h1>
        <p>Choose from a wide selection of vehicles — affordable rates, excellent support and easy booking. Drive happy, drive safe.</p>

        <div class="hero-cta">
          <a class="log btn-lg" href="user/pages/book_rent.php">Explore Now</a>
          <a class="btn sign" href="user/pages/book_rent.php">Browse Cars</a>
        </div>
      </div>

      <div class="hero-card">
        <h5>Special Weekend Deal</h5>
        <p class="mb-0">Rent an SUV this weekend and get <strong class="price">20% off</strong> plus free delivery (limited time).</p>
        <div style="height:12px"></div>
        <small class="text-muted">Use code: <strong>WEEKEND20</strong></small>
      </div>

    </div>
  </section>

  <!-- SELECT YOUR VEHICLE TYPE -->
  <div class="heading"><h2>SELECT YOUR VEHICAL TYPE</h2></div>
  <section class="category-slider">
    <div class="cat-item"><img src="user/assets/images/SVG.png" alt="SUV"><p>SUV</p></div>
    <div class="cat-item"><img src="user/assets/images/SVG (1).png" alt="Sedan"><p>Sedan</p></div>
    <div class="cat-item"><img src="user/assets/images/SVG (2).png" alt="Hatchback"><p>Hatchback</p></div>
    <div class="cat-item"><img src="user/assets/images/SVG (8).png" alt="Electric"><p>Electric</p></div>
  </section>

  <!-- MOST SEARCHES CAR -->
  <div class="heading"><h2>MOST SEARCHES CAR</h2></div>
  <section class="car-section">
    <div class="car-grid">
              <?php
          $sql = "SELECT * FROM vehical ORDER BY RAND() LIMIT 4";
          $result = mysqli_query($con,$sql);
          while($row = mysqli_fetch_assoc($result)) {
        ?>
      <div class="car-card">
        <img src="/car_rental/admin/assets/images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
        <div class="card-body">
            <h3><?php echo $row['name']; ?></h3>
          <div class="d-flex justify-content-between align-items-center">
            <div class="price">₹<?php echo $row['price']; ?> / day</div>
            <a href="user/pages/book_rent.php?id=<?php echo $row['id']; ?>"><button class="rent-btn">Rent Now</button></a>
          </div>
        </div>
      </div>
        <?php } ?>
    </div>
  </section>

  <!-- PERFECT BUDGET -->
  <div class="heading"><h2>PERFECT BUDGET</h2></div>
  <section class="two-column-section container">
    <div class="image-side">
      <video controls poster="user/assets/images/car1.jpg">
        <source src="user/assets/images/thumbnail.mp4" type="video/mp4">
      </video>
    </div>
    <div class="content-side">
      <h2>Get A Fair Price For Your Car Booking</h2>
      <p>We are committed to providing our customers with exceptional service, competitive pricing, and a wide range of vehicles to suit any budget.</p>
      <ul class="checklist">
        <li>We are the UK’s largest provider, with more patrols in more places</li>
        <li>You get 24/7 roadside assistance</li>
        <li>We fix 4 out of 5 cars at the roadside</li>
      </ul>
      <button class="btn btn-gold mt-3">Get started <i class="fa-solid fa-arrow-right ms-2"></i></button>
    </div>
  </section>

  <!-- ONLINE EVERYWHERE -->
  <div class="heading"><h2>ONLINE EVERYWHERE</h2></div>
  <section class="two-column-section container">
    <div class="content-side">
      <h2>Online, in-person, everywhere</h2>
      <p>Choose from thousands of vehicles from multiple brands and buy online with Click & Drive, or visit us at one of our dealerships today.</p>
      <a href="user/pages/book_rent.php" class="btn log">Get started <i class="fa-solid fa-arrow-right ms-2"></i></a>
    </div>
    <div class="image-side">
      <img src="user/assets/images/online_inperson .jpg" alt="Online & in-person">
    </div>
  </section>

  <!-- RECOMMENDED -->
  <div class="heading" id="recomended"><h2>RECOMENDED CAR FOR YOU</h2></div>
  <div class="container py-5">
    <div class="row g-4">
          <?php
          $sql = "SELECT * FROM vehical ORDER BY RAND() LIMIT 4";
          $result = mysqli_query($con,$sql);
          while($row = mysqli_fetch_assoc($result)) {
        ?>
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card shadow-sm rounded-4 h-100 recomended position-relative">
          <img src="/car_rental/admin/assets/images/<?php echo $row['image']; ?>" class="car-img" alt="<?php echo $row['name']; ?>">
          <div class="card-body d-flex flex-column">
            <h5 class="fw-semibold"><?php echo $row['name']; ?></h5>
            <div class="d-flex justify-content-between small text-muted mb-3">
            </div>
            <div class="mb-2">
              <span class="fw-bold fs-6">₹<?php echo $row['price']; ?>/day</span>
            </div>
            <a href="user/pages/book_rent.php" class="mt-auto log">View Details →</a>
          </div>
        </div>
      </div>
        <?php } ?>
    </div>
  </div>

  <!-- WHY CHOOSE US -->
  <div class="heading"><h2>WHY CHOOSE US</h2></div>
  <section class="why-choose-us">
    <div class="features container">
      <div class="feature-card">
        <i class="fas fa-dollar-sign"></i>
        <h3>Affordable Rates</h3>
        <p>Get the best value for your money with our competitive pricing.</p>
      </div>
      <div class="feature-card">
        <i class="fas fa-car"></i>
        <h3>Wide Range of Cars</h3>
        <p>Choose from SUVs, sedans, hatchbacks, and luxury vehicles.</p>
      </div>
      <div class="feature-card">
        <i class="fas fa-headset"></i>
        <h3>24/7 Support</h3>
        <p>We’re here for you anytime, anywhere during your rental.</p>
      </div>
      <div class="feature-card">
        <i class="fas fa-shield-alt"></i>
        <h3>Safe & Secure</h3>
        <p>Our cars are well-maintained and safety checked regularly.</p>
      </div>
    </div>
  </section>

  <!-- COUNTER -->
  <div class="counter">
    <div class="stat"><h2 data-target="450">0</h2><p>Cars For Rent</p></div>
    <div class="stat"><h2 data-target="800">0</h2><p>Happy Clients</p></div>
    <div class="stat"><h2 data-target="750">0</h2><p>Rental Locations</p></div>
  </div>
<?php include("user/includes/footer.php");  ?>
  