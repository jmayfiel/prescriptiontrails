<?php
require("../admin/db.php"); 
$adminPage = true;
require("secure.php"); 

$id = intval($_POST['id']);
$published = $_POST['value'];

$update = array(
	"published" => $published
	);

$trailObj = new trail;
$trailObj->setID($id);
$result = $trailObj->setAttr($update);

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