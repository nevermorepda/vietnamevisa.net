<?php
class M_visa_type extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_visa_type";
	}
	
	function search_by_name($name)
	{
		$sql   = "SELECT * FROM {$this->_table} WHERE UPPER({$this->_table}.name) = '".strtoupper($name)."'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return NULL;
	}
	
	function items($info=NULL, $active=NULL, $limit=NULL, $offset=NULL)
	{
		$sql  = "SELECT * FROM {$this->_table} WHERE 1 = 1";
		if (!is_null($info)) {
		}
		if (!is_null($active)) {
			$sql .= " AND active = '{$active}'";
		}
		if (!is_null($limit)) {
			$sql .= " LIMIT {$limit}";
		}
		if (!is_null($offset)) {
			$sql .= " OFFSET {$offset}";
		}
		
		$query = $this->db->query($sql);
		return $query->result();
	}
}
?>