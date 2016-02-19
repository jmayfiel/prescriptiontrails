<?php 
require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php"); 
$adminPage = true;
require("/nfs/users/clind/public_html/prescriptiontrails.org/src/secure.php"); 

$page_type = "admin";
$nomatch = false;
$offset = $_GET['page'];
if(intval($offset) > 0) {
	$offset = ($offset - 1) * 10;	
} else {
	$offset = 0;	
}

if($_GET['by'] == "city" || $_GET['by'] == "zip") {
	 if($_GET['by'] == "city" || $_GET['by'] == "zip") {
		$filtertext = "Trails ";
			if($_GET['by'] == "city") {
				$query = "?by=city&city=".$_GET['city'];
				$filterby = "city";
				$search = $_GET['city'];
				if(in_array($_GET['city'], $cities)) {
					$filtertext .= "in ".$_GET['city'];
					$filterObj = new trails;
					$filterResult = $filterObj->filterByLocation("city",$_GET['city'],$offset,10,"Array","showUnpublished"); 
					$filterCount = $filterResult['countReturned'];
					$totalMatched = $filterResult['totalMatched'];
					$trails = $filterResult['trails'];
				} else {
					$error = "city";
					$page_type = "error";
					$nomatch = true;	
				}
			}
			if($_GET['by'] == "zip") {
				$query = "?by=zip&zip=".$_GET['zip'];
					$filtertext .= "in ".$_GET['zip'];
					$filterObj = new trails;
					$filterResult = $filterObj->filterByLocation("zip",$_GET['zip'],$offset,10,"Array","showUnpublished"); 
					$filterCount = $filterResult['countReturned'];
					$totalMatched = $filterResult['totalMatched'];
					$trails = $filterResult['trails'];
			}
	 }

if(10 > ($totalMatched - $offset)) {
	$through = $totalMatched;	
} else {
	$through = $offset + 10;	 
}
$start = $offset + 1;
$title = $filtertext . "<br>showing ". $start . " - " . $through . " of " .$totalMatched;
if($totalMatched == 0) {
	$nomatch = true;
	$error = "nomatch";	
}
$more = false;
if($totalMatched > $filterCount) {
	$more = true;
	$last = ceil($totalMatched / 10);
	$page = 1;
	if(!empty($_GET['page'])) {
		$page = $_GET['page'];
	}
}
} else {

$allTrailObj = new trails;
$allTrails = $allTrailObj->getAll(); 

$count = $allTrails['totalMatched'];
$trails = $allTrails['trails'];

$title = "All Trails - ".$count." Total";

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

<div class="container">
    <div class="row">
    
        <div class="col m3 s12">
              <div class="card white" style="margin-top:106px;">
                <div class="card-content black-text">
                  <span class="card-title black-text">Hi <?php echo($_SESSION['fname']); ?>!</span>
                  <p>You are now logged in to the Prescription Trails control panel.</p>
                  <p style="margin-top:15px;"><a class="btn herobtn blue darken-1 white-text waves-effect waves-light" href="<?php echo($baseurl); ?>admin/new/">New Trail</a></p>
                  <p style="margin-top:5px;"><a class="btn herobtn blue darken-1 white-text waves-effect waves-light" href="<?php echo($baseurl); ?>admin/report/">Reports</a></p>
                  <p style="margin-top:5px;"><a class="btn herobtn blue darken-1 white-text waves-effect waves-light" href="<?php echo($baseurl); ?>user/new/admin/">Add Admin</a></p>
                  <p style="margin-top:5px;"><a class="btn herobtn pink darken-3 white-text waves-effect waves-light" href="<?php echo($baseurl); ?>user/logout.php">Logout</a></p>
                </div>
              </div>
        </div>
        
        <div class="col m9 s12">
        	<h2 class="glow center-align"><?php echo($title); ?></h2>

              <div class="card white">
                <div class="card-content black-text">
                	<div class="row">
                      <div class="input-field col s12 m5">
                        <select id="adminFilterCity">
                        <option value="" disabled selected>Choose city</option>
        <?php foreach($cities as $id => $name) { ?>
                          <option value="<?php echo($name); ?>"><?php echo($name); ?></option>
        <?php } ?>
                        </select>
                        <label>City</label>
                      </div>
                      <form action="<?php echo($baseurl); ?>admin/" method="get">
                      <input type="hidden" name="by" value="zip" />
                      <div class="input-field col s9 m4">
                          <input id="zip" name="zip" type="text" class="validate">
                          <label for="zip">Zip Code</label>
                      </div>
                      <div class="col m3 hide-on-small-and-down">
                        <button type="submit" class="pink darken-3 waves-effect waves-light btn left" style="margin-top:20px;" value="Search">Search</button>
                      </div>
                      </form>
                   </div>
               </div>
           </div>

<?php if($nomatch) { ?>
      <div class="row" style="margin-top:2vh;">
        <div class="col s12 m10 offset-m1">
          <div class="card red accent-4">
            <div class="card-content white-text">
              <h1 class="white-text glow" style="font-weight:300; margin-top:10px; margin-bottom:20px;" class="glow">Error!</h1>

<?php if($error == "nomatch") { ?>
	<h4>We weren't able to find any trails that matched your search.</h4>
    <p class="flow-text">Please try again. :(</p>
<?php } elseif($error == "city") { ?>
	<h4>We weren't able to find the city of "<?php echo(htmlentities($_GET['city'])); ?>" in our system.</h4>
    <p class="flow-text">Please try your search again or try browsing our trails from the homepage.</p>
<?php } elseif($error == "by") { ?>
    <h4>Error 404: Filter not found</h4>
    <p class="flow-text">The page you requested does not exist. Please try your search again or try browsing our trails from the homepage. In the mean time, our team of highly trained technical kittens is working to find the page you were looking for.</p>
<?php } else { ?>
    <h4>Error 404: Page not found</h4>
    <p class="flow-text">The page you requested does not exist. Please try your search again or try browsing our trails from the homepage. In the mean time, our team of highly trained technical kittens is working to find the page you were looking for.</p>
<?php } ?>
            </div>
          </div>
        </div>
      </div>

<?php } else { ?>            
   <div class="row">    
   		<div class="col s12">     
              <ul class="collection">
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
				$published = ($trail['published'] == 'true');
?>
                <li class="collection-item avatar">
                  <div class="left">
                  <img src="<?php echo($trail['thumbURL']); ?>" alt="<?php echo($trail['name']); ?>" class="circle">
                  <span class="title"><strong><?php echo($trail['name']); ?></strong> - <?php echo($trail['city']); ?>, <?php echo($trail['zip']); ?></span>
                  	<p style="margin-top:5px;">
                     <a class="btn btn-small white waves-effect waves-dark black-text" href="<?php echo($baseurl."admin/new/?id=".$trail['id']); ?>&action=edit"><i class="fa fa-pencil"></i></a>
                     <a href="#" class='dropdown-button btn btn-small white waves-effect waves-dark black-text' data-activates='translatedropdown<?php echo($trail['id']); ?>'>Translate</a>
                     <a class="btn btn-small white waves-effect waves-dark black-text" href="<?php if($pretty_urls) { echo($trail['url']); } else { echo($baseurl."trail/?id=".$trail['id']); } ?>"><i class="fa fa-eye"></i></a>
                     <?php if($_SESSION['is_super'] == 1) { ?>
                     <a class="btn btn-small white waves-effect waves-dark black-text" href="#!" onClick="deleteTrail(event,<?php echo($trail['id']); ?>);"><i class="fa fa-trash"></i></a>
                     <?php } ?>
                      <ul id='translatedropdown<?php echo($trail['id']); ?>' class='dropdown-content'>
                        <li><a href="<?php echo($baseurl."admin/translate/?id=".$trail['id']); ?>&lang=es">Spanish</a></li>
                        <li><a href="<?php echo($baseurl."admin/translate/?id=".$trail['id']); ?>&lang=vi">Vietnamese</a></li>
                      </ul>
                  </p>
                  </div>
                  <div class="right center-align">
                  			Publish?<br>
                          <div class="switch">
                             <label>
                              Off
                              <input type="checkbox" class="publishSwitch" data-id="<?php echo($trail['id']); ?>" <?php if($published) { ?>checked<?php } ?>>
                              <span class="lever"></span>
                              On
                            </label>   
                         </div>              
                  </div>
                </li>
<?php } ?>                
              </ul>  
          </div>          
	</div>


<?php } ?>
    
<?php if($more) { ?>

<div class="row">
	<div class="col s12">
      <div class="card white" style="height:105px;">
        <div class="card-content black-text">
            <div class="row center center-align">

  <ul class="pagination">
    <li <?php if($page == 1) { ?>class="disabled"<?php } else { ?>class="waves-effect"<?php } ?>><a href="<?php if($page == 1) { ?>#!<?php } else { echo($baseurl . "admin/" . $query . "&page=".($page - 1)); } ?>"><i class="material-icons">chevron_left</i></a></li>
<?php $i = 1;
while($i <= $last) { ?>
    <li <?php if($i == $page) { ?>class="active"<?php } else { ?>class="waves-effect"<?php } ?>><a href="<?php echo($baseurl . "admin/" . $query . "&page=".$i); ?>"><?php echo($i); ?></a></li>
<?php $i++; } ?>    
    <li <?php if($page == $last) { ?>class="disabled"<?php } else { ?>class="waves-effect"<?php } ?>><a href="<?php if($page == $last) { ?>#!<?php } else { echo($baseurl . "admin/" . $query . "&page=".($page + 1)); } ?>"><i class="material-icons">chevron_right</i></a></li>
  </ul>

          </div>
        </div>
      </div>
  </div>    
</div>

<?php } ?>    
           </div>
 
    </div>

</div>
 

  <!-- Modal Structure -->
  <div id="deleteTrailWindow" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h4 id="deleteTitle">Modal Header</h4>
      <p id="deleteBody">A bunch of text</p>
    </div>
    <div class="modal-footer">
      <a href="#!" class="waves-effect waves-red btn-flat" id="deleteConfirm">Yes, Delete</a>
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</a>
    </div>
  </div>

      
<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/drawer.php"); ?>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/js_base.php"); ?>

