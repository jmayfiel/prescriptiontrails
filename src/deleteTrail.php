<?php
require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php"); 
$adminPage = true;
require("/nfs/users/clind/public_html/prescriptiontrails.org/src/secure.php"); 

$id = intval($_POST['id']);

$trailObj = new trail;
$trailObj->setID($id);
$result = $trailObj->deleteTrail();

if($result == "done") {
	$status = array(
		"status" => $result
		);
} else {
	$status = array(
		"status"  => "error",
		"message" => $result
		);
}
header('Content-Type: application/json');
echo(json_encode($status));
?>