<?php include("includes/topbar.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Contact Us — DriveEasy Rentals</title>

<!-- Fonts & Icons -->
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<link rel="stylesheet" href="assets/css/contact_us.css">
</head>
<body>

<!-- =======================
     HERO
     ======================= -->
<section class="hero_contact">
  <div class="hero-inner container">
    <h1 class="hero-title">Contact <span style="color:var(--gold-2)">Car Rentals</span></h1>
    <p class="hero-sub">Luxury fleet. White-glove service. Talk to our team for bookings, billing, corporate accounts or tailored experiences.</p>
    <div class="cta-row">
      <a href="#contact" class="btn btn-gold"><i class="fa-solid fa-paper-plane"></i>&nbsp;Send a Message</a>
      <a href="tel:+1234567890" class="btn btn-ghost"><i class="fa-solid fa-phone"></i>&nbsp;Call Us</a>
    </div>
  </div>
</section>

<!-- =======================
     FEATURES — Expanded
     ======================= -->
<section class="features">
  <div class="container">
    <h2 class="section-title">Why Choose Car Rentals</h2>

    <div class="features-grid">
      <article class="feature-card">
        <div class="feature-icon"><i class="fa-solid fa-car"></i></div>
        <div class="feature-title">Luxury Fleet</div>
        <div class="feature-text">Flagship sedans, SUVs & convertibles from top marques — impeccably maintained.</div>
      </article>

      <article class="feature-card">
        <div class="feature-icon"><i class="fa-solid fa-star"></i></div>
        <div class="feature-title">5-Star Service</div>
        <div class="feature-text">Concierge pickup, priority delivery & flexible return windows.</div>
      </article>

      <article class="feature-card">
        <div class="feature-icon"><i class="fa-solid fa-shield-halved"></i></div>
        <div class="feature-title">Fully Insured</div>
        <div class="feature-text">Comprehensive cover & proactive maintenance for peace of mind.</div>
      </article>

      <article class="feature-card">
        <div class="feature-icon"><i class="fa-solid fa-rotate"></i></div>
        <div class="feature-title">Instant Upgrades</div>
        <div class="feature-text">Real-time upgrades & extensions from your phone.</div>
      </article>

      <article class="feature-card">
        <div class="feature-icon"><i class="fa-solid fa-headset"></i></div>
        <div class="feature-title">24/7 Support</div>
        <div class="feature-text">Always-on assistance & roadside support when you need it.</div>
      </article>
    </div>

    <!-- subtle trust chips -->
    <div class="badges">
      <span class="chip"><i class="fa-regular fa-circle-check"></i> ISO-grade cleaning</span>
      <span class="chip"><i class="fa-regular fa-clock"></i> Flexible hourly/day rates</span>
      <span class="chip"><i class="fa-solid fa-leaf"></i> Eco & hybrid lineup</span>
    </div>
  </div>
</section>

<!-- =======================
     CONTACT SPLIT (smaller form)
     ======================= -->
<section id="contact" class="contact-wrap">
  <div class="container contact-split">

    <!-- Info -->
    <aside class="info-panel">
      <h3>Get in Touch</h3>

      <div class="info-item">
        <i class="fa-solid fa-envelope"></i>
        <div><strong>Email</strong><span>support@driveeasy.com</span></div>
      </div>

      <div class="info-item">
        <i class="fa-solid fa-phone"></i>
        <div><strong>Phone</strong><span>+1 (234) 567-890</span></div>
      </div>

      <div class="info-item">
        <i class="fa-solid fa-building"></i>
        <div>
          <strong>Office</strong>
          <span>45 Sunset Blvd, Los Angeles, CA</span>
        </div>
      </div>

      <div class="info-item">
        <i class="fa-solid fa-clock"></i>
        <div><strong>Hours</strong><span>Mon–Sun: 7:00 AM – 10:00 PM</span></div>
      </div>

      <div class="info-item">
        <i class="fa-solid fa-location-crosshairs"></i>
        <div><strong>Coverage</strong><span>LA, Orange County, Santa Monica, LAX</span></div>
      </div>

      <div class="socials">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-x-twitter"></i></a>
        <a href="#"><i class="fab fa-whatsapp"></i></a>
      </div>
    </aside>

    <!-- Form (narrow & elegant) -->
    <section class="form-panel" aria-label="Contact form">
      <h3>Send us a Message</h3>
      <form class="form" action="#" method="post" novalidate>
        <div class="form-row">
          <label class="input">
            <i class="fa-regular fa-user"></i>
            <input class="field" type="text" name="name" placeholder="Full name" required>
          </label>
          <label class="input">
            <i class="fa-regular fa-envelope"></i>
            <input class="field" type="email" name="email" placeholder="Email address" required>
          </label>
        </div>

        <div class="form-row">
          <label class="input">
            <i class="fa-solid fa-phone"></i>
            <input class="field" type="tel" name="phone" placeholder="Phone (optional)">
          </label>
          <label class="input">
            <i class="fa-solid fa-car-side"></i>
            <input class="field" type="text" name="car" placeholder="Preferred car / model">
          </label>
        </div>

        <label class="input">
          <i class="fa-regular fa-message"></i>
          <textarea class="field textarea" name="message" placeholder="Tell us about your trip, dates & pickup preference…" required></textarea>
        </label>

        <div class="btn-row">
          <button type="submit" class="btn-submit"><i class="fa-solid fa-paper-plane"></i>&nbsp;Send Message</button>
          <a class="btn-outline" href="https://wa.me/7866846668" target="_blank"><i class="fa-brands fa-whatsapp"></i>&nbsp;WhatsApp</a>
        </div>
        <p class="note"><i class="fa-regular fa-circle-check" style="color:var(--success)"></i> We typically respond within 15 minutes during business hours.</p>
      </form>
    </section>

  </div>
</section>

<!-- =======================
     FULL-WIDTH MAP (responsive)
     ======================= -->
<section class="map-section" aria-label="Map & directions">
  <iframe class="map-embed"
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3682.8715622386308!2d88.4648447!3d22.6212709!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f89fe42b4892fd%3A0x8565fde6341d4d83!2sTravarsa%20Private%20Limited!5e0!3m2!1sen!2sin!4v1755078931775!5m2!1sen!2sin"
    loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>

  <div class="container">
    <div class="map-card">
      <h4>Lounge & Pickup</h4>
      <div class="map-row"><i class="fa-solid fa-location-dot"></i><span>45 Sunset Blvd, Los Angeles, CA</span></div>
      <div class="map-row"><i class="fa-solid fa-clock"></i><span>Open daily • 7:00 AM – 10:00 PM</span></div>
      <div class="map-actions">
        <a class="btn-mini" href="https://maps.google.com/?q=45+Sunset+Blvd+Los+Angeles+CA" target="_blank"><i class="fa-solid fa-map"></i>&nbsp;Open Maps</a>
        <a class="btn-mini" href="tel:+1234567890"><i class="fa-solid fa-phone"></i>&nbsp;Call</a>
      </div>
    </div>
  </div>
</section>

<!-- =======================
     FAQ (more content without JS)
     ======================= -->
<section class="faq">
  <div class="container faq-wrap">
    <h2 class="section-title">Frequently Asked Questions</h2>

    <details>
      <summary><i class="fa-regular fa-circle-question"></i> What documents do I need to rent?</summary>
      <p>Valid driver’s license, primary credit card, and a government-issued ID. International renters may need an IDP.</p>
    </details>

    <details>
      <summary><i class="fa-regular fa-circle-question"></i> Do you deliver to airports or hotels?</summary>
      <p>Yes — complimentary delivery to select hotels and premium curbside handoff at major airports.</p>
    </details>

    <details>
      <summary><i class="fa-regular fa-circle-question"></i> Can I add a chauffeur?</summary>
      <p>Absolutely. Choose a chauffeur at booking or mention it in your message and we’ll arrange it.</p>
    </details>
  </div>
</section>
<?php include("includes/footer.php"); ?>
</body>
</html>
