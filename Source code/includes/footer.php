  <!-- Footer -->
  <footer class="footer-section">
    <div class="container">
      <div class="row g-4 pb-5 border-bottom border-glass">
        <div class="col-lg-4 col-md-6">
          <a class="brand-logo text-white mb-3 d-inline-flex" href="index.html">
            <div class="brand-icon"><i class="fa-solid fa-film"></i></div>
            <span>Cine<span class="text-warning">Pulse</span></span>
          </a>
          <p class="text-muted-custom small mb-4">
            CinePulse is the premier next-generation online cinema ticket booking platform. Experience laser IMAX projection, Dolby Atmos acoustics, luxury recliners, and instant e-ticketing.
          </p>
          <div class="d-flex gap-2">
            <a href="#" class="social-icon-btn"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#" class="social-icon-btn"><i class="fa-brands fa-x-twitter"></i></a>
            <a href="#" class="social-icon-btn"><i class="fa-brands fa-instagram"></i></a>
            <a href="#" class="social-icon-btn"><i class="fa-brands fa-youtube"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-6">
          <h6 class="text-white fw-bold mb-3">Quick Links</h6>
          <ul class="list-unstyled small">
            <li><a href="index.html" class="footer-link">Home</a></li>
            <li><a href="movies.html" class="footer-link">Movies Catalog</a></li>
            <li><a href="booking.html" class="footer-link">Seat Booking</a></li>
            <li><a href="theaters.html" class="footer-link">Theaters & Venues</a></li>
            <li><a href="pricing.html" class="footer-link">Pricing Tiers</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-6">
          <h6 class="text-white fw-bold mb-3">Support & Info</h6>
          <ul class="list-unstyled small">
            <li><a href="about.html" class="footer-link">About CinePulse</a></li>
            <li><a href="contact.html" class="footer-link">Contact & Help</a></li>
            <li><a href="reviews.html" class="footer-link">User Reviews</a></li>
            <li><a href="login.html" class="footer-link">Member Sign In</a></li>
            <li><a href="register.html" class="footer-link">Join CinePulse Club</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-6">
          <h6 class="text-white fw-bold mb-3">Newsletter & Offers</h6>
          <p class="text-muted-custom small mb-3">Get VIP presale tickets, popcorn coupons, and film festival passes directly in your inbox.</p>
          <form onsubmit="event.preventDefault(); app.showToast('Subscribed to CinePulse Newsletter!', 'success'); this.reset();" class="d-flex gap-2">
            <input type="email" class="form-control form-control-cinema" placeholder="Your email address" required>
            <button type="submit" class="btn btn-warning fw-bold">Subscribe</button>
          </form>
        </div>
      </div>

      <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-4 small text-muted-custom">
        <div>&copy; 2026 CinePulse Inc. All Rights Reserved. eProject Production Frontend.</div>
        <div class="d-flex gap-3 mt-2 mt-md-0">
          <a href="#" class="text-muted-custom">Privacy Policy</a>
          <a href="#" class="text-muted-custom">Terms & Conditions</a>
          <a href="#" class="text-muted-custom">Ticket Refund Policy</a>
        </div>
      </div>
    </div>
  </footer>
  <div class="toast-container-custom" id="toastContainer"></div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/app.js"></script>
  <script type="text/javascript">
    // Page load hotay hi history push karo
    history.pushState(null, null, location.href);
    
    // Jab user Back button dabaye toh page reload ho
    window.onpopstate = function () {
        history.pushState(null, null, location.href);
        window.location.reload(); 
    };
</script>
  </body>
</html>