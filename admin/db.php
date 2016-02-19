<?php
$userActive = false;
$providerPage = false;
$superPage = false;
$adminPage = false;
require '../vendor/autoload.php';
require '../src/minifyHTML.php';

$pretty_urls = true;

$db_host = ''; //Your info here
$db_username = ''; //Your info here
$db_password = ''; //Your info here
$db_database = ''; //Your info here
define('DB_HOST', $db_host);
define('DB_USERNAME', $db_username);
define('DB_PASSWORD', $db_password);
define('DB_DATABASE', $db_database);


$baseurl = "http://prescriptiontrails.org/";
define('BASE_URL', $baseurl);
$bodyclass = "bodyBkg";

require_once('MysqliDb.php');

$cities = array("Albuquerque", "Chaves County", "Grant County", "Las Cruces", "Otero County", "Lincoln County", "Rio Rancho", "Santa Fe");

require("../src/lexicon.php");

$lang_set = "en";
if(in_array($_COOKIE['lang'], $lang_available)) {
	$lang_set = $_COOKIE['lang'];	
}

class trail
{
 
  public $trailID = "undefined";
 
  public function setID($ID)
  {
      $this->trailID = $ID;
  }

	public function slugify($text)
	{ 
	  // replace non letter or digits by -
	  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
	
	  // trim
	  $text = trim($text, '-');
	
	  // transliterate
	  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	
	  // lowercase
	  $text = strtolower($text);
	
	  // remove unwanted characters
	  $text = preg_replace('~[^-\w]+~', '', $text);
	
	  if (empty($text))
	  {
		return 'n-a';
	  }
	
	  return $text;
	}
 
  public function setAttr($attribute)
  {
	 if($this->trailID == "undefined") {
		 return "Trail ID has not been defined. Call setID($ID) before requesting data.";
	 } else {
		 $db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
			$db->where("id", $this->trailID);
			if($db->has("trails")) {

				$db->where ('id', $this->trailID);
				if ($db->update ('trails', $attribute))
					return 'done';
				else
					return 'update failed: ' . $db->getLastError();

			} else {
				return "Etrail";
			}
	 }
  }
  public function deleteTrail()
  {
	 if($this->trailID == "undefined") {
		 return "Trail ID has not been defined. Call setID($ID) before requesting data.";
	 } else {
		 $db = new MysqliDb(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
			$db->where("id", $this->trailID);
			if($db->has("trails")) {

				$db->where ('id', $this->trailID);
				if ($db->delete('trails'))
					return 'done';
				else
					return 'update failed: ' . $db->getLastError();

			} else {
				return "Etrail";
			}
	 }
  }
  public function getInfo($format)
  {
	 if($this->trailID == "undefined") {
		 return "Trail ID has not been defined. Call setID($ID) before requesting data.";
	 } else {
		 $db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
		  $db->where ("id", $this->trailID);
			if($db->has("trails")) {
			  $db->where ("id", $this->trailID);
			  $result = $db->getOne("trails");
			  $attractions = json_decode(stripslashes($result['attractions']));
			  $result['attractions'] = $attractions;
			  $loops = json_decode(stripslashes($result['loops']));
			  $result['loops'] = array();
			  foreach ($loops as $id => $data) {
				  $result['loops'][$id] = (array) $data;
			  }
			  
			  $result['satImgURL'] = BASE_URL . $result['satImgURL'];
			  $result['largeImgURL'] = BASE_URL . $result['largeImgURL'];
			  $result['thumbURL'] = BASE_URL . $result['thumbURL'];
			  $result['url'] = BASE_URL . "trail/" . $result['id'] . "/" . $this->slugify($result['name']) . "/";
		  $db->where ("trail_id", $this->trailID);
			if($db->has("translations")) {
			  $db->where ("trail_id", $this->trailID);
			  $result2 = $db->get("translations");
			  $translations = array();
			  foreach($result2 as $id => $translation) {
				  array_push($translations, $translation['lang']);
			  }
			  $result['translations'] = $translations;
			} else {
			   $result['translations'] = "none";
			}
			  if($format == "JSON") {
				  return json_encode($result);
			  } elseif($format == "XML") {		
					return "Maybe someday..";
			  } else {
				  return $result;
			  }
			} else {
				return "Etrail";
			}
	 }
  }
  public function getTranslation($lang,$format)
  {
	 if($this->trailID == "undefined") {
		 return "Trail ID has not been defined. Call setID($ID) before requesting data.";
	 } else {
		 $db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
		  $db->where ("trail_id", $this->trailID);
		  $db->where ("lang", $lang);
			if($db->has("translations")) {
			  $db->where ("trail_id", $this->trailID);
			  $db->where ("lang", $lang);
			  $result = $db->getOne("translations");
			  $attractions = json_decode(stripslashes($result['attractions']));
			  $result['attractions'] = $attractions;
			  $loops = json_decode(stripslashes($result['loops']));
			  $result['loops'] = $loops;	
			  if($format == "JSON") {
				  return json_encode($result);
			  } elseif($format == "XML") {		
					return "Maybe someday..";
			  } else {
				  return $result;
			  }
			} else {
				return "Elang";
			}
	 }
  }
}
 
 

class trails
{
	
