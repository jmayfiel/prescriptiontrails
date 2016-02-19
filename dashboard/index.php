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

function thousandsCurrencyFormat($num) {
  $x = round($num);
  $x_number_format = number_format($x);
  $x_array = explode(',', $x_number_format);
  $x_parts = array('k', 'm', 'b', 't');
  $x_count_parts = count($x_array) - 1;
  $x_display = $x;
  $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
  $x_display .= $x_parts[$x_count_parts - 1];
  return $x_display;
}

function properize($string) {
	return $string.'&rsquo;'.($string[strlen($string) - 1] != 's' ? 's' : '');
}

$ActCount = count($report);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Prescription Trails - Dashboard</title>

  <!-- CSS  -->
<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/style_base.php"); ?>
  

</head>
<body class="<?php echo($bodyclass); ?>">
  

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/nav.php"); ?>

<div class="container">
    <div class="row">
            
        <div class="col s12" style="margin-top:20px;">
				
              <h1 class="glow center hide-on-med-and-down"><?php echo($lexicon[34][$lang_set]); //MyPrescriptionTrails ?></h1>
              <h2 class="glow center hide-on-large-only hide-on-small-and-down"><?php echo($lexicon[34][$lang_set]); //MyPrescriptionTrails ?></h2>
              <h4 class="glow center hide-on-med-and-up"><?php echo($lexicon[34][$lang_set]); //MyPrescriptionTrails ?></h4>
                
        </div>
    
    </div>

    <div class="row">
            
        <div class="col s12 m4 l3" style="margin-top:10px;">

            <div class="card-panel white center-align">
            	<h2><?php echo(thousandsCurrencyFormat($sumArray['steps'])); ?></h2>
                <h5>Steps</h5>
            </div>
                
        </div>

        <div class="col s12 m4 l3 hide-on-small-and-down" style="margin-top:10px;">

            <div class="card-panel white center-align">
            	<h2><?php echo(number_format($sumArray['distance'])); ?></h2>
                <h5>Miles</h5>
            </div>
                
        </div>

        <div class="col l3 hide-on-med-and-down" style="margin-top:10px;">

            <div class="card-panel white center-align">
            	<h2><?php echo($ActCount); ?></h2>
                <h5>Walks</h5>
            </div>
                
        </div>

        <div class="col s12 m4 l3 hide-on-small-and-down" style="margin-top:10px;">

            <div class="card-panel white center-align" style="min-height:178px;">

                <div class="preloader-wrapper big active" id="loadingFavCount">
                  <div class="spinner-layer spinner-blue">
                    <div class="circle-clipper left">
                      <div class="circle"></div>
                    </div><div class="gap-patch">
                      <div class="circle"></div>
                    </div><div class="circle-clipper right">
                      <div class="circle"></div>
                    </div>
                  </div>
            
                  <div class="spinner-layer spinner-red">
                    <div class="circle-clipper left">
                      <div class="circle"></div>
                    </div><div class="gap-patch">
                      <div class="circle"></div>
                    </div><div class="circle-clipper right">
                      <div class="circle"></div>
                    </div>
                  </div>
            
                  <div class="spinner-layer spinner-yellow">
                    <div class="circle-clipper left">
                      <div class="circle"></div>
                    </div><div class="gap-patch">
                      <div class="circle"></div>
                    </div><div class="circle-clipper right">
                      <div class="circle"></div>
                    </div>
                  </div>
            
                  <div class="spinner-layer spinner-green">
                    <div class="circle-clipper left">
                      <div class="circle"></div>
                    </div><div class="gap-patch">
                      <div class="circle"></div>
                    </div><div class="circle-clipper right">
                      <div class="circle"></div>
                    </div>
                  </div>
                </div>

                <h5>Favorites</h5>
            </div>
                
        </div>
    
    </div>

    <div class="row" style="margin-top:-15px;">

        <div class="col m6 s12" style="margin-top:10px"><a class="waves-effect waves-dark btn herobtn white black-text" href="<?php echo($baseurl); ?>dashboard/activities/new/"><i class="fa fa-pencil-square-o left"></i>Log a Walk</a></div>
        <div class="col m6 s12" style="margin-top:10px"><a class="waves-effect waves-dark btn herobtn white black-text" href="<?php echo($baseurl); ?>filter/"><i class="material-icons left">search</i>Find Trails</a></div>

	</div>

    <div class="row" style="margin-top:-8px;">
        
        <div class="col m6 s12" style="margin-top:10px">
            <div class="card-panel white">
                <?php if(count($report) < 1) { ?>
                	<p class="flow-text">It looks like you haven't logged any trails yet! When you do, the last few will appear here. Trying <a href="<?php echo($baseurl); ?>filter/">searching for a trail</a> to walk. :)</p>
                <?php } else { ?>  
                	<h5 class="center"><?php echo(properize($_SESSION['fname'])); ?> last few walks</h5>      
                  <table class="highlight" style="width:100%" width="100%">
                    <thead>
                      <tr>
                          <th data-field="date">Date</th>
                          <th data-field="trail">Trail</th>
                          <th data-field="steps">Steps</th>
                      </tr>
                    </thead>
                    <tbody>
            <?php
				$report = array_slice($report, 0, 8);
                foreach($report as $id => $log) {
                    if($log['type'] == "trail") {
                        $trail_text = '<a href="'.$baseurl.'trail/?id='.$log['trail_id'].'">'.urldecode($log['trail_name']).'</a>';
                    } else {
						$trail_text = 'Custom';
                    }
            ?>
            
                      <tr>
                        <td><?php echo($log['date']); ?></td>
                        <td><?php echo($trail_text); ?></td>
                        <td><?php echo($log['steps']); ?></td>
                      </tr>
            
            <?php } ?>                
                    </tbody>
                  </table>
          <?php } ?>
          	</div>
			<a class="waves-effect waves-dark btn herobtn white black-text" href="<?php echo($baseurl); ?>dashboard/activities/"><i class="fa fa-list-ol left"></i>View Walking Log</a>            
        </div>

        <div class="col m6 s12" style="margin-top:10px">
            <div id="replace">
            </div>
        
            <div class="card-panel white center-align" id="placeholderDiv">
              <p class="black-text" style="margin-bottom:5px;"><img width="50" src="favorites/load.gif"></p>
              <p class="black-text flow-text" style="margin-top:5px;">We're loading your favorites!</p>
            </div>
			<a class="waves-effect waves-dark btn herobtn white black-text" href="<?php echo($baseurl); ?>dashboard/favorites/"><i class="fa fa-star left"></i>View All Favorites</a>            

        </div>


	</div>


