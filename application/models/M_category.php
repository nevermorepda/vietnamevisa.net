<?php
class M_category extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_category";
	}
	
	function items($info=NULL, $active=NULL, $limit=NULL, $offset=NULL)
	{
		$sql = "SELECT *, (SELECT COUNT(C.id) FROM vs_content AS C WHERE C.catid = CC.id) AS 'child_num' FROM {$this->_table} AS CC WHERE 1 = 1";
		if (!is_null($info)) {
			if (!is_null($info->parent_id)) {
				$sql .= " AND parent_id = '{$info->parent_id}'";
			}
			if (!empty($info->lang)) {
				$sql .= " AND lang = '{$info->lang}'";
			}
		}
		if (!is_null($active)) {
			$sql .= " AND active = '{$active}'";
		}
		$sql .= " ORDER BY order_num ASC";
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