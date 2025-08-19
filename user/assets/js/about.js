
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
