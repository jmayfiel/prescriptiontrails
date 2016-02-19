<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php"); 

$type = $_GET['type'];

if($type == "provider") {
	$text = "The page you requested requires permissions class 'provider'. Your account has not been granted that access level.";
} elseif($type == "admin") {
	$text = "The page you requested requires permissions class 'admin'. Your account has not been granted that access level.";
} elseif($type == "super") {
	$text = "The page you requested requires permissions class 'super'. Your account has not been granted that access level.";
} else {
	$text = "An unknown authentication error occurred. That's all we know. :(";
	$type = "unknown";	
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Prescription Trails - Error</title>

  <!-- CSS  -->
<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/style_base.php"); ?>
  

</head>
<body class="<?php echo($bodyclass); ?>">
  

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/nav.php"); ?>

      <div class="row" style="margin-top:10vh">
        <div class="col s12 m10 offset-m1">
          <div class="card red accent-4">
            <div class="card-content white-text">
              <h1 class="white-text glow" style="font-weight:300; margin-top:10px; margin-bottom:20px;" class="glow">Error!</h1>

                <h4>Error 401: Not Authorized</h4>
                <p class="flow-text">Sorry! It looks like you don't have permission to access the page you requested. Please contact us if you believe this is not correct.</p>

            </div>
            <div class="card-action">
              <a href="<?php echo($baseurl); ?>">Return home</a>
            </div>
          </div>
        </div>
      </div>
<div class="row" style="margin-bottom:10vh;">
        <div class="col s12 m10 offset-m1">
          <ul class="collapsible" data-collapsible="accordion">
            <li>
              <div class="collapsible-header"><i class="material-icons">filter_drama</i>Technical Details</div>
              <div class="collapsible-body white"><img src="<?php echo($baseurl); ?>img/techsupport.gif" width="110" style="float:left;margin-top:10px;margin-left:10px;margin-right:10px;" /><p><strong><?php echo($type); ?></strong>: <?php echo($text); ?></p></div>
            </li>
          </ul>
        </div>
</div>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/drawer.php"); ?>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/js_base.php"); ?>

  </body>
</html>
