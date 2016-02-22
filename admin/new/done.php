<?php 
require("../db.php"); 
$adminPage = true;
require("../../src/secure.php"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Prescription Trails</title>

  <!-- CSS  -->
<?php require("../../src/style_base.php"); ?>
  

</head>
<body class="<?php echo($bodyclass); ?>">
  

<?php require("../../src/nav.php"); ?>

<div class="container" style="margin-bottom:20vh; margin-top:3vh;">
    <div class="row">
        <div class="col m6 s12 offset-m3 center">
        	<h1 class="glow">Success!</h1>
		</div>
</div>

    <div class="row">
    
        <div class="col m6 s12 offset-m3">
          <div class="card">
            <div class="card-content center">
              <p class="flow-text">Go you! Your trail has been <?php if($_GET['type'] == "update") { ?>updated<?php }  else { ?>created<?php } ?>. Wanna see how it looks? Click <a href="<?php echo($baseurl); ?>trail/?id=<?php echo($_GET['id']); ?>">here</a> to see it in action.</p>
              <p>Click <a class="blue-text" href="<?php echo($baseurl); ?>admin/new/?action=edit&id=<?php echo($_GET['id']); ?>">here</a> to make changes!</p>
            </div>
            <div class="card-image">
              <img src="http://thecatapi.com/api/images/get?format=src&type=gif" style="max-height:450px;">
              <span class="card-title">Here's a cat gif for your troubles</span>
            </div>
            <div class="card-action">
              <a class="blue-text" href="<?php echo($baseurl); ?>admin/new/">Add Another</a>
              <a class="blue-text" href="<?php echo($baseurl); ?>admin/">Return to Dashboard</a>
            </div>
          </div>
        </div>
        
    
    </div>
</div>
      
<?php require("../../src/drawer.php"); ?>

<?php require("../../src/js_base.php"); ?>

  </body>
</html>
