<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: *");
require_once('../root/config.php');
$data = json_decode(file_get_contents("php://input"));
if(!empty($data->username) && !empty($data->password)) {
	$result = dbRow("SELECT * FROM users WHERE email='".$data->username."'
	AND password='".md5($data->password)."'");
	if($result){
		if($result->active == 1){
			http_response_code(200);
			echo json_encode(array("message" => "Login successful", "status" => "success","data" => $result));
		}else{
			echo json_encode(
			array("message" => "Login failed.. Account is not active", "status" => "failed"));
		}
	}else{
		http_response_code(503);
		
		echo json_encode(array("message" => "Username or password is incorrect","status" => "failed"));
	}
}elseif(!empty($data->business_name) && !empty($data->service)){
	$check = $dbh->query("SELECT business_name FROM field_data WHERE business_name='".$data->business_name."'")->fetchColumn();
	if(!$check){
		$sql = "INSERT INTO field_data VALUES(NULL,'".$data->business_name."', '".$data->business_type."','".$data->location."', 
		'".$data->service."', '".$data->postal_address."', 
		'".$data->phone_number."', '".$data->email_address."', '".$data->website."', 
		'".$data->description."','".$data->user."', '".$today."')";
		
		$result = dbCreate($sql);
		if($result == 1){
			http_response_code(200);
			echo json_encode(array("message" => "Record added successfully", "status" => "success"));
		}else{
			http_response_code(503);
			echo json_encode(array("message" => "Unable to create a record","status" => "failed"));
		}
	}else{
		http_response_code(503);
		echo json_encode(array("message" => "Business name already exists,try a different business name",
			"status" => "failed"));
	}
}elseif(!empty($data->userid) && !empty($data->amount)){
// call the payment function to initiate the  transaction 
$method = $data->method;
 if($method == 'mtn'){
	$trx = trim($data->mtn_number);
}else{
	$trx = trim($data->airtel_number);
}
$msisdn = "256".ltrim($trx,$trx[0]);
$reference = getCode();
$sql = "INSERT INTO payments(userid, msisdn, amount, reference, date_paid, date_time,status) 
VALUES('".$data->userid."','$msisdn','".$data->amount."','$reference','$today','$dtime','Pending')";

$result = dbCreate($sql);
	if($result == 1){
		// call the payment api at this point 
		http_response_code(200);
		echo json_encode(
			array("message" => "Payment initiated", 
			"status" => "success")
		);
	}else{
		http_response_code(503);
		//tell the user...
		echo json_encode(array("message" => "Unable to initiate payment","status" => "failed"));
	}
}else{
	http_response_code(503);
	echo json_encode(array("message" => "No data received","status" => "failed"));
}