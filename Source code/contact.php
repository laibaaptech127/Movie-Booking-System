<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<?php
include_once "includes/header.php";
include_once "includes/db.php";
?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) && !isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<style>
  .glass-card-contact {
    background: rgba(30, 41, 59, 0.7);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(245, 158, 11, 0.2);
    border-radius: 16px;
  }

  .icon-box-warning {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
  }

  .form-control-amber {
    background-color: rgba(15, 23, 42, 0.6) !important;
    border: 1px solid rgba(255, 255, 255, 0.15) !important;
    color: #fff !important;
    border-radius: 10px !important;
    padding: 0.75rem 1rem !important;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
  }

  .form-control-amber:focus {
    border-color: #f59e0b !important;
    box-shadow: 0 0 0 0.25rem rgba(245, 158, 11, 0.25) !important;
  }

  .form-control-amber::placeholder {
    color: #94a3b8 !important;
  }
</style>

<div class="page-content-wrapper text-white bg-dark min-vh-100">
  <div class="page-banner text-center py-5 bg-secondary bg-opacity-10 border-bottom border-secondary border-opacity-25">
    <div class="container">
      <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold text-uppercase mb-2">
        <i class="fa-solid fa-headset me-1"></i> 24/7 Concierge
      </span>
      <h1 class="display-5 fw-bold text-white mb-2">Get in Touch</h1>
      <p class="text-light opacity-75 mb-0">Have questions regarding tickets, private cinema bookings, or corporate packages?</p>
    </div>
  </div>

  <div class="container py-5">
    <div class="row g-4">
      <!-- Contact Info Section -->
      <div class="col-lg-5">
        <div class="glass-card-contact p-4 p-md-5 h-100 d-flex flex-column justify-content-between">
          <div>
            <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill fw-semibold mb-3 border border-warning border-opacity-25">
              Contact Details
            </span>
            <h4 class="text-white fw-bold mb-4">Contact Information</h4>

            <div class="d-flex align-items-center gap-3 mb-4">
              <div class="icon-box-warning bg-warning text-dark">
                <i class="fa-solid fa-location-dot"></i>
              </div>
              <div>
                <div class="text-warning fw-bold small text-uppercase">Headquarters</div>
                <div class="text-light">CinePulse Towers, Tech Boulevard, Metropolis</div>
              </div>
            </div>

            <div class="d-flex align-items-center gap-3 mb-4">
              <div class="icon-box-warning bg-warning text-dark">
                <i class="fa-solid fa-phone"></i>
              </div>
              <div>
                <div class="text-warning fw-bold small text-uppercase">Customer Helpline</div>
                <div class="text-light">+1 (800) 555-CINE (24/7)</div>
              </div>
            </div>

            <div class="d-flex align-items-center gap-3 mb-4">
              <div class="icon-box-warning bg-warning text-dark">
                <i class="fa-solid fa-envelope"></i>
              </div>
              <div>
                <div class="text-warning fw-bold small text-uppercase">Support Email</div>
                <div class="text-light">support@cinepulse.io</div>
              </div>
            </div>
          </div>

          <div class="p-3 rounded-3 bg-warning bg-opacity-10 border border-warning border-opacity-25 mt-4">
            <div class="d-flex align-items-center gap-2 text-warning fw-bold mb-1">
              <i class="fa-solid fa-clock"></i> Response Time
            </div>
            <p class="small text-light opacity-75 mb-0">Our support team usually responds to inquiries within 1-2 business hours.</p>
          </div>
        </div>
      </div>

      <!-- Form Section -->
      <div class="col-lg-7">
        <div class="glass-card-contact p-4 p-md-5">
          <h4 class="text-white fw-bold mb-1">Send Us a Message</h4>
          <p class="text-light opacity-75 small mb-4">Fill out the form below and we'll get back to you shortly.</p>

          <form onsubmit="event.preventDefault(); app.showToast('Thank you! Your message has been sent to support.', 'success'); this.reset();">
            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label class="form-label text-light small fw-semibold">Your Name:</label>
                <input type="text" class="form-control form-control-amber" placeholder="Alex Johnson" required>
              </div>
              <div class="col-md-6">
                <label class="form-label text-light small fw-semibold">Email Address:</label>
                <input type="email" class="form-control form-control-amber" placeholder="alex@gmail.com" required>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label text-light small fw-semibold">Subject / Inquiry Type:</label>
              <input type="text" class="form-control form-control-amber" placeholder="Booking Issue / Refund / Private Screen Booking" required>
            </div>

            <div class="mb-4">
              <label class="form-label text-light small fw-semibold">Message:</label>
              <textarea class="form-control form-control-amber" rows="4" placeholder="How can our support team assist you today?" required></textarea>
            </div>

            <button type="submit" class="btn btn-warning w-100 py-3 fw-bold text-dark rounded-3">
              <i class="fa-solid fa-paper-plane me-2"></i> Send Message
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once "includes/footer.php"; ?>