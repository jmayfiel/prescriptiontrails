<?php
//settings
$cache_ext  = '.js'; //file extension
$cache_time     = 3600 * 24;  //Cache file expires afere these seconds (1 hour = 3600 sec)
$cache_folder   = 'cache/'; //folder to store Cache files
$ignore_pages   = array('', '');

$dynamic_url    = 'https://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; // requested dynamic page (full url)
$cache_file     = $cache_folder.md5($dynamic_url).$cache_ext; // construct a cache file
$ignore = (in_array($dynamic_url,$ignore_pages))?true:false; //check if url is in ignore list

if (!$ignore && file_exists($cache_file) && time() - $cache_time < filemtime($cache_file)) { //check Cache exist and it's not expired.
    ob_start('ob_gzhandler'); //Turn on output buffering, "ob_gzhandler" for the compressed page with gzip.
    echo '/* cached page - '.date('l jS \of F Y h:i:s A', filemtime($cache_file)).', Page : '.$dynamic_url.' */';
    readfile($cache_file); //read Cache file
	$output = ob_get_contents();
	ob_end_clean();
	header('Content-Type: application/javascript');
	echo($output);
    exit(); //no need to proceed further, exit the flow.
}
//Turn on output buffering with gzip compression.
ob_start(); 
######## Your Website Content Starts Below #########

require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php");
$randomtrailObj = new trails;
$navTrails = $randomtrailObj->getAll();
$navTrails = $navTrails['trails'];
header('Content-Type: application/javascript');
ob_start(); ?>
  map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 35.104912, lng: -106.629581},
    scrollwheel: false,
    zoom: 11
  });
  var infowindow = new google.maps.InfoWindow({
    content: "placeholder"
  });

<?php

	foreach($navTrails as $id => $trail) {
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
<?php  
if (!is_dir($cache_folder)) { //create a new folder if we need to
    mkdir($cache_folder);
}
if(!$ignore){
    $fp = fopen($cache_file, 'w');  //open file for writing
	$output = minify_js(ob_get_contents());
	ob_end_clean();
    fwrite($fp, $output); //write contents of the output buffer in Cache file
    fclose($fp); //Close file pointer
	echo($output);
}

$output = ob_get_contents();
ob_end_clean();

echo(minify_js($output));
?>