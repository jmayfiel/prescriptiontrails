<?php
require("../../admin/db.php");
require("../../src/secure.php"); 

$allTrailObj = new trails;
$allTrails = $allTrailObj->getAll(); 

$trails = $allTrails['trails'];

$favorites = array();

foreach($trails as $id => $trail) {

	if(in_array($trail['id'], $_SESSION['data']['fav'])) {
		$favorites[$trail['id']] = $trail;
	}
	
}

krsort($favorites);
$count = count($favorites);
if($_GET['count'] == "show") {
	$return['trails'] = array_slice($favorites, 0, 5);
} else {
	$return['trails'] = $favorites;
}

$return['count'] = $count;
$favorites = $return;
	
header('Content-Type: application/json');
echo(json_encode($favorites));
?>