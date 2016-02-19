<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php");

$special = "breadcrumb";
$breadcrumb = '<a href="'.$baseurl.'" class="green-text text-darken-3"><i class="fa fa-home"></i></a>';
if($userActive) {
	$breadcrumb = '<a href="'.$baseurl.'dashboard/" class="green-text text-darken-3"><i class="fa fa-home"></i></a>';	
}

$breadcrumb .= '&nbsp;&nbsp;<i class="fa fa-chevron-right grey-text text-darken-1" style="padding-top:1px;"></i>&nbsp;&nbsp;<a href="'.$baseurl.'about/" class="green-text text-darken-3">About</a>&nbsp;&nbsp;<i class="fa fa-chevron-right grey-text text-darken-1" style="padding-top:1px;"></i>&nbsp;&nbsp;<a href="'.$baseurl.'about/tos/" class="green-text text-darken-3">Terms of Service</a>';

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Prescription Trails - Terms of Service</title>

  <!-- CSS  -->
<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/style_base.php"); ?>
  

</head>
<body class="<?php echo($bodyclass); ?>">
  

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/nav.php"); ?>

      <div class="container" style="margin-top:30px;">

                	<h1 class="center glow hide-on-small-and-down">Terms of Service</h1>
                	<h2 class="center glow hide-on-med-and-up">Terms of Service</h2>


		<div class="row">
        
            <div class="col s12">
            
              <div class="card hoverable white">
              
              	<div class="card-content">
					
                    <?php require("tos.php"); ?>

                </div>
              
              </div>
            
            </div>

      </div>
      
      </div>


<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/drawer.php"); ?>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/js_base.php"); ?>


  </body>
</html>