<script>
$('.publishSwitch').change(function() {
        var formData = {
            'id'              : $(this).data('id'),
            'value'             : $(this).prop('checked')
        };
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : '<?php echo($baseurl); ?>src/updatePublish.php', // the url where we want to POST
            data        : formData, // our data object
            dataType    : 'json', // what type of data do we expect back from the server
                        encode          : true
        })
            .done(function(data) {

				if(data.status == "done") {
					Materialize.toast('Update pushed successfully', 5000);
				} else {
					Materialize.toast('Error: '+data.message, 5000);
				}
            })
		  .fail(function(xhr, textStatus, errorThrown) {
				Materialize.toast('Error: '+xhr.responseText, 10000);
			});
});
		$("#adminFilterCity").change(function() {
			var city = $(this).val();
			document.location = "<?php echo($baseurl); ?>admin/?by=city&city=" + city;
		});
function rawurldecode(str) {
  return decodeURIComponent((str + '')
    .replace(/%(?![\da-f]{2})/gi, function() {
      // PHP tolerates poorly formed escape sequences
      return '%25';
    }));
}		
function deleteTrail(e,tid) {
	e.preventDefault();
    $.get( "<?php echo($baseurl); ?>api/trail/?maintainAdmin=yes&id="+tid, function(data) {
		var name = data.name;
		var city = data.city;
		var zip = data.zip;
		var url = data.url;
		var desc = rawurldecode(data.desc);
		$("#deleteTitle").replaceWith('<h4 id="deleteTitle">Really delete "' + name + '"?</h4>');
		$("#deleteBody").replaceWith('<div id="deleteBody"><p class="flow-text">Are you sure you want to delete ' + name + '? This CANNOT be undone! Be sure you have selected the correct trail.</p><p>' + name + ' is located in ' + city + ', ' + zip + '. Its trail page is located <a href="' + zip + '" target="_blank">here</a>.</p><blockquote>'+ desc +'</blockquote></div>');
		$("#deleteConfirm").replaceWith('<a class="waves-effect waves-red btn-flat" id="deleteConfirm" href="#" onClick="reallyDelete(event,'+tid+');">Yes, Delete</a>');
		$('#deleteTrailWindow').openModal();		
	},"json")
  .fail(function() {
    Materialize.toast( "Error: No internet connection", 10000 );
	setTimeout(function(){ window.location = "<?php echo($baseurl); ?>admin/"; }, 6010);
  });
}
function reallyDelete(e, tid) {
	e.preventDefault();
	$('#deleteTrailWindow').closeModal();
	$("#cover").show();
	Materialize.toast('Deleting..', 5000);
        var formData = {
            'id'              : tid,
            'value'           : 'delete',
			'name'			  : '<?php echo($_SESSION['fname']); ?> <?php echo($_SESSION['lname']); ?>'
        };
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : '<?php echo($baseurl); ?>src/deleteTrail.php', // the url where we want to POST
            data        : formData, // our data object
            dataType    : 'json', // what type of data do we expect back from the server
            encode      : true
        })
            .done(function(data) {

				if(data.status == "done") {
					Materialize.toast('Trail deleted! Reloading..', 5000);
					setTimeout(function(){ window.location = "<?php echo($baseurl); ?>admin/"; }, 3010);
				} else {
					Materialize.toast('Error: '+data.message, 5000);
				}
            })
		  .fail(function(xhr, textStatus, errorThrown) {
			  $("#cover").hide();
				Materialize.toast('Error: '+xhr.responseText, 10000);
			});
}
</script>

  </body>
</html>
