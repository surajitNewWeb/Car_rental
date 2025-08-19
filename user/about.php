<?php include("includes/topbar.php"); ?>
<?php include("config/db.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About Us - Car Rental</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;700&family=DM+Sans:wght@400;500;700&display=swap"
    rel="stylesheet">
  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <!-- about css -->
  <link rel="stylesheet" href="assets/css/about.css">
</head>

<body>

  <!-- Hero Section -->
  <section class="hero-fullwidth">
    <div class="hero-content">
      <h1>About CarRental</h1>
      <p>Providing premium vehicles, exceptional service, and unforgettable journeys. Our mission is to make every trip
        smooth, safe, and luxurious.</p>
      <div class="hero-buttons">
        <a href="pages/vehical.php" class="btn-primary">Explore Fleet</a>
        <a href="contact.php" class="btn-secondary">Contact Us</a>
      </div>
    </div>
  </section>

  <!-- About Us -->
  <section>
    <div class="heading">
      <h2>About Us</h2>
    </div>
    <div style="display: flex; flex-wrap: wrap; gap: 2rem; align-items: center; justify-content: center;">
      <div style="flex:1; min-width: 280px;">
        <p>
          At CarRental, we offer top-quality rental vehicles with exceptional service, ensuring comfort, safety, and
          affordability for every journey.
        </p>
      </div>
      <div style="flex:1; min-width: 280px;">
        <img src="assets/images/contact.jpg" alt="About CarRental"
          style="width:100%; border-radius:15px; box-shadow:0 10px 30px rgba(0,0,0,0.4);">
      </div>
    </div>
  </section>

  <!-- Our Mission Section -->
  <section>
    <div class="heading">
      <h2>Our Mission</h2>
    </div>
    <div style="display: flex; flex-wrap: wrap; gap: 2rem; align-items: center; justify-content: center;">
      <div style="flex:1; min-width: 280px;">
        <img src="assets/images/about-us.jpg" alt="Our Mission"
          style="width:100%; border-radius:15px; box-shadow:0 10px 30px rgba(0,0,0,0.4);">
      </div>
      <div style="flex:1; min-width: 280px;">
        <p>
          Our mission is to make premium travel experiences accessible for everyone. Whether it’s a short weekend
          getaway or a long road trip, we ensure your journey is memorable, affordable, and stress-free.
        </p>
      </div>
    </div>
  </section>

  <!-- Fleet Showcase -->
  <section>
    <div class="heading">
      <h2>Our Fleet</h2>
    </div>

    <div class="fleet-container">
         <?php
          $sql = "SELECT * FROM vehical ORDER BY RAND() LIMIT 3";
          $result = mysqli_query($con,$sql);
          while($row = mysqli_fetch_assoc($result)) {
        ?>
      <div class="fleet-card">
        <img src="/car_rental/admin/assets/images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
        <div class="car-title"><?php echo $row['name']; ?></div>
        <div class="car-type"><?php echo $row['type']; ?></div>
        <div class="car-specs">
          <span><i class="fa-solid fa-gears"></i><?php echo $row['transmission']; ?></span>
          <span><i class="fa-solid fa-signal"></i><?php echo $row['status']; ?></span>
            <span><i class="fa-solid fa-user-group"></i><?php echo $row['seats']; ?></span>
            <span><i class="fa-solid fa-snowflake"></i></i>₹<?php echo $row['price']; ?>/day</span>
        </div>
        <a href="pages/vehical.php" class="view-btn">View Details</a>
      </div>
     <?php } ?>
    </div>
  </section>

  <!-- Why Choose Us -->
  <section>
    <div class="heading">
      <h2>Why Choose Us</h2>
    </div>
    <div class="choose-container">
      <div class="choose-card">
        <i class="fas fa-car fa-2x" style="color: var(--accent);"></i>
        <h3>Wide Range of Vehicles</h3>
        <p>From economy to luxury cars, we have the perfect ride for every occasion.</p>
      </div>
      <div class="choose-card">
        <i class="fas fa-hand-holding-usd fa-2x" style="color: var(--accent);"></i>
        <h3>Affordable Prices</h3>
        <p>Competitive rates with no hidden charges.</p>
      </div>
      <div class="choose-card">
        <i class="fas fa-headset fa-2x" style="color: var(--accent);"></i>
        <h3>24/7 Customer Support</h3>
        <p>We’re always here to help you with your booking and travel needs.</p>
      </div>
    </div>
  </section>

  <!-- Feedback -->
  <section>
    <div class="heading">
      <h2>Customer Feedback</h2>
    </div>
    <div class="feedback-container">
      <div class="feedback-card">
        <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="">
        <h3>Sneha Patel</h3>
        <div class="stars">★★★★★</div>
        <p>Excellent service and clean cars. Highly recommend!</p>
      </div>
      <div class="feedback-card">
        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="">
        <h3>Rahul Verma</h3>
        <div class="stars">★★★★★</div>
        <p>Fantastic service and very friendly staff. Highly recommended!</p>
      </div>
      <div class="feedback-card">
        <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="">
        <h3>Ananya Singh</h3>
        <div class="stars">★★★★☆</div>
        <p>Great experience overall. The pickup and drop-off process was smooth.</p>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <?php include("includes/footer.php"); ?>

  <script>
    // Scroll animations
    const animatedEls = document.querySelectorAll('.hero-inner, .choose-card, .team-card, .feedback-card, .fleet-card');
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('show');
        }
      });
    }, { threshold: 0.2 });

    animatedEls.forEach(el => observer.observe(el));
  </script>

</body>

</html>