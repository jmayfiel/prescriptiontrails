<?php require("../../admin/db.php"); 
require("/nfs/users/clind/public_html/prescriptiontrails.org/src/secure.php"); 
$special = "breadcrumb";
$breadcrumb = '<a href="'.$baseurl.'dashboard/" class="green-text text-darken-3"><i class="fa fa-home"></i></a>&nbsp;&nbsp;<i class="fa fa-chevron-right grey-text text-darken-1" style="padding-top:1px;"></i>&nbsp;&nbsp;<a href="'.$baseurl.'dashboard/favorites/" class="green-text text-darken-3">Favorites</a>';
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

<div class="container" style="min-height:70vh">

	<div class="row" style="margin-top:30px; margin-bottom:10px;" id="title">
    	<div class="col s12 hide-on-small-and-down"><h1 class="glow center">Your Favorite Trails</h1></div>
    	<div class="col s12 hide-on-med-and-up"><h2 class="glow center">Your Favorites</h2></div>
    </div>
    
    <div class="row" style="display:none; margin-bottom:20px;" id="filterFav">
    
    </div>
    
    <div class="row" id="replace">
    </div>

	<div class="row" style="margin-top:10vh; margin-bottom:20vh" id="placeholderDiv">
    	<div class="col s12 m8 offset-m2 l6 offset-l3">
            <div class="card-panel white center-align">
              <p class="black-text" style="margin-bottom:5px;"><img width="50" src="load.gif"></p>
              <p class="black-text flow-text" style="margin-top:5px;">We're loading your favorites!</p>
            </div>
        </div>
    </div>

</div>
     
  <div id="logActivity" class="modal">
  	<div id="replace"><div class="modal-content">
            <div class="card-panel white center-align">
              <p class="black-text" style="margin-bottom:5px;"><img width="50" src="load.gif"></p>
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
	var NextContent = '<div class="row" style="margin-top:0px; display:none;" id="trails">';
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
	  NextContent += '<div class="card-content"><span class="card-title activator grey-text text-darken-4 truncate">' + value.name + '</span><p><a <?php if($pretty_urls) { ?>href="' + value.url + '"<?php } else { ?>href="<?php echo($baseurl) ?>trail/?id=' + value.id + '"<?php } ?>><?php echo($lexicon[31][$lang_set]); //Learn more ?>!</a><a class="right" href="#" onClick="openLog(event,'+value.id+');">Log trail</a></p></div>';
	  NextContent += '<div class="card-reveal"><span class="card-title grey-text text-darken-4">' + value.name + '<i class="material-icons right">close</i></span><p>' + value.city + ', ' + value.zip + '</p><p>' + distance + ' miles for a total of ' + steps + ' steps.</p><ul>';
	  NextContent += '<li>Hours: ' + value.hours + '</li><li>Nearby intersection: ' + value.crossstreets + '</li></ul><p><a <?php if($pretty_urls) { ?>href="' + value.url + '"<?php } else { ?>href="<?php echo($baseurl) ?>trail/?id=' + value.id + '"<?php } ?>><?php echo($lexicon[31][$lang_set]); //Learn more ?>!</a></p></div></div></div>';

	});
	
	NextContent += '</div>';
	return NextContent;	
}
var trails;
$(document).ready(function(e) {
    $.get( "getAll.php", function(data) {
		var count = data.count;
		var trails = data.trails;
		if(count == 0) {
		  var html = '<div class="card-panel white center"><h1><i class="fa fa-frown-o"></i></h1><h3>There\'s nothing here!</h3><p class="flow-text center">It looks like you don\'t have any favorite trails yet! Trying <a href="<?php echo($baseurl); ?>filter/">searching for trails</a> to favorite.</p></div>';
		} else {
		  var html = prepareHTML(trails); 
		}
	  $("#replace").replaceWith(html);
	  $("#filterFav").fadeIn(500);
	  $("#trails").delay(500).fadeIn(500);
	  setTimeout(function(){ $("#placeholderDiv").hide(); }, 200);
	  $(".fa").delay(800).fadeIn();	
	},"json")
  .fail(function() {
    Materialize.toast( "Error: No internet connection", 10000 );
	setTimeout(function(){ window.location = "<?php echo($baseurl); ?>dashboard/favorites/"; }, 10010);
  })
});

function openLog(e, tid) {
	e.preventDefault();
	$('#logActivity').openModal();
    $.get( "modal.php?id="+tid, function(data) {	  
	  setTimeout(function(){ $("#replace").replaceWith(data); $('select').material_select(); $('input').addClass("active"); }, 500);
	})
  .fail(function() {
    Materialize.toast( "Error: No internet connection", 10000 );
	setTimeout(function(){ window.location = "<?php echo($baseurl); ?>dashboard/favorites/"; }, 10010);
  })
}

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

</script>

  </body>
</html>
