<?php

if(empty($_POST['id'])) {
	die("bad request");	
}

require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php");

if($userActive) {

$id = intval($_POST['id']);

$trail = new trail;
$trail->setID($id);

$info = $trail->getInfo("array");
$rating = $info['rating'];
$ratings = $info['ratings'];

$userRating = intval($_POST['value']);

$newRatings = $ratings + 1;
$weighted = $rating * $ratings;
$add = $weighted + $userRating;

$newRating = $add / $newRatings;

$rate = $_SESSION['data']['rate'];

if(is_array($rate)) {
	$rate[] = $id;
} else {
	$rate = array(0,$id);
}

$_SESSION['data']['rate'] = $rate;

$update = array(
	"rate" => $rate
	);

$authObj = new Auth;
$result = $authObj->setAttr($_SESSION['user_id'],$update);

$update = array(
	"rating" => $newRating,
	"ratings" => $newRatings
);

$response = $trail->setAttr($update);


if($response == "done") {
	$status = array(
		"status" => "done",
		"rating" => round($newRating,2),
		"ratings" => $newRatings
		);
} else {
	$status = array(
		"status"  => "error",
		"message" => $result
		);
}

} else {
	$status = array(
		"status"  => "error",
		"message" => "unauth"
		);
}


header('Content-Type: application/json');
echo(json_encode($status));

?>