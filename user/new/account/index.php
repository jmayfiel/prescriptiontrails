<?php 

require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php");

if($_GET['status'] == "error") {
	$fn			 = filter_input(INPUT_GET, 'fn', FILTER_SANITIZE_STRING);
	$ln			 = filter_input(INPUT_GET, 'ln', FILTER_SANITIZE_STRING);
	$email		 = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);
	$birthMonth	 = filter_input(INPUT_GET, 'birthMonth', FILTER_SANITIZE_STRING);
	$birthYear	 = filter_input(INPUT_GET, 'birthYear', FILTER_SANITIZE_NUMBER_INT);
	$birthDay	 = filter_input(INPUT_GET, 'birthDay', FILTER_SANITIZE_NUMBER_INT);

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
                    <p class="flow-text center">Please complete this form to register for a Prescription Trails account.</p>
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
                    <form action="<?php echo($baseurl); ?>user/new/account/post.php" method="post" id="register">
                        <h4>New Account</h4>
                        <p>Note: If you have a prescription from your provider, please click here to register.</p>
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
                            <div class="input-field col s12 ">
                              <input placeholder="example@example.com" name="email" id="email" type="email" <?php if($_GET['status'] == "error") { echo("value='".htmlspecialchars($email, ENT_COMPAT, 'UTF-8')."'"); } ?> class="validate" required>
                              <label for="email">Email Address</label>
                            </div>
                           </div>                           
                            <div class="row">
                                      <div class="input-field col s5">
                                        <select id="birthMonth" name="birthMonth">
                                          <?php $i = 1; while($i < 13) { 
                                            $dateObj   = DateTime::createFromFormat('!m', $i);
                                            $monthName = $dateObj->format('F');
                                            $monthNameDisplay = $monthName;
                                            if($lang_set == "es") {
                                                $es_M = array(
                                                            1=>"Enero",
                                                            2=>"Febrero",
                                                            3=>"Marzo",
                                                            4=>"Abril",
                                                            5=>"Mayo",
                                                            6=>"Junio",
                                                            7=>"Julio",
                                                            8=>"Agosto",
                                                            9=>"Septiembre",
                                                            10=>"Octubre",
                                                            11=>"Noviembre",
                                                            12=>"Diciembre"
                                                        );
                                                $monthNameDisplay = $es_M[$i];	
                                            }
                                          ?>
                                          <option value="<?php echo($monthName); ?>"<?php if($_GET['status'] == "error") { if($monthName == $birthMonth) { ?> selected<?php } } ?>><?php echo($monthNameDisplay); ?></option>
                                          <?php $i++; } ?>
                                        </select>
                                        <label><?php echo($lexicon[37][$lang_set]); //Month ?></label>
                                      </div>       
                                      <div class="input-field col s3">
                                        <select id="birthDay" name="birthDay">
                                          <?php $i = 1; while($i < 32) { ?>
                                          <option value="<?php echo($i); ?>"<?php if($_GET['status'] == "error") { if($i == $birthDay) { ?> selected<?php } } ?>><?php echo($i); ?></option>
                                          <?php $i++; } ?>
                                        </select>
                                        <label><?php echo($lexicon[38][$lang_set]); //Day ?></label>
                                      </div>       
                                      <div class="input-field col s4">
                                        <select id="birthYear" name="birthYear">
                                          <option value="-1" selected disabled><?php echo($lexicon[39][$lang_set]); //Year ?></option>
                                          <?php $stop = intval(date("Y")) - 100; $i = intval(date("Y")) - 12; while($i > $stop) { ?>
                                          <option value="<?php echo($i); ?>"<?php if($_GET['status'] == "error") { if($i == $birthYear) { ?> selected<?php } } ?>><?php echo($i); ?></option>
                                          <?php $i = $i - 1; } ?>
                                        </select>
                                        <label><?php echo($lexicon[39][$lang_set]); //Year ?></label>
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
                            <div class="col s12">
                                <p>
                                  <input type="checkbox" id="terms" name="terms" />
                                  <label for="terms">I have read and understand the Prescription Trails <a class="modal-trigger" href="#tos">terms and conditions</a>.</label>
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

  <div id="tos" class="modal modal-fixed-footer">
    <div class="modal-content">
		<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/about/tos/tos.php"); ?>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Close</a>
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
			}
			if ($( "#ln" ).val().length < 2) {
				missing = false;
				Materialize.toast("Last Name is invalid.", 8000);
			}		
			if ($( "#email" ).val().length < 2) {
				missing = false;
				Materialize.toast("Email is invalid.", 8000);
			}		
			if ($( "#birthYear" ).val().length < 2) {
				missing = false;
				Materialize.toast("Date of Birth is invalid.", 8000);
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
