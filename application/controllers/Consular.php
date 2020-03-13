<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Consular extends CI_Controller {

	public function index($alias=null)
	{
		// $this->output->cache(CACHE_TIME);
		// $this->util->block_ip();
		if (!empty($alias)) {
			$item = $this->m_content->load($alias);
		
			$breadcrumb = array('Consular Services' => site_url('consular'), $item->title => '');
			
			$view_data = array();
			$view_data['item']  = $item;
			$view_data['breadcrumb'] = $breadcrumb;
			
			$tmpl_content = array();
			$tmpl_content['meta']['title'] = $this->util->getMetaTitle($item);
			$tmpl_content['tabindex']  = "consular";
			$tmpl_content['content']   = $this->load->view("consular/detail", $view_data, TRUE);
			$this->load->view('layout/view', $tmpl_content);
		}
		else {
			$breadcrumb = array("Consular Services" => site_url("{$this->util->slug($this->router->fetch_class())}"));
			$info = new stdClass();
			$info->catid = 31; // Consular service
			
			$view_data = array();
			$view_data['items'] = $this->m_content->items($info, 1);
			$view_data['breadcrumb']= $breadcrumb;
			
			$tmpl_content = array();
			$tmpl_content['meta']['title'] = "Consular Services";
			$tmpl_content['tabindex']  = "consular";
			$tmpl_content['content']   = $this->load->view("consular/index", $view_data, TRUE);
			$this->load->view('layout/view', $tmpl_content);
		}
	}
}

?>