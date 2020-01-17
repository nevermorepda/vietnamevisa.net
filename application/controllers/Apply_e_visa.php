<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apply_e_visa extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$key = "";
		$paymentOk = false;
		
		// OnePay
		if (isset($_GET["vpc_TxnResponseCode"]))
		{
			$vpc_Txn_Secure_Hash = $_GET["vpc_SecureHash"];
			$vpc_MerchTxnRef = $_GET["vpc_MerchTxnRef"];
			$vpc_AcqResponseCode = $_GET["vpc_AcqResponseCode"];
			unset($_GET["vpc_SecureHash"]);
			
			$key = $vpc_MerchTxnRef;
			
			// set a flag to indicate if hash has been validated
			$errorExists = false;
			
			if (strlen(OP_SECURE_SECRET) > 0 && $_GET["vpc_TxnResponseCode"] != "7" && $_GET["vpc_TxnResponseCode"] != "No Value Returned")
			{
			    ksort($_GET);
			    
			    $md5HashData = "";
			    
			    // sort all the incoming vpc response fields and leave out any with no value
			    foreach ($_GET as $k => $v) {
			        if ($k != "vpc_SecureHash" && (strlen($v) > 0) && ((substr($k, 0,4)=="vpc_") || (substr($k,0,5) =="user_"))) {
					    $md5HashData .= $k . "=" . $v . "&";
					}
			    }
			    
			    $md5HashData = rtrim($md5HashData, "&");
			
				if (strtoupper($vpc_Txn_Secure_Hash) == strtoupper(hash_hmac("SHA256", $md5HashData, pack("H*",OP_SECURE_SECRET)))) {
			        // Secure Hash validation succeeded, add a data field to be displayed later.
			        $hashValidated = "CORRECT";
			    } else {
			        // Secure Hash validation failed, add a data field to be displayed later.
			        $hashValidated = "INVALID HASH";
			    }
			} else {
			    // Secure Hash was not validated, add a data field to be displayed later.
			    $hashValidated = "INVALID HASH";
			}
			
			if($hashValidated=="CORRECT" && $_GET["vpc_TxnResponseCode"]=="0") {
				// Transaction successful
				$paymentOk = true;
			} else if ($hashValidated=="INVALID HASH" && $_GET["vpc_TxnResponseCode"]=="0") {
				// Transaction is pendding
				$paymentOk = false;
			} else {
				// Transaction is failed
				$paymentOk = false;
			}
		}
		// Paypal
		else if (isset($_GET["token"]))
		{
			$key = $_GET["key"];
			$token = $_GET["token"];
			
			$resArray = $this->paypal->GetShippingDetails($token);
			$ack = strtoupper($resArray["ACK"]);
			if ($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") {
				$resArray = $this->paypal->ConfirmPayment();
				$ack = strtoupper($resArray["ACK"]);
				if ($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") {
					$paymentOk = true;
				}
			}
		}
		
		if (!empty($key))
		{
			if ($paymentOk)
			{
				if (substr($key, 0, 3) == "po_") {
					header("Location: ".BASE_URL."/payment/success.html?key=".$key);
					die();
				} else if (substr($key, 0, 2) == "m_") {
					header("Location: ".BASE_URL."/member/payment-success.html?key=".$key);
					die();
				} else if (substr($key, 0, 3) == "ex_") {
					header("Location: ".BASE_URL."/booking/payment-success.html?key=".$key);
					die();
				} else {
					header("Location: ".BASE_URL."/apply-e-visa/success.html?key=".$key);
					die();
				}
			}
			else
			{
				if (substr($key, 0, 3) == "po_") {
					header("Location: ".BASE_URL."/payment/failure.html?key=".$key);
					die();
				} else if (substr($key, 0, 2) == "m_") {
					header("Location: ".BASE_URL."/member/payment-failure.html?key=".$key);
					die();
				} else if (substr($key, 0, 3) == "ex_") {
					header("Location: ".BASE_URL."/booking/payment-failure.html?key=".$key);
					die();
				} else {
					header("Location: ".BASE_URL."/apply-e-visa/failure.html?key=".$key);
					die();
				}
			}
		}
	}
	
	public function promotion($code="")
	{
		$this->prepare();
		
		$vev = $this->session->userdata("vev");
		
		if (!empty($code)) {
			$code = strtoupper(trim($code));
			$promotions = $this->m_promotion->available_items();
			if (!empty($promotions)) {
				foreach ($promotions as $promotion) {
					if (strtoupper($promotion->code) == $code) {
						$vev->promotion_code = $code;
						$vev->discount = $promotion->discount;
						$vev->discount_unit = $promotion->discount_unit;
						if ($vev->discount > 0) {
							$vev->vip_discount = 0;
						}
						$this->session->set_userdata("vev", $vev);
					}
				}
			}
		}
		
		$this->vev();
	}
	
	public function apply_code()
	{
		$visa_type = (!empty($_POST["visa_type"]) ? $_POST["visa_type"] : "");
		$processing_time = (!empty($_POST["processing_time"]) ? $_POST["processing_time"] : "Normal");
		$code = (!empty($_POST["code"]) ? $_POST["code"] : "");
		$result	= "";
		
		$vev = $this->session->userdata("vev");
		
		if (!empty($code)) {
			$code = strtoupper(trim($code));
			$promotions = $this->m_promotion->available_items();
			if (!empty($promotions)) {
				foreach ($promotions as $promotion) {
					if (strtoupper($promotion->code) == $code) {
						$vev->promotion_code = $code;
						$vev->discount = $promotion->discount;
						$vev->discount_unit = $promotion->discount_unit;
						if ($vev->discount > 0) {
							$vev->vip_discount = 0;
						}
						$this->session->set_userdata("vev", $vev);
						$result = $promotion->discount;
					}
				}
			}
		}
		echo $result;
	}
	
	public function vip()
	{
		$vip = $this->util->vip(0);
		if ($this->session->userdata("user")) {
			$vip = $this->util->vip($this->session->userdata("user")->vip_level);
		}
		return $vip;
	}
	
	public function prepare()
	{
		$this->session->unset_userdata("vev");
		
		$vev = new stdClass();
		$vev->booking_type_id			= 2;
		$vev->passport_holder			= "";
		$vev->visa_type					= "1ms";
		$vev->group_size				= 1;
		$vev->visit_purpose				= "";
		$vev->arrival_port				= 0;
		$vev->exit_port					= 0;
		$vev->processing_time			= "Normal";
		$vev->private_visa				= 0;
		$vev->full_package				= 0;
		$vev->full_package_fc_fee		= 0;
		$vev->full_package_total_fee	= 0;
		$vev->fast_checkin				= 0;
		$vev->car_pickup				= 0;
		// $vev->car_type					= "Economic Car";
		// $vev->num_seat					= 4;
		$vev->promotion_type			= "1ms";
		$vev->promotion_code			= "";
		$vev->member_discount			= !empty($this->util->level_account()) ? $this->util->level_account()[2] : 0 ;
		$vev->discount					= 0;
		$vev->discount_unit 			= "%";
		$vev->fullname[1]				= "";
		$vev->gender[1]					= "";
		$vev->birthdate[1]				= "";
		$vev->birthmonth[1]				= "";
		$vev->birthyear[1]				= "";
		$vev->nationality[1]			= "";
		$vev->passport[1]				= "";
		$vev->flight_booking			= 1;
		$vev->flightnumber				= "";
		$vev->arrivaltime				= "";
		$vev->arrivaldate				= "";
		$vev->exitdate					= "";
		$vev->contact_title				= "Mr";
		$vev->contact_fullname			= "";
		$vev->contact_email				= "";
		$vev->contact_email2			= "";
		$vev->contact_phone				= "";
		$vev->comment					= "";
		$vev->payment					= "";
		$vev->vip_discount				= $this->vip()->discount;
		
		$user = $this->session->userdata("user");
		if (!empty($user)) {
			$vev->contact_title		= $user->title;
			$vev->contact_fullname	= $user->user_fullname;
			$vev->contact_email		= $user->user_email;
			$vev->contact_phone		= $user->phone;
		}
		
		// Cal fees
		$visa_fee = $this->m_visa_fee->cal_visa_fee($vev->visa_type, $vev->group_size, $vev->processing_time, $vev->passport_holder, $vev->visit_purpose,null,$vev->booking_type_id);
		$vev->service_fee			= $visa_fee->service_fee;
		$vev->service_fee_discount	= 0;
		$vev->stamp_fee				= $visa_fee->stamp_fee;
		$vev->rush_fee				= $visa_fee->rush_fee;
		$vev->total_service_fee		= ($vev->service_fee * $vev->group_size);
		$vev->total_rush_fee		= ($vev->rush_fee * $vev->group_size);
		
		$vev->private_visa_fee		= 0;
		
		$vev->fast_checkin_fee		= 0;
		$vev->fast_checkin_total_fee= 0;
		
		$vev->car_fee				= 0;
		$vev->car_total_fee			= 0;
		
		$vev->total_fee = $vev->total_service_fee + $vev->total_rush_fee + $vev->private_visa_fee + $vev->fast_checkin_total_fee + $vev->car_total_fee;
		if ($vev->discount_unit == "USD") {
			$vev->total_fee = $vev->total_fee - $vev->discount;
		} else {
			$vev->total_fee = $vev->total_fee - round($vev->total_service_fee * $vev->discount/100);
		}
		$vev->total_fee = $vev->total_fee - round($vev->total_service_fee * $vev->vip_discount/100);
		$vev->total_fee = $vev->total_fee - round($vev->total_service_fee * $vev->service_fee_discount/100);
		
		$this->session->set_userdata("vev", $vev);
	}
	
	public function index()
	{
		$this->prepare();
		$this->step1();
	}
	
	function step1()
	{
		$vev = $this->session->userdata("vev");
		
		if ($vev == null) {
			$this->prepare();
		}
		
		$breadcrumb = array("Apply E-Visa" => site_url("apply-e-visa"), "1. Visa Options" => "");
		
		$view_data = array();
		$view_data["vev"] = $vev;
		$view_data["breadcrumb"] = $breadcrumb;
		
		$tmpl_content = array();
		$tmpl_content["meta"]["title"] = "Apply Vietnam Visa At The Official Site ".SITE_NAME;
		$tmpl_content["meta"]["description"] = "Apply Vietnam visa online using our secure online form at the official site of ".SITE_NAME.". Get visa approval letters in one working day only!";
		$tmpl_content["content"]   = $this->load->view("apply_vev/step1", $view_data, TRUE);
		$this->load->view("layout/main", $tmpl_content);
	}
	
	function ajax_cal_visa_types()
	{
		$nationality = (!empty($_POST["passport_holder"]) ? $_POST["passport_holder"] : "");
		
		$nation = $this->m_nation->search_by_name($nationality);
		
		$tourist_types  = $this->m_visa_fee->types_of_tourist($nation->id);
		$business_types = $this->m_visa_fee->types_of_business($nation->id);
		
		$visa_types = array();
		if (!empty($tourist_types)) {
			foreach ($tourist_types as $type) {
				$type = $this->util->getVisaType2String($type);
				if (!in_array($type, $visa_types)) {
					$visa_types[] = $type;
				}
			}
		}
		
		if (!empty($business_types)) {
			foreach ($business_types as $type) {
				$type = $this->util->getVisaType2String($type);
				if (!in_array($type, $visa_types)) {
					$visa_types[] = $type;
				}
			}
		}
		
		echo json_encode($visa_types);
	}
	
	function ajax_cal_visit_purposes()
	{
		$code_type = (!empty($_POST["visa_type"]) ? $_POST["visa_type"] : "");
		
		$visit_types = array();
		$visit_types[] = "";
		
		$visa_types = $this->m_visa_type->items(NULL, 1);
		$visit_purposes = $this->m_visit_purpose->items(NULL, 1);
		
		foreach ($visa_types as $visa_type) {
			if (strtoupper($visa_type->code) == strtoupper($code_type)) {
				foreach ($visit_purposes as $visit_purpose) {
					$purpose_type = $this->m_visit_purpose_types->search($visit_purpose->id, $visa_type->id);
					if (!empty($purpose_type)) {
						$visit_types[] = $visit_purpose->name;
					}
				}
			}
		}
		
		echo json_encode($visit_types);
	}
	
	function ajax_cal_service_fees()
	{
		$nationalities		= (!empty($_POST["nationalities"]) ? $_POST["nationalities"] : array());
		$passport_holder	= (!empty($_POST["passport_holder"]) ? $_POST["passport_holder"] : "");
		$booking_type_id	= (!empty($_POST["booking_type_id"]) ? $_POST["booking_type_id"] : 1);
		$group_size			= (!empty($_POST["group_size"]) ? $_POST["group_size"] : 0);
		$visa_type			= (!empty($_POST["visa_type"]) ? $_POST["visa_type"] : "1ms");
		$visit_purpose		= (!empty($_POST["visit_purpose"]) ? $_POST["visit_purpose"] : "");
		$arrival_port		= (!empty($_POST["arrival_port"]) ? $_POST["arrival_port"] : 0);
		$processing_time	= (!empty($_POST["processing_time"]) ? $_POST["processing_time"] : "Normal");
		$service_type		= (!empty($_POST["service_type"]) ? $_POST["service_type"] : 0);
		$car_type			= (!empty($_POST["car_type"]) ? $_POST["car_type"] : "Economic Car");
		$num_seat			= (!empty($_POST["num_seat"]) ? $_POST["num_seat"] : 0);
		
		$result = array();
		
		// Private letter
		$private_visa = $this->m_private_letter_fee->search(((stripos(strtolower($visit_purpose), "business") === false) ? "tourist_" : "business_").$visa_type);
		
		// FC
		$fast_checkin = $this->m_fast_checkin_fee->search($service_type, $arrival_port);
		
		// Car pick-up
		$car_pickup = $this->m_car_fee->search($num_seat, $arrival_port);
		
		// Visa service
		$visa_fee = $this->m_visa_fee->cal_visa_fee($visa_type, $group_size, $processing_time, $passport_holder, $visit_purpose,null, $booking_type_id);
		
		// Full package
		$full_package = $this->m_fast_checkin_fee->search(1, $arrival_port);
		
		$vev = $this->session->userdata("vev");
		if ($vev == null) {
			$this->prepare();
			$vev = $this->session->userdata("vev");
		}
		$visa_service_fee = array($private_visa, $full_package, $fast_checkin, $car_pickup, $visa_fee->service_fee, $visa_fee->rush_fee, $visa_fee->stamp_fee, $vev->discount, $vev->discount_unit, $vev->member_discount);

		////////////////////////////////////////////

		$nationality_group = array();
		foreach ($nationalities as $nationality) {
			if (array_key_exists($nationality, $nationality_group)) {
				$nationality_group[$nationality] = $nationality_group[$nationality] + 1;
			} else {
				$nationality_group[$nationality] = 1;
			}
		}
		
		$service_fee = 0;
		$service_fee_detail = "";
		$total_service_fee = 0;
		foreach ($nationality_group as $nationality => $count) {
			$visa_fee = $this->m_visa_fee->cal_visa_fee($visa_type, $group_size, $processing_time, $nationality, $visit_purpose,null,2);
			$service_fee += $visa_fee->service_fee * $count;
			$service_fee_detail .= '<div class="service-fee-item">';
			if (!empty($nationality)) {
				$service_fee_detail .= '<div class="text-right"><strong>'.$nationality.'</strong></div>';
			} else if (empty($nationality) && $count < sizeof($nationalities)) {
				$service_fee_detail .= '<div class="text-right"><strong>Other Nationality</strong></div>';
			}
			$service_fee_detail .= '<div class="price text-right">'.$visa_fee->service_fee.' USD x '.$count.' '.($count>1?"people":"person").' = '.($visa_fee->service_fee * $count).' USD</div>';
			$service_fee_detail .= '</div>';
			$total_service_fee += $visa_fee->service_fee * $count;
		}
		$service_fee = $service_fee . ' USD <i class="fa fa-chevron-circle-down"></i>';
		$nation_fee = array($service_fee, $service_fee_detail,$total_service_fee);

		$result = array($visa_service_fee,$nation_fee);
		echo json_encode($result);
	}
	
	function ajax_cal_service_fees_step2()
	{
		$nationalities		= (!empty($_POST["nationalities"]) ? $_POST["nationalities"] : array());
		$group_size			= (!empty($_POST["group_size"]) ? $_POST["group_size"] : 0);
		$visa_type			= (!empty($_POST["visa_type"]) ? $_POST["visa_type"] : "1ms");
		$visit_purpose		= (!empty($_POST["visit_purpose"]) ? $_POST["visit_purpose"] : "");
		$arrival_port		= (!empty($_POST["arrival_port"]) ? $_POST["arrival_port"] : 0);
		$processing_time	= (!empty($_POST["processing_time"]) ? $_POST["processing_time"] : "Normal");
		$private_visa		= (!empty($_POST["private_visa"]) ? $_POST["private_visa"] : 0);
		$full_package		= (!empty($_POST["full_package"]) ? $_POST["full_package"] : 0);
		$fast_checkin		= (!empty($_POST["fast_checkin"]) ? $_POST["fast_checkin"] : 0);
		$car_pickup			= (!empty($_POST["car_pickup"]) ? $_POST["car_pickup"] : 0);
		$car_type			= (!empty($_POST["car_type"]) ? $_POST["car_type"] : "Economic Car");
		$num_seat			= (!empty($_POST["num_seat"]) ? $_POST["num_seat"] : 0);

		$subtotal = 0;
		
		// Visa service
		$nationality_group = array();
		foreach ($nationalities as $nationality) {
			if (array_key_exists($nationality, $nationality_group)) {
				$nationality_group[$nationality] = $nationality_group[$nationality] + 1;
			} else {
				$nationality_group[$nationality] = 1;
			}
		}
		
		// Private letter
		$private_visa_fee = $this->m_private_letter_fee->search(((stripos(strtolower($visit_purpose), "business") === false) ? "tourist_" : "business_").$visa_type);
		if ($private_visa) {
			$subtotal += $private_visa_fee;
		}
		
		// // Full package
		// if ($full_package) {
		// 	$visa_fee = $this->m_visa_fee->cal_visa_fee($visa_type, $group_size, $processing_time, "", $visit_purpose);
		// 	$subtotal += $visa_fee->stamp_fee * $group_size;
			
		// 	$fast_checkin_fee = $this->m_fast_checkin_fee->search(1, $arrival_port);
		// 	$subtotal += $fast_checkin_fee * $group_size;
		// }
		
		$vev = $this->session->userdata("vev");
		if ($vev == null) {
			$this->prepare();
			$vev = $this->session->userdata("vev");
		}
		// Visa service
		$service_fee = 0;
		$total_visa_fee = 0;
		$stamp_fee = 0;
		foreach ($nationality_group as $nationality => $count) {
			$visa_fee = $this->m_visa_fee->cal_e_visa_fee($visa_type, $group_size, $processing_time, $nationality, $visit_purpose);
			$service_fee += $visa_fee->service_fee * $count;
			$stamp_fee += $visa_fee->stamp_fee;
			$total_visa_fee += ($visa_fee->service_fee + $visa_fee->rush_fee) * $count;
		}
		// // FC
		// $total_checkin_fee = 0;
		// $fast_checkin_fee = $this->m_fast_checkin_fee->search($fast_checkin, $arrival_port);
		// if ($fast_checkin) {
		// 	if (!empty($vev->discount_fast_track)) {
		// 		$total_checkin_fee = ($fast_checkin_fee * $group_size) * (1 - $vev->discount_fast_track/100);
		// 	} else {
		// 		$total_checkin_fee = $fast_checkin_fee * $group_size;
		// 	}
		// }
		// // Car pick-up
		// $total_car_pickup_fee = 0;
		// $car_pickup_fee = $this->m_car_fee->search($num_seat, $arrival_port);
		// if ($car_pickup) {
		// 	if (!empty($vev->discount_car_pickup)) {
		// 		$total_car_pickup_fee = $car_pickup_fee * (1 - $vev->discount_car_pickup/100);
		// 	} else {
		// 		$total_car_pickup_fee = $car_pickup_fee;
		// 	}
		// }
		
		if ($vev->discount_unit == "USD") {
			$subtotal = ($subtotal + $total_visa_fee + $stamp_fee) - $vev->discount;
		} else {
			$discount = ($vev->member_discount > $vev->discount) ? $vev->member_discount : $vev->discount ;
			$subtotal = ($subtotal + $total_visa_fee + $stamp_fee) - $service_fee * $discount/100;
		}
		
		echo json_encode(array(round($subtotal,2),$service_fee * $vev->discount/100,$vev->discount,$service_fee,$vev->member_discount));
	}
	
	function ajax_cal_service_fees_detail()
	{
		$nationalities		= (!empty($_POST["nationalities"]) ? $_POST["nationalities"] : array());
		$group_size			= (!empty($_POST["group_size"]) ? $_POST["group_size"] : 0);
		$visa_type			= (!empty($_POST["visa_type"]) ? $_POST["visa_type"] : "1ms");
		$visit_purpose		= (!empty($_POST["visit_purpose"]) ? $_POST["visit_purpose"] : "");
		$processing_time	= (!empty($_POST["processing_time"]) ? $_POST["processing_time"] : "Normal");
		
		$nationality_group = array();
		foreach ($nationalities as $nationality) {
			if (array_key_exists($nationality, $nationality_group)) {
				$nationality_group[$nationality] = $nationality_group[$nationality] + 1;
			} else {
				$nationality_group[$nationality] = 1;
			}
		}
		
		$service_fee = 0;
		$service_fee_detail = "";
		foreach ($nationality_group as $nationality => $count) {
			$visa_fee = $this->m_visa_fee->cal_visa_fee($visa_type, $group_size, $processing_time, $nationality, $visit_purpose,2);
			$service_fee += $visa_fee->service_fee * $count;
			$service_fee_detail .= '<div class="service-fee-item">';
			if (!empty($nationality)) {
				$service_fee_detail .= '<div class="text-right"><strong>'.$nationality.'</strong></div>';
			} else if (empty($nationality) && $count < sizeof($nationalities)) {
				$service_fee_detail .= '<div class="text-right"><strong>Other Nationality</strong></div>';
			}
			$service_fee_detail .= '<div class="price text-right">'.$visa_fee->service_fee.' USD x '.$count.' '.($count>1?"people":"person").' = '.($visa_fee->service_fee * $count).' USD</div>';
			$service_fee_detail .= '</div>';
		}
		$service_fee = $service_fee . ' USD <i class="fa fa-chevron-circle-down"></i>';
		$result = array($service_fee, $service_fee_detail);
		echo json_encode($result);
	}

	function check_valid_return($vev)
	{
		if (empty($vev->arrival_port)) {
			$this->session->set_flashdata("session-expired", "The Visa Application Form's session has been expired for some reasons! Please re-fill your information.");
			redirect(site_url($this->util->slug($this->router->fetch_class())));
		}
	}
	
	function step2()
	{
		$vev = $this->session->userdata("vev");

		if ($vev == null) {
			redirect(site_url("apply-e-visa"));
		}
		
		if (!empty($_POST))
		{
			$vev->passport_holder		= (!empty($_POST["passport_holder"]) ? $_POST["passport_holder"] : "");
			$vev->visa_type				= (!empty($_POST["visa_type"]) ? $_POST["visa_type"] : "1ms");
			$vev->group_size			= (!empty($_POST["group_size"]) ? $_POST["group_size"] : 1);
			$vev->visit_purpose			= (!empty($_POST["visit_purpose"]) ? $_POST["visit_purpose"] : "");
			if (!empty($_POST["arrivaldate"]) && !empty($_POST["arrivalmonth"]) && !empty($_POST["arrivalyear"])) {
				$vev->arrival_date		= $_POST["arrivalyear"].'-'.$_POST["arrivalmonth"].'-'.$_POST["arrivaldate"];
			} else {
				$vev->arrival_date = '';
			}

			$vev->exit_date				= (!empty($_POST["exit_date"]) ? $_POST["exit_date"] : "");
			$vev->arrival_port			= (!empty($_POST["arrival_port"]) ? $_POST["arrival_port"] : 0);
			$vev->exit_port				= (!empty($_POST["exit_port"]) ? $_POST["exit_port"] : 0);
			$vev->processing_time		= (!empty($_POST["processing_time"]) ? $_POST["processing_time"] : "Normal");
			
			// $vev->private_visa			= (!empty($_POST["private_visa"]) ? $_POST["private_visa"] : 0);
			// $vev->full_package			= (!empty($_POST["full_package"]) ? $_POST["full_package"] : 0);
			// $vev->fast_checkin			= (!empty($_POST["fast_checkin"]) ? $_POST["fast_checkin"] : (!empty($_POST["vip_fast_checkin"]) ? $_POST["vip_fast_checkin"] : 0));
			// $vev->car_pickup			= (!empty($_POST["car_pickup"]) ? $_POST["car_pickup"] : 0);
			// $vev->car_type				= (!empty($_POST["car_type"]) ? $_POST["car_type"] : "Economic Car");
			// $vev->num_seat				= (!empty($_POST["num_seat"]) ? $_POST["num_seat"] : 4);
			
			$vev->vip_discount			= $this->vip()->discount;
			
			if ($vev->visa_type == "6mm" || $vev->visa_type == "1ym") {
				$vev->discount = 0;
				$vev->vip_discount = 0;
			}
			else {
				// Reactive promotion code
				if (!empty($vev->promotion_code) && !$vev->discount) {
					$promotions = $this->m_promotion->available_items();
					if (!empty($promotions)) {
						foreach ($promotions as $promotion) {
							if (strtoupper($promotion->code) == $vev->promotion_code) {
								$vev->discount = $promotion->discount;
								$vev->discount_unit = $promotion->discount_unit;
							}
						}
					}
				}
			}
			
			if ($vev->discount > 0) {
				$vev->vip_discount = 0;
			}
			
			// RESET FIELDS
			for ($i=1; $i<=$vev->group_size; $i++) {
				$vev->fullname[$i]		= "";
				$vev->gender[$i]		= "";
				$vev->birthdate[$i]		= "";
				$vev->birthmonth[$i]	= "";
				$vev->birthyear[$i]		= "";
				$vev->nationality[$i]	= $vev->passport_holder;
				$vev->passport[$i]		= "";
			}

			$vev->flightnumber		= "";
			$vev->arrivaltime		= "";
			$vev->contact_title		= "Mr";
			$vev->contact_fullname	= "";
			$vev->contact_email		= "";
			$vev->contact_email2	= "";
			$vev->contact_phone		= "";
			$vev->comment			= "";
			$vev->payment			= "";
			
			//Cal fees
			$visa_fee = $this->m_visa_fee->cal_visa_fee($vev->visa_type, $vev->group_size, $vev->processing_time, $vev->passport_holder, $vev->visit_purpose,null,2);
			
			$vev->service_fee		= $visa_fee->service_fee;
			$vev->stamp_fee			= $visa_fee->stamp_fee;
			$vev->rush_fee			= $visa_fee->rush_fee;
			$vev->total_service_fee	= ($vev->service_fee * $vev->group_size);
			$vev->total_rush_fee	= ($vev->rush_fee * $vev->group_size);
			
			if ($vev->private_visa) {
				$vev->private_visa_fee = $this->m_private_letter_fee->search(((stripos(strtolower($vev->visit_purpose), "business") === false) ? "tourist_" : "business_").$vev->visa_type);
			} else {
				$vev->private_visa_fee = 0;
			}
			
			if ($vev->full_package) {
				$fast_checkin_fee = $this->m_fast_checkin_fee->search(1, $vev->arrival_port);
				$vev->full_package_fc_fee		= $fast_checkin_fee;
				$vev->full_package_total_fee	= ($vev->stamp_fee + $fast_checkin_fee) * $vev->group_size;
				$vev->service_fee_discount		= 0;
			} else {
				$vev->full_package_fc_fee		= 0;
				$vev->full_package_total_fee	= 0;
				$vev->service_fee_discount		= 0;
			}
			
			if ($vev->fast_checkin) {
				$fast_checkin_fee = $this->m_fast_checkin_fee->search($vev->fast_checkin, $vev->arrival_port);
				$vev->fast_checkin_fee			= $fast_checkin_fee;
				$vev->fast_checkin_total_fee	= $fast_checkin_fee * $vev->group_size;
			} else {
				$vev->fast_checkin_fee			= 0;
				$vev->fast_checkin_total_fee	= 0;
			}
			
			if ($vev->car_pickup) {
				$car_fee = $this->m_car_fee->search($vev->num_seat, $vev->arrival_port);
				$vev->car_fee		= $car_fee;
				$vev->car_total_fee	= $car_fee;
			} else {
				$vev->car_fee		= 0;
				$vev->car_total_fee	= 0;
			}
			
			$vev->total_fee = $vev->total_service_fee + $vev->total_rush_fee + $vev->private_visa_fee + $vev->full_package_total_fee + $vev->fast_checkin_total_fee + $vev->car_total_fee + ($vev->stamp_fee*$vev->group_size);
			if ($vev->discount_unit == "USD") {
				$vev->total_fee = $vev->total_fee - $vev->discount;
			} else {
				$vev->total_fee = $vev->total_fee - $vev->total_service_fee * $vev->discount/100;
			}
			$vev->total_fee = $vev->total_fee - $vev->total_service_fee * $vev->vip_discount/100;
			$vev->total_fee = $vev->total_fee - $vev->total_service_fee * $vev->service_fee_discount/100;
		}
		else {
			$this->check_valid_return($vev);
		}
		
		// Redirect from login form or step 1
		$user = $this->session->userdata("user");
		if (!empty($user)) {
			if (empty($vev->contact_title)) {
				$vev->contact_title = $user->title;
			}
			if (empty($vev->contact_fullname)) {
				$vev->contact_fullname = $user->user_fullname;
			}
			if (empty($vev->contact_email)) {
				$vev->contact_email = $user->user_email;
			}
			if (empty($vev->contact_phone)) {
				$vev->contact_phone = $user->phone;
			}
		}
		
		$vev->member_discount			= !empty($this->util->level_account()) ? $this->util->level_account()[2] : 0 ;
		// Final save
		$this->session->set_userdata("vev", $vev);

		// Require login
		$this->util->requireUserLogin("apply-e-visa/login");
		$check_step = new stdClass();
		$info = new stdClass();
		$info->email = $this->session->userdata('user')->user_email;
		$info->created_date = date('Y-m-d');
		$info->type = 2;
		$check_email = $this->m_check_step->items($info);
		if (empty($check_email)) {
			$check_step->id = date('Ymdhis');
			$data = array(
				"id"	=> $check_step->id,
				"email" => $this->session->userdata('user')->user_email,
				"fullname" => $this->session->userdata('user')->user_fullname,
				"type" => 2,
				"step1" => 1,
				"step2" => 1,
				"client_ip" => $this->util->realIP()
			);
			$this->m_check_step->add($data);
		} else {
			$check_step->id = $check_email[0]->id;
		}
		$this->session->set_userdata("check_step", $check_step);
		
		$breadcrumb = array("Apply Visa" => site_url("apply-e-visa"), "1. Visa Options" => site_url("apply-e-visa/step1"), "2. Applicant Details" => "");
		
		$view_data = array();
		$view_data["vev"] = $vev;
		$view_data["breadcrumb"] = $breadcrumb;
		
		$tmpl_content = array();
		$tmpl_content["meta"]["title"] = "Apply Vietnam Visa At The Official Site ".SITE_NAME;
		$tmpl_content["meta"]["description"] = "Apply Vietnam visa online using our secure online form at the official site of ".SITE_NAME.". Get visa approval letters in one working day only!";
		$tmpl_content["content"]   = $this->load->view("apply_vev/step2", $view_data, TRUE);
		$this->load->view("layout/main", $tmpl_content);
	}
	
	function dologout()
	{
		$vev = $this->session->userdata("vev");
		
		if ($vev == null) {
			redirect(site_url("{$this->util->slug($this->router->fetch_class())}"));
		}
		
		$this->session->set_userdata("user", NULL);
		
		redirect(site_url("{$this->util->slug($this->router->fetch_class())}/login"));
	}
	
	function login()
	{
		$vev = $this->session->userdata("vev");
		
		if ($vev == null) {
			redirect(site_url("{$this->util->slug($this->router->fetch_class())}"));
		}
		
		$breadcrumb = array('Apply E Visa' => site_url('apply-e-visa'), '1. Visa Options' => site_url('apply-e-visa/step1'), 'Member Login' => '');
		
		$this->session->set_userdata("return_url", site_url("apply-e-visa/step2"));
		
		$this->load->library('user_agent');
		$agent = 'Unidentified';
		if ($this->agent->is_browser()) {
			$agent = $this->agent->browser();
		}
		
		$view_data = array();
		$view_data["breadcrumb"] = $breadcrumb;
		$view_data["agent"] = $agent;
		
		$tmpl_content = array();
		$tmpl_content['meta']['title'] = "Apply Vietnam Visa At The Official Site ".SITE_NAME;
		$tmpl_content['meta']['description'] = "Apply Vietnam visa online using our secure online form at the official site of ".SITE_NAME.". Get visa approval letters in one working day only!";
		$tmpl_content['tabindex'] = "apply-e-visa";
		$tmpl_content['content'] = $this->load->view("apply_vev/login", $view_data, TRUE);
		$this->load->view('layout/main', $tmpl_content);
	}
	
	function dologin()
	{
		$vev = $this->session->userdata("vev");
		
		if ($vev == null) {
			redirect(site_url("{$this->util->slug($this->router->fetch_class())}"));
		}
		
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
			}
			else {
				$this->session->set_flashdata("status", "Invalid email or password.");
				redirect(site_url("{$this->util->slug($this->router->fetch_class())}/login"), "back");
			}
		}
		else if ($task == "register")
		{
			$new_title		= (!empty($_POST["new_title"]) ? $_POST["new_title"] : "");
			$new_fullname	= (!empty($_POST["new_fullname"]) ? $_POST["new_fullname"] : "");
			$new_email		= (!empty($_POST["new_email"]) ? $_POST["new_email"] : "");
			$new_password	= (!empty($_POST["new_password"]) ? $_POST["new_password"] : "");
			$new_phone		= (!empty($_POST["new_phone"]) ? $_POST["new_phone"] : "");
			
			$data->new_title = $new_title;
			$data->new_fullname = $new_fullname;
			$data->new_email = $new_email;
			$data->new_password = $new_password;
			$data->new_phone = $new_phone;
			$this->session->set_flashdata("login", $data);
			
			if (empty($new_fullname)) {
				$this->session->set_flashdata("status", "Full name is required.");
				redirect(BASE_URL_HTTPS."/apply-e-visa/login.html", "back");
			}
			else if (empty($new_email)) {
				$this->session->set_flashdata("status", "Email is required.");
				redirect(BASE_URL_HTTPS."/apply-e-visa/login.html", "back");
			}
			else if ($this->m_user->is_user_exist($new_email)) {
				$this->session->set_flashdata("status", "This email is already in used. Please input another email address.");
				redirect(BASE_URL_HTTPS."/apply-e-visa/login.html", "back");
			}
			else if (strlen($new_password) < 6) {
				$this->session->set_flashdata("status", "Password must be at least 6 characters long.");
				redirect(BASE_URL_HTTPS."/apply-e-visa/login.html", "back");
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
						"FULLNAME"	=> $user->user_fullname,
						"EMAIL"		=> $user->user_login,
						"PASSWORD"	=> $user->password_text,
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
					$this->session->set_flashdata("error", "Invalid email or password.");
					redirect(site_url("{$this->util->slug($this->router->fetch_class())}/login"), "back");
				}
			}
		}
		
		if ($user != null) {
			if (empty($vev->contact_title)) {
				$vev->contact_title = $user->title;
			}
			if (empty($vev->contact_fullname)) {
				$vev->contact_fullname = $user->user_fullname;
			}
			if (empty($vev->contact_email)) {
				$vev->contact_email = $user->user_email;
			}
			if (empty($vev->contact_phone)) {
				$vev->contact_phone = $user->phone;
			}
			
			// Re-calculate the total fee
			$vev->vip_discount = $this->vip()->discount;
			
			if ($vev->discount > 0) {
				$vev->vip_discount = 0;
			}
			
			if ($vev->visa_type == "6mm" || $vev->visa_type == "1ym") {
				$vev->vip_discount = 0;
			}
			
			$vev->total_fee = $vev->total_service_fee + $vev->total_rush_fee + $vev->business_visa_fee + $vev->private_visa_fee + $vev->full_package_total_fee + $vev->fast_checkin_total_fee + $vev->car_total_fee;
			if ($vev->discount_unit == "USD") {
				$vev->total_fee = $vev->total_fee - $vev->discount;
			} else {
				//$vev->total_fee = $vev->total_fee - $vev->total_service_fee * $vev->discount/100;
				$vev->total_fee = $vev->total_fee - round($vev->total_service_fee * $vev->discount/100);
			}
			//$vev->total_fee = $vev->total_fee - $vev->total_service_fee * $vev->vip_discount/100;
			$vev->total_fee = $vev->total_fee - round($vev->total_service_fee * $vev->vip_discount/100);
			
			$this->session->set_userdata("vev", $vev);
			
			redirect(site_url("apply-e-visa/step2"));
		}
	}
	
	function detect_holiday($arrivalmonth=NULL, $arrivaldate=NULL, $arrivalyear=NULL, $processing_time=NULL)
	{
		$isHoliday	= false;
		
		$currentDate = mktime(23, 59, 0, date("m"), date("d"), date("Y")); // Evening
		$next1Date	 = mktime(23, 59, 0, date("m"), date("d")+1, date("Y"));
		$next2Date	 = mktime(23, 59, 0, date("m"), date("d")+2, date("Y"));
		$next3Date	 = mktime(23, 59, 0, date("m"), date("d")+3, date("Y"));
		$arrivalDate = mktime(23, 59, 0, $arrivalmonth, $arrivaldate, $arrivalyear);
		
		if ($processing_time != "Holiday")
		{
			$frDate = mktime(23, 59, 0, 8, 31, 2018);
			$toDate = mktime(23, 59, 0, 9, 3, 2018);
			
			$crDate2 = mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"));
			$frDate2 = mktime(15, 0, 0, 8, 31, 2018);
			if ($crDate2 >= $frDate2 && $crDate2 <= $toDate) {
				if ($arrivalDate >= $frDate && $arrivalDate <= $toDate) {
					$isHoliday = true;
				}
			}
			if (!$isHoliday) {
				// If today is Friday afternoon
				if (date("w") == 5 && (date("H") >= 15 || (date("H") == 14 && date("i") >= 30))) {
					if (($arrivalDate >= $currentDate) && ($arrivalDate < $next3Date)) { // Saturday - Monday
						$isHoliday = true;
					}
				}
				// If today is Saturday
				else if (date("w") == 6) {
					if (($arrivalDate >= $currentDate) && ($arrivalDate < $next2Date)) { // Saturday - Monday
						$isHoliday = true;
					}
				}
				// If today is Sunday
				else if (date("w") == 0) {
					if (($arrivalDate >= $currentDate) && ($arrivalDate < $next1Date)) { // Sunday - Monday
						$isHoliday = true;
					}
				}
			}
		}
		
		return $isHoliday;
	}
	
	function ajax_detect_special_nationality()
	{
		$nationality = (!empty($_POST["nationality"]) ? $_POST["nationality"] : "");
		$nationality = $this->util->genTopicAlias($nationality);
		
		$fee = $this->m_visa_fees->load($nationality);
		
		if (!empty($fee)) {
			echo json_encode(array(TRUE, strtoupper($fee->nation)));
		} else {
			echo json_encode(array(FALSE));
		}
	}
	
	function ajax_detect_rush_case()
	{
		$arrival_month		= (!empty($_POST["arrival_month"]) ? $_POST["arrival_month"] : "");
		$arrival_date		= (!empty($_POST["arrival_date"]) ? $_POST["arrival_date"] : "");
		$arrival_year		= (!empty($_POST["arrival_year"]) ? $_POST["arrival_year"] : "");
		// $visit_purpose		= (!empty($_POST["visit_purpose"]) ? $_POST["visit_purpose"] : "");
		$day = (strtotime("{$arrival_year}-{$arrival_month}-{$arrival_date}") - strtotime(date("Y-m-d")))/86400;
		$working_day = 0;
		for ($i=1; $i <= $day; $i++) { 
			if (date('N',strtotime(" +{$i} days")) != 6 && date('N',strtotime(" +{$i} days")) != 7) {
				$working_day++;
			}
		}
		echo $working_day;
	}
	
	function ajax_detect_holiday()
	{
		$arrival_month		= (!empty($_POST["arrival_month"]) ? $_POST["arrival_month"] : "");
		$arrival_date		= (!empty($_POST["arrival_date"]) ? $_POST["arrival_date"] : "");
		$arrival_year		= (!empty($_POST["arrival_year"]) ? $_POST["arrival_year"] : "");
		$processing_time	= (!empty($_POST["processing_time"]) ? $_POST["processing_time"] : "");
		
		echo $this->detect_holiday($arrival_month, $arrival_date, $arrival_year, $processing_time);
	}
	
	function detect_emergency($arrivalmonth=NULL, $arrivaldate=NULL, $arrivalyear=NULL, $processing_time=NULL)
	{
		$isEmergency = false;
		
		$currentDate = mktime(23, 59, 0, date("m"), date("d"), date("Y")); // Evening
		$next1Date	 = mktime(23, 59, 0, date("m"), date("d")+1, date("Y"));
		$next2Date	 = mktime(23, 59, 0, date("m"), date("d")+2, date("Y"));
		$next3Date	 = mktime(23, 59, 0, date("m"), date("d")+3, date("Y"));
		$arrivalDate = mktime(23, 59, 0, $arrivalmonth, $arrivaldate, $arrivalyear);
		
		if ($processing_time != "Emergency" && $processing_time != "Holiday")
		{
			$frDate = mktime(23, 59, 0, 8, 31, 2018);
			$toDate = mktime(23, 59, 0, 9, 4, 2018);
			
			$crDate2 = mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"));
			$frDate2 = mktime(15, 0, 0, 8, 31, 2018);
			if ($crDate2 >= $frDate2 && $crDate2 <= $toDate) {
				if ($arrivalDate >= $frDate && $arrivalDate <= $toDate) {
					$isEmergency = true;
				}
			}
			if (!$isEmergency) {
				$arrivalDay = date("w", $arrivalDate);
				if ($currentDate == $arrivalDate || $next1Date == $arrivalDate) {
					$isEmergency = true;
				} else if ($arrivalDay == 6 && ($arrivalDate <= $next1Date)) { // Saturday
					$isEmergency = true;
				} else if ($arrivalDay == 0 && ($arrivalDate <= $next2Date)) { // Sunday
					$isEmergency = true;
				} else if ($arrivalDay == 1 && ($arrivalDate <= $next2Date || ($arrivalDate <= $next3Date && date("w") == 5 && date("H") >= 12))) { // Monday
					$isEmergency = true;
				}
			}
		}
		
		return $isEmergency;
	}
	
	function ajax_detect_emergency()
	{
		$arrival_month		= (!empty($_POST["arrival_month"]) ? $_POST["arrival_month"] : "");
		$arrival_date		= (!empty($_POST["arrival_date"]) ? $_POST["arrival_date"] : "");
		$arrival_year		= (!empty($_POST["arrival_year"]) ? $_POST["arrival_year"] : "");
		$processing_time	= (!empty($_POST["processing_time"]) ? $_POST["processing_time"] : "");
		
		echo $this->detect_emergency($arrival_month, $arrival_date, $arrival_year, $processing_time);
	}
	
	function step3()
	{

		$vev = $this->session->userdata("vev");


		if ($vev == null) {
			redirect(site_url("apply-e-visa"));
		}
		else {
			$this->check_valid_return($vev);
		}

		// Require login
		$this->util->requireUserLogin("apply-e-visa/login");

		if (!empty($_POST))
		{
			for ($i=1; $i<=$vev->group_size; $i++) {

				$allow_type = 'JPG|PNG|jpg|jpeg|png|pdf|PDF';
				$path = "/files/upload/image/passport_photo";
				
				$vev->fullname[$i]		= (!empty($_POST["fullname_{$i}"]) ? $_POST["fullname_{$i}"] : "");
				$vev->gender[$i]		= (!empty($_POST["gender_{$i}"]) ? $_POST["gender_{$i}"] : "");
				$vev->birthdate[$i]		= (!empty($_POST["birthdate_{$i}"]) ? $_POST["birthdate_{$i}"] : "");
				$vev->birthmonth[$i]	= (!empty($_POST["birthmonth_{$i}"]) ? $_POST["birthmonth_{$i}"] : "");
				$vev->birthyear[$i]		= (!empty($_POST["birthyear_{$i}"]) ? $_POST["birthyear_{$i}"] : "");
				$vev->nationality[$i]	= (!empty($_POST["nationality_{$i}"]) ? $_POST["nationality_{$i}"] : "");
				$vev->passport[$i]		= (!empty($_POST["passport_{$i}"]) ? $_POST["passport_{$i}"] : "");
				// $vev->passport_type[$i]	= (!empty($_POST["passport_type_{$i}"]) ? $_POST["passport_type_{$i}"] : "");
				$vev->expirydate[$i]	= (!empty($_POST["expirydate_{$i}"]) ? $_POST["expirydate_{$i}"] : "");
				$vev->expirymonth[$i]	= (!empty($_POST["expirymonth_{$i}"]) ? $_POST["expirymonth_{$i}"] : "");
				$vev->expiryyear[$i]	= (!empty($_POST["expiryyear_{$i}"]) ? $_POST["expiryyear_{$i}"] : "");
				// $vev->religion[$i]		= (!empty($_POST["religion_{$i}"]) ? $_POST["religion_{$i}"] : "");
				if (!empty($_FILES["passport_photo_{$i}"]["name"])) {
					$format_photo = explode('.', $_FILES["passport_photo_{$i}"]["name"]);
					$photo_name = $this->util->slug($format_photo[0]).'.'.$format_photo[1];
					$this->util->upload_file('.'.$path,"passport_photo_{$i}","",$allow_type,$photo_name);
					$vev->photo_path[$i]	= $path.'/'.$photo_name;
				}
				if (!empty($_FILES["passport_data_{$i}"]["name"])) {
					$format_data = explode('.', $_FILES["passport_data_{$i}"]["name"]);
					$data_name = $this->util->slug($format_data[0]).'.'.$format_data[1];
					$this->util->upload_file('.'.$path,"passport_data_{$i}","",$allow_type,$data_name);
					$vev->passport_path[$i]	= $path.'/'.$data_name;
				}

			}
			
			$vev->private_visa			= (!empty($_POST["private_visa"]) ? $_POST["private_visa"] : 0);
			$vev->full_package			= (!empty($_POST["full_package"]) ? $_POST["full_package"] : 0);
			$vev->fast_checkin			= (!empty($_POST["fast_checkin"]) ? $_POST["fast_checkin"] : (!empty($_POST["vip_fast_checkin"]) ? $_POST["vip_fast_checkin"] : 0));
			$vev->car_pickup			= (!empty($_POST["car_pickup"]) ? $_POST["car_pickup"] : 0);
			$vev->car_type				= (!empty($_POST["car_type"]) ? $_POST["car_type"] : "Economic Car");
			$vev->num_seat				= (!empty($_POST["num_seat"]) ? $_POST["num_seat"] : 4);
			
			$vev->flight_booking		= (!empty($_POST["flight_booking"]) ? $_POST["flight_booking"] : 0);
			if ($vev->flight_booking != 0) {
				$vev->flightnumber		= (!empty($_POST["flightnumber"]) ? $_POST["flightnumber"] : "");
				$vev->arrivaltime		= (!empty($_POST["arrivaltime"]) ? $_POST["arrivaltime"] : "");
			} else {
				$vev->flightnumber		= "";
				$vev->arrivaltime		= "";
			}
			
			$vev->contact_title		= (!empty($_POST["contact_title"]) ? $_POST["contact_title"] : "Mr");
			$vev->contact_fullname	= (!empty($_POST["contact_fullname"]) ? $_POST["contact_fullname"] : "");
			$vev->contact_email		= (!empty($_POST["contact_email"]) ? $_POST["contact_email"] : "");
			$vev->contact_email2	= (!empty($_POST["contact_email2"]) ? $_POST["contact_email2"] : "");
			$vev->contact_phone		= (!empty($_POST["contact_phone"]) ? $_POST["contact_phone"] : "");
			$vev->comment			= (!empty($_POST["comment"]) ? $_POST["comment"] : "");
			$vev->payment			= "";
			
			$vev->task				= (!empty($_POST["task"]) ? $_POST["task"] : "");
			$arrival_date = explode('-', $vev->arrival_date);
			// Double check holiday case

			$rush = $this->util->detect_rush_visa(date("m/d/Y", strtotime("{$arrival_date[1]}/{$arrival_date[2]}/{$arrival_date[0]}")), $vev->visa_type, $vev->visit_purpose);
			if ($rush == 3) {
				$vev->task = "Holiday";
			} else if ($rush == 2) {
				$vev->task = "Emergency";
			}
			
			if ($vev->task == "Holiday") {
				$vev->processing_time = "Holiday";
				$vev->full_package = 0;
				$vev->full_package_fc_fee = 0;
				$vev->full_package_total_fee = 0;
			}
			if ($vev->task == "Emergency") {
				$vev->processing_time = "Emergency";
			}
			
			$nationality_group = array();
			for ($i=1; $i<=$vev->group_size; $i++) {
				if (array_key_exists($vev->nationality[$i], $nationality_group)) {
					$nationality_group[$vev->nationality[$i]] = $nationality_group[$vev->nationality[$i]] + 1;
				} else {
					$nationality_group[$vev->nationality[$i]] = 1;
				}
			}
			
			//Cal fees
			$vev->total_service_fee = 0;
			$vev->total_rush_fee = 0;
			foreach ($nationality_group as $nationality => $count) {
				$visa_fee = $this->m_visa_fee->cal_visa_fee($vev->visa_type, $vev->group_size, $vev->processing_time, $nationality, $vev->visit_purpose,null,2);
				$vev->service_fee		= $visa_fee->service_fee;
				$vev->stamp_fee			= $visa_fee->stamp_fee;
				$vev->rush_fee			= $visa_fee->rush_fee;
				$vev->total_service_fee	+= ($visa_fee->service_fee * $count);
				$vev->total_rush_fee	+= ($visa_fee->rush_fee * $count);
			}
			
			// if ($vev->private_visa) {
			// 	$vev->private_visa_fee = $this->m_private_letter_fee->search(((stripos(strtolower($vev->visit_purpose), "business") === false) ? "tourist_" : "business_").$vev->visa_type);
			// } else {
			// 	$vev->private_visa_fee = 0;
			// }
			
			// if ($vev->full_package) {
			// 	$fast_checkin_fee = $this->m_fast_checkin_fee->search(1, $vev->arrival_port);
			// 	$vev->full_package_fc_fee		= $fast_checkin_fee;
			// 	$vev->full_package_total_fee	= ($vev->stamp_fee + $fast_checkin_fee) * $vev->group_size;
			// 	$vev->service_fee_discount		= 0;
			// } else {
			// 	$vev->full_package_fc_fee		= 0;
			// 	$vev->full_package_total_fee	= 0;
			// 	$vev->service_fee_discount		= 0;
			// }
			
			// if ($vev->fast_checkin) {
			// 	$fast_checkin_fee = $this->m_fast_checkin_fee->search($vev->fast_checkin, $vev->arrival_port);
			// 	$vev->fast_checkin_fee			= $fast_checkin_fee;
			// 	$vev->fast_checkin_total_fee	= $fast_checkin_fee * $vev->group_size;
			// } else {
			// 	$vev->fast_checkin_fee			= 0;
			// 	$vev->fast_checkin_total_fee	= 0;
			// }
			
			// if ($vev->car_pickup) {
			// 	$car_fee = $this->m_car_fee->search($vev->num_seat, $vev->arrival_port);
			// 	$vev->car_fee		= $car_fee;
			// 	$vev->car_total_fee	= $car_fee;
			// } else {
			// 	$vev->car_fee		= 0;
			// 	$vev->car_total_fee	= 0;
			// }
			
			$vev->total_fee = $vev->total_service_fee + $vev->total_rush_fee + $vev->stamp_fee*$vev->group_size;

			$discount = $vev->discount;
			if ($vev->discount_unit == "USD") {
				$vev->total_fee = $vev->total_fee - $vev->discount;
			} else {
				if ($vev->member_discount > $vev->discount)
				$discount = $vev->member_discount;
				$vev->total_fee = $vev->total_fee - round(($vev->total_service_fee * $discount/100),2);
			}
			// $vev->total_fee = $vev->total_fee - round($vev->total_service_fee * $vev->vip_discount/100);
			// $vev->total_fee = $vev->total_fee - round($vev->total_service_fee * $vev->service_fee_discount/100);
			$check_step = $this->session->userdata("check_step");
			$data_step = array(
				"step3" 	=> 1,
				"price" 	=> $vev->total_fee,
			);
			$this->m_check_step->update($data_step, array("id" => $check_step->id));

			$this->session->set_userdata("vev", $vev);
		}
		$breadcrumb = array("Apply Visa" => site_url("apply-e-visa"), "1. Visa Options" => site_url("apply-e-visa/step1"), "2. Applicant Details" => site_url("apply-e-visa/step2"), "3. Review & Payment" => "");
		
		$view_data = array();
		$view_data["vev"] = $vev;
		$view_data["breadcrumb"] = $breadcrumb;
		
		$tmpl_content = array();
		$tmpl_content["meta"]["title"] = "Apply Vietnam Visa At The Official Site ".SITE_NAME;
		$tmpl_content["meta"]["description"] = "Apply Vietnam visa online using our secure online form at the official site of ".SITE_NAME.". Get visa approval letters in one working day only!";
		$tmpl_content["content"]   = $this->load->view("apply_vev/step3", $view_data, TRUE);
		$this->load->view("layout/main", $tmpl_content);
	}
	
	function completed()
	{
		$vev = $this->session->userdata("vev");

		if ($vev == null) {
			redirect(site_url("apply-e-visa"));
		}
		else {
			$this->check_valid_return($vev);
		}

		// Require login
		$this->util->requireUserLogin("apply-e-visa/login");
		
		if (!empty($_POST))
		{
			$vev->payment = (!empty($_POST["payment"]) ? $_POST["payment"] : "");
			if (empty($vev->payment)) {
				$this->session->set_flashdata("error", "Please select an method of Payment.");
				redirect(site_url("apply-e-visa/step3"), "back");
			}
			$this->session->set_userdata("vev", $vev);
		}
		
		/*
		 * Save
		 */
		$user = $this->session->userdata("user");
		$succed  = true;
		$booking_id = "";
		
		// Return and try again
		$key = (!empty($_POST["key"]) ? $_POST["key"] : "");
		if (!empty($key)) {
			$booking = $this->m_visa_booking->booking(NULL, $key);
			if ($booking != null) {
				$booking_id = $booking->id;
				
				$data   = array("payment_method" => $vev->payment);
				$where  = array("booking_key" => $key);
				$this->m_visa_booking->update($data, $where);
				
				$paxs = array();
				
				for ($i=1; $i<=$vev->group_size; $i++) {
					$pax["booking_id"]	= $booking_id;
					$pax["fullname"]	= $vev->fullname[$i];
					$pax["gender"]		= $vev->gender[$i];
					$pax["birthday"]	= date("Y-m-d", strtotime($vev->birthmonth[$i]."/".$vev->birthdate[$i]."/".$vev->birthyear[$i]));
					$pax["nationality"]	= $vev->nationality[$i];
					$pax["passport"]	= $vev->passport[$i];
					$pax["passport_type"]	= $vev->passport_type[$i];
					$pax["expiry_date"]		= $vev->expiryyear[$i].'-'.$vev->expirymonth[$i].'-'.$vev->expirydate[$i];
					$pax["religion"]		= $vev->religion[$i];
					$pax["passport_photo"]	= $vev->photo_path[$i];
					$pax["passport_data"]	= $vev->passport_path[$i];
					
					$paxs[] = $pax;
				}
			}
		}
		
		if (empty($booking_id)) {
			// Get book id
			$booking_id = $this->m_visa_booking->get_next_value() + rand(2, 5);
			if ($booking_id < 5000) {
				$booking_id += 5000;
			}
			
			// Booking key
			$key = md5($booking_id.time());
			
			// Mobile detect
			$this->load->library("user_agent");
			
			$agent = "Unidentified";
			$platform = $this->agent->platform();
			
			if ($this->agent->is_mobile()) {
				$agent = "Mobile - ". $this->agent->mobile();
			}
			else if ($this->agent->is_browser()) {
				$agent = $this->agent->browser()." ".$this->agent->version();
			}
			else if ($this->agent->is_robot()) {
				$agent = $this->agent->robot();
			}
			
			// Cal capital
			$nationality_group = array();
			foreach ($vev->nationality as $nationality) {
				if (array_key_exists($nationality, $nationality_group)) {
					$nationality_group[$nationality] = $nationality_group[$nationality] + 1;
				} else {
					$nationality_group[$nationality] = 1;
				}
			}
			
			$vev->capital = 0;
			
			foreach ($nationality_group as $nationality => $count) {
				$visa_fee = $this->m_visa_fee->cal_e_visa_fee($vev->visa_type, $vev->group_size, $vev->processing_time, $nationality, $vev->visit_purpose);
				$vev->capital += $visa_fee->service_capital * $count;
				$vev->capital += $visa_fee->rush_capital * $count;
			}
			
			//if (in_array($arrival_port->category_id, array(2, 3))) {
			//	$vev->capital += ($vev->stamp_fee * $vev->group_size);
			//}
			if ($vev->private_visa) {
				$private_visa_fee = $this->m_private_letter_fee->search("capital_evisa_".((stripos(strtolower($vev->visit_purpose), "business") === false) ? "evisa_tourist_" : "evisa_business_").$vev->visa_type);
				$vev->capital += $private_visa_fee;
			}
			if ($vev->full_package) {
				$fast_checkin_fee = $this->m_fast_checkin_fee->search(1, $vev->arrival_port, 1);
				$vev->capital += ($vev->stamp_fee * $vev->group_size);
				$vev->capital += ($fast_checkin_fee * $vev->group_size);
			}
			
			if ($vev->fast_checkin) {
				$fast_checkin_fee = $this->m_fast_checkin_fee->search($vev->fast_checkin, $vev->arrival_port, 1);
				$vev->capital += ($fast_checkin_fee * $vev->group_size);
			}
			
			if ($vev->car_pickup) {
				$car_fee = $this->m_car_fee->search($vev->num_seat, $vev->arrival_port, 1);
				$vev->capital += $car_fee;
			}
			// Add to booking list
			$data = array(
				"id"					=> $booking_id,
				"order_ref"				=> $this->util->order_ref($booking_id),
				"booking_type_id"		=> $vev->booking_type_id,
				"booking_key"			=> $key,
				"visa_type"				=> $this->util->getVisaType2String($vev->visa_type),
				"group_size"			=> $vev->group_size,
				"visit_purpose" 		=> $vev->visit_purpose,
				"arrival_date"			=> date("Y-m-d", strtotime($vev->arrival_date)),
				"exit_date"				=> date("Y-m-d", strtotime($vev->exit_date)),
				"arrival_port"			=> $vev->arrival_port,
				"exit_port"				=> $vev->exit_port,
				"flight_number"			=> $vev->flightnumber,
				"arrival_time"			=> $vev->arrivaltime,
				"visa_fee"				=> $vev->service_fee,
				"visa_fee_discount"		=> $vev->service_fee_discount,
				"total_visa_fee"		=> $vev->total_service_fee,
				"stamp_fee"				=> $vev->stamp_fee,
				"rush_type"				=> ($vev->processing_time == "Urgent") ? 1 : (($vev->processing_time == "Emergency") ? 2 : (($vev->processing_time == "Holiday") ? 3 : (($vev->processing_time == "TET Holiday") ? 4 : 0))),
				"rush_fee"				=> $vev->rush_fee,
				"total_fee"				=> $vev->total_fee,
				"capital"				=> $vev->capital + ($vev->group_size * 25),
				"contact_title"			=> $vev->contact_title,
				"contact_fullname"		=> $vev->contact_fullname,
				'primary_email'			=> $vev->contact_email,
				"secondary_email"		=> $vev->contact_email2,
				"contact_phone"			=> $vev->contact_phone,
				"special_request"		=> $vev->comment,
				"payment_method" 		=> $vev->payment,
				"booking_date" 			=> date("Y-m-d H:i:s"),
				"paid_date" 			=> date("Y-m-d H:i:s"),
				"private_visa" 			=> $vev->private_visa,
				"private_visa_fee" 		=> $vev->private_visa_fee,
				"full_package"			=> $vev->full_package,
				"full_package_fc_fee"	=> $vev->full_package_fc_fee,
				"fast_checkin" 			=> $vev->fast_checkin,
				"fast_checkin_fee"		=> $vev->fast_checkin_total_fee,
				"car_pickup" 			=> $vev->car_pickup,
				"car_type" 				=> $vev->car_type,
				"seats" 				=> $vev->num_seat,
				"car_fee" 				=> $vev->car_total_fee,
				"promotion_code"		=> $vev->promotion_code,
				"discount"				=> $vev->discount,
				"discount_unit"			=> $vev->discount_unit,
				"vip_discount"			=> $vev->vip_discount,
				"user_id" 				=> !empty($user->id) ? $user->id : 1,
				"status" 				=> 0,
				"client_ip" 			=> $this->util->realIP(),
				"user_agent"			=> $agent,
				"platform"				=> $platform,
			);
			
			$paxs = array();

			if (!$this->m_visa_booking->add($data)) {
				$succed = false;
			} else {
				for ($i=1; $i<=$vev->group_size; $i++) {
					$pax["book_id"]			= $booking_id;
					$pax["fullname"]		= $vev->fullname[$i];
					$pax["gender"]			= $vev->gender[$i];
					$pax["birthday"]		= date("Y-m-d", strtotime($vev->birthmonth[$i]."/".$vev->birthdate[$i]."/".$vev->birthyear[$i]));
					$pax["nationality"]		= $vev->nationality[$i];
					$pax["passport"]		= $vev->passport[$i];
					// $pax["passport_type"]	= $vev->passport_type[$i];
					$pax["expiry_date"]		= $vev->expiryyear[$i].'-'.$vev->expirymonth[$i].'-'.$vev->expirydate[$i];
					// $pax["religion"]		= $vev->religion[$i];
					$pax["passport_photo"]	= $vev->photo_path[$i];
					$pax["passport_data"]	= $vev->passport_path[$i];
					
					if (!$this->m_visa_booking->add_traveller($pax)) {
						$succed = false;
					}
					else {
						$paxs[] = $pax;
					}
				}
			}
		}

		if ($succed)
		{
			// Get last updated booking
			$booking = $this->m_visa_booking->booking($booking_id);
			
			// Payment
			$payment = $vev->payment;
			
			$client_name = !empty($user->fullname) ? $user->fullname : $vev->contact_fullname;
			// Send mail
			$tpl_data = $this->mail_tpl->visa_data($booking);
			
			if ($vev->discount_unit == "USD") {
				$discount_fee = $vev->discount;
			} else {
				$discount_fee = round($vev->total_service_fee * $vev->discount/100);
			}
			
			if (in_array($payment, array("Credit Card", "Western Union", "Bank Transfer"))) {
				if ($vev->processing_time != "Normal") {
					$subject = "Application #".BOOKING_E_PREFIX.$booking_id.": Confirm ".$vev->processing_time."E-Visa for Vietnam ".$payment;
				} else {
					$subject = "Application #".BOOKING_E_PREFIX.$booking_id.": Confirm E-Visa for Vietnam ".$payment;
				}
			}
			else {
				if ($vev->processing_time != "Normal") {
					$subject = "Application #".BOOKING_E_PREFIX.$booking_id.": ".$vev->processing_time." E-Visa for Vietnam Remind ".$payment;
				} else {
					$subject = "Application #".BOOKING_E_PREFIX.$booking_id.": Visa for E-Vietnam Remind ".$payment;
				}
			}
			
			$vendor_subject = $subject;
			if ($vev->processing_time != "Normal") {
				$vendor_subject = "[".$vev->processing_time."] ".$subject;
			}
			
			$tpl_data["RECEIVER"] = MAIL_INFO;
			$messageToAdmin  = $this->mail_tpl->visa_payment_remind($tpl_data);
			
			$tpl_data["RECEIVER"] = $vev->contact_email;
			$messageToClient = $this->mail_tpl->visa_payment_remind($tpl_data);
			// Send to SALE Department
			$mail = array(
				"subject"		=> $vendor_subject." - ".$client_name,
				"from_sender"	=> $vev->contact_email,
				"name_sender"	=> $client_name,
				"to_receiver"	=> MAIL_INFO,
				"message"		=> $messageToAdmin
			);
			$this->mail->config($mail);
			$this->mail->sendmail();
			
			// Send confirmation to SENDER
			$mail = array(
				"subject"		=> $subject,
				"from_sender"	=> MAIL_INFO,
				"name_sender"	=> SITE_NAME,
				"to_receiver"	=> $vev->contact_email,
				"message"		=> $messageToClient
			);
			$this->mail->config($mail);
			$this->mail->sendmail();
			
			if ($payment == "OnePay")
			{
				$fields = array("agent" => "M_THEONE_VN");
				$fields["booking_id"] = $booking_id;
				$curl = curl_init("https://www.theonevietnam.com/cdn/cdn-evs/02.html");
				curl_setopt($curl, CURLOPT_TIMEOUT, 30);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
				curl_exec($curl);
				curl_close($curl);
				
				//Redirect to OnePay
				$vpcURL = OP_PAYMENT_URL;
				
				$vpcOpt["Title"]				= "Settle payment for Vietnam visa at ".SITE_NAME;
				$vpcOpt["AgainLink"]			= urlencode($_SERVER["HTTP_REFERER"]);
				$vpcOpt["vpc_Merchant"]			= OP_MERCHANT;
				$vpcOpt["vpc_AccessCode"]		= OP_ACCESSCODE;
				$vpcOpt["vpc_MerchTxnRef"]		= $key;
				$vpcOpt["vpc_OrderInfo"]		= $booking->order_ref;
				$vpcOpt["vpc_Amount"]			= $vev->total_fee*100;
				$vpcOpt["vpc_ReturnURL"]		= OP_E_RETURN_URL;
				$vpcOpt["vpc_Version"]			= "2";
				$vpcOpt["vpc_Command"]			= "pay";
				$vpcOpt["vpc_Locale"]			= "en";
				$vpcOpt["vpc_TicketNo"]			= $this->util->realIP();
				$vpcOpt["vpc_Customer_Email"]	= $vev->contact_email;
				$vpcOpt["vpc_Customer_Id"]		= $user->id;
				
				$md5HashData = "";
				
				ksort($vpcOpt);
				
				$appendAmp = 0;
				
				foreach($vpcOpt as $k => $v) {
					// create the md5 input and URL leaving out any fields that have no value
					if (strlen($v) > 0) {
						// this ensures the first paramter of the URL is preceded by the '?' char
						if ($appendAmp == 0) {
							$vpcURL .= urlencode($k) . "=" . urlencode($v);
							$appendAmp = 1;
						} else {
							$vpcURL .= "&" . urlencode($k) . "=" . urlencode($v);
						}
						if ((strlen($v) > 0) && ((substr($k, 0,4)=="vpc_") || (substr($k,0,5) =="user_"))) {
							$md5HashData .= $k . "=" . $v . "&";
						}
					}
				}
				
				$md5HashData = rtrim($md5HashData, "&");
				$md5HashData = strtoupper(hash_hmac("SHA256", $md5HashData, pack("H*",OP_SECURE_SECRET)));
				
				$vpcURL .= "&vpc_SecureHash=" . $md5HashData;
				
				header("Location: ".$vpcURL);
				die();
			}
			else if($payment == "Paypal")
			{
				$paymentAmount = $vev->total_fee;
				$paymentType = "Sale";
				$itemName = BOOKING_E_PREFIX.$booking_id.": ".$this->util->getVisaType2String($vev->visa_type);
				$itemQuantity = 1;
				$itemPrice = $vev->total_fee;
				$returnURL = PAYPAL_E_CANCEL_URL."?key=".$key;
				$cancelURL = PAYPAL_E_RETURN_URL."?key=".$key;
				
				$resArray = $this->paypal->CallShortcutExpressCheckout($paymentAmount, PAYPAL_CURRENCY, $paymentType, $itemName, $itemQuantity, $itemPrice, $returnURL, $cancelURL);
				$ack = strtoupper($resArray["ACK"]);
				$token = urldecode($resArray["TOKEN"]);
				if ($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") {
					$this->paypal->RedirectToPayPal($token);
				}
				else {
					header("Location: ".BASE_URL."/apply-e-visa/failure.html?key=".$key);
					die();
				}
			}
			else if (in_array($payment, array("Credit Card", "Western Union", "Bank Transfer")))
			{
				if ($this->session->userdata("user") && ($this->session->userdata("user")->id == 5056)) {
					header("Location: ".BASE_URL."/apply-e-visa/success.html?key=".$key);
					die();
				}
			}

			$check_step = $this->session->userdata("check_step");
			$data_step = array(
				"step4" 	=> 1,
				"booking_id" 	=> $booking->id,
			);
			$this->m_check_step->update($data_step, array("id" => $check_step->id));
		}
		
		$breadcrumb = array("Apply Visa" => site_url("apply-e-visa"), "1. Visa Options" => site_url("apply-e-visa/step1"), "2. Applicant Details" => site_url("apply-e-visa/step2"), "3. Review & Payment" => site_url("apply-e-visa/step3"), "Finish" => "");
		
		$view_data = array();
		$view_data["client_name"] = $client_name;
		$view_data["breadcrumb"] = $breadcrumb;
		
		$tmpl_content = array();
		$tmpl_content["meta"]["title"] = "Apply Vietnam Visa At The Official Site ".SITE_NAME;
		$tmpl_content["meta"]["description"] = "Apply Vietnam visa online using our secure online form at the official site of ".SITE_NAME.". Get visa approval letters in one working day only!";
		$tmpl_content["content"]   = $this->load->view("apply_vev/step4", $view_data, TRUE);
		$this->load->view("layout/main", $tmpl_content);
	}
	
	function finish()
	{
		redirect(BASE_URL, "location");
	}
	
	function paypal_success($key="")
	{
		$this->success($key);
	}
	
	function paypal_failure($key="")
	{
		$this->failure($key);
	}

	function success($key="")
	{
		if (empty($key)) {
			$key = !empty($_GET["key"]) ? $_GET["key"] : "";
		}
		
		if (!empty($key)) {
			$key = str_ireplace(".html", "", $key);
		}
		
		// Redirect if this booking is not found or succed
		$booking = $this->m_visa_booking->booking(NULL, $key);
		if ($booking == null || $booking->status)
		{
			redirect(BASE_URL);
			die();
		}
		// End redirect
		$data  = array(
			"status" => 1,
			"paid_date" => date("Y-m-d H:i:s")
		);
		$where = array("booking_key" => $key);
		
		$this->m_visa_booking->update($data, $where);

		$agents = $this->m_agents->items();

		$info = new stdClass();
		$info->id = $booking->id;
		$booking_pax = $this->m_visa_booking->get_visa_bookings($info);
		$c_booking_pax = count($booking_pax);
		////////////////////////////////////////////////////
		if (((date('Y-m-d',strtotime($booking->arrival_date)) >= date('Y-m-d',strtotime($booking->booking_date))) && (date('Y-m-d',strtotime($booking->arrival_date)) <= date('Y-m-d',strtotime("{$booking->booking_date} + 2days"))) && ($booking->fast_checkin == 1)) ||
			((date('Y-m-d',strtotime($booking->arrival_date)) >= date('Y-m-d',strtotime($booking->booking_date))) && (date('Y-m-d',strtotime($booking->arrival_date)) <= date('Y-m-d',strtotime("{$booking->booking_date} + 2days"))) && ($booking->car_pickup == 1)) ||
			((date('Y-m-d',strtotime($booking->arrival_date)) >= date('Y-m-d',strtotime($booking->booking_date))) && (date('Y-m-d',strtotime($booking->arrival_date)) <= date('Y-m-d',strtotime("{$booking->booking_date} + 2days"))) && ($booking->full_package == 1))){

			$arr_agents = array();
			$agents_id = 1;
			foreach ($agents as $agent) {
				$arr_port = explode(',',$agent->arr_port);
				$arr_port_pickup = explode(',',$agent->arr_port_pickup);
				$info = new stdClass();
				$info->agents_id = $agent->id;
				$info->send_approved = 1;
				$info->fromdate = date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), date('d'), date('Y')));
				$info->todate 	= date('Y-m-d H:i:s', mktime(date('H'), date('i'), 59, date('m'), date('d'), date('Y')));
				$paxs = $this->m_visa_booking->get_visa_bookings($info);
				$qty = $c_booking_pax + count($paxs);
				if ($booking->fast_checkin == 1 || $booking->car_pickup == 1 || $booking->full_package == 1) {
					if ($qty <= $agent->qty && in_array($booking->arrival_port, $arr_port_pickup) && in_array($booking->arrival_port, $arr_port))
						array_push($arr_agents, $agent);
					elseif (in_array($booking->arrival_port, $arr_port_pickup) && in_array($booking->arrival_port, $arr_port))
						$agents_id = $agent->id;
				} else {
					if ($qty <= $agent->qty && in_array($booking->arrival_port, $arr_port))
						array_push($arr_agents, $agent);
					elseif (in_array($booking->arrival_port, $arr_port))
						$agents_id = $agent->id;
				}
			}

			foreach ($booking_pax as $value) {
				$min_fee = 100000;
				$type = '';
				switch ($value->visit_purpose) {
					case 'For tourist':
						$type .= 'evisa_tourist_';
						break;
					case 'For business':
						$type .= 'evisa_business_';
						break;
				}
				switch ($value->booking_type_id) {
					case '1':
						$type .= '1ms';
						break;
					case '2':
						$type .= '1mm';
						break;
					case '3':
						$type .= '3ms';
						break;
					case '4':
						$type .= '3mm';
						break;
					case '5':
						$type .= '6mm';
						break;
					case '6':
						$type .= '1ym';
						break;
				}
				//
				switch ($value->rush_type) {
					case '0':
						$processing = '';
						break;
					case '1':
						if ($value->visit_purpose == 'For tourist')
							$processing = $type.'_4h';
						elseif ($value->visit_purpose == 'For business')
							$processing = $type.'_8h';
						break;
					case '2':
						$processing = $type.'_1h';
						break;
					case '3':
						$processing = $type.'_dng';
						break;
				}
				foreach ($arr_agents as $arr_agent) {
					$arr_port = explode(',',$arr_agent->arr_port);
					$total_fee = 0;
					$err = 0;
					// add visa fee
					$info = new stdClass();
					$info->nation_id = $value->nation_id;
					$info->agents_id = $arr_agent->id;
					$visa_fee = $this->m_agent_visa_fee->items($info);
					$total_fee += $visa_fee[0]->{$type};
					if (empty($visa_fee[0]->{$type})) {
						$err++;
					}
					// add processing fee
					if (!empty($processing)) {
						$processing_fee = $this->m_agent_processing_fee->item($arr_agent->id,$value->nation_type);
						$total_fee += $processing_fee->{$processing};
						if (empty($processing_fee->{$processing})) {
							$err++;
						}
					}
					// add private letter fee
					if (!empty($value->private_visa)) {
						$info = new stdClass();
						$info->agents_id = $arr_agent->id;
						$private_letter_fee = $this->m_agent_private_letter_fee->items($info);
						$total_fee += $private_letter_fee[0]->{$type};
						if (empty($private_letter_fee[0]->{$type})) {
							$err++;
						}
					}
					// add fast checkin fee
					if (!empty($value->full_package)) {
						$info = new stdClass();
						$info->airport = $value->airport_id;
						$info->agents_id = $arr_agent->id;
						$agent_fast_checkin_fee = $this->m_agent_fast_checkin_fee->items($info);
						$total_fee += $agent_fast_checkin_fee[0]->fc;
					} else {
						if (!empty($value->fast_checkin)) {
							$info = new stdClass();
							$info->airport = $value->airport_id;
							$info->agents_id = $arr_agent->id;
							$agent_fast_checkin_fee = $this->m_agent_fast_checkin_fee->items($info);
							$total_fee += $agent_fast_checkin_fee[0]->fc;
							if (empty($agent_fast_checkin_fee[0]->fc)) {
								$err++;
							}
						}
					}
					// add car fee
					if (!empty($value->car_pickup)) {
						$seats = "seat_{$value->seats}";
						$info = new stdClass();
						$info->airport = $value->airport_id;
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
				$this->m_visa_pax->update(array("agents_id"=> 4,"agents_fc_id"=> 4),array("id" => $value->pax_id));
			}
		} else {

			$arr_agents = array();
			$arr_agents_fc = array();
			$agents_id = 1;
			$agents_fc_id = 1;
			foreach ($agents as $agent) {
				$arr_port = explode(',',$agent->arr_port);
				$arr_port_pickup = explode(',',$agent->arr_port_pickup);
				$info = new stdClass();
				$info->agents_id = $agent->id;
				$info->send_approved = 1;
				$info->fromdate = date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), date('d'), date('Y')));
				$info->todate 	= date('Y-m-d H:i:s', mktime(date('H'), date('i'), 59, date('m'), date('d'), date('Y')));
				$paxs = $this->m_visa_booking->get_visa_bookings($info);
				$qty = $c_booking_pax + count($paxs);
				if ($booking->fast_checkin == 1 || $booking->car_pickup == 1 || $booking->full_package == 1) {
					if ($qty <= $agent->qty && in_array($booking->arrival_port, $arr_port_pickup) && in_array($booking->arrival_port, $arr_port))
						array_push($arr_agents, $agent);
					elseif (in_array($booking->arrival_port, $arr_port_pickup) && in_array($booking->arrival_port, $arr_port))
						$agents_id = $agent->id;
				} else {
					if ($qty <= $agent->qty && in_array($booking->arrival_port, $arr_port))
						array_push($arr_agents, $agent);
					elseif (in_array($booking->arrival_port, $arr_port))
						$agents_id = $agent->id;
				}
				//
				$info = new stdClass();
				$info->agents_id = $agent->id;
				$info->send_pickup = 1;
				$info->from_arrival_date = date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), date('d'), date('Y')));
				$info->to_arrival_date 	= date('Y-m-d H:i:s', mktime(date('H'), date('i'), 59, date('m',strtotime("+ 2days")), date('d',strtotime("+ 2days")), date('Y',strtotime("+ 2days"))));
				$fc_paxs = $this->m_visa_booking->get_visa_bookings($info);
				$qty_fc = $c_booking_pax + count($fc_paxs);
				if ($qty_fc <= $agent->qty_fc && in_array($booking->arrival_port, $arr_port_pickup))
					array_push($arr_agents_fc, $agent);
				elseif (in_array($booking->arrival_port, $arr_port_pickup))
					$arr_agents_fc = $agent->id;
			}
			foreach ($booking_pax as $value) {
				$min_fee = 100000;
				$min_fc_fee = 100000;
				$type = '';
				switch ($value->visit_purpose) {
					case 'For tourist':
						$type .= 'evisa_tourist_';
						break;
					case 'For business':
						$type .= 'evisa_business_';
						break;
				}
				switch ($value->visa_type) {
					case '1 month single':
						$type .= '1ms';
						break;
					case '1 month multiple':
						$type .= '1mm';
						break;
					case '3 months single':
						$type .= '3ms';
						break;
					case '3 months multiple':
						$type .= '3mm';
						break;
					case '6 months multiple':
						$type .= '6mm';
						break;
					case '1 year multiple':
						$type .= '1ym';
						break;
				}
				//
				switch ($value->rush_type) {
					case '0':
						$processing = '';
						break;
					case '1':
						if ($value->visit_purpose == 'For tourist')
							$processing = $type.'_4h';
						elseif ($value->visit_purpose == 'For business')
							$processing = $type.'_8h';
						break;
					case '2':
						$processing = $type.'_1h';
						break;
					case '3':
						$processing = $type.'_dng';
						break;
				}
				foreach ($arr_agents as $arr_agent) {
					$arr_port = explode(',',$arr_agent->arr_port);
					$total_fee = 0;
					$err = 0;
					// add visa fee
					$info = new stdClass();
					$info->nation_id = $value->nation_id;
					$info->agents_id = $arr_agent->id;
					$visa_fee = $this->m_agent_visa_fee->items($info);
					$total_fee += $visa_fee[0]->{$type};
					if (empty($visa_fee[0]->{$type})) {
						$err++;
					}
					// add processing fee
					if (!empty($processing)) {
						$processing_fee = $this->m_agent_processing_fee->item($arr_agent->id,$value->nation_type);
						$total_fee += $processing_fee->{$processing};
						if (empty($processing_fee->{$processing})) {
							$err++;
						}
					}
					// add private letter fee
					if (!empty($value->private_visa)) {
						$info = new stdClass();
						$info->agents_id = $arr_agent->id;
						$private_letter_fee = $this->m_agent_private_letter_fee->items($info);
						$total_fee += $private_letter_fee[0]->{$type};
						if (empty($private_letter_fee[0]->{$type})) {
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
				foreach ($arr_agents_fc as $arr_agent_fc) {
					$arr_port = explode(',',$arr_agent_fc->arr_port);
					$total_fc_fee = 0;
					$err = 0;
					// add fast checkin fee
					if (!empty($value->full_package)) {
						$info = new stdClass();
						$info->airport = $value->airport_id;
						$info->agents_id = $arr_agent_fc->id;
						$agent_fast_checkin_fee = $this->m_agent_fast_checkin_fee->items($info);
						$total_fc_fee += $agent_fast_checkin_fee[0]->fc;

					} else {
						if (!empty($value->fast_checkin)) {
							$info = new stdClass();
							$info->airport = $value->airport_id;
							$info->agents_id = $arr_agent_fc->id;
							$agent_fast_checkin_fee = $this->m_agent_fast_checkin_fee->items($info);
							$total_fc_fee += $agent_fast_checkin_fee[0]->fc;
							if (empty($agent_fast_checkin_fee[0]->fc)) {
								$err++;
							}
						}
					}
					// add car fee
					if (!empty($value->car_pickup)) {
						$seats = "seat_{$value->seats}";
						$info = new stdClass();
						$info->airport = $value->airport_id;
						$info->agents_id = $arr_agent_fc->id;
						$agent_car_fee = $this->m_agent_car_fee->items($info);
						$total_fc_fee += $agent_car_fee[0]->{$seats};
						if (empty($agent_car_fee[0]->{$seats})) {
							$err++;
						}
					}
					// add total fee
					if ($total_fc_fee < $min_fc_fee) {
						if ($err == 0) {
							$min_fc_fee = $total_fc_fee;
							$agents_fc_id = $arr_agent_fc->id;
						}
					}

				}
				$this->m_visa_pax->update(array("agents_id"=> 4,"agents_fc_id"=> 4),array("id" => $value->pax_id));
			}
		}
		////////////////////////////////////////////////////
		
		$client_name = "";
		$user = $this->m_user->load($booking->user_id);
		$this->m_user->update(array('amount' => $booking->total_fee+$user->amount), array('id' => $booking->user_id));
		$client_name = $user->user_fullname;

		// Send mail
		$tpl_data = $this->mail_tpl->visa_data($booking);

		$subject = "Application #".BOOKING_E_PREFIX.$booking->id.": Confirm E-Visa for Vietnam Successful (gate ".$booking->payment_method.")";
		
		$vendor_subject = $subject;
		if ($tpl_data["PROCESSING_TIME"] != "Normal") {
			$vendor_subject = "[".$tpl_data["PROCESSING_TIME"]."] ".$subject;
		}
		
		$tpl_data["RECEIVER"] = MAIL_INFO;
		$messageToAdmin  = $this->mail_tpl->visa_payment_successful($tpl_data);
		
		$tpl_data["RECEIVER"] = $booking->primary_email;
		$messageToClient = $this->mail_tpl->visa_payment_successful($tpl_data);

		// Send to SALE Department
		$mail = array(
			"subject"		=> $vendor_subject." - ".$client_name,
			"from_sender"	=> $booking->primary_email,
			"name_sender"	=> $client_name,
			"to_receiver"	=> MAIL_INFO,
			"message"		=> $messageToAdmin
		);
		$this->mail->config($mail);
		$this->mail->sendmail();
		
		// Send confirmation to SENDER
		$mail = array(
			"subject"		=> $subject,
			"from_sender"	=> MAIL_INFO,
			"name_sender"	=> SITE_NAME,
			"to_receiver"	=> $booking->primary_email,
			"message"		=> $messageToClient
		);
		$this->mail->config($mail);
		$this->mail->sendmail();

		$check_step = $this->session->userdata("check_step");
		$data_step = array(
			"status" 	=> 'paid',
			"send_mail" => 2,
		);
		$this->m_check_step->update($data_step, array("id" => $check_step->id));
		
		$breadcrumb = array("Apply Visa" => site_url("apply-e-visa"), "1. Visa Options" => site_url("apply-e-visa/step1"), "2. Applicant Details" => site_url("apply-e-visa/step2"), "3. Review & Payment" => site_url("apply-e-visa/step3"), "Apply Successful" => "");
		
		$total_fee = $booking->total_fee - (($booking->full_package) ? ($booking->stamp_fee * $booking->group_size) : 0);
		
		$view_data = array();
		$view_data["client_name"]	= $client_name;
		$view_data["total_fee"] 	= $total_fee;
		$view_data["key"]			= $key;
		$view_data["breadcrumb"]	= $breadcrumb;
		$view_data["transaction_id"]	= BOOKING_E_PREFIX.$booking->id;
		$view_data["transaction_fee"]	= $total_fee;
		$view_data["transaction_sku"]	= $booking->id;
		$view_data["transaction_name"]	= $booking->visa_type;
		$view_data["transaction_category"]	= ($booking->rush_type == 1) ? "Urgent" : (($booking->rush_type == 2) ? "Emergency" : (($booking->rush_type == 3) ? "Holiday" : (($booking->rush_type == 4) ? "TET Holiday" : "Normal")));
		$view_data["transaction_quantity"]	= $booking->group_size;
		
		$tmpl_content = array();
		$tmpl_content["transaction_id"]			= BOOKING_E_PREFIX.$booking->id;
		$tmpl_content["transaction_fee"]		= $total_fee;
		$tmpl_content["transaction_sku"]		= $booking->id;
		$tmpl_content["transaction_name"]		= $booking->visa_type;
		$tmpl_content["transaction_category"]	= ($booking->rush_type == 1) ? "Urgent" : (($booking->rush_type == 2) ? "Emergency" : (($booking->rush_type == 3) ? "Holiday" : (($booking->rush_type == 4) ? "TET Holiday" : "Normal")));
		$tmpl_content["transaction_quantity"]	= $booking->group_size;
		$tmpl_content["content"]  = $this->load->view("apply_vev/successful", $view_data, TRUE);
		$this->load->view("layout/main", $tmpl_content);
	}
	
	function failure($key="")
	{
		if (empty($key)) {
			$key = !empty($_GET["key"]) ? $_GET["key"] : "";
		}
		
		if (!empty($key)) {
			$key = str_ireplace(".html", "", $key);
		}
		
		$client_name = "";
		
		if (!empty($key))
		{
			$key = str_ireplace(".html", "", $key);
			
			// Redirect if this booking is not found or succed
			$booking = $this->m_visa_booking->booking(NULL, $key);
			if ($booking == null || $booking->status) {
				redirect(BASE_URL);
				die();
			}

			if ($booking != null)
			{
				// Change key for duplicated email
				$newkey = $key."_f";
				$data   = array( "booking_key" => $newkey );
				$where  = array( "booking_key" => $key );
				$this->m_visa_booking->update($data, $where);

				$user = $this->m_user->load($booking->user_id);
				$client_name = $user->fullname;

				// Send mail
				$tpl_data = $this->mail_tpl->visa_data($booking);

				$subject = "Application #".BOOKING_E_PREFIX.$booking->id.": Confirm Visa for Vietnam Failure (gate ".$booking->payment_method.")";
				
				$vendor_subject = $subject;
				if ($tpl_data["PROCESSING_TIME"] != "Normal") {
					$vendor_subject = "[".$tpl_data["PROCESSING_TIME"]."] ".$subject;
				}
				
				$tpl_data["RECEIVER"] = MAIL_INFO;
				$messageToAdmin  = $this->mail_tpl->visa_payment_failure($tpl_data);
				
				$tpl_data["RECEIVER"] = $booking->contact_email;
				$messageToClient = $this->mail_tpl->visa_payment_failure($tpl_data);
				
				// Send to SALE Department
				$mail = array(
					"subject"		=> $vendor_subject." - ".$client_name,
					"from_sender"	=> $booking->contact_email,
					"name_sender"	=> $client_name,
					"to_receiver"	=> MAIL_INFO,
					"message"		=> $messageToAdmin
				);
				$this->mail->config($mail);
				$this->mail->sendmail();
				
				// Send confirmation to SENDER
				$mail = array(
					"subject"		=> $subject,
					"from_sender"	=> MAIL_INFO,
					"name_sender"	=> SITE_NAME,
					"to_receiver"	=> $booking->contact_email,
					"message"		=> $messageToClient
				);
				$this->mail->config($mail);
				$this->mail->sendmail();
			}
		}
		
		$breadcrumb = array("Apply Visa" => site_url("apply-e-visa"), "1. Visa Options" => site_url("apply-e-visa/step1"), "2. Applicant Details" => site_url("apply-e-visa/step2"), "3. Review & Payment" => site_url("apply-e-visa/step3"), "Apply Failure" => "");
		
		$view_data = array();
		$view_data["client_name"] = $client_name;
		$view_data["key"] = $newkey;
		$view_data["breadcrumb"] = $breadcrumb;
		
		$tmpl_content = array();
		$tmpl_content["content"]   = $this->load->view("apply_vev/failure", $view_data, TRUE);
		$this->load->view("layout/main", $tmpl_content);
	}
}

?>
