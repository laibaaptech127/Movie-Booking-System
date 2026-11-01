<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
?>
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
  <title>CinePulse Admin | Dashboard Overview</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body style="background:#080c14;">
  <div class="admin-layout-wrapper">
      <div class="admin-sidebar">
    <a class="brand-logo text-white mb-3" href="index.php">
      <div class="brand-icon"><i class="fa-solid fa-film"></i></div>
      <span>Cine<span class="text-brand">Pulse</span></span>
    </a>
    <div class="badge-pill-custom badge-gold mb-3"><i class="fa-solid fa-shield-halved"></i> Admin Control Panel</div>

    <ul class="nav flex-column admin-sidebar-nav mb-auto">
      <li class="nav-item"><a class="nav-link active" href="index.php"><i class="fa-solid fa-chart-pie"></i> Overview Dashboard</a></li>
      <li class="nav-item"><a class="nav-link " href="theaters.php"><i class="fa-solid fa-building"></i> Manage Theaters</a></li>
      <li class="nav-item"><a class="nav-link " href="movie.php"><i class="fa-solid fa-film"></i> Manage Movies</a></li>
      <li class="nav-item"><a class="nav-link " href="seat.php"><i class="fa-solid fa-film"></i> Manage Seats</a></li>
      <li class="nav-item"><a class="nav-link " href="shows.php"><i class="fa-solid fa-clock"></i> Shows & Pricing </a></li>
      <li class="nav-item"><a class="nav-link " href="booking.php"><i class="fa-solid fa-receipt"></i> Bookings Audit</a></li>
      <li class="nav-item"><a class="nav-link " href="payment.php"><i class="fa-solid fa-receipt"></i> Payments</a></li>
      <li class="nav-item"><a class="nav-link " href="users.php"><i class="fa-solid fa-users"></i> Registered Users</a></li>
      <li class="nav-item"><a href="role.php" class="nav-link"><i class="fa-solid fa-user-shield"></i><span>Manage Roles</span></a></li>
    </ul>
  </div>