<?php
class M_requirement extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_requirement";
	}
	
	function items($info=NULL, $active=NULL, $limit=NULL, $offset=NULL)
	{
		$sql   = "SELECT * FROM vs_requirement WHERE 1 = 1";
		if (!is_null($info)) {
			if (!empty($info->nation)) {
				$sql .= " AND (nation = '{$info->nation}' OR LCASE(nation) LIKE '%".str_ireplace("-"," ",$info->nation)."%')";
			}
			if (!empty($info->alias)) {
				$sql .= " AND alias = '{$info->alias}'";
			}
		}
		if (!is_null($active)) {
			$sql .= " AND active = '{$active}'";
		}
		$sql .= " ORDER BY citizen ASC";
		if (!is_null($limit)) {
			$sql .= " LIMIT {$limit}";
		}
		if (!is_null($offset)) {
			$sql .= " OFFSET {$offset}";
		}
		
		$query = $this->db->query($sql);
		return $query->result();
	}

	function join_country_items($info=NULL, $active=NULL, $limit=NULL, $offset=NULL)
	{
		$sql = "SELECT {$this->_table}.*, vs_country.id as country_id, vs_country.name as country_name, vs_country.alias as country_alias, vs_country.region as country_region FROM {$this->_table} INNER JOIN vs_country ON {$this->_table}.alias = vs_country.alias WHERE 1 = 1";
		if (!is_null($info)) {
			if (!empty($info->alias)) {
				$sql .= " AND {$this->_table}.alias = '{$info->alias}'";
			}
			if (!empty($info->region)) {
				$sql .= " AND vs_country.region = '{$info->region}'";
			}
			if (!empty($info->type)) {
				$sql .= " AND {$this->_table}.type = '{$info->type}'";
			}
		}
		if (!is_null($active)) {
			$sql .= " AND {$this->_table}.active = '{$active}'";
		}
		$sql .= " ORDER BY citizen ASC";
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