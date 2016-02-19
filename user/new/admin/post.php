<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php"); 
$adminPage = true;
require("/nfs/users/clind/public_html/prescriptiontrails.org/src/secure.php"); 

$fn			 = filter_input(INPUT_POST, 'fn', FILTER_SANITIZE_STRING);
$ln			 = filter_input(INPUT_POST, 'ln', FILTER_SANITIZE_STRING);
$email		 = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password1	 = $_POST['password1'];
$password2	 = $_POST['password2'];

$query = array(
	"fn" => $fn,
	"ln" => $ln,
	"email" => $email,
);
$querystring = http_build_query($query);

// Required field names
$required = array('fn', 'ln', 'email', 'password1', 'password2');

// Loop over field names, make sure each one exists and is not empty
foreach($required as $field) {
  if (empty($_POST[$field])) {
    header("Location: ".$baseurl."user/new/admin/?status=error&code=missing&".$querystring);
	exit();
  }
}

if($password1 != $password2) {
    header("Location: ".$baseurl."user/new/admin/?status=error&code=password&".$querystring);
	exit();
}

$db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$db->where("email", $email);
if($db->has("users")) {
    header("Location: ".$baseurl."user/new/admin/?status=error&code=exists&".$querystring);
	exit();
}

$Auth = new Auth;
// $result = $Auth->createUser($email, $password, $fname, $lname, $is_active = 1, $is_admin = 0, $is_provider = 0, $is_super = 0, $is_verified = 0);
$result = $Auth->createUser($email, $password1, $fn, $ln, 1, 1, 0, 0, 0);

if($result['status']) {
	header("Location: ".$baseurl."user/new/admin/done.php?e=".$email);
} else {
	die("auth error");	
}

?>