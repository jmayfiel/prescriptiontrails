<?php 
require("admin/db.php");

function shuffle_assoc($list) { 
  if (!is_array($list)) return $list; 

  $keys = array_keys($list); 
  shuffle($keys); 
  $random = array(); 
  foreach ($keys as $key) 
    $random[$key] = $list[$key]; 

  return $random; 
} 

$randomtrailObj = new trails;
$randomtrails = $randomtrailObj->getRand(); 

$count = $randomtrails['totalMatched'];
$trails = $randomtrails['trails'];

$trails = shuffle_assoc($trails);
$ids = array_keys($trails);

$trails_master = $trails;
$trails = array_slice($trails_master, 0, 12);

$trails_next = array_slice($trails_master, 12, 6);

$trails_last = array_slice($trails_master, 18, 6);

ob_start();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Prescription Trails - New Mexico</title>
    <meta name="description" content="The New Mexico Prescription Trails web site will help you find some of the best park and trail walking and wheelchair rolling paths in the state!" />
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="image" content="<?php echo($trail['thumbURL']); ?>">
    <link rel="canonical" href="<?php echo($baseurl); ?>" />
    
    <!-- Open Graph data -->
    <meta property="og:title" content="Prescription Trails - New Mexico" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo($baseurl); ?>" />
    <meta property="og:image" content="<?php echo($baseurl); ?>img/logo-big-old.jpg" />
    <meta property="og:description" content="<?php echo($metaDesc); ?>" />
    <meta property="og:site_name" content="The New Mexico Prescription Trails web site will help you find some of the best park and trail walking and wheelchair rolling paths in the state!" />
    <meta property="fb:admins" content="1279607446, 100001120322907" />
    
    <link rel="prefetch" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.0.1/jquery.rateyo.min.js" />
    <link rel="prefetch" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.0.1/jquery.rateyo.min.css" />
<?php foreach($trails_next as $id => $trail) { //prefetch the next few random trail images ?>
    <link rel="prefetch" href="<?php echo($trail['thumbURL']); ?>" />
<?php } ?>
<?php foreach($trails_last as $id => $trail) { ?>
    <link rel="prefetch" href="<?php echo($trail['thumbURL']); ?>" />
<?php } ?>

  <!-- CSS  -->
<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/style_base.php"); ?>
  

