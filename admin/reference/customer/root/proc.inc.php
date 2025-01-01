<?php
require_once('config.php');
require_once('../mailer.php');
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])){ //add or edit user
	 $msg = NULL;
	 $check_email= dbRow("SELECT email FROM users WHERE email='".$_POST['email']."' ");
	 if($check_email){ $msg .= '<div class="alert alert-danger alert-dismissable"> 
	 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Email address already exists.</div>'; }
	 if(!is_null($msg)) {
		log_message($msg);
		redirect_page(SITE_URL.'users?fname='.$_POST['fname'].'&password='.$_POST['password'].'&email='.$_POST['email'].'&contact='.$_POST['contact'].'&role='.$_POST['role']);
	}else{
		//generate a password here and send it
		$pass = trim($_POST['password']);
		$reference = get_reference();
		$sql = "INSERT INTO users(firstName,email,password,contact,role,active,plain_password,reference, commission) 
		VALUES('".trim($_POST['fname'])."',
		'".trim($_POST['email'])."', '".md5($pass)."','".trim($_POST['contact'])."',
		'".trim($_POST['role'])."',1,'$pass','$reference','".trim($_POST['commission'])."')";
		$result = dbCreate($sql);
		if($result == 1){
			$subj = "New user account";
			$uname = trim($_POST['fname']);
			$sn_email = trim($_POST['email']);
			$sn_msg = "Dear <b> $uname </b>, your account has been created. 
					Please use the following details to login and access the dashboard.<br/>
					Email: <b>".trim($_POST['email'])."</b><br/>
					Password: <b>".$pass."</b><br/>
					Click ".SITE_URL." to login";
				// send email here 
			if(DB_URL != 'localhost'){
				SendMail($sn_email,$subj,$sn_msg); 
			}
			$_SESSION['success'] = 'New agent added successfully..';
			redirect_page(SITE_URL.'lists');
		}elseif($result == 0){
				log_message('<div class="alert alert-danger alert-dismissable"> 
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>ERROR!!,  Information could not be saved. Try agin</div>');
				redirect_page(SITE_URL.'users');
		}elseif($result == NULL){
				log_message('<div class="alert alert-danger alert-dismissable">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> DATABASE ERROR!!,  Information could not be saved. Try agin</div>');
				redirect_page(SITE_URL.'users');
		}elseif($result> 1){
				log_message('<div class="alert alert-info alert-dismissable"> 
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>SYSTEM ERROR!!,  Records modified, inform system administrator about this error</div>');
				redirect_page(SITE_URL.'users');
		}
	} 
}elseif($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_pharm'])){ //add or edit user
	 $msg = NULL;
	 $check= dbRow("SELECT name FROM pharmacy WHERE name='".$_POST['name']."' ");
	 if($check){ $msg .= '<div class="alert alert-danger alert-dismissable"> 
	 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Pharmacy name already exists.</div>'; }
	 if(!is_null($msg)) {
		log_message($msg);
		redirect_page(SITE_URL.'pharmacy?name='.$_POST['name'].'&description='.$_POST['description'].'&location='.$_POST['location']);
	}else{
		$sql = "INSERT INTO pharmacy(name,description,location) 
		VALUES('".trim($_POST['name'])."',
		'".trim($_POST['description'])."','".trim($_POST['location'])."')";
		$result = dbCreate($sql);
		if($result == 1){
			
			$_SESSION['success'] = 'New pharmacy added successfully..';
			redirect_page(SITE_URL.'prlist');
		}elseif($result == 0){
				log_message('<div class="alert alert-danger alert-dismissable"> 
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>ERROR!!,  Information could not be saved. Try agin</div>');
				redirect_page(SITE_URL.'pharmacy');
		}elseif($result == NULL){
				log_message('<div class="alert alert-danger alert-dismissable">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> DATABASE ERROR!!,  Information could not be saved. Try agin</div>');
				redirect_page(SITE_URL.'pharmacy');
		}elseif($result> 1){
				log_message('<div class="alert alert-info alert-dismissable"> 
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>SYSTEM ERROR!!,  Records modified, inform system administrator about this error</div>');
				redirect_page(SITE_URL.'pharmacy');
		}
	} 
}elseif($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])){ //add or edit user
	 $msg = NULL;
	 $check= dbRow("SELECT product_name FROM pharmacy WHERE product_name='".$_POST['product_name']."' ");
	 if($check){ $msg .= '<div class="alert alert-danger alert-dismissable"> 
	 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Product name already exists.</div>'; }
	 if(!is_null($msg)) {
		log_message($msg);
		redirect_page(SITE_URL.'products?product_name='.$_POST['product_name'].'&quantity='.$_POST['quantity'].'&price='.$_POST['price']);
	}else{
		$pid = get_reference();
		$sql = "INSERT INTO products(prd_number, product_name,quantity,price) 
		VALUES('$pid', '".trim($_POST['product_name'])."','".trim($_POST['quantity'])."','".trim($_POST['price'])."')";
		$result = dbCreate($sql);
		if($result == 1){
			$_SESSION['success'] = 'New product added successfully..';
			redirect_page(SITE_URL.'pdlist');
		}elseif($result == 0){
				log_message('<div class="alert alert-danger alert-dismissable"> 
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>ERROR!!,  Information could not be saved. Try agin</div>');
				redirect_page(SITE_URL.'products');
		}elseif($result == NULL){
				log_message('<div class="alert alert-danger alert-dismissable">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> DATABASE ERROR!!,  Information could not be saved. Try agin</div>');
				redirect_page(SITE_URL.'products');
		}elseif($result> 1){
				log_message('<div class="alert alert-info alert-dismissable"> 
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>SYSTEM ERROR!!,  Records modified, inform system administrator about this error</div>');
				redirect_page(SITE_URL.'products');
		}
	} 
}elseif(isset($_REQUEST['active'])){
	$tm = trim($_REQUEST['active']);
	$dbh->query("UPDATE users set active=1 WHERE userID='$tm' ");
    $_SESSION['success'] = 'User activated successfully.';
	redirect_page(SITE_URL.'users');
}elseif(isset($_REQUEST['susp'])){
	$tm = trim($_REQUEST['susp']);
	$dbh->query("UPDATE users set active=0 WHERE userID='$tm' ");
	$_SESSION['success'] = 'User deactivated successfully..';
	redirect_page(SITE_URL.'users');
}elseif(isset($_REQUEST['udelete'])){
	$tm = trim($_REQUEST['udelete']);
	$dbh->query("DELETE FROM users WHERE userID='$tm' ");
	$_SESSION['success'] = 'User deleted successfully';
	redirect_page(SITE_URL.'lists');
}elseif(isset($_REQUEST['pxdel'])){
	$tm = trim($_REQUEST['pxdel']);
	$dbh->query("DELETE FROM pharmacy WHERE pid='$tm' ");
	$_SESSION['success'] = 'Record deleted successfully';
	redirect_page(SITE_URL.'prlist');
}elseif(isset($_REQUEST['prdel'])){
	$tm = trim($_REQUEST['prdel']);
	$dbh->query("DELETE FROM products WHERE prd_number='$tm' ");
	$_SESSION['success'] = 'Product deleted successfully';
	redirect_page(SITE_URL.'pdlist');
}elseif(isset($_POST['change_password'])){
	trim(extract($_POST));
	$old = md5($old_pass);
	$chk_pass = $dbh->query("SELECT password FROM users WHERE userID='$user' ")->fetchColumn();
	if($old != $chk_pass){
		$_SESSION['success'] = 'Old password is incorrect..';
		redirect_page(SITE_URL.'dash');
	}else{
		$new = md5($new_pass);
		$result = $dbh->query("UPDATE users set password='$new', plain_password='$new_pass' WHERE userID='$user'");
		if($result){
			$_SESSION['success'] = 'Profile updated successfully..';
			redirect_page(SITE_URL.'logout');
		}else{
			$_SESSION['success'] = 'Profile not updated..';
			redirect_page(SITE_URL.'dash');
		}
	}
}else{
	log_message('<br/><div class="alert alert-danger alert-dismissable">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	Access Denied! An authorised access </div>');
	redirect_page(HOME_URL);
}