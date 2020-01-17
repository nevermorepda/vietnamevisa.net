<?php
class M_tour_rate extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_tour_rates";
	}
	
	function items($info=NULL, $active=NULL, $limit=NULL, $offset=0)
	{
		$sql = "SELECT * FROM {$this->_table} WHERE 1 = 1";
		if (!empty($info->tour_id)) {
			$sql .= " AND tour_id = '{$info->tour_id}'";
		}
		if (!empty($info->name)) {
			$sql .= " AND name = '{$info->name}'";
		}
		if (!empty($info->type_passenger)) {
			$type_passenger = $info->type_passenger;
			if (is_array($info->type_passenger) && !empty($type_passenger)) {
				$type_passenger = implode(",",$info->type_passenger);
			}
			$sql .= " AND type_passenger IN(".$type_passenger.")";
		}
		if (!is_null($active)) {
			$sql .= " AND active = '{$active}'";
		}
		if (!is_null($info) && !empty($info->sortby)) {
			$orderby = !empty($info->orderby) ? $info->orderby : "ASC";
			switch($info->sortby){
				case 'type_passenger':
					$sql .= " ORDER BY type_passenger {$orderby}, group_size ASC";
			}
		}
		if (!is_null($limit)) {
			$sql .= " LIMIT {$limit}";
		}
		if (!empty($offset)) {
			$sql .= " OFFSET {$offset}";
		}
		$query = $this->db->query($sql);
		return $query->result();
	}
}
?>
