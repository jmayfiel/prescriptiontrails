<?php 
require("../admin/db.php"); 
$page_type = "filter";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Prescription Trails</title>

<?php require("../src/style_base.php"); ?>

</head>
<body class="<?php echo($bodyclass); ?>">
  

<?php
if(!isset($_GET['by'])) {
	$page_type = "search"; require("../src/nav.php"); require("search.php"); //include search if filter missing
} else {

if($_GET['by'] == "city" || $_GET['by'] == "zip" || $_GET['by'] == "grade" || $_GET['by'] == "name" || $_GET['by'] == "coord") {
	 if($_GET['by'] == "city" || $_GET['by'] == "zip" || $_GET['by'] == "grade" || $_GET['by'] == "coord" || $_GET['by'] == "name") {
		$filtertext = "Trails ";
			if($_GET['by'] == "city") {
				$filterby = "city";
				$search = $_GET['city'];
				if(in_array($_GET['city'], $cities)) {
					if($_GET['city'] == "Chaves County" || $_GET['city'] == "Lincoln County" || $_GET['city'] == "Grant County" || $_GET['city'] == "Otero County") {
						$filtertext .= "in ".$_GET['city'];
						$filtertextsm = $_GET['city'];
					} else {
						$filtertext .= "in the city of ".$_GET['city'];
						$filtertextsm = "City of ".$_GET['city'];
					}
					$filterObj = new trails;
					$filterResult = $filterObj->filterByLocation("city",$_GET['city'],0,18,"Array"); 
					$term = $_GET['city'];
					$filterCount = $filterResult['countReturned'];
					$totalMatched = $filterResult['totalMatched'];
					$trails = $filterResult['trails'];
				} else {
					$error = "city";
					$page_type = "error";
					require("../src/nav.php");
					require("error.php");
					require("../src/drawer.php");
					require("../src/js_base.php");
					exit();
				}
			}
			if($_GET['by'] == "zip") {
					$filtertext .= "in ".$_GET['zip'];
					$filtertextsm = "Trails in ".$_GET['zip'];
					$term = $_GET['zip'];
					$filterObj = new trails;
					$filterResult = $filterObj->filterByLocation("zip",$_GET['zip'],0,18,"Array"); 
					$filterCount = $filterResult['countReturned'];
					$totalMatched = $filterResult['totalMatched'];
					$trails = $filterResult['trails'];
			}
			if($_GET['by'] == "coord") {
					$filtertext = $lexicon[45][$lang_set]; //Trails near me
					$filtertextsm = $filtertext;
					if(!is_numeric($_GET['lat']) || !is_numeric($_GET['lat'])) {
						$error = "coord";
						$page_type = "error";
						require("../src/nav.php");
						require("error.php");
						echo("</div>");
						require("../src/drawer.php");
						require("../src/js_base.php");
						exit();
					}
					$coords = array("lat" => $_GET['lat'], "lng" => $_GET['lng']);
					$filterObj = new trails;
					$filterResult = $filterObj->filterByLocation("coord",$coords,0,24,"Array"); 
					$filterCount = $filterResult['countReturned'];
					$totalMatched = $filterResult['totalMatched'];
					$trails = $filterResult['trails'];
			}
			if($_GET['by'] == "grade") {
					$filtertext = "Grade ";
					if($_GET['grade'] == 4) { $filtertext .= "3++"; } else { $filtertext .= $_GET['grade']; };
					$term = $_GET['grade'];
					$filtertext .= " Trails";
					$filtertextsm = $filtertext;
					$filterObj = new trails;
					$filterResult = $filterObj->filterByLocation("grade",$_GET['grade'],0,18,"Array"); 
					$filterCount = $filterResult['countReturned'];
					$totalMatched = $filterResult['totalMatched'];
					$trails = $filterResult['trails'];
			}
			if($_GET['by'] == "name") {
					$term = urldecode(filter_input(INPUT_GET, 'name', FILTER_SANITIZE_STRING));
					$filtertext = "'".htmlspecialchars($term, ENT_COMPAT, 'UTF-8')."'";
					$filtertextsm = $filtertext;
					$filterObj = new trails;
					$filterResult = $filterObj->filterByTerm($term,0,18,"Array"); 
					$filterCount = $filterResult['countReturned'];
					$totalMatched = $filterResult['totalMatched'];
					$trails = $filterResult['trails'];
			}
	 }

require("../src/nav.php");
?>
	<ul class="row collapsible white z-depth-2" style="margin-top:-50px; padding-top:0px; padding-bottom:30px;">
       <li>   
          <div class="collapsible-header" id="filterheader" style="margin-top:5px;"><div class="container"><div class="row" style="margin-bottom:0px;"><div class="col s12" style="text-align:center; margin-top:-4px;">&#x25BC;&nbsp;&nbsp;Filtering Options</div></div></div></div>
          <div class="collapsible-body"><div class="container"><div class="row" style="margin-bottom:0px;margin-top:5px;">
              <div class="input-field col s12 m4">
                <select id="filterCity">
                <option value="" disabled selected>Choose city</option>
<?php foreach($cities as $id => $name) { ?>
                  <option value="<?php echo($name); ?>"><?php echo($name); ?></option>
<?php } ?>
                </select>
                <label>City</label>
              </div>
              <div class="input-field col s9 m3">
                  <input id="zipSearch" type="text" class="validate">
                  <label for="zip">Zip Code</label>
              </div>
              <div class="col m3 hide-on-small-and-down">
              	<a class="pink darken-3 waves-effect waves-light btn right modal-trigger" href="#searchName" style="margin-top:20px; margin-left:15px;margin-right:-15px;">Search name</a>
              </div>
              <div class="col m2 hide-on-small-and-down">
              	<a href="#!" onClick="getLocation(event, true);" class="pink darken-3 waves-effect waves-light btn tooltipped" style="margin-top:20px; margin-right:-15px;" data-position="bottom" data-delay="50" data-tooltip="Use currrent location"><i class="fa fa-location-arrow"></i></a>
              </div>
          </div></div></div>
	   </li>
	</ul>
    <?php if($_GET['by'] != "name") { ?>
	<div class="row z-depth-2" style="margin-top:-50px; padding-top:1px; padding-bottom:30px; background-color:#225C8E;">
        
        <div class="container">

			<h2 class="white-text glow hide-on-small-only center-align" style="font-weight:300; margin-bottom:0px;"><i class="fa fa-search"></i> <?php echo($filtertext); ?></h2>
			<h4 class="white-text hide-on-med-and-up" style="font-weight:300; margin-top:25px; margin-bottom:-10px;"><i class="fa fa-search"></i> <?php echo($filtertextsm); ?></h4>

		</div>

	</div>
    <?php } else { ?>
      <nav class="z-depth-2" style="margin-top:-50px; padding-top:1px; padding-bottom:30px; background-color:#225C8E;">
        <div class="nav-wrapper container">
            <div class="row">
              <form class="col s12 m8 offset-m2 l6 offset-l3" method="get" action="<?php echo($baseurl); ?>filter/">
                <div class="input-field">
                  <input type="hidden" name="by" value="name">
                  <input class="center-align" id="name" name="name" type="search" value="<?php echo(htmlspecialchars($_GET['name'], ENT_COMPAT, 'UTF-8')); ?>" required>
                  <label for="name"><i class="material-icons">search</i></label>
                  <i class="material-icons">close</i>
                </div>
              </form>
           </div>
        </div>
      </nav>    
    <?php } ?>

    <div class="container" style="margin-top:20px;">
        
		<div class="row" id="target" style="margin-bottom:0px;">

<?php
$result = 0;
	foreach($trails as $id => $trail) {
		$result++;
		if($trail[$filterby] == $search) {
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

          <div class="col m4 s12 trailElement <?php if($filterCount == 1) { ?>offset-m4<?php } elseif($filterCount == 2 && $result == 1) { ?>offset-m2<?php } ?>" data-id="<?php echo($trail['id']); ?>" data-grade="<?php echo($trail['difficulty']); ?>" data-city="<?php echo($trail['city']); ?>" data-name="<?php echo($trail['name']); ?>">
          
              <div class="card">
              
                <div class="card-image waves-effect waves-block waves-light">
                  <img class="activator" src="<?php echo($trail['thumbURL']); ?>">
                  <?php if($userActive) { ?><a href="#" id="fav<?php echo($trail['id']); ?>" onClick="fav(event, <?php echo($trail['id']); ?>);" class="right favIcon flow-text <?php if(in_array($trail['id'],array_values($_SESSION['data']['fav']))) { ?>yellow-text text-darken-1<?php } else { ?>white-text<?php } ?>"><i class="fa fa-star fa-2x"></i></a><?php } ?>
                </div>
                
                <div class="card-content">
                  <span class="card-title activator grey-text text-darken-4 truncate"><?php echo($trail['name']); ?></span>
                <?php if($_GET['by'] != "coord") { ?>
                          <div class="chip" style="float:right; margin-right:-8px;">
                          	<a class="chiplink" href="<?php echo($baseurl); ?>filter/?by=grade&grade=<?php echo($trail['difficulty']); ?>">
                                <img src="<?php echo($baseurl); ?>img/<?php echo($trail['difficulty']); ?>.png" alt="Grade <?php if($trail['difficulty'] == 4) { echo("3++"); } else { echo($trail['difficulty']); } ?>">
                                Grade <?php if($trail['difficulty'] == 4) { echo("3++"); } else { echo($trail['difficulty']); } ?>
                            </a>
                          </div>				
                  <?php } ?>          
                  <p><a href="<?php if($pretty_urls) { echo($trail['url']); } else { echo($baseurl."trail/?id=".$trail['id']); } ?>"><?php echo($lexicon[31][$lang_set]); //Learn more ?>!</a><?php if($_GET['by'] == "coord") { ?><span class="right"><i class="fa fa-map-marker"></i> <?php echo(round($trail['distance'],2)); ?> mi</span><?php } ?>
				  </p>
                </div>
                
                <div class="card-reveal">
                  <span class="card-title grey-text text-darken-4"><?php echo($trail['name']); ?><i class="material-icons right">close</i></span>
                  <?php if($_GET['by'] == "coord") { ?><p><?php echo(round($trail['distance'],2)); ?> miles from current location.</p><?php } ?>
                    <p>Grade <?php if($trail['difficulty'] == 4) { echo("3++"); } else { echo($trail['difficulty']); } ?> trail - <?php echo($distance); ?> miles or <?php echo($steps); ?> steps.</p>
                  <ul>
                    <li>Hours: <?php echo($trail['hours']); ?></li>
                    <li>Location: <?php echo($trail['city']); ?>, <?php echo($trail['zip']); ?></li>
                  </ul>
                  <p><a href="<?php if($pretty_urls) { echo($trail['url']); } else { echo($baseurl."trail/?id=".$trail['id']); } ?>"><?php echo($lexicon[31][$lang_set]); //Learn more ?>!</a></p>
                </div>
                
              </div>
              
		</div>
<?php
		}
	}
?>
</div>
  <!-- name search -->
  <div id="searchName" class="modal">
  <form id="namesearchform" action="<?php echo($baseurl."filter/"); ?>" method="get">
    <div class="modal-content">
      <h4>Search by name</h4>
        <div class="row">
        	<div class="col s12 input-field">
			<i class="material-icons prefix">search</i>
              <input type="hidden" value="name" name="by">
              <input id="name" name="name" type="text" class="validate">
              <label for="name">Search term</label>
            </div>
        </div>
    <div class="modal-footer">
      <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Close</a>
      <button class="btn waves-effect waves-green btn-flat" type="submit" name="action">Search</button>
    </div>
  </div>  
  </form>
  </div>

<div class="row" id="doneDiv" style="margin-top:20px;">
	<div class="col s12 m6 offset-m3 center-align card">
    
    	<div class="row" style="margin-top:15px; margin-bottom:5px;">
        	<div class="col s4 offset-s4 center-align">
            	<h1 class="glow" style="margin-top: 10px; margin-bottom: 5px;"><i class="fa fa-info"></i></h1>
            </div>
        </div>
        <div class="card-content" style="padding-top:0px;">
                <p class="flow-text">That's all the trails we could find for this search!</p>
                <p style="margin-top:10px;"><a href="<?php echo($baseurl); ?>filter/" class="pink darken-3 waves-effect waves-light btn">New Search</a></p>
    	</div>
	</div>
</div>

  <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
    <a class="btn-floating btn-large red">
      <i class="large material-icons">sort_by_alpha</i>
    </a>
    <ul>
      <li><a class="btn-floating red tooltipped" data-position="left" data-delay="40" data-tooltip="Sort by name" onclick="sortTrails(event, 'name', 'asc');"><i class="fa fa-sort-alpha-asc"></i></a></li>
      <li><a class="btn-floating yellow darken-1 tooltipped" data-position="left" data-delay="40" data-tooltip="Sort by name" onclick="sortTrails(event, 'name', 'desc');"><i class="fa fa-sort-alpha-desc"></i></a></li>
      <li><a class="btn-floating green tooltipped" data-position="left" data-delay="40" data-tooltip="Sort by grade" onclick="sortTrails(event, 'grade', 'asc');"><i class="fa fa-sort-numeric-asc"></i></a></li>
      <li><a class="btn-floating blue tooltipped" data-position="left" data-delay="40" data-tooltip="Sort by grade" onclick="sortTrails(event, 'grade', 'desc');"><i class="fa fa-sort-numeric-desc"></i></a></li>
    </ul>
  </div>


<?php	
if($filterCount < 18 && $_GET['by'] != "coord") {
	//no load
} else {
?>
        <div class="row" id="moreBtns">
        	<div class="col m6 s12">
            	<a id="loadMore" href="#" class="btn-large white waves-effect center-align black-text" style="width:100%;"><i class="fa fa-gear left"></i>Load more trails</a>
            </div>
        	<div class="col m6 s12">
            	<a href="#" onClick="getLocation(event);" class="btn-large white waves-effect center-align black-text" style="width:100%;"><i class="fa fa-map-marker left"></i>Find trails near you</a>
            </div>
        </div> 
<?php } ?>

		</div>
<?php } else { $page_type = "error"; $error = "by"; require("../src/nav.php"); require("error.php"); } } ?>
      
      </div>


