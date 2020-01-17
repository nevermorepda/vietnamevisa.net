<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About_us extends CI_Controller {

	public function index()
	{
		$breadcrumb = array("Abouts us" => site_url("{$this->util->slug($this->router->fetch_class())}"));
		$this->util->block_ip();
		$this->output->cache(CACHE_TIME);
		
		$info = new stdClass();
		$info->catid = 11;
		$items = $this->m_content->items($info, 1);
		
		if (!empty($items)) {
			$item = $items[0];
		}
		
		// Check error before load page content
		$this->util->checkPageError($item);
		
		$view_data = array();
		$view_data['item'] = $item;
		$view_data['breadcrumb'] = $breadcrumb;
		
		$tmpl_content = array();
		$tmpl_content['meta']['title'] = $this->util->getMetaTitle($item);
		$tmpl_content['meta']['keywords'] = $item->meta_key;
		$tmpl_content['meta']['description'] = $item->meta_desc;
		$tmpl_content['content'] = $this->load->view("content/detail", $view_data, TRUE);
		$this->load->view('layout/view', $tmpl_content);
	}
	
	public function team()
	{
		//$this->output->cache(CACHE_TIME);
		
		$tmpl_content = array();
		$tmpl_content['content'] = $this->load->view("team/index", NULL, TRUE);
		$this->load->view('layout/view', $tmpl_content);
	}
}

?>