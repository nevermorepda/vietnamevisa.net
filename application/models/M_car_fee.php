<?php
class M_car_fee extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_car_fee";
	}
	
	function search($seats, $arrival_port, $capital=NULL)
	{
		if (!is_null($capital)) {
			$capital = "capital_";
		} else {
			$capital = "";
		}
		
		$car_type = $capital."seat_".$seats;
		
		if ($this->db->field_exists($car_type, $this->_table)) {
			$sql   = "SELECT {$car_type} FROM {$this->_table} WHERE {$this->_table}.airport = '{$arrival_port}'";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				$row = $query->row();
				return $row->{$car_type};
			} else {
				$new_instance = $this->instance();
				return $new_instance->{$car_type};
			}
		}
		return 0;
	}
	
	function items($info=NULL)
	{
		$sql = "SELECT * FROM {$this->_table} WHERE 1 = 1";
		if (!is_null($info)) {
			if (!empty($info->airport)) {
				$sql .= " AND {$this->_table}.airport = '{$info->airport}'";
			}
		}
		$query = $this->db->query($sql);
		return $query->result();
	}
}
?>
