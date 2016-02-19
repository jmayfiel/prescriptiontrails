<?php 
require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php"); 
$adminPage = true;
require("/nfs/users/clind/public_html/prescriptiontrails.org/src/secure.php"); 
require("loophtml.php");
$update = false;
if($_GET['action'] == "edit") {
	$trailObj = new trail;
	$trailObj->setID(intval($_GET['id']));
	$trail = $trailObj->getInfo("Array");
	if($trail == "Etrail") {
		//ERROR - Trail does not exist
		$error = true;
		$error_type = "unknown_id";
		$error_details = "The trail ID '" . htmlspecialchars($_GET['id']) . "' was not found in our database. It may have been deleted from our system. Please contact us if you have any questions or concerns.";
		die($error_type . ": " .$error_details . " Click <a href='".$baseurl."admin/'>here</a> to return to the dashboard.");
	} else {
		//Continue
		$update = true;
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Prescription Trails</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.1/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="<?php echo($baseurl); ?>style.css" rel="stylesheet">
  <link href="dropzone.css" rel="stylesheet">  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

<style>

  header, main, footer {
    padding-left: 240px;
  }

  @media only screen and (max-width : 992px) {
    header, main, footer {
      padding-left: 0;
    }
  }
.closeButton
{
    display:block;
    position:absolute;
    top: 5px;
    right: -6px;
    width: 27px;
    height:27px;
}
</style>
</head>
<body>
  

      <div class="row teal darken-1">
      	<div class="container">
            <div class="col s12 white-text center-align">
            		<h1><i class="fa fa-cloud fa-2x glow"></i></h1>
                    <h1 class="glow">You're now <?php if($update) { echo("editing " . htmlspecialchars($trail['name'])); } else { ?>adding a new trail<?php } ?>!</h1>
                    <p class="flow-text">Follow the steps below to <?php if($update) { echo("make your changes"); } else { ?>add a new trail to the database<?php } ?>! Everything should be pretty straightforward, but remember, if you need help, you can always consult the documentation!</p>
            </div>
         </div>
      </div>

<div class="container" style="padding-top:20px; padding-bottom:80px;">

      <div class="row">
        <div class="col s12">
          <div class="card light-blue darken-4" style="overflow:visible">
            <div class="card-content white-text">
              <span class="card-title">Step 1: The Basics</span>
				<p>First on our agenda: some basic information. Please provide the following:</p>
                
                  <div class="row" style="margin-top:15px;">
                    <div class="input-field col s6">
                      <input placeholder="Trail Name" id="name" name="name" type="text" class="validate" <?php if($update) { echo('value="'.htmlspecialchars($trail['name']).'"'); } ?>>
                      <label for="name">Give it a name!</label>
                    </div>
                    <div class="input-field col s6">
                        <select id="city" name="city">
                          <option value="empty" disabled <?php if(!$update) { echo('selected'); } ?>>Choose a city</option>
<?php foreach($cities as $id => $name) { ?>
                          <option value="<?php echo($name); ?>" <?php if($update) { if($trail['city'] == $name) { echo('selected'); } } ?>><?php echo($name); ?></option>
<?php } ?>
                        </select>
                        <label for="city">Which city is it in?</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s4">
                      <input placeholder="Zip Code" id="zip" name="zip" type="text" maxlength="6" class="validate" <?php if($update) { echo('value="'.htmlspecialchars($trail['zip']).'"'); } ?>>
                      <label for="zip">Zip code please!</label>
                    </div>
                    <div class="input-field col s8">
                      <input placeholder="e.g. Mountain & Rio Grande" id="crossstreets" name="crossstreets" type="text" class="validate" <?php if($update) { echo('value="'.htmlspecialchars($trail['crossstreets']).'"'); } ?>>
                      <label for="crossstreets">What are the nearest cross streets?</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12">
                      <input placeholder="e.g. Abq Ride Stops #53, #54 -or- unavailable" id="transit" name="transit" type="text" class="validate" <?php if($update) { echo('value="'.htmlspecialchars($trail['transit']).'"'); } ?>>
                      <label for="transit">Public transit information</label>
                    </div>
			      </div>
                  <div class="row">
                    <div class="input-field col s8">
                      <input placeholder="e.g. 1800 Mountain Rd NW" id="address" name="address" type="text" class="validate" <?php if($update) { echo('value="'.htmlspecialchars($trail['address']).'"'); } ?>>
                      <label for="address">Please provide the full street address.</label>
                    </div>
                    <div class="input-field col s2">
                      <input placeholder="Latitude" id="lat" name="lat" type="text" class="validate" readonly <?php if($update) { echo('value="'.htmlspecialchars($trail['lat']).'"'); } ?>>
                      <label for="lat">Latitude (Calculated)</label>
                    </div>
                    <div class="input-field col s2">
                      <input placeholder="Longitude" id="lng" name="lng" type="text" class="validate" readonly <?php if($update) { echo('value="'.htmlspecialchars($trail['lng']).'"'); } ?>>
                      <label for="lng">Longitude (Calculated)</label>
                    </div>
                  </div>
                  
            </div>
            <div class="card-action">
              <a href="#" onClick="validate1(event);">Validate</a>
              <div style="float:right; display:none; margin-top:-6px;" id="step1valid" class="green-text chip">
                <i class="fa fa-check"></i> Valid
              </div>
              <div style="float:right; display:none; margin-top:-6px;" id="step1invalid" class="red-text chip">
                <i class="fa fa-close"></i> Error
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="row">
        <div class="col s12">
          <div class="card purple darken-2">
            <div class="card-content white-text">
              <span class="card-title">Step 2: About the Trail</span>
				<p>Let's talk about description, distance, difficulty and loops, hurray!</p>
                <blockquote>Hint: the description should be an exciting summary and between 200 (75 min.) and 500 characters long.</blockquote>
                
                  <div class="row" style="margin-top:15px;">
                    <div class="input-field col s12">
                      <textarea id="desc" name="desc" class="materialize-textarea" length="500"><?php if($update) { echo(htmlspecialchars(rawurldecode($trail['desc']))); } ?></textarea>
                      <label for="desc">About this trail.</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s4">
                    		<p>How hard is this trail? <sup><a class="modal-trigger" href="#grades">Need help?</a></sup>
                            <p>
                              <input name="difficulty" type="radio" id="difficulty1" value="1" <?php if($update) { if($trail['difficulty'] == 1) { echo('checked'); } } ?> />
                              <label for="difficulty1" class="white-text">Grade 1</label>
                            </p>
                            <p>
                              <input name="difficulty" type="radio" id="difficulty2" value="2" <?php if($update) { if($trail['difficulty'] == 2) { echo('checked'); } } ?> />
                              <label for="difficulty2" class="white-text">Grade 2</label>
                            </p>
                            <p>
                              <input name="difficulty" type="radio" id="difficulty3" value="3" <?php if($update) { if($trail['difficulty'] == 3) { echo('checked'); } } ?> />
                              <label for="difficulty3" class="white-text">Grade 3</label>
                            </p>
                            <p>
                              <input name="difficulty" type="radio" id="difficulty4" value="4" <?php if($update) { if($trail['difficulty'] == 4) { echo('checked'); } } ?> />
                              <label for="difficulty4" class="white-text">Grade 3++</label>
                            </p>
                    </div>
                    <div class="col s8">
                    	<div class="row">
                        	<div class="input-field col s12">
                              <input placeholder="e.g. 6-foot+ wide sidewalk" id="surface" name="surface" type="text" class="validate" <?php if($update) { echo('value="'.htmlspecialchars($trail['surface']).'"'); } ?>>
                              <label for="surface">What is the trail surface like?</label>
                            </div>
                        </div>
                    	<div class="row">
                        	<div class="input-field col s12">
                              <input placeholder="e.g. 6 a.m. - 10 p.m." id="hours" name="hours" type="text" class="validate" <?php if($update) { echo('value="'.htmlspecialchars($trail['hours']).'"'); } ?>>
                              <label for="hours">When is the trail open?</label>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s6">
                      <input placeholder="e.g. On trail and parking lot" id="lighting" name="lighting" type="text" class="validate" <?php if($update) { echo('value="'.htmlspecialchars($trail['lighting']).'"'); } ?>>
                      <label for="lighting">How is the trail lighted?</label>
                    </div>
                    <div class="input-field col s6">
                      <input placeholder="e.g. On street" id="parking" name="parking" type="text" class="validate" <?php if($update) { echo('value="'.htmlspecialchars($trail['parking']).'"'); } ?>>
                      <label for="parking">What can people park?</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s6">
                      <input placeholder="e.g. Restrooms" id="facilities" name="facilities" type="text" class="validate" <?php if($update) { echo('value="'.htmlspecialchars($trail['facilities']).'"'); } ?>>
                      <label for="facilities">What facilities are available?</label>
                    </div>
                    <div class="input-field col s6">
                      <input placeholder="e.g. 2" id="loopcount" name="loopcount" type="number" class="validate" <?php if($update) { echo('value="'.htmlspecialchars($trail['loopcount']).'"'); } ?>>
                      <label for="loopcount">How many loops does this trail have?</label>
                    </div>
                  </div>
            </div>
            <div class="card-action">
              <a href="#" onClick="validate2(event);">Validate</a>
              <div style="float:right; display:none; margin-top:-6px;" id="step2valid" class="green-text chip">
                <i class="fa fa-check"></i> Valid
              </div>
              <div style="float:right; display:none; margin-top:-6px;" id="step2invalid" class="red-text chip">
                <i class="fa fa-close"></i> Error
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col s12">
          <div class="card deep-orange darken-4">
            <div class="card-content white-text">
              <span class="card-title">Step 3: Let's talk loops</span>
				<p>Describe each of the loops!</p>
				<div class="loopcontainer">
<?php if($update) {

		if($trail['loopcount'] == 1) {
		$looptext	= "Main Loop";
		$distance 	= $trail['loops'][1]['distance'];
		$steps 		= $trail['loops'][1]['steps'];
		$id = 1;
				echo('<div class="row"><div class="col s12"><p>Loop '.$id.'</p></div></div><div class="row"><div class="input-field col s4"><input placeholder="e.g. Outer Loop" id="loop'.$id.'name" name="loop'.$id.'name" value="'.$looptext.'" type="text" class="validate"><label class="loopDynamic" for="loop'.$id.'name">Give this loop a name!</label></div><div class="input-field col s3"><input placeholder="e.g. 0.5" id="loop'.$id.'distance" name="loop'.$id.'distance" value="'.$distance.'" type="text" class="validate"><label class="loopDynamic" for="loop'.$id.'distance">Distance? (miles, number only please!)</label></div><div class="col s2 text-center center-align"><a href="#" class="waves-effect waves-light btn-flat" style="margin-top:12px;" onClick="calcSteps('.$id.',event);"><i class="fa fa-calculator"></i><i class="fa fa-arrow-right"></i></a></div><div class="input-field col s3"><input placeholder="e.g. 1200" id="loop'.$id.'steps" name="loop'.$id.'steps" value="'.$steps.'" type="number" class="validate"><label class="loopDynamic" for="loop'.$id.'steps">How many steps is this loop?</label></div></div>');
				
				echo($newLoop);
	} else {

			foreach($trail['loops'] as $id => $details) {
				echo('<div class="row"><div class="col s12"><p>Loop '.$id.'</p></div></div><div class="row"><div class="input-field col s4"><input placeholder="e.g. Outer Loop" id="loop'.$id.'name" name="loop'.$id.'name" value="'.$details['name'].'" type="text" class="validate"><label class="loopDynamic" for="loop'.$id.'name">Give this loop a name!</label></div><div class="input-field col s3"><input placeholder="e.g. 0.5" id="loop'.$id.'distance" name="loop'.$id.'distance" value="'.$details['distance'].'" type="text" class="validate"><label class="loopDynamic" for="loop'.$id.'distance">Distance? (miles, number only please!)</label></div><div class="col s2 text-center center-align"><a href="#" class="waves-effect waves-light btn-flat" style="margin-top:12px;" onClick="calcSteps('.$id.',event);"><i class="fa fa-calculator"></i><i class="fa fa-arrow-right"></i></a></div><div class="input-field col s3"><input placeholder="e.g. 1200" id="loop'.$id.'steps" name="loop'.$id.'steps" value="'.$details['steps'].'" type="number" class="validate"><label class="loopDynamic" for="loop'.$id.'steps">How many steps is this loop?</label></div></div>');				
				echo($newLoop);
			}		
	}			
} else {
	 echo($loop0); 
}
?>
            	</div>
            </div>

            <div class="card-action">
              <a href="#" onClick="validate3(event);">Validate</a>
              <div style="float:right; display:none; margin-top:-6px;" id="step3valid" class="green-text chip">
                <i class="fa fa-check"></i> Valid
              </div>
              <div style="float:right; display:none; margin-top:-6px;" id="step3invalid" class="red-text chip">
                <i class="fa fa-close"></i> Error
              </div>
            </div>

          </div>
        </div>
      </div>
      

      <div class="row" id="satImgContainer">
        <div class="col s12">
          <div class="card orange darken-4">
            <div class="card-content">
            	<div class="row">
                	<div class="col s12">
                      <span class="card-title white-text">Step 4: Satellite Trail Image</span>
                    </div>
                </div>
              <div class="row">
<?php if($update) { ?>
              	<div class="col s6">
                  <div class="card">
                    <div class="card-image">
                	<img id="satImgTag" src="<?php echo($trail['satImgURL']); ?>" />
                      <span class="card-title">Current Image</span>
                    </div>
                    <div class="card-content">
                      <p id="satImgCaption">This is the current image. Upload an image to the right to replace it.</p>
                    </div>
                  </div>
                </div>
                <div class="col s6">
<?php } else { ?>
				<div class="col s12">
<?php } ?>
				<p class="white-text">Please upload the satellite photo map.</p>

                  <div class="row" id="satDone" style="margin-top:20px; display:none;">
                    <div class="col s6 offset-s3">
                      <div class="card white">
                        <div class="card-content black-text">
                          <span class="card-title black-text"><i class="material-icons">thumb_up</i> Done!</span>
                          <p>Your satellite image has been uploaded. Let's move on!</p>
                        </div>
                      </div>
                    </div>
                  </div>
            
                <form action="up.php"
                      class="dropzone"
                      id="satImage"><input type="hidden" name="t" value="s"/></form>                  
                </div>
			</div>
                  
                  
            </div>
          </div>
        </div>
      </div>


      <div class="row" id="covImgContainer">
        <div class="col s12">
          <div class="card teal darken-4">
            <div class="card-content">
            	<div class="row">
                	<div class="col s12">
                      <span class="card-title white-text">Step 5: How About a Cover Image?</span>
                      <p id="toCrop"></p>
                    </div>
                </div>
                <div id="image-cropper" style="display:none;"></div>
              <div class="row">
<?php if($update) { ?>
              	<div class="col s6" id="imgPreview">
                  <div class="card">
                    <div class="card-image">
                	<img id="lgImgTag" src="<?php echo($trail['thumbURL']); ?>" />
                      <span class="card-title">Current Image</span>
                    </div>
                    <div class="card-content">
                      <p id="lgImgCaption">This is the current image. Upload an image to the right to replace it.</p>
                    </div>
                  </div>
                </div>
                <div class="col s6">
<?php } else { ?>
				<div class="col s12">
<?php } ?>
				<p class="white-text" id="upInstructions">First, upload a large image of the trail here:</p>

                <form action="up.php"
                      class="dropzone"
                      id="firstImage"><input type="hidden" name="t" value="i"/></form>                                           

                </div>
            </div>
                  
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col s12">
          <div class="card cyan darken-4">
            <div class="card-content white-text">
              <span class="card-title">Step 6: Attractions</span>
				<p>What are the unique attractions of this trail? Is there a playground? Are there nearby museums?</p>
				<div class="attractioncontainer">
<?php if($update) {
			echo('<div class="row" id="attrPre" style="margin-top:20px;">');
			$attrArray = "[";
			foreach($trail['attractions'] as $id => $attractionName) {
				$attraction = '<div class="col s4" id="DIVattractionN"><div class="card white"><div class="card-content black-text"><a class="closeButton black-text" href="#" onClick="fxnN"><i class="fa fa-close"></i></a><div class="input-field"><input placeholder="Something exciting!" id="attractionN" name="attractionN" type="text" class="validate"><label for="attractionN" id="attractionLN">Attraction N</label> </div></div></div>';
				$newattraction = str_replace('name="attractionN"', 'name="attraction'.$id.'" value="'.htmlspecialchars(rawurldecode($attractionName)).'"', $attraction);
				$newattraction = str_replace("attractionN", 'attraction'.$id, $newattraction);
				$newattraction = str_replace("Attraction N", 'Attraction '.($id + 1), $newattraction);
				$newattraction = str_replace("fxnN", "removeAttr(event, " . $id . ");", $newattraction);
				$attrArray .= $id.",";
				
				echo($newattraction);
				echo("</div>");
			}		
			$attrArray = rtrim($attrArray, ',');
			$attrArray .= "]";
			echo('<div class="col s4"><div class="card white"><div class="card-content black-text"><p class="center-text center-align"><a class="waves-effect waves-light blue lighten-1 btn addattr" href="#"><i class="material-icons left">add_circle</i>Add</a>
</p></div></div></div></div>');
}  else {
	$attrArray = "[]";
echo($attraction0); 
}
?>
            	</div>
            </div>

            <div class="card-action">
              <a href="#" onClick="validate6(event);">Validate</a>
              <div style="float:right; display:none; margin-top:-6px;" id="step6valid" class="green-text chip">
                <i class="fa fa-check"></i> Valid
              </div>
              <div style="float:right; display:none; margin-top:-6px;" id="step6invalid" class="red-text chip">
                <i class="fa fa-close"></i> Error
              </div>
            </div>

          </div>
        </div>
      </div>


      <div class="row">
        <div class="col s12">
          <div class="card pink darken-4">
            <div class="card-content">
              <span class="card-title white-text">Step 7: Publish?</span>
				<p class="white-text">Do you want to publish this trail now? If yes, it will be immediately publically available!</p>

				<div class="row" style="margin-top:15px;">
                    <div class="col s6 offset-s3">
                      <div class="card white">
                        <div class="card-content black-text center-align">
                          <span class="card-title black-text">Publish?</span>
                          <div class="switch">
                            <label>
                              Off
                              <input type="checkbox" id="publishSwitch" <?php if($update) { if($trail['published'] == "true") { ?>checked<?php } else { /* Not Checked */ } } else { ?>checked<?php } ?>>
                              <span class="lever"></span>
                              On
                            </label>
                          </div>
                        </div>
                        </div>
                      </div>
                    </div>
                </div>
                  
            </div>
          </div>
        </div>
 
<div class="row" style="text-align:center">
  <a class="btn waves-effect waves-light btn-large" href="#" onClick="submitTrail(event);">Submit
    <i class="material-icons right">send</i>
  </a> 
</div> 
        
      </div>



  <!-- Modal Structure -->
  <div id="grades" class="modal">
    <div class="modal-content">
      <h4>About Trail Difficulty</h4>
		<p>Trails are identified and graded according to their level of difficulty. Many trails are loops that go around a park or track.</p>
		<h4>Grade 1</h4>
        	<blockquote>Fully accessible to all users except where noted. A flat, paved pathway located in or around a park that is suitable for wheelchairs.</blockquote>
		<h4>Grade 2</h4>
        	<blockquote>Mostly Accessible. Paved or packed crushed fine pathway that may have minor grade changes.</blockquote>
		<h4>Grade 3</h4>
        	<blockquote>Slightly challenging. A paved, packed, crusher, fine or dirt pathway with variations in grade.</blockquote>
		<h4>Grade 3++</h4>
        	<blockquote>Challenging. A paved, packed, crusher, fine or dirt pathway with variations in grade and/or unstable surfaces. Not for the beginner.</blockquote>
    </div>
    <div class="modal-footer">
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Close</a>
    </div>
  </div>

  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="dropzone.js"></script>
  <script src="jquery.cropit.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.1/js/materialize.min.js"></script>
  <script src="https://maps.google.com/maps/api/js?sensor=false"></script>

  <script>
var postData = {};
		postData.loops = {};
		postData.attractions = {};
		postData.publish = <?php if($update) { if($trail['publish']) { echo("true"); } else { echo("false"); } } else { echo("true"); } ?>;
		<?php if($update) { ?>postData.id = <?php echo($trail['id'].";"); } ?>
var loopcount = <?php if($update) { echo($trail['loopcount']); } else { echo(0); } ?>;
var lng<?php if($update) { echo(' = "'.$trail['lng'].'"'); } ?>;
var lat<?php if($update) { echo(' = "'.$trail['lat'].'"'); } ?>;
var satImgURL<?php if($update) { echo(' = "'.$trail['satImgURL'].'"'); } ?>;
var largeImgURL<?php if($update) { echo(' = "'.$trail['largeImgURL'].'"'); } ?>;
var thumbURL<?php if($update) { echo(' = "'.$trail['thumbURL'].'"'); } ?>;
var attrCount = <?php if($update) { echo(count($trail['attractions'])); } else { echo(0); } ?>;
var attrArray = <?php echo($attrArray); ?>;

var satImgContainer = $("#satImgContainer").html();
var covImgContainer = $("#covImgContainer").html();

Dropzone.options.firstImage = {
	  paramName: "file", // The name that will be used to transfer the file
	  maxFilesize: 4, // MB
	  maxFiles: 1,
	  addRemoveLinks: true,
	  init: function() {
		this.on("success", function(file) { 
			Materialize.toast('File uploaded!', 4000);
			var upResult = jQuery.parseJSON(file.xhr.response);
			cropImg( upResult.file, upResult.thumbname );
		});
	 	this.on("maxfilesexceeded", function(file){
        	Materialize.toast('You can\'t upload more than one file!', 4000);
    	});

	  },
	  accept: function(file, done) {
		 done();
	  }
	}; 
Dropzone.options.satImage = {
	  paramName: "file", // The name that will be used to transfer the file
	  maxFilesize: 4, // MB
	  maxFiles: 1,
	  addRemoveLinks: true,
	  init: function() {
		this.on("success", function(file) { 
			Materialize.toast('File uploaded!', 4000);
			var upResult = jQuery.parseJSON(file.xhr.response);
			satImgURL = upResult.file;
			$("#satImage").hide();
			$("#satDone").show();
			$("#satImgTag").prop("src",satImgURL);
			$("#satImgCaption").text("The previous image has been replaced.");
		});
	 	this.on("maxfilesexceeded", function(file){
        	Materialize.toast('You can\'t upload more than one file!', 4000);
    	});

	  },
	  accept: function(file, done) {
		 done();
	  }
	}; 

(function($){
  $(function(){

	$('.modal-trigger').leanModal();
    $('.button-collapse').sideNav();
	$('select').material_select();

	$( "#loopcount" ).change(function() {
		loopcount = $( "#loopcount" ).val();
		if(loopcount == 0) {
			var newcontent = '<?php echo($loop0); ?>';	
		} else {
			var newcontent = "";
			for (var i = 0; i < loopcount; i++) { 
				var c = i + 1;
				var loophtml = '<?php echo($loop); ?>';
				var find = 'loopNname';
				var re = new RegExp(find, 'g');
				var newloop = loophtml.replace(re, "loop"+c+"name");
				var find = 'loopNdistance';
				var re = new RegExp(find, 'g');
				newloop = newloop.replace(re, "loop"+c+"distance");
				var find = 'loopNsteps';
				var re = new RegExp(find, 'g');
				newloop = newloop.replace(re, "loop"+c+"steps");
	            newloop = newloop.replace("Loop N", "Loop "+c);
	            newloop = newloop.replace("calcSteps(N,event);", "calcSteps("+c+",event);");
				newcontent += newloop;
			 }
		}
		$(".loopcontainer").html(newcontent);
		var input_selector = '.loopDynamic';
		  $(input_selector).each(function(index, element) {
			  $(this).addClass('active');
		  });
	});

<?php if($update) { ?>postData.publish = <?php echo($trail['published'].";"); } ?>

$('#publishSwitch').change(function() {
	postData.publish = $(this).prop('checked');
});

$(".addattr").click(function(e) {
    e.preventDefault();
	  attrCount = attrCount + 1;
	  var attrhtml = '<?php echo($attraction); ?>';
	  var find = 'attractionN';
	  var re = new RegExp(find, 'g');
	  var newattr = attrhtml.replace(re, "attraction"+attrCount);
	  newattr = newattr.replace("Attraction N", "Attraction " + attrCount);
	  newattr = newattr.replace("attractionLN", "attractionL" + attrCount);
	  newattr = newattr.replace("fxnN", "removeAttr(event, " + attrCount + ");");
	  attrArray.push(attrCount);
	$("#attrPre").prepend(newattr);
	$("#attractionL"+ attrCount).addClass('active');
});

  }); // end of document ready
})(jQuery); // end of jQuery name space 

function removeAttr(e, n) {
    e.preventDefault();
	$("#DIVattraction" + n).remove();
	var index = attrArray.indexOf(n);
	if (index > -1) {
		attrArray.splice(index, 1);
	}	
	console.log(attrArray);
}

function cropImg(imgURL,thumbname) {
	var thumbname = thumbname;
	largeImgURL = imgURL;
	$("#toCrop").hide();
	$("#firstImage").hide();
	$("#imgPreview").hide();
	$('<iframe>', {
	   src: '<?php echo($baseurl); ?>admin/new/crop.php?url=' + encodeURIComponent(imgURL) + '&name=' + encodeURIComponent(thumbname),
	   id:  'cropFrame',
	   frameborder: 0,
	   height: 360,
	   scrolling: 'no'
	 }).css("width","100%").css("max-height","450px").appendTo('#image-cropper');
	$('#image-cropper').addClass("video-container").show();
	$("#upInstructions").text("Now, crop the image you uploaded for search and the homepage.");
}

function updateImg(imgURL) {
	thumbURL = imgURL;
}

function validate1(e) {
	
	e.preventDefault();

	$("#lat").removeClass("valid");
	$("#lng").removeClass("valid");

	var error = false;
	$("#step1valid").hide();
	$("#step1invalid").hide();

	var name = $("#name").val();
	if(name === "") {
		error = true;
		$("#name").addClass("invalid");
	}
	
	var city = $("#city").val();
	if(city === "empty") {
		error = true;
		$("#city").addClass("invalid");
	}

	var zip = $("#zip").val();
	if(zip === "") {
		error = true;
		$("#zip").addClass("invalid");
	}
	var isValid = /^[0-9]{5}(?:-[0-9]{4})?$/.test(zip);
	if (!isValid) {
		error = true;
		$("#zip").addClass("invalid");
	}

	var crossstreets = $("#crossstreets").val();
	if(crossstreets === "") {
		error = true;
		$("#crossstreets").addClass("invalid");
	}

	var transit = $("#transit").val();
	if(transit === "") {
		error = true;
		$("#transit").addClass("invalid");
	}


	var address	 = $("#address").val();
	if(address === "") {
		error = true;
		$("#address").addClass("invalid");
	}

   var geocoder = new google.maps.Geocoder();
   var streetAdr = address;
   var address = address + ", " + city + ", New Mexico " + zip;

	if(!error) {
	   if (geocoder) {
		  geocoder.geocode({ 'address': address }, function (results, status) {
			 if (status == google.maps.GeocoderStatus.OK) {
				lat = results[0].geometry.location.lat();
				lng = results[0].geometry.location.lng();
				console.log(lat + " " + lng);
				$("#lat").val(lat).addClass("valid");
				$("#lng").val(lng).addClass("valid");
			 }
			 else {
				error = true;
				console.log("Geocoding failed: " + status);
				$("#address").addClass("invalid");
				$("#city").addClass("invalid");
				$("#zip").addClass("invalid");
			 }
		  });
	   }    
	}

	if(error) {
		Materialize.toast('Validation of Step 1 failed!', 8000);
		$("#step1invalid").fadeIn(1000);
		return false;
	} else {
		$("#step1valid").fadeIn(1000);
		postData["name"] = name;
		postData["city"] = city;
		postData["zip"] = zip;
		postData["crossstreets"] = crossstreets;
		postData["address"] = streetAdr;
		postData["transit"] = transit;
		postData["lat"] = lat;
		postData["lng"] = lng;
		return true;
	}
	
}

function validate2(e) {
	
	e.preventDefault();

	var error = false;
	$("#step2valid").hide();
	$("#step2invalid").hide();

	var desc = $("#desc").val();
	if(desc === "") {
		error = true;
		$("#desc").addClass("invalid");
	} else { 
		if(desc.length > 500) {
			error = true;
			$("#desc").addClass("invalid");
		}
		if(desc.length < 75) {
			error = true;
			$("#desc").addClass("invalid");
			Materialize.toast('The description needs to be a little longer!', 8000);
		}
	}
	
	var lighting = $("#lighting").val();
	if(lighting === "") {
		error = true;
		$("#lighting").addClass("invalid");
	}

	var surface = $("#surface").val();
	if(surface === "") {
		error = true;
		$("#surface").addClass("invalid");
	}

	var parking = $("#parking").val();
	if(parking === "") {
		error = true;
		$("#parking").addClass("invalid");
	}

	var facilities = $("#facilities").val();
	if(facilities === "") {
		error = true;
		$("#facilities").addClass("invalid");
	}

	var hours = $("#hours").val();
	if(hours === "") {
		error = true;
		$("#hours").addClass("invalid");
	}

	var loopcount = $("#loopcount").val();
	if(loopcount === "") {
		error = true;
		$("#loopcount").addClass("invalid");
	}

	if(!error) {
		var difficulty = $("input[name='difficulty']:checked").val();
		if(difficulty != "1" && difficulty != "2" && difficulty != "3" && difficulty != "4") {
			error = true;
			$("#difficulty").addClass("invalid");
			Materialize.toast('Please provide the trail grade!', 8000);
		}
	}

	if(error) {
		Materialize.toast('Validation of Step 2 failed!', 8000);
		$("#step2invalid").fadeIn(1000);
		return false;
	} else {
		$("#step2valid").fadeIn(1000);
		postData["desc"] = desc;
		postData["lighting"] = lighting;
		postData["difficulty"] = difficulty;
		postData["surface"] = surface;
		postData["parking"] = parking;
		postData["facilities"] = facilities;
		postData["hours"] = hours;
		postData["loopcount"] = loopcount;
		return true;
	}
	
}

function validate3(e) {

	e.preventDefault();

	var error = false;
	$("#step3valid").hide();
	$("#step3invalid").hide();
	
	if(loopcount == 0 || loopcount === "") {
		Materialize.toast('You haven\'t added any loops!', 8000);
		$("#step2invalid").fadeIn(1000);
		$("#step3invalid").fadeIn(1000);
		return false;
	} else {
		for (var i = 0; i < loopcount; i++) { 
			var c = i + 1;
			
			var name = $("#loop" + c + "name").val();
			if(name === "") {
				error = true;
				$("#loop" + c + "name").addClass("invalid");
			}

			var distance = $("#loop" + c + "distance").val();
			if(distance === "") {
				error = true;
				$("#loop" + c + "distance").addClass("invalid");
			}
			
			var steps = parseInt($("#loop" + c + "steps").val());
			if(steps === "") {
				error = true;
				$("#loop" + c + "steps").addClass("invalid");
			}
			if (steps === parseInt(steps, 10)) {
				var cool = 1;
			} else {
				Materialize.toast('Steps must be an integer!', 8000);
				error = true;
				$("#loop" + c + "steps").addClass("invalid");
			}
			
			if(error) {
				Materialize.toast('Validation of Loop '+c+' failed!', 8000);
				$("#step3invalid").fadeIn(1000);
			} else {
				postData.loops[c] = {};
				postData.loops[c]["name"] = $("#loop" + c + "name").val();
				postData.loops[c]["distance"] = $("#loop" + c + "distance").val();
				postData.loops[c]["steps"] = $("#loop" + c + "steps").val();
			}
		 }
			if(error) {
				return false;
			} else {
				$("#step3valid").fadeIn(1000);
				console.log(postData);
				return true;
			}
	}

}

function validate4() {
	    return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(satImgURL);
}

function validate5() {
	    return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(thumbURL);
}

function validate6(e) {
	e.preventDefault();
	
	var error = false;
	$.each(attrArray, function( index, value ) {
		var name = $("#attraction" + value ).val();
		if(name === "") {
			error = true;
			$("#attraction" + value ).addClass("invalid");
			Materialize.toast('Validation of Attraction '+value+' failed!', 8000);
		} else {
			postData.attractions[value] = {};
			postData.attractions[value]["name"] = $("#attraction" + value ).val();	
		}
	});
	if(error) {
		$("#step6invalid").fadeIn(1000);
		return false;
	} else {
		$("#step6valid").fadeIn(1000);
		postData["attrArray"] = attrArray.toString();
		return true;
	}
}

function calcSteps(N,e) {
	
	e.preventDefault();
	
	var miles = $("#loop" + N + "distance").val();
	
	if(isNaN(miles)) {
		Materialize.toast('Distance must be a number!', 4000);
		$("#loop" + N + "distance").addClass("invalid");
	} else {	
		var steps = Math.round(miles * 2112);	
		$("#loop" + N + "steps").val(steps);
		$("#loop" + N + "steps").addClass("valid");
		Materialize.toast('Steps calculated from distance.', 4000);
	}
	
	return true;
}

function submitTrail(e) {
	
	e.preventDefault();
	
	is1valid = 	validate1(e);
	is2valid = 	validate2(e);
	is3valid = 	validate3(e);
	is6valid =  validate6(e);
	
	if(is1valid && is2valid && is3valid && is6valid) {

		if(postData.publish) {

			is4valid = 	validate4();
			is5valid = 	validate5();
			
			if(is4valid && is5valid) {
				
				satImgURL = satImgURL.replace("<?php echo($baseurl); ?>", "");
				largeImgURL = largeImgURL.replace("<?php echo($baseurl); ?>", "");
				thumbURL = thumbURL.replace("<?php echo($baseurl); ?>", "");
				postData["satImgURL"] = satImgURL;
				postData["largeImgURL"] = largeImgURL;
				postData["thumbURL"] = thumbURL;
				post("<?php echo($baseurl); ?>admin/new/<?php if($update) { ?>update.php<?php } else { ?>post.php<?php } ?>", postData);
				
			} else {
			
				Materialize.toast('You must upload images!', 8000);
				
			}
			
		} else {

			is4valid = 	validate4();
			is5valid = 	validate5();
		
			if(is4valid && is5valid) {
				
				satImgURL = satImgURL.replace("<?php echo($baseurl); ?>", "");
				largeImgURL = largeImgURL.replace("<?php echo($baseurl); ?>", "");
				thumbURL = thumbURL.replace("<?php echo($baseurl); ?>", "");
				postData["satImgURL"] = satImgURL;
				postData["largeImgURL"] = largeImgURL;
				postData["thumbURL"] = thumbURL;
				post("<?php echo($baseurl); ?>admin/new/<?php if($update) { ?>update.php<?php } else { ?>post.php<?php } ?>", postData);
				
			} else {
			
				postData["satImgURL"] = "img/placeholder-sm.png";
				postData["largeImgURL"] = "img/placeholder-lg.png";
				postData["thumbURL"] = "img/placeholder-sm.png";
				post("<?php echo($baseurl); ?>admin/new/<?php if($update) { ?>update.php<?php } else { ?>post.php<?php } ?>", postData);
				
			}
			
		}
		
	} else {
	
		return false;
		
	}
	
}

// Post to the provided URL with the specified parameters.
function post(path, parameters) {
    var form = $('<form></form>');

    form.attr("method", "post");
    form.attr("action", path);

    $.each(parameters, function(key, value) {
        var field = $('<input></input>');

        field.attr("type", "hidden");
        field.attr("name", key);
        field.attr("value", value);

        form.append(field);
    });
	$.each(attrArray, function( index, value ) {
		var postvalue = postData.attractions[value]["name"];
		var key = "attraction" + value;
        var field = $('<input></input>');

        field.attr("type", "hidden");
        field.attr("name", key);
        field.attr("value", postvalue);

        form.append(field);
	});

		for (var i = 0; i < loopcount; i++) { 
			var c = i + 1;
			
			var name = $("#loop" + c + "name").val();

			var distance = $("#loop" + c + "distance").val();
			
			var steps = parseInt($("#loop" + c + "steps").val());
			
			var field = $('<input></input>');
	
			field.attr("type", "hidden");
			field.attr("name", "loop" + c + "name");
			field.attr("value", name);
	
			form.append(field);
			
			var field = $('<input></input>');
	
			field.attr("type", "hidden");
			field.attr("name", "loop" + c + "distance");
			field.attr("value", distance);
	
			form.append(field);
			
			var field = $('<input></input>');
	
			field.attr("type", "hidden");
			field.attr("name", "loop" + c + "steps");
			field.attr("value", steps);
	
			form.append(field);
			
			
		 }


    // The form needs to be a part of the document in
    // order for us to be able to submit it.
    $(document.body).append(form);
    form.submit();
}
  </script>

  </body>
</html>
