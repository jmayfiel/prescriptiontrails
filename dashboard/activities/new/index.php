<?php 
require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php"); 
require("/nfs/users/clind/public_html/prescriptiontrails.org/src/secure.php"); 
$reportObj = new activity;
$report = $reportObj->getUserReport($_SESSION['user_id']); 

$sumArray = array();

foreach ($report as $k=>$subArray) {
  foreach ($subArray as $id=>$value) {
    $sumArray[$id]+=$value;
  }
}

$ActCount = count($report);

$special = "breadcrumb";
$breadcrumb = '<a href="'.$baseurl.'dashboard/" class="green-text text-darken-3"><i class="fa fa-home"></i></a>';
$breadcrumb .= '&nbsp;&nbsp;<i class="fa fa-chevron-right grey-text text-darken-1" style="padding-top:1px;"></i>&nbsp;&nbsp;<a href="'.$baseurl.'dashboard/activities/" class="green-text text-darken-3">Walking Log</a>&nbsp;&nbsp;<i class="fa fa-chevron-right grey-text text-darken-1" style="padding-top:1px;"></i>&nbsp;&nbsp;<a href="'.$baseurl.'dashboard/activities/new/" class="green-text text-darken-3">New Entry</a>';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Prescription Trails - New Activity</title>

  <!-- CSS  -->
<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/style_base.php"); ?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/ui-lightness/jquery-ui.css" />  

</head>
<body class="<?php echo($bodyclass); ?>">
  

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/nav.php"); ?>

