<?php
class M_province extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_province";
	}
	
	function search_by_name($nation)
	{
		$sql   = "SELECT * FROM {$this->_table} WHERE UPPER(name)='".strtoupper($nation)."' ORDER BY name ASC";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return null;
	}
	
	function items($info=NULL, $active=NULL, $limit=NULL, $offset=NULL)
	{
		$sql   = "SELECT * FROM {$this->_table} WHERE 1=1";
		if (!is_null($info)) {
		}
		if (!is_null($active)) {
			$sql .= " AND active = '{$active}'";
		}
		$sql .= " ORDER BY name ASC";
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
