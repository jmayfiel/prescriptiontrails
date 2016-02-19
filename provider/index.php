<?php 
require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php"); 
$providerPage = true;
require("/nfs/users/clind/public_html/prescriptiontrails.org/src/secure.php"); ?>
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
    
        <div class="col m3 s12">
              <div class="card white" style="margin-top:132px;">
                <div class="card-content black-text">
                  <span class="card-title black-text">Welcome, <?php echo($_SESSION['fname']); ?></span>
                  <p>You are now logged in to your Prescription Trails Dashboard.</p>
                </div>
                <div class="card-action">
                  <a href="<?php echo($baseurl); ?>admin/new/">New Trail</a>
                  <a href="<?php echo($baseurl); ?>user/logout.php">Logout</a>
                </div>
              </div>
        </div>
        
        <div class="col m9 s12" style="margin-top:20px;">
				
              <h1 class="glow center hide-on-med-and-down">MyPrescriptionTrails</h1>
              <h2 class="glow center hide-on-large-only hide-on-small-and-down">MyPrescriptionTrails</h2>
              <h4 class="glow center hide-on-med-and-up">MyPrescriptionTrails</h4>
                
              <div class="card white">
                <div class="card-content black-text">
					<pre>
                    	<?php print_r($_SESSION); ?>
                    </pre>
               </div>
           </div>

        </div>
    
    </div>

</div>
      
<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/drawer.php"); ?>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/js_base.php"); ?>

  </body>
</html>