<?php require("../src/drawer.php"); ?>

<?php require("../src/js_base.php"); 

if($totalMatched > 18 && $_GET['by'] != "coord") {
?>
<script>
$(document).ready(function(e) {
    $("#doneDiv").hide();
});
var offset = 18;
var total = <?php echo($totalMatched); ?>;
var count = total - offset;
var target = "target";
$("#loadMore").click(function(e) {
    e.preventDefault();
	var url = "<?php echo($baseurl); ?>api/filter/?by=<?php echo($_GET['by']); ?>&<?php echo($_GET['by']); ?>=<?php echo($term); ?>&offset="+offset+"&count="+count;
		$.get( url, function(data) {
		  var returnedCount = data.countReturned;
		  var totalMatched = data.totalMatched;
		  var html = prepareHTML(data.trails);  
		  $(html).insertAfter("#"+target);
		  $(".fa").delay(400).fadeIn();	
		  var atCount = returnedCount + offset;
		  if(atCount >= totalMatched) {
			  $("#moreBtns").hide();
			  $("#doneDiv").show();
		  }
		  target = "offset" + offset;
		  offset = offset + 9;
		  ga('send', 'event', "search", "loadMore", '<?php echo($_GET['by']); ?>-<?php echo(htmlentities($term)); ?>');
		  console.log(lastsort);
		  if(lastsort != "none") {
			  sortTrails("none", lastsort, lastorder);
		  }
		},"json")
	  .fail(function() {
		Materialize.toast( "Error: No internet connection", 10000 );
	  });
});
</script>
<?php
}
?>
<script>
var lastsort = "none";
var lastorder = "none";
function sortTrails(e, by, order) {
	if(e != "none") {
		e.preventDefault();
	}
	var $sortTrails = $('.trailElement');
	
	$sortTrails.sort(function(a,b){
		var an = a.getAttribute('data-'+by),
			bn = b.getAttribute('data-'+by);
	
		if(order == "asc") {
			if(an > bn) {
				return 1;
			}
			if(an < bn) {
				return -1;
			}
			return 0;
		} else {
			if(an < bn) {
				return 1;
			}
			if(an > bn) {
				return -1;
			}
			return 0;
		}
	});
		lastsort = by;
		lastorder = order;
	$sortTrails.detach().appendTo("#target");

}

