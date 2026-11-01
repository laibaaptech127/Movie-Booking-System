<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['role_id']) || (int)$_SESSION['role_id'] !== 1) {
    echo "<script>
            alert('Unauthorized Access!');
            window.location.href='../login.php';
          </script>";
    exit();
}
include_once "includes/db.php";
include_once "includes/header.php";
$query = "SELECT bookings.booking_id, users.user_name, movies.title, theaters.name AS theater_name, seats.seat_number, seats.category, shows.show_date, shows.show_time, bookings.booking_date, bookings.status 
          FROM bookings 
          JOIN users ON bookings.user_id = users.user_id 
          JOIN shows ON bookings.show_id = shows.id 
          JOIN movies ON shows.movie_id = movies.id 
          JOIN theaters ON shows.theater_id = theaters.id 
          JOIN seats ON bookings.seat_id = seats.id 
          ORDER BY bookings.booking_id DESC";
$bookings = mysqli_query($connect, $query);
$user_count_query = "SELECT COUNT(*) AS total_users FROM users";
$user_count_res = mysqli_query($connect, $user_count_query);
$user_data = mysqli_fetch_assoc($user_count_res);
$total_users = $user_data['total_users'] ?? 0;
?>
<div class="admin-main-content">
  <div class="admin-topbar">
    <div>
      <h4 class="text-white fw-bold mb-0">System Overview & Statistics</h4>
      <div class="text-white small">Real-time booking transactions, theaters, and member activity.</div>
    </div>
    <div class="d-flex align-items-center gap-3">
      <span class="badge-pill-custom badge-brand"><i class="fa-solid fa-circle text-danger me-1"></i> Production Live</span>
    </div>
  </div>

  <div class="row g-4 mb-4">
    <div class="col-lg-3 col-md-6">
      <div class="stat-card">
        <div class="stat-icon text-gold"><i class="fa-solid fa-users"></i></div>
        <div class="text-gold small fw-bold">REGISTERED USERS</div>
        <div class="display-6 fw-bold text-white" id="statTotalUsers"><?= $total_users ?></div>
        <div class="text-success small mt-2"><i class="fa-solid fa-arrow-trend-up"></i> Active Members</div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6">
      <div class="stat-card">
        <div class="stat-icon text-danger"><i class="fa-solid fa-building-columns"></i></div>
        <div class="text-danger small fw-bold">ACTIVE THEATERS</div>
        <div class="display-6 fw-bold text-white" id="statTotalTheaters">4</div>
        <div class="text-cyan small mt-2"><i class="fa-solid fa-circle-check"></i> 23 Screens total</div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6">
      <div class="stat-card">
        <div class="stat-icon text-primary"><i class="fa-solid fa-film"></i></div>
        <div class="text-primary small fw-bold">MOVIES IN CATALOG</div>
        <div class="display-6 fw-bold text-white" id="statTotalMovies">6</div>
        <div class="text-gold small mt-2"><i class="fa-solid fa-star"></i> 4 Now Showing</div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6">
      <div class="stat-card">
        <div class="stat-icon text-purple"><i class="fa-solid fa-receipt"></i></div>
        <div class="text-purple small fw-bold">TOTAL BOOKINGS</div>
        <div class="display-6 fw-bold text-white" id="statTotalBookings"><?= mysqli_num_rows($bookings) ?></div>
        <div class="text-success small mt-2"><i class="fa-solid fa-dollar-sign"></i> Active Revenue</div>
      </div>
    </div>
  </div>

  <!-- Quick Actions Grid -->
  <div class="row g-4">
    <div class="col-lg-6">
      <div class="admin-table-card p-4 h-100">
        <h5 class="text-white fw-bold mb-3"><i class="fa-solid fa-bolt text-gold me-2"></i> Quick Management Shortcuts</h5>
        <div class="d-grid gap-3">
          <a href="theaters.php" class="btn btn-cinema-outline text-start d-flex justify-content-between align-items-center p-3">
            <span><i class="fa-solid fa-plus-circle text-brand me-2"></i> Add or Edit Cinema Theaters</span>
            <i class="fa-solid fa-chevron-right text-muted"></i>
          </a>
          <a href="movie.php" class="btn btn-cinema-outline text-start d-flex justify-content-between align-items-center p-3">
            <span><i class="fa-solid fa-plus-circle text-cyan me-2"></i> Add New Movie to Catalog</span>
            <i class="fa-solid fa-chevron-right text-muted"></i>
          </a>
          <a href="shows.php" class="btn btn-cinema-outline text-start d-flex justify-content-between align-items-center p-3">
            <span><i class="fa-solid fa-tags text-gold me-2"></i> Adjust Class Seat Rates (Gold / Platinum / Box)</span>
            <i class="fa-solid fa-chevron-right text-muted"></i>
          </a>
        </div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="admin-table-card p-4 h-100">
        <h5 class="text-white fw-bold mb-3"><i class="fa-solid fa-receipt text-cyan me-2"></i> Recent Booking Audits</h5>
        <div class="table-responsive">
          <table class="table custom-table small">
            <thead>
              <tr>
                <th>Booking ID</th>
                <th>Movie</th>
                <th>Category</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php if(mysqli_num_rows($bookings) > 0){ ?>
                <?php while($booking = mysqli_fetch_assoc($bookings)){ ?>
                  <tr>
                    <td>#<?= $booking['booking_id']; ?></td>
                    <td><?= $booking['title']; ?></td>
                    <td><span class="badge bg-info text-dark"><?= $booking['category']; ?></span></td>
                    <td>
                      <?php if($booking['status'] == 'Confirmed'){ ?>
                        <span class="badge bg-success">Confirmed</span>
                      <?php }else{ ?>
                        <span class="badge bg-danger"><?= htmlspecialchars($booking['status']); ?></span>
                      <?php } ?>
                    </td>
                  </tr>
                <?php } ?>
              <?php } else { ?>
                <tr>
                  <td colspan="4" class="text-center text-muted">No bookings found.</td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once "includes/footer.php"; ?>