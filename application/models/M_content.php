<?php
class M_content extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_content";
	}
	
	function items($info=NULL, $active=NULL, $limit=NULL, $offset=NULL)
	{
		$sql  = "SELECT * FROM vs_content WHERE 1 = 1";
		if (!is_null($info)) {
			if (!empty($info->catid)) {
				$sql .= " AND catid = '{$info->catid}'";
			}
		}
		if (!is_null($active)) {
			$sql .= " AND active = '{$active}'";
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
	
	function getRelatedItems($excluded_id=0, $limit=NULL, $offset=NULL)
	{
		$sql_1   = "SELECT * FROM vs_content WHERE id = '{$excluded_id}' AND active = '1'";
		$query_1 = $this->db->query($sql_1);
		$row_1   = $query_1->row();
		
		if (!empty($row_1)) {
			$keywords	= explode(',', $row_1->keywords);
			$likes		= array();
			
			$sql  = "SELECT * FROM vs_content WHERE 1 = 1";
			$sql .= " AND id <> '{$excluded_id}'";
			$sql .= " AND catid = '{$row_1->catid}'";
			$sql .= " AND lang  = '{$row_1->lang}'";
			$sql .= " AND active = '1'";
			if (!empty($row_1->keywords)) {
				foreach ($keywords as $k) {
					if (!empty($k) && trim($k) != "") {
						$likes[] = " title LIKE '%".trim($k)."%' ";
					}
				}
				$sql .= " AND (".implode(" OR ", $likes).")";
			} else {
				$sql .= " AND FALSE ";
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
		return null;
	}
	
	function getNewerItems($excluded_id=0, $limit=NULL, $offset=NULL)
	{
		$sql_1   = "SELECT * FROM vs_content WHERE id = '{$excluded_id}' AND active = '1'";
		$query_1 = $this->db->query($sql_1);
		$row_1   = $query_1->row();
		
		if (!empty($row_1)) {
			$sql  = "SELECT * FROM vs_content WHERE 1 = 1";
			$sql .= " AND id <> '{$excluded_id}'";
			$sql .= " AND catid = '{$row_1->catid}'";
			$sql .= " AND lang  = '{$row_1->lang}'";
			$sql .= " AND active = '1'";
			$sql .= " AND created_date >= '{$row_1->created_date}'";
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
		return null;
	}
	
	function getOlderItems($excluded_id=0, $limit=NULL, $offset=NULL)
	{
		$sql_1   = "SELECT * FROM vs_content WHERE id = '{$excluded_id}' AND active = '1'";
		$query_1 = $this->db->query($sql_1);
		$row_1   = $query_1->row();
		
		if (!empty($row_1)) {
			$sql  = "SELECT * FROM vs_content WHERE 1 = 1";
			$sql .= " AND id <> '{$excluded_id}'";
			$sql .= " AND catid = '{$row_1->catid}'";
			$sql .= " AND lang  = '{$row_1->lang}'";
			$sql .= " AND active = '1'";
			$sql .= " AND created_date <= '{$row_1->created_date}'";
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
		return null;
	}
}
?>