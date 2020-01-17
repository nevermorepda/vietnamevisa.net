<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vietnam_visa_tips extends CI_Controller {

	public function index($alias=null)
	{
		$this->util->block_ip();
		if (!empty($alias)) {
			$item = $this->m_tips->load($alias);
		
			$breadcrumb = array('Vietnam Visa Tips' => site_url('vietnam-visa-tips'), $item->title => '');
			
			$view_data = array();
			$view_data['item'] = $item;
			$view_data['breadcrumb'] = $breadcrumb;
			
			$tmpl_content = array();
			$tmpl_content['meta']['title'] = $item->title;
			$tmpl_content['tabindex']  = "";
			$tmpl_content['content']   = $this->load->view("tips/detail", $view_data, TRUE);
			$this->load->view('layout/view', $tmpl_content);
		}
		else {
			$view_data = array();
			$view_data['items'] = $this->m_tips->items(NULL, 1);
			$view_data['nations'] = $this->m_nation->items();
			
			$tmpl_content = array();
			$tmpl_content['meta']['title'] = "Vietnam Visa Tips";
			$tmpl_content['content']   = $this->load->view("tips/index", $view_data, TRUE);
			$this->load->view('layout/view', $tmpl_content);
		}
	}
}

?>