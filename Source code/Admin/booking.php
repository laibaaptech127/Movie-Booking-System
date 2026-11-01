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
$query = "SELECT bookings.booking_id, users.user_name, movies.title, theaters.name AS theater_name, seats.seat_number, seats.category, shows.show_date, shows.show_time, bookings.booking_date, bookings.status 
          FROM bookings 
          JOIN users ON bookings.user_id = users.user_id 
          JOIN shows ON bookings.show_id = shows.id 
          JOIN movies ON shows.movie_id = movies.id 
          JOIN theaters ON shows.theater_id = theaters.id 
          JOIN seats ON bookings.seat_id = seats.id 
          ORDER BY bookings.booking_id DESC";
$bookings = mysqli_query($connect, $query);
include_once "includes/header.php";
?>
<div class="admin-main-content py-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
              <h3 class="text-white fw-bold mb-1"><i class="fa-solid fa-ticket text-brand me-2"></i>Bookings Audit</h3>
              <p class="text-white-50 small mb-0">Manage and view all movie ticket bookings.</p>
            </div>
            <a href="add_booking.php" class="btn btn-cinema btn-sm"><i class="fa-solid fa-plus me-1"></i>Add New Booking</a>
        </div>
        <div class="admin-table-card p-4">
            <div class="table-responsive">
                <table class="table custom-table align-middle">
                    <thead>
                        <tr>
                          <th>ID</th>
                          <th>User</th>
                          <th>Movie</th>
                          <th>Theater</th>
                          <th>Seat</th>
                          <th>Category</th>
                          <th>Show Date</th>
                          <th>Show Time</th>
                          <th>Booking Date</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($bookings) && mysqli_num_rows($bookings) > 0): ?>
                        <?php while ($booking = mysqli_fetch_assoc($bookings)): ?>
                            <tr>
                                <td class="fw-bold"><?= htmlspecialchars($booking['booking_id']); ?></td>
                                <td><?= htmlspecialchars($booking['user_name']); ?></td>
                                <td><?= htmlspecialchars($booking['title']); ?></td>
                                <td><?= htmlspecialchars($booking['theater_name']); ?></td>
                                <td><span class="badge bg-secondary"><?= htmlspecialchars($booking['seat_number']); ?></span></td>
                                <td><span class="badge bg-info text-dark"><?= htmlspecialchars($booking['category']); ?></span></td>
                                <td><?= htmlspecialchars($booking['show_date']); ?></td>
                                <td><?= htmlspecialchars($booking['show_time']); ?></td>
                                <td><?= htmlspecialchars($booking['booking_date']); ?></td>
                                <td>
                                    <?php if ($booking['status'] == 'Confirmed'): ?>
                                        <span class="badge bg-success">Confirmed</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger"><?= htmlspecialchars($booking['status']); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="delete_booking.php?id=<?= $booking['booking_id']; ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Delete this booking?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="11" class="text-center text-muted py-4">
                                No bookings found in the database.
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once "includes/footer.php"; ?>