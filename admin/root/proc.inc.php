<?php
require_once('config.php');
require_once('../mailer.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) { // Add or edit user
    $msg = NULL;

    // Check if email already exists
    $check_email = dbRow("SELECT email FROM users WHERE email='" . trim($_POST['email']) . "'");
    if ($check_email) {
        $msg .= '<div class="alert alert-danger alert-dismissable"> 
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Email address already exists.</div>';
    }

    // If errors exist, redirect back with message
    if (!is_null($msg)) {
        log_message($msg);
        redirect_page(SITE_URL . 'users.php?fname=' . $_POST['fname'] . '&password=' . $_POST['password'] . '&email=' . $_POST['email'] . '&contact=' . $_POST['contact'] . '&role=' . $_POST['role']);
    } else {
        // Insert user into database
        $pass = trim($_POST['password']);
        $code = rand(11111, 99999);
        $sql = "INSERT INTO users (userID, firstName, email, password, contact, role, reset_code, active, plain_password, country, department) 
                VALUES (NULL, '" . trim($_POST['fname']) . "', '" . trim($_POST['email']) . "', '" . md5($pass) . "', 
                '" . trim($_POST['contact']) . "', '" . trim($_POST['role']) . "', '$code', 1, '$pass', '" . trim($_POST['country']) . "', 
                '" . trim($_POST['department']) . "')";

        $result = dbCreate($sql);
        if ($result == 1) {
            $_SESSION['success'] = '<div class="alert alert-success alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>New user added successfully!</div>';
            redirect_page(SITE_URL . 'list_users.php'); // Redirect to list_users.php
        } else {
            log_message('<div class="alert alert-danger alert-dismissable"> 
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Failed to add user. Try again!</div>');
            redirect_page(SITE_URL . 'users.php');
        }
    }
}

// Activate user
elseif (isset($_REQUEST['active'])) {
    $userID = trim($_REQUEST['active']);
    $dbh->query("UPDATE users SET active=1 WHERE userID='$userID'");
    $_SESSION['success'] = 'User activated successfully.';
    redirect_page(SITE_URL . 'list_users.php');
}

// Suspend user
elseif (isset($_REQUEST['susp'])) {
    $userID = trim($_REQUEST['susp']);
    $dbh->query("UPDATE users SET active=0 WHERE userID='$userID'");
    $_SESSION['success'] = 'User deactivated successfully.';
    redirect_page(SITE_URL . 'list_users.php');
}

// Delete user
elseif (isset($_REQUEST['udelete'])) {
    $userID = trim($_REQUEST['udelete']);
    $dbh->query("DELETE FROM users WHERE userID='$userID'");
    $_SESSION['success'] = 'User deleted successfully.';
    redirect_page(SITE_URL . 'list_users.php');
}

// Change password
elseif (isset($_POST['change_password'])) {
    trim(extract($_POST));
    $old = md5($old_pass);
    $chk_pass = $dbh->query("SELECT password FROM users WHERE userID='$user'")->fetchColumn();

    if ($old != $chk_pass) {
        $_SESSION['success'] = 'Old password is incorrect.';
        redirect_page(SITE_URL . 'dash');
    } else {
        $new = md5($new_pass);
        $result = $dbh->query("UPDATE users SET password='$new', plain_password='$new_pass' WHERE userID='$user'");
        if ($result) {
            $_SESSION['success'] = 'Password updated successfully.';
            redirect_page(SITE_URL . 'logout');
        } else {
            $_SESSION['success'] = 'Password not updated.';
            redirect_page(SITE_URL . 'dash');
        }
    }
}elseif(isset($_POST['add_photos'])){
	trim(extract($_POST));
	$filename=  $_FILES["imgfile"]["name"];
	$chk = rand(111111111,999999999);
	$ext = strrchr($filename, ".");
	$apfile = $chk.$ext; 
	$posted = time();
	if(!empty($filename)){ 
		if(($_FILES["imgfile"]["type"] == "image/jpg") || ($_FILES["imgfile"]["type"] == "image/png")
			|| ($_FILES["imgfile"]["type"] == "image/jpeg")) 
		  {
			if(file_exists($_FILES["imgfile"]["name"]))
			{
			  echo "File name exists.";
			}
			else
			{
			$sql = "INSERT INTO gallery VALUES(NULL,'$apfile','$caption','$today')";
			$result = dbCreate($sql);
			if($result == 1) {
				move_uploaded_file($_FILES["imgfile"]["tmp_name"],"../uploads/$apfile");
				$_SESSION['success'] = 'Photo added successfully';
				redirect_page(SITE_URL.'gallery');
			}elseif($result == 0){
				log_message('<div class="alert alert-danger alert-dismissable"> 
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> ERROR!!,  Information could not be saved. Try agin</div>');
				redirect_page(HOME_URL);
			}elseif($result==NULL) {
				log_message('<div class="alert alert-danger">DATABASE ERROR!!,  Information could not be saved. Try agin</div>');
				redirect_page(HOME_URL);
			}elseif($result> 1) {
				log_message('<div class="alert alert-info">SYSTEM ERROR!!,  Records modified, inform system administrator about this error</div>');
				redirect_page(HOME_URL);
			}
			}
		  }else{
			echo "<script>
				alert('Please choose a valid file less than 2MB');
				window.location='../dash';
				</script>";
		  }
	}	
}elseif(isset($_REQUEST['gt-del'])){
	$tm = trim($_REQUEST['gt-del']);
	$dbh->query("DELETE FROM departments WHERE did='$tm' ");
	$_SESSION['success'] = 'Department deleted successfully';
	redirect_page(SITE_URL.'departments');
}elseif(isset($_REQUEST['sm-del'])){
	$tm = trim($_REQUEST['sm-del']);
	$dbh->query("DELETE FROM contacts WHERE cid='$tm' ");
	$_SESSION['success'] = 'Message deleted successfully';
	redirect_page(SITE_URL.'contacts');
}elseif(isset($_POST['add_dept'])){
	trim(extract($_POST));
	$chk = $dbh->query("SELECT dname FROM departments WHERE dname='$name'")->fetchColumn();
	if(!$chk){
		$sql = "INSERT INTO departments VALUES(NULL,'$name')";
		$result = dbCreate($sql);
		if($result == 1){
			$_SESSION['success'] = 'Department added successfully';
			redirect_page(SITE_URL.'departments');
		}
	}else{
			$_SESSION['success'] = 'Department already added';
			redirect_page(SITE_URL.'departments');
	}
}elseif(isset($_POST['add_branch'])){
	trim(extract($_POST));
	$chk = $dbh->query("SELECT bname FROM branches WHERE bname='$name'")->fetchColumn();
	if(!$chk){
		$sql = "INSERT INTO branches VALUES(NULL,'$name')";
		$result = dbCreate($sql);
		if($result == 1){
			$_SESSION['success'] = 'Branch added successfully';
			redirect_page(SITE_URL.'branches');
		}
	}else{
			$_SESSION['success'] = 'Branch already added';
			redirect_page(SITE_URL.'branches');
	}
	
}elseif(isset($_POST['add_asset'])){
	trim(extract($_POST));
	$chk = $dbh->query("SELECT name FROM assets WHERE name='$name'")->fetchColumn();
	if(!$chk){
		$code = generate_code();
		$sql = "INSERT INTO assets VALUES(NULL,'$code','$name','$allotted_to','$branch','$department','', $serial','$label','$today')";
		$result = dbCreate($sql);
		if($result == 1){
			$_SESSION['success'] = 'Asset added successfully';
			redirect_page(SITE_URL.'add');
		}
	}else{
			$_SESSION['success'] = 'Asset not added';
			redirect_page(SITE_URL.'add');
	}
	
}elseif(isset($_POST['edit_asset'])){
	trim(extract($_POST));
	$result = $dbh->query("UPDATE assets SET name='$name',allotted_to='$allotted_to',branch='$branch',department='$department'
		WHERE sid='$identity'");
	if($result){
		$_SESSION['success'] = 'Asset updated successfully';
		redirect_page(SITE_URL.'ptlist');
	}	
}elseif(isset($_POST['edit_status'])){
	trim(extract($_POST));
	$result = $dbh->query("UPDATE assets SET status='$status' WHERE sid='$identity'");
	if($result){
		$_SESSION['success'] = 'Asset updated successfully';
		redirect_page(SITE_URL.'ptlist');
	}	
}elseif(isset($_REQUEST['brt-del'])){
	$tm = trim($_REQUEST['brt-del']);
	$dbh->query("DELETE FROM branches WHERE bid='$tm' ");
	$_SESSION['success'] = 'Branch deleted successfully';
	redirect_page(SITE_URL.'branches');
}elseif(isset($_REQUEST['atd-del'])){
	$tm = trim($_REQUEST['atd-del']);
	$dbh->query("DELETE FROM assets WHERE sid='$tm' ");
	$_SESSION['success'] = 'Asset deleted successfully';
	redirect_page(SITE_URL.'ptlist');
}else{
	log_message('<br/><div class="alert alert-danger alert-dismissable">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	Access Denied! An authorised access </div>');
	redirect_page(HOME_URL);
}