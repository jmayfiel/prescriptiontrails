<?php
session_start();
require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php");

	$password	 = $_POST['password'];
	$email		 = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
	$rdr		 = filter_input(INPUT_POST, 'rdr', FILTER_SANITIZE_URL);

	$auth = new Auth;
	
	$result = $auth->login($email, $password);

	if($_POST['remember']) {
		setcookie("ptRemember", $email, time()+(3600 * 24 * 180));	
	} else {
		setcookie('ptRemember', null, -1, '/');
		unset($_COOKIE['ptRemember']);
	}
	
switch($result) {
	case 1:
		//User logged in, not verified
		if($_SESSION['is_provider']) {
			$_SESSION['verified'] = "no";
			$_SESSION['verifiedProvider'] = "no";
			header("Location: ".$baseurl."provider/verify/?msg=email");
		}
		elseif($_SESSION['is_admin']) {
			$_SESSION['verified'] = "no";
			if($rdr == "default") {
				header("Location: ".$baseurl."admin/?msg=verify");
			} else {
				header("Location: ".$baseurl.$rdr);
			}
		}
		elseif($_SESSION['is_super']) {
			$_SESSION['verified'] = "no";
			if($rdr == "default") {
				header("Location: ".$baseurl."super/");
			} else {
				header("Location: ".$baseurl.$rdr);
			}
		}
		else {
			$_SESSION['verified'] = "no";
			if($rdr == "default") {
				header("Location: ".$baseurl."dashboard/");
			} else {
				header("Location: ".$baseurl.$rdr);
			}
		}
		break;
	case 10:
		//User logged in and verified
		$_SESSION['verified'] = "yes";
		if($_SESSION['is_provider']) {
			if($_SESSION['data']['verifiedProvider'] != "yes") {
				header("Location: ".$baseurl."provider/verify/?msg=email");
			} else {
				if($rdr == "default") {
					header("Location: ".$baseurl."provider/");
				} else {
					header("Location: ".$baseurl.$rdr);
				}
			}
		}
		elseif($_SESSION['is_admin']) {
			if($rdr == "default") {
				header("Location: ".$baseurl."admin/");
			} else {
				header("Location: ".$baseurl.$rdr);
			}
		}
		elseif($_SESSION['is_super']) {
			if($rdr == "default") {
				header("Location: ".$baseurl."super/");
			} else {
				header("Location: ".$baseurl.$rdr);
			}
		}
		else {
			if($rdr == "default") {
				header("Location: ".$baseurl."dashboard/");
			} else {
				header("Location: ".$baseurl.$rdr);
			}
		}
		break;
	case 4:
		//no match
		header("Location: ".$baseurl."user/login/?er=yes&e=4&email=".$email);
		break;
	case 2:
		//Inactive
		header("Location: ".$baseurl."user/login/?er=yes&e=2&email=".$email);
		break;
	case 5:
		//DB Error
		header("Location: ".$baseurl."user/login/?er=yes&e=5&email=".$email);
		break;
}

?>