<div class="container">
    <div class="row">
            
        <div class="col s12" style="margin-top:20px;">
				
              <h1 class="glow center hide-on-med-and-down"><?php echo($lexicon[16][$lang_set]); //Walking Log ?></h1>
              <h2 class="glow center hide-on-large-only hide-on-small-and-down"><?php echo($lexicon[16][$lang_set]); //Walking Log ?></h2>
              <h4 class="glow center hide-on-med-and-up"><?php echo($lexicon[16][$lang_set]); //Walking Log ?></h4>
                
        </div>
    
    </div>

    <div class="row stepDiv" id="stepOneDiv">

		<div class="col s12 m10 offset-m1 l8 offset-l2">
        
        	<div class="card white">
            	<div class="card-content">
                <span class="card-title">Step 1. Choose type</span>
                	<p>Choose the type of log you'd like to start from the options below. </p>
                    <div class="row" style="margin-top:20px;">
                        <div class="col s12">
                            <a class="btn blue waves-effect waves-light" style="width:100%" href="#!" onClick="stepOne(event,1);">From Favorites</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <a class="btn blue waves-effect waves-light" style="width:100%" href="#!" onClick="stepOne(event,2);">Search by Name</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <a class="btn blue waves-effect waves-light" style="width:100%" href="<?php echo($baseurl); ?>filter/?r=new">Full Search Feature</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <a class="btn blue waves-effect waves-light" style="width:100%" href="#!" onClick="stepOne(event,3);">Custom Trail</a>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>
    
    </div>

    <div id="nameSearch" class="row stepDiv" style="display:none;">

		<div class="col s12 m10 offset-m1 l8 offset-l2">
            <div class="card white">
            	<div class="card-content">
	                <span class="card-title">Step 2. Search by Name</span>
                    <p>Enter the name (or part of the name) of the trail you'd like to log, then click on the correct option.</p>
                    <div class="row" style="margin-top:10px;">
                          <div class="input-field col s12">
                              <input id="name" type="text" name="name">
                              <label for="name">Enter search</label>
                          </div>
                    </div>
                 </div>
            </div>
        </div>

	</div>

    <div id="loadingDiv" class="row stepDiv" style="display:none;">

		<div class="col s12 m10 offset-m1 l8 offset-l2">
            <div class="card-panel white center-align">
              <p class="black-text" style="margin-bottom:5px;"><img width="50" src="../../favorites/load.gif"></p>
              <p class="black-text flow-text" style="margin-top:5px;">One moment please! =]</p>
            </div>
        </div>

	</div>

    <div id="favDiv" class="row stepDiv" style="display:none;">

		<div class="col s12 m10 offset-m1 l8 offset-l2">
            <div class="card-panel white">
	            <span class="card-title">Step 2. Pick from Favorites</span>
                <div id="favReplace">
                  <p class="black-text" style="margin-bottom:5px;"><img width="50" src="../../favorites/load.gif"></p>
                  <p class="black-text flow-text" style="margin-top:5px;">One moment please! =]</p>
                </div>
            </div>
        </div>

	</div>

    <div id="logActivity" class="row stepDiv" style="display:none;">

		<div class="col s12 m10 offset-m1 l8 offset-l2">
        	<div class="card-panel white">
                <div id="replace">
                </div>
            </div>
        </div>

	</div>

	<div id="customLog" class="row stepDiv" style="display:none;">
		<div class="col s12 m10 offset-m1 l8 offset-l2">
        	<div class="card-panel white">
            <div id="CustomActivityContent">
              <span class="card-title">Step 2. Custom Log</span>
                <p>Please select the date of this walk. Today's date is already selected for you.</p>		            
                <div class="row">
                          <div class="input-field col s5">
                            <select id="activityMonthCustom" name="activityMonthCustom">
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
                            <select id="activityDayCustom" name="activityDayCustom">
                              <?php $i = 1; while($i < 32) { ?>
                              <option value="<?php echo($i); ?>" <?php if($i == intval(date("j"))) { ?>selected<?php } ?>><?php echo($i); ?></option>
                              <?php $i++; } ?>
                            </select>
                            <label><?php echo($lexicon[38][$lang_set]); //Day ?></label>
                          </div>       
                          <div class="input-field col s4">
                            <select id="activityYearCustom" name="activityYearCustom">
                              <option value="<?php echo(date("Y")); ?>" selected><?php echo(date("Y")); ?></option>
                              <option value="<?php echo(intval(date("Y")) - 1); ?>"><?php echo(intval(date("Y")) - 1); ?></option>
                            </select>
                            <label><?php echo($lexicon[39][$lang_set]); //Year ?></label>
                          </div>       
                </div>
                <p>How far did you walk?</p>
					<div class="row">
                    	<div class="col s4 input-field">
                            <input placeholder="e.g. 1.2" id="customdistance" name="customdistance" type="text" class="validate"><label for="customdistance">How many miles did you walk?</label>
                        </div>
                        
                        <div class="col s2"><a href="#" class="waves-effect waves-light btn-flat btn-small tooltipped" data-position="bottom" data-delay="50" data-tooltip="Calculate distance from steps" style="margin-top:21px;" onClick="calcDistance(event);"><i class="fa fa-arrow-left"></i><i class="fa fa-calculator"></i></a></div>
                        <div class="col s2"><a href="#" class="waves-effect waves-light btn-flat btn-small tooltipped" data-position="bottom" data-delay="50" data-tooltip="Calculate steps from distance" style="margin-top:21px;" onClick="calcSteps(event);"><i class="fa fa-calculator"></i><i class="fa fa-arrow-right"></i></a></div>
                        
                        <div class="col s4 input-field">
                            <input placeholder="e.g. 1200" id="customsteps" name="customsteps" type="number" class="validate"><label for="customsteps">How many steps is this loop?</label>
                        </div>
                    </div>
                <p class="center-align">About how many minutes did you spend walking?</p>
                <div class="row">
                    <div class="input-field col s4 offset-s4">
                      <input placeholder="X <?php echo($lexicon[41][$lang_set]); //Minutes ?>" id="activityTimeCustom" name="activityTimeCustom" type="number" class="validate">
                      <label for="activityTime"><?php echo($lexicon[41][$lang_set]); //Minutes ?></label>            
                    </div>
                </div>        	
            </div>
            <div class="modal-footer center" id="customActBtns" style="height:70px;">
              <a href="#" style="float:none;" onClick="postLogActivityCustom(event);" class="waves-effect waves-light btn green darken-1" id="activitySubmitCustom"><?php echo($lexicon[36][$lang_set]); //Submit ?></a>&nbsp;
              <a href="<?php echo($baseurl); ?>dashboard/activities/new/" style="float:none;" class="waves-effect waves-dark btn red darken-1 white-text">Back</a>
            </div>
            </div>
          </div>    
            </div>
        </div>
    </div>

