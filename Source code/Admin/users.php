<?php
session_start();
include_once "includes/header.php";
include_once "includes/db.php";

if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    echo "<script>
            alert('Unauthorized Access!');
            window.location.href='../index.php';
          </script>";
    exit();
}

// User aur uski Bookings ko JOIN kar ke aik hi query se data lana
$query = "SELECT users.*, roles.role_name, bookings.seat_id 
          FROM users 
          JOIN roles ON users.role_id = roles.role_id
          LEFT JOIN bookings ON users.user_id = bookings.user_id";
          
$users = mysqli_query($connect, $query);
?>

<div class="admin-main-content">
<div class="container mt-5">
    <h2 class="text-white mb-4">All Registered Users</h2>
    <table class="table table-white text-black table-striped align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Booking Seat</th>
                <th>Created_at</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $user): ?>
            <tr>
                <td><?php echo $user['user_id']; ?></td>
                <td><?php echo $user['user_name']; ?></td>
                <td><?php echo $user['user_email']; ?></td>
                <td><?php echo $user['user_phone']; ?></td>
                <td><?php echo $user['role_name']; ?></td>
                <td><?php echo $user['seat_id'] ?? 'No Booking'; ?></td>
                <td><span class="badge bg-info"><?php echo $user['created_at']; ?></span></td>
                <td>
                    <a href="delete_user.php?id=<?= $user['user_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>
<?php include_once "includes/footer.php"; ?>