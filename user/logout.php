<?php

require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php"); 
$Auth = new Auth;

if($Auth->logout()) {
	header("Location: " . $baseurl . "?logout=done");	
} else {
	die("User could not be logged out.");	
}

?>