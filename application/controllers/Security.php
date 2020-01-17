<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Security extends CI_Controller {

	public function ajax_code()
	{
		echo $this->util->getSecurityCode();
	}
}

?>