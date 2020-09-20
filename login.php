<?php
session_start();
require_once('essentials/config.php');
include "dbConfig.php";
if (isset($_SESSION['email'])) : {
    header("location: index.php");
  }
endif;
$validation = new validation;
$queries    = new queries;

if (isset($_POST['submit'])) {

  $validation->validate('email', 'Email', 'required');
  $validation->validate("password", 'Password', 'required');
  if ($validation->run()) {

    $email = $validation->input('email');
    $password = $validation->input('password');
    if ($queries->query("SELECT * FROM customer WHERE email = ? ", [$email])) {
      if ($queries->count() > 0) {
        $row = $queries->fetch();
        $userId     = $row->id;
        $userName   = $row->fullName;
        $dbPassword = $row->password;
        $status     = $row->status;
        if ($status == 0) {
          $_SESSION['notActive'] = "Please Verify your email first";
        } else 
        if ($status == 2) {
          $_SESSION['notActive'] = "This account has been deactivated by the user";
        } else
        if ($status == 3) {
          $_SESSION['notActive'] = "This account has been deactivated by the admin";
        } else
        if ($status == 1) {
          if (password_verify($password, $dbPassword)) {
            $update = mysqli_query($connect, "UPDATE `customer` SET `last_login` = NOW() WHERE `email` = '$email' ");
            $_SESSION['email'] = $email;
            header("location: index.php");
          } else {
            $validation->errors['password'] = "Sorry invalid password";
          }
        }
      } else {
        $validation->errors['email'] = "Sorry invalid email";
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login</title>
  <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/login.css">
</head>

<body>
  <main>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6 login-section-wrapper">
          <div class="brand-wrapper">
            <img src="img/logo_nav.png" alt="logo" class="logo">
          </div>

          <?php if (isset($_SESSION['accountCreated'])) : ?>
            <div class="alert alert-success">
              <?php echo $_SESSION['accountCreated']; ?>
            </div>
          <?php endif; ?>
          <?php unset($_SESSION['accountCreated']); ?>

          <?php if (isset($_SESSION['emailVerified'])) : ?>
            <div class="alert alert-success">
              <?php echo $_SESSION['emailVerified']; ?>
            </div>
          <?php endif; ?>
          <?php unset($_SESSION['emailVerified']); ?>


          <?php if (isset($_SESSION['notActive'])) : ?>
            <div class="alert alert-danger">
              <?php echo $_SESSION['notActive']; ?>
            </div>
          <?php endif; ?>
          <?php unset($_SESSION['notActive']); ?>

          <div class="login-wrapper my-auto">
            <h1 class="login-title">Welcome Back</h1>
            <form name="signupform" method="post" action="">
              <div class="form-group">
                <label for="password">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter registered Email" required />
                <div class="error text-danger text-center">
                  <?php if (!empty($validation->errors['email'])) : echo $validation->errors['email'];
                  endif; ?>
                </div>
              </div>
              <div class="form-group mb-4">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your passsword" required />
                <div class="error text-danger text-center">
                  <?php if (!empty($validation->errors['password'])) : echo $validation->errors['password'];
                  endif; ?>
                </div>
              </div>
              <input name="submit" id="login" class="btn btn-block login-btn" type="submit" value="Login">
            </form>
            <a href="forgotPassword.php" class="forgot-password-link">Forgot password?</a>
            <p class="login-wrapper-footer-text">Don't have an account? <a href="register.php" class="text-reset">Register here</a></p>
          </div>
        </div>
      </div>
    </div>
  </main>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>

</html>