</head>
<body class="<?php echo($bodyclass); ?>">
  

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/nav.php"); ?>

      <div class="container" style="margin-top:20px;">
        <div class="row">
            <div class="col m4 s12" style="margin-top:10px"><a class="waves-effect waves-dark btn herobtn white black-text" href="<?php echo($baseurl); ?>filter/"><i class="material-icons left hide-on-med-only">search</i>Find Trails</a></div>
            <?php if(!$userActive) { ?>	
            <div class="col m4 s12" style="margin-top:10px"><a href="<?php echo($baseurl); ?>user/new/account/" class="modal-trigger waves-effect waves-dark btn herobtn white black-text"><i class="material-icons left hide-on-med-only">account_circle</i>Create account</a></div>
            <?php } else { ?>
            <div class="col m4 s12" style="margin-top:10px"><a class="waves-effect waves-dark btn herobtn white black-text <?php echo($user_class); ?>" href="<?php echo($user_url); ?>"><i class="material-icons left hide-on-med-only">account_circle</i>My Account</a></div>
            <?php } ?>
            <div class="col m4 s12" style="margin-top:10px"><a href="#" onClick="getLocation(event);" class="waves-effect waves-dark btn herobtn white black-text"><i class="fa fa-map-marker left hide-on-med-only"></i>Trails near you</a></div>
        </div>
        
		<div class="row">
        	<div class="col s12">
            	<div class="card white center-align">
                	<div class="row" style="padding-top:30px; margin-bottom:0px">
                    	<div class="col l4 offset-l4 m6 offset-m3 s8 offset-s2"><img src="<?php echo($baseurl); ?>img/logo-big-old.jpg" class="responsive-img" /></div>
                    </div>
                    <div class="card-content" style="margin-top:0px;">
                        <h1 style="font-weight:300; margin-top:5px;"><?php echo($lexicon[1][$lang_set]); //Get Up & Get Moving! ?></h1>
                        <p class="flow-text"><?php echo($lexicon[2][$lang_set]); //Intro text ?></p>
                    </div>
                </div>
            </div>
        </div>
	  </div>

      <div class="mapcontainer z-depth-1 hide-on-small-and-down" style="padding-top:10px; padding-bottom:10px; background-color:white;">
        <div id="map" style="width:100%; height:60vh; margin-bottom:10px; margin-top:10px; border-top-style: solid; border-top-width: 1px; border-bottom-style: solid; border-bottom-width: 2px;"></div>
        <p class="center-align" style="margin-bottom:8px;"><a class="pink darken-3 white-text waves-effect waves-light btn btn-sm" href="<?php echo($baseurl); ?>map/"><?php echo($lexicon[40][$lang_set]); //View Full Map ?></a></p>
      </div>
      
      <div class="container" id="main" style="margin-top:20px;">
		<div class="row" style="margin-bottom:0px;">

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

          <div class="col m4 s12">
          
              <div class="card hoverable" itemscope itemtype="http://schema.org/Place">
      			<meta itemprop="image" content="<?php echo($trail['largeImgURL']); ?>"></meta>
                	<span itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
                        <meta itemprop="latitude" content="<?php echo($trail['lat']); ?>"></meta>
                        <meta itemprop="longitude" content="<?php echo($trail['lng']); ?>"></meta>
                    </span>
                <div class="card-image waves-effect waves-block waves-light">
                  <img class="activator" src="<?php echo($trail['thumbURL']); ?>" alt="<?php echo($trail['name']); ?> Image">
                  <?php if($userActive) { ?><a href="#" id="fav<?php echo($trail['id']); ?>" onClick="fav(event, <?php echo($trail['id']); ?>);" class="right favIcon flow-text <?php if(in_array($trail['id'],array_values($_SESSION['data']['fav']))) { ?>yellow-text text-darken-1<?php } else { ?>white-text<?php } ?>"><i class="fa fa-star fa-2x"></i></a><?php } ?>
                </div>
                
                <div class="card-content">
                  <span class="card-title activator grey-text text-darken-4 truncate" itemprop="name"><?php echo($trail['name']); ?></span>
                  <p><a href="<?php if($pretty_urls) { echo($trail['url']); } else { echo($baseurl."trail/?id=".$trail['id']); } ?>"><?php echo($lexicon[31][$lang_set]); //Learn more ?>!</a></p>
                </div>
                
                <div class="card-reveal">
                  <span class="card-title grey-text text-darken-4"><?php echo($trail['name']); ?><i class="material-icons right">close</i></span>
                    <p itemprop="address" itemscope itemtype="http://schema.org/PostalAddress"><meta itemprop="streetAddress" content="<?php echo(htmlspecialchars($trail['address'])); ?>"></meta><span itemprop="addressLocality"><?php echo($trail['city']); ?></span>, <span itemprop="postalCode"><?php echo($trail['zip']); ?></span> <meta itemprop="addressRegion" content="NM"></meta></p>
                    <p><?php echo($distance); ?> miles for a total of <?php echo($steps); ?> steps.</p>
                  <ul>
                    <li><?php echo($lexicon[32][$lang_set]); //Hours ?>: <?php echo($trail['hours']); ?></li>
                    <li>Nearby intersection: <?php echo($trail['crossstreets']); ?></li>
                  </ul>
                  <p><a itemprop="url" href="<?php if($pretty_urls) { echo($trail['url']); } else { echo($baseurl."trail/?id=".$trail['id']); } ?>"><?php echo($lexicon[31][$lang_set]); //Learn more ?>!</a></p>
                </div>
                
              </div>
              
		</div>
<?php

	}
	
?>
            
      	</div>   
        <div id="two"></div>
        <div id="three"></div>
        <div class="row">
        	<div class="col m6 s12">
            	<a id="loadMore" href="#" class="btn-large white waves-effect center-align black-text" style="width:100%; margin-top:8px;"><i class="fa fa-gear left"></i>Load more trails</a>
            </div>
        	<div class="col m6 s12">
            	<a href="#" onClick="getLocation(event);" class="btn-large white waves-effect center-align black-text" style="width:100%; margin-top:8px;"><i class="fa fa-map-marker left"></i>Find trails near you</a>
            </div>
        </div> 
      </div>


