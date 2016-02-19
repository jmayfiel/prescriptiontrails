<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php"); 
$Auth = new Auth;
if($Auth->checkSession() == "auth") {
	header("Location: ".$baseurl."dashboard/");
	exit();
}

if($_GET['er'] == "yes") {
	$type = "Unknown";
	$details = "An unknown error has occurred.";
	if($_GET['e'] == 4) {
		$type = "Mismatch";
		$details = "We weren't able to verify the username/password combination you submited. Please try again. Click <a class=\"amber-text\" href=\"".$baseurl."user/forgot/\">here</a> to reset your password.";
	}
	if($_GET['e'] == 2) {
		$type = "Inactive";
		$details = "It appears that your account has been disabled. Please contact us at director@prescriptiontrails.org.";
	}
	if($_GET['e'] == 5) {
		$type = "DB";
		$details = "A database error occurred.";
	}
}

if(!empty($_GET['rdr']) && isset($_GET['rdr'])) {
	$rdr = filter_input(INPUT_GET, "rdr", FILTER_SANITIZE_URL);	
	$rdr = ltrim($rdr, "/");
} else {
	$rdr = "default";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Prescription Trails - Login</title>

  <!-- CSS  -->
<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/style_base.php"); ?>
  

</head>
<body class="<?php echo($bodyclass); ?>">
  

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/nav.php"); ?>

      <div class="container" style="margin-top:20px;">

		<div class="row center-align">
			<h1 style="margin-top:5px; font-size:5.3rem" class="white-text glow"><?php echo($lexicon[35][$lang_set]); //Login ?></h1>
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
            <?php if($_GET['msg'] == "reset") { ?>
                  <div class="row">
                    <div class="col s12 m8 offset-m2 l6 offset-l3">
                      <div class="card light-blue darken-1">
                        <div class="card-content white-text center">

                            <p class="flow-text">Your password has been reset! Please login below.</p>
            
                        </div>
                      </div>
                    </div>
                  </div>
            <?php } ?>
<form action="<?php echo($baseurl); ?>user/login/post.php" method="post">
		<div class="row">
        	<div class="col s12 m8 offset-m2 l6 offset-l3">
            	<div class="card white hover">
                    <div class="card-content">

                          <div class="row">
                                <div class="input-field col s12">
                                  <i class="material-icons prefix">account_circle</i>
                                  <input id="email" name="email" type="email" class="validate" <?php if($_GET['er'] == "yes") { echo("value='".htmlspecialchars($_GET['email'], ENT_COMPAT, 'UTF-8')."'"); } elseif(!empty($_COOKIE['ptRemember'])) { echo("value='".htmlspecialchars($_COOKIE['ptRemember'], ENT_COMPAT, 'UTF-8')."'"); } ?>>
                                  <label for="email">Email Address</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                  <i class="material-icons prefix">lock</i>
                                  <input id="password" name="password" type="password" class="validate">
                                  <label for="password">Password</label>
                                </div>
                          </div>

                          <div class="row center-align">
                          	  <div class="col s12 center-align">
								Remember me next time:
                              </div>
                          </div>
                          <div class="row center-align">
                              <div class="switch col s12">
                                <label>
                                  Off
                                  <input type="checkbox" name="remember" id="remember" <?php if(!empty($_COOKIE['ptRemember'])) { echo("checked"); } ?>>
                                  <span class="lever"></span>
                                  On
                                </label>
                              </div>
                          </div>


                    </div>
                </div>
            </div>
        </div>

		<div class="row center-align">
        	<input type="hidden" name="rdr" value="<?php echo($rdr); ?>" />
			  <button class="btn-large waves-effect waves-dark white black-text" type="submit" name="action"><?php echo($lexicon[36][$lang_set]); //Submit ?>
                <i class="material-icons right">send</i>
              </button>
        </div>
		<div class="row center-align">
			  <a class="btn-flat waves-effect waves-dark white-text" href="<?php echo($baseurl); ?>user/forgot/"><?php echo($lexicon[46][$lang_set]); //Reset Password ?></a>
        </div>
</form>


      </div>


<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/drawer.php"); ?>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/js_base.php"); ?>

  </body>
</html>
