<?php

require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php"); 
$adminPage = true;
require("/nfs/users/clind/public_html/prescriptiontrails.org/src/secure.php"); 

$ds          = DIRECTORY_SEPARATOR;  //1

$headers = apache_request_headers();
 
if (!empty($_FILES)) {

$allowedExts = array("gif", "jpeg", "jpg", "png","tiff","tif","JPG","GIF", "JPEG", "PNG","TIFF","TIF");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);

	if (($_FILES["file"]["size"] < 80000000)
		&& in_array($extension, $allowedExts)) {
     
			$tempFile = $_FILES['file']['tmp_name'];         
			
			$targetPath = dirname( __FILE__ ) . $ds. "images" . $ds;	
					
			if($extension == "tiff" || $extension == "tif") {
				$error = array(
					"error" => "TIFF files are not supported."
				);
				http_response_code(406);
				header("content-type: application/json");
				echo(json_encode($error));
			} else {
			  			 
				$targetFile =  $targetPath . time() . $_FILES['file']['name'];  //5		
				$name = time() . $_FILES['file']['name'];
				if (!move_uploaded_file($tempFile,$targetFile)) {
					$error = array(
						"status" => "error",
						"error" => "Failed to moved file."
					);					
					http_response_code(406);
					
				} else {
					header("A-Status: Uploaded to ".$targetFile);
					$status = array(
						"status" => "done",
						"thumb" => "none",
						"file" => $baseurl . "admin/new/images/" . $name,
						"name" => $name,
						"thumbname" => "square_" . $name
					);
				}

			}
     
	 	echo(json_encode($status));
	 
	} else {
	
		$error = array(
			"error" => strtoupper($extension)." files are not supported."
		);
		
		http_response_code(406);
		header("content-type: application/json");
		echo(json_encode($error));
	
	}
	 
}

?>