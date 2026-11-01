<?php
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
include_once "../includes/db.php";

$error = "";
if (isset($_POST['add_booking'])) {
    $user_id = (int)$_POST['user_id'];
    $show_id = (int)$_POST['show_id'];
    $seat_id = (int)$_POST['seat_id'];
    $status  = "Confirmed";
    if ($user_id > 0 && $show_id > 0 && $seat_id > 0) {
        // SQL Injection Protection
        $user_id = mysqli_real_escape_string($connect, $user_id);
        $show_id = mysqli_real_escape_string($connect, $show_id);
        $seat_id = mysqli_real_escape_string($connect, $seat_id);
        $query = "INSERT INTO bookings (user_id, show_id, seat_id, status) VALUES ('$user_id', '$show_id', '$seat_id', '$status')";
        if (mysqli_query($connect, $query)) {
            echo "<script>
                    alert('Booking added successfully!');
                    window.location.href='bookings.php';
                  </script>";
            exit();
        } else {
            $error = "Database Error: " . mysqli_error($connect);
        }
    } else {
        $error = "Please select all required fields.";
    }
}
$users_res = mysqli_query($connect, "SELECT user_id, user_name FROM users ORDER BY user_name ASC");
$shows_res = mysqli_query($connect, "SELECT shows.id, movies.title, theaters.name, shows.show_date, shows.show_time, shows.category FROM shows JOIN movies ON shows.movie_id = movies.id JOIN theaters ON shows.theater_id = theaters.id ORDER BY shows.show_date ASC");
$seats_res = mysqli_query($connect, "SELECT id, seat_number, category FROM seats ORDER BY seat_number ASC");
include_once "includes/header.php";
?>

<div class="admin-main-content py-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="text-white fw-bold mb-1"><i class="fa-solid fa-ticket text-brand me-2"></i>Add New Booking</h3>
                <p class="text-white small mb-0">Create a new movie ticket booking.</p>
            </div>
            <a href="bookings.php" class="btn btn-cinema btn-sm"><i class="fa-solid fa-arrow-left me-1"></i>Back to Bookings</a>
        </div>

        <?php if(!empty($error)){ ?>
            <div class="alert alert-danger">
                <i class="fa-solid fa-circle-exclamation me-2"></i>
                <?= htmlspecialchars($error); ?>
            </div>
        <?php } ?>

        <div class="admin-table-card p-4">
            <form method="POST">
                <div class="row g-3">
                    <!-- User Dropdown -->
                    <div class="col-md-4">
                        <label class="form-label text-white fw-bold">Select User</label>
                        <select name="user_id" class="form-select form-control-cinema bg-dark text-white border-secondary" required>
                            <option value="">-- Choose User --</option>
                            <?php while($u = mysqli_fetch_assoc($users_res)){ ?>
                                <option value="<?= $u['user_id']; ?>">
                                    <?= htmlspecialchars($u['user_name']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Show Dropdown -->
                    <div class="col-md-8">
                        <label class="form-label text-white fw-bold">Select Showtime</label>
                        <select name="show_id" class="form-select form-control-cinema bg-dark text-white border-secondary" required>
                            <option value="">-- Choose Showtime --</option>
                            <?php while($s = mysqli_fetch_assoc($shows_res)){ ?>
                                <option value="<?= $s['id']; ?>">
                                    <?= htmlspecialchars($s['title']); ?> | <?= htmlspecialchars($s['name']); ?> | <?= $s['show_date']; ?> - <?= $s['show_time']; ?> (<?= htmlspecialchars($s['category']); ?>)
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Seat Dropdown -->
                    <div class="col-md-6">
                        <label class="form-label text-white fw-bold">Select Seat</label>
                        <select name="seat_id" class="form-select form-control-cinema bg-dark text-white border-secondary" required>
                            <option value="">-- Choose Seat --</option>
                            <?php while($seat = mysqli_fetch_assoc($seats_res)){ ?>
                                <option value="<?= $seat['id']; ?>">
                                    Seat <?= htmlspecialchars($seat['seat_number']); ?> (<?= htmlspecialchars($seat['category']); ?>)
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <label class="form-label text-white fw-bold">Status</label>
                        <input type="text" class="form-control form-control-cinema bg-dark text-white border-secondary" value="Confirmed" readonly>
                    </div>

                    <!-- Save Button -->
                    <div class="col-12 text-end mt-4">
                        <button type="submit" name="add_booking" class="btn btn-cinema fw-bold px-4">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Save Booking
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once "includes/footer.php"; ?>