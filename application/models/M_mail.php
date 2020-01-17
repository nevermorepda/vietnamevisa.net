<?php
class M_mail extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_mail";
	}
	
	function items($info=NULL, $active=NULL, $limit=NULL, $offset=NULL)
	{
		$sql   = "SELECT * FROM {$this->_table} WHERE 1=1";
		if (!is_null($info)) {
			if (!empty($info->search_text)) {
				$sql .= " AND (sender LIKE '%{$info->search_text}%' OR title LIKE '%{$info->search_text}%')";
			}
			if (!empty($info->fromdate)) {
				$sql .= " AND DATE(created_date) >= '{$info->fromdate}'";
			}
			if (!empty($info->todate)) {
				$sql .= " AND DATE(created_date) <= '{$info->todate}'";
			}
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
	
	function count($info=NULL, $active=NULL)
	{
		$sql   = "SELECT COUNT(*) AS 'total' FROM {$this->_table} WHERE 1=1";
		if (!is_null($info)) {
			if (!empty($info->search_text)) {
				$sql .= " AND (sender LIKE '%{$info->search_text}%' OR title LIKE '%{$info->search_text}%')";
			}
		}
		if (!is_null($active)) {
			$sql .= " AND active = '{$active}'";
		}
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->row()->total;
		}
		
		return 0;
	}
	
	function delete_all()
	{
		return $this->db->empty_table($this->_table);
	}
}
?>