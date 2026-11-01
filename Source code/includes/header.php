
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CinePulse | Next-Gen Movie Ticket Booking</title>
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23ff1e27'><path d='M18 4l2 4h-3l-2-4h-2l2 4h-3l-2-4H8l2 4H7L5 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V4h-4z'/></svg>">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <!-- Navigation Header -->
  <nav class="navbar navbar-expand-lg fixed-top glass-nav navbar-cinepulse">
    <div class="container">
      <a class="navbar-brand brand-logo text-white" href="index.php">
        <div class="brand-icon"><i class="fa-solid fa-film"></i></div>
        <span>Cine<span class="text-warning">Pulse</span></span>
      </a>

      <button class="navbar-toggler btn-close-cinema border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
        <i class="fa-solid fa-bars text-white fs-3"></i>
      </button>

      <div class="collapse navbar-collapse" id="navbarMain">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link active" href="index.php"><center><i class="fa-solid fa-house-chimney me-1 small"></i></center> Home</a></li>
          <li class="nav-item"><a class="nav-link" href="movie.php"><center><i class="fa-solid fa-clapperboard me-1 small"></i></center> Movies</a></li>
          <li class="nav-item"><a class="nav-link" href="book.php"><center><i class="fa-solid fa-couch me-1 small"></i></center> Booking</a></li>
          <li class="nav-item"><a class="nav-link" href="theaters.php"><center><i class="fa-solid fa-building-columns me-1 small"></i></center> Theaters</a></li>
          <li class="nav-item"><a class="nav-link" href="pricing.php"><center><i class="fa-solid fa-tags me-1 small"></i></center> Pricing</a></li>
          <li class="nav-item"><a class="nav-link" href="about.php"><center><i class="fa-solid fa-circle-info me-1 small"></i></center> About</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.php"><center><i class="fa-solid fa-envelope me-1 small"></i></center> Contact</a></li>
        </ul>

        <!-- Action Buttons (Login / Register / Logout) -->
        <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
          <?php if (isset($_SESSION['user_id']) || isset($_SESSION['username']) || isset($_SESSION['role_id'])): ?>
            
            <!-- User Logged In hai toh Username & Logout Button dikhega -->
            <?php if (isset($_SESSION['username'])): ?>
              <span class="text-light small fw-bold me-2">
                <i class="fa-solid fa-user me-1 text-warning"></i> <?= htmlspecialchars($_SESSION['username']) ?>
              </span>
            <?php endif; ?>

            <a class="btn btn-outline-danger btn-sm fw-bold fs-6 py-2 px-3 rounded-3" href="logout.php">
              <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
            </a>

          <?php else: ?>

            <!-- User Logged Out hai toh Login & Register Button dikhenge -->
            <a class="btn btn-outline-warning btn-sm fw-bold fs-6 py-2 px-3 rounded-3" href="login.php">
              <i class="fa-solid fa-right-to-bracket me-1"></i> Login
            </a>
            <a class="btn btn-warning btn-sm fw-bold fs-6 py-2 px-3 text-dark rounded-3" href="register.php">
              <i class="fa-solid fa-user-plus me-1"></i> Register
            </a>

          <?php endif; ?>
        </div>

      </div>
    </div>
  </nav>