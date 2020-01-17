<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vietnam_visa_review extends CI_Controller {

	public function index()
	{
		if (empty($_GET['reviewid'])) {
			redirect('error404');
		} else {
			if (strlen($_GET['reviewid']) < 10) {
				redirect('error404');
			}
		}
		
		$tmpl_content = array();
		$tmpl_content['meta']['title'] = "Shopper Approved";
		$tmpl_content['tabindex']  = "contact";
		$tmpl_content['content']   = $this->load->view("shopperapproved/index", NULL, TRUE);
		$this->load->view('layout/view', $tmpl_content);
	}

}

?>