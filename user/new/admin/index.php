<?php 

require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php"); 
$adminPage = true;
require("/nfs/users/clind/public_html/prescriptiontrails.org/src/secure.php"); 

if($_GET['status'] == "error") {
	$fn			 = filter_input(INPUT_GET, 'fn', FILTER_SANITIZE_STRING);
	$ln			 = filter_input(INPUT_GET, 'ln', FILTER_SANITIZE_STRING);
	$email		 = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);
	$dob		 = filter_input(INPUT_GET, 'dob', FILTER_SANITIZE_STRING);

	if($_GET['code'] == "missing") {
		$type = "Missing";
		$details = "Please complete all fields. All information is required to create an account.";
	} elseif($_GET['code'] == "captcha") {
		$type = "Captcha";
		$details = "We weren't able to validate your ReCaptcha response. Please try again.";
	} elseif($_GET['code'] == "exists") {
		$type = "Account Exists";
		$details = "The email address you've entered has already been registered. Please try <a class=\"amber-text\" href=\"".$baseurl."user/reset/\">resetting your password</a>.";
	} elseif($_GET['code'] == "password") {
		$type = "Password Error";
		$details = "The passwords you entered did not match. Please try again.";
	}


}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Prescription Trails - Register</title>

  <!-- CSS  -->
<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/style_base.php"); ?>  

</head>
<body class="<?php echo($bodyclass); ?>">
  

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/nav.php"); ?>

      <div class="container" style="margin-top:20px;">

		<div class="row">
        
            <div class="col hide-on-small-and-down m4">
              <div class="card hoverable white">
              	<div class="card-content">
                	<h1 class="center"><i class="material-icons large">account_circle</i></h1>
                	<h2 class="center">Add Admin</h2>
                    <p class="flow-text center">Please complete this form to register a new administrator.</p>
                </div>
              </div>
            </div>

            <div class="col s12 m8">
            <?php if($_GET['status'] == "error") { ?>
                  <div class="row">
                      <div class="card red accent-4">
                        <div class="card-content white-text">

                            <h3 class="white-text glow">Error: <?php echo($type); ?></h3>
                            <p class="flow-text"><?php echo($details); ?></p>
            
                        </div>
                      </div>
                  </div>
            <?php } ?>
                <div class="row">
                  <div class="card hoverable white">
                    <div class="card-content">
                    <form action="<?php echo($baseurl); ?>user/new/admin/post.php" method="post" id="register">
                        <h4>New Administrator</h4>
                          <div class="row" style="margin-top:20px;">
                            <div class="input-field col s6">
                              <input placeholder="First Name" id="fn" name="fn" type="text" class="validate" <?php if($_GET['status'] == "error") { echo("value='".htmlspecialchars($fn, ENT_COMPAT, 'UTF-8')."'"); } ?> required>
                              <label for="fn">First Name</label>
                            </div>
                            <div class="input-field col s6">
                              <input placeholder="Last Name" id="ln" type="text" name="ln" class="validate" <?php if($_GET['status'] == "error") { echo("value='".htmlspecialchars($ln, ENT_COMPAT, 'UTF-8')."'"); } ?> required>
                              <label for="ln">Last Name</label>
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <input placeholder="example@example.com" name="email" id="email" type="email" <?php if($_GET['status'] == "error") { echo("value='".htmlspecialchars($email, ENT_COMPAT, 'UTF-8')."'"); } ?> class="validate" required>
                              <label for="email">Email Address</label>
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12 m6">
                              <input placeholder="Password" name="password1" id="password1" type="password" class="validate" required>
                              <label for="password1">Password</label>
                            </div>
                            <div class="input-field col s12 m6">
                              <input placeholder="Password" name="password2" id="password2" type="password" class="validate" required>
                              <label for="password2">Retype Password</label>
                            </div>
                          </div>
                          
                          <div class="row">
                            <div class="col s12 center-align">
                              <button class="btn waves-effect waves-light blue darken-1" type="submit" name="action" id="submitBtn" disabled><?php echo($lexicon[36][$lang_set]); //Submit ?>
                                <i class="material-icons right">send</i>
                              </button>
                            </div>
                          </div>
                    </form>
                    </div>
                  </div>
                </div>
            </div>


      </div>
      
      </div>


<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/drawer.php"); ?>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/js_base.php"); ?>
<script>
var isvalid = false;
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
	$("#register").submit(function(e) {
		if(!isvalid) {
			e.preventDefault();
			var terms = true;
			var missing = true;
			if ($( "#fn" ).val().length < 2) {
				missing = false;
				Materialize.toast("First Name is invalid.", 8000);
			}
			if ($( "#ln" ).val().length < 2) {
				missing = false;
				Materialize.toast("Last Name is invalid.", 8000);
			}		
			if ($( "#email" ).val().length < 2) {
				missing = false;
				Materialize.toast("Email is invalid.", 8000);
			}		
			if(terms && missing) {
					isvalid = true;
					$("#register").submit();
			}
		}
	});
});

</script>

  </body>
</html>
