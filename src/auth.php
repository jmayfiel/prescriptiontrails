<?php
session_start();
use Mailgun\Mailgun;

class HTMLemail
{
 
   function __construct() {
	 $this->base = BASE_URL;
  }

  public function loadMessages()
	{
	 require("confirmemail.php"); 
	 $this->confirmMessage = str_replace("%BASE_URL%", $this->base, $message);
	 $this->confirmText = str_replace("%BASE_URL%", $this->base, $text);
	 require("resetemail.php"); 
	 $this->resetMessage = str_replace("%BASE_URL%", $this->base, $message);
	 $this->resetText = str_replace("%BASE_URL%", $this->base, $text);
	}
 
  public function getMessage($type,$array)
  {
	 $this->loadMessages();
	 if($type == "confirm") {
		 $fname = $array['fname'];
		 $email = $array['email'];
		 $code = $array['code'];		 
		 $new_message = str_replace("%FIRST_NAME%", $fname, $this->confirmMessage);
		 $new_text = str_replace("%FIRST_NAME%", $fname, $this->confirmText);
		 $new_message = str_replace("%EMAIL%", $email, $new_message);
		 $new_text = str_replace("%EMAIL%", $email, $new_text);
		 $new_message = str_replace("%CODE%", $code, $new_message);
		 $new_text = str_replace("%CODE%", $code, $new_text);
		 return array("html" => $new_message, "text" => $new_text);
	 }
	 if($type == "reset") {
		 $fname = $array['fname'];
		 $email = $array['email'];
		 $code = $array['code'];		 
		 $new_message = str_replace("%FIRST_NAME%", $fname, $this->resetMessage);
		 $new_text = str_replace("%FIRST_NAME%", $fname, $this->resetText);
		 $new_message = str_replace("%EMAIL%", $email, $new_message);
		 $new_text = str_replace("%EMAIL%", $email, $new_text);
		 $new_message = str_replace("%CODE%", $code, $new_message);
		 $new_text = str_replace("%CODE%", $code, $new_text);
		 return array("html" => $new_message, "text" => $new_text);
	 }
	 
  }
}
 


class Auth {
	private $_siteKey;

	public function __construct()
  	{
		$this->siteKey = ''; //Enter a long random string here
		$this->oneStepVerify =  array("salud.unm.edu","farmingtonfp.com","sjrmc.net","lovelace.com","nmhi.com","unmmg.org","phs.org","abqhp.com","pinonfp.com","familypracticeassociatesoftaos.com","familydoctornm.org","nmfamilymedicine.com","functionalfamilymedicine.net","rgfmnm.com","romerofamilymedicine.com");
	}

	public function returnOneStepArray() {
		return $this->oneStepVerify;
	}

	private function randomString($length = 50)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$string = '';    
			
		for ($p = 0; $p < $length; $p++) {
			$string .= $characters[mt_rand(0, strlen($characters))];
		}
			
