<?php
class M_nation extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_nation";
	}
	
	function items()
	{
		$sql   = "SELECT * from vs_nation WHERE 1=1 ORDER BY name ASC";
		$query = $this->db->query($sql);
		return $query->result();
	}
	function nation_jion_visa_fee()
	{
		$sql = "SELECT {$this->_table}.id, name, region, alias, document_required, group_discount, get_fee_default FROM {$this->_table} INNER JOIN vs_visa_fee ON {$this->_table}.id = vs_visa_fee.nation_id WHERE 1=1 ORDER BY {$this->_table}.name ASC";
		$query = $this->db->query($sql);
		return $query->result();
	}
}
?>
