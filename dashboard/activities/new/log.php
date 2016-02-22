<?php
require("../../../admin/db.php");
require("../../../src/secure.php"); 
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
  <div id="replace">
      <span class="card-title">Add <?php echo($trail['name']); ?> to your walking log!</span>
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
    <div class="row center" style="height:70px;">
      <a href="#" style="float:none;" onClick="postLogActivity(event,<?php echo($trail['id']); ?>);" class="waves-effect waves-light btn green darken-1" id="activitySubmit"><?php echo($lexicon[36][$lang_set]); //Submit ?></a>
      <a href="#!" style="float:none;" class="waves-effect waves-dark btn red darken-1 white-text" onclick="Reset();">Back</a>
    </div>
  </div>
