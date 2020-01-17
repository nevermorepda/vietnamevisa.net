<?php
class M_tour extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_tour";
	}

	function items($info=NULL, $active=NULL, $limit=NULL, $offset=NULL)
	{
		$sql  = "SELECT * FROM vs_tour WHERE 1 = 1";
		if (!is_null($info)) {
			if (!empty($info->catid)) {
				$sql .= " AND catid = '{$info->catid}'";
			}
			if (!empty($info->alias)) {
				$sql .= " AND alias = '{$info->alias}'";
			}
		}
		if (!is_null($active)) {
			$sql .= " AND active = '{$active}'";
		}
		
		$sql .= " ORDER BY created_date DESC";
		
		if (!is_null($limit)) {
			$sql .= " LIMIT {$limit}";
		}
		if (!is_null($offset)) {
			$sql .= " OFFSET {$offset}";
		}
		
		$query = $this->db->query($sql);
		return $query->result();
	}
	function getBooking($booking_id=NULL, $key=NULL)
	{
		$sql = "SELECT * FROM {$this->m_tour_booking->_table} WHERE 1 = 1";
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

	function getPaxs($booking_id=NULL)
	{
		$sql   = "SELECT * FROM {$this->m_tour_booking_pax->_table} WHERE 1 = 1";
		if (!is_null($booking_id)) {
			$sql .= " AND booking_id='{$booking_id}'";
		}
		$query = $this->db->query($sql);
		return $query->result();
	}

	function getBookings($info=NULL, $limit=NULL, $offset=NULL)
	{
		$sql  = "SELECT DISTINCT TB.*, T.name AS 'name' FROM {$this->m_tour_booking->_table} TB INNER JOIN {$this->_table} AS T ON (T.id = TB.tour_id) WHERE 1=1";
		if (!is_null($info)) {
			if (!empty($info->search_text)) {
				$ID = strtoupper(trim($info->search_text));
				$sql .= " AND (UPPER(TB.id) = '{$ID}' OR UPPER(TB.contact_email) LIKE '%{$ID}%' OR UPPER(TB.contact_fullname) LIKE '%{$ID}%')";
			}
			if (!empty($info->fromdate)) {
				$sql .= " AND DATE(TB.booking_date) >= '{$info->fromdate}'";
			}
			if (!empty($info->todate)) {
				$sql .= " AND DATE(TB.booking_date) <= '{$info->todate}'";
			}
			if (!empty($info->tour_id)) {
				$sql .= " AND TB.tour_id = '{$info->tour_id}'";
			}
			if (!empty($info->departure_date)) {
				$sql .= " AND TB.departure_date = '{$info->departure_date}'";
			}
			if (!empty($info->departure_id)) {
				$sql .= " AND TB.departure_id = '{$info->departure_id}'";
			}
			if (!empty($info->promotion_code) && $info->promotion_code == "*") {
				$sql .= " AND promotion_code <> ''";
			}
		}
		if (!is_null($info) && !empty($info->sortby)) {
			$orderby = !empty($info->orderby)?$info->orderby:"ASC";
			switch ($info->sortby) {
				case 'booking_date': $sql .= " ORDER BY TB.booking_date {$orderby}"; break;
				default: break;
			}
		} else {
			$sql .= " ORDER BY TB.booking_date DESC";
		}
		if (!is_null($limit)) {
			$sql .= " LIMIT {$limit}";
		}
		if (!is_null($offset)) {
			$sql .= " OFFSET {$offset}";
		}
		$query = $this->db->query($sql);
		return $query->result();
	}

	function delete_booking($where)
	{
		return $this->db->delete("{$this->m_tour_booking->_table}", $where);
	}

	function update_booking($data, $where)
	{
		return $this->db->update("{$this->m_tour_booking->_table}", $data, $where);
	}
}
?>