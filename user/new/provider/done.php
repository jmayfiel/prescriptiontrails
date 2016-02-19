<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php");
$page_type = "user";

$Auth = new Auth;
$OneStep = $Auth->returnOneStepArray();
$domain = explode("@",$_GET['e']);
if(in_array($domain[1], $OneStep)) {
	$OneStepVerify = true;	
} else {
	$OneStepVerify = false;	
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
              <p class="flow-text">Your Prescription Trails account has been created.</p>
                <div class="card-panel orange darken-1">
                  <p class="white-text flow-text">Please check your email address, <?php echo(htmlspecialchars($_GET['e'], ENT_COMPAT, 'UTF-8')); ?>, for a verificaiton email. You must verify to access all Prescription Trails features.</p>
                  <p class="white-text"><?php if($OneStepVerify) { ?>Because your email address, registered at <?php echo($domain[1]); ?>, qualifies for one-step verification, you are only required to click the link in your email to access all provider features.<?php } else { ?><strong>Important</strong>: Because your email address, registered at <?php echo($domain[1]); ?>, does not qualify for one-step verification, your practice will receive a phone call within two (2) buisness days to verify your status as a medical provider.<?php } ?></p>
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
