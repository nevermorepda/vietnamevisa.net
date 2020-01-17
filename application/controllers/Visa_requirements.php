<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Visa_requirements extends CI_Controller {

	public function index($citizen=null)
	{
		$this->output->cache(CACHE_TIME);
		$this->util->block_ip();
		if (!empty($citizen)) {
			$nations = $this->m_nation->items();
			$item = $this->m_requirement->load($citizen);
			
			$view_data = array();
			$view_data["nations"] = $nations;
			$view_data["citizen"] = $citizen;
			$view_data["item"]    = $item;
			
			$tmpl_content = array();
			$tmpl_content['meta']['title'] = "Vietnam visa for ".(($item != null) ? $item->citizen : "")." citizens, passport holders, residents";
			$tmpl_content['content']   = $this->load->view("requirement/detail", $view_data, TRUE);
			$this->load->view('layout/view', $tmpl_content);
		}
		else {
			$nations = $this->m_nation->items();
			$citizen = (!empty($_POST["citizen"]) ? $_POST["citizen"] : "afghanistan");
			$item    = null;
			
			if (!empty($citizen)) {
				$item = $this->m_requirement->load($citizen);
			}
			
			$view_data = array();
			$view_data["nations"] = $nations;
			$view_data["citizen"] = $citizen;
			$view_data["item"]    = $item;
			
			$tmpl_content = array();
			$tmpl_content['meta']['title'] = "Vietnam visa for ".(($item != null) ? $item->citizen : "")." citizens, passport holders, residents";
			$tmpl_content['content']   = $this->load->view("requirement/index", $view_data, TRUE);
			$this->load->view('layout/view', $tmpl_content);
		}
	}
}

?>