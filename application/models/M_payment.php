<?php
class M_payment extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_payment";
	}
	
	function item($info=NULL, $key=NULL)
	{
		$sql   = "SELECT * FROM {$this->_table} WHERE 1 = 1";
		if (!empty($key)) {
			$sql .= " AND payment_key = '{$key}'";
		}
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return null;
	}
	
	function items($info=NULL, $key=NULL, $limit=NULL, $offset=NULL)
	{
		$sql  = "SELECT * FROM {$this->_table} WHERE 1 = 1";
		if (!is_null($info)) {
			if (!empty($info->search_text)) {
				$info->search_text = strtoupper(trim($info->search_text));
				$ID = preg_replace("/[^0-9]/", "", $info->search_text);
				if ($this->email->valid_email($info->search_text)) {
					$sql .= " AND (UPPER({$this->_table}.fullname) LIKE '%{$info->search_text}%' OR {$this->_table}.id = '{$ID}' OR UPPER({$this->_table}.primary_email) LIKE '%{$info->search_text}%')";
				} else {
					$sql .= " AND (UPPER({$this->_table}.fullname) LIKE '%{$info->search_text}%' OR {$this->_table}.id = '{$ID}')";
				}
			}
			if (!empty($info->payment_method)) {
				$sql .= " AND {$this->_table}.payment_method = '{$info->payment_method}'";
			}
			if (!empty($info->fromdate)) {
				$sql .= " AND DATE({$this->_table}.payment_date) >= '{$info->fromdate}'";
			}
			if (!empty($info->todate)) {
				$sql .= " AND DATE({$this->_table}.payment_date) <= '{$info->todate}'";
			}
		}
		if (!is_null($key)) {
			$sql .= " AND payment_key = '{$key}'";
		}
		
		$sql .= " ORDER BY {$this->_table}.id DESC";
		
		if (!is_null($limit)) {
			$sql .= " LIMIT {$limit}";
		}
		if (!is_null($offset)) {
			$sql .= " OFFSET {$offset}";
		}
		
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function total_items($info=NULL, $key=NULL, $limit=NULL, $offset=NULL, $status=NULL)
	{
		$sql  = "SELECT COUNT(*) AS 'total' FROM (";
		$sql .= "SELECT * FROM {$this->_table} WHERE 1 = 1";
		if (!is_null($info)) {
			if (!empty($info->search_text)) {
				$info->search_text = strtoupper(trim($info->search_text));
				$ID = preg_replace("/[^0-9]/", "", $info->search_text);
				if ($this->email->valid_email($info->search_text)) {
					$sql .= " AND (UPPER({$this->_table}.fullname) LIKE '%{$info->search_text}%' OR {$this->_table}.id = '{$ID}' OR UPPER({$this->_table}.primary_email) LIKE '%{$info->search_text}%')";
				} else {
					$sql .= " AND (UPPER({$this->_table}.fullname) LIKE '%{$info->search_text}%' OR {$this->_table}.id = '{$ID}')";
				}
			}
			if (!empty($info->payment_method)) {
				$sql .= " AND {$this->_table}.payment_method = '{$info->payment_method}'";
			}
			if (!empty($info->fromdate)) {
				$sql .= " AND DATE({$this->_table}.payment_date) >= '{$info->fromdate}'";
			}
			if (!empty($info->todate)) {
				$sql .= " AND DATE({$this->_table}.payment_date) <= '{$info->todate}'";
			}
		}
		if (!is_null($key)) {
			$sql .= " AND payment_key = '{$key}'";
		}
		
		$sql .= " ORDER BY {$this->_table}.id DESC";
		
		if (!is_null($limit)) {
			$sql .= " LIMIT {$limit}";
		}
		if (!is_null($offset)) {
			$sql .= " OFFSET {$offset}";
		}
		$sql .= ") AS PAYMENT";
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->total;
		}
		return 0;
	}
}
?>