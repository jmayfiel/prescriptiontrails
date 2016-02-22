<?php 
require("../../admin/db.php"); 
if($_GET['maintainAdmin'] == "yes") {
	$adminPage = true;
	require("../../src/secure.php"); 
}
header('Content-Type: application/json');

if(!isset( $_GET['id'] ) || empty( $_GET['id'] )) {
	$response = array(
		"status" 	=> "error",
		"type" 		=> "MISSING_ID",
		"message"	=> "The trail ID was not provided in the request. See ".$baseurl."api/"
	); 
	echo(json_encode($response));
	exit();	
}
if(!is_numeric($_GET['id']) && $error === false) {
	$response = array(
		"status" 	=> "error",
		"type" 		=> "INVALID_ID",
		"message"	=> "The trail ID should be an integer. '" . htmlspecialchars($_GET['id']) . "' is an invalid id value. See ".$baseurl."api/"
	); 
	echo(json_encode($response));
	exit();	
}

	$trailObj = new trail;
	$trailObj->setID(intval($_GET['id']));
	$trail = $trailObj->getInfo("JSON");
	if($trail == "Etrail") {
		$response = array(
			"status" 	=> "error",
			"type" 		=> "UNKNOWN_ID",
			"message"	=> "The trail ID '" . htmlspecialchars($_GET['id']) . "' was not found in our database. It may have been deleted from our system. Please contact us if you have any questions or concerns. See ".$baseurl."api/"
		); 
		echo(json_encode($response));
		exit();	
	} else {
		echo($trail);
	}
	
