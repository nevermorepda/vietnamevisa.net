<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Visa_fee extends CI_Controller {

	public function index($alias=null)
	{
		// $this->output->cache(CACHE_TIME);
		// $this->util->block_ip();
		if (!empty($alias)) {
			$current_nation = $this->m_country->load($alias);
		}
		$current_nation_id = !empty($current_nation->id) ? $current_nation->id : 0;
		$tourist_visa_types = array();
		$business_visa_types = array();
		$tourist_evisa_types = array();
		$business_evisa_types = array();
		
		$visa_types = $this->m_visa_type->items(NULL, 1);
		$types_of_tourist = $this->m_visa_fee->types_of_tourist($current_nation_id);
		$types_of_business = $this->m_visa_fee->types_of_business($current_nation_id);
		$types_evisa_of_tourist = $this->m_visa_fee->types_evisa_of_tourist($current_nation_id);
		$types_evisa_of_business = $this->m_visa_fee->types_evisa_of_business($current_nation_id);
		
		foreach ($visa_types as $visa_type) {
			if (in_array($visa_type->code, $types_of_tourist)) {
				$purpose_type = $this->m_visit_purpose_types->search(1, $visa_type->id);
				if (!empty($purpose_type) && !in_array($visa_type->code, $tourist_visa_types)) {
					$tourist_visa_types[] = $visa_type->code;
				}
			}
			if (in_array($visa_type->code, $types_of_business)) {
				$purpose_type = $this->m_visit_purpose_types->search(2, $visa_type->id);
				if (!empty($purpose_type) && !in_array($visa_type->code, $business_visa_types)) {
					$business_visa_types[] = $visa_type->code;
				}
			}
			if (in_array($visa_type->code, $types_evisa_of_tourist)) {
				$purpose_type = $this->m_visit_purpose_types->search(1, $visa_type->id);
				if (!empty($purpose_type) && !in_array($visa_type->code, $tourist_evisa_types)) {
					$tourist_evisa_types[] = $visa_type->code;
				}
			}
			if (in_array($visa_type->code, $types_evisa_of_business)) {
				$purpose_type = $this->m_visit_purpose_types->search(1, $visa_type->id);
				if (!empty($purpose_type) && !in_array($visa_type->code, $business_evisa_types)) {
					$business_evisa_types[] = $visa_type->code;
				}
			}
		}

		$breadcrumb = array('Visa Fees' => site_url('visa-fee'));

		$view_data = array();
		$view_data['nationalities'] = $this->m_country->items();
		$view_data['current_nation'] = !empty($current_nation) ? $current_nation : null;
		$view_data['tourist_visa_types'] = $tourist_visa_types;
		$view_data['business_visa_types'] = $business_visa_types;
		$view_data['tourist_evisa_types'] = $tourist_evisa_types;
		$view_data['business_evisa_types'] = $business_evisa_types;
		$view_data['breadcrumb']= $breadcrumb;
		
		$tmpl_content = array();
		$tmpl_content['tabindex'] = "visa-fee";
		if (!empty($current_nation)) {
		$tmpl_content['meta']['title'] = "Vietnam Visa Fee for ".$current_nation->name;
		$tmpl_content['meta']['keywords'] = "vietnam visa fee, vietnam visa cost, visa fee for ".$current_nation->name;
		} else {
		$tmpl_content['meta']['title'] = "Vietnam Visa Fee";
		$tmpl_content['meta']['keywords'] = "vietnam visa fee, vietnam visa cost, visa fee";
		}
		$tmpl_content['content'] = $this->load->view("fee/index", $view_data, TRUE);
		$this->load->view('layout/view', $tmpl_content);
	}
}

?>