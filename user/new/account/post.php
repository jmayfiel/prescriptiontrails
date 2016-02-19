<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("../../../admin/db.php");

$fn			 = filter_input(INPUT_POST, 'fn', FILTER_SANITIZE_STRING);
$ln			 = filter_input(INPUT_POST, 'ln', FILTER_SANITIZE_STRING);
$email		 = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$birthDay	 = filter_input(INPUT_POST, 'birthDay', FILTER_SANITIZE_NUMBER_INT);
$birthMonth	 = filter_input(INPUT_POST, 'birthMonth', FILTER_SANITIZE_STRING);
$birthYear	 = filter_input(INPUT_POST, 'birthYear', FILTER_SANITIZE_NUMBER_INT);
$password1	 = $_POST['password1'];
$password2	 = $_POST['password2'];
$terms	 	 = $_POST['terms'];

$query = array(
	"fn" => $fn,
	"ln" => $ln,
	"email" => $email,
	"birthDay" => $birthDay,
	"birthMonth" => $birthMonth,
	"birthYear" => $birthYear,
);
$querystring = http_build_query($query);

// Required field names
$required = array('fn', 'ln', 'email', 'birthYear', 'birthDay', 'birthMonth', 'password1', 'password2', 'terms');

// Loop over field names, make sure each one exists and is not empty
foreach($required as $field) {
  if (empty($_POST[$field])) {
    header("Location: ".$baseurl."user/new/account/?status=error&code=missing&".$querystring);
	exit();
  }
}

if(!$terms) {
    header("Location: ".$baseurl."user/new/account/?status=error&code=missing&".$querystring);
	exit();
}

if($password1 != $password2) {
    header("Location: ".$baseurl."user/new/account/?status=error&code=password&".$querystring);
	exit();
}

$secret = "6LfdFBUTAAAAAF40Be_HnpwT_Oj6CyDAsgtLohW_";
$recaptcha = new \ReCaptcha\ReCaptcha($secret);
$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
if ($resp->isSuccess()) {
    // verified!
} else {
    $errors = $resp->getErrorCodes();
    header("Location: ".$baseurl."user/new/account/?status=error&code=captcha&".$querystring."&respcode=".http_build_query($errors));
	exit();
}

$db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$db->where("email", $email);
if($db->has("users")) {
    header("Location: ".$baseurl."user/new/account/?status=error&code=exists&".$querystring);
	exit();
}

$dob = $birthMonth . " " . $birthDay . ", " . $birthYear;

$Auth = new Auth;
// $result = $Auth->createUser($email, $password, $fname, $lname, $is_active = 1, $is_admin = 0, $is_provider = 0, $is_super = 0, $is_verified = 0);
$result = $Auth->createUser($email, $password1, $fn, $ln, 1, 0, 0, 0, 0);

if($result['status']) {
	$attribute = array(
		'dob' => date("r", strtotime($dob)),
	);
	if($Auth->setAttr($result['id'], $attribute)) {
		header("Location: ".$baseurl."user/new/account/done.php?e=".$email);
	} else {
		die("auth error");	
	}
} else {
	die("auth error");	
}

?>