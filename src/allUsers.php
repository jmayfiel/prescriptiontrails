<?php
require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php"); 
$adminPage = true;
require("/nfs/users/clind/public_html/prescriptiontrails.org/src/secure.php"); 

$db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
	$cols = Array ("id", "fname", "lname", "email", "is_verified" , "is_active", "is_admin");
	$result = $db->get("users", null, $cols);

$final = array();

foreach($result as $id => $user) {
		if($user['is_verified'] == 1) {
			$verified = "Verified";
		} else {
			$verified = "Unverified";
		}
		if($user['is_active'] == 1) {
			$active = "Active";
		} else {
			$active = "Inactive";
		}
		if($user['is_super'] == 1) {
			$type = "SuperUser";
		} elseif($user['is_admin'] == 1) {
			$type = "Admin";
		} else {
			$type = "User";
		}

		$newentry = array(
			"id" => $user['id'],
			"fname" => $user['fname'],
			"lname" => $user['lname'],
			"email" => $user['email'],
			"verified" => $verified,
			"status" => $active,
			"permissions" => $type,
		);
			
		array_push($final, $newentry);
}

$return = array(
	"data" => $final,
);

header('Content-Type: application/json');
echo(json_encode($return));
?>