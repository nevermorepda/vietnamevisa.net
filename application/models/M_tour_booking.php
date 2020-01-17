<?php
class M_tour_booking extends M_db
{
	public function __construct()
	{
		parent::__construct();

		$this->_table = "vs_tour_booking";
	}
	
	function search($booking_id=NULL, $key=NULL)
	{
		$sql   = "SELECT * FROM m_tour_booking WHERE 1 = 1";
		if (!is_null($booking_id)) {
			$sql .= " AND id='{$booking_id}'";
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

	// function items($info=NULL, $limit=NULL, $offset=NULL, $sortby=NULL, $orderby=NULL)
	// {
	// 	$sql  = "SELECT DISTINCT {m_tour_booking}.*, T.name AS 'name' FROM {m_tour_booking} INNER JOIN {$this->m_tour->_table} AS T ON (T.id = {m_tour_booking}.tour_id) INNER JOIN {m_tour_booking}_pax ON ({m_tour_booking}_pax.booking_id = {m_tour_booking}.id) WHERE 1=1";
	// 	if (!is_null($info)) {
	// 		if (!empty($info->search_text)) {
	// 			$ID = strtoupper(trim($info->search_text));
	// 			$sql .= " AND (UPPER({m_tour_booking}.id) = '{$ID}' OR UPPER({m_tour_booking}.email) LIKE '%{$ID}%' OR UPPER({m_tour_booking}_pax.firstname) LIKE '%{$ID}%'  OR UPPER({m_tour_booking}_pax.lastname) LIKE '%{$ID}%')";
	// 		}
	// 		if (!empty($info->fromdate)) {
	// 			$sql .= " AND DATE({m_tour_booking}.booking_date) >= '{$info->fromdate}'";
	// 		}
	// 		if (!empty($info->todate)) {
	// 			$sql .= " AND DATE({m_tour_booking}.booking_date) <= '{$info->todate}'";
	// 		}
	// 		if (!empty($info->tour_id)) {
	// 			$sql .= " AND {m_tour_booking}.tour_id = '{$info->tour_id}'";
	// 		}
	// 	}
	// 	if (!is_null($sortby)) {
	// 		$sql .= " ORDER BY {$sortby} {$orderby}";
	// 	} else {
	// 		$sql .= " ORDER BY {m_tour_booking}.booking_date DESC";
	// 	}
	// 	if (!is_null($limit)) {
	// 		$sql .= " LIMIT {$limit}";
	// 	}
	// 	if (!is_null($offset)) {
	// 		$sql .= " OFFSET {$offset}";
	// 	}
	// 	$query = $this->db->query($sql);
	// 	return $query->result();
	// }
	
	function items($info=NULL, $limit=NULL, $offset=NULL)
	{
		$sql  = "SELECT * FROM {$this->_table} WHERE 1 = 1";
		if (!is_null($info)) {
			if (!empty($info->catid)) {
				$sql .= " AND catid = '{$info->catid}'";
			}
			if (!empty($info->alias)) {
				$sql .= " AND alias = '{$info->alias}'";
			}
			if (!empty($info->fromdate)) {
				$sql .= " AND DATE({$this->_table}.booking_date) >= '{$info->fromdate}'";
			}
			if (!empty($info->todate)) {
				$sql .= " AND DATE({$this->_table}.booking_date) <= '{$info->todate}'";
			}
			if (!empty($info->tour_id)) {
				$sql .= " AND {$this->_table}.tour_id = '{$info->tour_id}'";
			}
		}
		$sql .= " ORDER BY tour_id ASC";
		
		if (!is_null($limit)) {
			$sql .= " LIMIT {$limit}";
		}
		if (!is_null($offset)) {
			$sql .= " OFFSET {$offset}";
		}
		
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function user_booking($user_id,$limit=NULL,$offset=NULL)
	{
		$sql = "SELECT m_tour_booking.*, m_tour_booking.id AS 'booking_id' FROM m_tour_booking, m_user WHERE m_user.id = m_tour_booking.user_id AND m_user.id='{$user_id}' ORDER BY m_tour_booking.booking_date DESC";
		if (!is_null($limit)) {
			$sql .= " LIMIT {$limit}";
		}
		if (!is_null($offset)) {
			$sql .= " OFFSET {$offset}";
		}
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function booking_pax($booking_id)
	{
		$sql   = "SELECT * FROM m_tour_booking_pax WHERE booking_id='{$booking_id}'";
		$query = $this->db->query($sql);
		return $query->result();
	}
}
?>
