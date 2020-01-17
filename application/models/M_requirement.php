<?php
class M_requirement extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_requirement";
	}
	
	function items($info=NULL, $active=NULL, $limit=NULL, $offset=NULL)
	{
		$sql   = "SELECT * FROM vs_requirement WHERE 1 = 1";
		if (!is_null($info)) {
		}
		if (!is_null($active)) {
			$sql .= " AND active = '{$active}'";
		}
		$sql .= " ORDER BY citizen ASC";
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