<?php
class M_setting extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_setting";
	}
	
	function items()
	{
		$sql   = "SELECT * FROM {$this->_table}";
		$query = $this->db->query($sql);
		return $query->result();
	}

	function count($info=NULL, $active=NULL)
	{
		$sql = "SELECT COUNT(*) FROM {$this->_table} WHERE 1 = 1";
		if (!is_null($info)) {
			if (!empty($info->category_id)) {
				$sql .= " AND category_id = '{$info->category_id}'";
			}
			
			if (!empty($info->parent_id)) {
				if (is_array($info->parent_id)) {
					$sql .= " AND parent_id IN (".implode(",", $info->parent_id).")";
				} else {
					$sql .= " AND parent_id = '{$info->parent_id}'";
				}
			}
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