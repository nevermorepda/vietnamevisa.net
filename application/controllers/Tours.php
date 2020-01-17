<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tours extends CI_Controller {

	var $breadcrumb = array();
	public function index($categories_tour=null,$alias=null)
	{

		$info = new stdClass();
		if(!empty($categories_tour)) {
			$info->catid = $categories_tour;
		}
		if(!empty($alias)){
			$this->booking_planning($alias,0);
			$booking = $this->session->userdata("booking");

			if (isset($_POST) && !empty($_POST)) {
				$tour_id = $this->util->value($this->input->post("tour_id",0));
				$item = $this->m_tour->load($tour_id);

				$user = $this->session->userdata('user');
				$booking = $this->session->userdata("booking");
				
				if (empty($booking)) {
					redirect("{$this->util->slug($this->router->fetch_class())}","back");
				}

				$departure_date = $this->util->value($this->input->post("arrival_date"));
				$booking->adults = intval($this->util->value($this->input->post("adults",0))); // amount-childs
				$booking->children = intval($this->util->value($this->input->post("children",0))); // amount-childs
				$booking->infants = intval($this->util->value($this->input->post("infants",0))); // amount-infants
				$booking->travelers = $booking->adults + $booking->children + $booking->infants;
				$booking->departure_date = $departure_date;
				$booking->transport = $item->transport;

				if (empty($booking->departure_date)) {
					$this->session->set_flashdata("error","Please enter the departure date.");
					redirect("{$this->util->slug($this->router->fetch_class())}/booking/{$item->alias}","location");
				}

				if (empty($booking->adults)) {
					$this->session->set_flashdata("error","Please enter the number of adults.");
					redirect("{$this->util->slug($this->router->fetch_class())}/booking/{$item->alias}","location");
				}

				$children_rates = array();
				$infants_rates = array();
				if ($item->daily) {
					$info = new stdClass();
					$info->tour_id = $item->id;
					$info->type_passenger = 1;

					$rates = $this->m_tour_rate->items($info,1);
					if (!empty($booking->children)) {
						$info = new stdClass();
						$info->tour_id = $item->id;
						$info->type_passenger = 2;
						$children_rates = $this->m_tour_rate->items($info,1);
					}
					if (!empty($booking->infants)) {
						$info = new stdClass();
						$info->tour_id = $item->id;
						$info->type_passenger = 3;
						$infants_rates = $this->m_tour_rate->items($info,1);
					}
				}
				else {
					$info = new stdClass();
					$info->tour_departure = $tour_departure;
					$info->type_passenger = 1;

					$rates = $this->m_tour_departure_rate->items($info,1);
					if (!empty($booking->children)) {
						$info = new stdClass();
						$info->tour_departure = $tour_departure;
						$info->type_passenger = 2;
						$children_rates = $this->m_tour_departure_rate->items($info,1);
					}
					if (!empty($booking->infants)) {
						$info = new stdClass();
						$info->tour_departure = $tour_departure;
						$info->type_passenger = 3;
						$infants_rates = $this->m_tour_departure_rate->items($info,1);
					}
				}

				$adults_price = $item->price;
				$child_price = $item->child_price;
				$infants_price = $item->infants_price;
				// adults price
				$count = sizeof($rates);
				$hasrates = ($count>0)?true:false;
				for($i=0; $i<$count; $i++){
					if (!empty($rates[$i+1]->group_size)) {
						if ($booking->adults >= $rates[$i]->group_size && $booking->adults < $rates[$i+1]->group_size) {
							$adults_price = $rates[$i]->price;
							break;
						}
					}
					else {
						if ($rates[$i]->single_supplement == 1) {
							$adults_price = $rates[$i-1]->price;
						}
						else {
							$adults_price = $rates[$i]->price;
						}
						break;
					}
				}
				// children price
				if (!empty($booking->children)) {
					$count = sizeof($children_rates);
					for($i=0; $i<$count; $i++){
						if (!empty($children_rates[$i+1]->group_size)) {
							if ($booking->children >= $children_rates[$i]->group_size && $booking->children < $children_rates[$i+1]->group_size) {
								$child_price = $children_rates[$i]->price;
								break;
							}
						}
						else {
							if ($children_rates[$i]->single_supplement == 1) {
								$child_price = $children_rates[$i-1]->price;
							}
							else {
								$child_price = $children_rates[$i]->price;
							}
							break;
						}
					}
				}
				// infants price
				if (!empty($booking->infants)) {
					$count = sizeof($infants_rates);
					for($i=0; $i<$count; $i++){
						if (!empty($infants_rates[$i+1]->group_size)) {
							if ($booking->infants >= $infants_rates[$i]->group_size && $booking->infants < $infants_rates[$i+1]->group_size) {
								$infants_price = $infants_rates[$i]->price;
								break;
							}
						}
						else {
							if ($infants_rates[$i]->single_supplement == 1) {
								$infants_price = $infants_rates[$i-1]->price;
							}
							else {
								$infants_price = $infants_rates[$i]->price;
							}
							break;
						}
					}
				}

				$booking->tour_adults_rate = $adults_price;
				$booking->tour_child_rate = $child_price;
				$booking->tour_infants_rate = $infants_price;
				$total_infants_fee = ($booking->infants>0)?(($booking->infants-1)*$booking->tour_infants_rate):0;
				$booking->tour_fee = ((!$hasrates)?0:($booking->tour_adults_rate*$booking->adults + $booking->children*$booking->tour_child_rate + $total_infants_fee));
				$booking->total_service_fee = $booking->tour_fee + $booking->ship_fee;
				$booking->total_fee = $booking->total_service_fee + $booking->film_ride_fee;

				$this->session->set_userdata("booking",$booking);
				redirect("{$this->util->slug($this->router->fetch_class())}/booking/review");
			}

			$item = $this->m_tour->load($alias);
			
			$this->breadcrumb = array("Vietnam Visa Tours" => site_url("{$this->util->slug($this->router->fetch_class())}"));
			$this->breadcrumb = array_merge($this->breadcrumb, array("$item->title" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$item->alias}")));

			$rate_info = new stdClass();
			$rate_info->tour_id = $item->id;
			$rate_info->orderby = "ASC";
			$rate_info->sortby = "type_passenger";
			$rate_info->type_passenger = array(1,2,3);//1:adults,2:children;3:infants
			$rates = $this->m_tour_rate->items($rate_info,1);

			$view_data = array();
			$view_data['item']		= $item;
			$view_data['breadcrumb']= $this->breadcrumb;
			$view_data["rates"] = $rates;
			
			$tmpl_content = array();
			$tmpl_content['meta']['title'] = "Tours";
			$tmpl_content['tabindex']  = "tours";
			$tmpl_content['meta']['keywords'] = $item->meta_key;
			$tmpl_content['meta']['description'] = $item->meta_desc;
			$tmpl_content['content']   = $this->load->view("tour/optional_tours/booking", $view_data, TRUE);
			$this->load->view('layout/view', $tmpl_content);

		}else {
			$view_data = array();
			$view_data['items'] = $this->m_tour->items($info);

			$tmpl_content = array();
			$tmpl_content['meta']['title'] = "Tours";
			$tmpl_content['tabindex']  = "tours";

			$tmpl_content['content']   = $this->load->view("tour/optional_tours/index", $view_data, TRUE);
			$this->load->view('layout/view', $tmpl_content);
		}

	}

	public function booking_planning($alias=null,$tour_departure=0)
	{
		$user = $this->session->userdata('user');
		$this->session->unset_userdata("booking");

		$item = $this->m_tour->load($alias);

		if (!empty($item->daily)){
			$tour_departure = 0;
		}

		$booking = new stdClass();
		$booking->tour_id = $item->id;
		$booking->tour_departure = $tour_departure;
		// $booking->departure_date = (($item->daily) ? date("Y-m-d",strtotime("+3 day")) : $this->m_tour_departure->load($booking->tour_departure)->start);
		$booking->departure_date = date("Y-m-d",strtotime("+3 day"));
		$booking->classtype = "";
		$booking->adults = 1;
		$booking->children = 0;
		$booking->infants = 0;
		$booking->supplements = 0;
		$booking->supplement_rate = 0;
		$booking->travelers = $booking->adults + $booking->children + $booking->infants;
		$booking->contact_fullname = !empty($user) ? $user->user_fullname : "";
		$booking->contact_title = !empty($user) ? $user->title : "Mr";
		$booking->contact_email = !empty($user) ? $user->user_email : "";
		$booking->contact_phone = !empty($user) ? $user->phone : "";
		$booking->birth_day = "";
		$booking->contact_message = "";
		// $booking->tour_adults_rate = !empty($tour_departure) ? $this->m_tour_departure->load($tour_departure)->price : $item->price;
		// $booking->tour_child_rate = !empty($tour_departure) ? $this->m_tour_departure->load($tour_departure)->child_price : $item->child_price;
		// $booking->tour_infants_rate = !empty($tour_departure) ? $this->m_tour_departure->load($tour_departure)->infants_price : $item->infants_price;
		$booking->tour_adults_rate = $item->price;
		$booking->tour_child_rate = $item->child_price;
		$booking->tour_infants_rate = $item->infants_price;
		$booking->tour_fee = ($booking->tour_adults_rate * $booking->adults) + ($booking->children * $booking->tour_child_rate) + ($booking->tour_infants_rate * $booking->infants);
		$booking->paxs = array();
		$booking->payment_option = "";
		$booking->payment_method = "";
		$booking->status = 0;
		$booking->less_80_kg = 0;
		$booking->greater_80_kg = 0;
		$booking->discount = 0;
		$booking->promotion_code = "";
		$booking->discount_unit = "%";
		$booking->min_passenger = -1;
		$booking->allergic = "";
		$booking->rb_allergic = 0;
		$booking->pickup = "";
		$booking->transport = "Motorbike";
		$booking->vat = 0;
		$booking->film_ride_fee = 0;
		$booking->user_id = 0;
		
		/* CRUISE TOURS */
		$booking->ship_ids = "";
		$booking->ship_rooms = "";
		$booking->ship_room_nums = "";
		$booking->ship_fee = 0;
		$booking->total_service_fee = $booking->tour_fee + $booking->ship_fee;
		$booking->total_fee = $booking->total_service_fee + $booking->film_ride_fee;
		$booking->from_source = "";

		$promotion = $this->session->userdata("promotion");
		if (!empty($promotion)) {
			$booking->discount = $promotion->discount;
			$booking->promotion_code = $promotion->promotion_code;
			$booking->discount_unit = $promotion->discount_unit;
			$booking->min_passenger = $promotion->min_passenger;
		}

		$this->session->set_userdata("booking", $booking);
	}

	public function ajax_api() {
		$amount_adult = $this->input->post('adult');
		$amount_child = $this->input->post('child');
		$amount_infant = $this->input->post('infant');
		$id = $this->input->post('id');

		$total = 0;

		$info_adult = new stdClass();
		$info_adult->tour_id = $id;
		$info_adult->type_passenger = 1;

		$fee_adults = $this->m_tour_rate->items($info_adult);

		$rate_adult = 0;
		foreach ($fee_adults as $fee_adult) {
			if($amount_adult >= $fee_adult->group_size) {
				$rate_adult = $fee_adult->price;
			}else{
				break;
			}
		}

		$info_child = new stdClass();
		$info_child->tour_id = $id;
		$info_child->type_passenger = 2;

		$fee_childs = $this->m_tour_rate->items($info_child);

		$rate_child = 0;
		foreach ($fee_childs as $fee_child) {
			if($amount_child >= $fee_child->group_size) {
				$rate_child = $fee_child->price;
			}else{
				break;
			}
		}

		$info_infant = new stdClass();
		$info_infant->tour_id = $id;
		$info_infant->type_passenger = 3;

		$fee_infants = $this->m_tour_rate->items($info_infant);

		$rate_infant = 0;
		foreach ($fee_infants as $fee_infant) {
			if($amount_infant >= $fee_infant->group_size) {
				$rate_infant = $fee_infant->price;
			}else{
				break;
			}
		}
		
		$total = ($amount_adult*$rate_adult) + ($amount_child*$rate_child) + ($amount_infant*$rate_infant);

		echo json_encode($total);
	}

	public function booking_review() {

		$booking = $this->session->userdata("booking");
		$user = $this->session->userdata("user");

		if (empty($booking)) {
			redirect("{$this->util->slug($this->router->fetch_class())}","location");
		}

		$item = $this->m_tour->load($booking->tour_id);
		// $category = $this->m_tour_category->load("motorbike-tours");

		// $child_cat_info = new stdClass();
		// $child_cat_info->parent_id = $category->id;
		// $child_cat_biketours = $this->m_tour_category->items($child_cat_info,1);
		// $arrbiketours = array();
		// foreach($child_cat_biketours as $child_cat){
		// 	$arrbiketours[] = $child_cat->id;
		// }

		if (isset($_POST) && !empty($_POST)) { 

			$dial_code		= $this->util->value($this->input->post("dial_code")); //$this->input->post("dial_code");
			$fullname 		= $this->util->value($this->input->post("fullname")); //$this->input->post("fullname");
			$arrival_date 	= $this->input->post("arrival_date");
			$adults 		= $this->input->post("adults");
			$childs 		= $this->input->post("childs");
			$infants 		= $this->input->post("infants");
			$new_title 		= $this->input->post("new_title","Mr");
			$email 			= $this->input->post("email");
			$phone 			= $this->input->post("phone");
			$message 		= $this->input->post("message");
			$nation_id		= $this->input->post("nation_id");
			$birthdate		= $this->input->post("birthdate");
			$birthmonth		= $this->input->post("birthmonth");
			$birthyear		= $this->input->post("birthyear");

			//$booking = $this->update_booking($booking);
			$discount = 0;
			/* promotion code be apply when total guests >= min_passenger */
			// if ($booking->min_passenger != -1 && $booking->min_passenger <= $booking->travelers) {
			// 	if ($booking->discount_unit == "USD") {
			// 		$discount = $booking->discount;
			// 	} else {
			// 		$discount = round(($booking->total_service_fee * ($booking->discount/100)), 2);
			// 	}
			// }
			$booking->adults = $adults;
			$booking->children = $childs;
			$booking->infants = $infants;
			$booking->arrival_date = $arrival_date;
			$booking->user_id = $user->id;
			$booking->total_fee = ($booking->tour_adults_rate * $adults) + ($booking->tour_child_rate * $childs) + ($booking->tour_infants_rate * $infants);
			$booking->vat = round(($booking->total_fee * (VAT/100)),2);
			// $booking->total_fee += $booking->vat;

			$booking->contact_title = (!empty($new_title) ? $new_title : $booking->contact_title);
			$booking->contact_fullname = (!empty($fullname) ? $fullname : $booking->contact_fullname);
			$booking->contact_email = (!empty($email) ? $email : $booking->contact_email);
			$booking->contact_phone = (!empty($phone) ? ((!empty($dial_code) ? "+{$dial_code} " : "") . $phone) : $booking->contact_phone);
			$booking->contact_message = (!empty($message) ? $message : $booking->contact_message);

			$booking->client_ip = $this->util->realIP();
			$booking->pickup = $this->input->post("pickup");
			$booking->payment_method = $this->input->post("payment_method","");
			$booking->payment_option = $this->input->post("payment_option");

			$booking->less_80_kg = $this->input->post("less_80_kg",0);
			$booking->greater_80_kg = $this->input->post("greater_80_kg",0);
			$booking->rb_allergic = $this->input->post("rb_allergic",0);
			$booking->allergic = (!empty($booking->rb_allergic) ? $this->input->post("allergic") : "");
			$booking->birth_day = date("Y-m-d", strtotime($birthyear."/".$birthmonth."/".$birthdate));
			$booking->nation_id = $nation_id;
			// $booking->tour_option_id = $this->input->post("tour_option_id",0);
			$booking->from_source = $this->input->post("from_source");

			$total = 0;

			$info_adult = new stdClass();
			$info_adult->tour_id = $booking->tour_id;
			$info_adult->type_passenger = 1;

			$fee_adults = $this->m_tour_rate->items($info_adult);

			$rate_adult = 0;
			foreach ($fee_adults as $fee_adult) {
				if($adults >= $fee_adult->group_size) {
					$rate_adult = $fee_adult->price;
				}else{
					break;
				}
			}

			$info_child = new stdClass();
			$info_child->tour_id = $booking->tour_id;
			$info_child->type_passenger = 2;

			$fee_childs = $this->m_tour_rate->items($info_child);

			$rate_child = 0;
			foreach ($fee_childs as $fee_child) {
				if($childs >= $fee_child->group_size) {
					$rate_child = $fee_child->price;
				}else{
					break;
				}
			}

			$info_infant = new stdClass();
			$info_infant->tour_id = $booking->tour_id;
			$info_infant->type_passenger = 3;

			$fee_infants = $this->m_tour_rate->items($info_infant);

			$rate_infant = 0;
			foreach ($fee_infants as $fee_infant) {
				if($infants >= $fee_infant->group_size) {
					$rate_infant = $fee_infant->price;
				}else{
					break;
				}
			}
			
			$total = ($adults*$rate_adult) + ($childs*$rate_child) + ($infants*$rate_infant);

			$booking->total_fee = $total;
			$booking->vat = round(($booking->total_fee * (VAT/100)),2);
			// $booking->total_fee += $booking->vat;

			$this->session->set_userdata("booking",$booking);
		}

		//$booking = $this->update_booking($booking);
		
		$discount = 0;
		/* promotion code be apply when total guests >= min_passenger */
		// if ($booking->min_passenger != -1 && $booking->min_passenger <= $booking->travelers) {
		// 	if ($booking->discount_unit == "USD") {
		// 		$discount = $booking->discount;
		// 	} else {
		// 		$discount = round(($booking->total_service_fee * ($booking->discount/100)), 2);
		// 	}
		// }
		// $booking->total_fee = ($booking->total_service_fee + $booking->film_ride_fee) - $discount;
		// $booking->vat = round($booking->total_fee * (VAT/100),2);
		// $booking->total_fee += $booking->vat;

		if ($user != null) {
			if (empty($booking->contact_title)) {
				$booking->contact_title = $user->title;
			}
			if (empty($booking->contact_fullname)) {
				$booking->contact_fullname = $user->user_fullname;
			}
			if (empty($booking->contact_email)) {
				$booking->contact_email = $user->user_email;
			}
			if (empty($booking->contact_phone)) {
				$booking->contact_phone = $user->phone;
			}
		}
  
		// Final save
		$this->session->set_userdata("booking", $booking);

		// Require login
		$this->util->requireUserLogin("{$this->util->slug($this->router->fetch_class())}/login");

		$this->breadcrumb = array_merge($this->breadcrumb, array("Step 1" => site_url("{$this->util->slug($this->router->fetch_class())}/booking/{$item->alias}")));
		$this->breadcrumb = array_merge($this->breadcrumb, array("Step 2" => site_url("{$this->util->slug($this->router->fetch_class())}/booking/review")));
		$view_data = array();
		$view_data["booking"] = $booking;
		$view_data["discount"] = $discount;
		$view_data["item"] = $item;
		$view_data["breadcrumb"] = $this->breadcrumb;
		// $view_data["category"] = $category;
		// $view_data["arrbiketours"] = $arrbiketours;

		$tmpl_content = array();
		$tmpl_content['meta']['title'] = "Vietnam Tour Booking - " . (!empty($item->meta_title) ? $item->meta_title : $item->title);
		$tmpl_content['meta']['keywords'] = $item->meta_key;
		$tmpl_content['meta']['description'] = $item->meta_desc;
		$tmpl_content["content"] = $this->load->view("tour/review",$view_data,TRUE);
		$this->load->view("layout/main",$tmpl_content);
	}

	public function login()
	{
		$booking = $this->session->userdata("booking");
		if ($booking == null) {
			redirect("{$this->util->slug($this->router->fetch_class())}");
		}

		$item = $this->m_tour->load($booking->tour_id);
		$task = $this->util->slug($this->input->post("task"),"");
		if (!empty($task)) {
			if ($task == "login")
			{
				$email = $this->input->post("email");
				$password = $this->util->slug($this->input->post("password"),"");

				$data = new stdClass();
				$data->username = $email;
				$this->session->set_flashdata("login", $data);

				$info = new stdClass();
				$info->username = $email;
				$info->password = $password;

				$user = $this->m_user->user($info, 1);

				if ($user != null) {
					if ($this->m_user->login($email, $password)) {
						if ($this->session->userdata("return_url")) {
							$redirect_url = site_url('tours/review');
							$this->session->unset_userdata("return_url");
							redirect($redirect_url, "back");
						}
					}
				}
				else {
					$this->session->set_flashdata("error", "Invalid email or password.");
					redirect("{$this->util->slug($this->router->fetch_class())}/login", "back");
				}
			}
			else if ($task == "register")
			{
				$dial_code 	= $this->util->slug($this->input->post("dial_code"),"");
				$new_title			= $this->util->slug($this->input->post("new_title","Mr"),"");
				$new_fullname		= $this->util->slug($this->input->post("new_fullname"),"");
				$new_email			= $this->util->slug($this->input->post("new_email"),"");
				$new_password		= $this->util->slug($this->input->post("new_password"),"");
				$phone			= $this->util->slug($this->input->post("phone"),"");
				$new_confirm_password	= $this->util->slug($this->input->post("new_confirm_password"),"");

				$data = new stdClass();
				$data->title = $new_title;
				$data->fullname = $new_fullname;
				$data->email = $new_email;
				$data->password = md5($new_password);
				$data->phone = $phone;
				$data->active = 1;
				$data->client_ip = $this->util->realIP();
				$this->session->set_flashdata("login", $data);

				if (empty($new_fullname)) {
					$this->session->set_flashdata("error", "Full name is required.");
					redirect("{$this->util->slug($this->router->fetch_class())}/login", "back");
				}
				else if (empty($new_email)) {
					$this->session->set_flashdata("error", "Email is required.");
					redirect("{$this->util->slug($this->router->fetch_class())}/login", "back");
				}
				else if ($this->m_user->is_user_exist($new_email)) {
					$this->session->set_flashdata("error", "This email is already in used. Please input another email address.");
					redirect("{$this->util->slug($this->router->fetch_class())}/login", "back");
				}
				else if (strlen(trim($new_password)) < 6) {
					$this->session->set_flashdata("error", "Password must be at least 6 characters long.");
					redirect("{$this->util->slug($this->router->fetch_class())}/login", "back");
				}
				else if (empty($new_confirm_password) || trim($new_confirm_password) != trim($new_password)) {
					$this->session->set_flashdata("error", "Password confirmation is not matched.");
					redirect("{$this->util->slug($this->router->fetch_class())}/login", "back");
				}
				else {

					$this->m_user->add((array)$data);

					// Auto Login
					$info = new stdClass();
					$info->email = $new_email;
					$info->password = $new_password;

					$user = $this->m_user->user($info);

					if ($user != null) {
						$this->m_user->login($new_email, $new_password);

						// SEND MAIL TO USER
						$tpl_data = array(
							"FULLNAME"		=> $user->fullname,
							"EMAIL"		=> $user->email,
							"PASSWORD"		=> $new_password,
						);

						$message = $this->mail_tpl->register_successful($tpl_data);

						// Send to SALE Department
						$mail = array(
							"subject"		=> "Registration Successful - ".SITE_NAME,
							"from_sender"	=> MAIL_INFO,
							"name_sender"	=> $user->fullname,
							"to_receiver"	=> $user->email,
							"message"		=> $message
						);
						$this->mail->config($mail);
						$this->mail->sendmail();

						$this->session->set_flashdata("success", "You have successfully registered.");
						if ($this->session->userdata("return_url")) {
							$redirect_url = $this->session->userdata("return_url");
							$this->session->unset_userdata("return_url");
							redirect($redirect_url, "back");
						}
					}
					else {
						$this->session->set_flashdata("error", "Invalid email or password.");
						redirect("{$this->util->slug($this->router->fetch_class())}/login", "location");
					}
				}
			}
		}
		

		$this->breadcrumb = array("Step 1" => site_url("{$this->util->slug($this->router->fetch_class())}/booking/{$item->alias}"), "Member Login" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}"));

		$this->session->set_userdata("return_url",site_url("{$this->util->slug($this->router->fetch_class())}/booking/review"));
		
		$this->load->library("user_agent");
		$agent = "Unidentified";
		if ($this->agent->is_browser()) {
			$agent = $this->agent->browser();
		}
		$view_data = array();
		$view_data["breadcrumb"] = $this->breadcrumb;
		$view_data["agent"] = $agent;
		
		$tmpl_content = array();
		$tmpl_content["meta"]["title"] = "Booking Tour Online";
		$tmpl_content["meta"]["description"] = "Booking Tour Online using our secure online form at the official site of ".SITE_NAME;
		$tmpl_content["content"] = $this->load->view("tour/login", $view_data, TRUE);
		$this->load->view("layout/main", $tmpl_content);
	}

	public function ajax_apply_code()
	{
		$code = trim($this->input->post("code"));
		$travelers = intval($this->input->post("travelers"));
		$result = new stdClass();
		
		$booking = $this->session->userdata("booking");
		
		if (!empty($code)) {
			$info = new stdClass();
			$info->type_service = 2;
			$info->cid = $booking->tour_id;
			$promotions = $this->m_promotion->available_items($info);
			foreach ($promotions as $promotion) {
				if (strtoupper($promotion->code) == strtoupper($code)) {
					//if ((empty($promotion->limited) || $promotion->limited == 1 && $promotion->qty > 0) && $travelers >= $promotion->min_passenger) {
						$booking->promotion_code = $code;
						$booking->discount = $promotion->discount;
						$booking->discount_unit = $promotion->discount_unit;
						// $booking->min_passenger = $promotion->min_passenger;

						$this->session->set_userdata("booking", $booking);
						$promotion = new stdClass();
						$promotion->promotion_code = $booking->promotion_code;
						$promotion->discount = $booking->discount;
						$promotion->discount_unit = $booking->discount_unit;
						// $promotion->min_passenger = $booking->min_passenger;
						$this->session->set_userdata("promotion", $promotion);

						$result->discount = $promotion->discount;
						$result->discount_unit = $promotion->discount_unit;
					//}
					break;
				}
			}
		}
		echo json_encode((array)$result);
	}

	public function booking_checkout()
	{
		$user = $this->session->userdata("user");
		$booking = $this->session->userdata("booking");
		$booking->nation_id = $this->input->post('nation_id');
		$booking->birth_day = $this->input->post('birthyear').'-'.$this->input->post('birthmonth').'-'.$this->input->post('birthdate');
		$booking->departure_date = $booking->arrival_date;
		$booking->payment_method = $this->input->post('payment_method');
		$this->session->set_userdata("booking", $booking);

		if (!empty($booking)){
			$tour = $this->m_tour->load($booking->tour_id);

			// Booking key
			$booking->key = "tour_".md5(time());

			// Mobile detect
			$this->load->library("user_agent");
			
			$agent = "Unidentified";
			$platform = $this->agent->platform();
			
			if ($this->agent->is_mobile()) {
				if (strpos($this->agent->mobile(), "iPad") === false && strpos($this->agent->mobile(), "Tablet") === false) {
					$agent = "Mobile - ". $this->agent->mobile();
				} else {
					$agent = $this->agent->mobile();
				}
			}
			else if ($this->agent->is_browser()) {
				$agent = $this->agent->browser();
			}
			else if ($this->agent->is_robot()) {
				$agent = $this->agent->robot();
			}

			// Add to booking list
			$data = new stdClass();
			$data->tour_id = $booking->tour_id;
			$data->departure_date = date("Y-m-d H:i:s",strtotime($booking->departure_date));
			$data->departure_id = $booking->tour_departure;
			$data->classtype = $booking->classtype;
			$data->booking_key = $booking->key;
			$data->adults = $booking->adults;
			$data->children = $booking->children;
			$data->infants = $booking->infants;
			$data->supplements = $booking->supplements;
			$data->supplement_rate = $booking->supplement_rate;
			$data->contact_fullname = $booking->contact_fullname;
			$data->contact_title = $booking->contact_title;
			$data->contact_email = $booking->contact_email;
			$data->contact_phone = $booking->contact_phone;
			$data->contact_message = $booking->contact_message;
			$data->payment_option = $booking->payment_option;
			$data->payment_method = $booking->payment_method;
			$data->tour_adults_rate = $booking->tour_adults_rate;
			$data->tour_child_rate = $booking->tour_child_rate;
			$data->tour_infants_rate = $booking->tour_infants_rate;
			$data->tour_fee = $booking->tour_fee;
			$data->total_fee = $booking->total_fee;
			$data->promotion_code = $booking->promotion_code;
			$data->discount = $booking->discount;
			$data->discount_unit = $booking->discount_unit;
			$data->booking_date = date("Y-m-d H:i:s");
			$data->user_id = !empty($user) ? $user->id : 0;
			$data->status = 0;
			$data->vat = $booking->vat;
			$data->client_ip = $booking->client_ip;
			$data->pickup = $booking->pickup;
			$data->allergic = $booking->allergic;
			// $data->less_80_kg = $booking->less_80_kg;
			// $data->greater_80_kg = $booking->greater_80_kg;
			// $data->tour_option_id = $booking->tour_option_id;
			$data->film_ride_fee = $booking->film_ride_fee;
			$data->total_service_fee = $booking->total_service_fee;
			$data->nation_id = $booking->nation_id;
			$data->birth_day = $booking->birth_day;
			$data->user_agent	= $agent;
			$data->platform	= $platform;
			/* CRUISE TPOUR*/
			$data->ship_fee = $booking->ship_fee;
			$data->ship_ids = $booking->ship_ids;
			$data->ship_rooms = $booking->ship_rooms;
			$data->ship_room_nums = $booking->ship_room_nums;

			$succed = true;
			if (!$this->m_tour_booking->add((array)$data)) {
				$succed = false;
			}
			// else {
			// 	$booking->id = $this->m_tour_booking->insert_id();
			// 	// foreach($booking->paxs as $pax){
			// 	// 	$booking_pax = new stdClass();
			// 	// 	$booking_pax->booking_id = $booking->id;
			// 	// 	$booking_pax->firstname = $pax->firstname;
			// 	// 	$booking_pax->lastname = $pax->lastname;
			// 	// 	$booking_pax->supplement = $pax->supplement;
			// 	// 	$booking_pax->title = $pax->title;

			// 	// 	if (!$this->m_tour_booking_pax->add((array)$booking_pax)) {
			// 	// 		$succed = false;
			// 	// 	}
			// 	// }
			// }
			if ($booking->status == 1) {
				$succed = false;
			}
			if ($succed) {
				if ($booking->payment_method == "Western Union" || $booking->payment_method == "Bank Transfer") {
					$subject = "BOOKING #".BOOKING_TOUR_PREFIX.$booking->id.": Booking Payment (".$booking->payment_method.")";
				} else {
					$subject = "BOOKING #".BOOKING_TOUR_PREFIX.$booking->id.": Booking Confirmation (gate ".$booking->payment_method.")";
				}
				
				$tpl_data = $this->mail_tpl->tour_data($booking);
				$message = $this->mail_tpl->tour_payment_inquiry($tpl_data);

				// // Send to SALE Department
				$mail = array(
					"subject" => $subject . " - " . $booking->contact_title . " " . $booking->contact_fullname,
					"from_sender" => $booking->contact_email,
					"name_sender" => $booking->contact_fullname,
					"to_receiver" => MAIL_INFO,
					"message" => $message
				);
				$this->mail->config($mail);
				$this->mail->sendmail();

				// Send confirmation to SENDER
				$mail = array(
					"subject" => $subject,
					"from_sender" => MAIL_INFO,
					"name_sender" => SITE_NAME,
					"to_receiver" => $booking->contact_email,
					"message" => $message
				);

				$this->mail->config($mail);
				$this->mail->sendmail();

				if ($booking->total_fee > 0) {
					if ($booking->payment_method == 'OnePay') {
						//Redirect to OnePay
						$vpcURL = OP_PAYMENT_URL;

						$vpcOpt['Title'] = "Settle payment for Vietnam travel at " . SITE_NAME;
						$vpcOpt['AgainLink'] = urlencode($_SERVER['HTTP_REFERER']);
						$vpcOpt['vpc_Merchant'] = OP_MERCHANT;
						$vpcOpt['vpc_AccessCode'] = OP_ACCESSCODE;
						$vpcOpt['vpc_MerchTxnRef'] = $booking->key;
						$vpcOpt['vpc_OrderInfo'] = BOOKING_TOUR_PREFIX.$booking->id;
						$vpcOpt['vpc_Amount'] = $booking->total_fee * 100;
						$vpcOpt['vpc_ReturnURL'] = OP_T_RETURN_URL;
						$vpcOpt['vpc_Version'] = "2";
						$vpcOpt['vpc_Command'] = "pay";
						$vpcOpt['vpc_Locale'] = "en";
						$vpcOpt['vpc_TicketNo'] = $this->util->realIP();
						$vpcOpt['vpc_Customer_Email'] = $booking->contact_email;
						$vpcOpt['vpc_Customer_Id'] = $user->id;

						$md5HashData = "";

						ksort($vpcOpt);

						$appendAmp = 0;

						foreach ($vpcOpt as $k => $v) {
							// create the md5 input and URL leaving out any fields that have no value
							if (strlen($v) > 0) {
								// this ensures the first paramter of the URL is preceded by the '?' char
								if ($appendAmp == 0) {
									$vpcURL .= urlencode($k) . '=' . urlencode($v);
									$appendAmp = 1;
								} else {
									$vpcURL .= '&' . urlencode($k) . "=" . urlencode($v);
								}
								if ((strlen($v) > 0) && ((substr($k, 0, 4) == "vpc_") || (substr($k, 0, 5) == "user_"))) {
									$md5HashData .= $k . "=" . $v . "&";
								}
							}
						}

						$md5HashData = rtrim($md5HashData, "&");
						$md5HashData = strtoupper(hash_hmac('SHA256', $md5HashData, pack('H*', OP_SECURE_SECRET)));

						$vpcURL .= "&vpc_SecureHash=" . $md5HashData;

						header("Location: " . $vpcURL);
						die();
					} else if ($booking->payment_method == 'Paypal') {
						$paymentAmount = round($booking->total_fee);
						$paymentType = "Sale";
						$itemName = BOOKING_TOUR_PREFIX.$booking->id.": Tour Booking";
						$itemQuantity = 1;
						$itemPrice = $booking->total_fee;
						$returnURL = PAYPAL_TOUR_RETURN_URL . "?key=" . $booking->key;
						$cancelURL = PAYPAL_TOUR_CANCEL_URL . "?key=" . $booking->key;

						$resArray = $this->paypal->CallShortcutExpressCheckout($paymentAmount, PAYPAL_CURRENCY, $paymentType, $itemName, $itemQuantity, $itemPrice, $returnURL, $cancelURL);
						$ack = strtoupper($resArray["ACK"]);
						$token = urldecode($resArray["TOKEN"]);
						if ($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") {
							$this->paypal->RedirectToPayPal($token);
						} else {
							header('Location: ' . BASE_URL . "/tours/failure.html?key=" . $booking->key);
							die();
						}
					}
				}
				$booking->status = 1;
			}
			$this->session->unset_userdata("promotion");
			if (!empty($booking->tour_departure)) {
				$this->breadcrumb = array_merge($this->breadcrumb, array("Step 1" => site_url("{$this->util->slug($this->router->fetch_class())}/availability/{$this->m_tour->load($booking->tour_id)->alias}")));
			} else {
				$this->breadcrumb = array_merge($this->breadcrumb, array("Step 1" => site_url("{$this->util->slug($this->router->fetch_class())}/booking/{$this->m_tour->load($booking->tour_id)->alias}")));
			}
			$this->breadcrumb = array_merge($this->breadcrumb, array("Step 2" => site_url("{$this->util->slug($this->router->fetch_class())}/booking/review")));
			$this->breadcrumb = array_merge($this->breadcrumb, array("Step 3" => '#'));

			$view_data = array();
			$view_data["client_name"] = $booking->contact_fullname;
			$view_data["booking"] = $booking;
			$view_data["tour"] = $tour;
			$view_data['breadcrumb'] = $this->breadcrumb;

			$tmpl_content = array();
			$tmpl_content['content'] = $this->load->view("payment/tour/finish", $view_data, TRUE);
			$this->load->view('layout/main', $tmpl_content);
		}
		else {
			redirect("error404");
		}
	}

	public function success()
	{
		if (empty($key)) {
			$key = !empty($_GET["key"]) ? $_GET["key"] : "";
		}
		if (!empty($key)) {
			$key = str_ireplace(".html", "", $key);
		}

		$data = array('status' => 1);
		$where = array('booking_key' => $key);

		$this->m_tour_booking->update($data, $where);

		$booking = $this->m_tour->getBooking(NULL, $key);
		if ($booking != null) {
			$tour = $this->m_tour->load($booking->tour_id);
			$subject = "BOOKING #".BOOKING_TOUR_PREFIX.$booking->id . ": Successful Payment (gate " . $booking->payment_method . ")";

			$tpl_data = $this->mail_tpl->tour_data($booking);
			$message = $this->mail_tpl->tour_payment_successful($tpl_data);
			// Send to SALE Department
			$mail = array(
				"subject" => $subject . " - " . $booking->contact_title . " " . $booking->contact_fullname,
				"from_sender" => $booking->contact_email,
				"name_sender" => $booking->contact_fullname,
				"to_receiver" => MAIL_INFO,
				"message" => $message
			);
			$this->mail->config($mail);
			$this->mail->sendmail();

			// Send confirmation to SENDER
			$mail = array(
				"subject" => $subject,
				"from_sender" => MAIL_INFO,
				"name_sender" => SITE_NAME,
				"to_receiver" => $booking->contact_email,
				"message" => $message
			);
			$this->mail->config($mail);
			$this->mail->sendmail();
		}
		if (!empty($booking->tour_departure)) {
			$this->breadcrumb = array_merge($this->breadcrumb, array("Step 1" => site_url("{$this->util->slug($this->router->fetch_class())}/availability/{$this->m_tour->load($booking->tour_id)->alias}")));
		} else {
			$this->breadcrumb = array_merge($this->breadcrumb, array("Step 1" => site_url("{$this->util->slug($this->router->fetch_class())}/booking/{$this->m_tour->load($booking->tour_id)->alias}")));
		}
		$this->breadcrumb = array_merge($this->breadcrumb, array("Step 2" => site_url("{$this->util->slug($this->router->fetch_class())}/booking/review")));
		$this->breadcrumb = array_merge($this->breadcrumb, array("Step Final" => '#'));

		$view_data = array();
		$view_data["client_name"] = $booking->contact_fullname;
		$view_data['booking'] = $booking;
		$view_data['tour'] = $tour;
		$view_data['breadcrumb']	= $this->breadcrumb;

		$tmpl_content = array();
		$tmpl_content['content'] = $this->load->view("payment/tour/success", $view_data, TRUE);
		$this->load->view('layout/main', $tmpl_content);
	}

	public function failure()
	{
		if (empty($key)) {
			$key = !empty($_GET["key"]) ? $_GET["key"] : "";
		}
		if (!empty($key)) {
			$key = str_ireplace(".html", "", $key);

			$booking = $this->m_tour->getBooking(NULL, $key);
			if ($booking != null) {
				$tour = $this->m_tour->load($booking->tour_id);
				$subject = "BOOKING #".BOOKING_TOUR_PREFIX.$booking->id . ": Payment Failure (gate " . $booking->payment_method . ")";

				$tpl_data = $this->mail_tpl->tour_data($booking);
				$message = $this->mail_tpl->tour_payment_failure($tpl_data);

				// Send to SALE Department
				$mail = array(
					"subject" => $subject . " - " . $booking->contact_fullname,
					"from_sender" => $booking->contact_email,
					"name_sender" => $booking->contact_fullname,
					"to_receiver" => MAIL_INFO,
					"message" => $message
				);
				$this->mail->config($mail);
				$this->mail->sendmail();

			// Send confirmation to SENDER
				$mail = array(
					"subject" => $subject,
					"from_sender" => MAIL_INFO,
					"name_sender" => SITE_NAME,
					"to_receiver" => $booking->contact_email,
					"message" => $message
					);
				$this->mail->config($mail);
				$this->mail->sendmail();
			}
		}
		if (!empty($booking->tour_departure)) {
			$this->breadcrumb = array_merge($this->breadcrumb, array("Step 1" => site_url("{$this->util->slug($this->router->fetch_class())}/availability/{$this->m_tour->load($booking->tour_id)->alias}")));
		} else {
			$this->breadcrumb = array_merge($this->breadcrumb, array("Step 1" => site_url("{$this->util->slug($this->router->fetch_class())}/booking/{$this->m_tour->load($booking->tour_id)->alias}")));
		}
		$this->breadcrumb = array_merge($this->breadcrumb, array("Step 2" => site_url("{$this->util->slug($this->router->fetch_class())}/booking/review")));
		$this->breadcrumb = array_merge($this->breadcrumb, array("Step Final" => '#'));

		$view_data = array();
		$view_data["client_name"] = $booking->contact_fullname;
		$view_data['booking'] = $booking;
		$view_data['tour'] = $tour;
		$view_data['breadcrumb'] = $this->breadcrumb;

		$tmpl_content = array();
		$tmpl_content['content'] = $this->load->view("payment/tour/failure", $view_data, TRUE);
		$this->load->view('layout/main', $tmpl_content);
	}

	function update_booking($booking)
	{
		$promotion = $this->session->userdata("promotion");
		if (!empty($promotion)) {
			$check_promotion = false;
			$info = new stdClass();
			$info->type_service = 2;
			$info->cid = $booking->tour_id;
			$promotions = $this->m_promotion->available_items($info);
			foreach($promotions as $valpromotion) {
				if (strtoupper($valpromotion->code) == strtoupper($promotion->promotion_code)) {
					//if ((empty($valpromotion->limited) || ($valpromotion->limited == 1 && $valpromotion->qty > 0)) && $booking->travelers >= $valpromotion->min_passenger) {
						$booking->promotion_code = $promotion->promotion_code;
						$booking->discount = $promotion->discount;
						$booking->discount_unit = $promotion->discount_unit;
						//$booking->min_passenger = $promotion->min_passenger;
						$check_promotion = true;
					//}
					break;
				}
			}
			if (!$check_promotion) {
				$booking->promotion_code = "";
				$booking->discount = 0;
				$booking->discount_unit = "%";
				// $booking->min_passenger = -1;
			}
		}
		return $booking;
	}
}

?>