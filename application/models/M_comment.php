<?php
class M_comment extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_comment";
	}
	
	function items($info=NULL, $active=NULL, $limit=NULL, $offset=NULL, $orderby=NULL, $sortby=NULL)
	{
		$sql = "SELECT {$this->_table}.*, vs_users.user_fullname, vs_users.avatar FROM {$this->_table} INNER JOIN vs_users ON (vs_users.id = {$this->_table}.user_id) WHERE 1=1";
		if (!is_null($info)) {
			if (!is_null($info->parent_id)) {
				$sql .= " AND {$this->_table}.parent_id = '{$info->parent_id}'";
			}
		}
		if (!is_null($active)) {
			$sql .= " AND {$this->_table}.active = '{$active}'";
		}
		
		if (!is_null($orderby) && !is_null($sortby)) {
			$sql .= " ORDER BY {$this->_table}.{$orderby} {$sortby}, {$this->_table}.created_date DESC";
		}
		else {
			$sql .= " ORDER BY {$this->_table}.created_date DESC";
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