<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/drawer.php"); 
$output = ob_get_contents();
ob_end_clean();

echo(minify_html($output));

?>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/js_base.php"); ?>

<script>
<?php if($userActive) { ?>
var favoritesObj = JSON.parse("<?php echo(json_encode(array_values($_SESSION['data']['fav']))); ?>");
<?php ob_start(); ?>
var favorites = $.map(favoritesObj, function(el) { return el });
var userActive = true;
<?php } else { ?>
var userActive = false;
<?php } ?>
var NextLoadArray = jQuery.parseJSON( '<?php echo(str_replace("'", "\'", json_encode($trails_next))); ?>' );
var LastLoadArray = jQuery.parseJSON( '<?php echo(str_replace("'", "\'", json_encode($trails_last))); ?>' );
$(document).ready(function(e) {
	
});

function prepareHTML(NextLoadArray) {
	var NextContent = '<div class="row" style="margin-top:0px;">';
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
		
	  NextContent += '<div class="col m4 s12"><div class="card hoverable"><div class="card-image waves-effect waves-block waves-light"><img class="activator" src="' + value.thumbURL + '">'+favText+'</div>';
	  NextContent += '<div class="card-content"><span class="card-title activator grey-text text-darken-4 truncate">' + value.name + '</span><p><a <?php if($pretty_urls) { ?>href="' + value.url + '"<?php } else { ?>href="<?php echo($baseurl) ?>trail/?id=' + value.id + '"<?php } ?>><?php echo($lexicon[31][$lang_set]); //Learn more ?>!</a></p></div>';
	  NextContent += '<div class="card-reveal"><span class="card-title grey-text text-darken-4">' + value.name + '<i class="material-icons right">close</i></span><p>' + value.city + ', ' + value.zip + '</p><p>' + distance + ' miles for a total of ' + steps + ' steps.</p><ul>';
	  NextContent += '<li>Hours: ' + value.hours + '</li><li>Nearby intersection: ' + value.crossstreets + '</li></ul><p><a <?php if($pretty_urls) { ?>href="' + value.url + '"<?php } else { ?>href="<?php echo($baseurl) ?>trail/?id=' + value.id + '"<?php } ?>><?php echo($lexicon[31][$lang_set]); //Learn more ?>!</a></p></div></div></div>';

	});
	
	NextContent += '</div>';
	return NextContent;	
}

$("#loadMore").click(function(e) {
    e.preventDefault();
	NextContent = prepareHTML(NextLoadArray);
	$("#two").replaceWith(NextContent);
	$("#loadMore").replaceWith('<a id="loadLast" onClick="loadLast(event);" href="#" class="btn-large white waves-effect center-align black-text" style="width:100%; margin-top:8px;"><i class="fa fa-gear left"></i>Load more trails</a>');
	$(".fa").delay(500).fadeIn();	
});

function loadLast(e) {
    e.preventDefault();
	NextContent = prepareHTML(LastLoadArray);
	$("#three").replaceWith(NextContent);
	$("#loadLast").replaceWith('<a id="EndSearch" href="<?php echo($baseurl); ?>filter/" class="btn-large white waves-effect center-align black-text" style="width:100%; margin-top:8px;"><i class="fa fa-search left"></i>Search</a>');
	$(".fa").delay(500).fadeIn();	
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
							$("#fav"+id).removeClass("white-text").addClass("yellow-text").addClass("text-darken-1");
						} else {
							favorites = jQuery.grep(favorites, function(value) {
							  return value != id;
							});
							$("#fav"+id).addClass("white-text").removeClass("yellow-text").removeClass("text-darken-1");
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
		$.getScript( "<?php echo($baseurl); ?>src/mapJS.js" )
		  .done(function( script, textStatus ) {
			console.log( textStatus );
		  })
		  .fail(function( jqxhr, settings, exception ) {
			Materialize.toast('Error: '+jqxhr.responseText, 10000);
		});	
}
<?php $output = ob_get_contents();
ob_end_clean();

echo(minify_js($output));
?>
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGtuuf2tqUJcX_-XulhmjJuksAigifezM&callback=initMap"
        async defer></script>
  </body>
</html>
