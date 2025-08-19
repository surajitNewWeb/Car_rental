   
    // Counter animation
    document.querySelectorAll('.stat h2').forEach(el=>{
      const target = +el.dataset.target;
      let current = 0;
      const increment = Math.max(1, Math.floor(target/120));
      const timer = setInterval(()=>{
        current += increment;
        if(current >= target){ el.textContent = target; clearInterval(timer); }
        else el.textContent = current;
      }, 12);
    });

    // Simple scroll reveal using IntersectionObserver
    const io = new IntersectionObserver((entries)=>{
      entries.forEach(e=>{
        if(e.isIntersecting){
          e.target.style.transition = 'transform .6s ease, opacity .6s ease';
          e.target.style.transform = 'translateY(0)';
          e.target.style.opacity = 1;
          io.unobserve(e.target);
        }
      });
    }, {threshold: 0.12});

    // apply to key blocks
    document.querySelectorAll('.car-card, .feature-card, .recomended, .two-column-section, .hero-card').forEach(n=>{
      n.style.transform = 'translateY(18px)';
      n.style.opacity = 0;
      io.observe(n);
    });

    // small UX: open mobile nav when clicking search icon (if collapsed)
    document.querySelectorAll('.search-btn').forEach(b=>{
      b.addEventListener('click', ()=>{/* placeholder for search action */});
    });

    // optional: prevent form default for demo
    document.getElementById('carBookingForm').addEventListener('submit', function(e){
      e.preventDefault();
      alert('Booking demo — form submitted (demo)');
    });
  