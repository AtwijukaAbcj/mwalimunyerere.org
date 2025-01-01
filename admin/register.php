<?php
include('root/config.php');
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_data'])){ //add or edit user
	trim(extract($_POST));
	$check = $dbh->query("SELECT phone_number FROM field_data WHERE phone_number='$phone_number' ")->fetchColumn();
	if(!$check){
		$district = ucfirst($district);
		$business_name = ucfirst($con->real_escape_string(trim($business_name)));
		
		if($business_type == "fish-input-suppliers"){
			$rsx = explode(",", $phone_number);
			$phone = ltrim($rsx[0], $rsx[0][0]);
			$sql = "INSERT INTO fish_input_suppliers VALUES(NULL,'".strtoupper($business_name)."','$phone','$district', '$location','$description')";
		}elseif($business_type == "fish-markets"){
			$sql = "INSERT INTO fish_markets VALUES(NULL,'$business_name','$postal_address','$district', '$location')";
		}elseif($business_type == "fish-traders"){
			$rsx = explode(",", $phone_number);
			$phone = ltrim($rsx[0], $rsx[0][0]);
			$sql = "INSERT INTO fish_traders VALUES(NULL,'".strtoupper($business_name)."','$phone','$district', '$location')";
		}elseif($business_type == "boat-owners"){
			$rsx = explode(",", $phone_number);
			$phone = ltrim($rsx[0], $rsx[0][0]);
			$sql = "INSERT INTO boat_owners VALUES(NULL,'".strtoupper($business_name)."','$phone','$district', '$location')";
		}elseif($business_type == "boat-builders"){
			$rsx = explode(",", $phone_number);
			$phone = ltrim($rsx[0], $rsx[0][0]);
			$sql = "INSERT INTO boat_builders VALUES(NULL,'".strtoupper($business_name)."','$phone','$district', '$location')";
		}elseif($business_type == "fish-organizations"){
			$rsx = explode(",", $phone_number);
			$phone = "256".ltrim($rsx[0], $rsx[0][0]);
			$sql = "INSERT INTO fish_organizations VALUES(NULL,'$business_name','$postal_address','$business_type',
			'$phone','$email_address','$phone','','$district', '$location')";
		}elseif($business_type == "fish-farmers"){
			$rsx = explode(",", $phone_number);
			$phone = ltrim($rsx[0], $rsx[0][0]);
			$sql = "INSERT INTO fish_farmers VALUES(NULL,'$business_name','$phone','$district', '$location','$description')";
		}elseif($business_type == "fish-exporters-processors"){
			$rsx = explode(",", $phone_number);
			$phone = "256".ltrim($rsx[0], $rsx[0][0]);
			$sql = "INSERT INTO fish_exporters VALUES(NULL,'$business_name','$postal_address','$business_type',
			'$phone','$email_address','$phone','$district', '$location')";
		}elseif($business_type == "landing-sites"){
			$sql = "INSERT INTO landings VALUES(NULL,'$business_name','$postal_address','$district', '$location')";
		}elseif($business_type == "fish-consultants"){
			$rsx = explode(",", $phone_number);
			$phone = ltrim($rsx[0], $rsx[0][0]);
			$sql = "INSERT INTO fish_consultants VALUES(NULL,'$business_name','$postal_address','$phone','$district', '$location')";
		}
		
		/*$sql = "INSERT INTO field_data VALUES(NULL,'$business_name','$business_type','$location', '$service', '$postal_address',
		'$phone_number', '$email_address', '$website', '$description','$user', '$today')"; */
		
		$result = dbCreate($sql);
		if($result == 1){
			echo "<script>
			alert('Data submitted successfully');
			window.location = 'register';
			</script>";
		}else{
			echo "<script>
			alert('Data not submitted. Try again later');
			window.location = 'register';
			</script>";
		}
	}else{
		echo "<script>
		alert('Phone number already exists,try a different number');
		window.location = 'register';
		</script>";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="dist/css/logo.ico" type="images/x-icon" />
  <title> RFBCP :: Registration Form </title>
  <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet"> 
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page" style="background-color:#343a40">
<div class="col-md-8">
<div class="card mb-8 info" style="top:100px">
				<div class="card-header">
					<p style="text-align:justify"> GIZ-Responsible Fisheries Business Chains Project (RFBCP) with support from German Federal Ministry for 
			Economic Cooperation and Development (BMZ) is developing a <b> Fisheries and Aquaculture Directory </b> where all 
			legally recognized businesses in the fisheries sector in Uganda will be listed to create a one stop national database. 
			Be part of the fisheries directory by entering the information needed below. </p>
					<i class="fas fa-plus mr-1"> </i>
					<b> RFBCP - Registration Form </b>
				</div>
            <div class="card-body">
				<form role="form" method="post" action="" name="user" onsubmit="return alert(' *** The information you have provided will be published in the book and on the website for public viewing ***');">
				<input type="hidden" name="user" value="1" />
							<div class="row">
								<div class="col-sm-4">
									<div class="form-group">
										<span style="font-weight:600"> Name of Company or Business: </span>
										<input class="form-control" name="business_name" type="text" value="" autofocus required />
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<span style="font-weight:600"> District: </span>
										<input class="form-control" name="district" type="text" value="" placeholder="e.g Kampala" required />
									</div>
								</div>
								<div class="col-sm-4">
									 <div class="form-group">
									  <span style="font-weight:600">  Location By Region:  </span>
										<select name="location" type="text" class="form-control" required>
										<option value=""> -- Select -- </option>
										<?php foreach($regions as $val):?>
											<option value="<?=$val;?>"> <?=$val;?> </option>
										<?php endforeach;?>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									 <div class="form-group">
									  <span style="font-weight:600"> Physical or Postal Address: </span>
										<input type="text" class="form-control" name="postal_address" >
									</div>
								</div>
								<div class="col-sm-4">
									 <div class="form-group">
									  <span style="font-weight:600">  Contact Phone Number:</span>
										<input type="text" class="form-control" name="phone_number" required>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<span style="font-weight:600"> Contact Email Address:  </span>
										<input type="email" class="form-control" name="email_address"  />
									</div>
								</div>
								
							</div>
							<div class="row">
								<div class="col-sm-6">
									 <div class="form-group">
									  <span style="font-weight:600"> Business Web Address:  </span>
										<input type="text" class="form-control" name="website" >
									</div>
								</div>
								<div class="col-sm-6">
									 <div class="form-group">
									  <span style="font-weight:600">  Type of Business:  </span>
										<select name="business_type" type="text" class="form-control" required>
										    <option value=""> -- Select -- </option>		
											<option value="fish-input-suppliers">Fisheries and Aquaculture Input Suppliers</option>
											<option value="fish-markets">Fish Markets </option>
											<option value="fish-traders">Fish Traders </option>
											<option value="boat-owners">Boat Owners </option>
											<option value="boat-builders">Boat Builders</option>
											<option value="fish-organizations">Fisheries and Aquaculture Organizations</option>
											<option value="fish-farmers">Fish Farmers </option>
											<option value="fish-exporters-processors">Fish Exporters and Processors </option>
											<option value="landing-sites">Landing Sites</option>
											<option value="fish-consultants">Fisheries and Aquaculture Consultants</option>
											
										</select>
									</div>
								</div>
								<!--<div class="col-sm-4">
									 <div class="form-group">
									  <span style="font-weight:600"> Services or Products Offered:  </span>
										<select name="service" type="text" class="form-control" required>
										<option value=""> -- Select -- </option>
										<?php foreach($services as $val):?>
											<option value="<?=$val;?>"> <?=$val;?> </option>
										<?php endforeach;?>
										</select>
									</div>
								</div>-->
							</div>
							<div class="row">
								<div class="col-sm-12">
									 <div class="form-group">
									  <span style="font-weight:600">  Description of the service:</span>
										<textarea cols="10" type="text" class="form-control" name="description" > </textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
								<span>&nbsp; </span>
								<br/>
									<input type="submit" name="add_data" value="Submit" class="btn btn-primary"/>
								</div>
							</div>
                        </form>
                    </div>
		</div>
</div>
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
