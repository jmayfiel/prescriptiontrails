<?php
require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Prescription Trails - Forgot Password</title>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/style_base.php"); ?>

</head>
<body class="<?php echo($bodyclass); ?>">

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/nav.php"); ?>

      <div class="container" style="margin-top:20px;">
		<div class="row center-align">
			<h1 style="margin-top:5px; font-size:5.3rem" class="white-text glow"><?php echo($lexicon[46][$lang_set]); //Reset Password ?></h1>
        </div>
                  <div class="row" style="display:none;" id="errorContainer">
                    <div class="col s12 m8 offset-m2 l6 offset-l3">
                      <div class="card red accent-4">
                        <div class="card-content white-text center">

                            <p class="flow-text" id="error_details"></p>
            
                        </div>
                      </div>
                    </div>
                  </div>
<form id="resetform">
		<div class="row">
        	<div class="col s12 m8 offset-m2 l6 offset-l3">
            	<div class="card white hover">
                    <div class="card-content">
                          <div class="row">
                          	<div class="col s12">
                            	<p>Please enter your email address below to reset your password. You will receive an email with further instructions.</p>
                            </div>
						  </div>
                          <div class="row">
                                <div class="input-field col s12">
                                  <i class="material-icons prefix">account_circle</i>
                                  <input autocomplete="off" id="email" name="email" type="email" class="validate" <?php if($_GET['er'] == "yes") { echo("value='".htmlspecialchars($_GET['email'], ENT_COMPAT, 'UTF-8')."'"); } elseif(!empty($_COOKIE['ptRemember'])) { echo("value='".htmlspecialchars($_COOKIE['ptRemember'], ENT_COMPAT, 'UTF-8')."'"); } ?>>
                                  <label for="email">Email Address</label>
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

      </div>


<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/drawer.php"); ?>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/js_base.php"); ?>

  </body>
</html>

<script>
function isValidEmailAddress(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
};		
$(document).ready(function () {
   $("#email").keyup(function(e) {
		var email = $("#email").val();		
		if (!isValidEmailAddress(email)) {
			if ( $( "#email" ).hasClass( "invalid" ) ) {
				//Already invalid
			} else {
				$("#email").addClass("invalid");
			}
			var isDisabled = $("#submitBtn").is(':disabled');
			if(!isDisabled) {
				$('#submitBtn').prop('disabled', true);
			}
		} else {
			$("#email").removeClass("invalid").addClass("valid");
			$('#submitBtn').prop('disabled', false);
		}
	});
});
$("#resetform").submit(function(e) {
    e.preventDefault();
	$("#errorContainer").hide();
		var email = $("#email").val();		
		if (!isValidEmailAddress(email)) {
			if ( $( "#email" ).hasClass( "invalid" ) ) {
				//Already invalid
			} else {
				$("#email").addClass("invalid");
			}
			var isDisabled = $("#submitBtn").is(':disabled');
			if(!isDisabled) {
				$('#submitBtn').prop('disabled', true);
			}
		} else {
			$("#email").removeClass("invalid").addClass("valid");
			$('#submitBtn').prop('disabled', false);
				var formData = {
					'email'		: email,
				};
				$.ajax({
					type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
					url         : '<?php echo($baseurl); ?>src/pwReset.php', // the url where we want to POST
					data        : formData, // our data object
					dataType    : 'json', // what type of data do we expect back from the server
					encode      : true
				})
					.done(function(data) {
		
						if(data.status == "done") {
							ga('send', 'event', "resetPW", "pw-sent", email);
							Materialize.toast("Address verified.", 5000);
							$("#resetform").replaceWith('<div class="row"><div class="col s12 m8 offset-m2 l6 offset-l3"><div class="card white hover"><div class="card-content">'+
								'<h4 class="center">Done!</h4><p class="flow-text center">Your email address checks out!</p><p class="center" style="margin-top:15px;">Check your inbox at '+email+'. You should have received an email from donotreply@prescriptiontrails.org with further instructions.</p>'+
								'');
						} else {
							Materialize.toast('Error - Verification failed!', 5000);
							$("#error_details").text(data.message);
							$("#errorContainer").show();
							$("#email").val("");
						}
					})
				  .fail(function(xhr, textStatus, errorThrown) {
						Materialize.toast('Error: '+xhr.responseText, 10000);
					});
		}
});
</script>