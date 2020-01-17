<?php
class M_nation_type extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_nation_type";
	}
	
	function items()
	{
		$sql   = "SELECT * from {$this->_table} WHERE 1=1 ORDER BY id ASC";
		$query = $this->db->query($sql);
		return $query->result();
	}
}
?>
