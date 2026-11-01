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
$query = "SELECT seats.*, theaters.name FROM seats JOIN theaters ON seats.theater_id = theaters.id";
$seats = mysqli_query($connect, $query);

include_once "includes/header.php";
?>

<div class="admin-main-content py-4">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="text-white fw-bold mb-0">All Theater Seats</h3>
      <a href="add_seat.php" class="btn btn-cinema btn-sm">+ Add New Seat</a>
    </div>

    <div class="admin-table-card p-4">
      <div class="table-responsive">
        <table class="table custom-table align-middle">
          <thead>
            <tr>
              <th>ID</th>
              <th>Theater Name</th>
              <th>Seat Number</th>
              <th>Category</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($seats) && mysqli_num_rows($seats) > 0): ?>
              <?php foreach($seats as $seat): ?>
                <tr>
                  <td class="fw-bold"><?= htmlspecialchars($seat['id']); ?></td>
                  <td><?= htmlspecialchars($seat['name']); ?></td>
                  <td><span class="badge bg-secondary"><?= htmlspecialchars($seat['seat_number']); ?></span></td>
                  <td><span class="badge bg-info text-dark"><?= htmlspecialchars($seat['category']); ?></span></td>
                  <td>
                    <a href="delete_seat.php?id=<?= $seat['id']; ?>" 
                       class="btn btn-danger btn-sm" 
                       onclick="return confirm('Delete this seat?')">
                      <i class="fa-solid fa-trash me-1"></i>Delete
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-center text-muted py-4">No seats found in the database.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include_once "includes/footer.php"; ?>