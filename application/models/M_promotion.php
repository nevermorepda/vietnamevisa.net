<?php
class M_promotion extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_promotion";
	}
	
	function item($info=NULL, $active=NULL)
	{
		$sql = "SELECT * FROM {$this->_table} WHERE 1 = 1";
		if (!is_null($info)) {
			if (!empty($info->code)) {
				$sql .= " AND code = '{$info->id}'";
			}
			if (!empty($info->visa_type)) {
				$sql .= " AND visa_type = '{$info->visa_type}'";
			}
		}
		$sql .= " LIMIT 1";
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return null;
	}
	
	function items($info=NULL, $active=NULL, $limit=NULL, $offset=NULL)
	{
		$sql = "SELECT * FROM {$this->_table} WHERE 1 = 1";
		
		if (!is_null($info)) {
			if (!empty($info->search_text)) {
				$sql .= " AND code = '{$info->search_text}'";
			}
			if (!empty($info->search_status)) {
				if ($info->search_status == -1) {
					$sql .= " AND DATE(end_date) < '".date('Y-m-d')."'";
				}
			}
		}
		if (!is_null($active)) {
			$sql .= " AND active = '{$active}'";
		}
		
		$sql .= " ORDER BY start_date DESC";
		
		if (!is_null($limit)) {
			$sql .= " LIMIT {$limit}";
		}
		if (!is_null($offset)) {
			$sql .= " OFFSET {$offset}";
		}
		
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	public function count($info=null, $active=null)
	{
		$sql = "SELECT COUNT(*) AS 'total' FROM {$this->_table} WHERE 1 = 1";
		if (!is_null($info)) {
			if (!empty($info->search_text)) {
				$sql .= " AND code = '{$info->search_text}'";
			}
			if (!empty($info->search_status)) {
				if ($info->search_status == -1) {
					$sql .= " AND DATE(end_date) < '".date('Y-m-d')."'";
				}
			}
		}
		if (!is_null($active)) {
			$sql .= " AND active = '{$active}'";
		}
		
		$sql .= " ORDER BY start_date DESC";
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->row()->total;
		}
		
		return 0;
	}
	
	function available_items($info=NULL)
	{
		$current_date = date("Y-m-d");
		$sql   = "SELECT * FROM {$this->_table} WHERE active = '1' AND start_date <= '{$current_date}' AND end_date >= '{$current_date}'";
		if (!is_null($info)) {
			if (!empty($info->visa_type)) {
				$sql .= " AND visa_type = '{$info->visa_type}'";
			}
		}
		$query = $this->db->query($sql);
		return $query->result();
	}
}
?>