<?php 
require("../admin/db.php"); 
$error = false;

if($_GET['by'] == "coord") {
		$filtertext = $lexicon[45][$lang_set]; //Trails near me
		$filtertextsm = $filtertext;
		if(!is_numeric($_GET['lat']) || !is_numeric($_GET['lat'])) {
			$error = "coord";
			$page_type = "error";
			require("/nfs/users/clind/public_html/prescriptiontrails.org/src/nav.php");
			require("../filter/error.php");
			echo("</div>");
			require("/nfs/users/clind/public_html/prescriptiontrails.org/src/drawer.php");
			require("/nfs/users/clind/public_html/prescriptiontrails.org/src/js_base.php");
			exit();
		}
		$coords = array("lat" => $_GET['lat'], "lng" => $_GET['lng']);
		$filterObj = new trails;
		$filterResult = $filterObj->filterByLocation("coord",$coords,0,24,"Array"); 
		$filterCount = $filterResult['countReturned'];
		$totalMatched = $filterResult['totalMatched'];
		$trails = $filterResult['trails'];
		
		$showLocaiton = true;
} else {

	$allTrails = new trails;
	$result = $allTrails->getAll();
		
	$count = $result['totalMatched'];
	$trails = $result['trails'];
	
	$showLocaiton = false;

}

	function limit_text($text, $limit) {
		  if (str_word_count($text, 0) > $limit) {
			  $words = str_word_count($text, 2);
			  $pos = array_keys($words);
			  $text = substr($text, 0, $pos[$limit]) . '...';
		  }
		  return $text;
		}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Map: Trails in New Mexico - Prescription Trails</title>
    <meta name="description" content="" />
        
    <!-- Open Graph data -->
    <meta property="og:title" content="Map: Trails in New Mexico" />
    <meta property="og:url" content="<?php echo($baseurl); ?>map/" />
    <meta property="og:site_name" content="Prescription Trails" />
    <meta property="fb:admins" content="1279607446" />
    <meta property="fb:explicitly_shared" content="true" />
   
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/style_base.php"); ?>

</head>
<body class="<?php echo($bodyclass); ?>">
  
  <?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/nav.php"); ?>

	<div id="map" style="width:100%; height:85vh; margin-bottom:-42px;"></div>
          
<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/drawer.php"); ?>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/js_base.php"); ?>

<script src="fontawesome-markers.min.js"></script>
  <script>
		
var map;

<?php if($showLocaiton) { ?>

var slat = <?php echo($_GET['lat']); ?>;
var slng = <?php echo($_GET['lng']); ?>;
var zoom = 13;

<?php } else { ?>

var slat = 34.552341;
var slng = -105.847480;
var zoom = 7;

<?php } ?>

function initMap() {
  map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: slat, lng: slng},
    zoom: zoom
  });
  var infowindow = new google.maps.InfoWindow({
    content: "placeholder"
  });

