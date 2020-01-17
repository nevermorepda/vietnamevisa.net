<?php
class M_redirect extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_redirect";
	}
	
	function item($info=NULL)
	{
		$sql   = "SELECT * FROM {$this->_table} WHERE 1 = 1";
		if (!is_null($info)) {
			if (!empty($info->id)) {
				$sql .= " AND id = '{$info->id}'";
			}
			if (!empty($info->from_url)) {
				$info->from_url = str_replace("//", "/", $info->from_url."/");
				$info->from_url = substr($info->from_url, 0, -1);
				$sql .= " AND (from_url = 'http://{$info->from_url}' OR from_url = 'http://{$info->from_url}/' OR from_url = 'https://{$info->from_url}' OR from_url = 'https://{$info->from_url}/')";
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
		$sql   = "SELECT * FROM {$this->_table} WHERE 1 = 1";
		if (!is_null($info)) {
			if (!empty($info->from_url)) {
				$sql .= " AND from_url = '{$info->from_url}'";
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
	
	public function count($info=null, $active=null)
	{
		$sql = "SELECT COUNT(*) AS 'total' FROM {$this->_table} WHERE 1 = 1";
		if (!is_null($info)) {
			if (!empty($info->from_url)) {
				$sql .= " AND from_url = '{$info->from_url}'";
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
}
?>