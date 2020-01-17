<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Visa_processing extends CI_Controller {

	public function index()
	{
		$this->output->cache(CACHE_TIME);
		$this->util->block_ip();
		$info = new stdClass();
		$info->catid = 4; // FAQs
		$info_evisa = new stdClass();
		$info_evisa->catid = 32; // FAQs
		
		$view_data = array();
		$view_data['faqs'] = $this->m_content->items($info, 1);
		$view_data['evisa_faqs'] = $this->m_content->items($info_evisa, 1);

		$tmpl_content = array();
		$tmpl_content['meta']['title'] = "How Vietnam Visa on Arrival works?";
		$tmpl_content['tabindex']  = "processing";
		$tmpl_content['content']   = $this->load->view("processing/index", $view_data, TRUE);
		$this->load->view('layout/main', $tmpl_content);
	}
	public function ajax_check_visa_available()
	{
		$nation_id = $this->input->post("nation_id");
		$types_of_tourist = $this->m_visa_fee->types_of_tourist($nation_id);
		$types_of_business = $this->m_visa_fee->types_of_business($nation_id);
		
		echo json_encode(array(sizeof($types_of_tourist), sizeof($types_of_business)));
	}
}

?>