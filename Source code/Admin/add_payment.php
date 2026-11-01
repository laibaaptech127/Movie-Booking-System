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

if (isset($_POST['add'])) {
    $booking_id     = mysqli_real_escape_string($connect, $_POST['booking_id']);
    $amount         = mysqli_real_escape_string($connect, $_POST['amount']);
    $payment_method = mysqli_real_escape_string($connect, $_POST['payment_method']);
    $payment_status = mysqli_real_escape_string($connect, $_POST['payment_status']);

    $query = "INSERT INTO payments(booking_id, amount, payment_method, payment_status) VALUES('$booking_id', '$amount', '$payment_method', '$payment_status')";
    $result = mysqli_query($connect, $query);

    if ($result) {
        header("Location: payment.php");
        exit();
    } else {
        $error = "Payment not added: " . mysqli_error($connect);
    }
}

$bookings = mysqli_query($connect, "SELECT bookings.booking_id, users.user_name, movies.title FROM bookings JOIN users ON bookings.user_id = users.user_id JOIN shows ON bookings.show_id = shows.id JOIN movies ON shows.movie_id = movies.id");

include_once "includes/header.php";
?>

<div class="admin-main-content py-4">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="text-white fw-bold mb-1">
                    <i class="fa-solid fa-credit-card text-brand me-2"></i>Add New Payment
                </h3>
                <p class="text-white small mb-0">Add payment details for a movie booking.</p>
            </div>

            <a href="payment.php" class="btn btn-cinema btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i>Back to Payments
            </a>
        </div>

        <?php if(!empty($error)){ ?>
            <div class="alert alert-danger">
                <i class="fa-solid fa-circle-exclamation me-2"></i><?= htmlspecialchars($error); ?>
            </div>
        <?php } ?>

        <div class="admin-table-card p-4">
            <form method="POST">
                <div class="row g-3">

                    <div class="col-md-12">
                        <label class="form-label text-white fw-bold">Select Booking</label>
                        <select name="booking_id" class="form-select form-control-cinema bg-dark text-white border-secondary" required>
                            <option value="">-- Choose Booking --</option>
                            <?php while($booking = mysqli_fetch_assoc($bookings)){ ?>
                                <option value="<?= $booking['booking_id']; ?>">
                                    Booking #<?= $booking['booking_id']; ?> | <?= htmlspecialchars($booking['user_name']); ?> | <?= htmlspecialchars($booking['title']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-white fw-bold">Amount</label>
                        <input type="number" step="0.01" name="amount" class="form-control form-control-cinema bg-dark text-white border-secondary" placeholder="Enter payment amount" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-white fw-bold">Payment Method</label>
                        <select name="payment_method" class="form-select form-control-cinema bg-dark text-white border-secondary" required>
                            <option value="">-- Select Method --</option>
                            <option value="Cash">Cash</option>
                            <option value="Card">Card</option>
                            <option value="Online">Online Payment</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label text-white fw-bold">Payment Status</label>
                        <select name="payment_status" class="form-select form-control-cinema bg-dark text-white border-secondary">
                            <option value="Paid">Paid</option>
                            <option value="Pending">Pending</option>
                            <option value="Failed">Failed</option>
                        </select>
                    </div>

                    <div class="col-12 text-end mt-4">
                        <a href="payment.php" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" name="add" class="btn btn-cinema fw-bold px-4">
                            <i class="fa-solid fa-floppy-disk me-1"></i>Add Payment
                        </button>
                    </div>

                </div>
            </form>
        </div>

    </div>
</div>

<?php include_once "includes/footer.php"; ?>