<?php 
require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php"); 
header('Content-Type: application/json');

$all = new trails;

$result = $all->getAll();

$count = $result['totalMatched'];
$trails = $result['trails'];

$return = array();

foreach($trails as $id => $trail) {
	$returnItem['label']	= $trail['name'];
	$returnItem['value']	= $trail['id'];
	array_push($return, $returnItem);
}

echo(json_encode($return));
?>