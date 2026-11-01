<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once "includes/db.php";

$sweet_alert = "";

if (isset($_POST["loginbtn"])) {
    $email = mysqli_real_escape_string($connect, $_POST["email"]);
    $password = $_POST["password"];

    $user = mysqli_query($connect, "SELECT * FROM users WHERE user_email='$email'");

    if (mysqli_num_rows($user) == 0) {
        $sweet_alert = "
            Swal.fire({
                icon: 'error',
                title: 'Invalid Credentials',
                background: '#1e293b',
                color: '#fff',
                confirmButtonColor: '#f59e0b'
            });
        ";
    } else {
        $validuser = mysqli_fetch_assoc($user);

        if (!password_verify($password, $validuser["user_password"])) {
            $sweet_alert = "
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Credentials',
                    background: '#1e293b',
                    color: '#fff',
                    confirmButtonColor: '#f59e0b'
                });
            ";
        } else {
            $_SESSION["user_id"]  = $validuser["user_id"] ?? $validuser["id"];
            $_SESSION["username"] = $validuser["user_name"] ?? $validuser["username"];
            $_SESSION["role_id"]  = (int)$validuser["role_id"];

            if ($_SESSION["role_id"] === 1) {
                echo "<script>window.location.href='Admin/index.php';</script>";
                header("Location: Admin/index.php");
                exit();
            } else {
                echo "<script>window.location.href='index.php';</script>";
                header("Location: index.php");
                exit();
            }
        }
    }
}
include_once "includes/header.php"; 
?>
<div class="page-content-wrapper d-flex align-items-center py-5 mt-4">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="glassmorphism p-4 p-md-5 rounded-4 shadow-elevated">
          <div class="text-center mb-4">
            <div class="brand-icon mx-auto mb-2" style="width: 50px; height: 50px;">
                <i class="fa-solid fa-film fs-4"></i>
            </div>
            <h3 class="text-white fw-bold mb-1">Welcome Back</h3>
            <p class="text-white small">Sign in to access your CinePulse tickets & perks.</p>
          </div>

          <form action="" method="POST">
            <div class="mb-3">
              <label class="form-label text-white small fw-bold">Email Address:</label>
              <input type="email" name="email" class="form-control form-control-cinema" placeholder="Enter Your Email" required>
            </div>
            <div class="mb-3">
              <div class="d-flex justify-content-between">
                <label class="form-label text-white small fw-bold">Password:</label>
                <a href="#" class="text-gold small">Forgot?</a>
              </div>
              <input type="password" name="password" class="form-control form-control-cinema" placeholder="......." required>
            </div>
            <button type="submit" name="loginbtn" class="btn btn-warning w-100 py-3 fw-bold mt-2">Sign In to Account</button>
          </form>

          <div class="text-center mt-4 text-white small">
            Don't have a CinePulse account? <a href="register.php" class="text-gold fw-bold">Register Now</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- SweetAlert2 CDN for Modern Popups -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (!empty($sweet_alert)): ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        <?= $sweet_alert ?>
    });
</script>
<?php endif; ?>

<?php include_once "includes/footer.php"; ?>