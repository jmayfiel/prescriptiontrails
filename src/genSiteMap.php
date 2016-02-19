<?php
require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php"); 
header("Content-Type: text/plain");
?>
<?php echo($baseurl); ?>

<?php echo($baseurl); ?>about/
<?php echo($baseurl); ?>about/sun/
<?php echo($baseurl); ?>about/contact/
<?php echo($baseurl); ?>about/providers/
<?php echo($baseurl); ?>about/api/
<?php echo($baseurl); ?>user/login/
<?php echo($baseurl); ?>user/create/account/
<?php echo($baseurl); ?>user/filter/
<?php

$allTrailObj = new trails;
$allTrails = $allTrailObj->getAll(); 

$count = $allTrails['totalMatched'];
$trails = $allTrails['trails'];

foreach($trails as $id => $trail) {
	echo($trail['url']);
?> 
<?php		
}
foreach($cities as $id => $city) {
	echo($baseurl. "filter/?by=city&city=" .$city);
?> 
<?php		
}
?>