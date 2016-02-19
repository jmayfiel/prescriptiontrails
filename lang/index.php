<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 0);
error_reporting(E_ERROR | E_PARSE);

if(empty($_GET['set'])) {
	require("/nfs/users/clind/public_html/prescriptiontrails.org/src/404.php");
	exit();	
}

$lang 	= filter_input(INPUT_GET,"set", FILTER_SANITIZE_STRING);
$rdr	= filter_input(INPUT_GET, 'rdr', FILTER_SANITIZE_URL);

require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php");

if(in_array($lang, $lang_available)) {
	setcookie('lang',$lang,time() + (86400 * 7 * 90),'/',false);
	$rdr = ltrim($rdr, '/');
	header("Location: ".$baseurl.$rdr);
} else {
	require("/nfs/users/clind/public_html/prescriptiontrails.org/src/404.php");
	exit();	
}

?>