</div>
    
    
      
<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/drawer.php"); ?>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/js_base.php"); ?>
<script src="<?php echo($baseurl); ?>dashboard/favorites/js.php"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script>
// Closure
(function() {
  /**
   * Decimal adjustment of a number.
   *
   * @param {String}  type  The type of adjustment.
   * @param {Number}  value The number.
   * @param {Integer} exp   The exponent (the 10 logarithm of the adjustment base).
   * @returns {Number} The adjusted value.
   */
  function decimalAdjust(type, value, exp) {
    // If the exp is undefined or zero...
    if (typeof exp === 'undefined' || +exp === 0) {
      return Math[type](value);
    }
    value = +value;
    exp = +exp;
    // If the value is not a number or the exp is not an integer...
    if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
      return NaN;
    }
    // Shift
    value = value.toString().split('e');
    value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
    // Shift back
    value = value.toString().split('e');
    return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
  }

  // Decimal round
  if (!Math.round10) {
    Math.round10 = function(value, exp) {
      return decimalAdjust('round', value, exp);
    };
  }
  // Decimal floor
  if (!Math.floor10) {
    Math.floor10 = function(value, exp) {
      return decimalAdjust('floor', value, exp);
    };
  }
  // Decimal ceil
  if (!Math.ceil10) {
    Math.ceil10 = function(value, exp) {
      return decimalAdjust('ceil', value, exp);
    };
  }
})();

function calcSteps(e) {
	
	e.preventDefault();
	
	var miles = $("#customdistance").val();
	
	if(isNaN(miles)) {
		Materialize.toast('Distance must be a number!', 4000);
		$("#customdistance").addClass("invalid");
	} else {	
		var steps = Math.round(miles * 2112);	
		$("#customsteps").val(steps);
		$("#customsteps").addClass("valid");
		Materialize.toast('Steps calculated from distance.', 4000);
	}
	
	return true;
}

function calcDistance(e) {
	
	e.preventDefault();
	
	var steps = $("#customsteps").val();
	
	if(isNaN(steps)) {
		Materialize.toast('Steps must be a number!', 4000);
		$("#customdistance").addClass("invalid");
	} else {	
		var distance = Math.round10((steps / 2112), -2);	
		$("#customdistance").val(distance);
		$("#customdistance").addClass("valid");
		Materialize.toast('Steps calculated from distance.', 4000);
	}
	
	return true;
}

var favoritesObj = JSON.parse("<?php echo(json_encode(array_values($_SESSION['data']['fav']))); ?>");
var favorites = $.map(favoritesObj, function(el) { return el });

function showLoading() {
	$(".stepDiv").hide("slide", { direction: "left" }, 400);
	$("#loadingDiv").delay(401).show("slide", { direction: "right" }, 400);
}
function showDiv(name) {
	$(".stepDiv").hide("slide", { direction: "left" }, 400);
	$("#"+name).delay(401).show("slide", { direction: "right" }, 400);
}
function stepOne(e, opt) {
	e.preventDefault();
	if(opt == 1) {
		showLoading();
		loadFavorites();
	}
	if(opt == 2) {
		loadSearch();
	}
	if(opt == 3) {
		showDiv("customLog");
	}
}
function loadFavorites() {
    $.get( "<?php echo($baseurl); ?>dashboard/favorites/getAll.php?count=show", function(data) {
		var count = data.count;
		var trails = data.trails;
		$("#loadingFavCount").replaceWith('<h2>'+count+'</h2>');
		if(count == 0) {
		  var html = '<div class="card-panel white"><p class="flow-text center">It looks like you don\'t have any favorite trails yet! Trying <a href="<?php echo($baseurl); ?>filter/">searching for trails</a> to favorite. :)</p></div>';
		} else {
		  var html = prepareHTML(trails); 
		}
		  $("#favReplace").replaceWith(html);
		  setTimeout(function(){ showDiv("favDiv"); }, 500);
	},"json")
  .fail(function() {
    Materialize.toast( "Error: No internet connection", 10000 );
	setTimeout(function(){ window.location = "<?php echo($baseurl); ?>dashboard/"; }, 10010);
  });
}
function prepareHTML(NextLoadArray) {
	var NextContent = '<p>Please select one of your favorites!</p> <ul class="collection" style="margin-top:10px;" id="trails">';
    $.each( NextLoadArray, function( key, value ) {
		if(value['loopcount'] == 1) {
			var distance 	= value['loops'][1]['distance'];
			var steps 		= value['loops'][1]['steps'];
		} else {
				var distance = 0;
				var steps	 = 0;
				$.each(value.loops, function( id, details ) {
					distance 	= Number(value['loops'][id]['distance']) + distance;
					steps 		= Number(value['loops'][id]['steps']) + steps;
				});
				distance = distance.toFixed(2);
		}

	var favText = "";
		
	  NextContent += '<li class="collection-item avatar"><img src="' + value.thumbURL + '" alt="" class="circle"><span class="title"><a href="#" onClick="openLogWrap(event,'+value.id+');">' + value.name + '</a></span>';
	  NextContent += '<p>' + value.city + ', ' + value.zip + '<br><a href="#" onClick="openLogWrap(event,'+value.id+');">Log a walk at this trail</a></p>';
	  NextContent += favText + '</li>';

	});
	
	NextContent += '</ul>';
	return NextContent;	
}