<?php if($userActive) { ?>
var favoritesObj = JSON.parse("<?php echo(json_encode(array_values($_SESSION['data']['fav']))); ?>");
var favorites = $.map(favoritesObj, function(el) { return el });
var userActive = true;
<?php } else { ?>
var userActive = false;
<?php } ?>
function prepareHTML(NextLoadArray) {
	var NextContent = '<div class="row" id="offset'+offset+'" style="margin-top:0px; margin-bottom:0px;">';
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
		var favText = '<a href="#" id="fav'+value["id"]+'" onClick="fav(event, '+value["id"]+');" class="right favIcon flow-text ';
		if(($.inArray( value['id'], favorites )) > -1) {
			favText += 'yellow-text text-darken-1';
		} else {
			favText += 'white-text';	
		}
		favText += '"><i class="fa fa-star fa-2x"></i></a>';
<?php } else { ?>
	var favText = "";
<?php } ?>		
		
	  if(value.difficulty == 4) { var diffText = "3++"; } else { var diffText = value.difficulty; }
		
	  var cardDiff = '<div class="chip" style="float:right; margin-right:-8px;">'+
                          	'<a class="chiplink" href="<?php echo($baseurl); ?>filter/?by=grade&grade=' + value.difficulty + '">'+
                                '<img src="<?php echo($baseurl); ?>img/' + value.difficulty + '.png" alt="Grade '+ diffText + '" />'+
                                'Grade '+ diffText + '</a>'+
                          '</div>';
		
	  NextContent += '<div class="col m4 s12 trailElement" data-id="' + value.id + '" data-grade="' + value.difficulty + '>" data-city="' + value.city + '" data-name="' + value.name + '"><div class="card hoverable"><div class="card-image waves-effect waves-block waves-light"><img class="activator" src="' + value.thumbURL + '">'+favText+'</div>';
	  NextContent += '<div class="card-content"><span class="card-title activator grey-text text-darken-4 truncate">' + value.name + '</span>'+ cardDiff +'<p><a <?php if($pretty_urls) { ?>href="' + value.url + '"<?php } else { ?>href="<?php echo($baseurl) ?>trail/?id=' + value.id + '"<?php } ?>><?php echo($lexicon[31][$lang_set]); //Learn more ?>!</a>'+favText+'</p></div>';
	  NextContent += '<div class="card-reveal"><span class="card-title grey-text text-darken-4">' + value.name + '<i class="material-icons right">close</i></span><p>' + value.city + ', ' + value.zip + '</p><p>Grade ' + diffText + ' trail - ' + distance + ' miles or ' + steps + ' steps.</p><ul>';
	  NextContent += '<li>Hours: ' + value.hours + '</li><li>Nearby intersection: ' + value.crossstreets + '</li></ul><p><a <?php if($pretty_urls) { ?>href="' + value.url + '"<?php } else { ?>href="<?php echo($baseurl) ?>trail/?id=' + value.id + '"<?php } ?>><?php echo($lexicon[31][$lang_set]); //Learn more ?>!</a></p></div></div></div>';

	});
	
	NextContent += '</div>';
	return NextContent;	
}
<?php if($userActive) { ?>
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
<?php } ?>
$("#filterCity").change(function() {
	var city = $(this).val();
	document.location = "<?php echo($baseurl); ?>filter/?by=city&city=" + city;
});
$("#zipSearch").keyup(function() {
	var zip = $(this).val();
	if(zip.length == 5) {
		document.location = "<?php echo($baseurl); ?>filter/?by=zip&zip=" + zip;
	}
});
</script>
  </body>
</html>
