<?php
class M_car_plus_fee extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_car_plus_fee";
	}
	
	function search($port)
	{
		$sql = "SELECT * FROM {$this->_table} WHERE port='{$port}'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return null;
	}
	
	function items($info=NULL)
	{
		$sql = "SELECT {$this->_table}.*, vs_arrival_port.* FROM {$this->_table} INNER JOIN vs_arrival_port ON {$this->_table}.port = vs_arrival_port.id WHERE 1 = 1";
		if (!is_null($info)) {
			if (!empty($info->port)) {
				$sql .= " AND {$this->_table}.port = '{$info->port}'";
			}
		}
		$query = $this->db->query($sql);
		return $query->result();
	}
}
?>
