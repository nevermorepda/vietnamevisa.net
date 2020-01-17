<?php
class M_letter_log extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_letter_log";
	}
	
	function items($info=NULL, $limit=NULL, $offset=NULL)
	{
		$sql   = "SELECT * FROM {$this->_table} WHERE 1=1";
		if (!is_null($info)) {
			if (!empty($info->user_id)) {
				$sql .= " AND user_id = '{$info->user_id}'";
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
}
?>