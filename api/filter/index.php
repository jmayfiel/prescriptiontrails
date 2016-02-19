<?php 
require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php"); 
header('Content-Type: application/json');

if(!isset($_GET['offset']) || empty($_GET['count'])) {
	
	$response = array(
		"status" 	=> "error",
		"type" 		=> "MISSING",
		"message"	=> "You must include offset and count in your request. See ".$baseurl."api/"
	); 
	echo(json_encode($response));
	exit();	
}

if(intval($_GET['count']) > 50) {
	
	$response = array(
		"status" 	=> "error",
		"type" 		=> "LARGE_REQUEST",
		"message"	=> "Please request no more than 50 trail objects at a time. See ".$baseurl."api/"
	); 
	echo(json_encode($response));
	exit();	
}


 if($_GET['by'] == "city" || $_GET['by'] == "zip" || $_GET['by'] == "grade" || $_GET['by'] == "name" || $_GET['by'] == "location") {
	 if($_GET['by'] == "city" || $_GET['by'] == "zip" || $_GET['by'] == "grade" || $_GET['by'] == "name") {
			if($_GET['by'] == "city") {
				$search = $_GET['city'];
				if(in_array($_GET['city'], $cities)) {
					$filterObj = new trails;
					$filterResult = $filterObj->filterByLocation("city",filter_input(INPUT_GET, 'city', FILTER_SANITIZE_STRING),intval($_GET['offset']),intval($_GET['count']),"JSON"); 
				} else {
					$response = array(
						"status" 	=> "error",
						"type" 		=> "INVALID_CITY",
						"message"	=> "City not recognized. ".htmlspecialchars($_GET['city'])." is not in our system. Filter can be used by city, zip, grade, name, or location. See ".$baseurl."api/"
					); 
					echo(json_encode($response));
					exit();
				}
			}
			if($_GET['by'] == "zip") {
					$filterObj = new trails;
					$filterResult = $filterObj->filterByLocation("zip",intval($_GET['zip']),intval($_GET['offset']),intval($_GET['count']),"JSON"); 
			}
			if($_GET['by'] == "grade") {
					$filterObj = new trails;
					$filterResult = $filterObj->filterByLocation("grade",intval($_GET['grade']),intval($_GET['offset']),intval($_GET['count']),"JSON"); 
			}
			if($_GET['by'] == "name") {
					$term = urldecode(filter_input(INPUT_GET, 'name', FILTER_SANITIZE_STRING));
					$filterObj = new trails;
					$filterResult = $filterObj->filterByTerm($term,intval($_GET['offset']),intval($_GET['count']),"JSON"); 
			}
	 }

echo($filterResult);

 } else {
	
	$response = array(
		"status" 	=> "error",
		"type" 		=> "INVALID_REQUEST",
		"message"	=> "Request not recognized. Filter can be used by city, zip, grade, name, or location. See ".$baseurl."api/"
	); 
	 
	echo(json_encode($response));
 }
?>