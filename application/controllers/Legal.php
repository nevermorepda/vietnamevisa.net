<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Legal extends CI_Controller {

	public function index($alias)
	{
		$this->util->block_ip();
		$item = $this->m_content->load($alias, 1);
		
		// Check error before load page content
		$this->util->checkPageError($item);
		
		$breadcrumb = array('Legal' => site_url('legal'), $item->title => '');
		
		$view_data = array();
		$view_data['item'] = $item;
		$view_data["breadcrumb"] = $breadcrumb;
		
		$tmpl_content = array();
		$tmpl_content['meta']['title'] = $this->util->getMetaTitle($item);
		$tmpl_content['meta']['keywords'] = $item->meta_key;
		$tmpl_content['meta']['description'] = $item->meta_desc;
		$tmpl_content['content']   = $this->load->view("legal/detail", $view_data, TRUE);
		$this->load->view('layout/view', $tmpl_content);
	}
}

?>