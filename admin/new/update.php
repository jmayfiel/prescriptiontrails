<?php
require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php"); 
$adminPage = true;
require("/nfs/users/clind/public_html/prescriptiontrails.org/src/secure.php"); 
$db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if(empty($_POST['name']) || empty($_POST['city']) || empty($_POST['zip']) || empty($_POST['crossstreets']) || empty($_POST['address']) || empty($_POST['lat']) || empty($_POST['lng']) || empty($_POST['desc']) || empty($_POST['lighting']) || empty($_POST['difficulty']) || empty($_POST['surface']) || empty($_POST['parking']) || empty($_POST['hours']) || empty($_POST['loopcount']) || empty($_POST['loop1name']) || empty($_POST['loop1distance']) || empty($_POST['loop1steps']) || empty($_POST['satImgURL']) || empty($_POST['thumbURL']) || empty($_POST['largeImgURL']) || empty($_POST['publish'])) {
	header("Location: ".$baseurl."admin/new/?error=true");
	exit();	
}

    $name 			= $_POST['name'];
    $city 			= $_POST['city'];
    $zip 			= $_POST['zip'];
    $crossstreets 	= $_POST['crossstreets'];
    $address 		= $_POST['address'];
    $transit 		= $_POST['transit'];
    $lat 			= $_POST['lat'];
		$lat = round(floatval($lat), 7);
		
    $lng 			= $_POST['lng'];
		$lng = round(floatval($lng), 7);
		
    $desc 			= rawurlencode($_POST['desc']);
    $lighting 		= $_POST['lighting'];
    $difficulty 	= $_POST['difficulty'];
    $surface 		= $_POST['surface'];
    $parking 		= $_POST['parking'];
    $facilities 	= $_POST['facilities'];
    $hours 			= $_POST['hours'];
    $loopcount 		= $_POST['loopcount'];
    $satImgURL 		= $_POST['satImgURL'];
    $largeImgURL 	= $_POST['largeImgURL'];
    $thumbURL 		= $_POST['thumbURL'];
    $attrArray 		= explode(',',$_POST['attrArray']);
    $loopcount 		= $_POST['loopcount'];
    $published 		= $_POST['publish'];
	

	$attractions = array();
	foreach($attrArray as $index => $attractionID) {
		array_push($attractions, rawurlencode($_POST['attraction'.$attractionID]));
	}

	$loops = array();
	$i = 1;
	while($i <= $loopcount) {
		$loops[$i]["name"] = $_POST['loop'.$i.'name'];
		$loops[$i]["distance"] = $_POST["loop".$i."distance"];
		$loops[$i]["steps"] = intval($_POST["loop".$i."steps"]);
		$i++;
	}


$data = array(
    'name' => $name,
    'city' => $city,
    'zip' => $zip,
    'crossstreets' => $crossstreets,
    'address' => $address,
    'transit' => $transit,
    'lat' => $lat,
    'lng' => $lng,
    'desc' => $desc,
    'lighting' => $lighting,
    'difficulty' => $difficulty,
    'surface' => $surface,
    'parking' => $parking,
    'facilities' => $facilities,
    'hours' => $hours,
    'loopcount' => $loopcount,
    'satImgURL' => $satImgURL,
    'largeImgURL' => $largeImgURL,
    'thumbURL' => $thumbURL,
    'attractions' => addslashes(json_encode($attractions)),
    'loops' => addslashes(json_encode($loops)),
    'published' => $published,
);


$db->where ('id', $_POST['id']);
if ($db->update ('trails', $data))
	header("Location: ".$baseurl."admin/new/done.php?type=update&id=".$_POST['id']);
else
	return 'update failed: ' . $db->getLastError();

?>