<?php
class M_useful extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_useful";
	}
	
	function items($info=NULL, $active=NULL, $limit=NULL, $offset=NULL, $orderby=NULL, $sortby=NULL)
	{
		$sql  = "SELECT * FROM vs_useful WHERE 1 = 1";
		if (!is_null($info)) {
			if (!empty($info->catid)) {
				$sql .= " AND catid = '{$info->catid}'";
			}
			if(!empty($info->search_text)){
				$search_text = trim(strtoupper($info->search_text));
				$sql .= " AND (UPPER(title) LIKE '%{$search_text}%' OR UPPER(content) LIKE '%$search_text%')";
			}
		}
		if (!is_null($active)) {
			$sql .= " AND active = '{$active}'";
		}

		if (!is_null($orderby) && !is_null($sortby)) {
			$sql .= " ORDER BY {$orderby} {$sortby}, updated_date DESC";
		}
		else {
			$sql .= " ORDER BY order_num ASC, created_date DESC";
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

	function getRelatedItems($excluded_id=0, $limit=NULL, $offset=NULL)
	{
		$sql_1   = "SELECT * FROM vs_useful WHERE id = '{$excluded_id}' AND active = '1'";
		$query_1 = $this->db->query($sql_1);
		$row_1   = $query_1->row();
		
		if (!empty($row_1)) {
			$keywords	= explode(',', $row_1->keywords);
			$likes		= array();
			
			$sql  = "SELECT * FROM vs_useful WHERE 1 = 1";
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
		$sql_1   = "SELECT * FROM vs_useful WHERE id = '{$excluded_id}' AND active = '1'";
		$query_1 = $this->db->query($sql_1);
		$row_1   = $query_1->row();
		
		if (!empty($row_1)) {
			$sql  = "SELECT * FROM vs_useful WHERE 1 = 1";
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
		$sql_1   = "SELECT * FROM vs_useful WHERE id = '{$excluded_id}' AND active = '1'";
		$query_1 = $this->db->query($sql_1);
		$row_1   = $query_1->row();
		
		if (!empty($row_1)) {
			$sql  = "SELECT * FROM vs_useful WHERE 1 = 1";
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