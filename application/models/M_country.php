<?php
class M_country extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_country";
	}
	
	function search_by_name($nation)
	{
		$sql   = "SELECT * FROM {$this->_table} WHERE UPPER({$this->_table}.name)='".strtoupper(addslashes($nation))."' ORDER BY {$this->_table}.name ASC";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return null;
	}
	
	function items($info=NUll)
	{
		$sql   = "SELECT * FROM {$this->_table} WHERE 1=1";
		if (!is_null($info)) {
			if (!empty($info->type)) {
				$sql .= " AND type = '{$info->type}'";
			}
		}
		$sql .= " ORDER BY {$this->_table}.name ASC";
		$query = $this->db->query($sql);
		return $query->result();
	}
}
?>
