<?php

if(empty($_POST['type'])) {
	die("bad request");	
}

require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php");

if($userActive) {

	$type		 = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
	$distance	 = filter_input(INPUT_POST, 'distance', FILTER_SANITIZE_STRING);
	$steps		 = filter_input(INPUT_POST, 'steps', FILTER_SANITIZE_NUMBER_INT);
	$time		 = filter_input(INPUT_POST, 'time', FILTER_SANITIZE_NUMBER_INT);
	$date		 = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);

	$activity = new activity;
	
	if($type == "trail") {
		$trail_id	 = filter_input(INPUT_POST, 'trail_id', FILTER_SANITIZE_NUMBER_INT);
		$trail_name	 = filter_input(INPUT_POST, 'trail_name', FILTER_SANITIZE_STRING);
		$status		 = $activity->newLog($_SESSION['user_id'], $type, $distance, $steps, $time, $date, $trail_id, $trail_name);
	} else {
		$status		 = $activity->newLog($_SESSION['user_id'], $type, $distance, $steps, $time, $date, 0, "Custom Trail");
	}

	header('Content-Type: application/json');
	echo(json_encode($status));

} else {
	header('Content-Type: application/json');
	echo(json_encode(array("status" => "error", "message" => "Unauth")));
}
?>