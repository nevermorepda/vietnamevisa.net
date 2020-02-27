<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apply_visa extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$params = explode('/', current_url());
		
		$key = "";
		$paymentOk = false;
		
		// OnePay
		if (isset($_GET['vpc_TxnResponseCode']))
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
			
				if (strtoupper($vpc_Txn_Secure_Hash) == strtoupper(hash_hmac('SHA256', $md5HashData, pack('H*',OP_SECURE_SECRET)))) {
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
		// G2S
		else if (isset($_GET['customField1']))
		{
			$key = $_GET['customField1'];
			
			//Status, could be APPROVED, PENDING, DECLINED or ERROR
			$checksum = md5(urldecode(G2S_SECRET_KEY.$_GET['totalAmount'].$_GET['currency'].$_GET['responseTimeStamp'].$_GET['PPP_TransactionID'].$_GET['Status'].$_GET['productId']));
			
			if ($_GET['Status'] && $checksum === $_GET['advanceResponseChecksum']) {
				if ($_GET['Status'] == 'APPROVED') {
					$paymentOk = true;
				}
				else {
					$paymentOk = false;
				}
			}
			else {
				$paymentOk = false;
			}
		}
		// Paypal
		else if (isset($_GET['token']))
		{
			$key = $_GET['key'];
			$token = $_GET['token'];
			
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
				if (substr($key, 0 , 3) == "po_") {
					header('Location: '.BASE_URL."/payment-online/success.html?key=".$key);
					die();
				} else if (substr($key, 0 , 4) == "spo_") {
					header('Location: '.BASE_URL."/secured-payment-online/success.html?key=".$key);
					die();
				} else if (substr($key, 0 , 2) == "m_") {
					header('Location: '.BASE_URL."/member/payment-success.html?key=".$key);
					die();
				} else if (substr($key, 0 , 3) == "ex_") {
					header('Location: '.BASE_URL."/booking/payment-success.html?key=".$key);
					die();
				} else {
					header('Location: '.BASE_URL."/apply-visa/success.html?key=".$key);
					die();
				}
			}
			else
			{
				if (substr($key, 0 , 3) == "po_") {
					header('Location: '.BASE_URL."/payment-online/failure.html?key=".$key);
					die();
				} else if (substr($key, 0 , 4) == "spo_") {
					header('Location: '.BASE_URL."/secured-payment-online/failure.html?key=".$key);
					die();
				} else if (substr($key, 0 , 2) == "m_") {
					header('Location: '.BASE_URL."/member/payment-failure.html?key=".$key);
					die();
				} else if (substr($key, 0 , 3) == "ex_") {
					header('Location: '.BASE_URL."/booking/payment-failure.html?key=".$key);
					die();
				} else {
					header('Location: '.BASE_URL."/apply-visa/failure.html?key=".$key);
					die();
				}
			}
		}
	}
	
	public function promotion($code="")
	{
		$this->prepare();
		
		$step1 = $this->session->userdata("step1");
		
		if (!empty($code)) {
			$code = strtoupper(trim($code));
			$promotions = $this->m_promotion->available_items();
			if (!empty($promotions)) {
				foreach ($promotions as $promotion) {
					if (strtoupper($promotion->code) == $code) {
						$step1->promotion_code	= $code;
						$step1->discount		= $promotion->discount;
						$step1->discount_unit	= $promotion->discount_unit;
						if ($step1->discount > 0) {
							$step1->vip_discount = 0;
						}
						$this->session->set_userdata("step1", $step1);
						
						$promotion = new stdClass();
						$promotion->promotion_code = $step1->promotion_code;
						$promotion->discount = $step1->discount;
						$promotion->discount_unit = $step1->discount_unit;
						$this->session->set_userdata("promotion", $promotion);
						break;
					}
				}
			}
		}
		
		$this->step1();
	}
	
	public function apply_code()
	{
		$visa_type = (!empty($_POST["visa_type"]) ? $_POST["visa_type"] : "");
		$processing_time = (!empty($_POST["processing_time"]) ? $_POST["processing_time"] : "Normal");
		$code = (!empty($_POST["code"]) ? $_POST["code"] : "");
		$result	= "";
		
		$step1 = $this->session->userdata("step1");
		
		if (!empty($code)) {
			$code = strtoupper(trim($code));
			$promotions = $this->m_promotion->available_items();
			if (!empty($promotions)) {
				foreach ($promotions as $promotion) {
					if (strtoupper($promotion->code) == $code) {
						$step1->promotion_code	= $code;
						$step1->discount		= $promotion->discount;
						$step1->discount_unit	= $promotion->discount_unit;
						if ($step1->discount > 0) {
							$step1->vip_discount = 0;
						}
						$this->session->set_userdata("step1", $step1);
						
						$promotion = new stdClass();
						$promotion->promotion_code = $step1->promotion_code;
						$promotion->discount = $step1->discount;
						$promotion->discount_unit = $step1->discount_unit;
						$this->session->set_userdata("promotion", $promotion);
						
						$result = $promotion->discount;
						
						break;
					}
				}
			}
		}
		echo $result;
	}
	
	public function vip()
	{
		$vip = $this->util->vip(0);
		if ($this->session->userdata("logged_in")) {
			$vip = $this->util->vip($this->session->userdata("user")->vip_level);
		}
		return $vip;
	}
	
	public function prepare()
	{
		$this->session->unset_userdata("step1");
		$step1 = new stdClass();
		$step1->passport_holder			= "";
		$step1->visa_type				= "1ms";
		$step1->group_size				= 1;
		$step1->visit_purpose			= "";
		$step1->arrival_port			= "";
		$step1->exit_port				= 0;
		$step1->processing_time			= "Normal";
		$step1->private_visa			= 0;
		$step1->full_package			= 0;
		$step1->full_package_fc_fee		= 0;
		$step1->full_package_total_fee	= 0;
		$step1->fast_checkin			= 0;
		$step1->car_pickup				= 0;
		$step1->car_type				= "Economic Car";
		$step1->num_seat				= 4;
		$step1->car_plus_fee			= 0;
		$step1->car_distance			= 0;
		$step1->car_distance_default	= 0;
		$step1->car_destination			= "";
		$step1->promotion_type			= "1ms";
		$step1->promotion_code			= "";
		$step1->member_discount			= 0;
		$step1->discount				= 0;
		$step1->discount_unit			= "%";
		$step1->fullname[1]				= "";
		$step1->gender[1]				= "Male";
		$step1->birthdate[1]			= "";
		$step1->birthmonth[1]			= "";
		$step1->birthyear[1]			= "";
		$step1->nationality[1]			= "";
		$step1->passportnumber[1]		= "";
		$step1->flight_booking			= 1;
		$step1->flightnumber			= "";
		$step1->arrivaltime				= "";
		$step1->arrivaldate				= "";
		$step1->arrivalmonth			= "";
		$step1->arrivalyear				= "";
		$step1->exitdate				= "";
		$step1->exitmonth				= "";
		$step1->exityear				= "";
		$step1->contact_title			= "Mr";
		$step1->contact_fullname		= "";
		$step1->contact_email			= "";
		$step1->contact_email2			= "";
		$step1->contact_phone			= "";
		$step1->comment					= "";
		$step1->payment					= "";
		$step1->vip_discount			= $this->vip()->discount;
		
		$user = $this->session->userdata("user");
		if (!empty($user)) {
			$step1->contact_title		= $user->title;
			$step1->contact_fullname	= $user->user_fullname;
			$step1->contact_email		= $user->user_email;
			$step1->contact_phone		= $user->phone;
		}
		
		// Cal fees
		$visa_fee = $this->m_visa_fee->cal_visa_fee($step1->visa_type, $step1->group_size, $step1->processing_time, $step1->passport_holder, $step1->visit_purpose, $step1->arrival_port);
		$step1->service_fee				= $visa_fee->service_fee;
		$step1->stamp_fee				= $visa_fee->stamp_fee;
		$step1->rush_fee				= $visa_fee->rush_fee;
		$step1->total_service_fee		= ($step1->service_fee * $step1->group_size);
		$step1->total_rush_fee			= ($step1->rush_fee * $step1->group_size);
		
		$step1->business_visa_fee		= 0;
		$step1->private_visa_fee		= 0;
		
		$step1->fast_checkin_fee		= 0;
		$step1->fast_checkin_total_fee	= 0;
		
		$step1->car_fee					= 0;
		$step1->car_total_fee			= 0;
		
		$step1->total_fee = $step1->total_service_fee + $step1->total_rush_fee + $step1->business_visa_fee + $step1->private_visa_fee + $step1->fast_checkin_total_fee + $step1->car_total_fee;
		
		$promotion = $this->session->userdata("promotion");
		if (!empty($promotion)) {
			$step1->promotion_code = $promotion->promotion_code;
			$step1->discount = $promotion->discount;
			$step1->discount_unit = $promotion->discount_unit;
		}
		
		if ($step1->discount_unit == "USD") {
			$step1->total_fee = $step1->total_fee - $step1->discount;
		} else {
			// $step1->total_fee = $step1->total_fee - $step1->total_service_fee * $step1->discount/100;
			$step1->total_fee = $step1->total_fee - round($step1->total_service_fee * $step1->discount/100);
		}
		// $step1->total_fee = $step1->total_fee - $step1->total_service_fee * $step1->vip_discount/100;
		$step1->total_fee = $step1->total_fee - round($step1->total_service_fee * $step1->vip_discount/100);
		
		$this->session->set_userdata("step1", $step1);
	}
	
	public function index()
	{
		$this->prepare();
		$this->step1();
	}
	
	function step1()
	{
		$step1 = $this->session->userdata("step1");

		if ($step1 == null) {
			$this->prepare();
		}
		
		$breadcrumb = array('Apply Visa' => site_url('apply-visa'), '1. Visa Options' => '');
		
		$view_data = array();
		$view_data["step1"] = $step1;
		$view_data["breadcrumb"] = $breadcrumb;
		
		$tmpl_content = array();
		$tmpl_content['meta']['title'] = "Apply Vietnam Visa At The Official Site ".SITE_NAME;
		$tmpl_content['meta']['description'] = "Apply Vietnam visa online using our secure online form at the official site of ".SITE_NAME.". Get visa approval letters in one working day only!";
		$tmpl_content['tabindex'] = "apply-visa";
		$tmpl_content['content'] = $this->load->view("apply/step1", $view_data, TRUE);
		$this->load->view('layout/main', $tmpl_content);
	}
	
	function ajax_cal_visa_types()
	{
		$nationality = (!empty($_POST["passport_holder"]) ? $_POST["passport_holder"] : "");
		
		$nation = $this->m_country->search_by_name($nationality);
		$types_of_tourist = $this->m_visa_fee->types_of_tourist($nation->id);
		$types_of_business = $this->m_visa_fee->types_of_business($nation->id);
		
		$visa_types = array();
		if (!empty($types_of_tourist)) {
			foreach ($types_of_tourist as $type) {
				$visa_type = $this->m_visa_type->load($type);
				if (!in_array($visa_type->name, $visa_types)) {
					$visa_types[] = $visa_type->name;
				}
			}
		}
		
		if (!empty($types_of_business)) {
			foreach ($types_of_business as $type) {
				$visa_type = $this->m_visa_type->load($type);
				if (!in_array($visa_type->name, $visa_types)) {
					$visa_types[] = $visa_type->name;
				}
			}
		}
		
		echo json_encode($visa_types);
	}
	
	function ajax_cal_visit_purposes()
	{
		$nationality = (!empty($_POST["passport_holder"]) ? $_POST["passport_holder"] : "");
		
		$nation = $this->m_country->search_by_name($nationality);
		$tourist_visa_types = array();
		$business_visa_types = array();

		$nation_id = !empty($nation) ? $nation->id : 0;

		$visa_types = $this->m_visa_type->items(NULL, 1);
		$types_of_tourist = $this->m_visa_fee->types_of_tourist($nation_id);
		$types_of_business = $this->m_visa_fee->types_of_business($nation_id);
		
		foreach ($visa_types as $visa_type) {
			if (in_array($visa_type->code, $types_of_tourist)) {
				$purpose_type = $this->m_visit_purpose_types->search(1, $visa_type->id);
				if (!empty($purpose_type) && !in_array($visa_type->code, $tourist_visa_types)) {
					$tourist_visa_types[] = $visa_type->code;
				}
			}
			if (in_array($visa_type->code, $types_of_business)) {
				$purpose_type = $this->m_visit_purpose_types->search(2, $visa_type->id);
				if (!empty($purpose_type) && !in_array($visa_type->code, $business_visa_types)) {
					$business_visa_types[] = $visa_type->code;
				}
			}
		}
		
		$visa_type = (!empty($_POST["visa_type"]) ? $_POST["visa_type"] : "");
		
		$visit_types = array();
		$visit_types[] = "";
		if ($visa_type == 'e-1ms') {
			$visit_types[] = "For tourist";
			$visit_types[] = "For business";
		} else {
			if (!empty($tourist_visa_types) && in_array($visa_type, $tourist_visa_types)) {
				$visit_types[] = "For tourist";
			}
			if (!empty($business_visa_types) && in_array($visa_type, $business_visa_types)) {
				$visit_types[] = "For business";
			}
		}
		
		echo json_encode($visit_types);
	}
	
	function ajax_cal_service_fees()
	{
		$step1 = $this->session->userdata("step1");
		
		$passport_holder	= (!empty($_POST["passport_holder"]) ? $_POST["passport_holder"] : "");
		$group_size			= (!empty($_POST["group_size"]) ? $_POST["group_size"] : 0);
		$visa_type			= (!empty($_POST["visa_type"]) ? $_POST["visa_type"] : "1ms");
		$visit_purpose		= (!empty($_POST["visit_purpose"]) ? $_POST["visit_purpose"] : "");
		$arrival_port		= (!empty($_POST["arrival_port"]) ? $_POST["arrival_port"] : 0);
		$processing_time	= (!empty($_POST["processing_time"]) ? $_POST["processing_time"] : "Normal");
		$service_type		= (!empty($_POST["service_type"]) ? $_POST["service_type"] : 0);
		$car_type			= (!empty($_POST["car_type"]) ? $_POST["car_type"] : "");
		$num_seat			= (!empty($_POST["num_seat"]) ? $_POST["num_seat"] : 0);

		$private_visa = 0;
		$full_package = 0;
		$fast_checkin = 0;
		$car_pickup = 0;
		$booking_type_id = 2;

		$result = array();
		if ($visa_type != 'e-1ms') {
			// Private letter
			$private_visa = $this->m_private_letter_fee->search(((stripos(strtolower($visit_purpose), "business") === false) ? "tourist_" : "business_").$visa_type);
			
			// FC
			$fast_checkin = $this->m_fast_checkin_fee->search($service_type, $arrival_port);
			
			// Car pick-up
			$car_pickup = $this->m_car_fee->search($num_seat, $arrival_port);
			
			// Full package
			$full_package = $this->m_fast_checkin_fee->search(1, $arrival_port);

			$booking_type_id = 1;
		}
		// Visa service
		$visa_fee = $this->m_visa_fee->cal_visa_fee($visa_type, $group_size, $processing_time, $passport_holder, $visit_purpose, $arrival_port,$booking_type_id);
		
		$result = array($private_visa, $full_package, $fast_checkin, $car_pickup, $visa_fee->service_fee, $visa_fee->rush_fee, $visa_fee->stamp_fee, $step1->discount, $step1->discount_unit, $step1->member_discount);
		echo json_encode($result);
	}
	
	function check_valid_return($step1)
	{
		if (empty($step1->arrival_port)) {
			$this->session->set_flashdata("session-expired", "The Visa Application Form's session has been expired for some reasons! Please re-fill your information.");
			redirect(site_url("{$this->util->slug($this->router->fetch_class())}"));
		}
	}
	
	function step2()
	{
		$step1 = $this->session->userdata("step1");
		if ($step1 == null) {
			redirect(BASE_URL_HTTPS."/apply-visa.html");
		}
		
		///////////////////
		if (!empty($_POST))
		{
			// POST FROM STEP 1
			$step1->passport_holder	= (!empty($_POST["passport_holder"]) ? $_POST["passport_holder"] : "");
			$step1->visa_type		= (!empty($_POST["visa_type"]) ? $_POST["visa_type"] : "1ms");
			$step1->embassies		= (!empty($_POST["embassies"]) ? $_POST["embassies"] : "");
			$step1->group_size		= (!empty($_POST["group_size"]) ? $_POST["group_size"] : 1);
			$step1->visit_purpose	= (!empty($_POST["visit_purpose"]) ? $_POST["visit_purpose"] : "");
			$step1->arrival_port	= (!empty($_POST["arrival_port"]) ? $_POST["arrival_port"] : "");
			$step1->processing_time	= (!empty($_POST["processing_time"]) ? $_POST["processing_time"] : "Normal");
			
			$step1->private_visa	= (!empty($_POST["private_visa"]) ? $_POST["private_visa"] : 0);
			$step1->full_package	= (!empty($_POST["full_package"]) ? $_POST["full_package"] : 0);
			$step1->fast_checkin	= (!empty($_POST["fast_checkin"]) ? $_POST["fast_checkin"] : (!empty($_POST["vip_fast_checkin"]) ? $_POST["vip_fast_checkin"] : 0));
			$step1->car_pickup		= (!empty($_POST["car_pickup"]) ? $_POST["car_pickup"] : 0);
			$step1->car_type		= (!empty($_POST["car_type"]) ? $_POST["car_type"] : "Economic Car");
			$step1->num_seat		= (!empty($_POST["num_seat"]) ? $_POST["num_seat"] : 4);
			
			$num_seat = 24;
			if ($step1->group_size <= 4) {
				$num_seat = 4;
			} else if ($step1->group_size <= 7) {
				$num_seat = 7;
			} else if ($step1->group_size <= 16) {
				$num_seat = 16;
			}
			if ($step1->num_seat < $num_seat) {
				$step1->num_seat = $num_seat;
			}
			
			$step1->vip_discount	= $this->vip()->discount;
			
			if ($step1->visa_type == "6mm" || $step1->visa_type == "1ym") {
				$step1->discount = 0;
				$step1->vip_discount = 0;
			}
			else {
				// Reactive promotion code
				if (!empty($step1->promotion_code) && !$step1->discount) {
					$promotions = $this->m_promotion->available_items();
					if (!empty($promotions)) {
						foreach ($promotions as $promotion) {
							if (strtoupper($promotion->code) == $step1->promotion_code) {
								$step1->discount = $promotion->discount;
								$step1->discount_unit = $promotion->discount_unit;
							}
						}
					}
				}
			}
			
			if ($step1->discount > 0) {
				$step1->vip_discount = 0;
			}
			
			// RESET FIELDS
			for ($i=1; $i<=$step1->group_size; $i++) {
				$step1->fullname[$i]		= "";
				$step1->gender[$i]			= "Male";
				$step1->birthdate[$i]		= "";
				$step1->birthmonth[$i]		= "";
				$step1->birthyear[$i]		= "";
				$step1->nationality[$i]		= $step1->passport_holder;
				$step1->passportnumber[$i]	= "";
			}
			
			$step1->arrivaldate			= (!empty($_POST["arrivaldate"]) ? $_POST["arrivaldate"] : "");
			$step1->arrivalmonth		= (!empty($_POST["arrivalmonth"]) ? $_POST["arrivalmonth"] : "");
			$step1->arrivalyear			= (!empty($_POST["arrivalyear"]) ? $_POST["arrivalyear"] : "");
			$step1->flightnumber		= "";
			$step1->arrivaltime			= "";
			$step1->contact_title		= "Mr";
			$step1->contact_fullname	= "";
			$step1->contact_email		= "";
			$step1->contact_email2		= "";
			$step1->contact_phone		= "";
			$step1->comment				= "";
			$step1->payment				= "";
			
			// Double check holiday case
			$rush = $this->util->detect_rush_visa(date("m/d/Y", strtotime($step1->arrivalmonth."/".$step1->arrivaldate."/".$step1->arrivalyear)), $step1->visa_type, $step1->visit_purpose);
			if ($rush == 3) {
				$step1->processing_time	= "Holiday";
				$step1->full_package = 0;
				$step1->full_package_fc_fee = 0;
				$step1->full_package_total_fee = 0;
			} else if ($rush == 2) {
				$step1->processing_time	= "Emergency";
			}
			
			//Cal fees
			$visa_fee = $this->m_visa_fee->cal_visa_fee($step1->visa_type, $step1->group_size, $step1->processing_time, $step1->passport_holder, $step1->visit_purpose, $step1->arrival_port);
			
			$step1->service_fee			= $visa_fee->service_fee;
			$step1->stamp_fee			= $visa_fee->stamp_fee;
			$step1->rush_fee			= $visa_fee->rush_fee;
			$step1->total_service_fee	= ($step1->service_fee * $step1->group_size);
			$step1->total_rush_fee		= ($step1->rush_fee * $step1->group_size);
			
			$private_visa_fee = $this->m_private_letter_fee->search(((stripos(strtolower($step1->visit_purpose), "business") === false) ? "tourist_" : "business_").$step1->visa_type);
			if ($step1->private_visa) {
				$step1->private_visa_fee = $private_visa_fee;
			} else {
				$step1->private_visa_fee = 0;
			}
			
			if ($step1->full_package) {
				$fast_checkin_fee = $this->m_fast_checkin_fee->search(1, $step1->arrival_port);
				$step1->full_package_fc_fee		= $fast_checkin_fee;
				$step1->full_package_total_fee	= ($step1->stamp_fee + $fast_checkin_fee) * $step1->group_size;
			} else {
				$step1->full_package_fc_fee		= 0;
				$step1->full_package_total_fee	= 0;
			}
			
			if ($step1->fast_checkin) {
				$fast_checkin_fee = $this->m_fast_checkin_fee->search($step1->fast_checkin, $step1->arrival_port);
				$step1->fast_checkin_fee		= $fast_checkin_fee;
				$step1->fast_checkin_total_fee	= $fast_checkin_fee * $step1->group_size;
			} else {
				$step1->fast_checkin_fee		= 0;
				$step1->fast_checkin_total_fee	= 0;
			}
			
			if ($step1->car_pickup) {
				$car_pickup_fee = $this->m_car_fee->search($step1->num_seat, $step1->arrival_port);
				$step1->car_fee			= $car_pickup_fee;
				$step1->car_total_fee	= $car_pickup_fee;
			} else {
				$step1->car_fee			= 0;
				$step1->car_total_fee	= 0;
			}
			
			$step1->total_fee = $step1->total_service_fee + $step1->total_rush_fee + $step1->business_visa_fee + $step1->private_visa_fee + $step1->full_package_total_fee + $step1->fast_checkin_total_fee + $step1->car_total_fee;
			if ($step1->discount_unit == "USD") {
				$step1->total_fee = $step1->total_fee - $step1->discount;
			} else {
				$discount = ($step1->member_discount > $step1->discount) ? $step1->member_discount : $step1->discount ;
				//$step1->total_fee = floor($step1->total_fee - ($step1->total_service_fee * $step1->discount)/100);
				$step1->total_fee = $step1->total_fee - round($step1->total_service_fee * $discount/100);
			}
			//$step1->total_fee = floor($step1->total_fee - ($step1->total_service_fee * $step1->vip_discount)/100);
			$step1->total_fee = $step1->total_fee - round($step1->total_service_fee * $step1->vip_discount/100);
		}
		
		// Redirect from login form or step 1
		$user = $this->session->userdata("user");
		if (!empty($user)) {
			if (empty($step1->contact_title)) {
				$step1->contact_title = $user->title;
			}
			if (empty($step1->contact_fullname)) {
				$step1->contact_fullname = $user->user_fullname;
			}
			if (empty($step1->contact_email)) {
				$step1->contact_email = $user->user_email;
			}
			if (empty($step1->contact_phone)) {
				$step1->contact_phone = $user->phone;
			}
		}
		
		// Final save
		$this->session->set_userdata("step1", $step1);
		
		// Check if user click on "Apply Online" menu and return without submited
		$this->check_valid_return($step1);
		
		// Require login
		$this->util->requireUserLogin("apply-visa/login");
		// add check step
		$check_step = new stdClass();
		$info = new stdClass();
		$info->email = $this->session->userdata('user')->user_email;
		$info->created_date = date('Y-m-d');
		$info->type = 1;
		$check_email = $this->m_check_step->items($info);
		if (empty($check_email)) {
			$check_step->id = date('Ymdhis');
			$data = array(
				"id"	=> $check_step->id,
				"email" => $this->session->userdata('user')->user_email,
				"fullname" => $this->session->userdata('user')->user_fullname,
				"step1" => 1,
				"step2" => 1,
				"client_ip" => $this->util->realIP()
			);
			$this->m_check_step->add($data);
		} else {
			$check_step->id = $check_email[0]->id;
		}
		$this->session->set_userdata("check_step", $check_step);
		// END add check step
		$breadcrumb = array('Apply Visa' => site_url('apply-visa'), '1. Visa Options' => site_url('apply-visa/step1'), '2. Applicant Details' => '');
		
		$view_data = array();
		$view_data["step1"] = $step1;
		$view_data["breadcrumb"] = $breadcrumb;
		
		$tmpl_content = array();
		$tmpl_content['meta']['title'] = "Apply Vietnam Visa At The Official Site ".SITE_NAME;
		$tmpl_content['meta']['description'] = "Apply Vietnam visa online using our secure online form at the official site of ".SITE_NAME.". Get visa approval letters in one working day only!";
		$tmpl_content['tabindex'] = "apply-visa";
		$tmpl_content['content'] = $this->load->view("apply/step2", $view_data, TRUE);
		$this->load->view('layout/main', $tmpl_content);
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
		
		// Full package
		if ($full_package) {
			$visa_fee = $this->m_visa_fee->cal_visa_fee($visa_type, $group_size, $processing_time, "", $visit_purpose);
			$subtotal += $visa_fee->stamp_fee * $group_size;
			
			$fast_checkin_fee = $this->m_fast_checkin_fee->search(1, $arrival_port);
			$subtotal += $fast_checkin_fee * $group_size;
		}
		
		$step1 = $this->session->userdata("step1");
		if ($step1 == null) {
			$this->prepare();
			$step1 = $this->session->userdata("step1");
		}
		// Visa service
		$service_fee = 0;
		$total_visa_fee = 0;
		foreach ($nationality_group as $nationality => $count) {
			$visa_fee = $this->m_visa_fee->cal_visa_fee($visa_type, $group_size, $processing_time, $nationality, $visit_purpose);
			$service_fee += $visa_fee->service_fee * $count;
			$total_visa_fee += ($visa_fee->service_fee + $visa_fee->rush_fee) * $count;
		}
		// FC
		$total_checkin_fee = 0;
		$fast_checkin_fee = $this->m_fast_checkin_fee->search($fast_checkin, $arrival_port);
		if ($fast_checkin) {
			if (!empty($step1->discount_fast_track)) {
				$total_checkin_fee = ($fast_checkin_fee * $group_size) * (1 - $step1->discount_fast_track/100);
			} else {
				$total_checkin_fee = $fast_checkin_fee * $group_size;
			}
		}
		// Car pick-up
		$total_car_pickup_fee = 0;
		$car_pickup_fee = $this->m_car_fee->search($num_seat, $arrival_port);
		if ($car_pickup) {
			if (!empty($step1->discount_car_pickup)) {
				$total_car_pickup_fee = $car_pickup_fee * (1 - $step1->discount_car_pickup/100);
			} else {
				$total_car_pickup_fee = $car_pickup_fee;
			}
		}
		
		if ($step1->discount_unit == "USD") {
			$subtotal = ($subtotal + $total_visa_fee) - $step1->discount;
		} else {
			$discount = ($step1->member_discount > $step1->discount) ? $step1->member_discount : $step1->discount ;
			$subtotal = ($subtotal + $total_visa_fee) - $service_fee * $discount/100;
		}
		
		echo json_encode(array($subtotal + $total_checkin_fee + $total_car_pickup_fee,$service_fee * $step1->discount/100,$step1->discount,$service_fee,$step1->member_discount));
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
			$visa_fee = $this->m_visa_fee->cal_visa_fee($visa_type, $group_size, $processing_time, $nationality, $visit_purpose);
			$service_fee += $visa_fee->service_fee * $count;
			$service_fee_detail .= '<div class="service-fee-item">';
			if (!empty($nationality)) {
				$service_fee_detail .= '<div class="text-right"><strong>'.$nationality.'</strong></div>';
			} else if (empty($nationality) && $count < sizeof($nationalities)) {
				$service_fee_detail .= '<div class="text-right"><strong>Other Nationality</strong></div>';
			}
			$service_fee_detail .= '<div class="price text-right">'.$visa_fee->service_fee.' $ x '.$count.' '.($count>1?"people":"person").' = '.($visa_fee->service_fee * $count).' $</div>';
			$service_fee_detail .= '</div>';
		}
		$service_fee = $service_fee . ' $ <i class="fa fa-chevron-circle-down"></i>';
		$result = array($service_fee, $service_fee_detail);
		echo json_encode($result);
	}
	function dologout()
	{
		$step1 = $this->session->userdata("step1");
		
		if ($step1 == null) {
			redirect(site_url("{$this->util->slug($this->router->fetch_class())}"));
		}
		
		$this->session->set_userdata("user", NULL);
		
		redirect(site_url("{$this->util->slug($this->router->fetch_class())}/login"));
	}
	
	function login()
	{
		$step1 = $this->session->userdata("step1");
		
		if ($step1 == null) {
			redirect(site_url("{$this->util->slug($this->router->fetch_class())}"));
		}
		
		$breadcrumb = array('Apply Visa' => site_url('apply-visa'), '1. Visa Options' => site_url('apply-visa/step1'), 'Member Login' => '');
		
		$this->session->set_userdata("return_url", site_url("apply-visa/step2"));
		
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
		$tmpl_content['tabindex'] = "apply-visa";
		$tmpl_content['content'] = $this->load->view("apply/login", $view_data, TRUE);
		$this->load->view('layout/main', $tmpl_content);
	}
	
	function dologin()
	{
		$step1 = $this->session->userdata("step1");
		
		if ($step1 == null) {
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
				redirect(BASE_URL_HTTPS."/apply-visa/login.html", "back");
			}
			else if (empty($new_email)) {
				$this->session->set_flashdata("status", "Email is required.");
				redirect(BASE_URL_HTTPS."/apply-visa/login.html", "back");
			}
			else if ($this->m_user->is_user_exist($new_email)) {
				$this->session->set_flashdata("status", "This email is already in used. Please input another email address.");
				redirect(BASE_URL_HTTPS."/apply-visa/login.html", "back");
			}
			else if (strlen($new_password) < 6) {
				$this->session->set_flashdata("status", "Password must be at least 6 characters long.");
				redirect(BASE_URL_HTTPS."/apply-visa/login.html", "back");
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
			if (empty($step1->contact_title)) {
				$step1->contact_title = $user->title;
			}
			if (empty($step1->contact_fullname)) {
				$step1->contact_fullname = $user->user_fullname;
			}
			if (empty($step1->contact_email)) {
				$step1->contact_email = $user->user_email;
			}
			if (empty($step1->contact_phone)) {
				$step1->contact_phone = $user->phone;
			}
			
			// Re-calculate the total fee
			$step1->vip_discount = $this->vip()->discount;
			
			if ($step1->discount > 0) {
				$step1->vip_discount = 0;
			}
			
			if ($step1->visa_type == "6mm" || $step1->visa_type == "1ym") {
				$step1->vip_discount = 0;
			}
			
			$step1->total_fee = $step1->total_service_fee + $step1->total_rush_fee + $step1->business_visa_fee + $step1->private_visa_fee + $step1->full_package_total_fee + $step1->fast_checkin_total_fee + $step1->car_total_fee;
			if ($step1->discount_unit == "USD") {
				$step1->total_fee = $step1->total_fee - $step1->discount;
			} else {
				//$step1->total_fee = $step1->total_fee - $step1->total_service_fee * $step1->discount/100;
				$step1->total_fee = $step1->total_fee - round($step1->total_service_fee * $step1->discount/100);
			}
			//$step1->total_fee = $step1->total_fee - $step1->total_service_fee * $step1->vip_discount/100;
			$step1->total_fee = $step1->total_fee - round($step1->total_service_fee * $step1->vip_discount/100);
			
			$this->session->set_userdata("step1", $step1);
			
			redirect(site_url("{$this->util->slug($this->router->fetch_class())}/step2"));
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
		
		$nation = $this->m_country->search_by_name($nationality);
		$document_required = $this->m_visa_fee->search($nation->id)->document_required;
		
		if ($document_required) {
			echo json_encode(array(TRUE, strtoupper($nation->name)));
		} else {
			echo json_encode(array(FALSE));
		}
	}
	
	function ajax_detect_rush_case()
	{
		$arrival_month	= (!empty($_POST["arrival_month"]) ? $_POST["arrival_month"] : "");
		$arrival_date	= (!empty($_POST["arrival_date"]) ? $_POST["arrival_date"] : "");
		$arrival_year	= (!empty($_POST["arrival_year"]) ? $_POST["arrival_year"] : "");
		$visa_type		= (!empty($_POST["visa_type"]) ? $_POST["visa_type"] : "");
		$visit_purpose	= (!empty($_POST["visit_purpose"]) ? $_POST["visit_purpose"] : "");
		
		echo $this->util->detect_rush_visa(date("m/d/Y", strtotime($arrival_month."/".$arrival_date."/".$arrival_year)), $visa_type, $visit_purpose);
	}
	
	function ajax_detect_holiday()
	{
		$arrivalmonth		= (!empty($_POST["arrivalmonth"]) ? $_POST["arrivalmonth"] : "");
		$arrivaldate		= (!empty($_POST["arrivaldate"]) ? $_POST["arrivaldate"] : "");
		$arrivalyear		= (!empty($_POST["arrivalyear"]) ? $_POST["arrivalyear"] : "");
		$processing_time	= (!empty($_POST["processing_time"]) ? $_POST["processing_time"] : "");
		
		echo $this->detect_holiday($arrivalmonth, $arrivaldate, $arrivalyear, $processing_time);
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
		$arrivalmonth		= (!empty($_POST["arrivalmonth"]) ? $_POST["arrivalmonth"] : "");
		$arrivaldate		= (!empty($_POST["arrivaldate"]) ? $_POST["arrivaldate"] : "");
		$arrivalyear		= (!empty($_POST["arrivalyear"]) ? $_POST["arrivalyear"] : "");
		$processing_time	= (!empty($_POST["processing_time"]) ? $_POST["processing_time"] : "");
		
		echo $this->detect_emergency($arrivalmonth, $arrivaldate, $arrivalyear, $processing_time);
	}
	
	function step3()
	{
		$step1 = $this->session->userdata("step1");
		$setting = $this->m_setting->load(1);
		$ban_name = explode(',',str_replace(' ','',strtolower($setting->ban_name)));
		$ban_email = explode(',',str_replace(' ','',strtolower($setting->ban_email)));
		$ban_passport = explode(',',str_replace(' ','',strtolower($setting->ban_passport)));
		$ban_err = 0;

		if ($step1 == null) {
			redirect(site_url("{$this->util->slug($this->router->fetch_class())}"));
		}
		else {
			
			$this->check_valid_return($step1);
		}
		
		if (!$this->util->checkUserLogin()) {
			redirect(site_url("{$this->util->slug($this->router->fetch_class())}/login"));
		}
		
		if (!empty($_POST))
		{
			for ($i=1; $i<=$step1->group_size; $i++) {
				$step1->fullname[$i]		= (!empty($_POST["fullname_{$i}"]) ? $_POST["fullname_{$i}"] : "");
				$step1->gender[$i]			= (!empty($_POST["gender_{$i}"]) ? $_POST["gender_{$i}"] : "Male");
				$step1->birthdate[$i]		= (!empty($_POST["birthdate_{$i}"]) ? $_POST["birthdate_{$i}"] : "");
				$step1->birthmonth[$i]		= (!empty($_POST["birthmonth_{$i}"]) ? $_POST["birthmonth_{$i}"] : "");
				$step1->birthyear[$i]		= (!empty($_POST["birthyear_{$i}"]) ? $_POST["birthyear_{$i}"] : "");
				$step1->nationality[$i]		= (!empty($_POST["nationality_{$i}"]) ? $_POST["nationality_{$i}"] : "");
				$step1->passportnumber[$i]	= (!empty($_POST["passportnumber_{$i}"]) ? $_POST["passportnumber_{$i}"] : "");

				if (in_array(strtolower($_POST["fullname_{$i}"]), $ban_name)) {
					$ban_err++;
				}
				if (in_array(strtolower($_POST["passportnumber_{$i}"]), $ban_passport)) {
					$ban_err++;
				}

			}
			
			$step1->flight_booking		= (!empty($_POST["flight_booking"]) ? $_POST["flight_booking"] : 0);
			if ($step1->flight_booking != 0) {
				$step1->flightnumber	= (!empty($_POST["flightnumber"]) ? $_POST["flightnumber"] : "");
				$step1->arrivaltime		= (!empty($_POST["arrivaltime"]) ? $_POST["arrivaltime"] : "");
			} else {
				$step1->flightnumber	= "";
				$step1->arrivaltime		= "";
			}
			
			$step1->contact_title		= (!empty($_POST["contact_title"]) ? $_POST["contact_title"] : "Mr");
			$step1->contact_fullname	= (!empty($_POST["contact_fullname"]) ? $_POST["contact_fullname"] : "");
			$step1->contact_email		= (!empty($_POST["contact_email"]) ? $_POST["contact_email"] : "");
			$step1->contact_email2		= (!empty($_POST["contact_email2"]) ? $_POST["contact_email2"] : "");
			$step1->contact_phone		= (!empty($_POST["contact_phone"]) ? $_POST["contact_phone"] : "");
			$step1->comment				= (!empty($_POST["comment"]) ? $_POST["comment"] : "");
			$step1->payment				= "";
			
			$step1->task				= (!empty($_POST["task"]) ? $_POST["task"] : "");
			
			if (in_array(strtolower($_POST["contact_fullname"]), $ban_name)) {
				$ban_err++;
			}
			if (in_array(strtolower($_POST["contact_email"]), $ban_email)) {
				$ban_err++;
			}
			if (in_array(strtolower($_POST["contact_email2"]), $ban_email)) {
				$ban_err++;
			}
			
			if ($ban_err != 0) {
				redirect(site_url("apply-visa"));
			}
			// Double check holiday case
			$rush = $this->util->detect_rush_visa(date("m/d/Y", strtotime($step1->arrivalmonth."/".$step1->arrivaldate."/".$step1->arrivalyear)), $step1->visa_type, $step1->visit_purpose);
			if ($rush == 3) {
				$step1->task = "Holiday";
			} else if ($rush == 2) {
				$step1->task = "Emergency";
			}
			///////////////////////////////////////////////////
			if ($step1->arrivalmonth < 9) {
				$temp_arrivalmonth = '0'.$step1->arrivalmonth;
			} else {
				$temp_arrivalmonth = $step1->arrivalmonth;
			}
			$temp_date = $step1->arrivalyear.'-'.$temp_arrivalmonth.'-'.$step1->arrivaldate;
			if ($temp_date == '2019-08-19') {
				$step1->task = "Holiday";
			}
			////////////////////////////////////////////////////
			if ($step1->task == "Holiday") {
				$step1->processing_time = "Holiday";
				$step1->full_package = 0;
				$step1->full_package_fc_fee = 0;
				$step1->full_package_total_fee = 0;
			}
			if ($step1->task == "Emergency") {
				$step1->processing_time = "Emergency";
			}
			
			$nationality_group = array();
			for ($i=1; $i<=$step1->group_size; $i++) {
				if (array_key_exists($step1->nationality[$i], $nationality_group)) {
					$nationality_group[$step1->nationality[$i]] = $nationality_group[$step1->nationality[$i]] + 1;
				} else {
					$nationality_group[$step1->nationality[$i]] = 1;
				}
			}
			
			//Cal fees
			$step1->total_service_fee = 0;
			$step1->total_rush_fee = 0;
			$arr_service_fee = array();
			$step1->arr_service_fee = "";
			foreach ($nationality_group as $nationality => $count) {
				$visa_fee = $this->m_visa_fee->cal_visa_fee($step1->visa_type, $step1->group_size, $step1->processing_time, $nationality, $step1->visit_purpose);
				array_push($arr_service_fee, $visa_fee->service_fee);
				$step1->arr_service_fee		= $arr_service_fee;
				$step1->stamp_fee			= $visa_fee->stamp_fee;
				$step1->rush_fee			= $visa_fee->rush_fee;
				$step1->total_service_fee	+= ($visa_fee->service_fee * $count);
				$step1->total_rush_fee	+= ($visa_fee->rush_fee * $count);
			}

			if ($step1->private_visa) {
				$step1->private_visa_fee = $this->m_private_letter_fee->search(((stripos(strtolower($step1->visit_purpose), "business") === false) ? "tourist_" : "business_").$step1->visa_type);
			} else {
				$step1->private_visa_fee = 0;
			}
			
			if ($step1->full_package) {
				$fast_checkin_fee = $this->m_fast_checkin_fee->search(1, $step1->arrival_port);
				$step1->full_package_fc_fee		= $fast_checkin_fee;
				$step1->full_package_total_fee	= ($step1->stamp_fee + $fast_checkin_fee) * $step1->group_size;
				$step1->service_fee_discount		= 0;
			} else {
				$step1->full_package_fc_fee		= 0;
				$step1->full_package_total_fee	= 0;
				$step1->service_fee_discount		= 0;
			}
			
			if ($step1->fast_checkin) {
				$fast_checkin_fee = $this->m_fast_checkin_fee->search($step1->fast_checkin, $step1->arrival_port);
				if (!empty($step1->discount_fast_track)) {
					$step1->fast_checkin_fee			= $fast_checkin_fee * (1 - $step1->discount_fast_track/100);
					$step1->fast_checkin_total_fee	= ($fast_checkin_fee * $step1->group_size) * (1 - $step1->discount_fast_track/100);
				} else {
					$step1->fast_checkin_fee			= $fast_checkin_fee;
					$step1->fast_checkin_total_fee	= $fast_checkin_fee * $step1->group_size;
				}
			} else {
				$step1->fast_checkin_fee			= 0;
				$step1->fast_checkin_total_fee	= 0;
			}
			
			if ($step1->car_pickup) {
				$car_fee = $this->m_car_fee->search($step1->num_seat, $step1->arrival_port);
				$fast_checkin_fee = $this->m_fast_checkin_fee->search($step1->fast_checkin, $step1->arrival_port);
				if (!empty($step1->discount_car_pickup)) {
					$step1->car_fee			= $car_fee * (1 - $step1->discount_car_pickup/100);
					$step1->car_total_fee		= $car_fee * (1 - $step1->discount_car_pickup/100);
				} else {
					$step1->car_fee		= $car_fee;
					$step1->car_total_fee	= $car_fee;
				}
			} else {
				$step1->car_fee		= 0;
				$step1->car_total_fee	= 0;
			}
			
			$step1->total_fee = $step1->total_service_fee + $step1->total_rush_fee + $step1->private_visa_fee + $step1->full_package_total_fee + $step1->fast_checkin_total_fee + $step1->car_total_fee;
			$discount = $step1->discount;
			if ($step1->discount_unit == "USD") {
				$step1->total_fee = $step1->total_fee - $step1->discount;
			} else {
				if ($step1->member_discount > $step1->discount)
				$discount = $step1->member_discount;
				$step1->total_fee = round($step1->total_fee - round(($step1->total_service_fee * $discount/100),2),2);
			}
			$step1->total_fee = $step1->total_fee - round(($step1->total_service_fee * $step1->vip_discount/100),2);
			$step1->total_fee = $step1->total_fee - round(($step1->total_service_fee * $step1->service_fee_discount/100),2);
			$step1->total_fee += $step1->car_plus_fee;
			// =============================

			// Check denied passport
			foreach ($step1->passportnumber as $passport) {
				$passport = strtoupper(trim(str_replace(" ","",$passport)));
				$pax_info = new stdClass();
				$pax_info->search_text = $passport;
				$paxs = $this->m_visa_pax->items($pax_info, NULL, 10);
				foreach ($paxs as $pax) {
					if ((strtoupper(trim(str_replace(" ","",$pax->passport))) == $passport) && ($pax->status == 3)) {
						$this->session->set_flashdata("error", "Your passport number: ".$passport." is denied from Vietnam Immgration Department.");
						redirect(site_url("{$this->util->slug($this->router->fetch_class())}/step2"));
						break;
					}
				}
			}

				// Mobile detect
			$this->load->library('user_agent');
			
			$agent = 'Unidentified';
			$platform = $this->agent->platform();
			
			if ($this->agent->is_mobile()) {
				$agent = "Mobile - ". $this->agent->mobile();
			}
			else if ($this->agent->is_browser()) {
				$agent = $this->agent->browser().' '.$this->agent->version();
			}
			else if ($this->agent->is_robot()) {
				$agent = $this->agent->robot();
			}
			
			$step1->capital = 0;
			
			$visa_fee = $this->m_visa_fee->cal_visa_fee($step1->visa_type, $step1->group_size, $step1->processing_time, $step1->passport_holder, $step1->visit_purpose, $step1->arrival_port);
			$step1->capital += $visa_fee->service_capital * $step1->group_size;
			$step1->capital += $visa_fee->rush_capital * $step1->group_size;
			
			// if ($step1->private_visa) {
			// 	$private_visa_fee = $this->m_private_letter_fee->search("capital_".((stripos(strtolower($step1->visit_purpose), "business") === false) ? "tourist_" : "business_").$step1->visa_type);
			// 	$step1->capital += $private_visa_fee;
			// }
			
			if ($step1->full_package) {
				$fast_checkin_fee = $this->m_fast_checkin_fee->search(1, $step1->arrival_port, 1);
				$step1->capital += ($step1->stamp_fee * $step1->group_size);
				$step1->capital += ($fast_checkin_fee * $step1->group_size);
			}
			
			if ($step1->fast_checkin) {
				$fast_checkin_fee = $this->m_fast_checkin_fee->search($step1->fast_checkin, $step1->arrival_port, 1);
				$step1->capital += ($fast_checkin_fee * $step1->group_size);
			}
			
			if ($step1->car_pickup) {
				$car_fee = $this->m_car_fee->search($step1->num_seat, $step1->arrival_port, 1);
				$step1->capital += $car_fee;
			}
			$check_step = $this->session->userdata("check_step");
			$data_step = array(
				"step3" 	=> 1,
				"price" 	=> $step1->total_fee,
			);
			$this->m_check_step->update($data_step, array("id" => $check_step->id));

			$this->session->set_userdata("step1", $step1);
		}
		
		$breadcrumb = array('Apply Visa' => site_url('apply-visa'), '1. Visa Options' => site_url('apply-visa/step1'), '2. Applicant Details' => site_url('apply-visa/step2'), '3. Review & Payment' => '');
		
		$view_data = array();
		$view_data["step1"] = $step1;
		$view_data["breadcrumb"] = $breadcrumb;
		
		$tmpl_content = array();
		$tmpl_content['meta']['title'] = "Apply Vietnam Visa At The Official Site ".SITE_NAME;
		$tmpl_content['meta']['description'] = "Apply Vietnam visa online using our secure online form at the official site of ".SITE_NAME.". Get visa approval letters in one working day only!";
		$tmpl_content['tabindex'] = "apply-visa";
		$tmpl_content['content'] = $this->load->view("apply/step3", $view_data, TRUE);
		$this->load->view('layout/main', $tmpl_content);
	}
	
	function completed()
	{
		$step1 = $this->session->userdata("step1");
		$security_code = $this->util->value($this->input->post("security_code"), "");
		if ($step1 == null) {
			redirect(site_url("{$this->util->slug($this->router->fetch_class())}"));
		}
		else {
			$this->check_valid_return($step1);
		}
		
		if (!$this->util->checkUserLogin()) {
			redirect(site_url("{$this->util->slug($this->router->fetch_class())}/login"));
		}
		
		if (!empty($_POST))
		{
			$step1->payment = (!empty($_POST["payment"]) ? $_POST["payment"] : "");
			if (empty($step1->payment)) {
				$this->session->set_flashdata("error", "Please select an method of Payment.");
				redirect(BASE_URL_HTTPS."/apply-visa/step3.html", "back");
			}
			$this->session->set_userdata("step1", $step1);
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
				
				$data   = array( 'payment_method' => $step1->payment );
				$where  = array( 'booking_key' => $key );
				$this->m_visa_booking->update($data, $where);
			}
		}
		
		if (empty($booking_id)) {
			// Get booking id
			$booking_id = $this->m_visa_booking->get_next_value() + rand(2, 5);
			
			// Booking key
			$key = md5($booking_id.time());
			
			// Mobile detect
			$this->load->library('user_agent');
			
			$agent = 'Unidentified';
			$platform = $this->agent->platform();
			
			if ($this->agent->is_mobile()) {
				$agent = "Mobile - ". $this->agent->mobile();
			}
			else if ($this->agent->is_browser()) {
				$agent = $this->agent->browser().' '.$this->agent->version();
			}
			else if ($this->agent->is_robot()) {
				$agent = $this->agent->robot();
			}
			
			$step1->capital = 0;
			
			$visa_fee = $this->m_visa_fee->cal_visa_fee($step1->visa_type, $step1->group_size, $step1->processing_time, $step1->passport_holder, $step1->visit_purpose, $step1->arrival_port);
			$step1->capital += $visa_fee->service_capital * $step1->group_size;
			$step1->capital += $visa_fee->rush_capital * $step1->group_size;
			
			if ($step1->private_visa) {
				$private_visa_fee = $this->m_private_letter_fee->search("capital_".((stripos(strtolower($step1->visit_purpose), "business") === false) ? "tourist_" : "business_").$step1->visa_type);
				$step1->capital += $private_visa_fee;
			}
			
			if ($step1->full_package) {
				$fast_checkin_fee = $this->m_fast_checkin_fee->search(1, $step1->arrival_port, 1);
				$step1->capital += ($step1->stamp_fee * $step1->group_size);
				$step1->capital += ($fast_checkin_fee * $step1->group_size);
			}
			
			if ($step1->fast_checkin) {
				$fast_checkin_fee = $this->m_fast_checkin_fee->search($step1->fast_checkin, $step1->arrival_port, 1);
				$step1->capital += ($fast_checkin_fee * $step1->group_size);
			}
			
			if ($step1->car_pickup) {
				$car_fee = $this->m_car_fee->search($step1->num_seat, $step1->arrival_port, 1);
				$step1->capital += $car_fee;
			}
			
			// Add to booking list
			$data = array(
				'id'					=> $booking_id,
				"order_ref"				=> $this->util->order_ref($booking_id),
				'booking_key'			=> $key,
				'visa_type'				=> $this->m_visa_type->load($step1->visa_type)->name,
				'group_size'			=> $step1->group_size,
				'visit_purpose' 		=> $step1->visit_purpose,
				'arrival_date'			=> date("Y-m-d", strtotime($step1->arrivalyear."/".$step1->arrivalmonth."/".$step1->arrivaldate)),
				'exit_date'				=> date("Y-m-d", strtotime($step1->exityear."/".$step1->exitmonth."/".$step1->exitdate)),
				'arrival_port'			=> $this->m_arrival_port->load($step1->arrival_port)->short_name,
				'flight_number'			=> $step1->flightnumber,
				'arrival_time'			=> $step1->arrivaltime,
				'visa_fee'				=> $step1->service_fee,
				'total_visa_fee'		=> $step1->total_service_fee,
				'stamp_fee'				=> $step1->stamp_fee,
				'rush_type'				=> ($step1->processing_time == "Urgent") ? 1 : (($step1->processing_time == "Emergency") ? 2 : (($step1->processing_time == "Holiday") ? 3 : (($step1->processing_time == "TET Holiday") ? 4 : 0))),
				'rush_fee'				=> $step1->rush_fee,
				'total_fee'				=> $step1->total_fee,
				'capital'				=> $step1->capital,
				'contact_title'			=> $step1->contact_title,
				'contact_fullname'		=> $step1->contact_fullname,
				'primary_email'			=> $step1->contact_email,
				'secondary_email'		=> $step1->contact_email2,
				'contact_phone'			=> $step1->contact_phone,
				'special_request'		=> $step1->comment,
				'payment_method' 		=> $step1->payment,
				'booking_date' 			=> date("Y-m-d H:i:s"),
				'paid_date' 			=> date("Y-m-d H:i:s"),
				'private_visa' 			=> $step1->private_visa,
				'private_visa_fee' 		=> $step1->private_visa_fee,
				'business_visa_fee' 	=> $step1->business_visa_fee,
				'full_package'			=> $step1->full_package,
				'full_package_fc_fee'	=> $step1->full_package_fc_fee,
				'fast_checkin' 			=> $step1->fast_checkin,
				'fast_checkin_fee'		=> $step1->fast_checkin_total_fee,
				'car_pickup' 			=> $step1->car_pickup,
				'car_type' 				=> $step1->car_type,
				'seats' 				=> $step1->num_seat,
				'car_fee' 				=> $step1->car_total_fee,
				'promotion_code'		=> ($step1->member_discount > $step1->discount) ? 'Member Discount' : $step1->promotion_code,
				'discount'				=> ($step1->member_discount > $step1->discount) ? $step1->member_discount : $step1->discount,
				'discount_unit'			=> $step1->discount_unit,
				'vip_discount'			=> $step1->vip_discount,
				'user_id' 				=> !empty($user->id) ? $user->id : 1,
				'status' 				=> 0,
				'client_ip' 			=> $this->util->realIP(),
				'user_agent'			=> $agent,
				'platform'				=> $platform,
			);
			if (!$this->m_visa_booking->add($data)) {
				$succed = false;
			} else {
				for ($i=1; $i<=$step1->group_size; $i++) {
					$pax["book_id"]		= $booking_id;
					$pax["fullname"]	= $step1->fullname[$i];
					$pax["gender"]		= $step1->gender[$i];
					$pax["birthday"]	= date("Y-m-d", strtotime($step1->birthmonth[$i]."/".$step1->birthdate[$i]."/".$step1->birthyear[$i]));
					$pax["nationality"]	= $step1->nationality[$i];
					$pax["passport"]	= $step1->passportnumber[$i];
					
					if (!$this->m_visa_booking->add_traveller($pax)) {
						$succed = false;
					}
				}
			}
		}
		
		if ($succed)
		{
			// Get new added booking
			$booking = $this->m_visa_booking->booking(NULL, $key);
			
			// Send mail
			$tpl_data = $this->mail_tpl->visa_data($booking);
			
			if ($booking->payment_method == "Western Union" || $booking->payment_method == "Bank Transfer") {
				$subject = "Application #".BOOKING_PREFIX.$booking->id.": Confirm Visa for Vietnam (".$booking->payment_method.")";
			} else {
				$subject = "Application #".BOOKING_PREFIX.$booking->id.": Visa for Vietnam Remind (gate ".$booking->payment_method.")";
			}
			
			$vendor_subject = $subject;
			if ($tpl_data["PROCESSING_TIME"] != "Normal") {
				$vendor_subject = "[".$tpl_data["PROCESSING_TIME"]."] ".$subject;
			}
			
			$message = $this->mail_tpl->visa_payment_remind($tpl_data);
			
			// Send to SALE Department
			$mail = array(
				"subject"		=> $vendor_subject." - ".$user->user_fullname,
				"from_sender"	=> $booking->primary_email,
				"name_sender"	=> $user->user_fullname,
				"to_receiver"	=> 'thaibaolam.lx@gmail.com',
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
			
			if ($booking->payment_method == 'OnePay')
			{
				$fields = array("agent" => "M_THEONE_VN");
				$fields["booking_id"] = $booking->id;
				$curl = curl_init("https://www.theonevietnam.com/cdn/cdn-evs/04.html");
				curl_setopt($curl, CURLOPT_TIMEOUT, 30);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
				curl_exec($curl);
				curl_close($curl);
				
				//Redirect to OnePay
				$vpcURL = OP_PAYMENT_URL;
				
				$vpcOpt['Title']				= "Settle payment for Vietnam visa at ".SITE_NAME;
				$vpcOpt['AgainLink']			= urlencode($_SERVER['HTTP_REFERER']);
				$vpcOpt['vpc_Merchant']			= OP_MERCHANT;
				$vpcOpt['vpc_AccessCode']		= OP_ACCESSCODE;
				$vpcOpt['vpc_MerchTxnRef']		= $key;
				$vpcOpt['vpc_OrderInfo']		= $booking->order_ref;
				$vpcOpt['vpc_Amount']			= $booking->total_fee*100;
				$vpcOpt['vpc_ReturnURL']		= OP_RETURN_URL;
				$vpcOpt['vpc_Version']			= "2";
				$vpcOpt['vpc_Command']			= "pay";
				$vpcOpt['vpc_Locale']			= "en";
				$vpcOpt['vpc_TicketNo']			= $this->util->realIP();
				$vpcOpt['vpc_Customer_Email']	= $booking->primary_email;
				$vpcOpt['vpc_Customer_Id']		= $user->id;
				
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
			else if ($booking->payment_method == 'Credit Card')
			{
				//Redirect to gate2shop
				$numberofitems = 1;
				$totalAmount   = $booking->total_fee;
				$productName   = BOOKING_PREFIX.$booking->id.": ".$booking->visa_type;
				$productPrice  = $totalAmount/$booking->group_size;
				$productNum    = $booking->group_size;
				$datetime      = gmdate($this->config->item("log_date_format"));
				
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
				$link .= '&customField2='.$booking->primary_email;
				
				header('Location: '.$link);
				die();
			}
			else if ($booking->payment_method == 'Paypal')
			{
				$paymentAmount = $booking->total_fee;
				$paymentType = "Sale";
				$itemName = BOOKING_PREFIX.$booking->id.": ".$booking->visa_type;
				$itemQuantity = 1;
				$itemPrice = $booking->total_fee;
				$returnURL = PAYPAL_RETURN_URL."?key=".$key;
				$cancelURL = PAYPAL_CANCEL_URL."?key=".$key;
				
				$resArray = $this->paypal->CallShortcutExpressCheckout($paymentAmount, PAYPAL_CURRENCY, $paymentType, $itemName, $itemQuantity, $itemPrice, $returnURL, $cancelURL);
				$ack = strtoupper($resArray["ACK"]);
				$token = urldecode($resArray["TOKEN"]);
				if ($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") {
					$this->paypal->RedirectToPayPal($token);
				}
				else {
					header('Location: '.BASE_URL."/apply-visa/failure.html?key=".$key);
					die();
				}
			}
			else if (in_array($booking->payment_method, array("Credit Card", "Western Union", "Bank Transfer")))
			{
				if ($this->session->userdata("user") && ($this->session->userdata("user")->id == 8086)) {
					header("Location: ".BASE_URL."/apply-visa/success.html?key=".$key);
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
		
		$breadcrumb = array('Apply Visa' => site_url('apply-visa'), '1. Visa Options' => site_url('apply-visa/step1'), '2. Applicant Details' => site_url('apply-visa/step2'), '3. Review & Payment' => site_url('apply-visa/step3'), 'Finish' => '');
		$client_name = !empty($user->user_fullname) ? $user->user_fullname : $step1->contact_fullname;
		$view_data = array();
		$view_data["client_name"] = $client_name;
		$view_data["breadcrumb"] = $breadcrumb;
		
		$tmpl_content = array();
		$tmpl_content["transaction_id"]			= BOOKING_PREFIX.$booking->id;
		$tmpl_content["transaction_fee"]		= $booking->total_fee;
		$tmpl_content["transaction_sku"]		= $booking->id;
		$tmpl_content["transaction_name"]		= $booking->visa_type;
		$tmpl_content["transaction_category"]	= ($booking->rush_type == 1) ? "Urgent" : (($booking->rush_type == 2) ? "Emergency" : (($booking->rush_type == 3) ? "Holiday" : (($booking->rush_type == 4) ? "TET Holiday" : "Normal")));
		$tmpl_content["transaction_quantity"]	= $booking->group_size;
		$tmpl_content['meta']['title'] = "Apply Vietnam Visa At The Official Site ".SITE_NAME;
		$tmpl_content['meta']['description'] = "Apply Vietnam visa online using our secure online form at the official site of ".SITE_NAME.". Get visa approval letters in one working day only!";
		$tmpl_content['tabindex'] = "apply-visa";
		$tmpl_content['content'] = $this->load->view("apply/step4", $view_data, TRUE);
		$this->load->view('layout/view', $tmpl_content);
	}
	
	function finish()
	{
		redirect(BASE_URL);
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
		if ($booking == null || $booking->status) {
			redirect(BASE_URL);
			die();
		}
		
		$data  = array(
			'status' => 1,
			'paid_date' => date($this->config->item("log_date_format"))
		);
		$where = array( 'booking_key' => $key );
		
		$this->m_visa_booking->update($data, $where);
		
		$booking = $this->m_visa_booking->booking(NULL, $key);
		if ($booking != null)
		{
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
							$type .= 'tourist_';
							break;
						case 'For business':
							$type .= 'business_';
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
					$this->m_visa_pax->update(array("agents_id"=>$agents_id,"agents_fc_id"=>$agents_id),array("id" => $value->pax_id));
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
							$type .= 'tourist_';
							break;
						case 'For business':
							$type .= 'business_';
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
					$this->m_visa_pax->update(array("agents_id"=>$agents_id,"agents_fc_id"=>$agents_fc_id),array("id" => $value->pax_id));
				}
			}
			////////////////////////////////////////////////////
			$user = $this->m_user->load($booking->user_id);
			$this->m_user->update(array('amount' => $booking->total_fee+$user->amount), array('id' => $booking->user_id));
			// Send mail
			$tpl_data = $this->mail_tpl->visa_data($booking);
			
			$subject = "Application #".BOOKING_PREFIX.$booking->id.": Confirm Visa for Vietnam Successful (gate ".$booking->payment_method.")";
			$vendor_subject = $subject;
			if ($tpl_data['PROCESSING_TIME'] != "Normal") {
				$vendor_subject = "[".$tpl_data['PROCESSING_TIME']."] ".$subject;
			}
			
			$message  = $this->mail_tpl->visa_payment_successful($tpl_data);
			
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
			//
			$check_step = $this->session->userdata("check_step");
			$data_step = array(
				"status" 	=> 'paid',
				"send_mail" => 2,
			);
			$this->m_check_step->update($data_step, array("id" => $check_step->id));
			//
		}
		else {
			redirect(BASE_URL);
			die();
		}
		
		$breadcrumb = array('Apply Visa' => site_url('apply-visa'), '1. Visa Options' => site_url('apply-visa/step1'), '2. Applicant Details' => site_url('apply-visa/step2'), '3. Review & Payment' => site_url('apply-visa/step3'), 'Apply Successful' => '');
		
		$total_fee = $booking->total_fee - (($booking->full_package) ? ($booking->stamp_fee * $booking->group_size) : 0);
		
		$view_data = array();
		$view_data["client_name"]	= $user->user_fullname;
		$view_data["total_fee"] 	= $total_fee;
		$view_data["key"]			= $key;
		$view_data["breadcrumb"]	= $breadcrumb;
		
		$tmpl_content = array();
		$tmpl_content["transaction_id"]			= BOOKING_PREFIX.$booking->id;
		$tmpl_content["transaction_fee"]		= $total_fee;
		$tmpl_content["transaction_sku"]		= $booking->id;
		$tmpl_content["transaction_name"]		= $booking->visa_type;
		$tmpl_content["transaction_category"]	= ($booking->rush_type == 1) ? "Urgent" : (($booking->rush_type == 2) ? "Emergency" : (($booking->rush_type == 3) ? "Holiday" : (($booking->rush_type == 4) ? "TET Holiday" : "Normal")));
		$tmpl_content["transaction_quantity"]	= $booking->group_size;
		$tmpl_content["tabindex"] = "apply-visa";
		$tmpl_content["content"] = $this->load->view("apply/successful", $view_data, TRUE);
		$this->load->view('layout/view', $tmpl_content);
	}
	
	function failure($key="")
	{
		if (empty($key)) {
			$key = !empty($_GET["key"]) ? $_GET["key"] : "";
		}
		
		if (!empty($key)) {
			$key = str_ireplace(".html", "", $key);
		}
		
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
				$user = $this->m_user->load($booking->user_id);
				
				// Change key for duplicated email
				$newkey = $key."_f";
				$data   = array( 'booking_key' => $newkey );
				$where  = array( 'booking_key' => $key );
				$this->m_visa_booking->update($data, $where);
				
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
		}
		
		$breadcrumb = array('Apply Visa' => site_url('apply-visa'), '1. Visa Options' => site_url('apply-visa/step1'), '2. Applicant Details' => site_url('apply-visa/step2'), '3. Review & Payment' => site_url('apply-visa/step3'), 'Apply Failure' => '');
		
		$view_data = array();
		$view_data["client_name"] = $user->user_fullname;
		$view_data["key"] = $newkey;
		$view_data["errMsg"] = $this->session->flashdata('payment_error');
		$view_data["breadcrumb"] = $breadcrumb;
		
		$tmpl_content = array();
		$tmpl_content['tabindex'] = "apply-visa";
		$tmpl_content['content'] = $this->load->view("apply/failure", $view_data, TRUE);
		$this->load->view('layout/view', $tmpl_content);
	}
	function upload_audio(){

		$step1 = $this->session->userdata("step1");

		$size = $_FILES['audio_data']['size'];
		$input = $_FILES['audio_data']['tmp_name'];
		$output = $_FILES['audio_data']['name'].".wav";
		move_uploaded_file($input, "./files/upload/review_audio/{$output}");

		$user_id = !empty($this->session->userdata("user")->id) ? $this->session->userdata("user")->id : 0 ;
		$data = array(
			'name' => $_FILES['audio_data']['name'],
			'user_id' => $user_id,
			'mail' => $step1->contact_email
		);
		$this->m_review_audio->add($data);
	}
	function ajax_call_car_plus_fees() {
		$distance = $this->input->post("distance");
		$port_id = $this->input->post("port_id");
		$destination = $this->input->post("destination");

		$arr_result = array();
		$step1 = $this->session->userdata("step1");
		
		$car_plus_fee = $this->m_car_plus_fee->search($port_id);

		$plus_car_fee = round((Float)$distance/1000,1) - $car_plus_fee->distance;
		if ($plus_car_fee > $car_plus_fee->distance_plus) {

			$seat = "seat_{$step1->num_seat}";
			$step1->car_plus_fee = round(($plus_car_fee/$car_plus_fee->distance_plus)*$car_plus_fee->{$seat},1);
			$step1->car_distance = round((Float)$distance/1000,1);
			$step1->car_distance_default = $car_plus_fee->distance;
			$step1->car_destination = $destination;

			array_push($arr_result, $car_plus_fee);
			array_push($arr_result, $step1->car_plus_fee);
			array_push($arr_result, $step1->car_distance);
		} else {
			$step1->car_plus_fee = 0;
		}
		$this->session->set_userdata("step1", $step1);

		echo json_encode($arr_result);
	}
}

?>