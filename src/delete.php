<?php
require("../admin/db.php"); 
if(!$userActive) {
	exit("sadface");
}

$id = intval($_GET['id']);

$db->where('id', $id);

if($db->delete('trails')) {
	header("Location: ".$baseurl."admin/?delete=done");
} else {
	$status = array(
		"status"  => "error",
		"message" => $db->getLastError()
		);
}
echo(json_encode($status));
?>