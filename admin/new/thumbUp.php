<?php
require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php"); 
$adminPage = true;
require("/nfs/users/clind/public_html/prescriptiontrails.org/src/secure.php"); 

$name = $_POST['name'];
$image = rawurldecode($_POST['img']);

    //explode at ',' - the last part should be the encoded image now
    $exp = explode(',', $image);

    //we just get the last element with array_pop
    $base64 = array_pop($exp);

    //decode the image and finally save it
    $data = base64_decode($base64);
	$name = str_replace(".jpg","",$name);
	$name = str_replace(".png","",$name);
	$name = str_replace(".jpeg","",$name);
    $file = 'images/'.$name.'.jpg';

    //make sure you are the owner and have the rights to write content
    file_put_contents($file, $data);


	$url = $baseurl . "admin/new/images/" . $name . ".jpg";

$response = array(
	name => $name,
	url => $url,
	img => $base64
);

echo(json_encode($response));


?>