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
$query = "SELECT * FROM roles";
$result = mysqli_query($connect, $query);
include_once "includes/header.php";
?>
<div class="admin-main-content py-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="text-white fw-bold mb-1"><i class="fa-solid fa-user-shield text-brand me-2"></i>Manage Roles</h3>
                <p class="text-white-50 small mb-0">View and manage system user access roles.</p>
            </div>
            <a href="add_role.php" class="btn btn-cinema btn-sm"><i class="fa-solid fa-plus me-1"></i>Add Role</a>
        </div>
        
        <div class="admin-table-card p-4">
            <div class="table-responsive">
                <table class="table custom-table align-middle">
                    <thead>
                        <tr>
                            <th>Role ID</th>
                            <th>Role Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($result) && mysqli_num_rows($result) > 0): ?>
                        <?php foreach($result as $row): ?>
                            <tr>
                                <td class="fw-bold"><?php echo htmlspecialchars($row['role_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['role_name']); ?></td>
                                <td>
                                    <a href="edit_role.php?id=<?php echo $row['role_id']; ?>" class="btn btn-sm btn-warning me-2">
                                        <i class="fa-solid fa-pen me-1"></i>Edit
                                    </a>
                                    <a href="delete_role.php?id=<?php echo $row['role_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this role?')">
                                        <i class="fa-solid fa-trash me-1"></i>Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">No roles found in the database.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once "includes/footer.php"; ?>