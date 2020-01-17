<?php
class M_support_online extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_support_online";
	}
	
	function items($info=NULL, $active=NULL, $limit=NULL, $offset=NULL)
	{
		$sql   = "SELECT * FROM vs_support_online WHERE 1 = 1";
		if (!is_null($info)) {
			if (!empty($info->online_date)) {
				$sql .= " AND start_date <= '{$info->online_date}'";
				$sql .= " AND end_date >= '{$info->online_date}'";
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
	
	function add($data)
	{
		return $this->db->insert("vs_support_online", $data);
	}
	
	function update($data, $where)
	{
		return $this->db->update("vs_support_online", $data, $where);
	}
	
	function delete($where)
	{
		return $this->db->delete("vs_support_online", $where);
	}
}
?>