<?php
include_once "includes/header.php";
include_once "includes/db.php";

if(isset($_POST["register"])){
  $username = trim($_POST["username"]);
  $useremail = trim($_POST["useremail"]);
  $userphone = trim($_POST["userphone"]);
  $password = $_POST["password"];
  $confirmpassword = $_POST["confirm_password"];

    if(!preg_match("/^[a-zA-Z\s]+$/", $username)){
        echo "<script>window.location.href='register.php?error=Name should only contain alphabets.&type=danger'</script>";
        exit();
    }
    else if(!filter_var($useremail, FILTER_VALIDATE_EMAIL)){
        echo "<script>window.location.href='register.php?error=Please enter a valid email address.&type=danger'</script>";
        exit();
    }
    else if(!preg_match("/^[0-9]{11}$/", $userphone)){
        echo "<script>window.location.href='register.php?error=Phone number must be exactly 11 digits.&type=danger'</script>";
        exit();
    }
    else if(strlen($password) < 6){
        echo "<script>window.location.href='register.php?error=Password must be at least 6 characters long.&type=danger'</script>";
        exit();
    }
    else if($password !== $confirmpassword){
        echo "<script>window.location.href='register.php?error=Password and Confirm Password do not match.&type=danger'</script>";
        exit();
    }
    else {
        $checkStmt = mysqli_prepare($connect, "SELECT user_id FROM users WHERE user_email = ?");
        mysqli_stmt_bind_param($checkStmt, "s", $useremail);
        mysqli_stmt_execute($checkStmt);
        mysqli_stmt_store_result($checkStmt);
        
        if(mysqli_stmt_num_rows($checkStmt) > 0){ 
            echo "<script>window.location.href='register.php?error=Account Already Exists! Try Logging In.&type=danger'</script>";
            exit();
        }
        mysqli_stmt_close($checkStmt);

        $roleStmt = mysqli_prepare($connect, "SELECT role_id FROM roles WHERE role_name = 'User'");
        mysqli_stmt_execute($roleStmt);
        $roleResult = mysqli_stmt_get_result($roleStmt);
        
        if($roledata = mysqli_fetch_assoc($roleResult)){
            $roleid = $roledata['role_id'];
        } else {
            $roleid = 8; 
        }
        mysqli_stmt_close($roleStmt);
                    $encryptedpassword = password_hash($password, PASSWORD_DEFAULT);
        
        $insertStmt = mysqli_prepare($connect, "INSERT INTO users(user_name, user_email, user_password, user_phone, role_id) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($insertStmt, "ssssi", $username, $useremail, $encryptedpassword, $userphone, $roleid);
        $res = mysqli_stmt_execute($insertStmt);

        if($res){
            echo "<script>window.location.href='login.php?msg=Registration successful! Please sign in.&type=success'</script>";
            exit();
        } else {
            echo "<script>window.location.href='register.php?error=Registration failed. Please try again.&type=danger'</script>";
            exit();
        }
        mysqli_stmt_close($insertStmt);
    }
}
?>

<div class="page-content-wrapper d-flex align-items-center py-5 mt-3">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="glassmorphism p-4 p-md-5 rounded-4 shadow-elevated p-5">
          <div class="text-center mb-4">
            <div class="brand-icon mx-auto mb-2" style="width: 50px; height: 50px;"><i class="fa-solid fa-user-plus fs-4"></i></div>
            <h3 class="text-white fw-bold mb-1">Create Account</h3>
            <p class="text-white small">Join CinePulse Club for presale tickets & discounts.</p>
          </div>

          <form method="post">
            <div class="mb-3">
              <label class="form-label text-white small fw-bold">Full Name:</label>
              <input type="text" name="username" class="form-control form-control-cinema" placeholder="Enter Your Name" required pattern="[a-zA-Z\s]+" title="Name should only contain alphabets">
            </div>

            <div class="mb-3">
              <label class="form-label text-white small fw-bold">Email Address:</label>
              <input type="email" name="useremail" class="form-control form-control-cinema" placeholder="Enter Your Email" required>
            </div>

            <div class="mb-3">
              <label class="form-label text-white small fw-bold">Phone:</label>
              <input type="text" name="userphone" class="form-control form-control-cinema" placeholder="03001234567" required pattern="[0-9]{11}" title="Phone number must be exactly 11 digits">
            </div>

            <div class="mb-3">
              <label class="form-label text-white small fw-bold">Password:</label>
              <input type="password" name="password" class="form-control form-control-cinema" placeholder="........" required minlength="6">
            </div>

            <div class="mb-3">
              <label class="form-label text-white small fw-bold">Confirm Password:</label>
              <input type="password" name="confirm_password" class="form-control form-control-cinema" placeholder="........" required minlength="6">
            </div>
            
            <button type="submit" name="register" class="btn w-100 btn-warning py-3 fw-bold mt-2">Register My Account</button>
          </form>

          <div class="text-center mt-4 text-white small">
            Already have an account? <a href="login.php" class="text-warning fw-bold">Sign In</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once "includes/footer.php"; ?>