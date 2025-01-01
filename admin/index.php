<?php
require_once ('root/config.php');

session_start(); // Start the session at the beginning of the script

if (isset($_POST['login'])) {
    $uname = $_POST['email']; // Capture the user input email
    $pass = md5($_POST['password']); // Encrypt input password of the user with md5 function

    if ($uname && $pass) { // Check if the email and password were input
        $sql = $dbh->query("SELECT * FROM users WHERE email='$uname' AND password='$pass'");
        $check = $sql->fetch(PDO::FETCH_OBJ); // Fetch every row in table users

        if ($check) { // If the email and password are found in table users
            // Set session variables
            $_SESSION['pwd'] = $check->password;
            $_SESSION['interface'] = $check->role;
            $_SESSION['email'] = $check->email;
            $_SESSION['first'] = $check->firstName;
            $_SESSION['userid'] = $check->userID;
            $_SESSION['department'] = $check->department; // Corrected to use $check instead of $user

            // Redirect to the home page
            echo "<script>
                    window.location='" . HOME_URL . "';
                  </script>";
        } else {
            // Invalid email or password
            echo "<script>
                    alert('Username or password is incorrect. Try again');
                    window.location = '" . SITE_URL . "';
                  </script>";
        }
    }
} elseif (isset($_POST['forgot_pass'])) {
    trim(extract($_POST));
    $chk = $dbh->query("SELECT email FROM users WHERE email='$email'")->fetchColumn();

    if ($chk) {
        $code = rand(10000, 99999);
        $dbh->query("UPDATE users SET reset_code='$code' WHERE email='$email'");
        $subject = "Password Reset";
        $message = "You requested password reset for your account (Email: $email). If you really want to reset your password, 
        Here is the Reset Code: <b>$code</b>. If you are not interested in password resetting, please ignore this email and do not share the code with others. Thank you.";

        if (DB_URL != 'localhost') {
            SendMail($email, $subject, $message); // Call the mail function 
        }

        redirect_page('?reset&user=' . base64_encode($email));
    } else {
        echo "<script>
                alert('Email address does not match with any account...');
                window.location = '" . SITE_URL . "?forgot';
              </script>";
    }
} elseif (isset($_POST['reset_pass'])) {
    trim(extract($_POST));
    $rows = dbRow("SELECT * FROM users WHERE email='$email' LIMIT 1");

    if ($rows->reset_code == $code && $rows->email == $email) {
        $sql = $dbh->query("UPDATE users SET password='" . md5($password) . "' WHERE email='$email'");
        
        if ($sql) {
            echo "<script>
                    alert('Your password was reset successfully. You can now login.');
                    window.location = '" . SITE_URL . "';
                  </script>";
        } else {
            echo "<script>
                    alert('Password reset failed. Try again');
                    window.location = '" . SITE_URL . "?forgot';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Your password reset code is incorrect.');
                window.location = '" . SITE_URL . "?forgot';
              </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="dist/img/logo.png" type="images/png" />
  <title>Requisitions Management System :: Home</title>
  <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page" style="background-color:#343a40">
<div class="login-box">
  <div class="card">
    <div class="card-body login-card-body">
      <?php if (isset($_REQUEST['forgot'])) { ?>
        <center><img src="dist/img/logo.png" style="width:50%" />
        <h4>Reset Password</h4></center>
        <hr style="border:1px solid #ddd" />
        <form action="?reset" method="post">
          <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Enter your email" />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" name="forgot_pass" class="btn btn-primary btn-block"><i class="fa fa-angle-double-right"></i> Next Step</button>
            </div>
          </div>
        </form>
        <br/>
        <div class="row">
          <div class="col-12">
            <a href="./" class="btn btn-danger btn-block"><i class="fa fa-key"></i> Back to Login</a>
          </div>
        </div>
      <?php } elseif (isset($_REQUEST['reset'])) { ?>
        <center><img src="dist/img/logo.png" style="width:50%" />
        <h4>Reset Password</h4></center>
        <hr style="border:1px solid #ddd" />
        <form action="" method="post">
          <input type="hidden" name="email" value="<?php echo base64_decode($_REQUEST['user']); ?>" />
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="code" placeholder="Reset code">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="New password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" name="reset_pass" class="btn btn-primary btn-block"><i class="fa fa-save"></i> Submit</button>
            </div>
          </div>
        </form>
        <br/>
        <div class="row">
          <div class="col-12">
            <a href="?forgot" class="btn btn-danger btn-block"><i class="fa fa-key"></i> Back to Login</a>
          </div>
        </div>
      <?php } else { ?>
        <center><img src="dist/img/logo.png" style="width:50%" />
        <h4>Login</h4></center>
        <hr style="border:1px solid #ddd" />
        <form action="" method="post">
          <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Enter email address" autofocus required />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Enter password" required />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" name="login" class="btn btn-primary btn-block"><i class="fa fa-key"></i> Login</button>
            </div>
          </div>
        </form>
        <br/>
        <div class="row">
          <div class="col-12">
            <a href="?forgot" class="btn btn-danger btn-block">I forgot my password?</a>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</div>
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
