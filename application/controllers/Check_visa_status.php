<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Check_visa_status extends CI_Controller {

	public function index()
	{
		$this->util->block_ip();
		$tmpl_content = array();
		$tmpl_content['content']   = $this->load->view("status/index", NULL, TRUE);
		$this->load->view('layout/view', $tmpl_content);
	}
	
	public function check()
	{
		$email			= (!empty($_POST["email"]) ? $_POST["email"] : "");
		$fullname		= (!empty($_POST["fullname"]) ? $_POST["fullname"] : "");
		$passport		= (!empty($_POST["passport"]) ? $_POST["passport"] : "");
		$message		= (!empty($_POST["message"]) ? $_POST["message"] : "");
		$security_code	= (!empty($_POST["security_code"]) ? $_POST["security_code"] : "");
		
		$data->email	= $email;
		$data->fullname	= $fullname;
		$data->passport	= $passport;
		$data->message	= $message;
		$this->session->set_flashdata("check_status", $data);
		
		if (empty($email)) {
			$this->session->set_flashdata("status", "Email is required.");
			redirect("check-visa-status", "back");
			die();
		} else if (empty($fullname)) {
			$this->session->set_flashdata("status", "Full name is required.");
			redirect("check-visa-status", "back");
			die();
		} else if (empty($passport)) {
			$this->session->set_flashdata("status", "Passport is required.");
			redirect("check-visa-status", "back");
			die();
		} else if (strtoupper($security_code) != strtoupper($this->util->getSecurityCode())) {
			$this->session->set_flashdata("status", "Captcha is not matched.");
			redirect("check-visa-status", "back");
			die();
		}
		else {
			$tpl_data = array(
					"FULLNAME"				=> $fullname,
					"PRIMARY_EMAIL"			=> $email,
					"SECONDARY_EMAIL"		=> "",
					"PASSPORT"				=> $passport,
					"MESSAGE"				=> $message,
			);
			
			$message = $this->mail_tpl->check_status($tpl_data);
		
			// Send to SALE Department
			$mail = array(
	                            "subject"		=> "Check Visa Status - ".$fullname,
								"from_sender"	=> $email,
	                            "name_sender"	=> $fullname,
								"to_receiver"	=> MAIL_INFO,
	                            "message"		=> $message
			);
			$this->mail->config($mail);
			$this->mail->sendmail();
		}
		
		redirect(site_url("{$this->util->slug($this->router->fetch_class())}/sent"));
	}
	
	public function sent()
	{
		$breadcrumb = array('Check Status' => site_url('check-visa-status'), 'Sent' => '');
		
		$view_data = array();
		$view_data["breadcrumb"] = $breadcrumb;
		
		$tmpl_content = array();
		$tmpl_content['content'] = $this->load->view("message_sent", $view_data, TRUE);
		$this->load->view('layout/view', $tmpl_content);
	}
}

?>