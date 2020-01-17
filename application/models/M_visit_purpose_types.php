<?php
class M_visit_purpose_types extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_visit_purpose_types";
	}
	
	function search($visit_purpose_id, $visa_type_id)
	{
		$sql = "SELECT * FROM {$this->_table} WHERE visit_purpose_id = '{$visit_purpose_id}' AND visa_type_id = '{$visa_type_id}'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return null;
	}
}
?>