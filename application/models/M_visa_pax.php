<?php
class M_visa_pax extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_visa_pax";
	}
	
	function items($info=NULL, $active=NULL, $limit=NULL, $offset=NULL,$send_again=0)
	{
		$sql = "SELECT DISTINCT * FROM {$this->_table} WHERE 1 = 1";
		if (!is_null($info)) {
			if (!empty($info->search_text)) {
				$info->search_text = strtoupper(trim($info->search_text));
				$sql .= " AND UPPER(passport) = '{$info->search_text}'";
			}
			if (!empty($info->status)) {
				$sql .= " AND status = '{$info->status}'";
			}
			if (!empty($info->book_id)) {
				$sql .= " AND book_id = '{$info->book_id}'";
			}
			if (!empty($info->send_urgent)) {
				$sql .= " AND send_urgent = '{$info->send_urgent}'";
			}
		}
		if (!is_null($send_again)) {
			$sql .= " AND send_urgent = '{$send_again}'";
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
	
	function count($info=NULL, $active=NULL)
	{
		$sql = "SELECT DISTINCT * FROM {$this->_table} WHERE 1 = 1";
		if (!is_null($info)) {
			if (!empty($info->search_text)) {
				$info->search_text = strtoupper(trim($info->search_text));
				$sql .= " AND UPPER(passport) = '{$info->search_text}'";
			}
			if (!empty($info->status)) {
				$sql .= " AND status = '{$info->status}'";
			}
		}
		if (!is_null($active)) {
		}
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}
		return 0;
	}
	function update_multiple($data,$arr_id) {
		$sql = "UPDATE {$this->_table} SET ";
		$count_id = count($arr_id);
		$key = key($data);
		$sql .= "{$key} = '{$data[$key]}' ";
		
		$sql .= "WHERE id IN (";
		$i = 0;
		foreach ($arr_id as $id) {
			if (($i+1) != $count_id) {
				$sql .= "{$id},";
			} else {
				$sql .= "{$id}";
			}
			$i++;
		}
		$sql .=");";
		if (!empty($arr_id)) {
			$this->db->query($sql);
			return true;
		} else {
			return false;
		}
	}
}
?>