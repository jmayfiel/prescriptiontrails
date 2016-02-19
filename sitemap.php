<?php
require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php");
$allTrailsObj = new trails;
$allTrails = $allTrails->getAll(); 

$trails = $allTrails['trails'];
foreach($trails as $id => $trail) {
?>
<?php echo($baseurl); ?>trail/?id=<?php echo($trail['id']); ?>
<?php
}
?>