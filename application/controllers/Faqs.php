<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faqs extends CI_Controller {

	public function index($alias=NULL)
	{
		// $this->util->block_ip();
		// $this->output->cache(CACHE_TIME);
		
		if (!empty($alias)) {
			$item = $this->m_content->load($alias, 1);
		
			if (empty($item)) {
				redirect("error404");
			}
			
			$breadcrumb = array('Vietnam Visa FAQs' => site_url('faqs'), $item->title => '');
			
			$view_data = array();
			$view_data['item'] = $item;
			$view_data["breadcrumb"] = $breadcrumb;
			
			$tmpl_content = array();
			$tmpl_content['meta']['title'] = $this->util->getMetaTitle($item);
			$tmpl_content['meta']['keywords'] = $item->meta_key;
			$tmpl_content['meta']['description'] = $item->meta_desc;
			$tmpl_content['tabindex']  = "faqs";
			$tmpl_content['content']   = $this->load->view("faq/detail", $view_data, TRUE);
			$this->load->view('layout/view', $tmpl_content);
		}
		else {
			$info = new stdClass();
			$info->catid = 4; // FAQs

			$info_evisa = new stdClass();
			$info_evisa->catid = 32; // FAQs
			
			$view_data = array();
			$view_data['faqs'] = $this->m_content->items($info, 1);
			$view_data['evisa_faqs'] = $this->m_content->items($info_evisa, 1);
			
			$tmpl_content = array();
			$tmpl_content['meta']['title'] = "FAQ - Questions and Answer Vietnam Visa";
			$tmpl_content['meta']['keywords'] = "faqs, visa, vietnam, visa vietnam, vietnam visa";
			$tmpl_content['tabindex']  = "faqs";
			$tmpl_content['content']   = $this->load->view("faq/index", $view_data, TRUE);
			$this->load->view('layout/view', $tmpl_content);
		}
	}
}

?>