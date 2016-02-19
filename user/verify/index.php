<?php

require("../../admin/db.php");

if(isset($_GET['email']) && isset($_GET['code'])) {
    $Auth = new Auth;
	$result = $Auth->verify($_GET['email'], $_GET['code']);
	if($result == 1) {
		if($Auth->checkSession()) {
			$_SESSION['verified'] = "yes";
			
			if($_SESSION['is_admin']) {
				header("Location: ".$baseurl."admin/?msg=verified");
			}
			elseif($_SESSION['is_super']) {
				header("Location: ".$baseurl."super/?msg=verified");
			}
			elseif($_SESSION['is_provider']) {
				header("Location: ".$baseurl."provider/?msg=verified");
			}
			else {
				header("Location: ".$baseurl."dashboard/?msg=verified");
			}
		} else {
			header("Location: ".$baseurl."user/login/?msg=verified");
		}
	}
	if($result == 2) {
		if($Auth->checkSession()) {
			$_SESSION['verified'] = "yes";
			if($_SESSION['data']['verifiedProvider'] != "yes") {
				header("Location: ".$baseurl."provider/verify/?msg=email");
			} else {
				header("Location: ".$baseurl."provider/");
			}
		} else {
			header("Location: ".$baseurl."user/login/?msg=verified");
		}
	}
	if($result == 3) {
		die("The link you clicked was malformed or has already been used.");	
	}
	if($result == 4) {
		die("SQL error.");	
	}
} else {
	die("The link you clicked was malformed or has already been used.");	
}

?>