</div>
    
    
  <div id="logActivity" class="modal">
  	<div id="replace"><div class="modal-content">
            <div class="card-panel white center-align">
              <p class="black-text" style="margin-bottom:5px;"><img width="50" src="favorites/load.gif"></p>
              <p class="black-text flow-text" style="margin-top:5px;">One moment please! =]</p>
            </div>
    </div></div>
  </div>     

      
<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/drawer.php"); ?>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/js_base.php"); ?>
<script src="<?php echo($baseurl); ?>dashboard/favorites/js.php"></script>
<script>
var favoritesObj = JSON.parse("<?php echo(json_encode(array_values($_SESSION['data']['fav']))); ?>");
var favorites = $.map(favoritesObj, function(el) { return el });

function prepareHTML(NextLoadArray) {
	var NextContent = '<div class="card-panel white"><h5 class="center" style="margin-bottom:26px;">A few of <?php echo(properize($_SESSION['fname'])); ?> favorites</h5> <ul class="collection" style="margin-top:10px; display:none;" id="trails">';
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

<?php if($userActive) { ?>		
		var favText = '<a href="#" id="fav'+value["id"]+'" onClick="fav(event, '+value["id"]+');" class="secondary-content ';
		if(($.inArray( value['id'], favorites )) > -1) {
			favText += 'yellow-text text-darken-1';
		} else {
			favText += 'white-text';	
		}
		favText += '"><i class="fa fa-star"></i></a>';
<?php } else { ?>
	var favText = "";
<?php } ?>		
		
	  NextContent += '<li class="collection-item avatar"><img src="' + value.thumbURL + '" alt="" class="circle"><span class="title"><a <?php if($pretty_urls) { ?>href="' + value.url + '"<?php } else { ?>href="<?php echo($baseurl) ?>trail/?id=' + value.id + '"<?php } ?>>' + value.name + '</a></span>';
	  NextContent += '<p>' + value.city + ', ' + value.zip + '<br><a href="#" onClick="openLog(event,'+value.id+');">Log a walk at this trail</a></p>';
	  NextContent += favText + '</li>';

	});
	
	NextContent += '</ul></div>';
	return NextContent;	
}
var trails;
$(document).ready(function(e) {
    $.get( "favorites/getAll.php?count=show", function(data) {
		var count = data.count;
		var trails = data.trails;
		$("#loadingFavCount").replaceWith('<h2>'+count+'</h2>');
		if(count == 0) {
		  var html = '<div class="card-panel white"><p class="flow-text center">It looks like you don\'t have any favorite trails yet! Trying <a href="<?php echo($baseurl); ?>filter/">searching for trails</a> to favorite. :)</p></div>';
		} else {
		  var html = prepareHTML(trails); 
		}
		  $("#replace").replaceWith(html);
		  $("#filterFav").fadeIn(500);
		  $("#trails").delay(500).fadeIn(500);
		  setTimeout(function(){ $("#placeholderDiv").hide(); }, 500);
		  $(".fa").delay(800).fadeIn();	
	},"json")
  .fail(function() {
    Materialize.toast( "Error: No internet connection", 10000 );
	setTimeout(function(){ window.location = "<?php echo($baseurl); ?>dashboard/"; }, 10010);
  })
});

function fav(e, id) {
	e.preventDefault();
	if(($.inArray( id, favorites )) > -1) {
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
							favorites.push(id);
							$("#fav"+id).removeClass("grey-text").addClass("yellow-text").addClass("text-darken-1");
						} else {
							favorites = jQuery.grep(favorites, function(value) {
							  return value != id;
							});
							$("#fav"+id).addClass("grey-text").removeClass("yellow-text").removeClass("text-darken-1");
						}					
				} else {
					Materialize.toast('Error: '+data.message, 5000);
				}
            })
		  .fail(function(xhr, textStatus, errorThrown) {
				Materialize.toast('Error: '+xhr.responseText, 10000);
			});
}
function openLog(e, tid) {
	e.preventDefault();
	$('#logActivity').openModal();
    $.get( "favorites/modal.php?id="+tid, function(data) {	  
	  setTimeout(function(){ $("#replace").replaceWith(data); $('select').material_select(); $('input').addClass("active"); }, 500);
	})
  .fail(function() {
    Materialize.toast( "Error: No internet connection", 10000 );
	setTimeout(function(){ window.location = "<?php echo($baseurl); ?>dashboard/favorites/"; }, 10010);
  })
}

</script>

  </body>
</html>
