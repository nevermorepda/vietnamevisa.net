<?php
class M_agent_private_letter_fee extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_agent_private_letter_fee";
	}
	
	function items($info=NULL, $limit=NULL, $offset=NULL)
	{
		$sql  = "SELECT * FROM {$this->_table} WHERE 1 = 1";
		if (!is_null($info)) {
			if (!empty($info->agents_id)) {
				$sql .= " AND agents_id = '{$info->agents_id}'";
			}
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
}
?>