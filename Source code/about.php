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
<div class="page-content-wrapper text-white bg-dark min-vh-100">
  <div class="page-banner text-center py-5 bg-secondary bg-opacity-10 border-bottom border-secondary border-opacity-25">
    <div class="container">
      <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold text-uppercase mb-2">Our Vision & Mission</span>
      <h1 class="display-5 fw-bold text-white mb-2">About CinePulse</h1>
      <p class="text-light opacity-75 mb-0">Pioneering cinematic innovation, luxury comfort, and seamless ticket reservation.</p>
    </div>
  </div>

  <div class="container py-5">
    <div class="row g-5 align-items-center mb-5">
      <div class="col-lg-6">
        <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill fw-semibold mb-3 border border-warning border-opacity-25">
          <i class="fa-solid fa-film me-1"></i> Cinematic Excellence
        </span>
        <h2 class="text-white fw-bold mb-3 display-6">Revolutionizing The Big Screen Experience</h2>
        <p class="text-light opacity-75 mb-3 leading-relaxed">
          Founded with a passion for film, CinePulse was created to eliminate the friction of physical ticketing while enhancing the grandeur of movie theaters.
        </p>
        <p class="text-light opacity-75 mb-4 leading-relaxed">
          We partner with leading theater chains to deliver RGB laser projection, multi-channel Dolby Atmos sound, 4DX atmospheric simulation, and three distinct seat tiers engineered for optimal eye-level viewing.
        </p>
        
        <div class="row g-3">
          <div class="col-6">
            <div class="p-3 glass-card-amber">
              <div class="fs-3 fw-bold text-warning">50+</div>
              <div class="small text-light opacity-75">Auditoriums Nationally</div>
            </div>
          </div>
          <div class="col-6">
            <div class="p-3 glass-card-amber">
              <div class="fs-3 fw-bold text-warning">1M+</div>
              <div class="small text-light opacity-75">Tickets Issued Annually</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="position-relative">
          <img src="assets/images/hero2.avif" alt="Cinema Hall" class="img-fluid rounded-4 about-img-glow">
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .glass-card-amber {
    background: rgba(30, 41, 59, 0.7);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(245, 158, 11, 0.2);
    border-radius: 16px;
    transition: transform 0.3s ease, border-color 0.3s ease;
  }
  
  .glass-card-amber:hover {
    transform: translateY(-4px);
    border-color: rgba(245, 158, 11, 0.5);
  }

  .about-img-glow {
    border: 2px solid rgba(245, 158, 11, 0.25);
    box-shadow: 0 15px 35px rgba(245, 158, 11, 0.15);
  }
</style>
<?php include_once "includes/footer.php"; ?>