<?php
include_once "../includes/db.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    echo "<script>
            alert('Unauthorized Access!');
            window.location.href='../index.php';
          </script>";
    exit();
}
$query = "SELECT payments.*, bookings.booking_id, users.user_name, movies.title, theaters.name AS theater_name
          FROM payments
          JOIN bookings ON payments.booking_id = bookings.booking_id
          JOIN users ON bookings.user_id = users.user_id
          JOIN shows ON bookings.show_id = shows.id
          JOIN movies ON shows.movie_id = movies.id
          JOIN theaters ON shows.theater_id = theaters.id
          ORDER BY payments.payment_id DESC";

$result = mysqli_query($connect, $query);

include_once "includes/header.php";
?>

<div class="admin-main-content py-4">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h3 class="text-white fw-bold mb-1">
          <i class="fa-solid fa-credit-card text-brand me-2"></i>Payments
        </h3>
        <p class="text-white-50 small mb-0">Manage and view all payment records.</p>
      </div>
      <a href="add_payment.php" class="btn btn-cinema btn-sm">
        <i class="fa-solid fa-plus me-1"></i>Add Payment
      </a>
    </div>
    
    <div class="admin-table-card p-4">
      <div class="table-responsive">
        <table class="table custom-table align-middle mb-0">
          <thead>
            <tr>
              <th>Payment ID</th>
              <th>Booking</th>
              <th>User</th>
              <th>Movie</th>
              <th>Theater</th>
              <th>Amount</th>
              <th>Method</th>
              <th>Status</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($result) && mysqli_num_rows($result) > 0): ?>
              <?php while ($payment = mysqli_fetch_assoc($result)): ?>
                <tr>
                  <td class="fw-bold">#<?= htmlspecialchars($payment['payment_id']); ?></td>
                  <td>#<?= htmlspecialchars($payment['booking_id']); ?></td>
                  <td><?= htmlspecialchars($payment['user_name']); ?></td>
                  <td><?= htmlspecialchars($payment['title']); ?></td>
                  <td><?= htmlspecialchars($payment['theater_name']); ?></td>
                  <td>Rs. <?= htmlspecialchars($payment['amount']); ?></td>
                  <td><span class="badge bg-secondary"><?= htmlspecialchars($payment['payment_method']); ?></span></td>
                  <td>
                    <?php if ($payment['payment_status'] == "Paid"): ?>
                      <span class="badge bg-success">Paid</span>
                    <?php elseif ($payment['payment_status'] == "Pending"): ?>
                      <span class="badge bg-warning text-dark">Pending</span>
                    <?php else: ?>
                      <span class="badge bg-danger"><?= htmlspecialchars($payment['payment_status']); ?></span>
                    <?php endif; ?>
                  </td>
                  <td><?= htmlspecialchars($payment['payment_date']); ?></td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="9" class="text-center text-muted py-4">No payment records found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include_once "includes/footer.php"; ?>