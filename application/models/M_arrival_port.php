<?php
class M_arrival_port extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_arrival_port";
	}
	
	function items($info=NULL, $active=NULL, $limit=NULL, $offset=NULL)
	{
		$sql  = "SELECT * FROM {$this->_table} WHERE 1 = 1";
		if (!is_null($info)) {
			if (!empty($info->category_id)) {
				$sql .= " AND category_id = '{$info->category_id}'";
			}
			if (!empty($info->short_name)) {
				$sql .= " AND short_name = '{$info->short_name}'";
			}
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
	public function load_short_name($id)
	{
		$sql = "SELECT * FROM {$this->_table} WHERE 1 = 1";
		$sql .= " AND short_name = '{$id}'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->row();
		} 
		return null;
	}
}
?>