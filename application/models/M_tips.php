<?php
class M_tips extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_tips";
	}
	
	function items($info=NULL, $active=NULL, $limit=NULL, $offset=NULL)
	{
		$sql   = "SELECT * FROM vs_tips WHERE 1 = 1";
		if (!is_null($info)) {
			if (!empty($info->nation)) {
				$sql .= " AND nation = '{$info->nation}'";
			}
		}
		if (!is_null($active)) {
			$sql .= " AND active = '{$active}'";
		}
		$sql .= " ORDER BY nation ASC";
		if (!is_null($limit)) {
			$sql .= " LIMIT {$limit}";
		}
		if (!is_null($offset)) {
			$sql .= " OFFSET {$offset}";
		}
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function getNewerItems($excluded_id=0, $limit=NULL, $offset=NULL)
	{
		$sql_1   = "SELECT * FROM vs_tips WHERE id = '{$excluded_id}' AND active = '1'";
		$query_1 = $this->db->query($sql_1);
		$row_1   = $query_1->row();
		
		if (!empty($row_1)) {
			$sql  = "SELECT * FROM vs_tips WHERE 1 = 1";
			$sql .= " AND id <> '{$excluded_id}'";
			$sql .= " AND active = '1'";
			$sql .= " AND nation > '{$row_1->nation}'";
			$sql .= " ORDER BY nation ASC";
			
			if (!is_null($limit)) {
				$sql .= " LIMIT {$limit}";
			}
			if (!is_null($offset)) {
				$sql .= " OFFSET {$offset}";
			}
			
			$query = $this->db->query($sql);
			return $query->result();
		}
		return null;
	}
	
	function getOlderItems($excluded_id=0, $limit=NULL, $offset=NULL)
	{
		$sql_1   = "SELECT * FROM vs_tips WHERE id = '{$excluded_id}' AND active = '1'";
		$query_1 = $this->db->query($sql_1);
		$row_1   = $query_1->row();
		
		if (!empty($row_1)) {
			$sql  = "SELECT * FROM vs_tips WHERE 1 = 1";
			$sql .= " AND id <> '{$excluded_id}'";
			$sql .= " AND active = '1'";
			$sql .= " AND nation < '{$row_1->nation}'";
			$sql .= " ORDER BY nation DESC";
			
			if (!is_null($limit)) {
				$sql .= " LIMIT {$limit}";
			}
			if (!is_null($offset)) {
				$sql .= " OFFSET {$offset}";
			}
			
			$query = $this->db->query($sql);
			return array_reverse($query->result());
		}
		return null;
	}
}
?>