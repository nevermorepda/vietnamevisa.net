<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Booking extends CI_Controller {

	public function flight()
	{
		if (empty($_POST)) {
			redirect("services");
		}
		
		$airline 		= (!empty($_POST["airline"]) ? $_POST["airline"] : "");
		$direction 		= (!empty($_POST["direction"]) ? $_POST["direction"] : "");
		$departureDate 	= (!empty($_POST["departureDate"]) ? $_POST["departureDate"] : "");
		$returnDate 	= (!empty($_POST["returnDate"]) ? $_POST["returnDate"] : "");
		$leavingFrom 	= (!empty($_POST["leavingFrom"]) ? $_POST["leavingFrom"] : "");
		$goingTo 		= (!empty($_POST["goingTo"]) ? $_POST["goingTo"] : "");
		$travelers 		= (!empty($_POST["travelers"]) ? $_POST["travelers"] : "");
		$fullname 		= (!empty($_POST["fullname"]) ? $_POST["fullname"] : "");
		$email 			= (!empty($_POST["email"]) ? $_POST["email"] : "");
		$phone 			= (!empty($_POST["phone"]) ? $_POST["phone"] : "");
		$specialRequest = (!empty($_POST["specialRequest"]) ? $_POST["specialRequest"] : "");
		
		// Send mail to sales department
		$tpl_data = array(
				"AIRLINE"			=> $airline,
				"DIRECTION"			=> $direction,
				"DEPARTURE_DATE"	=> date('M d Y', strtotime($departureDate)),
				"RETURN_DATE"		=> date('M d Y', strtotime($returnDate)),
				"FROM_CITY"			=> $leavingFrom,
				"TO_CITY"			=> $goingTo,
				"TRAVELERS"			=> $travelers,
				"FULLNAME"			=> $fullname,
				"EMAIL"				=> $email,
				"PHONE"				=> $phone,
				"SPECIAL_REQUEST"	=> $specialRequest,
		);
		
		$message = $this->mail_booking_tpl->flight($tpl_data);
			
		// Send to SALE Department
		$mail = array(
                            "subject"		=> "Flight Booking from ".strtoupper($fullname),
							"from_sender"	=> $email,
                            "name_sender"	=> $fullname,
							"to_receiver"	=> MAIL_INFO,
                            "message"		=> $message
		);
		$this->mail->config($mail);
		$this->mail->sendmail();
		
		// Send confirmation to SENDER
		$mail = array(
                            "subject"		=> "Flight Booking Request confirmation from ".SITE_NAME,
							"from_sender"	=> MAIL_INFO,
                            "name_sender"	=> SITE_NAME,
							"to_receiver"	=> $email,
                            "message"		=> $message
		);
		$this->mail->config($mail);
		$this->mail->sendmail();
		
		$this->request_sent();
	}
	
	public function hotel()
	{
		if (empty($_POST)) {
			redirect("services");
		}
		
		$checkinDate 	= (!empty($_POST["checkinDate"]) ? $_POST["checkinDate"] : "");
		$checkoutDate 	= (!empty($_POST["checkoutDate"]) ? $_POST["checkoutDate"] : "");
		$destination 	= (!empty($_POST["destination"]) ? $_POST["destination"] : "");
		$budget 		= (!empty($_POST["budget"]) ? $_POST["budget"] : "");
		$stars 			= (!empty($_POST["stars"]) ? $_POST["stars"] : "");
		$rooms 			= (!empty($_POST["rooms"]) ? $_POST["rooms"] : "");
		$occupancy 		= (!empty($_POST["occupancy"]) ? $_POST["occupancy"] : "");
		$fullname 		= (!empty($_POST["fullname"]) ? $_POST["fullname"] : "");
		$email 			= (!empty($_POST["email"]) ? $_POST["email"] : "");
		$phone 			= (!empty($_POST["phone"]) ? $_POST["phone"] : "");
		$specialRequest = (!empty($_POST["specialRequest"]) ? $_POST["specialRequest"] : "");
		
		// Send mail to sales department
		$tpl_data = array(
				"CHECKIN_DATE"		=> date('M d Y', strtotime($checkinDate)),
				"CHECKOUT_DATE"		=> date('M d Y', strtotime($checkoutDate)),
				"DESTINATION"		=> $destination,
				"BUDGET"			=> $budget,
				"STARS"				=> $stars,
				"ROOMS"				=> $rooms,
				"ROOM_TYPE"			=> $occupancy,
				"FULLNAME"			=> $fullname,
				"EMAIL"				=> $email,
				"PHONE"				=> $phone,
				"SPECIAL_REQUEST"	=> $specialRequest,
		);
		
		$message = $this->mail_booking_tpl->hotel($tpl_data);
			
		// Send to SALE Department
		$mail = array(
                            "subject"		=> "Hotel Reservation from ".strtoupper($fullname),
							"from_sender"	=> $email,
                            "name_sender"	=> $fullname,
							"to_receiver"	=> MAIL_INFO,
                            "message"		=> $message
		);
		$this->mail->config($mail);
		$this->mail->sendmail();
		
		// Send confirmation to SENDER
		$mail = array(
                            "subject"		=> "Hotel Reservation Request confirmation from ".SITE_NAME,
							"from_sender"	=> MAIL_INFO,
                            "name_sender"	=> SITE_NAME,
							"to_receiver"	=> $email,
                            "message"		=> $message
		);
		$this->mail->config($mail);
		$this->mail->sendmail();
		
		$this->request_sent();
	}
	
	public function tour()
	{
		if (empty($_POST)) {
			redirect("services");
		}
		
		$arrivalDate 	= (!empty($_POST["arrivalDate"]) ? $_POST["arrivalDate"] : "");
		$departureDate 	= (!empty($_POST["departureDate"]) ? $_POST["departureDate"] : "");
		$destination 	= (!empty($_POST["destination"]) ? $_POST["destination"] : "");
		$category 		= (!empty($_POST["category"]) ? $_POST["category"] : "");
		$budget 		= (!empty($_POST["budget"]) ? $_POST["budget"] : "");
		$travelers 		= (!empty($_POST["travelers"]) ? $_POST["travelers"] : "");
		$fullname 		= (!empty($_POST["fullname"]) ? $_POST["fullname"] : "");
		$email 			= (!empty($_POST["email"]) ? $_POST["email"] : "");
		$phone 			= (!empty($_POST["phone"]) ? $_POST["phone"] : "");
		$specialRequest = (!empty($_POST["specialRequest"]) ? $_POST["specialRequest"] : "");
		
		// Send mail to sales department
		$tpl_data = array(
				"ARRIVAL_DATE"		=> date('M d Y', strtotime($arrivalDate)),
				"DEPARTURE_DATE"	=> date('M d Y', strtotime($departureDate)),
				"DESTINATION"		=> $destination,
				"CATEGORY"			=> $category,
				"BUDGET"			=> $budget,
				"TRAVELERS"			=> $travelers,
				"FULLNAME"			=> $fullname,
				"EMAIL"				=> $email,
				"PHONE"				=> $phone,
				"SPECIAL_REQUEST"	=> $specialRequest,
		);
		
		$message = $this->mail_booking_tpl->tour($tpl_data);
			
		// Send to SALE Department
		$mail = array(
                            "subject"		=> "Tour Booking from ".strtoupper($fullname),
							"from_sender"	=> $email,
                            "name_sender"	=> $fullname,
							"to_receiver"	=> MAIL_INFO,
                            "message"		=> $message
		);
		$this->mail->config($mail);
		$this->mail->sendmail();
		
		// Send confirmation to SENDER
		$mail = array(
                            "subject"		=> "Tour Booking Request confirmation from ".SITE_NAME,
							"from_sender"	=> MAIL_INFO,
                            "name_sender"	=> SITE_NAME,
							"to_receiver"	=> $email,
                            "message"		=> $message
		);
		$this->mail->config($mail);
		$this->mail->sendmail();
		
		$this->request_sent();
	}
	
	public function request_sent()
	{
		$tmpl_content['content']   = $this->load->view("booking/request_sent", NULL, TRUE);
		$this->load->view('layout/main', $tmpl_content);
	}
	
	function ajax_cal_fast_checkin_fees()
	{
		$service_type	= (!empty($_POST["servicetype"]) ? $_POST["servicetype"] : 0);
		$arrival_port	= (!empty($_POST["arrivalport"]) ? $_POST["arrivalport"] : 0);
		
		$fast_checkin = $this->m_fast_checkin_fee->search($service_type, $arrival_port);
		
		$result = array($fast_checkin);
		echo json_encode($result);
	}
	
	function ajax_cal_car_pickup_fees()
	{
		$car_type		= (!empty($_POST["cartype"]) ? $_POST["cartype"] : "");
		$num_seat		= (!empty($_POST["seats"]) ? $_POST["seats"] : 0);
		$arrival_port	= (!empty($_POST["arrivalport"]) ? $_POST["arrivalport"] : 0);
		
		$car_pickup = $this->m_car_fee->search($num_seat, $arrival_port);
		
		$result = array($car_pickup);
		echo json_encode($result);
	}
	
	public function ajax_cal_service_fees()
	{
		$arrival_port	= (!empty($_POST["arrival_port"]) ? $_POST["arrival_port"] : 0);
		$service_type	= (!empty($_POST["service_type"]) ? $_POST["service_type"] : 0);
		$car_type		= (!empty($_POST["car_type"]) ? $_POST["car_type"] : "");
		$num_seat		= (!empty($_POST["num_seat"]) ? $_POST["num_seat"] : 0);
		
		// FC
		$fast_checkin = $this->m_fast_checkin_fee->search($service_type, $arrival_port);
		
		// Car pick-up
		$car_pickup = $this->m_car_fee->search($num_seat, $arrival_port);
		
		$result = array($fast_checkin, $car_pickup);
		echo json_encode($result);
	}
	
	public function airport_service()
	{
		if (empty($_POST)) {
			redirect("services");
		}
		
		$group_size 		= (!empty($_POST["group-size"]) ? $_POST["group-size"] : 0);
		$arrival_port 		= (!empty($_POST["arrival-port"]) ? $_POST["arrival-port"] : 0);
		
		$fast_track			= (!empty($_POST["airport-fast-track"]) ? $_POST["airport-fast-track"] : 0);
		$fast_track_fee		= 0;
		
		$car_pickup			= (!empty($_POST["car-pickup"]) ? $_POST["car-pickup"] : 0);
		$car_pickup_fee		= 0;
		$car_type			= (!empty($_POST["car-type"]) ? $_POST["car-type"] : "Economic Car");
		$num_seat			= (!empty($_POST["num-seat"]) ? $_POST["num-seat"] : 0);
		
		$welcome_name		= (!empty($_POST["welcome-name"]) ? $_POST["name-prefix"]." ".$_POST["welcome-name"] : "");
		$arrival_date 		= (!empty($_POST["arrival-date"]) ? $_POST["arrival-date"] : "");
		$flight_number		= (!empty($_POST["flight-number"]) ? $_POST["flight-number"] : "");
		
		$fullname 			= (!empty($_POST["fullname"]) ? $_POST["fullname"] : "");
		$primary_email		= (!empty($_POST["email"]) ? $_POST["email"] : "");
		$phone_number		= (!empty($_POST["phone-number"]) ? $_POST["phone-number"] : "");
		$special_request 	= (!empty($_POST["special-request"]) ? $_POST["special-request"] : "");
		
		$payment			= (!empty($_POST["payment"]) ? $_POST["payment"] : "");
		$promotion_code		= (!empty($_POST["promotion_code"]) ? $_POST["promotion_code"] : "");
		
		$security_code 		= (!empty($_POST["security_code"]) ? trim($_POST["security_code"]) : "");
		if (strtoupper($security_code) != strtoupper($this->util->getSecurityCode())) {
			redirect($_SERVER['HTTP_REFERER']);
		}
		
		$fast_track_fee = 0;
		$car_pickup_fee = 0;
		$total_fee = 0;
		$capital = 0;
		
		if ($fast_track) {
			$fee = $this->m_fast_checkin_fee->search($fast_track, $arrival_port);
			$fast_track_fee	= $fee;
			$total_fee += $fee * $group_size;
			
			$fee = $this->m_fast_checkin_fee->search($fast_track, $arrival_port, 1);
			$capital += $fee * $group_size;
		}
		
		if ($car_pickup) {
			$fee = $this->m_car_fee->search($num_seat, $arrival_port);
			$car_pickup_fee	= $fee;
			$total_fee += $fee;
			
			$fee = $this->m_car_fee->search($num_seat, $arrival_port, 1);
			$capital += $fee;
		}
		
		// Get book id
		$book_id = $this->m_service_booking->get_next_value();
		
		// Booking key
		$key = "ex_".md5(time());
		
		// Save to db
		$data = array(
			"id"				=> $book_id,
			"group_size"		=> $group_size,
			"arrival_port"		=> $this->m_arrival_port->load($arrival_port)->short_name,
			"welcome_name"		=> $welcome_name,
			"flight_number"		=> $flight_number,
			"arrival_date"		=> date($this->config->item("log_date_format"), strtotime($arrival_date)),
			"contact_name"		=> $fullname,
			"primary_email"		=> $primary_email,
			"phone"				=> $phone_number,
			"special_request"	=> $special_request,
			"promotion_code"	=> $promotion_code,
			"payment_method"	=> $payment,
			"total_fee"			=> $total_fee,
			"capital"			=> $capital,
			"fast_checkin"		=> $fast_track,
			"fast_checkin_fee"	=> $fast_track_fee,
			"car_pickup"		=> $car_pickup,
			"car_fee"			=> $car_pickup_fee,
			"car_type"			=> $car_type,
			"seats"				=> $num_seat,
			"status"			=> 0,
			"booking_key"		=> $key,
			"booking_date" 		=> date("Y-m-d H:i:s"),
			"paid_date" 		=> date("Y-m-d H:i:s"),
			"client_ip" 		=> $this->util->realIP(),
		);
		
		if ($this->m_service_booking->add($data)) {
		
			// Send mail to sales department
			$tpl_data = array(
				"GROUP_SIZE"		=> $group_size,
				"ARRIVAL_PORT"		=> $this->m_arrival_port->load($arrival_port)->short_name,
				"WELCOME_NAME"		=> $welcome_name,
				"FLIGHT_NUMBER"		=> $flight_number,
				"ARRIVAL_DATE"		=> date("M d, Y H:i A", strtotime($arrival_date)),
				"FULLNAME"			=> $fullname,
				"EMAIL"				=> $primary_email,
				"PHONE"				=> $phone_number,
				"SPECIAL_REQUEST"	=> $special_request,
				"PAYMENT_METHOD"	=> $payment,
				"TOTAL_FEE"			=> $total_fee,
				"FAST_CHECKIN"		=> $fast_track,
				"FAST_CHECKIN_FEE"	=> $fast_track_fee,
				"CAR_PICKUP"		=> $car_pickup,
				"CAR_FEE"			=> $car_pickup_fee,
				"CAR_TYPE"			=> $car_type,
				"SEATS"				=> $num_seat,
				"STATUS"			=> 0,
			);
			
			$message = $this->mail_booking_tpl->airport_service($tpl_data);
				
			// Send to SALE Department
			$mail = array(
	                            "subject"		=> "Application #".BOOKING_PREFIX_EX.$book_id.": Extra Service Booking from ".strtoupper($fullname),
								"from_sender"	=> $primary_email,
	                            "name_sender"	=> $fullname,
								"to_receiver"	=> MAIL_INFO,
	                            "message"		=> $message
			);
			$this->mail->config($mail);
			$this->mail->sendmail();
			
			// Send confirmation to SENDER
			$mail = array(
	                            "subject"		=> "Application #".BOOKING_PREFIX_EX.$book_id.": Extra Service Booking confirmation from ".SITE_NAME,
								"from_sender"	=> MAIL_INFO,
	                            "name_sender"	=> SITE_NAME,
								"to_receiver"	=> $primary_email,
	                            "message"		=> $message
			);
			$this->mail->config($mail);
			$this->mail->sendmail();
			
			if ($payment == 'OnePay')
			{
				//Redirect to OnePay
				$vpcURL = OP_PAYMENT_URL;
				
				$vpcOpt['Title']				= "Settle payment for Extra Service at ".SITE_NAME;
				$vpcOpt['AgainLink']			= urlencode($_SERVER['HTTP_REFERER']);
				$vpcOpt['vpc_Merchant']			= OP_MERCHANT;
				$vpcOpt['vpc_AccessCode']		= OP_ACCESSCODE;
				$vpcOpt['vpc_MerchTxnRef']		= $key;
				$vpcOpt['vpc_OrderInfo']		= BOOKING_PREFIX_EX.$book_id;
				$vpcOpt['vpc_Amount']			= $total_fee*100;
				$vpcOpt['vpc_ReturnURL']		= OP_RETURN_URL;
				$vpcOpt['vpc_Version']			= "2";
				$vpcOpt['vpc_Command']			= "pay";
				$vpcOpt['vpc_Locale']			= "en";
				$vpcOpt['vpc_TicketNo']			= $_SERVER['REMOTE_ADDR'];
				$vpcOpt['vpc_Customer_Email']	= $primary_email;
				
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
			else if($payment == 'Credit Card')
			{
				//Redirect to gate2shop
				$numberofitems = 1;
				$totalAmount   = $total_fee;
				$productName   = BOOKING_PREFIX_EX.$book_id.": Extra Service Booking from ".SITE_NAME;
				$productPrice  = $total_fee;
				$productNum    = 1;
				$datetime      = gmdate("Y-m-d H:i:s");
				
				// Cal checksum
				$checksum = md5(G2S_SECRET_KEY.G2S_MERCHANT_ID.G2S_CURRENTCY.$totalAmount.$productName.$productPrice.$productNum.$datetime);
	
				$link  = 'https://secure.Gate2Shop.com/ppp/purchase.do?';
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
				$link .= '&customField2='.$primary_email;
				
				header('Location: '.$link);
				die();
			}
			else if($payment == 'Paypal')
			{
				$paymentAmount = $total_fee;
				$paymentType = "Sale";
				$itemName = BOOKING_PREFIX_EX.$book_id.": Extra Service Booking from ".SITE_NAME;
				$itemQuantity = 1;
				$itemPrice = $total_fee;
				$returnURL = PAYPAL_RETURN_URL."?key=".$key;
				$cancelURL = PAYPAL_CANCEL_URL."?key=".$key;
				
				$resArray = $this->paypal->CallShortcutExpressCheckout($paymentAmount, PAYPAL_CURRENCY, $paymentType, $itemName, $itemQuantity, $itemPrice, $returnURL, $cancelURL);
				$ack = strtoupper($resArray["ACK"]);
				$token = urldecode($resArray["TOKEN"]);
				if ($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") {
					$this->paypal->RedirectToPayPal($token);
				}
				else {
					header('Location: '.BASE_URL."/booking/payment-failure.html?key=".$key);
					die();
				}
			}
		}
	}
	
	function payment_success($key="")
	{
		if (empty($key)) {
			$key = !empty($_GET["key"]) ? $_GET["key"] : "";
		}
		
		if (!empty($key)) {
			$key = str_ireplace(".html", "", $key);
		}
		
		$booking = $this->m_service_booking->booking(NULL, $key);
		if ($booking != null) {
			if ($booking->status) {
				redirect(BASE_URL);
				die();
			}
		}
		
		$booking = $this->m_service_booking->booking(NULL, $key);
		if ($booking != null)
		{
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$fc_type = 'fc';
			if ($booking->fast_checkin == 2) {
				$fc_type = 'vip_fc';
			}
			$agents_id = 1;
			$min_fee = 100000;
			$arr_agents = $this->m_agents->items();
			foreach ($arr_agents as $arr_agent) {
				$arr_port_pickup = explode(',',$arr_agent->arr_port_pickup);
				$total_fee = 0;
				$err = 0;
				$airport_id = $this->m_arrival_port->load_short_name($booking->arrival_port)->id;
				// add fast checkin fee
				if (in_array($booking->arrival_port, $arr_port_pickup)) {
					if (!empty($booking->fast_checkin)) {
						$info = new stdClass();
						$info->airport = $airport_id;
						$info->agents_id = $arr_agent->id;
						$agent_fast_checkin_fee = $this->m_agent_fast_checkin_fee->items($info);
						$total_fee += $agent_fast_checkin_fee[0]->{$fc_type};
						if (empty($agent_fast_checkin_fee[0]->{$fc_type})) {
							$err++;
						}
					}
					// add car fee
					if (!empty($booking->car_pickup)) {
						$seats = "seat_{$booking->seats}";
						$info = new stdClass();
						$info->airport = $airport_id;
						$info->agents_id = $arr_agent->id;
						$agent_car_fee = $this->m_agent_car_fee->items($info);
						$total_fee += $agent_car_fee[0]->{$seats};
						if (empty($agent_car_fee[0]->{$seats})) {
							$err++;
						}
					}
					// add total fee
					if ($total_fee < $min_fee) {
						if ($err == 0) {
							$min_fee = $total_fee;
							$agents_id = $arr_agent->id;
						}
					}
				}
			}
			$data  = array(
				'status' => 1,
				'agents_id' => $agents_id,
				'paid_date' => date("Y-m-d H:i:s")
			);
			$where = array( 'booking_key' => $key );
			$this->m_service_booking->update($data, $where);
			// Send mail to sales department
			$tpl_data = array(
				"GROUP_SIZE"		=> $booking->group_size,
				"ARRIVAL_PORT"		=> $booking->arrival_port,
				"WELCOME_NAME"		=> $booking->welcome_name,
				"FLIGHT_NUMBER"		=> $booking->flight_number,
				"ARRIVAL_DATE"		=> date("M d, Y H:i A", strtotime($booking->arrival_date)),
				"FULLNAME"			=> $booking->contact_name,
				"EMAIL"				=> $booking->primary_email,
				"PHONE"				=> $booking->phone,
				"SPECIAL_REQUEST"	=> $booking->special_request,
				"PAYMENT_METHOD"	=> $booking->payment_method,
				"TOTAL_FEE"			=> $booking->total_fee,
				"FAST_CHECKIN"		=> $booking->fast_checkin,
				"FAST_CHECKIN_FEE"	=> $booking->fast_checkin_fee,
				"CAR_PICKUP"		=> $booking->car_pickup,
				"CAR_FEE"			=> $booking->car_fee,
				"CAR_TYPE"			=> $booking->car_type,
				"SEATS"				=> $booking->seats,
				"STATUS"			=> $booking->status,
			);
			
			$subject = "Application #".BOOKING_PREFIX_EX.$booking->id.": Confirm Extra Service ".$booking->payment_method." Successful";
			
			$message = $this->mail_booking_tpl->airport_service($tpl_data);
			
			// Send to SALE Department
			$mail = array(
	                            "subject"		=> $subject,
								"from_sender"	=> $booking->primary_email,
	                            "name_sender"	=> $booking->contact_name,
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
			
			$view_data = array();
			$view_data['client_name'] = $booking->contact_name;
			$view_data['total_fee']   = $booking->total_fee;
			
			$tmpl_content = array();
			$tmpl_content['content']  = $this->load->view("booking/payment_successful", $view_data, TRUE);
			$this->load->view('layout/view', $tmpl_content);
		}
		else {
			redirect("services");
		}
	}
	
	function payment_failure($key="")
	{
		if (empty($key)) {
			$key = !empty($_GET["key"]) ? $_GET["key"] : "";
		}
		
		if (!empty($key)) {
			$key = str_ireplace(".html", "", $key);
		}
		
		$errMsg = "";
		
		if (!empty($key))
		{
			$booking = $this->m_service_booking->booking(NULL, $key);
			if ($booking != null) {
				// Send mail to sales department
				$tpl_data = array(
					"GROUP_SIZE"		=> $booking->group_size,
					"ARRIVAL_PORT"		=> $booking->arrival_port,
					"WELCOME_NAME"		=> $booking->welcome_name,
					"FLIGHT_NUMBER"		=> $booking->flight_number,
					"ARRIVAL_DATE"		=> date("M d, Y H:i A", strtotime($booking->arrival_date)),
					"FULLNAME"			=> $booking->contact_name,
					"EMAIL"				=> $booking->primary_email,
					"PHONE"				=> $booking->phone,
					"SPECIAL_REQUEST"	=> $booking->special_request,
					"PAYMENT_METHOD"	=> $booking->payment_method,
					"TOTAL_FEE"			=> $booking->total_fee,
					"FAST_CHECKIN"		=> $booking->fast_checkin,
					"FAST_CHECKIN_FEE"	=> $booking->fast_checkin_fee,
					"CAR_PICKUP"		=> $booking->car_pickup,
					"CAR_FEE"			=> $booking->car_fee,
					"CAR_TYPE"			=> $booking->car_type,
					"SEATS"				=> $booking->seats,
					"STATUS"			=> $booking->status,
				);
				
				$subject = "Application #".BOOKING_PREFIX_EX.$booking->id.": Confirm Extra Service ".$booking->payment_method." Failure";
				
				$message = $this->mail_booking_tpl->airport_service($tpl_data);
				
				// Send to SALE Department
				$mail = array(
		                            "subject"		=> $subject,
									"from_sender"	=> $booking->primary_email,
		                            "name_sender"	=> $booking->contact_name,
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
				
				$view_data = array();
				$view_data['client_name'] = $booking->contact_name;
				
				$tmpl_content = array();
				$tmpl_content['content']   = $this->load->view("booking/payment_cancel", $view_data, TRUE);
				$this->load->view('layout/view', $tmpl_content);
			}
			else {
				redirect("services");
			}
		}
		else {
			redirect("services");
		}
	}
}

?>