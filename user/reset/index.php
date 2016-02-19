<?php
require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php");
$error = false;

if(isset($_GET['email']) && isset($_GET['code'])) {
    $Auth = new Auth;
	$result = $Auth->verifyReset($_GET['email'], $_GET['code']);
	if($result['status']) {
		$error = false;
	} else {
		$error = true;
		$type = "mismatch";	
	}
} else {
	$error = true;
	$type = "missing_data";	
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Prescription Trails - Reset Password</title>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/style_base.php"); ?>

</head>
<body class="<?php echo($bodyclass); ?>">

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/nav.php"); ?>

      <div class="container" style="margin-top:20px;">
<?php if($error) { require("error.php"); } else { ?>
		<div class="row center-align">
			<h1 style="margin-top:5px; font-size:5.3rem" class="white-text glow"><?php echo($lexicon[46][$lang_set]); //Reset Password ?></h1>
        </div>
            <?php if($_GET['er'] == "yes") { ?>
                  <div class="row">
                    <div class="col s12 m8 offset-m2 l6 offset-l3">
                      <div class="card red accent-4">
                        <div class="card-content white-text center">

                            <p class="flow-text"><?php echo($details); ?></p>
            
                        </div>
                      </div>
                    </div>
                  </div>
            <?php } ?>
<form action="<?php echo($baseurl); ?>user/reset/post.php" method="post">
	<input type="hidden" name="uid" value="<?php echo($result['uid']); ?>" />
	<input type="hidden" name="verify" value="<?php echo($result['verify']); ?>" />
		<div class="row">
        	<div class="col s12 m8 offset-m2 l6 offset-l3">
            	<div class="card white hover">
                    <div class="card-content">
                          <div class="row">
                          	<div class="col s12">
                            	<p>Thanks! We've verified your email address. Please type your new password into both of the fields below.</p>
                            </div>
						  </div>
                          <div class="row">
                                <div class="input-field col s12">
                                  <i class="material-icons prefix">lock</i>
                                      <input placeholder="Password" name="password1" id="password1" type="password" class="validate" required>
                                      <label for="password1">Password</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                  <i class="material-icons prefix">lock</i>
                                      <input placeholder="Password" name="password2" id="password2" type="password" class="validate" required>
                                      <label for="password2">Retype Password</label>
                                </div>
                          </div>

                    </div>
                </div>
            </div>
        </div>

		<div class="row center-align">
			  <button class="btn-large waves-effect waves-dark white black-text" id="submitBtn" type="submit" name="action" disabled><?php echo($lexicon[36][$lang_set]); //Submit ?>
                <i class="material-icons right">send</i>
              </button>
        </div>
</form>

<?php } ?>

      </div>


<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/drawer.php"); ?>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/js_base.php"); ?>

  </body>
</html>

<script>
$(document).ready(function () {
   $("#password2").keyup(function(e) {
		var password = $("#password1").val();
		var confirmPassword = $("#password2").val();
		if (password != confirmPassword) {
			if ( $( "#password2" ).hasClass( "invalid" ) ) {
				//Already invalid
			} else {
				$("#password2").addClass("invalid");
			}
			var isDisabled = $("#submitBtn").is(':disabled');
			if(!isDisabled) {
				$('#submitBtn').prop('disabled', true);
			}
		} else {
			$("#password2").removeClass("invalid").addClass("valid");
			$('#submitBtn').prop('disabled', false);
		}
	});
});
</script>