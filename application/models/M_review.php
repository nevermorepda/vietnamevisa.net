<?php
class M_review extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_review";
	}
	
	function items($info=NULL, $active=NULL, $limit=NULL, $offset=NULL)
	{
		$sql = "SELECT * FROM {$this->_table} WHERE 1 = 1";
		if (!is_null($info)) {
			if (!empty($info->category_id)) {
				$sql .= " AND category_id = '{$info->category_id}'";
			}
			if (!empty($info->ref_id)) {
				$sql .= " AND ref_id = '{$info->ref_id}'";
			}
			if (!empty($info->parent_id)) {
				if (is_array($info->parent_id)) {
					$sql .= " AND parent_id IN (".implode(",", $info->parent_id).")";
				} else {
					$sql .= " AND parent_id = '{$info->parent_id}'";
				}
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
	
	function count($info=NULL, $active=NULL)
	{
		$sql = "SELECT COUNT(*) AS 'total' FROM {$this->_table} WHERE 1 = 1";
		if (!is_null($info)) {
			if (!empty($info->category_id)) {
				$sql .= " AND category_id = '{$info->category_id}'";
			}
			if (!empty($info->ref_id)) {
				$sql .= " AND ref_id = '{$info->ref_id}'";
			}
			if (!empty($info->parent_id)) {
				if (is_array($info->parent_id)) {
					$sql .= " AND parent_id IN (".implode(",", $info->parent_id).")";
				} else {
					$sql .= " AND parent_id = '{$info->parent_id}'";
				}
			}
		}
		if (!is_null($active)) {
			$sql .= " AND active = '{$active}'";
		}
		$sql .= " ORDER BY created_date DESC";
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->row()->total;
		}
		
		return 0;
	}
}
?>