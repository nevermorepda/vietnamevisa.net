<?php
class M_processing_fee extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_processing_fee";
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
}
?>
