<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vietnam_e_visa extends CI_Controller {

	public function index()
	{
		$this->output->cache(CACHE_TIME);
		$this->util->block_ip();
		$info_evisa = new stdClass();
		$info_evisa->catid = 32; // FAQs

		$view_data = array();
		$view_data['evisa_faqs'] = $this->m_content->items($info_evisa, 1);

		$tmpl_content = array();
		$tmpl_content["meta"]["title"] = "Vietnam Electronic Visa (e-Visa Vietnam)";
		$tmpl_content["tabindex"] = $this->util->slug($this->router->fetch_class());
		$tmpl_content["content"] = $this->load->view("evisa/index", $view_data, TRUE);
		$this->load->view("layout/main", $tmpl_content);
	}
}

?>