			return $string;
	}

	protected function hashData($data)
	{
			return hash_hmac('sha512', $data, $this->_siteKey);
	}

	public function isProvider($email)
	{		
		$db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

		$db->where ("email", $email);
		$user = $db->getOne ("users");

		if($user['is_provider'] == 1) {
			return true;
		}
			
		return false;
	}

	public function isAdmin($email)
	{		
		$db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

		$db->where ("email", $email);
		$user = $db->getOne ("users");

		if($user['is_admin'] == 1) {
			return true;
		}
			
		return false;
	}

	public function isSuper($email)
	{		
		$db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

		$db->where ("email", $email);
		$user = $db->getOne ("users");

		if($user['is_super'] == 1) {
			return true;
		}
			
		return false;
	}

	public function verify($email, $code)
	{		
		$db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

		$db->where ("email", $email);
		$user = $db->getOne ("users");

		if($code == $user['verification_code']) {
			if($user['is_provider'] == 1) {
				$domain_name = substr(strrchr($email, "@"), 1);
				if (in_array($domain_name, $this->oneStepVerify)) {
					$update = array(
						"verifiedProvider" => "yes"
						);
					$this->setAttr($user['id'],$update);
					$db->where ("email", $email);
					$user = $db->getOne ("users");
					$_SESSION['data'] = json_decode($user['data'], true);
					$return = 1; //verification complete
				} else {
					$update = array(
						"verifiedProvider" => "no"
						);
					$this->setAttr($user['id'],$update);
					$return = 2; //provider must be verfied, email is done
				}
			} else {
				$return = 1; //verification complete
			}
		} else {
			$return = 3; //mismatch
		}
	
		if($return == 1 || $return == 2) {
			$data = Array (
				'is_verified' => $return
			);
			$db->where ("email", $email);
			if ($db->update ('users', $data)) {
				return $return;
			} else {
				return 4;
			}
		} else {
			return 3;
		}

	}

	public function verifyReset($email, $code)
	{		
		$db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
		$db->where("email", $email);
		if($db->has("users")) {

			$db->where ("email", $email);
			$user = $db->getOne ("users");
	
			if($code == $user['verification_code']) {
				$code = $this->randomString();
				$update = array(
					'verification_code' 	=> $code
				);
				$db->where("email", $email);
				$db->update('users', $update);
				return array(
					"status" => true,
					"uid" => $user['id'],
					"verify" => $code
				);
			} else {
			  return array(
				  "status" => false,
				  "uid" => "badcode"
			  );
			}
		} else {
		  return array(
			  "status" => false,
			  "uid" => "bademail"
		  );
		}
	}


	public function forgotPasswordSend($email) {
		$db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
		$db->where("email", $email);
		if($db->has("users")) {
			$db->where("email", $email);
			$user = $db->getOne("users");
			//Create verification code
			$code = $this->randomString();
			$update = array(
				'verification_code' 	=> $code
			);
			$db->where("email", $email);
			$db->update('users', $update);
			$mg = new Mailgun("key-YOURKEYHERE"); //Go to mailgun and set up an account to get an API key
			$domain = "prescriptiontrails.org"; //Change to your domain
			$from = "donotreply@".$domain;
			$generate = new HTMLemail;
			$message = $generate->getMessage("reset", array("fname" => $user['fname'], "email" => $email, "code" => $code));
			$mg->sendMessage($domain, array('from'    => $from, 
											'to'      => $email, 
											'text'    => $message['text'],
											'html'    => $message['html'],
											'subject' => 'Password Reset'));
			return "sent";						  
		} else {
			return "notfound";	
		}
	}

	public function resetPW($uid, $password)
	{
		$db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

		//Generate users salt
		$user_salt = $this->randomString();
				
		//Salt and Hash the password
		$password = $user_salt . $password;
		$password = $this->hashData($password);
				
		//Create verification code
		$code = $this->randomString();

		  $data = Array (
			  'password' 			=> $password,
			  'user_salt' 			=> $user_salt,
			  'verification_code' 	=> $code,
		  );

		$db->where ('id', $uid);
		if ($db->update ('users', $data))
			return true;
		else
			return false;

	}

	public function createUser($email, $password, $fname, $lname, $is_active = 1, $is_admin = 0, $is_provider = 0, $is_super = 0, $is_verified = 0)
	{			
		$db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

		//Generate users salt
		$user_salt = $this->randomString();
				
		//Salt and Hash the password
		$password = $user_salt . $password;
		$password = $this->hashData($password);
				
		//Create verification code
		$code = $this->randomString();
		
		$usrData = json_encode(array(
			"fav" => array(0)
		));
	
		  $data = Array (
			  'email' 				=> $email,
			  'password' 			=> $password,
			  'user_salt' 			=> $user_salt,
			  'fname' 				=> $fname,
			  'lname' 				=> $lname,
			  'is_active' 			=> $is_active,
			  'is_verified' 		=> $is_verified,
			  'is_admin' 			=> $is_admin,
			  'is_provider' 		=> $is_provider,
			  'is_super' 			=> $is_super,
			  'data' 				=> $usrData,
			  'verification_code' 	=> $code,
			  'createdAt'			=> $db->now(),
		  );

		$id = $db->insert ('users', $data);
		if ($id) {
			require("confirmemail.php");
			$mg = new Mailgun("key-YOURKEYHERE"); //Go to mailgun and set up an account to get an API key
			$domain = "prescriptiontrails.org"; //Change to your domain
			$from = "donotreply@".$domain;
			$generate = new HTMLemail;
			$message = $generate->getMessage("confirm", array("fname" => $fname, "email" => $email, "code" => $code));
			$mg->sendMessage($domain, array('from'    => $from, 
											'to'      => $email, 
											'text'    => $message['text'],
											'html'    => $message['html'],
											'subject' => 'Please Verify Your Email Address'));
											
			/* THIS SECTION LETS YOU AUTOSUBSCRIBE PEOPLE TO A MAILING LIST - ADVANCED
			$mc = new \Mailchimp\Mailchimp('YOURKEYHERE'); //Go to mailchimp and set up an account to get an API key
			

			try {
			$result = $mc->post('lists/51022bd4a7/members/', array(
				'email_address' => $email,
				'status' => "subscribed",
				'merge_fields' => array(
					"FNAME" => $fname,
					"LNAME" =>$lname
				)
			));
			} catch (Exception $e) {
				// Do nothing. we don't care if email exists. Mailchimp is secondary
			}
			*/
			
			$result = array(
				"status" => true,
				"id" => $id,
			);
			return $result;
		} else {				
			return false;
		}
	}

	  public function toggleStatus($id, $update)
	  {
		 $db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
			$db->where("id", $id);
			if($db->has("users")) {
				
				$newData = array(
					"is_active" => $attribute,
				);
	
				$db->where ('id', $id);
				if ($db->update ('users', $newData))
					return true;
				else
					return 'update failed: ' . $db->getLastError();

			} else {
				return false;
			}
	  }

	  public function setAttr($id, $attribute)
	  {
		 $db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
			$db->where("id", $id);
			if($db->has("users")) {
	
				$db->where ('id', $id);
				$user = $db->getOne ("users");
				if(empty($user['data'])) {
					$data = $attribute;
				} else {
					$userData = json_decode($user['data'], true);
					$data = array_merge( $userData, $attribute );
				}
				
				$newData = array(
					"data" => json_encode($data),
				);
				
				$db->where ('id', $id);
				if ($db->update ('users', $newData))
					return true;
				else
					return 'update failed: ' . $db->getLastError();

			} else {
				return false;
			}
	  }

	public function login($email, $password)
	{
		$db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
		
		$db->where ("email", $email);
		$user = $db->getOne ("users");
			
		//Salt and hash password for checking
		$password = $user['user_salt'] . $password;
		$password = $this->hashData($password);
			
		//Check email and password hash match database row
			
		//Convert to boolean
		$is_active = (boolean) $user['is_active'];
		$verified = (boolean) $user['is_verified'];
			
		if($password == $user['password']) {	
			if($is_active == true) {
				if($verified == true) {
					//Email/Password combination exists, set sessions
					//First, generate a random string.
					$random = $this->randomString();
					//Build the token
					$token = $_SERVER['HTTP_USER_AGENT'] . $random;
					$token = $this->hashData($token);
											
					//Setup sessions vars
					$_SESSION['token'] = $token;
					$_SESSION['user_id'] = $user['id'];
					$_SESSION['data'] = json_decode($user['data'], true);
					$_SESSION['fname'] = $user['fname'];
					$_SESSION['lname'] = $user['lname'];
					$_SESSION['email'] = $user['email'];
					$_SESSION['is_admin'] = $user['is_admin'];
					$_SESSION['is_super'] = $user['is_super'];
					$_SESSION['is_provider'] = $user['is_provider'];
						
					$db->where('user_id', $user['id']);
					$db->delete('logged_in_member');

					//Insert new logged_in_member record for user
						$data = Array (
							'user_id' => $user['id'],
							'session_id' => session_id(),
							'token' => $token,
							'is_provider' => $user['is_provider'],
							'is_admin' => $user['is_admin'],
							'is_super' => $user['is_super'],
							'createdAt' => $db->now()
						);
						$id = $db->insert ('logged_in_member', $data);
						if ($id) {
								return 10;
							} else {
								return 5;
							}
				} else {
					//Not verified
					//Email/Password combination exists, set sessions
					//First, generate a random string.
					$random = $this->randomString();
					//Build the token
					$token = $_SERVER['HTTP_USER_AGENT'] . $random;
					$token = $this->hashData($token);
						
					//Setup sessions vars
					session_start();
					$_SESSION['token'] = $token;
					$_SESSION['user_id'] = $user['id'];
					$_SESSION['data'] = json_decode($user['data'], true);
					$_SESSION['fname'] = $user['fname'];
					$_SESSION['lname'] = $user['lname'];
					$_SESSION['email'] = $user['email'];
					$_SESSION['is_admin'] = $user['is_admin'];
					$_SESSION['is_super'] = $user['is_super'];
					$_SESSION['is_provider'] = $user['is_provider'];
						
					//Delete old logged_in_member records for user
					
					//Insert new logged_in_member record for user
					$db->where('user_id', $user['id']);
					$db->delete('logged_in_member');

					//Insert new logged_in_member record for user
						$data = Array (
							'user_id' => $user['id'],
							'session_id' => session_id(),
							'token' => $token,
							'is_provider' => $user['is_provider'],
							'is_admin' => $user['is_admin'],
							'is_super' => $user['is_super'],
							'createdAt' => $db->now()
						);
						$id = $db->insert ('logged_in_member', $data);
						if ($id) {
								return 1;
							} else {
								return 5;
							}
				}
			} else {
				//Not active
				return 2;
			}
		}
		//No match, reject
		return 4;
	}

	public function checkSession()
	{
		$db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
		
		$db->where ("user_id", $_SESSION['user_id']);
		$user = $db->getOne ("logged_in_member");
			
		if($user) {
			//Check ID and Token
			if(session_id() == $user['session_id'] && $_SESSION['token'] == $user['token']) {
				//Id and token match, refresh the session for the next request
				$this->refreshSession();
				return "auth";
			} else {
				return "unauth";
			}
		} else {
			return "unauth";	
		}
			
	}

	private function refreshSession()
	{
		$db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
		//Regenerate id
		session_regenerate_id();
			
		//Regenerate token
		$random = $this->randomString();
		//Build the token
		$token = $_SERVER['HTTP_USER_AGENT'] . $random;
		$token = $this->hashData($token); 
			
		//Store in session
		$_SESSION['token'] = $token;
		
		$data = Array (
			'session_id' => session_id(),
			'token' => $token,
		);
		$db->where ('user_id', $_SESSION['user_id']);
		if ($db->update ('logged_in_member', $data))
			return true;
		else
			return false;

	}
	public function logout()
	{
		if($this->checkSession() == "auth") {
			$db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
			$db->where('user_id', $_SESSION['user_id']);
			$db->delete('logged_in_member');	
			session_destroy();	
			return true;	
		} else {
			return true;	
		}
	}

}