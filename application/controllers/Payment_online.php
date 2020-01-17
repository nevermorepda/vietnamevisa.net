<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_online extends CI_Controller {

	public function index()
	{
		$breadcrumb = array("Payment online" => site_url("{$this->util->slug($this->router->fetch_class())}"));
		$this->util->block_ip();
		$view_data = array();
		$view_data['breadcrumb'] = $breadcrumb;

		$tmpl_content = array();
		$tmpl_content['meta']['title'] = "Payment Online";
		$tmpl_content['content']   = $this->load->view("payment/index", $view_data, TRUE);
		$this->load->view('layout/view', $tmpl_content);
	}
	
	function proceed()
	{
		if (!empty($_POST))
		{
			$checkOK	= true;
			$fullname	= (!empty($_POST["fullname"]) ? $_POST["fullname"] : "");
			$email		= (!empty($_POST["email"]) ? $_POST["email"] : "");
			$email2		= (!empty($_POST["email2"]) ? $_POST["email2"] : "");
			$booking_id	= (!empty($_POST["application_id"]) ? $_POST["application_id"] : "");
			$amount		= (!empty($_POST["amount"]) ? $_POST["amount"] : "");
			$note		= (!empty($_POST["note"]) ? $_POST["note"] : "");
			$payment	= (!empty($_POST["payment"]) ? $_POST["payment"] : "");
			// $security_code = (!empty($_POST["security_code"]) ? $_POST["security_code"] : "");
			
			$checkOK = !empty($fullname) && !empty($email) && !empty($amount) && !empty($note) && !empty($payment);
			if ($checkOK == false)
			{
				redirect(BASE_URL_HTTPS."/payment-online.html", "back");
			}
			else
			{
				// Get booking id
				$book_id = $this->m_payment->get_next_value();
				
				// Booking key
				$key = "po_".md5(time());
				
				$amount = round($amount);
				
				// $info = new stdClass();
				// $info->booking_id = $booking_id;
				// $info->check_po = 2;
				// $info->created_date = date('Y-m-d');
				// $step = $this->m_check_step->items($info);

				// $check_step_id = date('YmdHis').rand(1,1000);
				// $data_check = array(
				// 	"id"		=> $check_step_id,
				// 	"email" 	=> $email,
				// 	"fullname" 	=> $fullname,
				// 	"step1" 	=> 1,
				// 	"step2" 	=> 1,
				// 	"step3" 	=> 1,
				// 	"step4" 	=> 1,
				// 	"check_po" 	=> 2,
				// 	"price" 	=> $amount,
				// 	'client_ip' => $this->util->realIP(),
				// 	'booking_id'=> $booking_id,
				// );
				// if (!empty($step)) {
				// 	$this->m_check_step->update($data_check, array("id" => $step[0]->id));
				// } else {
				// 	$this->m_check_step->add($data_check);
				// }
				// Add to payment list
				$data = array(
					'id'				=> $book_id,
					'payment_key'		=> $key,
					'fullname'			=> $fullname,
					'primary_email'		=> $email,
					'secondary_email'	=> $email2,
					'booking_id'		=> $booking_id,
					'amount'			=> $amount,
					'message'			=> $note,
					'payment_method'	=> $payment,
					'payment_date' 		=> date("Y-m-d H:i:s"),
					'paid_date' 		=> date("Y-m-d H:i:s"),
					'client_ip' 		=> $this->util->realIP()
				);
				
				if ($this->m_payment->add($data))
				{
					if ($payment == 'Paypal')
					{
						// Send mail to sales department
						$tpl_data = array(
								"FULLNAME"				=> $fullname,
								"AMOUNT"				=> $amount,
								"PRIMARY_EMAIL"			=> $email,
								"SECONDARY_EMAIL"		=> $email2,
								"APPLICATION_ID"		=> $booking_id,
								"NOT_4_PAYMENT"			=> $note,
								"PAYMENT_METHOD"		=> $payment,
						);
						
						$subject = "Payment #".BOOKING_PREFIX_PO.$book_id.": Secure Payment Online Remind PP";
						$message = $this->mail_tpl->payment_online_remind($tpl_data);
						
						// Send to SALE Department
						$mail = array(
				                            "subject"		=> $subject." - ".$fullname,
											"from_sender"	=> $email,
				                            "name_sender"	=> $fullname,
											"to_receiver"	=> MAIL_INFO,
				                            "message"		=> $message
						);
						$this->mail->config($mail);
						// $this->mail->sendmail();
						
						// Send confirmation to SENDER
						$mail = array(
				                            "subject"		=> $subject,
											"from_sender"	=> MAIL_INFO,
				                            "name_sender"	=> SITE_NAME,
											"to_receiver"	=> $email,
				                            "message"		=> $message
						);
						$this->mail->config($mail);
						// $this->mail->sendmail();
					}
					
					// Payment
					if ($payment == 'OnePay') {
						//Redirect to OnePay
						$vpcURL = OP_PAYMENT_URL;
						
						$vpcOpt['Title']				= "Secure Payment Online";
						$vpcOpt['AgainLink']			= urlencode($_SERVER['HTTP_REFERER']);
						$vpcOpt['vpc_Merchant']			= OP_MERCHANT;
						$vpcOpt['vpc_AccessCode']		= OP_ACCESSCODE;
						$vpcOpt['vpc_MerchTxnRef']		= $key;
						$vpcOpt['vpc_OrderInfo']		= BOOKING_PREFIX_PO.$book_id;
						$vpcOpt['vpc_Amount']			= $amount*100;
						$vpcOpt['vpc_ReturnURL']		= OP_RETURN_URL;
						$vpcOpt['vpc_Version']			= "2";
						$vpcOpt['vpc_Command']			= "pay";
						$vpcOpt['vpc_Locale']			= "en";
						$vpcOpt['vpc_TicketNo']			= $this->util->realIP();
						$vpcOpt['vpc_Customer_Email']	= $email;
						
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
					else if($payment == 'Credit Card') {
						//Redirect to gate2shop
						$numberofitems = 1;
						$totalAmount   = $amount;
						$productName   = BOOKING_PREFIX_PO.$book_id.": Secure Payment Online";
						$productPrice  = $amount;
						$productNum    = $numberofitems;
						$datetime      = gmdate("Y-m-d H:i:s");
						
						// Cal checksum
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
						$link .= '&customField1='.$key;
						
						header('Location: '.$link);
						die();
					}
					else if($payment == 'Paypal')
					{
						$paymentAmount = $amount;
						$paymentType = "Sale";
						$itemName = BOOKING_PREFIX_PO.$book_id.": Secure Payment Online";
						$itemQuantity = 1;
						$itemPrice = $amount;
						$returnURL = PAYPAL_RETURN_URL."?key=".$key;
						$cancelURL = PAYPAL_CANCEL_URL."?key=".$key;
						
						$resArray = $this->paypal->CallShortcutExpressCheckout($paymentAmount, PAYPAL_CURRENCY, $paymentType, $itemName, $itemQuantity, $itemPrice, $returnURL, $cancelURL);
						$ack = strtoupper($resArray["ACK"]);
						$token = urldecode($resArray["TOKEN"]);
						if ($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") {
							$this->paypal->RedirectToPayPal($token);
						}
						else {
							header('Location: '.BASE_URL."/payment-online/failure.html?key=".$key);
							die();
						}
					}
				}
			}
		}
		redirect(site_url("{$this->util->slug($this->router->fetch_class())}"));
	}
	
	function success($key="")
	{
		if (empty($key)) {
			$key = !empty($_GET["key"]) ? $_GET["key"] : "";
		}
		if (!empty($key)) {
			$key = str_ireplace(".html", "", $key);
		}
		
		// Redirect if this payment is not found or succed
		$payments = $this->m_payment->items(NULL, $key);
		$payment = $payments[0];
		if ($payment == null || $payment->status)
		{
			redirect(BASE_URL);
			die();
		}
		// End redirect
	
		$client_name = "";
		
		$data  = array(
			'status' => 1,
			'paid_date' => date("Y-m-d H:i:s")
		);
		$where = array( 'payment_key' => $key );
		
		$this->m_payment->update($data, $where);
		
		$payments = $this->m_payment->items(NULL, $key);
		$payment = $payments[0];
		if ($payment != null)
		{
			$client_name = $payment->fullname;
			
			// Send mail to sales department
			$tpl_data = array(
					"FULLNAME"				=> $client_name,
					"AMOUNT"				=> $payment->amount,
					"PRIMARY_EMAIL"			=> $payment->primary_email,
					"SECONDARY_EMAIL"		=> $payment->secondary_email,
					"APPLICATION_ID"		=> $payment->booking_id,
					"NOT_4_PAYMENT"			=> $payment->message,
					"PAYMENT_METHOD"		=> $payment->payment_method,
			);
			
			$subject = "Payment #".BOOKING_PREFIX_PO.$payment->id.": Secure Payment Online ".$payment->payment_method." Successful";
			$message = $this->mail_tpl->payment_online_successful($tpl_data);
			
			// Send to SALE Department
			$mail = array(
	                            "subject"		=> $subject." - ".$client_name,
								"from_sender"	=> $payment->primary_email,
	                            "name_sender"	=> $client_name,
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
								"to_receiver"	=> $payment->primary_email,
	                            "message"		=> $message
			);
			$this->mail->config($mail);
			$this->mail->sendmail();

			$info = new stdClass();
			$info->booking_id = $payment->booking_id;
			$info->check_po = 2;
			$info->created_date = date('Y-m-d');
			$step = $this->m_check_step->items($info);
			$check_step_id = date('YmdHis').rand(1,1000);
			$data_check = array(
				"status" 		=> "paid",
				"send_mail" 	=> 2
			);
			if (!empty($step)) {
				$this->m_check_step->update($data_check, array("id" => $step[0]->id));
			} else {
				$data_check["id"]		= $check_step_id;
				$this->m_check_step->add($data_check);
			}
		}
		
		$view_data["client_name"] = $client_name;
		$tmpl_content['content']  = $this->load->view("payment/successful", $view_data, TRUE);
		$this->load->view('layout/view', $tmpl_content);
	}
	
	function failure($key="")
	{
		if (empty($key)) {
			$key = !empty($_GET["key"]) ? $_GET["key"] : "";
		}
		
		if (!empty($key))
		{
			$key = str_ireplace(".html", "", $key);
			
			$payments = $this->m_payment->items(NULL, $key);
			$payment = $payments[0];
			if ($payment != null) {
				
				// Change key for duplicated email
				$newkey = $key."_f";
				$data   = array( 'payment_key' => $newkey );
				$where  = array( 'payment_key' => $key );
				$this->m_payment->update($data, $where);
				// End change key
				
				$client_name = $payment->fullname;;
				
				// Send mail to sales department
				$tpl_data = array(
						"FULLNAME"				=> $client_name,
						"AMOUNT"				=> $payment->amount,
						"PRIMARY_EMAIL"			=> $payment->primary_email,
						"SECONDARY_EMAIL"		=> $payment->secondary_email,
						"APPLICATION_ID"		=> $payment->booking_id,
						"NOT_4_PAYMENT"			=> $payment->message,
						"PAYMENT_METHOD"		=> $payment->payment_method,
				);
				
				$subject = "Payment #".BOOKING_PREFIX_PO.$payment->id.": Secure Payment Online ".$payment->payment_method." Failure";
				$message = $this->mail_tpl->payment_online_failure($tpl_data);
				
				// Send to SALE Department
				$mail = array(
		                            "subject"		=> $subject." - ".$client_name,
									"from_sender"	=> $payment->primary_email,
		                            "name_sender"	=> $client_name,
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
									"to_receiver"	=> $payment->primary_email,
		                            "message"		=> $message
				);
				$this->mail->config($mail);
				$this->mail->sendmail();
			}
		}
		
		$view_data["errMsg"] = $this->session->flashdata('payment_error');
		$tmpl_content['content']   = $this->load->view("payment/cancel", $view_data, TRUE);
		$this->load->view('layout/view', $tmpl_content);
	}
}

?>