<?php
class Captcha {

	function Captcha() {
		$this->ci = &get_instance();
	}
	
	function create()
	{
		if ($this->ci->session->userdata("captcha")) {
			return $this->ci->session->userdata("captcha");
		} else {
			$captcha = strtoupper(substr(md5(date($this->ci->config->item("log_date_format")).$this->ci->config->item("encryption_key")), 0, 6));
			$this->ci->session->set_userdata("captcha", $captcha);
			return $captcha;
		}
	}
	
	function test($input)
	{
		return (strtoupper(trim($input)) == strtoupper(trim($this->create())));
	}
}
?>