<?php

if(empty($_POST['email'])) {
	die("bad request");	
}

require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php");

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

$auth = new auth;
$response = $auth->forgotPasswordSend($email);

if($response == "sent") {
	$status = array(
		"status" => "done",
		"email" => $email
		);
} else {
	$status = array(
		"status"  => "error",
		"message" => "The email address you entered was not found in our system. Please try again."
		);
}

header('Content-Type: application/json');
echo(json_encode($status));

?>