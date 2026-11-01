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
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) && !isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<?php
include_once "includes/header.php";
include_once "includes/db.php";
?>

<style>
  .pricing-tier-card {
    background: rgba(30, 41, 59, 0.7);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    padding: 2rem;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .pricing-tier-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(245, 158, 11, 0.2);
  }

  .featured-tier {
    border: 2px solid #f59e0b;
    background: rgba(245, 158, 11, 0.05);
    position: relative;
  }

  .pricing-icon-wrap {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 1rem;
  }

  .pricing-price-tag {
    font-size: 2.5rem;
    font-weight: 800;
    margin: 1rem 0;
  }

  .pricing-price-tag .currency {
    font-size: 1.5rem;
    vertical-align: super;
  }

  .pricing-price-tag .period {
    font-size: 0.9rem;
    color: #94a3b8;
    font-weight: 400;
  }

  .pricing-feature-list {
    list-style: none;
    padding: 0;
    margin: 1.5rem 0;
  }

  .pricing-feature-list li {
    margin-bottom: 0.75rem;
    color: #e2e8f0;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .glassmorphism {
    background: rgba(30, 41, 59, 0.7);
    backdrop-filter: blur(12px);
  }
</style>

<div class="page-content-wrapper text-white bg-dark min-vh-100">
  <div class="page-banner text-center py-5 bg-secondary bg-opacity-10 border-bottom border-secondary border-opacity-25">
    <div class="container">
      <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold text-uppercase mb-2">Transparent Pricing System</span>
      <h1 class="display-5 fw-bold text-white mb-2">Cinema Ticket Rates & Tiers</h1>
      <p class="text-light opacity-75 mb-0">Experience transparent rates, premium amenities, and family concessions.</p>
    </div>
  </div>

  <div class="container py-5">
    <!-- 3 Tier Cards -->
    <div class="row g-4 mb-5">
      <!-- Gold Class -->
      <div class="col-lg-4">
        <div class="pricing-tier-card">
          <div>
            <div class="pricing-icon-wrap bg-warning text-dark"><i class="fa-solid fa-medal"></i></div>
            <h4 class="text-white fw-bold">Gold Class</h4>
            <p class="text-light opacity-75 small">Standard luxury plush seating with crystal clear stereo surround audio.</p>
            <div class="pricing-price-tag text-warning">
              <span class="currency">$</span>12<span class="period">/ ticket</span>
            </div>
            <ul class="pricing-feature-list">
              <li><i class="fa-solid fa-circle-check text-warning"></i> High-resilience cushioned seats</li>
              <li><i class="fa-solid fa-circle-check text-warning"></i> Front & Middle auditorium rows (F-J)</li>
              <li><i class="fa-solid fa-circle-check text-warning"></i> 20% Kids Special Concession valid</li>
              <li class="text-white"><i class="fa-solid fa-circle-xmark opacity-50"></i> Motorized recliners</li>
            </ul>
          </div>
          <a href="book.php" class="btn btn-outline-warning w-100 py-3 fw-bold rounded-3">Book Gold Class</a>
        </div>
      </div>

      <!-- Platinum Class -->
      <div class="col-lg-4">
        <div class="pricing-tier-card featured-tier">
          <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-3 px-3 py-2 rounded-pill fw-bold">Most Popular</span>
          <div>
            <div class="pricing-icon-wrap bg-warning text-dark"><i class="fa-solid fa-gem"></i></div>
            <h4 class="text-white fw-bold">Platinum VIP</h4>
            <p class="text-light opacity-75 small">Prime center auditorium sweet spot with semi-recliners & Dolby Atmos.</p>
            <div class="pricing-price-tag text-warning">
              <span class="currency">$</span>18<span class="period">/ ticket</span>
            </div>
            <ul class="pricing-feature-list">
              <li><i class="fa-solid fa-circle-check text-warning"></i> Center rows (C-E) sweet-spot alignment</li>
              <li><i class="fa-solid fa-circle-check text-warning"></i> Ergonomic semi-reclining leather seats</li>
              <li><i class="fa-solid fa-circle-check text-warning"></i> 20% Kids Special Concession valid</li>
              <li><i class="fa-solid fa-circle-check text-warning"></i> Priority express snack counter line</li>
            </ul>
          </div>
          <a href="book.php" class="btn btn-warning w-100 py-3 fw-bold text-dark rounded-3">Book Platinum VIP</a>
        </div>
      </div>

      <!-- VIP Box Class -->
      <div class="col-lg-4">
        <div class="pricing-tier-card">
          <div>
            <div class="pricing-icon-wrap bg-warning text-dark"><i class="fa-solid fa-crown"></i></div>
            <h4 class="text-white fw-bold">VIP Luxury Box</h4>
            <p class="text-light opacity-75 small">Motorized sofa recliners, blanket service, and in-seat gourmet dining.</p>
            <div class="pricing-price-tag text-warning">
              <span class="currency">$</span>25<span class="period">/ ticket</span>
            </div>
            <ul class="pricing-feature-list">
              <li><i class="fa-solid fa-circle-check text-warning"></i> Full motorized leather sofa recliners (A-B)</li>
              <li><i class="fa-solid fa-circle-check text-warning"></i> In-seat butler & gourmet dining service</li>
              <li><i class="fa-solid fa-circle-check text-warning"></i> Exclusive VIP Lounge access with free coffee</li>
              <li><i class="fa-solid fa-circle-check text-warning"></i> USB fast-charging ports on armrest</li>
            </ul>
          </div>
          <a href="book.php" class="btn btn-warning w-100 py-3 fw-bold text-dark rounded-3">Book VIP Box</a>
        </div>
      </div>
    </div>

    <!-- Concession & Discount Policies Box -->
    <div class="glassmorphism p-4 p-md-5 rounded-4 border border-secondary border-opacity-25">
      <div class="row g-4 align-items-center">
        <div class="col-lg-8">
          <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-2"><i class="fa-solid fa-child me-1"></i> Special Family Privilege</span>
          <h3 class="text-white fw-bold mb-2">Kids Special Concession (20% Off)</h3>
          <p class="text-light opacity-75 mb-0">
            Children aged 3 to 12 years automatically receive a <strong class="text-warning">20% discount</strong> on all seat classes when toggling the Kids Concession switch during seat booking checkout.
          </p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <a href="book.php" class="btn btn-warning btn-lg fw-bold text-dark rounded-3 px-4 py-3"><i class="fa-solid fa-ticket me-2"></i> Book With Discount</a>
        </div>
      </div>
    </div>

  </div>
</div>
<?php include_once "includes/footer.php"; ?>