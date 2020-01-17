<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends CI_Controller {

	public function index($alias=NULL)
	{
		// $this->output->cache(CACHE_TIME);
		$this->util->block_ip();
		if (!empty($alias)) {
			$item = $this->m_content->load($alias, 1);
			
			$breadcrumb = array("Vietnam Visa News" => site_url("news"), $item->title => '');
			
			$view_data = array();
			$view_data['item']		= $item;
			$view_data['breadcrumb']= $breadcrumb;
			
			$tmpl_content = array();
			$tmpl_content['meta']['title'] = $this->util->getMetaTitle($item);
			$tmpl_content['meta']['keywords'] = $item->meta_key;
			$tmpl_content['meta']['description'] = $item->meta_desc;
			$tmpl_content['tabindex']  = "news";
			$tmpl_content['content']   = $this->load->view("news/detail", $view_data, TRUE);
			$this->load->view('layout/view', $tmpl_content);
		}
		else {
			$info = new stdClass();
			$info->catid = 2; // News
			$breadcrumb = array("Vietnam Visa News" => site_url("{$this->util->slug($this->router->fetch_class())}"));

			$view_data = array();
			$view_data['items']  = $this->m_content->items($info, 1);
			$view_data['breadcrumb']= $breadcrumb;
			
			$tmpl_content = array();
			$tmpl_content['meta']['title'] = "Vietnam Visa News";
			$tmpl_content['meta']['keywords'] = "Visa news, visa, vietnam, visa vietnam, vietnam visa";
			$tmpl_content['tabindex']  = "news";
			$tmpl_content['content']   = $this->load->view("news/index", $view_data, TRUE);
			$this->load->view('layout/view', $tmpl_content);
		}
	}
	
	public function travel($alias=NULL)
	{
		$this->util->block_ip();
		// $this->output->cache(CACHE_TIME);
		
		if (!empty($alias)) {
			$item = $this->m_content->load($alias, 1);
			
			$breadcrumb = array("Vietnam Travel News" => site_url("news/travel"), $item->title => '');
			
			$view_data = array();
			$view_data['item']		= $item;
			$view_data['breadcrumb']= $breadcrumb;
			
			$tmpl_content = array();
			$tmpl_content['meta']['title'] = $this->util->getMetaTitle($item);
			$tmpl_content['meta']['keywords'] = $item->meta_key;
			$tmpl_content['meta']['description'] = $item->meta_desc;
			$tmpl_content['tabindex']  = "news";
			$tmpl_content['content']   = $this->load->view("news/travel/detail", $view_data, TRUE);
			$this->load->view('layout/view', $tmpl_content);
		}
		else {
			$info = new stdClass();
			$info->catid = 16; // News
			
			$breadcrumb = array('Vietnam Travel News' => '');
			
			$view_data = array();
			$view_data['items'] = $this->m_content->items($info, 1);
			$view_data['breadcrumb'] = $breadcrumb;
			
			$tmpl_content = array();
			$tmpl_content['meta']['title'] = "Vietnam Travel News";
			$tmpl_content['meta']['keywords'] = "Travel visa news, travel, visa, vietnam, visa vietnam, vietnam visa";
			$tmpl_content['tabindex']  = "news";
			$tmpl_content['content']   = $this->load->view("news/travel/index", $view_data, TRUE);
			$this->load->view('layout/view', $tmpl_content);
		}
	}
}

?>
