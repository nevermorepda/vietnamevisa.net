<?php
class M_visa_fee extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_visa_fee";
	}
	
	function search($nation_id)
	{
		$sql   = "SELECT * FROM {$this->_table} WHERE {$this->_table}.nation_id = '{$nation_id}'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return null;
	}
	
	function items()
	{
		$sql   = "SELECT * FROM {$this->_table} WHERE 1 = 1";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function evisa_nations()
	{
		$sql   = "SELECT vs_country.name, vs_country.code FROM {$this->_table} INNER JOIN vs_country ON (vs_country.id = {$this->_table}.nation_id) WHERE vs_country.active = 1 AND {$this->_table}.evisa_1ms <> 0 ORDER BY vs_country.name ASC";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function voa_nations()
	{
		$tourist  = "tourist_";
		$business = "business_";
		
		$_1ms = "1ms";
		$_1mm = "1mm";
		$_3ms = "3ms";
		$_3mm = "3mm";
		$_6mm = "6mm";
		$_1ym = "1ym";
		
		$visa_types = array($_1ms, $_1mm, $_3ms, $_3mm, $_6mm, $_1ym);
		$visa_fees = array();
		
		foreach ($visa_types as $visa_type) {
			$visa_fees[] = "({$this->_table}.".$tourist.$visa_type." <> 0)";
			$visa_fees[] = "({$this->_table}.".$business.$visa_type." <> 0)";
		}
		
		$sql  = "SELECT vs_country.name, vs_country.code FROM {$this->_table} INNER JOIN vs_country ON (vs_country.id = {$this->_table}.nation_id) WHERE vs_country.active = 1";
		$sql .= " AND (".implode(" OR ", $visa_fees).")";
		$sql .= " ORDER BY vs_country.name ASC";
		
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function types_of_tourist($nation_id)
	{
		$tourist  = "tourist_";
		
		$_1ms = "1ms";
		$_1mm = "1mm";
		$_3ms = "3ms";
		$_3mm = "3mm";
		$_6mm = "6mm";
		$_1ym = "1ym";
		
		$visa_types = array();
		
		$fee = $this->search($nation_id);
		if (!is_null($fee)) {
			if (!empty($fee->{$tourist.$_1ms})) {
				$visa_types[] = $_1ms;
			}
			if (!empty($fee->{$tourist.$_1mm})) {
				$visa_types[] = $_1mm;
			}
			if (!empty($fee->{$tourist.$_3ms})) {
				$visa_types[] = $_3ms;
			}
			if (!empty($fee->{$tourist.$_3mm})) {
				$visa_types[] = $_3mm;
			}
			if (!empty($fee->{$tourist.$_6mm})) {
				$visa_types[] = $_6mm;
			}
			if (!empty($fee->{$tourist.$_1ym})) {
				$visa_types[] = $_1ym;
			}
		}
		
		return $visa_types;
	}
	
	function types_of_business($nation_id)
	{
		$business = "business_";
		
		$_1ms = "1ms";
		$_1mm = "1mm";
		$_3ms = "3ms";
		$_3mm = "3mm";
		$_6mm = "6mm";
		$_1ym = "1ym";
		
		$visa_types = array();
		
		$fee = $this->search($nation_id);
		if (!is_null($fee)) {
			if (!empty($fee->{$business.$_1ms})) {
				$visa_types[] = $_1ms;
			}
			if (!empty($fee->{$business.$_1mm})) {
				$visa_types[] = $_1mm;
			}
			if (!empty($fee->{$business.$_3ms})) {
				$visa_types[] = $_3ms;
			}
			if (!empty($fee->{$business.$_3mm})) {
				$visa_types[] = $_3mm;
			}
			if (!empty($fee->{$business.$_6mm})) {
				$visa_types[] = $_6mm;
			}
			if (!empty($fee->{$business.$_1ym})) {
				$visa_types[] = $_1ym;
			}
		}
		
		return $visa_types;
	}
	function types_evisa_of_tourist($nation_id)
	{
		$tourist  = "evisa_tourist_";
		
		$_1ms = "1ms";
		$_1mm = "1mm";
		$_3ms = "3ms";
		$_3mm = "3mm";
		$_6mm = "6mm";
		$_1ym = "1ym";
		
		$visa_types = array();
		
		$fee = $this->search($nation_id);
		if (!is_null($fee)) {
			if (!empty($fee->{$tourist.$_1ms})) {
				$visa_types[] = $_1ms;
			}
			if (!empty($fee->{$tourist.$_1mm})) {
				$visa_types[] = $_1mm;
			}
			if (!empty($fee->{$tourist.$_3ms})) {
				$visa_types[] = $_3ms;
			}
			if (!empty($fee->{$tourist.$_3mm})) {
				$visa_types[] = $_3mm;
			}
			if (!empty($fee->{$tourist.$_6mm})) {
				$visa_types[] = $_6mm;
			}
			if (!empty($fee->{$tourist.$_1ym})) {
				$visa_types[] = $_1ym;
			}
		}
		
		return $visa_types;
	}
	function types_evisa_of_business($nation_id)
	{
		$business = "evisa_business_";
		
		$_1ms = "1ms";
		$_1mm = "1mm";
		$_3ms = "3ms";
		$_3mm = "3mm";
		$_6mm = "6mm";
		$_1ym = "1ym";
		
		$visa_types = array();
		
		$fee = $this->search($nation_id);
		if (!is_null($fee)) {
			if (!empty($fee->{$business.$_1ms})) {
				$visa_types[] = $_1ms;
			}
			if (!empty($fee->{$business.$_1mm})) {
				$visa_types[] = $_1mm;
			}
			if (!empty($fee->{$business.$_3ms})) {
				$visa_types[] = $_3ms;
			}
			if (!empty($fee->{$business.$_3mm})) {
				$visa_types[] = $_3mm;
			}
			if (!empty($fee->{$business.$_6mm})) {
				$visa_types[] = $_6mm;
			}
			if (!empty($fee->{$business.$_1ym})) {
				$visa_types[] = $_1ym;
			}
		}
		
		return $visa_types;
	}
	
	function types_of_evisa($nation_id)
	{
		$evisa  = "evisa_";
		
		$_1ms = "1ms";
		$_1mm = "1mm";
		$_3ms = "3ms";
		$_3mm = "3mm";
		$_6mm = "6mm";
		$_1ym = "1ym";
		
		$visa_types = array();
		
		$fee = $this->search($nation_id);
		if (!is_null($fee)) {
			if (!empty($fee->{$evisa.$_1ms})) {
				$visa_types[] = $_1ms;
			}
		}
		
		return $visa_types;
	}
	
	function cal_visa_fee($visa_type="1ms", $group_size=1, $processing_time="", $passport_holder="", $visit_purpose="", $arrival_port=0,$booking_type_id = 1)
	{
		$port_type_id = 0;
		if (!empty($arrival_port)) {
			$m_arrival_port = $this->m_arrival_port->load($arrival_port);
			if (!empty($m_arrival_port)) {
				$port_type_id = $m_arrival_port->category_id;
			}
		}
		
		// if (in_array($port_type_id, array(2, 3))) {
		// 	return $this->cal_e_visa_fee($visa_type, $group_size, $processing_time, $passport_holder);
		// } else 
		if (stripos(strtolower($visit_purpose), "business") !== false) {
			return $this->cal_business_visa_fee($visa_type, $group_size, $processing_time, $passport_holder,$booking_type_id);
		} else {
			return $this->cal_tourist_visa_fee($visa_type, $group_size, $processing_time, $passport_holder,$booking_type_id);
		}
	}
	
	function cal_tourist_visa_fee($visa_type="1ms", $group_size=1, $processing_time="", $passport_holder="",$booking_type_id)
	{
		$original_fee		= 0;
		$service_fee		= 0;
		$service_capital	= 0;
		$stamping_fee		= 0;
		$rush_fee			= 0;
		$rush_capital		= 0;
		
		$_1ms = "1ms";
		$_1mm = "1mm";
		$_3ms = "3ms";
		$_3mm = "3mm";
		$_6mm = "6mm";
		$_1ym = "1ym";
		
		if ($booking_type_id == 2) {
			$purpose = "evisa_tourist_";
			$capital = "capital_";
		} else {
			$purpose = "tourist_";
			$capital = "capital_";
		}
		
		$rush_fee = $this->m_processing_fee->search($purpose.$visa_type.'_'.strtolower($processing_time));
		$rush_capital = $this->m_processing_fee->search($capital.$purpose.$visa_type.'_'.strtolower($processing_time));
		
		$nation = $this->m_country->search_by_name($passport_holder);
		if (!empty($nation)) {
			$fee = $this->search($nation->id);
			if (!empty($fee->get_fee_default)) {
				$fee = $this->search(0);
				if (empty($fee)) {
					$fee = $this->instance();
				}
			}
		} else {
			$fee = $this->search(0);
			if (empty($fee)) {
				$fee = $this->instance();
			}
		}
		
		$original_fee		= max($fee->{$purpose.$visa_type}, 0);

		if ($group_size == 1){
			$price_discount = 0;
		} else if ($group_size >= 2 && $group_size <= 3) {
			$price_discount = 1;
		} else if ($group_size >= 4 && $group_size <= 5) {
			$price_discount = 2;
		} else if ($group_size >= 6 && $group_size <= 9) {
			$price_discount = 3;
		} else if ($group_size >= 10) {
			$price_discount = 4;
		}
		
		if ($fee->group_discount) {
			$service_fee	= $original_fee - $price_discount;
		} else {
			$service_fee	= $original_fee;
		}
		// if ($fee->group_discount) {
		// 	$service_fee	= max($original_fee - round((min(10, $group_size)-1) / 2) * 2, 0);
		// } else {
		// 	$service_fee	= $original_fee;
		// }
		$service_capital	= max($fee->{$capital.$purpose.$visa_type}, 0);
		
		switch ($visa_type)
		{
			case $_1ms:
				$stamping_fee = 25;
				break;
			case $_1mm:
				$stamping_fee = 50;
				break;
			case $_3ms:
				$stamping_fee = 25;
				break;
			case $_3mm:
				$stamping_fee = 50;
				break;
			case $_6mm:
				$stamping_fee = 95;
				break;
			case $_1ym:
				$stamping_fee = 135;
				break;
			default:break;
		}
		
		$price = new stdClass();
		$price->original_fee	= $original_fee;
		$price->service_fee		= $service_fee;
		$price->service_capital	= $service_capital;
		$price->stamp_fee		= $stamping_fee;
		$price->gov_fee			= $stamping_fee;
		$price->rush_fee		= $rush_fee;
		$price->rush_capital	= $rush_capital;
		$price->total_fee		= ($service_fee + $rush_fee) * $group_size;
		
		return $price;
	}
	
	function cal_business_visa_fee($visa_type="1ms", $group_size=1, $processing_time="", $passport_holder="",$booking_type_id)
	{
		$original_fee		= 0;
		$service_fee		= 0;
		$service_capital	= 0;
		$stamping_fee		= 0;
		$rush_fee			= 0;
		$rush_capital		= 0;
		
		$_1ms = "1ms";
		$_1mm = "1mm";
		$_3ms = "3ms";
		$_3mm = "3mm";
		$_6mm = "6mm";
		$_1ym = "1ym";
		
		if ($booking_type_id == 2) {
			$purpose = "evisa_business_";
			$capital = "capital_";
		} else {
			$purpose = "business_";
			$capital = "capital_";
		}
		
		$rush_fee = $this->m_processing_fee->search($purpose.$visa_type.'_'.strtolower($processing_time));
		$rush_capital = $this->m_processing_fee->search($capital.$purpose.$visa_type.'_'.strtolower($processing_time));
		
		$nation = $this->m_country->search_by_name($passport_holder);
		if (!empty($nation)) {
			$fee = $this->search($nation->id);
			if (!empty($fee->get_fee_default)) {
				$fee = $this->search(0);
				if (empty($fee)) {
					$fee = $this->instance();
				}
			}
		} else {
			$fee = $this->search(0);
			if (empty($fee)) {
				$fee = $this->instance();
			}
		}
		
		$original_fee		= max($fee->{$purpose.$visa_type}, 0);

		if ($group_size == 1){
			$price_discount = 0;
		} else if ($group_size >= 2 && $group_size <= 3) {
			$price_discount = 1;
		} else if ($group_size >= 4 && $group_size <= 5) {
			$price_discount = 2;
		} else if ($group_size >= 6 && $group_size <= 9) {
			$price_discount = 3;
		} else if ($group_size >= 10) {
			$price_discount = 4;
		}
		
		if ($fee->group_discount) {
			$service_fee	= $original_fee - $price_discount;
		} else {
			$service_fee	= $original_fee;
		}
		// if ($fee->group_discount) {
		// 	$service_fee	= max($original_fee - round((min(10, $group_size)-1) / 2) * 2, 0);
		// } else {
		// 	$service_fee	= $original_fee;
		// }
		$service_capital	= max($fee->{$capital.$purpose.$visa_type}, 0);
		
		switch ($visa_type)
		{
			case $_1ms:
				$stamping_fee = 25;
				break;
			case $_1mm:
				$stamping_fee = 50;
				break;
			case $_3ms:
				$stamping_fee = 25;
				break;
			case $_3mm:
				$stamping_fee = 50;
				break;
			case $_6mm:
				$stamping_fee = 95;
				break;
			case $_1ym:
				$stamping_fee = 135;
				break;
			default:break;
		}
		
		$price = new stdClass();
		$price->original_fee	= $original_fee;
		$price->service_fee		= $service_fee;
		$price->service_capital	= $service_capital;
		$price->stamp_fee		= $stamping_fee;
		$price->gov_fee			= $stamping_fee;
		$price->rush_fee		= $rush_fee;
		$price->rush_capital	= $rush_capital;
		$price->total_fee		= ($service_fee + $rush_fee) * $group_size;
		
		return $price;
	}
	
	function cal_e_visa_fee($visa_type="1ms", $group_size=1, $processing_time="", $passport_holder="",$visit_purpose="")
	{
		$original_fee		= 0;
		$service_fee		= 0;
		$service_capital	= 0;
		$stamping_fee		= 0;
		$rush_fee			= 0;
		$rush_capital		= 0;
		
		$_1ms = "1ms";
		$_1mm = "1mm";
		$_3ms = "3ms";
		$_3mm = "3mm";
		$_6mm = "6mm";
		$_1ym = "1ym";
		if ($visit_purpose == 'For business'){
			$purpose = "evisa_business_";
		} else {
			$purpose = "evisa_tourist_";
		}
		
		$capital = "capital_";
		
		$rush_fee = $this->m_processing_fee->search($purpose.$visa_type.'_'.strtolower($processing_time));
		$nation = $this->m_country->search_by_name($passport_holder);
		if (!empty($nation)) {
			$fee = $this->search($nation->id);
			if (!empty($fee->get_fee_default)) {
				$fee = $this->search(0);
				if (empty($fee)) {
					$fee = $this->instance();
				}
			}
		} else {
			$fee = $this->search(0);
			if (empty($fee)) {
				$fee = $this->instance();
			}
		}
		$original_fee		= max($fee->{$purpose.$visa_type}, 0);
		$service_fee		= $original_fee;
		// $service_fee		= max($original_fee - round((min(10, $group_size)-1) / 2) * 2, 0);
		$service_capital	= max($fee->{$capital.$purpose.$visa_type}, 0);
		
		switch ($visa_type)
		{
			case $_1ms:
				$stamping_fee = 25;
				break;
			case $_1mm:
				$stamping_fee = 50;
				break;
			case $_3ms:
				$stamping_fee = 25;
				break;
			case $_3mm:
				$stamping_fee = 50;
				break;
			case $_6mm:
				$stamping_fee = 95;
				break;
			case $_1ym:
				$stamping_fee = 135;
				break;
			default:break;
		}
		
		$price = new stdClass();
		$price->original_fee	= $original_fee;
		$price->service_fee		= $service_fee;
		$price->service_capital	= $service_capital;
		$price->stamp_fee		= $stamping_fee;
		$price->gov_fee			= $stamping_fee;
		$price->rush_fee		= $rush_fee;
		$price->rush_capital	= $rush_capital;
		$price->total_fee		= ($service_fee + $rush_fee) * $group_size;
		
		return $price;
	}
}
?>
