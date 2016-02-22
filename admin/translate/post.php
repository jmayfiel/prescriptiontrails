<?php 
require("../db.php"); 
$adminPage = true;
require("../../src/secure.php"); 
$db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if(empty($_POST['desc']) || empty($_POST['surface']) || empty($_POST['parking']) || empty($_POST['facilities'])) {
	header("Location: ".$baseurl."admin/translate/?error=true&id=".$_POST['id']."&lang=".$_POST['lang']);
	exit();	
}

    $id 			= $_POST['id'];
    $lang 			= $_POST['lang'];
    $facilities		= $_POST['facilities'];
    $lighting 		= $_POST['lighting'];
    $surface 		= $_POST['surface'];
    $transit 		= $_POST['transit'];
    $parking 		= $_POST['parking'];
    $desc 			= rawurlencode($_POST['desc']);
    $hours	 		= $_POST['hours'];
    $loopcount	 	= $_POST['loopcount'];
    $attractioncount= $_POST['attractioncount'];
    $postaction		= $_POST['postaction'];
    $trans_id		= $_POST['trans_id'];
	

	$attractions = array();
	$i = 0;
	while($i <= $attractioncount) {
		array_push($attractions, rawurlencode($_POST['attraction'.$i]));
		$i++;
	}

	$loops = array();
	$i = 1;
	while($i <= $loopcount) {
		$loops[$i]["name"] = $_POST['loop'.$i];
		$i++;
	}

$data = array(
    'trail_id' => $id,
    'lang' => $lang,
    'desc' => $desc,
    'lighting' => $lighting,
    'surface' => $surface,
    'parking' => $parking,
    'facilities' => $facilities,
    'hours' => $hours,
    'attractions' => addslashes(json_encode($attractions)),
    'loops' => addslashes(json_encode($loops)),
);

if($postaction == "update") {
	$db->where ('id', $trans_id);
	if ($db->update ('translations', $data)) {
		header("Location: ".$baseurl."admin/translate/done.php?status=update&id=".$id."&lang=".$lang);
	} else {
		echo 'update failed: ' . $db->getLastError();	
	}
} else {
	$id = $db->insert ('translations', $data);
	if ($id) {
		header("Location: ".$baseurl."admin/translate/done.php?id=".$id."&lang=".$lang);
	} else {
		echo 'insert failed: ' . $db->getLastError();
	}
}

?>