function loadSearch() {
	showDiv("nameSearch");
}
function openLogWrap(e,tid) {
	e.preventDefault();
	openLog(tid);
}
function openLog(tid) {
	showLoading();
    $.get( "<?php echo($baseurl); ?>dashboard/activities/new/log.php?id="+tid, function(data) {
	  $("#replace").replaceWith(data); $('select').material_select(); $('input').addClass("active");	  
	  setTimeout(function(){ showDiv("logActivity"); }, 500);
	})
  .fail(function() {
    Materialize.toast( "Error: No internet connection", 10000 );
	setTimeout(function(){ window.location = "<?php echo($baseurl); ?>dashboard/"; }, 10010);
  })
}
	$(document).ready(function() {
	  $.ajaxSetup({ cache: true });
	  $.getScript('<?php echo($baseurl); ?>dashboard/activities/new/js.php', function(){
		$( "#name" ).autocomplete({
		  source: SearchTrails,
		  select: function( event, ui ) {
			openLog(ui.item.id);
		  }
    });  
	  });
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
	function postLogActivityCustom(e) {
		e.preventDefault();
		$("#activitySubmitCustom").prop("disabled",true);
			var missing = true;
			if ($( "#activityTimeCustom" ).val().length < 1) {
				missing = false;
				$( "#activityTimeCustom" ).addClass("invalid");
				Materialize.toast("How much time did you spend?", 8000);
			}
		var totaldistance = $("#customdistance").val();
		var totalsteps = $("#customsteps").val();
		var month = $("#activityMonthCustom").val();
		var day = $("#activityDayCustom").val();
		var year = $("#activityYearCustom").val();
		var time = $("#activityTimeCustom").val();
		var date = month + " " + day + ", " + year;
		if(totaldistance == 0 || missing === false) {
			Materialize.toast('Please complete all fields.', 5000);
			$("#activitySubmit").prop("disabled",false);
		} else {
			fbdistance = totaldistance;
			var formData = {
				'type'			: "custom",
				'date'			: date,
				'time'			: time,
				'steps'			: totalsteps,
				'distance'		: totaldistance,
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
						ga('send', 'event', "log", "log-custom", "steps: "+totalsteps);
						$("#customActBtns").replaceWith('');
						Materialize.toast("Trail logged!", 5000);
						$("#CustomActivityContent").html("<div class='row center-align' style='margin-top:50px;'><h1><i class='fa fa-2x fa-thumbs-up'></i></h1></div><div class='row'><div class='col s12 center-align'><p class='flow-text'>Your activity was logged successfully!</p></div></div>"+
                        '<div class="row center" style="height:70px;">'+
                        '<a href="#" style="float:none;" onClick="Reset();" class="waves-effect waves-light btn green darken-1" id="activitySubmit">Start New Log</a>&nbsp;'+
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

</script>

  </body>
</html>
