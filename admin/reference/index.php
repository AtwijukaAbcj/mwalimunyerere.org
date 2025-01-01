<?php 
include('root/config.php');
require_once("mailer.php");
if(isset($_POST['login'])){ 
$uname = $_POST['email']; // captures the user input email
$pass = md5($_POST['password']); // encrypts input password of the user with md5 function
if($uname && $pass){ // checks if the email and password was input
	$sql = $dbh->query("SELECT * FROM users WHERE email='$uname' AND password='$pass'");
	$check = $sql->fetch(PDO::FETCH_OBJ); // fetch every row in table users 
	if($check){ // if the email and password is found in table users
			$name = $check->email; // email that is stored in the table users
			$pwd = $check->password; // password that is stored in the table users
			$type = $check->role; // user type that is stored in the table users
			$_SESSION['pwd'] = $check->password;
			$_SESSION['interface'] = $check->role;
			$_SESSION['email'] = $check->email;
			$_SESSION['first'] = $check->firstName;
			$_SESSION['userid'] = $check->userID;
			if($name == $uname && $pass == $pwd){
				echo "<script>
					window.location='".HOME_URL."';
					</script>";	
			}else{
				echo "<script>
				alert('Username or password is incorrect.  Try again later');
				window.location = SITE_URL;
				</script>";	
			}
	}else{
				echo "<script>
				alert('Username or password is incorrect. Try again');
				window.location = SITE_URL;
				</script>";	
	}
	}	
}elseif(isset($_POST['forgot_pass'])){
	trim(extract($_POST));
	$chk = $dbh->query("SELECT email from users WHERE email='$email' ")->fetchColumn();
	if($chk){
		$code = rand(10000,99999);
		$dbh->query("UPDATE users set reset_code='$code' WHERE email='$email' ");
		$subject = "Password Reset";
		$message = "You requested password reset for your account (Email: $email). If you really want to reset your password, 
		Here is the Reset Code : <b> $code </b> . If you are not interested in password resetting, please ignore this email and do not share the code with others. Thank you..";
		if(DB_URL != 'localhost'){
			SendMail($email,$subject,$message);// call the mail function 
		}
		redirect_page('?reset&user='.base64_encode($email));
	}else{
		echo "<script>
		alert('Email address does not match with any account...');
		window.location = '".SITE_URL."?forgot';
		</script>";
	}
}elseif(isset($_POST['reset_pass'])){
	trim(extract($_POST));
	$rows = dbRow("SELECT * FROM users WHERE email='$email' LIMIT 1");
	if($rows->reset_code == $code && $rows->email == $email){
		$sql = $dbh->query("UPDATE users set password='".md5($password)."' WHERE email='$email'");
		if($sql){
			echo "<script>
			alert('Your password was reset successfully.. You can now login.');
			window.location = '".SITE_URL."';
			</script>";
		}else{
			echo "<script>
			alert('Password reset failed. Try again');
			window.location = '".SITE_URL."?forgot';
			</script>";
		}
	}else{
		echo "<script>
			alert('Your password reset code is incorrect.');
			window.location = '".SITE_URL."?forgot';
			</script>";
	}
}?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Customer Reference - Login </title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/metisMenu.min.css" rel="stylesheet">
	<link href="css/startmin.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>
<body>
<br> <br/>
<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">Customer Reference - Login Panel</h3>
				</div>
				<div class="panel-body">
					<form role="form" method="post" action="">
						<fieldset>
							<div class="form-group">
								<input class="form-control" placeholder="Email address" name="email" type="email" autofocus required>
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="Password" name="password" type="password" value="" required>
							</div>
							
							<button type="submit" name="login" class="btn btn-lg btn-success btn-block">Login</button>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/metisMenu.min.js"></script>
<script src="js/startmin.js"></script>
</body>
</html>
