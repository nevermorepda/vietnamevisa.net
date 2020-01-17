<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mail_Booking_Tpl {

	var $CI;
	
	function __construct()
	{
		$CI =& get_instance();
	}
	
	function template($content)
	{
		return '<!DOCTYPE html>
				<html lang="en-US">
					<head>
						<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
					</head>
					<body style="font-family: Arial,Tahoma,sans-serif; font-size: 13px; padding: 30px;">
						<table style="background-color: #FFF3B0; border: 1px solid #BBCDD9; border-collapse: collapse;">
							<tr>
								<td style="padding: 15px;">
									'.$content.'
								</td>
							</tr>
							<tr>
								<td style="padding: 0px 15px 15px;">
									<table>
										<tr><td colspan="3"><b>VIETNAM VISA DEPT.</b></td></tr>
										<tr><td>Address</td><td>:</td><td>'.ADDRESS.'</td></tr>
										<tr><td>Hotline</td><td>:</td><td>'.HOTLINE.'</td></tr>
										<tr><td>Website</td><td>:</td><td><a href="'.BASE_URL.'" target="_blank">www.'.strtolower(SITE_NAME).'</a></td></tr>
										<tr><td>Email</td><td>:</td><td><a href="mailto:'.MAIL_INFO.'" target="_blank">'.MAIL_INFO.'</a></td></tr>
										<tr><td colspan="3" style="color: red"><b>WE ALWAYS SUPPORT YOU 24/7</b></td></tr>
									</table>
								</td>
							</tr>
						</table>
					<body>
				</html>';
	}
	
	function header($tpl_data)
	{
		return '<div>
					<p>Dear: <b>'.$tpl_data["FULLNAME"].'</b></p>
					<p>Thanks for booking with us!</p>
					<p>Your request message has been sent to Vietnam Visa team. We will reviewing and contact to you in 1 - 2 hours.</p>
				</div>';
	}
	
	function flight($tpl_data)
	{
		$content = $this->header($tpl_data).'<br>'.$this->flight_detail($tpl_data);
		return $this->template($content);
	}
	 
	function flight_detail($tpl_data)
	{
		return '<fieldset style="border:1px solid #DADCE0; background-color: #FFFFFF;">
					<legend style="border:1px solid #DADCE0; background-color: #F6F6F6; padding: 4px"><strong>Flight Reservation Information</strong></legend>
					<div>
						<div style="color: #005286;font-weight: bold;padding: 10px 0 10px 20px;">
							A. Flight Information
						</div>
						<div style="padding: 0 0 10px 40px;">
							<table>
								<tr>
									<td width="150px">Airline</td>
									<td>:</td>
									<td width="400px">'.$tpl_data["AIRLINE"].'</td>
								</tr>
								<tbody><tr>
									<td>Departure Date</td>
									<td>:</td>
									<td>'.$tpl_data["DEPARTURE_DATE"].'</td>
								</tr>
								<tbody><tr>
									<td>Return Date</td>
									<td>:</td>
									<td>'.$tpl_data["RETURN_DATE"].'</td>
								</tr>
								<tbody><tr>
									<td>Direction</td>
									<td>:</td>
									<td>'.$tpl_data["DIRECTION"].'</td>
								</tr>
								<tr>
									<td>From City</td>
									<td>:</td>
									<td>'.$tpl_data["FROM_CITY"].'</td>
								</tr>
								<tr>
									<td>To City</td>
									<td>:</td>
									<td>'.$tpl_data["TO_CITY"].'</td>
								</tr>
								<tr>
									<td>Number of Travelers</td>
									<td>:</td>
									<td>'.$tpl_data["TRAVELERS"].'</td>
								</tr>
							</table>
						</div>
					</div>
					<div>
						<div style="color: #005286;font-weight: bold;padding: 10px 0 10px 20px;">
							B. Contact Information
						</div>
						<div style="padding: 0 0 10px 40px;">
							<table>
								<tr>
									<td width="150px">Full Name</td>
									<td>:</td>
									<td width="400px">'.$tpl_data["FULLNAME"].'<br></td>
								</tr>
								<tr>
									<td>Email</td>
									<td>:</td>
									<td width="400px"><a href="mailto:'.$tpl_data["EMAIL"].'">'.$tpl_data["EMAIL"].'</a><br></td>
								</tr>
								<tr>
									<td>Phone Number</td>
									<td>:</td>
									<td width="400px">'.$tpl_data["PHONE"].'<br></td>
								</tr>
								<tr>
									<td>Special Request</td>
									<td>:</td>
									<td width="400px">'.$tpl_data["SPECIAL_REQUEST"].'<br></td>
								</tr>
							</table>
						</div>
					</div>
				</fieldset>';
	}
	
	function tour($tpl_data)
	{
		$content = $this->header($tpl_data).'<br>'.$this->tour_detail($tpl_data);
		return $this->template($content);
	}
	 
	function tour_detail($tpl_data)
	{
		return '<fieldset style="border:1px solid #DADCE0; background-color: #FFFFFF;">
					<legend style="border:1px solid #DADCE0; background-color: #F6F6F6; padding: 4px"><strong>Tour Reservation Information</strong></legend>
					<div>
						<div style="color: #005286;font-weight: bold;padding: 10px 0 10px 20px;">
							A. Tour Information
						</div>
						<div style="padding: 0 0 10px 40px;">
							<table>
								<tr>
									<td width="150px">Arrival Date</td>
									<td>:</td>
									<td width="400px">'.$tpl_data["ARRIVAL_DATE"].'</td>
								</tr>
								<tbody><tr>
									<td>Departure Date</td>
									<td>:</td>
									<td>'.$tpl_data["DEPARTURE_DATE"].'</td>
								</tr>
								<tbody><tr>
									<td>Destination</td>
									<td>:</td>
									<td>'.$tpl_data["DESTINATION"].'</td>
								</tr>
								<tbody><tr>
									<td>Category</td>
									<td>:</td>
									<td>'.$tpl_data["CATEGORY"].'</td>
								</tr>
								<tr>
									<td>Budget</td>
									<td>:</td>
									<td>'.$tpl_data["BUDGET"].' USD</td>
								</tr>
								<tr>
									<td>Number of Travelers</td>
									<td>:</td>
									<td>'.$tpl_data["TRAVELERS"].'</td>
								</tr>
							</table>
						</div>
					</div>
					<div>
						<div style="color: #005286;font-weight: bold;padding: 10px 0 10px 20px;">
							B. Contact Information
						</div>
						<div style="padding: 0 0 10px 40px;">
							<table>
								<tr>
									<td width="150px">Full Name</td>
									<td>:</td>
									<td width="400px">'.$tpl_data["FULLNAME"].'<br></td>
								</tr>
								<tr>
									<td>Email</td>
									<td>:</td>
									<td width="400px"><a href="mailto:'.$tpl_data["EMAIL"].'">'.$tpl_data["EMAIL"].'</a><br></td>
								</tr>
								<tr>
									<td>Phone Number</td>
									<td>:</td>
									<td width="400px">'.$tpl_data["PHONE"].'<br></td>
								</tr>
								<tr>
									<td>Special Request</td>
									<td>:</td>
									<td width="400px">'.$tpl_data["SPECIAL_REQUEST"].'<br></td>
								</tr>
							</table>
						</div>
					</div>
				</fieldset>';
	}
	
	function hotel($tpl_data)
	{
		$content = $this->header($tpl_data).'<br>'.$this->hotel_detail($tpl_data);
		return $this->template($content);
	}
	 
	function hotel_detail($tpl_data)
	{
		return '<fieldset style="border:1px solid #DADCE0; background-color: #FFFFFF;">
					<legend style="border:1px solid #DADCE0; background-color: #F6F6F6; padding: 4px"><strong>Hotel Reservation Information</strong></legend>
					<div>
						<div style="color: #005286;font-weight: bold;padding: 10px 0 10px 20px;">
							A. Hotel Information
						</div>
						<div style="padding: 0 0 10px 40px;">
							<table>
								<tr>
									<td width="150px">Check-in Date</td>
									<td>:</td>
									<td width="400px">'.$tpl_data["CHECKIN_DATE"].'</td>
								</tr>
								<tbody><tr>
									<td>Check-out Date</td>
									<td>:</td>
									<td>'.$tpl_data["CHECKOUT_DATE"].'</td>
								</tr>
								<tbody><tr>
									<td>Destination</td>
									<td>:</td>
									<td>'.$tpl_data["DESTINATION"].'</td>
								</tr>
								<tbody><tr>
									<td>Budget</td>
									<td>:</td>
									<td>'.$tpl_data["BUDGET"].' USD</td>
								</tr>
								<tr>
									<td>Stars</td>
									<td>:</td>
									<td>'.$tpl_data["STARS"].'</td>
								</tr>
								<tr>
									<td>Number of Rooms</td>
									<td>:</td>
									<td>'.$tpl_data["ROOMS"].'</td>
								</tr>
								<tr>
									<td>Type of Room</td>
									<td>:</td>
									<td>'.$tpl_data["ROOM_TYPE"].'</td>
								</tr>
							</table>
						</div>
					</div>
					<div>
						<div style="color: #005286;font-weight: bold;padding: 10px 0 10px 20px;">
							B. Contact Information
						</div>
						<div style="padding: 0 0 10px 40px;">
							<table>
								<tr>
									<td width="150px">Full Name</td>
									<td>:</td>
									<td width="400px">'.$tpl_data["FULLNAME"].'<br></td>
								</tr>
								<tr>
									<td>Email</td>
									<td>:</td>
									<td width="400px"><a href="mailto:'.$tpl_data["EMAIL"].'">'.$tpl_data["EMAIL"].'</a><br></td>
								</tr>
								<tr>
									<td>Phone Number</td>
									<td>:</td>
									<td width="400px">'.$tpl_data["PHONE"].'<br></td>
								</tr>
								<tr>
									<td>Special Request</td>
									<td>:</td>
									<td width="400px">'.$tpl_data["SPECIAL_REQUEST"].'<br></td>
								</tr>
							</table>
						</div>
					</div>
				</fieldset>';
	}
	
	function airport_service($tpl_data)
	{
		$content = $this->header($tpl_data).'<br>'.$this->airport_service_detail($tpl_data);
		return $this->template($content);
	}
	 
	function airport_service_detail($tpl_data)
	{
		$fast_checkin = "";
		if ($tpl_data["FAST_CHECKIN"] == 1) {
			$fast_checkin .= '<tr>
								<td>Airport Fast Track</td>
								<td>:</td>
								<td>Normal</td>
							</tr>';
		} else if ($tpl_data["FAST_CHECKIN"] == 2) {
			$fast_checkin .= '<tr>
								<td>Airport Fast Track</td>
								<td>:</td>
								<td>VIP Fast Track</td>
							</tr>';
		}
		
		$car_pickup = "";
		if ($tpl_data["CAR_PICKUP"]) {
			$car_pickup .= '<tr>
								<td>Car Pick-up/Drop-off</td>
								<td>:</td>
								<td>'.$tpl_data["CAR_TYPE"].', '.$tpl_data["SEATS"].' seats</td>
							</tr>';
		}
		
		return '<fieldset style="border:1px solid #DADCE0; background-color: #FFFFFF;">
					<legend style="border:1px solid #DADCE0; background-color: #F6F6F6; padding: 4px"><strong>Extra Service Options Information</strong></legend>
					<div>
						<div style="color: #005286;font-weight: bold;padding: 10px 0 10px 20px;">
							A. Extra Service Options
						</div>
						<div style="padding: 0 0 10px 40px;">
							<table>
								<tr>
									<td width="150px">Number of Person</td>
									<td>:</td>
									<td width="400px">'.$tpl_data["GROUP_SIZE"].'</td>
								</tr>
								<tr>
									<td>Arrival Port</td>
									<td>:</td>
									<td>'.$tpl_data["ARRIVAL_PORT"].'</td>
								</tr>
								'.$fast_checkin.'
								'.$car_pickup.'
								<tr>
									<td>Who will picking-up</td>
									<td>:</td>
									<td>'.$tpl_data["WELCOME_NAME"].'</td>
								</tr>
								<tr>
									<td>Flight Number</td>
									<td>:</td>
									<td>'.$tpl_data["FLIGHT_NUMBER"].'</td>
								</tr>
								<tr>
									<td>Arrival Date and Time</td>
									<td>:</td>
									<td>'.$tpl_data["ARRIVAL_DATE"].'</td>
								</tr>
								<tr>
									<td colspan="3" style="border-top: 1px dotted #CCCCCC; height: 1px;"></td>
								</tr>
								<tr>
									<td><b>Total Services Charge</b></td>
									<td>:</td>
									<td><b>'.$tpl_data["TOTAL_FEE"].' USD</b></td>
								</tr>
							</table>
						</div>
					</div>
					<div>
						<div style="color: #005286;font-weight: bold;padding: 10px 0 10px 20px;">
							B. Payment Information
						</div>
						<div style="padding: 0 0 10px 40px;">
							<table>
								<tr>
									<td width="150px">Payment Method</td>
									<td>:</td>
									<td width="400px">'.$tpl_data["PAYMENT_METHOD"].'<br></td>
								</tr>
								<tr>
									<td>Status</td>
									<td>:</td>
									<td width="400px">'.(($tpl_data["STATUS"]== 0) ? "Under Payment" : "Payment Successfull").'<br></td>
								</tr>
							</table>
						</div>
					</div>
					<div>
						<div style="color: #005286;font-weight: bold;padding: 10px 0 10px 20px;">
							C. Contact Information
						</div>
						<div style="padding: 0 0 10px 40px;">
							<table>
								<tr>
									<td width="150px">Full Name</td>
									<td>:</td>
									<td width="400px">'.$tpl_data["FULLNAME"].'<br></td>
								</tr>
								<tr>
									<td>Email</td>
									<td>:</td>
									<td width="400px"><a href="mailto:'.$tpl_data["EMAIL"].'">'.$tpl_data["EMAIL"].'</a><br></td>
								</tr>
								<tr>
									<td>Phone Number</td>
									<td>:</td>
									<td width="400px">'.$tpl_data["PHONE"].'<br></td>
								</tr>
								<tr>
									<td>Special Request</td>
									<td>:</td>
									<td width="400px">'.$tpl_data["SPECIAL_REQUEST"].'<br></td>
								</tr>
							</table>
						</div>
					</div>
				</fieldset>';
	}
	
	public function extra_service_introduction($tpl_data)
	{
		return '<html lang="en-US">
				<body style="font-family: Arial; font-size: 14px; line-height: 1.6em">
					<p>Dear <strong>'.$tpl_data["FULLNAME"].'</strong>,</p>
					<p>Thanks for choosing <a href="'.BASE_URL.'" target="_blank">'.SITE_NAME.'</a></p>
					<p style="color: #0000FF">After taking a long flight, do you feel very tired to get the line to get visa stamp at arrival airport?</p>
					<p style="color: #0000FF">You do not want to wait a long time at arrival airport to get line visa stamp, you want to get it ASAP and go to hotel to relax?</p>
					<p>Many customers said that it is very uncomfortable to wait for a long time to get visa stamp because there are many people also get visa on arrival like them and it is also very hard to take back their passports because the differences about pronunciation</p>
					<p>Many people is very confused at arrival airport in the first time they use visa on arrival because they don’t know where the Immigration Department counter to get visa stamp is</p>
					<p>&rarr; To avoid wasting your valuable time, especially after having a long flight or other personal reasons. We establish <font color="red">additional services</font> to assist you at the airport when you arrived, and will bring to you with the  highest satisfy. You are welcome as highest VIP person, and you don’t need to get line for pick up visa stamp at the airport, let our staff do it for you.</p>
					<p>We offer 2 options for you to chose, and let us do the rest for you:</p>
					<p style="color: red; font-size: 20px">A. Fast Track at the airport</p>
					<ul>
						<li><strong>Fast Track</strong>: Welcome and help to get visa stamp without get line. <a href="'.site_url("services").'" target="_blank">More details</a></li>
						<li><strong>VIP Fast Track</strong>: Welcome and get visa stamp without get line at Immigration checking desk, then staff will escort you to luggage lounge and help you passing the customs checking counter, and after that we will take you to the car park. <a href="'.site_url("services").'" target="_blank">More details</a></li>
					</ul>
					<table width="100%" border="0" cellspacing="0" cellpadding="4" style="border-collapse: collapse">
						<tbody>
							<tr>
								<td width="200" style="border: 1px solid #333333; background-color: #538135; color: #FFFFFF">
									<p align="center">No. of Person</p>
								</td>
								<td colspan="2" style="border: 1px solid #333333; background-color: #A8D08D;">
									<p align="center">1-4 paxs</p>
								</td>
								<td colspan="2" style="border: 1px solid #333333; background-color: #A8D08D;">
									<p align="center">5-10 paxs</p>
								</td>
							</tr>
							<tr>
								<td style="border: 1px solid #333333; background-color: #538135; color: #FFFFFF">
									<p align="center">Airport</p>
								</td>
								<td style="border: 1px solid #333333; background-color: #A8D08D;">
									<p align="center">Ho Chi Minh</p>
								</td>
								<td style="border: 1px solid #333333; background-color: #A8D08D;">
									<p align="center">Ha Noi</p>
								</td>
								<td style="border: 1px solid #333333; background-color: #A8D08D;">
									<p align="center">Ho Chi Minh</p>
								</td>
								<td style="border: 1px solid #333333; background-color: #A8D08D;">
									<p align="center">Ha Noi</p>
								</td>
							</tr>
							<tr>
								<td style="border: 1px solid #333333; background-color: #538135; color: #FFFFFF">
									<p align="center">Airport Fast Track</p>
								</td>
								<td style="border: 1px solid #333333;">
									<p align="center">15 USD/pax</p>
								</td>
								<td style="border: 1px solid #333333;">
									<p align="center">20 USD/pax</p>
								</td>
								<td style="border: 1px solid #333333;">
									<p align="center">12 USD/pax</p>
								</td>
								<td style="border: 1px solid #333333;">
									<p align="center">15 USD/pax</p>
								</td>
							</tr>
							<tr>
								<td style="border: 1px solid #333333; background-color: #538135; color: #FFFFFF">
									<p align="center">VIP Airport Fast Track</p>
								</td>
								<td style="border: 1px solid #333333;">
									<p align="center">40 USD/pax</p>
								</td>
								<td style="border: 1px solid #333333;">
									<p align="center">40 USD/pax</p>
								</td>
								<td style="border: 1px solid #333333;">
									<p align="center">35 USD/pax</p>
								</td>
								<td style="border: 1px solid #333333;">
									<p align="center">35 USD/pax</p>
								</td>
							</tr>
						</tbody>
					</table>
					<div>
						<p align="center"><a style="text-decoration: none; background-color: #D40000; color: #FFFFFF; padding: 10px 25px" href="'.site_url("services").'" target="_blank">CHECK MORE</a></p>
					</div>
					<br>
					<br>
					<p style="color: #0000FF">There are many taxi firms at Vietnam arrival airport and you do not know which firm is cheap and suitable for you?</p>
					<p>You do not want to be cheated by bad taxi drivers and be charged with the high fee</p>
					<p>You and your family have a lot of luggage and all that you need is going to your hotel ASAP</p>
					<p style="color: red; font-size: 20px">B. Car Pick up and Drop off</p>
					<p>&rarr; To avoid facing with taxi at the airport, we offer car pick up at the airport. With our experienced driver and modern car will bring you safety on your trip. If you need our help, please contact us any time. <a href="'.site_url("services").'" target="_blank">More details</a>.</p>
					<table width="100%" border="0" cellspacing="0" cellpadding="4" style="border-collapse: collapse">
						<tbody>
							<tr>
								<td rowspan="2" width="27%" style="border: 1px solid #333333; background-color: #1F3864; color: #FFFFFF">
									<p align="center">Transfer/pick up</p>
								</td>
								<td width="36%" style="border: 1px solid #333333; background-color: #8EAADB">
									<p align="center">Airport- HCM</p>
								</td>
								<td width="36%" style="border: 1px solid #333333; background-color: #8EAADB">
									<p align="center">Airport- Hanoi</p>
								</td>
							</tr>
							<tr>
								<td width="36%" style="border: 1px solid #333333">
									<p align="center">Private Car</p>
								</td>
								<td width="36%" style="border: 1px solid #333333">
									<p align="center">Private Car</p>
								</td>
							</tr>
							<tr>
								<td width="27%" style="border: 1px solid #333333">
									<p align="center">4 seats</p>
								</td>
								<td width="36%" style="border: 1px solid #333333">
									<p align="center">25 USD/car</p>
								</td>
								<td width="36%" style="border: 1px solid #333333">
									<p align="center">30 USD/car</p>
								</td>
							</tr>
							<tr>
								<td width="27%" style="border: 1px solid #333333">
									<p align="center">7 seats</p>
								</td>
								<td width="36%" style="border: 1px solid #333333">
									<p align="center">30 USD/car</p>
								</td>
								<td width="36%" style="border: 1px solid #333333">
									<p align="center">35 USD/car</p>
								</td>
							</tr>
							<tr>
								<td width="27%" style="border: 1px solid #333333">
									<p align="center">16 seats</p>
								</td>
								<td width="36%" style="border: 1px solid #333333">
									<p align="center">50 USD/van</p>
								</td>
								<td width="36%" style="border: 1px solid #333333">
									<p align="center">60 USD/van</p>
								</td>
							</tr>
							<tr>
								<td width="27%" style="border: 1px solid #333333">
									<p align="center">24 seats</p>
								</td>
								<td width="36%" style="border: 1px solid #333333">
									<p align="center">85 USD/van</p>
								</td>
								<td width="36%" style="border: 1px solid #333333">
									<p align="center">90 USD/bus</p>
								</td>
							</tr>
						</tbody>
					</table>
					<p align="center"> <a style="text-decoration: none; background-color: #D40000; color: #FFFFFF; padding: 10px 25px" href="'.site_url("services").'" target="_blank">CHECK MORE</a></p>
					<br>
					<p>For more information please feel free to contact us immediately in the hotline <font color="red">(+84) 909 343 525</font> <strong>Mr. David La</strong> for any help or any trouble if you facing with. We are at your service at 24/7. </p>
					<p>----------------------------------------- </p>
					<p>Thank you for your interesting!</p>
					<p style="font-size: 20px"><strong>Jenny Pham</strong></p>
					<table border="0" cellpadding="0">
						<tbody>
							<tr>
								<td>
									<p><strong>Marketing Department of '.SITE_NAME.'</strong></p>
								</td>
							</tr>
							<tr>
								<td style="padding-top: 20px">
									<p>Hotline: '.HOTLINE.'</p>
									<p>Toll-free: '.TOLL_FREE.'</p>
									<p>Email: <a href="mailto:'.MAIL_INFO.'" target="_blank">'.MAIL_INFO.'</a></p>
								</td>
							</tr>
						</tbody>
					</table>
				</body>
				</html>';
	}
}