<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Libraries extends CI_Controller {

	// public function cron_send_mail_arrival()
	// {
	// 	$info = new stdClass();
	// 	$info->arrival_date = date('Y-m-d',strtotime("+ 2days"));
	// 	$info->status = 1;
	// 	$bookings = $this->m_visa_booking->bookings($info);
	// 	foreach ($bookings as $booking) {

	// 		$tpl_data = $this->mail_tpl->visa_data($booking);
			
	// 		if ($booking->payment_method == "Western Union" || $booking->payment_method == "Bank Transfer") {
	// 			$subject = "Application #".BOOKING_PREFIX.$booking->id.": Confirm Visa for Vietnam (".$booking->payment_method.")";
	// 		} else {
	// 			$subject = "Application #".BOOKING_PREFIX.$booking->id.": Visa for Vietnam Remind (gate ".$booking->payment_method.")";
	// 		}
			
	// 		$vendor_subject = $subject;
	// 		if ($tpl_data["PROCESSING_TIME"] != "Normal") {
	// 			$vendor_subject = "[".$tpl_data["PROCESSING_TIME"]."] ".$subject;
	// 		}
			
	// 		$message = $this->mail_tpl->visa_remind_arrival_date($tpl_data);
			
	// 		// Send to SALE Department
	// 		$mail = array(
	// 			"subject"		=> $subject,
	// 			"from_sender"	=> MAIL_INFO,
	// 			"name_sender"	=> SITE_NAME,
	// 			"to_receiver"	=> $booking->primary_email,
	// 			"message"		=> $message
	// 		);

	// 		$this->mail->config($mail);
	// 		$this->mail->sendmail();
	// 	}
	// }
	// public function cron_send_mail_2d()
	// {
	// 	$info = new stdClass();
	// 	$info->fromdate = date('Y-m-d',strtotime("-2 days"));
	// 	$info->todate = date('Y-m-d');
	// 	$info->send_mail = 2;
	// 	$paid_items = $this->m_check_step->items($info);
	// 	$info = new stdClass();
	// 	$info->fromdate = date('Y-m-d',strtotime("-2 days"));
	// 	$info->todate = date('Y-m-d');
	// 	$info->send_mail = 1;
	// 	$unpaid_items = $this->m_check_step->items($info,null,null,'booking_id ','DESC');
	// 	$arr_booking = array();
	// 	$arr_booking_null = array();
	// 	$arr_mail_send = array();
	// 	foreach ($unpaid_items as $unpaid_item) {
	// 		$i = 0;
	// 		foreach ($paid_items as $paid_item) {
	// 			if (strcmp($unpaid_item->email, $paid_item->email) == 0){
	// 				$i++;
	// 			}
	// 		}
	// 		if ($i == 0) {
	// 			if (!empty($unpaid_item->booking_id))
	// 				array_push($arr_booking, $unpaid_item);
	// 			else
	// 				array_push($arr_booking_null, $unpaid_item);
	// 		}
	// 	}

	// 	foreach ($arr_booking as $value) {
	// 		if (!empty($value->booking_id)) {
	// 			if (!in_array($value->email, $arr_mail_send)) {
	// 				$booking = $this->m_visa_booking->load($value->booking_id);
	// 				$tpl_data = $this->mail_tpl->visa_data($booking);
	// 				$subject = "Just checking in to see if you have any questions";
	// 				$vendor_subject = $subject;
	// 				if ($tpl_data["PROCESSING_TIME"] != "Normal") {
	// 					$vendor_subject = "[".$tpl_data["PROCESSING_TIME"]."] ".$subject;
	// 				}
	// 				$message = $this->mail_tpl->visa_remind_arrival_date($tpl_data);

	// 				$mail = array(
	// 					"subject"		=> $subject,
	// 					"from_sender"	=> MAIL_INFO,
	// 					"name_sender"	=> SITE_NAME,
	// 					"to_receiver"	=> $value->email,
	// 					"message"		=> $message
	// 				);
	// 				$this->mail->config($mail);
	// 				if (date('Y-m-d',strtotime($value->created_date)) == date('Y-m-d',strtotime("-2 days"))) {
	// 					$this->mail->sendmail('mia@vietnam-visa.org.vn', '2~DBDil9bVTURsrYPb');
	// 					array_push($arr_mail_send,$value->email);
	// 				}
	// 			}
	// 		}
	// 	}
	// }
	// public function cron_send_mail_7d()
	// {
	// 	$info = new stdClass();
	// 	$info->fromdate = date('Y-m-d',strtotime("-7 days"));
	// 	$info->todate = date('Y-m-d');
	// 	$info->send_mail = 2;
	// 	$paid_items = $this->m_check_step->items($info);
	// 	$info = new stdClass();
	// 	$info->fromdate = date('Y-m-d',strtotime("-7 days"));
	// 	$info->todate = date('Y-m-d');
	// 	$info->send_mail = 1;
	// 	$unpaid_items = $this->m_check_step->items($info,null,null,'booking_id ','DESC');
	// 	$arr_booking = array();
	// 	$arr_booking_null = array();
	// 	$arr_mail_send = array();
	// 	foreach ($unpaid_items as $unpaid_item) {
	// 		$i = 0;
	// 		foreach ($paid_items as $paid_item) {
	// 			if (strcmp($unpaid_item->email, $paid_item->email) == 0){
	// 				$i++;
	// 			}
	// 		}
	// 		if ($i == 0) {
	// 			if (!empty($unpaid_item->booking_id))
	// 				array_push($arr_booking, $unpaid_item);
	// 			else
	// 				array_push($arr_booking_null, $unpaid_item);
	// 		}
	// 	}

	// 	foreach ($arr_booking as $value) {
	// 		if (!empty($value->booking_id)) {
	// 			if (!in_array($value->email, $arr_mail_send)) {
	// 				$booking = $this->m_visa_booking->load($value->booking_id);
	// 				$tpl_data = $this->mail_tpl->visa_data($booking);
	// 				$subject = "Just checking in to see if you have any questions";
	// 				$vendor_subject = $subject;
	// 				if ($tpl_data["PROCESSING_TIME"] != "Normal") {
	// 					$vendor_subject = "[".$tpl_data["PROCESSING_TIME"]."] ".$subject;
	// 				}
	// 				$message = $this->mail_tpl->visa_remind_arrival_date($tpl_data);

	// 				$mail = array(
	// 					"subject"		=> $subject,
	// 					"from_sender"	=> MAIL_INFO,
	// 					"name_sender"	=> SITE_NAME,
	// 					"to_receiver"	=> $value->email,
	// 					"message"		=> $message
	// 				);
	// 				$this->mail->config($mail);
	// 				if (date('Y-m-d',strtotime($value->created_date)) == date('Y-m-d',strtotime("-7 days"))) {
	// 					$this->mail->sendmail('mia@vietnam-visa.org.vn', '2~DBDil9bVTURsrYPb');
	// 					array_push($arr_mail_send,$value->email);
	// 				}
	// 			}
	// 		}
	// 	}
	// }
	public function cron_send_mail_10d()
	{
		$info = new stdClass();
		$info->arrival_date = date('Y-m-d',strtotime("-2 days"));
		$send_mail_reviews = $this->m_visa_booking->send_mail_review($info);
		foreach ($send_mail_reviews as $send_mail_review) {
			$subject = "How was your trip to Vietnam?";
			$tpl_data = array(
				"FULLNAME"	=> $send_mail_review->contact_fullname,
				"URL"		=> BASE_URL."/vietnam-visa-review/?reviewid=".rand(1000,9999).rand(100,999).$send_mail_review->id.rand(10,99),
			);
			$message = $this->mail_tpl->review_on_arrival_date($tpl_data);
			$mail = array(
				"subject" => $subject,
				"from_sender" => MAIL_INFO,
				"name_sender" => SITE_NAME,
				"to_receiver" => $send_mail_review->primary_email,
				"message" => $message
				);
			$this->mail->config($mail);
			$this->mail->sendmail('mia@vietnam-visa.org.vn', '2~DBDil9bVTURsrYPb');
		}
	}
	public function cron_send_mail_15d()
	{
		$info = new stdClass();
		$info->fromdate = date('Y-m-d',strtotime("-10 days"));
		$info->todate = date('Y-m-d');
		$info->send_mail = 2;
		$paid_items = $this->m_check_step->items($info);
		$info = new stdClass();
		$info->fromdate = date('Y-m-d',strtotime("-10 days"));
		$info->todate = date('Y-m-d');
		$info->send_mail = 1;
		$unpaid_items = $this->m_check_step->items($info,null,null,'booking_id ','DESC');
		$arr_booking = array();
		$arr_booking_null = array();
		$arr_mail_send = array();
		foreach ($unpaid_items as $unpaid_item) {
			$i = 0;
			foreach ($paid_items as $paid_item) {
				if (strcmp($unpaid_item->email, $paid_item->email) == 0){
					$i++;
				}
			}
			if ($i == 0) {
				if (!empty($unpaid_item->booking_id))
					array_push($arr_booking, $unpaid_item);
				else
					array_push($arr_booking_null, $unpaid_item);
			}
		}

		foreach ($arr_booking as $value) {
			if (!empty($value->booking_id)) {
				if (!in_array($value->email, $arr_mail_send)) {
					$booking = $this->m_visa_booking->load($value->booking_id);
					$tpl_data = $this->mail_tpl->visa_data($booking);
					$subject = "Just checking in to see if you have any questions";
					$vendor_subject = $subject;
					if ($tpl_data["PROCESSING_TIME"] != "Normal") {
						$vendor_subject = "[".$tpl_data["PROCESSING_TIME"]."] ".$subject;
					}
					$message = $this->mail_tpl->visa_remind_arrival_date($tpl_data);

					$mail = array(
						"subject"		=> $subject,
						"from_sender"	=> MAIL_INFO,
						"name_sender"	=> SITE_NAME,
						"to_receiver"	=> $value->email,
						"message"		=> $message
					);
					$this->mail->config($mail);
					if (date('Y-m-d',strtotime($value->created_date)) == date('Y-m-d',strtotime("-10 days"))) {
						$this->mail->sendmail('mia@vietnam-visa.org.vn', '2~DBDil9bVTURsrYPb');
						array_push($arr_mail_send,$value->email);
					}
				}
			}
		}
	}
	public function cron_send_mail_30d()
	{
		$info = new stdClass();
		$info->arrival_date = date('Y-m-d',strtotime("-2 days"));
		$info->status = 1;
		$bookings = $this->m_visa_booking->bookings($info);
		foreach ($bookings as $booking) {
			$subject = "Feedback for extra service - Vietnam-Visa.Org.Vn";
			$tpl_data = array(
				"FULLNAME"		=> $booking->contact_fullname,
			);
			if ((!empty($booking->car_pickup) && empty($booking->full_package)) || (!empty($booking->car_pickup) && empty($booking->fast_checkin))) {
				$message = $this->mail_tpl->feedback_car_service($tpl_data);
				$mail = array(
					"subject"		=> $subject,
					"from_sender"	=> MAIL_INFO,
					"name_sender"	=> SITE_NAME,
					"to_receiver"	=> $booking->primary_email,
					"message"		=> $message
				);
				$this->mail->config($mail);
				$this->mail->sendmail('mia@vietnam-visa.org.vn', '2~DBDil9bVTURsrYPb');
			} else if (!empty($booking->full_package) || !empty($booking->fast_checkin)) {
				$message = $this->mail_tpl->feedback_fc_service($tpl_data);
				$mail = array(
					"subject"		=> $subject,
					"from_sender"	=> MAIL_INFO,
					"name_sender"	=> SITE_NAME,
					"to_receiver"	=> $booking->primary_email,
					"message"		=> $message
				);
				$this->mail->config($mail);
				$this->mail->sendmail('mia@vietnam-visa.org.vn', '2~DBDil9bVTURsrYPb');
			}
		}
	}
	public function test(){
		curl_init();
	}
}
