<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends CI_Controller {

	public function checkUserLogin()
	{
		if (!$this->util->checkUserLogin()) {
			redirect("member/login");
			die();
		}
	}
	
	public function ajax_username()
	{
		$username = "";
		if ($this->session->userdata("user")) {
			$user = $this->session->userdata("user");
			$username = (empty($user->user_fullname)?($user->user_email):$user->user_fullname);
		}
		echo $username;
	}
	
	public function index()
	{
		$this->util->block_ip();
		$this->myaccount();
	}
	
	public function login()
	{
		$breadcrumb = array("Login" => site_url("{$this->util->slug($this->router->fetch_class())}"));
		$this->load->library('user_agent');
		$agent = 'Unidentified';
		if ($this->agent->is_browser()) {
			$agent = $this->agent->browser();
		}
		
		$view_data = array();
		$view_data['agent'] = $agent;
		$view_data['breadcrumb'] = $breadcrumb;
		
		$tmpl_content['meta']['title'] = "Login to ".SITE_NAME;
		$tmpl_content['content'] = $this->load->view("member/login", $view_data, TRUE);
		$this->load->view('layout/main', $tmpl_content);
	}
	
	public function dologin()
	{
		$task = (!empty($_POST["task"]) ? $_POST["task"] : "login");
		
		if ($task == "login")
		{
			$email = (!empty($_POST["email"]) ? $_POST["email"] : "");
			$password = (!empty($_POST["password"]) ? $_POST["password"] : "");
			
			$data = new stdClass();
			$data->email = $email;
			$data->password = $password;
			$this->session->set_flashdata("login", $data);
			
			$info = new stdClass();
			$info->username = $email;
			$info->password = $password;
			
			$user = $this->m_user->user($info, 1);
			
			if ($user != null) {
				$this->m_user->login($email, $password);
			} else {
				$this->session->set_flashdata("status", "Invalid email or password.");
				redirect("member/login", "back");
			}
		}
		else if ($task == "getpass")
		{
			$email = (!empty($_POST["email"]) ? $_POST["email"] : "");
			
			$user = $this->m_user->get_user_by_email($email);
			$fb_user = $this->m_user->get_user_by_email($email, NULL, "facebook");
			$gp_user = $this->m_user->get_user_by_email($email, NULL, "google-plus");
			
			if ($user != null) {
				$tpl_data = array(
					"FULLNAME"		=> $user->user_fullname,
					"EMAIL"			=> $user->user_login,
					"PASSWORD"		=> $user->password_text,
				);
				
				$message = $this->mail_tpl->forgot_password($tpl_data);
				
				// Send to SALE Department
				$mail = array(
					"subject"		=> "Forgot password - ".SITE_NAME,
					"from_sender"	=> MAIL_INFO,
					"name_sender"	=> $user->user_fullname,
					"to_receiver"	=> $email,
					"message"		=> $message
				);
				$this->mail->config($mail);
				$this->mail->sendmail();
				
				redirect("member/recovered-password");
			}
			else if ($fb_user != null) {
				$this->session->set_flashdata("status", "This email is associating with your Facebook account. You just click on the <strong>Sign in with Facebook</strong> button bellow to signin to our system.");
				redirect("member/login", "back");
			}
			else if ($gp_user != null) {
				$this->session->set_flashdata("status", "This email is associating with your Google+ account. You just click on the <strong>Sign in with Google+</strong> button bellow to signin to our system.");
				redirect("member/login", "back");
			}
			else {
				$this->session->set_flashdata("status", "This email is not registered. Please signup a new account with us!");
				redirect("member/login", "back");
			}
		}
		else if ($task == "register")
		{
			$new_title			= (!empty($_POST["new_title"]) ? $_POST["new_title"] : "");
			$new_fullname		= (!empty($_POST["new_fullname"]) ? $_POST["new_fullname"] : "");
			$new_email			= (!empty($_POST["new_email"]) ? $_POST["new_email"] : "");
			$new_password		= (!empty($_POST["new_password"]) ? $_POST["new_password"] : "");
			$new_phone			= (!empty($_POST["new_phone"]) ? $_POST["new_phone"] : "");
			
			$data->new_title = $new_title;
			$data->new_fullname = $new_fullname;
			$data->new_email = $new_email;
			$data->new_password = $new_password;
			$data->new_phone = $new_phone;
			$this->session->set_flashdata("login", $data);
			
			if (empty($new_fullname)) {
				$this->session->set_flashdata("status", "Full name is required.");
				redirect("member/login", "back");
			}
			else if (empty($new_email)) {
				$this->session->set_flashdata("status", "Email is required.");
				redirect("member/login", "back");
			}
			else if ($this->m_user->is_user_exist($new_email)) {
				$this->session->set_flashdata("status", "This email is already in used. Please input another email address.");
				redirect("member/login", "back");
			}
			else if (strlen($new_password) < 6) {
				$this->session->set_flashdata("status", "Password must be at least 6 characters long.");
				redirect("member/login", "back");
			}
			else {
				$data = array(
					"title"				=> $new_title,
					"user_fullname"		=> $new_fullname,
					"user_login"		=> $new_email,
					"user_pass"			=> md5($new_password),
					"password_text"		=> $new_password,
					"user_email"		=> $new_email,
					"active"			=> 1,
					"phone"				=> $new_phone,
					"user_registered"	=> date($this->config->item("log_date_format")),
					"client_ip"			=> $this->util->realIP()
				);
				$this->m_user->add($data);
				
				// Auto Login
				$info->username = $new_email;
				$info->password = $new_password;
				
				$user = $this->m_user->user($info);
				
				if ($user != null) {
					$this->m_user->login($new_email, $new_password);
					
					// SEND MAIL TO USER
					$tpl_data = array(
						"FULLNAME"		=> $user->user_fullname,
						"EMAIL"			=> $user->user_login,
						"PASSWORD"		=> $user->password_text,
					);
					
					$message = $this->mail_tpl->register_successful($tpl_data);
					
					// Send to SALE Department
					$mail = array(
						"subject"		=> "Registration Successful - ".SITE_NAME,
						"from_sender"	=> MAIL_INFO,
						"name_sender"	=> $user->user_fullname,
						"to_receiver"	=> $user->user_email,
						"message"		=> $message
					);
					$this->mail->config($mail);
					$this->mail->sendmail();
				} else {
					$this->session->set_flashdata("status", "Invalid email or password.");
					redirect("member/login");
				}
			}
		}
		
		redirect("member/myaccount");
	}
	
	public function check_email_existed()
	{
		$email = $this->input->post('email');
		$result = FALSE;
		if ($this->m_user->is_user_exist($email)) {
			$result = TRUE;
		}
		echo $result;
	}
	
	public function lostpass()
	{
		$tmpl_content = array();
		$tmpl_content['content']  = $this->load->view("member/lostpass", TRUE, TRUE);
		$this->load->view('layout/view', $tmpl_content);
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect(BASE_URL);
	}
	
	public function myaccount()
	{
		$this->checkUserLogin();
		
		$tmpl_content['meta']['title'] = "My Account";
		$tmpl_content['content'] = $this->load->view("member/myaccount", NULL, TRUE);
		$this->load->view('layout/main', $tmpl_content);
	}
	
	public function profile()
	{
		$this->checkUserLogin();
		
		if (!empty($_POST)) {
			$data = array(
				"user_fullname" => !empty($_POST["fullname"]) ? $_POST["fullname"] : "",
				"address" 		=> !empty($_POST["address"]) ? $_POST["address"] : "",
				"city" 			=> !empty($_POST["city"]) ? $_POST["city"] : "",
				"state" 		=> !empty($_POST["state"]) ? $_POST["state"] : "",
				"zipcode" 		=> !empty($_POST["zipcode"]) ? $_POST["zipcode"] : "",
				"country" 		=> !empty($_POST["country"]) ? $_POST["country"] : "",
				"phone" 		=> !empty($_POST["phone"]) ? $_POST["phone"] : "",
			);
			$where = array("id" => $this->session->userdata("user")->id);
			$this->m_user->update($data, $where);
		}
		
		$view_data['user'] = $this->m_user->load($this->session->userdata("user")->id);
		$view_data['nations'] = $this->m_nation->items();
		
		$tmpl_content['meta']['title'] = "My Profile";
		$tmpl_content['content']   = $this->load->view("member/profile", $view_data, TRUE);
		$this->load->view('layout/main', $tmpl_content);
	}
	
	public function change_password()
	{
		$this->checkUserLogin();
		
		if (!empty($_POST)) {
			$crrent_pwd = !empty($_POST["current_pwd"]) ? $_POST["current_pwd"] : "";
			$new_pwd = !empty($_POST["new_pwd"]) ? $_POST["new_pwd"] : "";
			$re_new_pwd = !empty($_POST["re_new_pwd"]) ? $_POST["re_new_pwd"] : "";
			
			$info->username = $this->session->userdata("user")->user_login;
			$info->password = $crrent_pwd;
			
			$user = $this->m_user->user($info);
			
			if ($user == null) {
				$this->session->set_flashdata("status", "Invalid password.");
				redirect("member/change-password", "back");
			} else if (empty($new_pwd) || strlen($new_pwd) < 6) {
				$this->session->set_flashdata("status", "New password is required at least 6 characters.");
				redirect("member/change-password", "back");
			} else if ($new_pwd != $re_new_pwd) {
				$this->session->set_flashdata("status", "Please retype your new password. Confirm field is not matched.");
				redirect("member/change-password", "back");
			} else {
				$data = array(
					"user_pass" => md5($new_pwd),
					"password_text" => $new_pwd,
				);
				$where = array("id" => $this->session->userdata("user")->id);
				$this->m_user->update($data, $where);
				redirect("member/myaccount");
			}
		}
		
		$tmpl_content['meta']['title'] = "Change Your Password";
		$tmpl_content['content']   = $this->load->view("member/change_password", NULL, TRUE);
		$this->load->view('layout/main', $tmpl_content);
	}
	
	public function recovered_password()
	{
		$tmpl_content['content'] = $this->load->view("member/recovered_password", NULL, TRUE);
		$this->load->view('layout/view', $tmpl_content);
	}
	
	public function payment($booking_id)
	{
		$this->checkUserLogin();
		
		$booking = $this->m_visa_booking->booking($booking_id);
		if (empty($booking) || $booking->status == 1) {
			redirect("member/myaccount");
		}
		
		$rush = $this->util->detect_rush_visa($booking->arrival_date, $booking->visa_type, $booking->visit_purpose);
		if ((date("Y-m-d", strtotime($booking->arrival_date)) < date("Y-m-d")) || ($rush == 3 && $booking->rush_type < 3) || ($rush == 2 && $booking->rush_type < 2)) {
			redirect("member/myaccount");
		}
			
		$view_data = array();
		$view_data["booking_id"] = $booking->id;
		$view_data["item"] = $booking;
		
		$tmpl_content['meta']['title'] = "Settle Payment";
		$tmpl_content['content']   = $this->load->view("member/payment", $view_data, TRUE);
		$this->load->view('layout/main', $tmpl_content);
	}
	
	public function pay()
	{
		$this->checkUserLogin();
		
		if (!empty($_POST)) {
			
			$booking_id = !empty($_POST["booking_id"]) ? $_POST["booking_id"] : 0;
			$payment = !empty($_POST["payment"]) ? $_POST["payment"] : "";
			
			$item = $this->m_visa_booking->booking($booking_id);
			if ($item->status == 1) {
				redirect("member/myaccount");
			}
			
			$data = array(
				"payment_method" => $payment,
			);
			$where = array("id" => $booking_id, "user_id" => $this->session->userdata("user")->id);
			$this->m_visa_booking->update($data, $where);
			
			$item = $this->m_visa_booking->booking($booking_id);
			
			// Payment
			if ($payment == 'OnePay') {
				//Redirect to OnePay
				$vpcURL = OP_PAYMENT_URL;
				
				$vpcOpt['Title']				= "Settle payment for Vietnam visa at ".SITE_NAME;
				$vpcOpt['AgainLink']			= urlencode($_SERVER['HTTP_REFERER']);
				$vpcOpt['vpc_Merchant']			= OP_MERCHANT;
				$vpcOpt['vpc_AccessCode']		= OP_ACCESSCODE;
				$vpcOpt['vpc_MerchTxnRef']		= 'm_'.$item->booking_key;
				$vpcOpt['vpc_OrderInfo']		= (!empty($item->order_ref)?$item->order_ref:$item->id);
				$vpcOpt['vpc_Amount']			= $item->total_fee*100;
				$vpcOpt['vpc_ReturnURL']		= OP_RETURN_URL;
				$vpcOpt['vpc_Version']			= "2";
				$vpcOpt['vpc_Command']			= "pay";
				$vpcOpt['vpc_Locale']			= "en";
				$vpcOpt['vpc_TicketNo']			= $this->util->realIP();
				$vpcOpt['vpc_Customer_Email']	= $item->primary_email;
				$vpcOpt['vpc_Customer_Id']		= $item->user_id;
				
				$md5HashData = "";
				
				ksort($vpcOpt);
				
				$appendAmp = 0;
				
				foreach($vpcOpt as $k => $v) {
					// create the md5 input and URL leaving out any fields that have no value
					if (strlen($v) > 0) {
						// this ensures the first paramter of the URL is preceded by the '?' char
						if ($appendAmp == 0) {
							$vpcURL .= urlencode($k) . '=' . urlencode($v);
							$appendAmp = 1;
						} else {
							$vpcURL .= '&' . urlencode($k) . "=" . urlencode($v);
						}
						if ((strlen($v) > 0) && ((substr($k, 0,4)=="vpc_") || (substr($k,0,5) =="user_"))) {
							$md5HashData .= $k . "=" . $v . "&";
						}
					}
				}
				
				$md5HashData = rtrim($md5HashData, "&");
				$md5HashData = strtoupper(hash_hmac('SHA256', $md5HashData, pack('H*',OP_SECURE_SECRET)));
				
				$vpcURL .= "&vpc_SecureHash=" . $md5HashData;
				
				header("Location: ".$vpcURL);
				die();
			}
			else if ($payment == 'Credit Card') {
				//Redirect to gate2shop
				$numberofitems = 1;
				$totalAmount   = $item->total_fee;
				$productName   = BOOKING_PREFIX.$item->id.": ".$item->visa_type;
				$productPrice  = $totalAmount/$item->group_size;
				$productNum    = $item->group_size;
				$datetime      = gmdate("Y-m-d.H:i:s");
	
				$checksum = md5(G2S_SECRET_KEY.G2S_MERCHANT_ID.G2S_CURRENTCY.$totalAmount.$productName.$productPrice.$productNum.$datetime);
				
				$link = 'https://secure.Gate2Shop.com/ppp/purchase.do?';
				$link .= 'version='.G2S_VERSION;
				$link .= '&merchant_id='.G2S_MERCHANT_ID;
				$link .= '&merchant_site_id='.G2S_MERCHANT_SITE_ID;
				$link .= '&total_amount='.$totalAmount;
				$link .= '&numberofitems='.$numberofitems;
				$link .= '&currency='.G2S_CURRENTCY;
				$link .= '&item_name_1='.$productName;
				$link .= '&item_amount_1='.$productPrice;
				$link .= '&item_quantity_1='.$productNum;
	
				$link .= '&time_stamp='.$datetime;
				$link .= '&checksum='.$checksum;
				$link .= '&customField1=m_'.$item->booking_key;
				$link .= '&customField2='.$this->session->userdata('user')->user_fullname;
	
				header('Location: '.$link);
				die();
			}
			else if($payment == 'Paypal')
			{
				$paymentAmount = $item->total_fee;
				$paymentType = "Sale";
				$itemName = BOOKING_PREFIX.$item->id.": ".$item->visa_type;
				$itemQuantity = 1;
				$itemPrice = $item->total_fee;
				$returnURL = PAYPAL_RETURN_URL."?key=m_".$item->booking_key;
				$cancelURL = PAYPAL_CANCEL_URL."?key=m_".$item->booking_key;
				
				$resArray = $this->paypal->CallShortcutExpressCheckout($paymentAmount, PAYPAL_CURRENCY, $paymentType, $itemName, $itemQuantity, $itemPrice, $returnURL, $cancelURL);
				$ack = strtoupper($resArray["ACK"]);
				$token = urldecode($resArray["TOKEN"]);
				if ($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") {
					$this->paypal->RedirectToPayPal($token);
				}
				else {
					header('Location: '.BASE_URL."/member/payment-failure.html?key=".$item->booking_key);
					die();
				}
			}
		}
		
		redirect("member/myaccount");
	}
	
	function payment_success($key="")
	{
		if (empty($key)) {
			$key = !empty($_GET["key"]) ? $_GET["key"] : "";
		}
		
		if (!empty($key)) {
			$key = str_ireplace("m_", "", str_ireplace(".html", "", $key));
		}
		
		// Redirect if this booking is not found or succed
		$booking = $this->m_visa_booking->booking(NULL, $key);
		if ($booking == null || $booking->status) {
			redirect(BASE_URL);
			die();
		}
		
		$data  = array(
			'status' => 1,
			'paid_date' => date("Y-m-d H:i:s")
		);
		$where = array( 'booking_key' => $key );
		
		$this->m_visa_booking->update($data, $where);
		
		$booking = $this->m_visa_booking->booking(NULL, $key);
		if ($booking != null)
		{
			$user = $this->m_user->load($booking->user_id);
			
			// Send mail
			$tpl_data = $this->mail_tpl->visa_data($booking);
			
			// Send mail to sales department
			$subject = "Application #".BOOKING_PREFIX.$booking->id.": Confirm Visa for Vietnam Successful (gate ".$booking->payment_method.")";
			$vendor_subject = $subject;
			if ($tpl_data['PROCESSING_TIME'] != "Normal") {
				$vendor_subject = "[".$tpl_data['PROCESSING_TIME']."] ".$subject;
			}
				
			$message = $this->mail_tpl->visa_payment_successful($tpl_data);
			
			// Send to SALE Department
			$mail = array(
				"subject"		=> $vendor_subject." - ".$user->user_fullname,
				"from_sender"	=> $booking->primary_email,
				"name_sender"	=> $user->user_fullname,
				"to_receiver"	=> MAIL_INFO,
				"message"		=> $message
			);
			$this->mail->config($mail);
			$this->mail->sendmail();
			
			// Send confirmation to SENDER
			$mail = array(
				"subject"		=> $subject,
				"from_sender"	=> MAIL_INFO,
				"name_sender"	=> SITE_NAME,
				"to_receiver"	=> $booking->primary_email,
				"message"		=> $message
			);
			$this->mail->config($mail);
			$this->mail->sendmail();
			
			if ($booking->payment_method == "OnePay") {
				$fields = array("agent" => "M_THEONE_VN");
				$fields["booking_id"] = $booking->id;
				$curl = curl_init("https://www.theonevietnam.com/cdn/cdn-evs/04.html");
				curl_setopt($curl, CURLOPT_TIMEOUT, 30);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
				curl_exec($curl);
				curl_close($curl);
			}
		}
		
		$total_fee = $booking->total_fee - (($booking->full_package) ? ($booking->stamp_fee * $booking->group_size) : 0);
		
		$view_data = array();
		$view_data["client_name"]	= $user->user_fullname;
		$view_data["total_fee"] 	= $total_fee;
		$view_data["key"]			= $key;
		
		$tmpl_content = array();
		$tmpl_content["transaction_id"]			= BOOKING_PREFIX.$booking->id;
		$tmpl_content["transaction_fee"]		= $total_fee;
		$tmpl_content["transaction_sku"]		= $booking->id;
		$tmpl_content["transaction_name"]		= $booking->visa_type;
		$tmpl_content["transaction_category"]	= ($booking->rush_type == 1) ? "Urgent" : (($booking->rush_type == 2) ? "Emergency" : (($booking->rush_type == 3) ? "Holiday" : (($booking->rush_type == 4) ? "TET Holiday" : "Normal")));
		$tmpl_content["transaction_quantity"]	= $booking->group_size;
		$tmpl_content['content']  = $this->load->view("apply/successful", $view_data, TRUE);
		$this->load->view('layout/view', $tmpl_content);
	}
	
	function payment_failure($key="")
	{
		if (empty($key)) {
			$key = !empty($_GET["key"]) ? $_GET["key"] : "";
		}
		
		if (!empty($key))
		{
			$key = str_ireplace("m_", "", str_ireplace(".html", "", $key));
			
			// Redirect if this booking is not found or succed
			$booking = $this->m_visa_booking->booking(NULL, $key);
			if ($booking == null || $booking->status) {
				redirect(BASE_URL);
				die();
			}
			// End redirect
			
			//$booking = $this->m_visa_booking->booking(NULL, $key);
			if ($booking != null)
			{
				// Change key for duplicated email
				$newkey = $key."_f";
				$data   = array( 'booking_key' => $newkey );
				$where  = array( 'booking_key' => $key );
				$this->m_visa_booking->update($data, $where);
				// End change key
				
				$user = $this->m_user->load($booking->user_id);
				
				// Send mail
				$tpl_data = $this->mail_tpl->visa_data($booking);
				
				$subject = "Application #".BOOKING_PREFIX.$booking->id.": Confirm Visa for Vietnam Failure (gate ".$booking->payment_method.")";
				$vendor_subject = $subject;
				if ($tpl_data['PROCESSING_TIME'] != "Normal") {
					$vendor_subject = "[".$tpl_data['PROCESSING_TIME']."] ".$subject;
				}
				
				$message = $this->mail_tpl->visa_payment_failure($tpl_data);
				
				// Send to SALE Department
				$mail = array(
					"subject"		=> $vendor_subject." - ".$user->user_fullname,
					"from_sender"	=> $booking->primary_email,
					"name_sender"	=> $user->user_fullname,
					"to_receiver"	=> MAIL_INFO,
					"message"		=> $message
				);
				$this->mail->config($mail);
				$this->mail->sendmail();
				
				// Send confirmation to SENDER
				$mail = array(
					"subject"		=> $subject,
					"from_sender"	=> MAIL_INFO,
					"name_sender"	=> SITE_NAME,
					"to_receiver"	=> $booking->primary_email,
					"message"		=> $message
				);
				$this->mail->config($mail);
				$this->mail->sendmail();
			}
		}
		
		$view_data = array();
		$view_data["client_name"] = $user->user_fullname;
		$view_data["errMsg"] = $this->session->flashdata('payment_error');
		
		$tmpl_content = array();
		$tmpl_content['content']   = $this->load->view("apply/failure", $view_data, TRUE);
		$this->load->view('layout/view', $tmpl_content);
	}
}

?>