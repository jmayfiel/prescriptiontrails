<?php 

require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php");

if($_GET['status'] == "error") {
	$fn			 = filter_input(INPUT_GET, 'fn', FILTER_SANITIZE_STRING);
	$ln			 = filter_input(INPUT_GET, 'ln', FILTER_SANITIZE_STRING);
	$email		 = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);
	$zip		 = filter_input(INPUT_GET, 'zip', FILTER_SANITIZE_EMAIL);
	$pn			 = filter_input(INPUT_GET, 'pn', FILTER_SANITIZE_STRING);
	$ph			 = filter_input(INPUT_GET, 'ph', FILTER_SANITIZE_STRING);

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
<script src='https://www.google.com/recaptcha/api.js'></script>
<style>
div.g-recaptcha {
  margin: 0 auto;
  width: 304px;
}
</style>
  

</head>
<body class="<?php echo($bodyclass); ?>">
  

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/nav.php"); ?>

      <div class="container" style="margin-top:20px;">

		<div class="row">
        
            <div class="col hide-on-small-and-down m4">
              <div class="card hoverable white">
              	<div class="card-content">
                	<h1 class="center"><i class="material-icons large">account_circle</i></h1>
                	<h2 class="center">Register</h2>
                    <p class="flow-text center">Please complete this form to register for a Prescription Trails Provider account.</p>
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
                    <form action="<?php echo($baseurl); ?>user/new/provider/post.php" method="post" id="register">
                        <h4>New Account</h4>
                        <p><strong>IMPORTANT</strong>: Because we must verify medical professionals, please use your official email address if your institution has provided one to you. We are able to autoverify accounts that are registered using UNM HSC, Presbyterian, Lovelace, and other standardized email addresses.</p>
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
                            <div class="input-field col s12 m6">
                              <input placeholder="example@example.com" name="email" id="email" type="email" <?php if($_GET['status'] == "error") { echo("value='".htmlspecialchars($email, ENT_COMPAT, 'UTF-8')."'"); } ?> class="validate" required>
                              <label for="email">Email Address</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <select id="title" name="title">
                                <option value="" disabled <?php if($_GET['status'] != "error") { ?>selected<?php } ?>>Choose profession</option>
<?php foreach($titles as $code => $info) { ?>
                                          <option value="<?php echo($code); ?>" <?php if($_GET['status'] == "error") { if($_GET['title'] == $code) { ?>selected<?php } } ?>><?php echo($info['title']); ?> - <?php echo($info['degree']); ?></option>
<?php } ?>                                          
                                        </select>
                                <label>Profession and Title</label>
                            </div>
                          </div>
                        <h4>Practice Details</h4>
                        <p>Please provide the following details about your practice. We may need to use this information to verify you if your email address isn't autoverified.</p>
                          <div class="row" style="margin-top:20px;">
                            <div class="input-field col s12">
                              <input placeholder="Practice Name" id="pn" name="pn" type="text" class="validate" <?php if($_GET['status'] == "error") { echo("value='".htmlspecialchars($pn, ENT_COMPAT, 'UTF-8')."'"); } ?> required>
                              <label for="pn">Practice Name</label>
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s6">
                              <input placeholder="(XXX) XXX-XXXX" id="ph" name="ph" type="tel" class="validate" <?php if($_GET['status'] == "error") { echo("value='".htmlspecialchars($ph, ENT_COMPAT, 'UTF-8')."'"); } ?> required>
                              <label for="ph">Phone Number</label>
                            </div>
                            <div class="input-field col s6">
                              <input placeholder="XXXXX" id="zip" type="number" min="10000" max="99999" name="zip" class="validate" <?php if($_GET['status'] == "error") { echo("value='".htmlspecialchars($zip, ENT_COMPAT, 'UTF-8')."'"); } ?> required>
                              <label for="zip">Zip Code</label>
                            </div>
                          </div>
                        <h4>Password</h4>                          
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
                            <div class="col s12">
                                <p>
                                  <input type="checkbox" id="terms" name="terms" />
                                  <label for="terms">I have read and understand the Prescription Trails <a href="#!">terms and conditions</a>.</label>
                                </p>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col s12 center-align">
                                <div class="g-recaptcha" data-sitekey="6LfdFBUTAAAAANUEfBOu9fEcvncv4q_z-F8QD_3B"></div>
                            </div>
                          </div>
                          
                          <div class="row">
                            <div class="col s12 center-align">
                              <button class="btn waves-effect waves-light blue darken-1" type="<?php echo($lexicon[36][$lang_set]); //Submit ?>" name="action" id="<?php echo($lexicon[36][$lang_set]); //Submit ?>Btn" disabled><?php echo($lexicon[36][$lang_set]); //Submit ?>
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
			var isDisabled = $("#<?php echo($lexicon[36][$lang_set]); //Submit ?>Btn").is(':disabled');
			if(!isDisabled) {
				$('#<?php echo($lexicon[36][$lang_set]); //Submit ?>Btn').prop('disabled', true);
			}
		} else {
			$("#password2").removeClass("invalid").addClass("valid");
			$('#<?php echo($lexicon[36][$lang_set]); //Submit ?>Btn').prop('disabled', false);
		}
	});
	$("#register").<?php echo($lexicon[36][$lang_set]); //Submit ?>(function(e) {
		if(!isvalid) {
			e.preventDefault();
			var terms = false;
			var missing = true;
			if ($('#terms').is(':checked')) {
				terms = true;
			} else {
				Materialize.toast("You must agree to the Terms.", 8000);	
			}
			if ($( "#fn" ).val().length < 2) {
				missing = false;
				Materialize.toast("First Name is invalid.", 8000);
				$("#fn").addClass("invalid");
			}
			if ($( "#ln" ).val().length < 2) {
				missing = false;
				Materialize.toast("Last Name is invalid.", 8000);
				$("#ln").addClass("invalid");
			}		
			if ($( "#email" ).val().length < 2) {
				missing = false;
				Materialize.toast("Email is invalid.", 8000);
				$("#email").addClass("invalid");
			}		
			if ($( "#zip" ).val().length < 2) {
				missing = false;
				Materialize.toast("Zip Code is invalid.", 8000);
				$("#zip").addClass("invalid");
			} else {
				var zip = $('#zip').val();
				var zipRegex = /^\d{5}$/;
			
				if (!zipRegex.test(zip))
				{
					Materialize.toast("Zip Code is invalid.", 8000);
					missing = false;
					$("#zip").addClass("invalid");
				}				
			}
			if ($( "#ph" ).val().length < 2) {
				missing = false;
				Materialize.toast("Phone number is invalid.", 8000);
				$("#ph").addClass("invalid");
			} else {
				var phone = $('#ph').val();
				var phoneRegex = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
			
				if (!phoneRegex.test(phone))
				{
					Materialize.toast("Phone number is invalid.", 8000);
					Materialize.toast("Phone format: (XXX) XXX-XXXX", 8000);
					missing = false;
					$("#ph").addClass("invalid");
				}				
			}
			if ($( "#pn" ).val().length < 2) {
				missing = false;
				Materialize.toast("Practice Name is invalid.", 8000);
				$("#pn").addClass("invalid");
			}		
			if(terms && missing) {
					isvalid = true;
					$("#register").<?php echo($lexicon[36][$lang_set]); //Submit ?>();
			}
		}
	});
});

</script>

  </body>
</html>
