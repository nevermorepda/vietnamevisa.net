<?php
class M_service_booking extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_service_booking";
	}
	
	function booking($id=NULL, $key=NULL)
	{
		$sql   = "SELECT * FROM {$this->_table} WHERE 1 = 1";
		if (!is_null($id)) {
			$sql .= " AND id='{$id}'";
		}
		if (!is_null($key)) {
			$sql .= " AND booking_key='{$key}'";
		}
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return null;
	}
	
	function bookings($info=NULL, $limit=NULL, $offset=NULL)
	{
		$sql  = "SELECT DISTINCT {$this->_table}.* FROM {$this->_table} WHERE 1=1";
		if (!is_null($info)) {
			if (!empty($info->search_text)) {
				$info->search_text = strtoupper(trim($info->search_text));
				$ID = preg_replace("/[^0-9]/", "", $info->search_text);
				if ($this->email->valid_email($info->search_text)) {
					$sql .= " AND (UPPER({$this->_table}.welcome_name) LIKE '%{$info->search_text}%' OR UPPER({$this->_table}.contact_name) LIKE '%{$info->search_text}%' OR {$this->_table}.id = '{$ID}' OR UPPER({$this->_table}.primary_email) LIKE '%{$info->search_text}%')";
				} else {
					$sql .= " AND (UPPER({$this->_table}.welcome_name) LIKE '%{$info->search_text}%' OR UPPER({$this->_table}.contact_name) LIKE '%{$info->search_text}%' OR {$this->_table}.id = '{$ID}')";
				}
			}
			if (!empty($info->payment_method)) {
				$sql .= " AND {$this->_table}.payment_method = '{$info->payment_method}'";
			}
			if (!empty($info->fromdate)) {
				$sql .= " AND DATE({$this->_table}.booking_date) >= '{$info->fromdate}'";
			}
			if (!empty($info->todate)) {
				$sql .= " AND DATE({$this->_table}.booking_date) <= '{$info->todate}'";
			}
			if (!empty($info->from_arrival_date)) {
				$sql .= " AND {$this->_table}.arrival_date >= '{$info->from_arrival_date}'";
			}
			if (!empty($info->to_arrival_date)) {
				$sql .= " AND {$this->_table}.arrival_date <= '{$info->to_arrival_date}'";
			}
			if (!empty($info->agents_fc_id)) {
				$sql .= " AND {$this->_table}.agents_id = '{$info->agents_fc_id}'";
			}
			if (!empty($info->status)) {
				$sql .= " AND {$this->_table}.status = '{$info->status}'";
			}
			if (!empty($info->service_status)) {
				$sql .= " AND ({$this->_table}.status = '{$info->service_status}' OR {$this->_table}.other_payment = '{$info->service_status}')";
			}
		}
		$sql .= " ORDER BY {$this->_table}.booking_date DESC";
		if (!is_null($limit)) {
			$sql .= " LIMIT {$limit}";
		}
		if (!is_null($offset)) {
			$sql .= " OFFSET {$offset}";
		}
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function total_bookings($info=NULL, $limit=NULL, $offset=NULL, $status=NULL)
	{
		$sql  = "SELECT COUNT(*) AS 'total' FROM (";
		$sql .= "SELECT DISTINCT {$this->_table}.* FROM {$this->_table} WHERE 1=1";
		if (!is_null($info)) {
			if (!empty($info->search_text)) {
				$info->search_text = strtoupper(trim($info->search_text));
				$ID = preg_replace("/[^0-9]/", "", $info->search_text);
				if ($this->email->valid_email($info->search_text)) {
					$sql .= " AND (UPPER({$this->_table}.welcome_name) LIKE '%{$info->search_text}%' OR UPPER({$this->_table}.contact_name) LIKE '%{$info->search_text}%' OR {$this->_table}.id = '{$ID}' OR UPPER({$this->_table}.primary_email) LIKE '%{$info->search_text}%')";
				} else {
					$sql .= " AND (UPPER({$this->_table}.welcome_name) LIKE '%{$info->search_text}%' OR UPPER({$this->_table}.contact_name) LIKE '%{$info->search_text}%' OR {$this->_table}.id = '{$ID}')";
				}
			}
			if (!empty($info->payment_method)) {
				$sql .= " AND {$this->_table}.payment_method = '{$info->payment_method}'";
			}
			if (!empty($info->fromdate)) {
				$sql .= " AND DATE({$this->_table}.booking_date) >= '{$info->fromdate}'";
			}
			if (!empty($info->todate)) {
				$sql .= " AND DATE({$this->_table}.booking_date) <= '{$info->todate}'";
			}
		}
		$sql .= " ORDER BY {$this->_table}.booking_date DESC";
		if (!is_null($limit)) {
			$sql .= " LIMIT {$limit}";
		}
		if (!is_null($offset)) {
			$sql .= " OFFSET {$offset}";
		}
		$sql .= ") AS BOOKING";
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->total;
		}
		return 0;
	}
	
	function book_by_user($user_id=NULL)
	{
		$sql   = "SELECT *, {$this->_table}.id AS 'book_id' FROM {$this->_table}, vs_users WHERE vs_users.id = {$this->_table}.user_id";
		if (!is_null($user_id)) {
			$sql .= " AND vs_users.id='{$user_id}'";
		}
		$sql .= " ORDER BY {$this->_table}.booking_date";
		
		$query = $this->db->query($sql);
		return $query->result();
	}
	function update_multiple($data,$arr_id) {
		$sql = "UPDATE {$this->_table} SET ";
		$count_id = count($arr_id);
		$key = key($data);
		$sql .= "{$key} = '{$data[$key]}' ";
		
		$sql .= "WHERE id IN (";
		$i = 0;
		foreach ($arr_id as $id) {
			if (($i+1) != $count_id) {
				$sql .= "{$id},";
			} else {
				$sql .= "{$id}";
			}
			$i++;
		}
		$sql .=");";
		if (!empty($arr_id)) {
			$this->db->query($sql);
			return true;
		} else {
			return false;
		}
	}
}
?>
