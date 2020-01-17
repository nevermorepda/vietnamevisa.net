<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

	public function index()
	{
		$q = !empty($_GET["q"]) ? $_GET["q"] : "";
		
		$view_data = array();
		$view_data['q'] = $q;
		
		$tmpl_content = array();
		$tmpl_content['content']   = $this->load->view("search/index", $view_data, TRUE);
		$this->load->view('layout/view', $tmpl_content);
	}
}

?>