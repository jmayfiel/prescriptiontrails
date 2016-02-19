<?php

require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php");

	$password	 = $_POST['password1'];
	$uid		 = filter_input(INPUT_POST, 'uid', FILTER_SANITIZE_NUMBER_INT);
	$verify		 = filter_input(INPUT_POST, 'verify', FILTER_SANITIZE_STRING);

		$db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
		$db->where("id", $uid);
		if($db->has("users")) {

			$db->where ("id", $uid);
			$user = $db->getOne ("users");
	
			if($verify == $user['verification_code']) {
				
				$auth = new auth();
				
				if($auth->resetPW($uid, $password)) {
					header("Location: ".$baseurl."user/login/?msg=reset");
					exit();
				} else {
					die("an unexpected error occurred");	
				}
				
				
			} else {
			  die("Link expired");
			}
		} else {
		  die("uid error");
		}


	$auth = new Auth;
	

?>