	public function slugify($text)
	{ 
	  // replace non letter or digits by -
	  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
	
	  // trim
	  $text = trim($text, '-');
	
	  // transliterate
	  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	
	  // lowercase
	  $text = strtolower($text);
	
	  // remove unwanted characters
	  $text = preg_replace('~[^-\w]+~', '', $text);
	
	  if (empty($text))
	  {
		return 'n-a';
	  }
	
	  return $text;
	}
	
  public function getRand()
	{
		$db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
			  $db->where ("published", "true");
			  $result = $db->get("trails");
			  $trails = array();
			  foreach($result as $id => $trail) {
				  $trails[$trail['id']] = $trail;
				  $attractions = json_decode(stripslashes($trail['attractions']));
				  $trails[$trail['id']]['attractions'] = $attractions;
				  $loops = json_decode(stripslashes($trail['loops']));
				  $trails[$trail['id']]['loops'] = array();
				  foreach ($loops as $id => $data) {
					  $trails[$trail['id']]['loops'][$id] = (array) $data;
				  }
				  
				  $trails[$trail['id']]['satImgURL'] = BASE_URL . $trail['satImgURL'];
				  $trails[$trail['id']]['largeImgURL'] = BASE_URL . $trail['largeImgURL'];
				  $trails[$trail['id']]['thumbURL'] = BASE_URL . $trail['thumbURL'];
				  $trails[$trail['id']]['url'] = BASE_URL . "trail/" . $trail['id'] . "/" . $this->slugify($trail['name']) . "/";
			  }
			  $total = count($trails);
				  $response['trails'] = $trails;
				  $response['totalMatched'] = $total;
				  return $response;	
	}

  public function getReport($column, $condition)
	{
		$db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
			  $db->where ($column, $condition);
			  $result = $db->get("trails");
			  $trails = array();
			  foreach($result as $id => $trail) {
				  $trails[$trail['id']] = $trail;
				  $attractions = json_decode(stripslashes($trail['attractions']));
				  $trails[$trail['id']]['attractions'] = $attractions;
				  $loops = json_decode(stripslashes($trail['loops']));
				  $trails[$trail['id']]['loops'] = array();
				  foreach ($loops as $id => $data) {
					  $trails[$trail['id']]['loops'][$id] = (array) $data;
				  }
				  
				  $trails[$trail['id']]['satImgURL'] = BASE_URL . $trail['satImgURL'];
				  $trails[$trail['id']]['largeImgURL'] = BASE_URL . $trail['largeImgURL'];
				  $trails[$trail['id']]['thumbURL'] = BASE_URL . $trail['thumbURL'];
				  $trails[$trail['id']]['url'] = BASE_URL . "trail/" . $trail['id'] . "/" . $this->slugify($trail['name']) . "/";
			  }
			  $total = count($trails);
				  $response['trails'] = $trails;
				  $response['totalMatched'] = $total;
				  return $response;	
	}