<?php if($showLocaiton) { ?>

new google.maps.Marker({
    map: map,
    icon: {
        path: fontawesome.markers.CROSSHAIRS,
        scale: 0.5,
        strokeWeight: 0.3,
        strokeColor: 'black',
        strokeOpacity: 1,
        fillColor: 'green',
        fillOpacity: 0.8
    },
    clickable: false,
    position: new google.maps.LatLng(slat, slng)
});

<?php

	foreach($trails as $id => $trail) {
		if($trail['loopcount'] == 1) {
			$distance 	= $trail['loops'][1]['distance'];
			$steps 		= $trail['loops'][1]['steps'];
		} else {
				$looptext	= $trail['loopcount']." loops";
				$distance = 0;
				$steps = 0;
				foreach($trail['loops'] as $id => $details) {
					$distance 	= $trail['loops'][$id]['distance'] + $distance;
					$steps 		= $trail['loops'][$id]['steps'] + $steps;
				}
		}
?>
  var contentString<?php echo($trail['id']); ?> = '<div id="content">'+
      '<div id="bodyContent" class="center-align center" style="padding-left:25px; padding-top:20px;"><a href="<?php if($pretty_urls) { echo($trail['url']); } else { echo($baseurl."trail/?id=".$trail['id']); } ?>"><img src="<?php echo($trail['thumbURL']); ?>" style="width:200px; margin-right:5px; margin-bottom:5px;" class="center-align circle"></a>'+
	  '<p class="flow-text center-align" style="margin-top:8px; margin-bottom:8px;"><a class="green-text text-darken-3" href="<?php if($pretty_urls) { echo($trail['url']); } else { echo($baseurl."trail/?id=".$trail['id']); } ?>"><?php echo(htmlspecialchars($trail['name'])); ?></a></p>' +
      '<p><i class="fa fa-map-marker"></i> <?php echo(round($trail['distance'],2)); ?> mi away</p>' +
	  '</div>'+
      '</div>';

  var marker<?php echo($trail['id']); ?> = new google.maps.Marker({
    position: {lat: <?php echo($trail['lat']); ?>, lng: <?php echo($trail['lng']); ?>},
    map: map,
    title: '<?php echo(htmlspecialchars($trail['name'])); ?>'
  });
  marker<?php echo($trail['id']); ?>.addListener('click', function() {
	infowindow.close(); 
	infowindow.setContent(contentString<?php echo($trail['id']); ?>); 
    infowindow.open(map, this);
  });
<?php } ?>

<?php } else { ?>

	<?php
	
		foreach($trails as $id => $trail) {
			if($trail['loopcount'] == 1) {
				$distance 	= $trail['loops'][1]['distance'];
				$steps 		= $trail['loops'][1]['steps'];
			} else {
					$looptext	= $trail['loopcount']." loops";
					$distance = 0;
					$steps = 0;
					foreach($trail['loops'] as $id => $details) {
						$distance 	= $trail['loops'][$id]['distance'] + $distance;
						$steps 		= $trail['loops'][$id]['steps'] + $steps;
					}
			}
	?>
	  var contentString<?php echo($trail['id']); ?> = '<div id="content">'+
		  '<div id="siteNotice">'+
		  '</div>'+
		  '<div id="bodyContent"><a href="<?php if($pretty_urls) { echo($trail['url']); } else { echo($baseurl."trail/?id=".$trail['id']); } ?>"><img src="<?php echo($trail['thumbURL']); ?>" style="width:110px; margin-right:5px; margin-bottom:5px;" class="left"></a>'+
		  '<p class="flow-text"><a href="<?php if($pretty_urls) { echo($trail['url']); } else { echo($baseurl."trail/?id=".$trail['id']); } ?>"><?php echo(htmlspecialchars($trail['name'])); ?></a></p>' +
		  '<p><?php echo($distance); ?> miles for a total of <?php echo($steps); ?> steps.</p>' +
		  '<p><b>Address</b>: <?php echo(htmlspecialchars($trail['address'])); ?>, <?php echo($trail['city']); ?>, NM <?php echo($trail['zip']); ?></p>'+
		  '<p><b>Directions</b>: <a href="http://maps.google.com/?q=<?php echo(urlencode($trail['address'].", ". $trail['city'] . ", NM ". $trail['zip'])); ?>">Google Maps</a> | <a href="http://maps.apple.com/?address=<?php echo(urlencode($trail['address'].", ". $trail['city'] . ", NM ". $trail['zip'])); ?>">Apple Maps</a></p>'+
		  '</div>'+
		  '</div>';
	
	  var marker<?php echo($trail['id']); ?> = new google.maps.Marker({
		position: {lat: <?php echo($trail['lat']); ?>, lng: <?php echo($trail['lng']); ?>},
		map: map,
		title: '<?php echo(htmlspecialchars($trail['name'])); ?>'
	  });
	  marker<?php echo($trail['id']); ?>.addListener('click', function() {
		infowindow.close(); 
		infowindow.setContent(contentString<?php echo($trail['id']); ?>); 
		infowindow.open(map, this);
	  });
	
	<?php } ?>
    
<?php } ?>  
  
}

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGtuuf2tqUJcX_-XulhmjJuksAigifezM&callback=initMap"
        async defer></script>

  </body>
</html>
