<?php
class M_fast_checkin_fee extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_fast_checkin_fee";
	}
	
	function search($service_type, $arrival_port, $capital=NULL)
	{
		if (!is_null($capital)) {
			$capital = "capital_";
		} else {
			$capital = "";
		}
		
		$fc_type = $capital;
		
		if ($service_type == 1) {
			$fc_type .= "fc";
		}
		else if ($service_type == 2) {
			$fc_type .= "vip_fc";
		}
		
		if ($this->db->field_exists($fc_type, $this->_table)) {
			$sql   = "SELECT {$fc_type} FROM {$this->_table} WHERE {$this->_table}.airport = '{$arrival_port}'";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				$row = $query->row();
				return $row->{$fc_type};
			} else {
				$new_instance = $this->instance();
				return $new_instance->{$fc_type};
			}
		}
		return 0;
	}
	
	function items($info=NULL)
	{
		$sql = "SELECT * FROM {$this->_table} WHERE 1 = 1";
		if (!is_null($info)) {
			if (!empty($info->airport)) {
				$sql .= " AND {$this->_table}.airport = '{$info->airport}'";
			}
		}
		$query = $this->db->query($sql);
		return $query->result();
	}
}
?>
