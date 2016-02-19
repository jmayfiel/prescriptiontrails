<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php");
$page_type = "user";
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
              <h4>Go you!</h4>
              <p class="flow-text">Your Prescription Trails account has been created.</p>
                <div class="card-panel orange darken-1">
                  <span class="white-text">Please check your email address, <?php echo(htmlspecialchars($_GET['e'], ENT_COMPAT, 'UTF-8')); ?>, for a verificaiton email. You must verify to access all Prescription Trails features.</span>
                </div>
              <p class="center-align" style="margin-top:15px;"><a class="btn waves-effect waves-light blue darken-1" href="<?php echo($baseurl); ?>user/login/">Login</a></p>
            </div>
          </div>
        </div>
        
    
    </div>
</div>
      
<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/drawer.php"); ?>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/js_base.php"); ?>

  </body>
</html>