  public function getAll()
	{
		$db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
			  $result = $db->get("trails");
			  $trails = array();
			  foreach($result as $id => $trail) {
				  $trails[$trail['id']] = $trail;
				  $attractions = json_decode(stripslashes($trail['attractions']));
				  $trails[$trail['id']]['attractions'] = $attractions;
				  $loops = json_decode(stripslashes($trail['loops']));
				  $trails[$trail['id']]['loops'] = array();
				  foreach ($loops as $id => $data) {
					  $trails[$trail['id']]['loops'][$id] = (array) $data;
				  }
				  
				  $trails[$trail['id']]['satImgURL'] = BASE_URL . $trail['satImgURL'];
				  $trails[$trail['id']]['largeImgURL'] = BASE_URL . $trail['largeImgURL'];
				  $trails[$trail['id']]['thumbURL'] = BASE_URL . $trail['thumbURL'];
				  $trails[$trail['id']]['url'] = BASE_URL . "trail/" . $trail['id'] . "/" . $this->slugify($trail['name']) . "/";
			  }
			  $total = count($trails);
				  $response['trails'] = $trails;
				  $response['totalMatched'] = $total;
				  return $response;	
	}

  public function getAllPrint()
	{
		$db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
			  $db->orderBy("city","Desc");
			  $result = $db->get("trails");
			  $trails = array();
			  foreach($result as $id => $trail) {
				  $trails[$trail['id']] = $trail;
				  $attractions = json_decode(stripslashes($trail['attractions']));
				  $trails[$trail['id']]['attractions'] = $attractions;
				  $loops = json_decode(stripslashes($trail['loops']));
				  $trails[$trail['id']]['loops'] = array();
				  foreach ($loops as $id => $data) {
					  $trails[$trail['id']]['loops'][$id] = (array) $data;
				  }
				  
				  $trails[$trail['id']]['satImgURL'] = BASE_URL . $trail['satImgURL'];
				  $trails[$trail['id']]['largeImgURL'] = BASE_URL . $trail['largeImgURL'];
				  $trails[$trail['id']]['thumbURL'] = BASE_URL . $trail['thumbURL'];
				  $trails[$trail['id']]['url'] = BASE_URL . "trail/" . $trail['id'] . "/" . $this->slugify($trail['name']) . "/";
			  }
			  $total = count($trails);
				  $response['trails'] = $trails;
				  $response['totalMatched'] = $total;
				  return $response;	
	}


