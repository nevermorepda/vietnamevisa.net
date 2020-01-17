<?php
class M_agent_processing_fee extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_agent_processing_fee";
	}
	
	function search($processing_type)
	{
		if ($this->db->field_exists($processing_type, $this->_table)) {
			$sql   = "SELECT {$processing_type} FROM {$this->_table}";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				$row = $query->row();
				return $row->{$processing_type};
			} else {
				$new_instance = $this->instance();
				return $new_instance->{$processing_type};
			}
		}
		return 0;
	}
	
	function items()
	{
		$sql   = "SELECT * FROM {$this->_table} WHERE 1 = 1";
		$query = $this->db->query($sql);
		return $query->result();
	}
	function item($agents_id,$nation_type_id)
	{
		$sql   = "SELECT * FROM {$this->_table} WHERE 1 = 1";
		if (!is_null($agents_id)) {
			$sql .= " AND agents_id = '{$agents_id}'";
		}
		if (!is_null($nation_type_id)) {
			$sql .= " AND nation_type_id = '{$nation_type_id}'";
		}
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return null;
	}
}
?>
