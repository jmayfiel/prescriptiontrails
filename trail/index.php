<?php 
require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php"); 
require("/nfs/users/clind/public_html/prescriptiontrails.org/trail/Html2Text.php"); 
$error = false;

if(!isset( $_GET['id'] ) || empty( $_GET['id'] )) {
	$error = true;
	$error_type = "missing_id";
	$error_details = "The trail ID was not provided in the request.<br><br>";
}
if(!is_numeric($_GET['id']) && $error === false) {
	$error = true;
	$error_type = "invalid_id";
	$error_details = "The trail ID should be an integer. '" . htmlspecialchars($_GET['id']) . "' is an invalid id value.";
}


if(!$error) {
	
	$trailObj = new trail;
	$trailObj->setID(intval($_GET['id']));
	$trail = $trailObj->getInfo("Array");
	if($trail == "Etrail") {
		//ERROR - Trail does not exist
		$error = true;
		$error_type = "unknown_id";
		$error_details = "The trail ID '" . htmlspecialchars($_GET['id']) . "' was not found in our database. It may have been deleted from our system. Please contact us if you have any questions or concerns.";
	} else {
		//Continue
	}
	
}

if(!$error) {

ini_set('display_errors', 1);
ini_set('display_startup_errors', 0);
error_reporting(E_ERROR | E_PARSE);
$page_type = "trail";

	if($trail['loopcount'] == 1) {
		if($lang_set == "es") {
			$looptext = "un trayectoria";
		} else {
			$looptext	= "one loop";
		}
		$distance 	= $trail['loops'][1]['distance'];
		$steps 		= $trail['loops'][1]['steps'];
	} else {
		if($lang_set == "es") {
			$looptext = $trail['loopcount']." trajectorias";
		} else {
			$looptext	= $trail['loopcount']." loops";
		}
		$distance = 0;
		$steps = 0;
		foreach($trail['loops'] as $id => $details) {
			$distance 	= $trail['loops'][$id]['distance'] + $distance;
			$steps 		= $trail['loops'][$id]['steps'] + $steps;
		}
	}
	
	
	function limit_text($text, $limit) {
		  if (str_word_count($text, 0) > $limit) {
			  $words = str_word_count($text, 2);
			  $pos = array_keys($words);
			  $text = substr($text, 0, $pos[$limit]) . '...';
		  }
		  return $text;
		}
	
	$html = new \Html2Text\Html2Text(rawurldecode($trail['desc']));
	
	$metaDesc = str_replace("\n", ' ', $html->getText());

} else {
	
	header("HTTP/1.0 404 Not Found");
	
}
if($userActive) {
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past	
} else {
	//get the last-modified-date of this very file
	$lastModified = $trail['ModifiedTime'];
	//get a unique hash of this file (etag)
	$etagFile = md5_file(__FILE__);
	//get the HTTP_IF_MODIFIED_SINCE header if set
	$ifModifiedSince=(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : false);
	//get the HTTP_IF_NONE_MATCH header if set (etag: unique file hash)
	$etagHeader=(isset($_SERVER['HTTP_IF_NONE_MATCH']) ? trim($_SERVER['HTTP_IF_NONE_MATCH']) : false);
	
	//set last-modified header
	header("Last-Modified: ".gmdate(DATE_RFC1123, $lastModified)." GMT");
	//set etag-header
	header("Etag: $etagFile");
	//make sure caching is turned on
	header('Cache-Control: public');
	
	//check if page has changed. If not, send 304 and exit
	if (@strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE'])==strtotime($lastModified) || $etagHeader == $etagFile)
	{
		   header("HTTP/1.1 304 Not Modified");
		   exit;
	}
}
$looptranslation = false;
if($lang_set != "en") {
	if(in_array($lang_set, $trail['translations'])) {
		$translation = $trailObj->getTranslation($lang_set,"Array");
		$trail['desc'] = $translation['desc'];
		$trail['lighting'] = $translation['lighting'];
		$trail['surface'] = $translation['surface'];
		$trail['parking'] = $translation['parking'];
		$trail['facilities'] = $translation['facilities'];
		$trail['hours'] = $translation['hours'];
		$trail['attractions'] = $translation['attractions'];
		$looptranslation = true;
		$translation['loops'] = json_decode(json_encode($translation['loops']),true);
	} else {
		//translation not available!	
	}
}

$special = "breadcrumb";
$breadcrumb = '<a href="'.$baseurl.'" class="green-text text-darken-3"><i class="fa fa-home"></i></a>';
if($userActive) {
	$breadcrumb = '<a href="'.$baseurl.'dashboard/" class="green-text text-darken-3"><i class="fa fa-home"></i></a>';
	if(in_array($trail['id'], $_SESSION['data']['fav'])) {
		$isFav = true;
	} else {
		$isFav = false;
	}
	
}

$breadcrumb .= '&nbsp;&nbsp;<i class="fa fa-chevron-right grey-text text-darken-1" style="padding-top:1px;"></i>&nbsp;&nbsp;<a href="'.$baseurl.'filter/" class="green-text text-darken-3">'.$lexicon[3][$lang_set].'</a>&nbsp;&nbsp;<i class="fa fa-chevron-right grey-text text-darken-1" style="padding-top:1px;"></i>&nbsp;&nbsp;<a href="'.$baseurl.'trail/?id='.$trail['id'].'" class="green-text text-darken-3">'.$trail['name'].'</a>';
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
<?php if(!$error) { ?>
    <title><?php echo($trail['name']); ?> - Prescription Trails - <?php echo($trail['city']); ?></title>
    <meta name="description" content="<?php echo(limit_text($metaDesc, 24)); ?>" />
    
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="image" content="<?php echo($trail['thumbURL']); ?>">
    <link rel="canonical" href="<?php if($pretty_urls) { echo($trail['url']); } else { echo($baseurl."trail/?id=".$trail['id']); } ?>" />
    
    <!-- Open Graph data -->
    <meta property="og:title" content="<?php echo($trail['name']); ?>" />
    <meta property="og:type" content="prescriptiontrails:trail" />
    <meta property="og:url" content="<?php if($pretty_urls) { echo($trail['url']); } else { echo($baseurl."trail/?id=".$trail['id']); } ?>" />
    <meta property="og:image" content="<?php echo($trail['thumbURL']); ?>" />
    <meta property="og:description" content="<?php echo($metaDesc); ?>" />
    <meta property="og:site_name" content="Prescription Trails" />
    <meta property="fb:admins" content="1279607446, 100001120322907" />
    <meta property="fb:explicitly_shared" content="true" />
    <meta property="place:location:latitude"  content="<?php echo($trail['lat']); ?>" /> 
    <meta property="place:location:longitude" content="<?php echo($trail['lng']); ?>" /> 
    <meta property="prescriptiontrails:grade" content="<?php echo($trail['difficulty']); ?>" />
    <meta property="prescriptiontrails:distance" content="<?php echo($distance); ?>" />
    <meta property="prescriptiontrails:steps" content="<?php echo($steps); ?>" />

<?php } else { ?>

    <title>Error - Prescription Trails</title>
    <meta name="description" content="This is an error page." />
<?php } ?>   
   
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/style_base.php"); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.0.1/jquery.rateyo.min.css">

</head>
<body class="<?php echo($bodyclass); ?>">
  
  <?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/nav.php"); ?>          

<?php if($error) {
		require("error.php");
} else {
	
?>

      <div class="container" style="margin-top:20px;" itemscope itemtype="http://schema.org/Place">

        <div class="row">

            <div class="col s12">
              <div class="card hoverable">
                <div class="card-image" style="height: 240px; overflow:hidden; ">
                  <meta itemprop="image" content="<?php echo($trail['largeImgURL']); ?>"></meta>
                  <div style="background:url('<?php echo($trail['largeImgURL']); ?>') center center no-repeat; background-size: cover;" class="heroimage">
                  <span class="card-title"><?php if(strlen($trail['name']) > 20) { ?><h2<?php } else { ?><h1<?php } ?> style="font-weight:300; margin-bottom:0px;" class="glow" itemprop="name"><?php echo($trail['name']); ?><?php if(strlen($trail['name']) > 20) { ?></h2><?php } else { ?></h1><?php } ?></span>
                  </div>
                </div>
                <div class="card-content">
                    <div class="row" style="margin-bottom:0px;">
			<?php if(!$userActive) { ?>
            		<div class="col s12">
                      <a class="waves-effect waves-light btn" style="float:right; margin-left:15px; background-color:#48649F" title="Share on Facebook" href="#" onClick="shareFB();"><i class="fa fa-facebook-square"></i> Share</a>
                      <p><span itemprop="description"><?php echo(rawurldecode($trail['desc'])); ?></span> <a href="<?php echo($baseurl); ?>user/login/?rdr=/trail/?id=<?php echo($trail['id']); ?>"><?php echo($lexicon[14][$lang_set]); //Log In ?></a> <?php echo($lexicon[33][$lang_set]); //or ?> <a href="<?php echo($baseurl); ?>user/new/account/"><?php echo($lexicon[23][$lang_set]); //Register ?></a> to favorite trails and keep track of your walks!</a></p>
                    </div>
            <?php } else { ?>
            		<div class="col s12">
                      <p itemprop="description"><?php echo(rawurldecode($trail['desc'])); ?></p>
                    </div>
            <?php } ?>
                    </div>
			<?php if($userActive) { ?>
                    <div class="row" style="margin-top:10px; margin-bottom:0px;">
                        <div class="col m6 s12" style="margin-top:10px;"><a id="favBtn" class="waves-effect herobtn yellow <?php if($isFav) { ?>darken-2 white-text<?php } else { ?>lighten-4 black-text<?php } ?> waves-dark btn" onClick="fav(event, <?php echo($trail['id']); ?>);"><i class="material-icons left">star</i><span id="favText"><?php if($isFav) { ?>Favorited<?php } else { ?><?php echo($lexicon[52][$lang_set]); //Add to favorites ?><?php } ?></span></a></div>
                        <div class="col m6 s12" style="margin-top:10px;"><a class="waves-effect herobtn light-blue accent-1 waves-dark btn white black-text modal-trigger" href="#logActivity"><i class="material-icons left">assignment</i>Log This Trail</a></div>
                    </div>
            <?php } ?>
                </div>
              </div>
            </div>			
            
      	</div> 
		
		<div class="row">
        
        	<div class="col m8 s12">
            <?php if($trail['published'] == "false") { ?>
                  <div class="row">
                    <div class="col s12">
                      <div class="card red accent-4">
                        <div class="card-content white-text center">

                            <p class="flow-text">Warning: This trail is currently undergoing maintenance and may contain inaccurate or incomplete information.</p>
            
                        </div>
                      </div>
                    </div>
                  </div>
            <?php } ?>
        
                <div class="row">
                
                	<div class="col s12">
                    
                      <div class="card hoverable">
                        <div class="card-content">
			<?php if($userActive) { ?>
                    <a class="waves-effect waves-light btn hide-on-small-and-down" style="float:right; margin-left:15px; background-color:#48649F" title="Share on Facebook" href="#" onClick="shareFB();"><i class="fa fa-facebook-square"></i> Share</a>
            <?php } ?>
                            <h3 style="font-weight:200"><?php echo($lexicon[20][$lang_set]); //About this trail ?></h3>
                                <p class="flow-text"><?php if($lang_set == "es") { echo($trail['name']); ?> es una sendero de grado <?php if($trail['difficulty'] == 4) { echo("3++"); } else { echo($trail['difficulty']); } ?> <sup><a class="modal-trigger" href="#grades">[?]</a></sup> con <?php echo($looptext); ?> para un total de <?php echo($distance); ?> millas (<?php echo($steps); ?> pasos). <?php } else { echo($trail['name']); ?> is a grade <?php if($trail['difficulty'] == 4) { echo("3++"); } else { echo($trail['difficulty']); } ?> <sup><a class="modal-trigger" href="#grades">[?]</a></sup> trail with <?php echo($looptext); ?> for a total of <?php echo($distance); ?> miles (<?php echo($steps); ?> steps).<?php } ?></p>
<?php
		if($trail['loopcount'] == 1) {

		} else {
	
			foreach($trail['loops'] as $id => $details) {
				
				if($looptranslation) {
					$translation['loops'][$id] = (array) $translation['loops'][$id];
					$name = $translation['loops'][$id]['name'];	
				} else {
					$name = $details['name'];
				}
			
			?>
            					<h5><?php echo($name); ?></h5>
                                <p><?php if($lang_set == "es") { ?>Esta trayectoria es <?php echo($details['distance']); ?> millas para una total de <?php echo($details['steps']); ?> pasos.<?php } else { ?>This loop is <?php echo($details['distance']); ?> miles for a total of <?php echo($details['steps']); ?> steps.<?php } ?></p>
            <?php
				
			}
	
		}
?>                    			            
                            <h3 style="font-weight:200"><?php echo($lexicon[19][$lang_set]); //Attractions ?></h3>
                                <ul class="flow-text">
<?php
	
			foreach($trail['attractions'] as $id => $attraction) {
				if($attraction != "") {
			?>
                                    <li style="margin-top:4px;"><i class="fa fa-chevron-right red-text text-darken-2"></i> <?php echo(rawurldecode($attraction)); ?></li>
            <?php
				}
			}
	
?>                    			            
                                </ul>
                        </div>
                      </div>
                
                	</div>
                
                </div>
                
                <div class="row">

                	<div class="col s12">

                          <div class="card hoverable">
                            <div class="card-content">
                                <h3 style="font-weight:200"><?php echo($lexicon[18][$lang_set]); //More details ?></h3>
                                    <p><strong><?php echo($lexicon[48][$lang_set]); //Nearby intersection ?></strong></p>
                                        <blockquote><?php echo($trail['crossstreets']); ?></blockquote>
                                    <p><strong>Public Transportation:</strong></p>
                                        <blockquote><?php echo($trail['transit']); ?></blockquote>
                                    <p><strong>Public Facilities:</strong></p>
                                        <blockquote><?php echo($trail['facilities']); ?></blockquote>
                                    <p><strong>Parking:</strong></p>
                                        <blockquote><?php echo($trail['parking']); ?></blockquote>
                            </div>
                            
                          </div>
            
            		</div>
            
            	</div>
            
            </div>
        
            <div class="col s12 m4">
			

                <div class="row">
                
                	<div class="col s12">
                    
                      <div class="card hoverable">
                        <div class="card-content center-align" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                        	<h4 style="font-weight:200; text-align:center">User Ratings</h4>
                            <p id="ratingData" ><strong><span itemprop="ratingValue"><?php echo(round($trail['rating'],1)); ?></span>/<span itemprop="bestRating">5</span></strong> with <span itemprop="ratingCount"><?php echo($trail['ratings']); ?></span> responses</p>
                            <?php if($userActive) { ?><p><?php echo($lexicon[48][$lang_set]); //Add your voice! Click the stars below to rate this trail. ?></p><?php } else { ?><p><a href="<?php echo($baseurl); ?>user/login/?rdr=/trail/?id=<?php echo($trail['id']); ?>"><?php echo($lexicon[14][$lang_set]); //Log In ?></a> <?php echo($lexicon[33][$lang_set]); //or ?> <a href="<?php echo($baseurl); ?>user/new/account/"><?php echo($lexicon[23][$lang_set]); //Register ?></a> to vote.</p><?php } ?>   
                            <div id="ratingWrapper" class="center center-align" style="margin-top:10px;	width: 167px; margin-left: auto; margin-right: auto;"><div id="rating"></div></div>
                        </div>
                      </div>
                      
                    </div>
                      
                </div>
			         
				  <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                    <meta itemprop="streetAddress" content="<?php echo(htmlspecialchars($trail['address'])); ?>"></meta>
                    <meta itemprop="addressLocality" content="<?php echo($trail['city']); ?>"></meta>
                    <meta itemprop="addressRegion" content="NM"></meta>
                    <meta itemprop="postalCode" content="<?php echo($trail['zip']); ?>"></meta>
                  </div>

                <div class="row" style="height:250px; margin-top:10px; margin-bottom:10px">


                	<div class="col s12 video-container" style="height:250px;" itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
                        <meta itemprop="latitude" content="<?php echo($trail['lat']); ?>"></meta>
                        <meta itemprop="longitude" content="<?php echo($trail['lng']); ?>"></meta>

							<div id="map" style="height:250px;"></div>
                            
                    </div>
             
                </div>
                
                <div class="row" style="margin-top:5px">


                	<div class="col s12">
                          <a class='dropdown-button btn white black-text' style="width:100%" href='#' data-activates='directionsDrop'><i class="material-icons left">place</i><?php echo($lexicon[24][$lang_set]); //Directions ?></a>
                        
                          <ul id='directionsDrop' class='dropdown-content'>
                            <li><a href="http://maps.google.com/?q=<?php echo(urlencode($trail['address'].", ". $trail['city'] . ", NM ". $trail['zip'])); ?>">Google Maps</a></li>
                            <li><a href="http://maps.apple.com/?address=<?php echo(urlencode($trail['address'].", ". $trail['city'] . ", NM ". $trail['zip'])); ?>">Apple Maps</a></li>
                          </ul>
                    </div>
             
                </div>
             
                <div class="row">

                	<div class="col s12">

                          <div class="card" style="overflow:visible">
                            <div class="card-image">
                              <img id="satImg" src="<?php echo($trail['satImgURL']); ?>" class="materialboxed">
                            </div>
                            <div class="card-action">
                              <a href="#!" onClick="$('#satImg').click();">View Larger</a>
                            </div>
                          </div>
                          
                     </div>
      
                </div>                  	
             
                <div class="row white-text">
                      <span class="card-title" style="padding-left:10px;">Tags</span>
                </div>
                    
                <div class="row" style="padding-left:10px;">
                          <div class="chip">
                          	<a class="chiplink" href="<?php echo($baseurl); ?>filter/?by=city&city=<?php echo($trail['city']); ?>">
                                <img src="<?php echo($baseurl); ?>img/city/<?php echo($trail['city']); ?>.jpg" alt="<?php echo($trail['city']); ?>">
                                <?php echo($trail['city']); ?>
                            </a>
                          </div>&nbsp;        	
                          <div class="chip">
                          	<a class="chiplink" href="<?php echo($baseurl); ?>filter/?by=zip&zip=<?php echo($trail['zip']); ?>">
								<?php echo($trail['zip']); ?>
                            </a>
                          </div>&nbsp;
                          <div class="chip">
                          	<a class="chiplink" href="<?php echo($baseurl); ?>filter/?by=grade&grade=<?php echo($trail['difficulty']); ?>">
                                <img src="<?php echo($baseurl); ?>img/<?php echo($trail['difficulty']); ?>.png" alt="Grade <?php if($trail['difficulty'] == 4) { echo("3++"); } else { echo($trail['difficulty']); } ?>">
                                Grade <?php if($trail['difficulty'] == 4) { echo("3++"); } else { echo($trail['difficulty']); } ?>
                            </a>
                          </div>
                </div>

			<?php if($userActive) { ?>
                <div class="row">
                        <a class="col s12 waves-effect waves-light btn hide-on-med-and-up" style="background-color:#48649F" title="Share on Facebook" href="#" onClick="shareFB();"><i class="fa fa-facebook-square"></i> Share</a>
				</div>
            <?php } ?>

                
            </div>   
                           	
        </div>

             
      </div>
<?php if($userActive) { ?>
  <!-- Modal Structure - log -->
  <div id="logActivity" class="modal">
    <div class="modal-content" id="activityContent">
      <h5>Add <?php echo($trail['name']); ?> to your walking log!</h5>
        <p>Please select the date of this walk. Today's date is already selected for you.</p>		            
      	<div class="row">
                  <div class="input-field col s5">
                    <select id="activityMonth" name="activityMonth">
                      <?php $i = 1; while($i < 13) { 
						$dateObj   = DateTime::createFromFormat('!m', $i);
						$monthName = $dateObj->format('F');
						$monthNameDisplay = $monthName;
						if($lang_set == "es") {
							$es_M = array(
										1=>"Enero",
										2=>"Febrero",
										3=>"Marzo",
										4=>"Abril",
										5=>"Mayo",
										6=>"Junio",
										7=>"Julio",
										8=>"Agosto",
										9=>"Septiembre",
										10=>"Octubre",
										11=>"Noviembre",
										12=>"Diciembre"
									);
							$monthNameDisplay = $es_M[$i];	
						}
					  ?>
                      <option value="<?php echo($monthName); ?>" <?php if($i == intval(date("n"))) { ?>selected<?php } ?>><?php echo($monthNameDisplay); ?></option>
                      <?php $i++; } ?>
                    </select>
                    <label><?php echo($lexicon[37][$lang_set]); //Month ?></label>
                  </div>       
                  <div class="input-field col s3">
                    <select id="activityDay" name="activityDay">
                      <?php $i = 1; while($i < 32) { ?>
                      <option value="<?php echo($i); ?>" <?php if($i == intval(date("j"))) { ?>selected<?php } ?>><?php echo($i); ?></option>
                      <?php $i++; } ?>
                    </select>
                    <label><?php echo($lexicon[38][$lang_set]); //Day ?></label>
                  </div>       
                  <div class="input-field col s4">
                    <select id="activityYear" name="activityYear">
                      <option value="<?php echo(date("Y")); ?>" selected><?php echo(date("Y")); ?></option>
                      <option value="<?php echo(intval(date("Y")) - 1); ?>"><?php echo(intval(date("Y")) - 1); ?></option>
                    </select>
                    <label><?php echo($lexicon[39][$lang_set]); //Year ?></label>
                  </div>       
        </div>
      	<p>How many loops did you walk? Select from the dropdown.</p>
        <table class="striped">
<?php
		if($trail['loopcount'] == 1) {
?>
      		<tr>
            	<td>Main Loop</td>
            	<td><?php echo($distance); ?> mi</td>
                <td><?php echo($steps); ?> steps</td>
            	<td>
                  <div class="input-field col s12">
                    <select id="loop1" name="loop1">
                      <option value="0" disabled selected>Times walked</option>
                      <option value="0">0</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                    </select>
                    <label>Loops walked</label>
                  </div>       
            	</td>
        	</tr>	
<?php
		} else {
	
			$i = 0;
			foreach($trail['loops'] as $id => $details) {
					$i = $i + 1;			
			?>
      		<tr>
            	<td><?php echo($details['name']); ?></td>
            	<td><?php echo($details['distance']); ?> mi</td>
                <td><?php echo($details['steps']); ?> steps</td>
            	<td>
                  <div class="input-field col s12">
                    <select id="loop<?php echo($i); ?>" name="loop<?php echo($i); ?>">
                      <option value="0" disabled selected>Times walked</option>
                      <option value="0">0</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                    </select>
                    <label>Loops walked</label>
                  </div>       
            	</td>
        	</tr>
            <?php
				
			}
	
		}
?>               
		</table>     
        <p class="center-align">About how many minutes did you spend walking?</p>
      	<div class="row">
            <div class="input-field col s4 offset-s4">
              <input placeholder="X <?php echo($lexicon[41][$lang_set]); //Minutes ?>" id="activityTime" name="activityTime" type="number" class="validate">
              <label for="activityTime"><?php echo($lexicon[41][$lang_set]); //Minutes ?></label>            
            </div>
        </div>        	
    </div>
    <div class="modal-footer center" style="height:70px;">
      <a href="#" style="float:none;" onClick="postLogActivity(event);" class="waves-effect waves-light btn green darken-1" id="activitySubmit"><?php echo($lexicon[36][$lang_set]); //Submit ?></a>&nbsp;
      <a href="#!" style="float:none;" class="modal-action modal-close waves-effect waves-dark btn red darken-1 white-text">Close</a>
    </div>
  </div>
<?php } ?>

<?php } ?>

  <!-- Modal Structure -->
  <div id="grades" class="modal">
    <div class="modal-content">
      <h4><?php echo($lexicon[29][$lang_set]); //Attractions ?></h4>
		<p><?php echo($lexicon[28][$lang_set]); //Attractions ?></p>
		<h4><?php echo($lexicon[30][$lang_set]); //Grade ?> 1</h4>
        	<blockquote><?php echo($lexicon[25][$lang_set]); //g1 ?></blockquote>
		<h4><?php echo($lexicon[30][$lang_set]); //Grade ?> 2</h4>
        	<blockquote><?php echo($lexicon[26][$lang_set]); //g2 ?></blockquote>
		<h4><?php echo($lexicon[30][$lang_set]); //Grade ?> 3</h4>
        	<blockquote><?php echo($lexicon[27][$lang_set]); //g3 ?></blockquote>
		<h4><?php echo($lexicon[30][$lang_set]); //Grade ?> 3++</h4>
        	<blockquote>Challenging. A paved, packed, crusher, fine or dirt pathway with variations in grade and/or unstable surfaces. Not for the beginner.</blockquote>
    </div>
    <div class="modal-footer">
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Close</a>
    </div>
  </div>

          
<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/drawer.php"); 


$output = ob_get_contents();
ob_end_clean();

echo(minify_html($output));

?>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/js_base.php"); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.0.1/jquery.rateyo.min.js"></script>

  <script><?php ob_start(); ?>
  var loopdistance = {};
  var loopsteps = {};
<?php
	if($trail['loopcount'] == 1) {  
			echo("loopdistance[1] = ".$distance.";");
			echo("loopsteps[1] = ".$steps.";");
			echo("var loopcount = 1;");
		} else {
			$i = 0;
			foreach($trail['loops'] as $id => $details) {
					$i = $i + 1;		
			?>
loopsteps[<?php echo($i); ?>] = <?php echo($details['steps']); ?>;
loopdistance[<?php echo($i); ?>] = <?php echo($details['distance']); ?>;
<?php
			}
?>
var loopcount = <?php echo($i); ?>;
<?php	
		}
?>                    			            
var fbdistance = 0;
<?php if($userActive) { ?>
	function postLogActivity (e) {
		e.preventDefault();
		$("#activitySubmit").prop("disabled",true);
			var missing = true;
			if ($( "#activityTime" ).val().length < 1) {
				missing = false;
				$( "#activityTime" ).addClass("invalid");
				Materialize.toast("How much time did you spend?", 8000);
			}
		var iterateloops = 0;
		var totaldistance = 0;
		var totalsteps = 0;
		var month = $("#activityMonth").val();
		var day = $("#activityDay").val();
		var year = $("#activityYear").val();
		var time = $("#activityTime").val();
		var date = month + " " + day + ", " + year;
		while(iterateloops < loopcount) {
			loopid = iterateloops + 1;
			var count = $("#loop"+loopid).val();
				var distance = count * loopdistance[loopid];
				var steps = count * loopsteps[loopid];
				totaldistance = totaldistance + distance;
				totalsteps = totalsteps + steps;
			iterateloops++;	
		}
		if(totaldistance == 0 || missing === false) {
			Materialize.toast('Please complete all fields.', 5000);
			$("#activitySubmit").prop("disabled",false);
		} else {
			fbdistance = totaldistance;
			var formData = {
				'trail_id'		: <?php echo($trail['id']); ?>,
				'type'			: "trail",
				'date'			: date,
				'time'			: time,
				'steps'			: totalsteps,
				'distance'		: totaldistance,
				'trail_name'	: "<?php echo(urlencode($trail['name'])); ?>",
			};
			$.ajax({
				type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
				url         : '<?php echo($baseurl); ?>src/log.php', // the url where we want to POST
				data        : formData, // our data object
				dataType    : 'json', // what type of data do we expect back from the server
				encode      : true
			})
				.done(function(data) {
	
					if(data.status == "done") {
						ga('send', 'event', "log", "log-<?php echo($trail['id']); ?>", "steps: "+steps);
						$("#activitySubmit").replaceWith('<a class="waves-effect waves-light btn" style="float:none; margin-left:15px; background-color:#48649F" title="Share on Facebook" href="#" onClick="shareActivityFB('+totaldistance+',\'<?php echo($trail['name']); ?>\');"><i class="fa fa-facebook-square"></i> Share</a>');
						Materialize.toast("Trail logged!", 5000);
						$("#activityContent").html("<div class='row center-align' style='margin-top:50px;'><h1><i class='fa fa-2x fa-thumbs-up'></i></h1></div><div class='row'><div class='col s12 center-align'><p class='flow-text'>Your activity was logged successfully!</p></div></div>");
					} else {
						Materialize.toast('Error: '+data.message, 5000);
					}
				})
			  .fail(function(xhr, textStatus, errorThrown) {
					Materialize.toast('Error: '+xhr.responseText, 10000);
				});	
		}
		
	}
<?php } ?>
    
	$(document).ready(function() {
	
	  $.ajaxSetup({ cache: true });
	  $.getScript('//connect.facebook.net/en_US/sdk.js', function(){
		FB.init({
		  appId: '1050813504958674',
		  version: 'v2.4' // or v2.0, v2.1, v2.2, v2.3
		});     
	  });
	  	  
	});

function shareFB() {
		FB.ui({
		  method: 'share_open_graph',
		  action_type: 'prescriptiontrails:likes_to_walk',
		  action_properties: JSON.stringify({
			'trail': '<?php if($pretty_urls) { echo($trail['url']); } else { echo($baseurl."trail/?id=".$trail['id']); } ?>',
		  })
		}, function(response){
			Materialize.toast('Posted to Facebook!', 7000);
			});
	}
function shareActivityFB(distance,name) {

	var distance = distance;
	var name = name;
		FB.ui({
		  method: 'share_open_graph',
		  action_type: 'prescriptiontrails:likes_to_walk',
		  action_properties: JSON.stringify({
			'trail': '<?php if($pretty_urls) { echo($trail['url']); } else { echo($baseurl."trail/?id=".$trail['id']); } ?>',
            'og:title': 'I walked '+distance+' miles at '+name+' with Prescription Trails!',
		  })
		}, function(response){
			Materialize.toast('Posted to Facebook!', 7000);
			});

}



$(function () {
 
  $("#rating").rateYo({
    rating: <?php echo(round($trail['rating'],2)); ?>,
    halfStar: true
  }).on("rateyo.set", function (e, data) {
	var rating = data.rating;
	<?php if(!in_array($trail['id'], $_SESSION['data']['rate'])) { ?>
        var formData = {
            'id'		: <?php echo($trail['id']); ?>,
            'value'		: rating
        };
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : '<?php echo($baseurl); ?>src/rate.php', // the url where we want to POST
            data        : formData, // our data object
            dataType    : 'json', // what type of data do we expect back from the server
            encode      : true
        })
            .done(function(data) {

				if(data.status == "done") {
					ga('send', 'event', "rating", "rate-<?php echo($trail['id']); ?>", rating);
					Materialize.toast("Thanks for your feedback!", 5000);
					var newRating = data.rating;
					var totalRating = data.ratings;
					var newText = "<strong>"+newRating+"/5</strong> with "+totalRating+" responses";
					$("#ratingData").html(newText);
					$("#rating").rateYo("option", "readOnly", true);
				} else {
					Materialize.toast('Error: '+data.message, 5000);
				}
            })
		  .fail(function(xhr, textStatus, errorThrown) {
				Materialize.toast('Error: '+xhr.responseText, 10000);
			});	
	<?php } else { ?>
		Materialize.toast("You've already rated this trail!", 5000);
	<?php } ?>
  });
<?php if(!$userActive) { ?>$("#rating").rateYo("option", "readOnly", true);<?php } ?>
});

<?php if($userActive) { ?>

var isFav = <?php if($isFav) { echo("true"); } else { echo("false"); } ?>;
function fav(e, id) {
	e.preventDefault();
	if(isFav) {
		var val = "no";
		var boolval = false;
		var action = "unfavorite";
		var NoteText = "<?php echo($lexicon[51][$lang_set]); //Removed from favorites ?>!";	
	} else {
		var val = "yes";	
		var boolval = true;
		var action = "favorite";
		var NoteText = "<?php echo($lexicon[50][$lang_set]); //Added to favorites ?>!";	
	}
        var formData = {
            'id'		: id,
            'value'		: val
        };
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : '<?php echo($baseurl); ?>src/fav.php', // the url where we want to POST
            data        : formData, // our data object
            dataType    : 'json', // what type of data do we expect back from the server
                        encode          : true
        })
            .done(function(data) {

				if(data.status == "done") {
					ga('send', 'event', "favorites", action, id);
					Materialize.toast(NoteText, 5000);
					isFav = boolval;
						if(isFav) {
							$("#favBtn").removeClass("lighten-4").removeClass("black-text").addClass("darken-2").addClass("white-text");
							$("#favText").text("Favorited");
						} else {
							$("#favBtn").addClass("lighten-4").addClass("black-text").removeClass("darken-2").removeClass("white-text");
							$("#favText").text("Add to Favorites");
						}					
				} else {
					Materialize.toast('Error: '+data.message, 5000);
				}
            })
		  .fail(function(xhr, textStatus, errorThrown) {
				Materialize.toast('Error: '+xhr.responseText, 10000);
			});
}
<?php } ?>
	
