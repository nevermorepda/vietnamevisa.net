<?php
class M_history extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_history";
	}
	
	function items($info=NULL, $limit=NULL, $offset=NULL)
	{
		$sql  = "SELECT * FROM {$this->_table} WHERE 1=1";
		if (!is_null($info)) {
		}
		$sql .= " ORDER BY created_date DESC";
		if (!is_null($limit)) {
			$sql .= " LIMIT {$limit}";
		}
		if (!is_null($offset)) {
			$sql .= " OFFSET {$offset}";
		}
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function count($info=NULL)
	{
		$sql = "SELECT COUNT(*) AS 'total' FROM {$this->_table} WHERE 1=1";
		if (!is_null($info)) {
		}
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->row()->total;
		}
		return 0;
	}
	
	function search($table_name=NULL, $item_id=NULL, $user_id=NULL, $limit=NULL, $offset=NULL)
	{
		$sql  = "SELECT * FROM {$this->_table} WHERE 1=1";
		if (!is_null($table_name)) {
			$sql .= " AND table_name = '{$table_name}'";
		}
		if (!is_null($item_id)) {
			$sql .= " AND item_id = '{$item_id}'";
		}
		if (!is_null($user_id)) {
			$sql .= " AND user_id = '{$user_id}'";
		}
		$sql .= " ORDER BY created_date DESC";
		if (!is_null($limit)) {
			$sql .= " LIMIT {$limit}";
		}
		if (!is_null($offset)) {
			$sql .= " OFFSET {$offset}";
		}
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function delete_all()
	{
		return $this->db->empty_table($this->_table);
	}
}
?>