  public function getAllSheet()
	{
		$db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
			  $result = $db->get("trails");
			  $trails = array();
			  foreach($result as $id => $trail) {
				  $trails[$trail['id']] = $trail;
				  $attractions = json_decode(stripslashes($trail['attractions']));
				  $trails[$trail['id']]['attractions'] = $attractions;
				  $loops = json_decode(stripslashes($trail['loops']));
				  $trails[$trail['id']]['loops'] = array();
				  foreach ($loops as $id => $data) {
					  $trails[$trail['id']]['loops'][$id] = (array) $data;
				  }
				  $db->where ("trail_id", $trail['id']);
					if($db->has("translations")) {
					  $db->where ("trail_id", $trail['id']);
					  $result2 = $db->get("translations");
					  $translations = array();
					  foreach($result2 as $id => $translation) {
						  array_push($translations, $translation['lang']);
					  }
					  $trails[$trail['id']]['translations'] = $translations;
					} else {
					   $trails[$trail['id']]['translations'] = "none";
					}
				  $trails[$trail['id']]['satImgURL'] = BASE_URL . $trail['satImgURL'];
				  $trails[$trail['id']]['largeImgURL'] = BASE_URL . $trail['largeImgURL'];
				  $trails[$trail['id']]['thumbURL'] = BASE_URL . $trail['thumbURL'];
				  $trails[$trail['id']]['url'] = BASE_URL . "trail/" . $trail['id'] . "/" . $this->slugify($trail['name']) . "/";
			  }
			  $total = count($trails);
				  $response['trails'] = $trails;
				  $response['totalMatched'] = $total;
				  return $response;	
	}

  
  public function filterByLocation($type,$query,$offset,$count,$format,$override="no")
  {
	
	if($type == "coord") {
		$lat = $query['lat'];
		$lng = $query['lng'];
		$db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
			$result = $db->rawQuery('SELECT *, ( 3959 * acos( cos( radians(?) ) * cos( radians( `lat` ) ) * cos( radians( `lng` ) - radians(?) ) + sin( radians(?) ) * sin(radians(`lat`)) ) ) AS distance 
										FROM trails 
										HAVING distance < 50 
										ORDER BY distance 
										LIMIT ? , ?;', Array ($lat, $lng, $lat, $offset, $count));
				  $trails = array();
				  foreach($result as $id => $trail) {
					  $trails[$trail['id']] = $trail;
					  $attractions = json_decode(stripslashes($trail['attractions']));
					  $trails[$trail['id']]['attractions'] = $attractions;
					  $loops = json_decode(stripslashes($trail['loops']));
					  $trails[$trail['id']]['loops'] = array();
					  foreach ($loops as $id => $data) {
						  $trails[$trail['id']]['loops'][$id] = (array) $data;
					  }
					  
					  $trails[$trail['id']]['satImgURL'] = BASE_URL . $trail['satImgURL'];
					  $trails[$trail['id']]['largeImgURL'] = BASE_URL . $trail['largeImgURL'];
					  $trails[$trail['id']]['thumbURL'] = BASE_URL . $trail['thumbURL'];
					  $trails[$trail['id']]['url'] = BASE_URL . "trail/" . $trail['id'] . "/" . $this->slugify($trail['name']) . "/";
				  }
				  $total = count($trails);
				  $trails = array_slice($trails, $offset, $count);
					  $response['trails'] = $trails;
					  $response['countReturned'] = count($trails);
					  $response['totalMatched'] = $total;
				  if($format == "JSON") {
					  return json_encode($response);
				  } elseif($format == "XML") {		
						return "Maybe someday..";
				  } else {
					  return $response;
				  }
	} else {

		  if($type == "city") {
			$by = "city";  
		  }
		  if($type == "zip") {
			$by = "zip";  
		  }
		  if($type == "grade") {
			$by = "difficulty";  
		  }
			 $db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
				  $db->where($by, $query);
				  if($override != "showUnpublished") {
					  $db->where ("published", "true");
				  }
				  $result = $db->get("trails");
				  $trails = array();
				  foreach($result as $id => $trail) {
					  $trails[$trail['id']] = $trail;
					  $attractions = json_decode(stripslashes($trail['attractions']));
					  $trails[$trail['id']]['attractions'] = $attractions;
					  $loops = json_decode(stripslashes($trail['loops']));
					  $trails[$trail['id']]['loops'] = array();
					  foreach ($loops as $id => $data) {
						  $trails[$trail['id']]['loops'][$id] = (array) $data;
					  }
					  
					  $trails[$trail['id']]['satImgURL'] = BASE_URL . $trail['satImgURL'];
					  $trails[$trail['id']]['largeImgURL'] = BASE_URL . $trail['largeImgURL'];
					  $trails[$trail['id']]['thumbURL'] = BASE_URL . $trail['thumbURL'];
					  $trails[$trail['id']]['url'] = BASE_URL . "trail/" . $trail['id'] . "/" . $this->slugify($trail['name']) . "/";
				  }
				  $total = count($trails);
				  $trails = array_slice($trails, $offset, $count);
					  $response['trails'] = $trails;
					  $response['countReturned'] = count($trails);
					  $response['totalMatched'] = $total;
				  if($format == "JSON") {
					  return json_encode($response);
				  } elseif($format == "XML") {		
						return "Maybe someday..";
				  } else {
					  return $response;
				  }
				  
		}
  	}

  public function filterByTerm($query,$offset,$count,$format,$override="no")
  {
	if($override != "yes") {
		$published = "AND published = 'true'";	
	} else {
		$published = "";
	}
		$db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
			$term = "%".$query."%";
			$result = $db->rawQuery('SELECT * 
										FROM trails 
										WHERE name LIKE ? '.$published.'
										LIMIT ? , ?;', array($term, $offset, $count));
				  $trails = array();
				  foreach($result as $id => $trail) {
					  $trails[$trail['id']] = $trail;
					  $attractions = json_decode(stripslashes($trail['attractions']));
					  $trails[$trail['id']]['attractions'] = $attractions;
					  $loops = json_decode(stripslashes($trail['loops']));
					  $trails[$trail['id']]['loops'] = array();
					  foreach ($loops as $id => $data) {
						  $trails[$trail['id']]['loops'][$id] = (array) $data;
					  }
					  
					  $trails[$trail['id']]['satImgURL'] = BASE_URL . $trail['satImgURL'];
					  $trails[$trail['id']]['largeImgURL'] = BASE_URL . $trail['largeImgURL'];
					  $trails[$trail['id']]['thumbURL'] = BASE_URL . $trail['thumbURL'];
					  $trails[$trail['id']]['url'] = BASE_URL . "trail/" . $trail['id'] . "/" . $this->slugify($trail['name']) . "/";
				  }
				  $total = count($trails);
				  $trails = array_slice($trails, $offset, $count);
					  $response['trails'] = $trails;
					  $response['countReturned'] = count($trails);
					  $response['totalMatched'] = $total;
				  if($format == "JSON") {
					  return json_encode($response);
				  } elseif($format == "XML") {		
						return "Maybe someday..";
				  } else {
					  return $response;
				  }
  	}



}

 
$titles = array(
	"md" => array(
				"title" => "Physician",
				"degree" => "MD",
			),
	"do" => array(
				"title" => "Physician",
				"degree" => "DO",
			),
	"np" => array(
				"title" => "Nurse Practitioner",
				"degree" => "NP",
			),
	"npc" => array(
				"title" => "Nurse Practitioner",
				"degree" => "NP-C",
			),
	"cfnp" => array(
				"title" => "Nurse Practitioner",
				"degree" => "CFNP",
			),
	"aprnbc" => array(
				"title" => "Nurse Practitioner",
				"degree" => "APRN, BC",
			),
	"pac" => array(
				"title" => "Physician Assistant",
				"degree" => "PA-C",
			),
	"pa" => array(
				"title" => "Physician Assistant",
				"degree" => "PA",
			),
	"pharmd" => array(
				"title" => "Pharmacist",
				"degree" => "PharmD",
			),
	"pd" => array(
				"title" => "Pharmacist",
				"degree" => "PD",
			),
	"mpharm" => array(
				"title" => "Pharmacist",
				"degree" => "MPharm",
			),
	"cnm" => array(
				"title" => "Midwife",
				"degree" => "CNM",
			),
	"dpt" => array(
				"title" => "Physical Therapist",
				"degree" => "DPT",
			),
	"pt" => array(
				"title" => "Physical Therapist",
				"degree" => "PT",
			),
	"rnbsn" => array(
				"title" => "Nurse",
				"degree" => "RN, BSN",
			),
	"rn" => array(
				"title" => "Nurse",
				"degree" => "RN",
			),
	"phd" => array(
				"title" => "Any PhD",
				"degree" => "PhD",
			),
); 
 

class activity
{
  
  public function newLog($uid,$type,$distance,$steps,$time,$date,$trail_id=null,$trail_name=null)
  {
	  $db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
	  
	  $data = array(
	  	"uid" => $uid,
		"type" => $type,
		"trail_id" => $trail_id,
		"distance" => $distance,
		"steps" => $steps,
		"time" => $time,
		"trail_name" => $trail_name,
		"date" => $date
	  );
	  
	  $id = $db->insert ('activities', $data);
		if ($id) {
			$return = array(
				"status" => "done",
				"id" => $id,
			);
		} else {
			$return = array(
				"status" 	=> "error",
				"message" 	=> "A MySQLi error has occurred.",
				"tech"		=> $db->getLastError()
			);
		}

	return $return;
	
  }
  public function getUserReport($uid)
  {
	  $db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
	  $db->where('uid', $uid);
	  $db->orderBy("id","Desc");
	  $result = $db->get("activities");
		
	return $result;
	
  }

}
 
require("../src/auth.php");

$userCheck = new Auth;
if($userCheck->checkSession() == "auth") {
	$userActive = true;
}
header("X-XSS-Protection: 1; mode=block");
header("X-Frame-Options: sameorigin");
?>