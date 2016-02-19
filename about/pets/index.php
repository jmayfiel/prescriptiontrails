<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php");

$special = "breadcrumb";
$breadcrumb = '<a href="'.$baseurl.'" class="green-text text-darken-3"><i class="fa fa-home"></i></a>';
if($userActive) {
	$breadcrumb = '<a href="'.$baseurl.'dashboard/" class="green-text text-darken-3"><i class="fa fa-home"></i></a>';	
}

$breadcrumb .= '&nbsp;&nbsp;<i class="fa fa-chevron-right grey-text text-darken-1" style="padding-top:1px;"></i>&nbsp;&nbsp;<a href="'.$baseurl.'about/" class="green-text text-darken-3">About</a>&nbsp;&nbsp;<i class="fa fa-chevron-right grey-text text-darken-1" style="padding-top:1px;"></i>&nbsp;&nbsp;<a href="'.$baseurl.'about/pets/" class="green-text text-darken-3">Walking Your Pet</a>';

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Prescription Trails - Walking Your Pet</title>

  <!-- CSS  -->
<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/style_base.php"); ?>
  

</head>
<body class="<?php echo($bodyclass); ?>">
  

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/nav.php"); ?>

      <div class="container" style="margin-top:30px;">

                	<h1 class="center glow hide-on-small-and-down">Walking Your Pet</h1>
                	<h2 class="center glow hide-on-med-and-up">Walking Your Pet</h2>


		<div class="row">
        
            <div class="col s12">
            
              <div class="card hoverable white">
              
              	<div class="card-content">

                    <p class="flow-text" style="margin-bottom:10px;">The below PDF articles provide reports and citations to additional resources on healty living through regular physcial exercise.</p>
                                          
                    <h4>Tips for exercising with furry family members:</h4>                    
                        <ol>
                          <li> <a href="<?php echo($baseurl); ?>files/abqjournalcom-Keep_Rover_cool_in_heat_of_summer.pdf">Keep Rover Cool in Heat of Summer</a> - In extreme heat scenarios, such as the interior of a car, panting can just exacerbate dehydration. And when it's 80 degrees outside, the inside of a car can reach 125 degrees very quickly, even with the windows left open. Each summer, People for the Ethical Treatment of Animals receives dozens of reports of dogs who've died after being left in hot autos by naive or careless pet owners.</li>
                          <li> <a href="<?php echo($baseurl); ?>files/abqjournalcom-Helping_your_dog_handle_challenges_of_summer.pdf">Helping Your Dog Handle Challenges of Summer: prepare pets for more encounters with children, wildlife, lightning</a> - Warm weather brings a fresh set of challenges for dog owners. More exposure to children and neighborhood critters, and stress caused by summer storms and fireworks, are just a few issues dogs have to face.</li>
                        </ol>
                                    
                </div>
              
              </div>
            
            </div>

      </div>
      
      </div>


<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/drawer.php"); ?>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/js_base.php"); ?>


  </body>
</html>
