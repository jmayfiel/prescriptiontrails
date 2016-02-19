<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/db.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Learn About Diabetes | Prescription Trails</title>

  <!-- CSS  -->
<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/style_base.php"); ?>
  

</head>
<body class="<?php echo($bodyclass); ?>">
  

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/nav.php"); ?>

      <div class="container" style="margin-top:20px;">
        <div class="row">
            <div class="col m4 s12" style="margin-top:10px"><a class="waves-effect waves-dark btn herobtn white black-text"><i class="material-icons left">search</i>Find Trails</a></div>
            <div class="col m4 s12" style="margin-top:10px"><a class="waves-effect waves-dark btn herobtn white black-text"><i class="material-icons left">account_circle</i>Create an account</a></div>
            <div class="col m4 s12" style="margin-top:10px"><a class="waves-effect waves-dark btn herobtn white black-text"><i class="material-icons left">assignment</i>Have a prescription?</a></div>
        </div>
		<div class="row">
        	<div class="col s12">
            	<div class="card white center-align">
                	<div class="row" style="margin-top:30px; margin-bottom:0px">
                    	<div class="col m2 offset-m5 s4 offset-s4"><img src="<?php echo($baseurl); ?>img/logo_icon.png" class="responsive-img" /></div>
                    </div>
                    <div class="card-content" style="margin-top:0px;">
                        <h1 style="font-weight:300; margin-top:5px;">Get Up & Get Moving!</h1>
                        <p class="flow-text">The New Mexico Prescription Trails web site will help you find some of the best park and trail walking and wheelchair rolling paths around the state.</p>
                    </div>
                </div>
            </div>
        </div>
	  </div>
      
      <div class="container" style="margin-top:20px;">
		<div class="row">

<?php

	foreach($trails as $id => $trail) {
		if($trail['loopcount'] == 1) {
			$distance 	= $trail['loops'][1]['distance'];
			$steps 		= $trail['loops'][1]['steps'];
		} else {
			$distance 	= $trail['totaldist'];
			$steps 		= $trail['totalsteps'];
		}
?>

          <div class="col m4">
          
              <div class="card hoverable">
              
                <div class="card-image waves-effect waves-block waves-light">
                  <img class="activator" src="<?php echo($trail['imagesq']); ?>">
                </div>
                
                <div class="card-content">
                  <span class="card-title activator grey-text text-darken-4"><?php echo($trail['name']); ?><i class="material-icons right">more_vert</i></span>
                  <p><a href="<?php echo($baseurl."trail/?id=".$id); ?>">Learn more!</a></p>
                </div>
                
                <div class="card-reveal">
                  <span class="card-title grey-text text-darken-4"><?php echo($trail['name']); ?><i class="material-icons right">close</i></span>
					<p><?php echo($trail['city']); ?>, <?php echo($trail['zip']); ?></p>
                  <ul>
                    <li>Distance: <?php echo($distance); ?> miles</li>
                    <li>Steps: <?php echo($steps); ?></li>
                    <li>Hours: <?php echo($trail['hours']); ?></li>
                    <li>Nearby intersection: <?php echo($trail['crossstreets']); ?></li>
                  </ul>
                  <p><a href="<?php echo($baseurl."trail/?id=".$id); ?>">Learn more!</a></p>
                </div>
                
              </div>
              
		</div>
<?php

	}
	
?>
            
      	</div>     
        <div class="row">
        	<div class="col m6 s12">
            	<a href="#" class="btn-large white waves-effect center-align black-text" style="width:100%;"><i class="fa fa-gear left"></i>Load more trails</a>
            </div>
        	<div class="col m6 s12">
            	<a href="#" class="btn-large white waves-effect center-align black-text" style="width:100%;"><i class="fa fa-map-marker left"></i>Find trails near you</a>
            </div>
        </div> 
      </div>


<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/drawer.php"); ?>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/js_base.php"); ?>

  </body>
</html>
