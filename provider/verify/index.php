<?php 
require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php"); 
$providerPage = true;
$overrideProvider = "yes";
require("/nfs/users/clind/public_html/prescriptiontrails.org/src/secure.php");

$human = true;
$email = true;

if($_SESSION['data']['verifiedProvider'] != "yes") {
	$text = "Although your email address has been verified, it does not qualify for one-step verification. You will be contacted within 48 hours of registration at your clinic phone number to verify your identity. You will then have full access to the site.";
	$human = false;
}
if($_SESSION['verified'] != "yes") {
	$text = "Please check your email address (".$_SESSION['email'].") for a verification email sent from admin@prescriptiontrails.org.";	
	$email = false;
}

if($email && $human) {
	echo("Location: ".$baseurl."provider/");
	exit();	
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Prescription Trails - Verify</title>

  <!-- CSS  -->
<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/style_base.php"); ?>
  

</head>
<body class="<?php echo($bodyclass); ?>">
  

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/nav.php"); ?>

      <div class="row" style="margin-top:10vh">
        <div class="col s12 m10 offset-m1">
          <div class="card red accent-4">
            <div class="card-content white-text">
              <h1 class="white-text glow" style="font-weight:300; margin-top:10px; margin-bottom:20px;" class="glow">Provider Not Verified</h1>

				<h4>Sorry! It looks like you are not yet verified.</h4>
                <p class="flow-text"><?php echo($text); ?></p>

            </div>
            <div class="card-action">
              <a href="<?php echo($baseurl); ?>">Return home</a>
              <a class="right" href="<?php echo($baseurl); ?>user/logout.php">Log Out</a>           
            </div>
          </div>
        </div>
      </div>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/drawer.php"); ?>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/js_base.php"); ?>

  </body>
</html>
