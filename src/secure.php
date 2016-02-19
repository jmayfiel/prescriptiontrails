<?php
if(!$userActive) {
	header("Location: ".$baseurl."user/login/?rdr=".htmlspecialchars($_SERVER['REQUEST_URI']));
	exit();
}
if($providerPage) {
	if($_SESSION['is_provider'] != 1 && $_SESSION['is_super'] != 1) {
		header("Location: ".$baseurl."user/error/?type=provider");
		exit();
	}
	if($overrideProvider != "yes") {
		if($_SESSION['data']['verifiedProvider'] != "yes" || $_SESSION['verified'] != "yes") {
			header("Location: ".$baseurl."provider/verify/");
			exit();
		}
	}
}
if($adminPage) {
	if($_SESSION['is_admin'] != 1 && $_SESSION['is_super'] != 1) {
		header("Location: ".$baseurl."user/error/?type=admin");
		exit();
	}
}
if($superPage) {
	if($_SESSION['is_super'] != 1) {
		header("Location: ".$baseurl."user/error/?type=super");
		exit();
	}
}
?>