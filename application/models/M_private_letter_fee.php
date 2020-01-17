<?php
class M_private_letter_fee extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_private_letter_fee";
	}
	
	function search($visa_type)
	{
		if ($this->db->field_exists($visa_type, $this->_table)) {
			$sql   = "SELECT {$visa_type} FROM {$this->_table}";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				$row = $query->row();
				return $row->{$visa_type};
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
