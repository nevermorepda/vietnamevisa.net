<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vietnam_embassies extends CI_Controller {

	public function index($nation=null)
	{
		$this->output->cache(CACHE_TIME*4);
		$this->util->block_ip();
		if (!empty($nation)) {
			$info = new stdClass();
			$info->nation = $nation;
			$items = $this->m_embassy->items($info, 1);
			
			$nation = $this->m_nation->load($nation);
			
			$breadcrumb = array('Vietnam Embassies' => site_url('vietnam-embassies'), 'Vietnam Embassy in '.$nation->name => '');
			
			$view_data = array();
			$view_data['breadcrumb']= $breadcrumb;
			$view_data['nation']	= $nation;
			$view_data['nations']	= $this->m_nation->items();
			$view_data['item']		= (!empty($items) ? $items[0] : null);
			
			$tmpl_content = array();
			$tmpl_content['meta']['title'] = "Vietnam Embassy in ".$nation->name;
			$tmpl_content['content'] = $this->load->view("embassies/detail", $view_data, TRUE);
			$this->load->view('layout/view', $tmpl_content);
		}
		else {
			$view_data = array();
			$view_data['nations'] = $this->m_nation->items();
			
			$tmpl_content = array();
			$tmpl_content['meta']['title'] = "Vietnam Embassy Worldwide";
			$tmpl_content['content']   = $this->load->view("embassies/index", $view_data, TRUE);
			$this->load->view('layout/view', $tmpl_content);
		}
	}
}

?>