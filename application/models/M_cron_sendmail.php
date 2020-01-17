<?php
class M_cron_sendmail extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_cron_sendmail";
	}
	
	function items($info=NULL, $active=NULL, $limit=NULL, $offset=NULL)
	{
		$sql	= "SELECT * FROM {$this->_table} WHERE 1=1";
		if (!is_null($info)) {
			if (!empty($info->type)) {
				$sql .= " AND type = '{$info->type}'";
			}
			if (!empty($info->check_send_1d)) {
				$sql .= " AND check_send_1d = '{$info->check_send_1d}'";
			}
			if (!empty($info->check_send_3d)) {
				$sql .= " AND check_send_3d = '{$info->check_send_3d}'";
			}
			if (!empty($info->booking_date)) {
				$sql .= " AND DATE(booking_date) = '{$info->booking_date}'";
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
		$sql	= "SELECT COUNT(*) AS 'total' FROM {$this->_table} WHERE 1=1";
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