<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Refund_policy extends CI_Controller {

	public function index()
	{
		$this->util->block_ip();
		$catinfo->alias = "refund-policy";
		$cat = $this->m_content->getCategory($catinfo);
		
		$info = new stdClass();
		$info->catid = $cat->id;
		$items = $this->m_content->items($info, 1);
		
		if (!empty($items)) {
			$item = $items[0];
		}
		
		// Check error before load page content
		$this->util->checkPageError($item);
		
		$view_data = array();
		$view_data['item'] = $item;
		
		$tmpl_content = array();
		$tmpl_content['meta']['title'] = $this->util->getMetaTitle($item);
		$tmpl_content['meta']['keywords'] = $item->meta_key;
		$tmpl_content['meta']['description'] = $item->meta_desc;
		$tmpl_content['content']   = $this->load->view("content_view", $view_data, TRUE);
		$this->load->view('layout/colview', $tmpl_content);
	}
}

?>