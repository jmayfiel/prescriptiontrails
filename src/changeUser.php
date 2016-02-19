<?php
require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php"); 
$superPage = true;
require("/nfs/users/clind/public_html/prescriptiontrails.org/src/secure.php"); 

$id = intval($_GET['id']);
$status = $_GET['status'];

if($status == "Active") {
	$update = 0;
} else { 
	$update = 1;
}

$user = new auth;
$result = $user->toggleStatus($id, $update);

if($result) {
	header("Location: ".$baseurl."admin/report/users.php");
	exit();
} else {
	$status = array(
		"status"  => "error",
		"message" => $result
		);
}
header('Content-Type: application/json');
echo(json_encode($status));
?>