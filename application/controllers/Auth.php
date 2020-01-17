<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller
{
	/**
	 * Facebook Login action will be call by Ajax using Facebook Javascript SDK
	 */
	public function socialLogin() {
		$uid		= $this->input->post("id");
		$provider	= $this->input->post("providername");
		$fullname	= $this->input->post("fullname");
		$email		= $this->input->post("email");
		$gender		= $this->input->post("gender");
		$avatar		= $this->input->post("avatar");
		
		$result = $this->m_user->get_social_user($uid, $provider, $email);
		
		if ($result != NULL) {
			$user = $result;
		}
		else {
			$userobj = array(
				"uid"				=> $uid,
				"user_login"		=> $email,
				"user_fullname"		=> (!empty($fullname)?$fullname:$email),
				"user_email"		=> $email,
				"provider"			=> $provider,
				"gender"			=> $gender,
				"title"				=> ($gender?"Mr":"Ms"),
				"avatar"			=> $avatar,
				"user_registered"	=> date($this->config->item("log_date_format")),
				"client_ip"			=> $this->util->realIP()
			);
			$this->m_user->add($userobj);
			$user = $this->m_user->get_social_user($uid, $provider, $email);
			
			// Send email to user
			$subject = "Welcome to ".SITE_NAME;
			
			$tpl_data = array();
			$tpl_data["PROVIDER"] = $provider;
			$tpl_data["FULLNAME"] = $user->user_fullname;
			$tpl_data["EMAIL"]    = $user->user_email;
			$message = $this->mail_tpl->register_successful($tpl_data);
			
			$mail = array(
					"subject"		=> $subject,
					"from_sender"	=> MAIL_INFO,
					"name_sender"	=> SITE_NAME,
					"to_receiver"	=> $user->user_email,
					"message"		=> $message
			);
			$this->mail->config($mail);
			$this->mail->sendmail();
		}
		
		if ($user != null) {
			if (!$user->active) {
				echo site_url("member/myaccount");
			}
			else {
				$this->session->set_userdata("user", $user);
				
				// Redirect to the link user had entered before
				if ($this->session->userdata("return_url")) {
					$redirect_url = $this->session->userdata("return_url");
					$this->session->unset_userdata("return_url");
					echo $redirect_url;
				} else {
					echo site_url("member/myaccount");
				}
			}
		}
	}
}