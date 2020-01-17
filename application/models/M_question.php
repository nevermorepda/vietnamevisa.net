<?php
class M_question extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_question";
	}
	
	function items($info=NULL, $approved=NULL, $limit=1000, $offset=NULL, $orderby=NULL, $sortby=NULL)
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
			else if (!empty($info->topLevel)) {
				$sql .= " AND parent_id IS NULL";
			}
			if (!empty($info->term)) {
				$arr = explode(" ", $info->term);
				$terms = "";
				foreach ($arr as $w) {
					$terms .= " OR title LIKE '%{$w}%' OR content LIKE '%{$w}%' ";
				}
				$sql .= " AND (title LIKE '%{$info->term}%' OR content LIKE '%{$info->term}%' {$terms})";
			}
		}
		
		if (!is_null($approved)) {
			$sql .= " AND active = '{$approved}'";
		}
		
		if (!empty($info->parent_id)) {
			$sql .= " ORDER BY created_date ASC";
		}
		else if (!empty($orderby) && !empty($sortby)) {
			$sql .= " ORDER BY {$orderby} {$sortby}, created_date DESC";
		}
		else {
			$sql .= " ORDER BY created_date DESC";
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
	
	function count($info=NULL, $approved=NULL, $orderby=NULL, $sortby=NULL)
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
			else if (!empty($info->topLevel)) {
				$sql .= " AND parent_id IS NULL";
			}
			if (!empty($info->term)) {
				$arr = explode(" ", $info->term);
				$terms = "";
				foreach ($arr as $w) {
					$terms .= " OR title LIKE '%{$w}%' OR content LIKE '%{$w}%' ";
				}
				$sql .= " AND (title LIKE '%{$info->term}%' OR content LIKE '%{$info->term}%' {$terms})";
			}
		}
		
		if (!is_null($approved)) {
			$sql .= " AND active = '{$approved}'";
		}
		
		if (!empty($info->parent_id)) {
			$sql .= " ORDER BY created_date ASC";
		}
		else if (!empty($orderby) && !empty($sortby)) {
			$sql .= " ORDER BY {$orderby} {$sortby}, created_date DESC";
		}
		else {
			$sql .= " ORDER BY created_date DESC";
		}
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->row()->total;
		}
		
		return 0;
	}
}
?>
