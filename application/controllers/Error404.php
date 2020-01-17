<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error404 extends CI_Controller {

	public function index()
	{
		header("HTTP/1.1 404 Not Found");
		
		$tmpl_content = array();
		$tmpl_content['meta']['title'] = "404 - Page Not Found!!!";
		$tmpl_content['content'] = $this->load->view("error404", NULL, TRUE);
		$this->load->view('layout/view', $tmpl_content);
	}
}

?>