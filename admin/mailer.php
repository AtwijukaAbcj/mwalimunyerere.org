<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
function SendMail($to,$subj,$body){
			$mail = new PHPMailer(true);
			$mail->SMTPDebug = 0; // Enable verbose debug output
			$mail->isSMTP(); // Set mailer to use SMTP
			$mail->Host = "mail.ugandafishdirectory.com"; // Specify main and backup SMTP servers
			$mail->SMTPAuth = true; // Enable SMTP authentication
			$mail->Username = "info@ugandafishdirectory.com"; // SMTP username
			$mail->Password = "Whois@Uganda2020#"; // SMTP password
			$mail->SMTPSecure = "tls"; // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 587; // TCP port to connect to
			// Recipients
			$mail->setFrom('info@ugandafishdirectory.com', 'Uganda Fish Directory Notifications');
			$mail->addAddress($to, $to); // Add a recipient
			//$mail->addCC($cc, $cc);
			$mail->isHTML(true);
			$mail->Subject = $subj;
			$mail->Body    = $body;
			// check if mail has been sent
			if($mail->send()) {
				$_SESSION['message'] = "Mail has been successfully sent.";
			} else {
				$_SESSION['message'] = "Sending failed:" . $mail->ErrorInfo;
			}
}


