<?php
require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php");
require("/nfs/users/clind/public_html/prescriptiontrails.org/src/secure.php"); 
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past	
header('Content-Type: application/javascript');
?>
var loopdistance = {};
var loopsteps = {};
var loopcount = {};
var trailname = {};
<?php

$allTrailObj = new trails;
$allTrails = $allTrailObj->getAll(); 

$trails = $allTrails['trails'];

$favorites = array();

foreach($trails as $id => $trail) {

	if(in_array($trail['id'], $_SESSION['data']['fav'])) {
?>
trailname[<?php echo($trail['id']); ?>] = "<?php echo(urlencode($trail['name'])); ?>";
loopdistance[<?php echo($trail['id']); ?>] = {};
loopsteps[<?php echo($trail['id']); ?>] = {};
<?php
	if($trail['loopcount'] == 1) {  
			echo("loopdistance[".$trail['id']."][1] = ".$trail['loops'][1]['distance'].";");
			echo("loopsteps[".$trail['id']."][1] = ".$trail['loops'][1]['steps'].";");
			echo("loopcount[".$trail['id']."] = 1;");
		} else {
			$i = 0;
			foreach($trail['loops'] as $id => $details) {
					$i = $i + 1;		
			?>
loopsteps[<?php echo($trail['id']); ?>][<?php echo($i); ?>] = <?php echo($details['steps']); ?>;
loopdistance[<?php echo($trail['id']); ?>][<?php echo($i); ?>] = <?php echo($details['distance']); ?>;
<?php
			}
?>
loopcount[<?php echo($trail['id']); ?>] = <?php echo($i); ?>;
<?php	
		}
?>                    			            

<?php
	}
	
}



?>
	function postLogActivity (e,tid) {
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
        var thisloopcount = loopcount[tid];
		while(iterateloops < thisloopcount) {
			loopid = iterateloops + 1;
			var count = $("#loop"+loopid).val();
				var distance = count * loopdistance[tid][loopid];
				var steps = count * loopsteps[tid][loopid];
				totaldistance = totaldistance + distance;
				totalsteps = totalsteps + steps;
			iterateloops++;	
		}
		if(totaldistance == 0 || missing === false) {
			Materialize.toast('Please complete all fields.', 5000);
			$("#activitySubmit").prop("disabled",false);
		} else {
			var formData = {
				'trail_id'		: tid,
				'type'			: "trail",
				'date'			: date,
				'time'			: time,
				'steps'			: totalsteps,
				'distance'		: totaldistance,
				'trail_name'	: trailname[tid],
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
						$("#activitySubmit").hide();
						Materialize.toast("Trail logged!", 5000);
						$("#activityContent").html("<div class='row center-align' style='margin-top:50px;'><h1><i class='fa fa-2x fa-thumbs-up'></i></h1></div><div class='row'><div class='col s12 center-align'><p class='flow-text'>Your activity was logged successfully!</p></div></div>"+
                        '<div class="row center" style="height:70px;">'+
                        '<a href="#" style="float:none;" onClick="Reset();" class="waves-effect waves-light btn green darken-1" id="activitySubmit">Start New Log</a>'+
                        '<a href="<?php echo($baseurl); ?>dashboard/" style="float:none;" class="waves-effect waves-dark btn blue darken-1 white-text">Dashboard</a>'+
					    '</div>');
					} else {
						Materialize.toast('Error: '+data.message, 5000);
					}
				})
			  .fail(function(xhr, textStatus, errorThrown) {
					Materialize.toast('Error: '+xhr.responseText, 10000);
				});	
		}
		
	}
function Reset() {
    window.location = "<?php echo($baseurl); ?>dashboard/activities/new/";
}