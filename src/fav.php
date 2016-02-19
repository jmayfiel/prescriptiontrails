<?php

function remove_array_item( $array, $item ) {
	$index = array_search($item, $array);
	if ( $index !== false ) {
		unset( $array[$index] );
	}

	return $array;
}


if(empty($_POST['id'])) {
	die("bad request");	
}

require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php");

if($userActive) {

$id = intval($_POST['id']);

$trail = new trail;
$trail->setID($id);

$info = $trail->getInfo("array");
$favCount = $info['favorites'];

$fav = $_SESSION['data']['fav'];

if($_POST['value'] == "yes") {
	if(is_array($fav)) {
		$fav[] = $id;
		$message = "added ".$id;
	} else {
		$fav = array(0,$id);
		$message = "added ".$id;
	}
	$favCount = $favCount + 1;
} else {
	$fav = remove_array_item($fav, $id);
		$message = "removed ".$id;
	$favCount = $favCount - 1;
}

$_SESSION['data']['fav'] = $fav;

$update = array(
	"fav" => $fav
	);

$authObj = new Auth;
$result = $authObj->setAttr($_SESSION['user_id'],$update);

if($result == true) {
	$status = array(
		"status" => "done",
		"message" => $message
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

$attr = array(
	"favorites" => $favCount
);
$trail->setAttr($attr);

header('Content-Type: application/json');
echo(json_encode($status));

?>