var map;
function initMap() {
  map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: <?php echo($trail['lat']); ?>, lng: <?php echo($trail['lng']); ?>},
    zoom: 14
  });

  var contentString = '<div id="content">'+
      '<div id="siteNotice">'+
      '</div>'+
      '<div id="bodyContent">'+
      '<p><b>Address</b>: <?php echo(htmlspecialchars($trail['address'])); ?>, <?php echo($trail['city']); ?>, NM <?php echo($trail['zip']); ?></p>'+
      '<p><b>Directions</b>: <a href="http://maps.google.com/?q=<?php echo(urlencode($trail['address'].", ". $trail['city'] . ", NM ". $trail['zip'])); ?>">Google Maps</a> | <a href="http://maps.apple.com/?address=<?php echo(urlencode($trail['address'].", ". $trail['city'] . ", NM ". $trail['zip'])); ?>">Apple Maps</a></p>'+
      '</div>'+
      '</div>';

  var infowindow = new google.maps.InfoWindow({
    content: contentString
  });

  var marker = new google.maps.Marker({
    position: {lat: <?php echo($trail['lat']); ?>, lng: <?php echo($trail['lng']); ?>},
    map: map,
    title: '<?php echo(htmlspecialchars($trail['name'])); ?>'
  });
  marker.addListener('click', function() {
    infowindow.open(map, marker);
  });
  
}
<?php $output = ob_get_contents();
ob_end_clean();

echo(minify_js($output)); ?>
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGtuuf2tqUJcX_-XulhmjJuksAigifezM&callback=initMap"
        async defer></script>

  </body>
</html>
