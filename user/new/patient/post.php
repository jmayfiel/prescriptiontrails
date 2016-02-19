<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("../../../admin/db.php");

$fn			 = filter_input(INPUT_POST, 'fn', FILTER_SANITIZE_STRING);
$ln			 = filter_input(INPUT_POST, 'ln', FILTER_SANITIZE_STRING);
$email		 = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$dob		 = filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_STRING);
$password1	 = $_POST['password1'];
$password2	 = $_POST['password2'];
$terms	 	 = $_POST['terms'];

$query = array(
	"fn" => $fn,
	"ln" => $ln,
	"email" => $email,
	"dob" => $dob,
);
$querystring = http_build_query($query);

// Required field names
$required = array('fn', 'ln', 'email', 'dob', 'password1', 'password2', 'terms');

// Loop over field names, make sure each one exists and is not empty
foreach($required as $field) {
  if (empty($_POST[$field])) {
    header("Location: ".$baseurl."user/new/patient/?status=error&code=missing&".$querystring);
	exit();
  }
}

if(!$terms) {
    header("Location: ".$baseurl."user/new/patient/?status=error&code=missing&".$querystring);
	exit();
}

if($password1 != $password2) {
    header("Location: ".$baseurl."user/new/patient/?status=error&code=password&".$querystring);
	exit();
}

$secret = "6LfdFBUTAAAAAF40Be_HnpwT_Oj6CyDAsgtLohW_";
$recaptcha = new \ReCaptcha\ReCaptcha($secret);
$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
if ($resp->isSuccess()) {
    // verified!
} else {
    $errors = $resp->getErrorCodes();
    header("Location: ".$baseurl."user/new/patient/?status=error&code=captcha&".$querystring."&respcode=".http_build_query($errors));
	exit();
}

$db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$db->where("email", $email);
if($db->has("users")) {
    header("Location: ".$baseurl."user/new/patient/?status=error&code=exists&".$querystring);
	exit();
}

$Auth = new Auth;
// $result = $Auth->createUser($email, $password, $fname, $lname, $is_active = 1, $is_admin = 0, $is_provider = 0, $is_super = 0, $is_verified = 0);
$result = $Auth->createUser($email, $password1, $fn, $ln, 1, 0, 0, 0, 0);

if($result['status']) {
	$attribute = array(
		'dob' => date("d-m-Y", strtotime($dob)),
	);
	if($Auth->setAttr($result['id'], $attribute)) {
		header("Location: ".$baseurl."user/new/patient/done.php?e=".$email);
	} else {
		die("auth error");	
	}
} else {
	die("auth error");	
}

?>