<?php
require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php"); 
$adminPage = true;
require("/nfs/users/clind/public_html/prescriptiontrails.org/src/secure.php"); 

if($_GET['lang'] != "es" && $_GET['lang'] != "vi") {
	header("Location: ".$baseurl."admin/?error=lang");
	exit();
}

if($_GET['lang'] == "es") {
	
	$language = "Spanish";
	$lang = "es";
		
}
if($_GET['lang'] == "vi") {
	
	$language = "Vietnamese";
	$lang = "vi";
		
}

$page_type = "admin";

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
		$update = false;
		if(in_array($lang,$trail['translations'])) {
		
			$update = true;
			$translation = $trailObj->getTranslation($lang,"Array");
			
		}
	}
	
}

if(!$error) {

ini_set('display_errors', 1);
ini_set('display_startup_errors', 0);
error_reporting(E_ERROR | E_PARSE);

	if($trail['loopcount'] == 1) {
		$looptext	= "one loop";
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
	
} else {
	
	header("HTTP/1.0 404 Not Found");
	
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Prescription Trails</title>

  <!-- CSS  -->
<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/style_base.php"); ?>
  

</head>
<body class="<?php echo($bodyclass); ?>">
  

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/nav.php"); ?>

<div class="container" style="margin-top:25px;">
    <div class="row">
    	<div class="col s12 center-align">
        	<h1 class="glow"><i class="fa fa-2x fa-language"></i></h1>
            <h1 class="glow">Translation:</h1>
			<h2 class="glow"><?php echo($trail['name']); ?></h2>
            <h3 class="glow"><?php echo($language); ?></h3>
		</div>
    </div>
<form action="<?php echo($baseurl); ?>admin/translate/post.php" method="post">
    <input type="hidden" name="id" value="<?php echo($_GET['id']); ?>"/>
    <input type="hidden" name="lang" value="<?php echo($lang); ?>"/>
<?php if($update) { ?>
    <input type="hidden" name="postaction" value="update"/>
    <input type="hidden" name="trans_id" value="<?php echo($translation['id']); ?>"/>
<?php } else { ?>    
    <input type="hidden" name="postaction" value="new"/>
<?php } ?>    
    
    <div class="row">
    	<div class="col s5">
          <div class="card white">
            <div class="card-content black-text">
              <span class="card-title">Description</span>
              <p id="descEn"><?php echo(rawurldecode($trail['desc'])); ?></p>
            </div>
          </div>
        </div>
        <div class="col s2 center-align">
        	<a class="waves-effect waves-dark white black-text btn tooltipped" data-position="bottom" data-position="bottom" data-delay="50" data-tooltip="Copy Original to Translation" style="margin-top:50px;" onClick="copyTxt(event, 'desc');"><i class="fa fa-copy"></i> <i class="fa fa-arrow-right"></i></a>
        </div>
    	<div class="col s5">
          <div class="card white">
            <div class="card-content black-text">
              <span class="card-title">Translation</span>
                    <div class="input-field">
                      <textarea id="desc" name="desc" class="materialize-textarea" length="500"><?php if($update) { echo(rawurldecode($translation['desc'])); } ?></textarea>
                      <label for="desc">About this trail.</label>
                    </div>
            </div>
          </div>
        </div>
    </div>

    <div class="row">
    	<div class="col s5">
          <div class="card white">
            <div class="card-content black-text">
              <span class="card-title">Lighting</span>
              <p id="lightingEn"><?php echo(rawurldecode($trail['lighting'])); ?></p>
            </div>
          </div>
        </div>
        <div class="col s2 center-align">
        	<a class="waves-effect waves-dark white black-text btn tooltipped" data-position="bottom" data-position="bottom" data-delay="50" data-tooltip="Copy Original to Translation" style="margin-top:50px;" onClick="copyTxt(event, 'lighting');"><i class="fa fa-copy"></i> <i class="fa fa-arrow-right"></i></a>
        </div>
    	<div class="col s5">
          <div class="card white">
            <div class="card-content black-text">
              <span class="card-title">Translation</span>
                    <div class="input-field">
                      <input placeholder="e.g. On trail and parking lot" id="lighting" name="lighting" type="text" value="<?php if($update) { echo(rawurldecode($translation['lighting'])); } ?>" class="validate">
                      <label for="lighting">How is the trail lighted?</label>
                    </div>
            </div>
          </div>
        </div>
    </div>

    <div class="row">
    	<div class="col s5">
          <div class="card white">
            <div class="card-content black-text">
              <span class="card-title">Surface</span>
              <p id="surfaceEn"><?php echo(rawurldecode($trail['surface'])); ?></p>
            </div>
          </div>
        </div>
        <div class="col s2 center-align">
        	<a class="waves-effect waves-dark white black-text btn tooltipped" data-position="bottom" data-position="bottom" data-delay="50" data-tooltip="Copy Original to Translation" style="margin-top:50px;" onClick="copyTxt(event, 'surface');"><i class="fa fa-copy"></i> <i class="fa fa-arrow-right"></i></a>
        </div>
    	<div class="col s5">
          <div class="card white">
            <div class="card-content black-text">
              <span class="card-title">Translation</span>
                        	<div class="input-field">
                              <input placeholder="e.g. 6-foot+ wide sidewalk" id="surface" name="surface" type="text" value="<?php if($update) { echo(rawurldecode($translation['surface'])); } ?>" class="validate">
                              <label for="surface">What is the trail surface like?</label>
                            </div>
            </div>
          </div>
        </div>
    </div>

    <div class="row">
    	<div class="col s5">
          <div class="card white">
            <div class="card-content black-text">
              <span class="card-title">Parking</span>
              <p id="parkingEn"><?php echo(rawurldecode($trail['parking'])); ?></p>
            </div>
          </div>
        </div>
        <div class="col s2 center-align">
        	<a class="waves-effect waves-dark white black-text btn tooltipped" data-position="bottom" data-position="bottom" data-delay="50" data-tooltip="Copy Original to Translation" style="margin-top:50px;" onClick="copyTxt(event, 'parking');"><i class="fa fa-copy"></i> <i class="fa fa-arrow-right"></i></a>
        </div>
    	<div class="col s5">
          <div class="card white">
            <div class="card-content black-text">
              <span class="card-title">Translation</span>
                    <div class="input-field">
                      <input placeholder="e.g. On street" id="parking" name="parking" type="text" value="<?php if($update) { echo(rawurldecode($translation['parking'])); } ?>" class="validate">
                      <label for="parking">What can people park?</label>
                    </div>
            </div>
          </div>
        </div>
    </div>

    <div class="row">
    	<div class="col s5">
          <div class="card white">
            <div class="card-content black-text">
              <span class="card-title">Facilities</span>
              <p id="facilitiesEn"><?php echo(rawurldecode($trail['facilities'])); ?></p>
            </div>
          </div>
        </div>
        <div class="col s2 center-align">
        	<a class="waves-effect waves-dark white black-text btn tooltipped" data-position="bottom" data-position="bottom" data-delay="50" data-tooltip="Copy Original to Translation" style="margin-top:50px;" onClick="copyTxt(event, 'facilities');"><i class="fa fa-copy"></i> <i class="fa fa-arrow-right"></i></a>
        </div>
    	<div class="col s5">
          <div class="card white">
            <div class="card-content black-text">
              <span class="card-title">Translation</span>
                    <div class="input-field">
                      <input placeholder="e.g. Restrooms" id="facilities" name="facilities" type="text" value="<?php if($update) { echo(rawurldecode($translation['facilities'])); } ?>" class="validate">
                      <label for="facilities">What facilities are available?</label>
                    </div>
            </div>
          </div>
        </div>
    </div>

    <div class="row">
    	<div class="col s5">
          <div class="card white">
            <div class="card-content black-text">
              <span class="card-title">Hours</span>
              <p id="hoursEn"><?php echo(rawurldecode($trail['hours'])); ?></p>
            </div>
          </div>
        </div>
        <div class="col s2 center-align">
        	<a class="waves-effect waves-dark white black-text btn tooltipped" data-position="bottom" data-position="bottom" data-delay="50" data-tooltip="Copy Original to Translation" style="margin-top:50px;" onClick="copyTxt(event, 'hours');"><i class="fa fa-copy"></i> <i class="fa fa-arrow-right"></i></a>
        </div>
    	<div class="col s5">
          <div class="card white">
            <div class="card-content black-text">
              <span class="card-title">Translation</span>
                        	<div class="input-field">
                              <input placeholder="e.g. 6 a.m. - 10 p.m." id="hours" name="hours" value="<?php if($update) { echo(rawurldecode($translation['hours'])); } ?>" type="text" class="validate">
                              <label for="hours">When is the trail open?</label>
                            </div>
            </div>
          </div>
        </div>
    </div>

<?php
	$loopcount = 0;
			foreach($trail['loops'] as $id => $details) {
					$loopcount = $loopcount + 1;
			?>
    <div class="row">
    	<div class="col s5">
          <div class="card white">
            <div class="card-content black-text">
              <span class="card-title">Loop <?php echo($id); ?></span>
              <p id="loop<?php echo($id); ?>En"><?php echo($details['name']); ?></p>
            </div>
          </div>
        </div>
        <div class="col s2 center-align">
        	<a class="waves-effect waves-dark white black-text btn tooltipped" data-position="bottom" data-position="bottom" data-delay="50" data-tooltip="Copy Original to Translation" style="margin-top:50px;" onClick="copyTxt(event, 'loop<?php echo($id); ?>');"><i class="fa fa-copy"></i> <i class="fa fa-arrow-right"></i></a>
        </div>
    	<div class="col s5">
          <div class="card white">
            <div class="card-content black-text">
              <span class="card-title">Translation</span>
                        	<div class="input-field">
                              <input id="loop<?php echo($id); ?>" name="loop<?php echo($id); ?>" value="<?php if($update) { $translation['loops'] = (array) $translation['loops']; echo(rawurldecode($translation['loops'][$id]['name'])); } ?>" type="text" class="validate">
                              <label for="loop<?php echo($id); ?>">Loop Name</label>
                            </div>
            </div>
          </div>
        </div>
    </div>
            <?php
				
			}
	
?>                    			            

<?php
	$attractioncount = 0;
			foreach($trail['attractions'] as $id => $attraction) {
					$attractioncount = $attractioncount + 1;
			?>
    <div class="row">
    	<div class="col s5">
          <div class="card white">
            <div class="card-content black-text">
              <span class="card-title">Attraction <?php echo($id + 1); ?></span>
              <p id="attraction<?php echo($id); ?>En"><?php echo(rawurldecode($attraction)); ?></p>
            </div>
          </div>
        </div>
        <div class="col s2 center-align">
        	<a class="waves-effect waves-dark white black-text btn tooltipped" data-position="bottom" data-position="bottom" data-delay="50" data-tooltip="Copy Original to Translation" style="margin-top:50px;" onClick="copyTxt(event, 'attraction<?php echo($id); ?>');"><i class="fa fa-copy"></i> <i class="fa fa-arrow-right"></i></a>
        </div>
    	<div class="col s5">
          <div class="card white">
            <div class="card-content black-text">
              <span class="card-title">Translation</span>
                        	<div class="input-field">
                              <input id="attraction<?php echo($id); ?>" name="attraction<?php echo($id); ?>" value='<?php if($update) { echo(rawurldecode($translation['attractions'][$id])); } ?>' type="text" class="validate">
                              <label for="attraction<?php echo($id); ?>">Attraction</label>
                            </div>
            </div>
          </div>
        </div>
    </div>
            <?php
				
			}
	
?>                    			            

    <div class="row">
    	<div class="col s12 center-align">
          <button class="btn waves-effect waves-light blue darken-1" type="submit" name="action">Submit
            <i class="material-icons right">send</i>
          </button>
		</div>
    </div>
<input type="hidden" name="attractioncount" value="<?php echo($attractioncount); ?>"/>
<input type="hidden" name="loopcount" value="<?php echo($loopcount); ?>"/>
</form>
</div>
      
<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/drawer.php"); ?>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/js_base.php"); ?>

<script>
function copyTxt(e, id) {
	e.preventDefault();
	var value = $("#" + id + "En").html();
	$("#" + id).val(value);
}
</script>

  </body>
</html>
