<?php
header("HTTP/1.0 404 Not Found");
	switch($error) {
		case "mismatch":
			$error_type = "mismatch";	
			$error_details = "This reset code has already been used. If you still need to reset your password, please click <a href=\"".$baseurl."user/forgot/\">here</a>.";
			break;
		case "missing_data":
			$error_type = "missing_data";	
			$error_details = "This link does not contain information necessary to perform a password reset. Please ensure that you clicked this link from an official Prescription Trails email";
			break;
		default:
			$error_type = "unknown";	
			$error_details = "An unknown error has occurred and our system was not prepared to handle it. That's all we know. :(";
	}
?>
      <div class="row" style="margin-top:10vh;">
        <div class="col s12 m10 offset-m1">
          <div class="card red accent-4">
            <div class="card-content white-text">
              <h1 class="white-text glow" style="font-weight:300; margin-top:10px; margin-bottom:20px;" class="glow">Error!</h1>

	<h4>Validation for password reset failed.</h4>
    <p class="flow-text">There was a problem with your request. Please double check the link you clicked.</p>

            </div>
            <div class="card-action">
              <a href="<?php echo($baseurl); ?>user/forgot/">Reset Password</a>
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
              <div class="collapsible-body white"><img src="<?php echo($baseurl); ?>img/techsupport.gif" width="110" style="float:left;margin-top:10px;margin-left:10px;margin-right:10px;" /><p><strong><?php echo($error_type); ?></strong>: <?php echo($error_details); ?></p></div>
            </li>
          </ul>
        </div>
    </div>    	

      	</div>      
      </div>