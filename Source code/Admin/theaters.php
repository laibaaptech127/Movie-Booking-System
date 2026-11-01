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
$query = "SELECT * FROM theaters";
$theater = mysqli_query($connect, $query); 

include_once "includes/header.php";
?>

<div class="admin-main-content">
  <div class="admin-topbar">
    <div>
      <h4 class="text-white fw-bold mb-0">Manage Theater Complexes</h4>
      <div class="small">Add, update, or remove multiplex venues and screen capacities.</div>
    </div>
    <a href="theater_add.php"><button class="btn btn-cinema btn-sm"><i class="fa-solid fa-plus me-1"></i> Add New Theater</button></a>
  </div>
  <div class="admin-table-card p-4">
    <div class="table-responsive">
      <table class="table custom-table">
        <thead>
          <tr>
            <th>Theater id</th>
            <th>Theater Name</th>
            <th>Location</th>
            <th>Created_at</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($theater) && mysqli_num_rows($theater) > 0): ?>
            <?php foreach($theater as $row): ?>
                <tr>
                    <td class="fw-bold"><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['location']); ?></td>
                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                    <td>
                        <a href="edit_theater.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning me-2"><i class="fa-solid fa-pen"></i> Edit</a>
                        <a href="delete_theater.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fa-solid fa-trash"></i> Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5" class="text-center text-muted py-4">No theaters found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include_once "includes/footer.php"; ?>