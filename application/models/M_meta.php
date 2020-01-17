<?php
class M_meta extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_meta";
	}
	
	function item($info=NULL, $active=NULL)
	{
		$sql   = "SELECT * FROM {$this->_table} WHERE 1 = 1";
		if (!is_null($info)) {
			if (!empty($info->id)) {
				$sql .= " AND id = '{$info->id}'";
			}
			if (!empty($info->url)) {
				$info->url = str_replace("//", "/", $info->url."/");
				$info->url = substr($info->url, 0, -1);
				$sql .= " AND (url = 'http://{$info->url}' OR url = 'http://{$info->url}/' OR url = 'https://{$info->url}' OR url = 'https://{$info->url}/')";
			}
		}
		if (!is_null($active)) {
			$sql .= " AND active = '{$active}'";
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
		$sql  = "SELECT * FROM {$this->_table} WHERE 1 = 1";
		if (!is_null($info)) {
			if (!empty($info->url)) {
				$info->url = str_replace("//", "/", $info->url."/");
				$info->url = substr($info->url, 0, -1);
				$sql .= " AND (url = 'http://{$info->url}' OR url = 'http://{$info->url}/' OR url = 'https://{$info->url}' OR url = 'https://{$info->url}/')";
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
			if (!empty($info->url)) {
				$info->url = str_replace("//", "/", $info->url."/");
				$info->url = substr($info->url, 0, -1);
				$sql .= " AND (url = 'http://{$info->url}' OR url = 'http://{$info->url}/' OR url = 'https://{$info->url}' OR url = 'https://{$info->url}/')";
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