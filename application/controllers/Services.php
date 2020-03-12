<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Services extends CI_Controller {

	public function index($alias=null)
	{
		// $this->output->cache(CACHE_TIME);
		// $this->util->block_ip();
		if (!empty($alias)) {
			$item = $this->m_content->load($alias);
		
			$breadcrumb = array('Extra Services' => site_url('services'), $item->title => '');
			
			$view_data = array();
			$view_data['item']  = $item;
			$view_data['breadcrumb'] = $breadcrumb;
			
			$tmpl_content = array();
			$tmpl_content['meta']['title'] = $this->util->getMetaTitle($item);
			$tmpl_content['tabindex']  = "services";
			$tmpl_content['content']   = $this->load->view("service/detail", $view_data, TRUE);
			$this->load->view('layout/view', $tmpl_content);
		}
		else {
			$breadcrumb = array("Extra Services" => site_url("{$this->util->slug($this->router->fetch_class())}"));
			$info = new stdClass();
			$info->catid = 10; // Extra service
			
			$view_data = array();
			$view_data['items'] = $this->m_content->items($info, 1);
			$view_data['breadcrumb']= $breadcrumb;
			
			$tmpl_content = array();
			$tmpl_content['meta']['title'] = "Extra Services";
			$tmpl_content['tabindex']  = "services";
			$tmpl_content['content']   = $this->load->view("service/index", $view_data, TRUE);
			$this->load->view('layout/view', $tmpl_content);
		}
	}
}

?>