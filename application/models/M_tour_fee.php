<?php
class M_tour_fee extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_tour_fee";
	}

	function items($info=NULL, $active=NULL, $limit=NULL, $offset=NULL)
	{
		$sql  = "SELECT * FROM {$this->_table} WHERE 1 = 1";
		if (!is_null($info)) {
			if (!empty($info->tour_id)) {
				$sql .= " AND tour_id = '{$info->tour_id}'";
			}
			if (!empty($info->type)) {
				$sql .= " AND type = '{$info->type}'";
			}
		}
		if (!is_null($active)) {
			$sql .= " AND active = '{$active}'";
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