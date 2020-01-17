<?php
class M_visa_booking extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_visa_booking";
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
		$sql  = "SELECT DISTINCT {$this->_table}.*, U.user_registered FROM {$this->_table} INNER JOIN vs_users AS U ON (U.id = {$this->_table}.user_id) WHERE 1=1";
		if (!is_null($info)) {
			if (!empty($info->search_text)) {
				$sql  = "SELECT DISTINCT {$this->_table}.*, U.user_registered FROM {$this->_table} INNER JOIN vs_users AS U ON (U.id = {$this->_table}.user_id) INNER JOIN vs_visa_pax ON (vs_visa_pax.book_id = {$this->_table}.id) WHERE 1=1";
				$info->search_text = strtoupper(trim($info->search_text));
				$ID = preg_replace("/[^0-9]/", "", $info->search_text);
				if ($this->email->valid_email($info->search_text)) {
					$sql .= " AND (UPPER(vs_visa_pax.fullname) LIKE '%{$info->search_text}%' OR UPPER(vs_visa_pax.passport) LIKE '%{$info->search_text}%' OR {$this->_table}.id = '{$ID}' OR {$this->_table}.order_ref = '{$ID}' OR {$this->_table}.promotion_code LIKE '%{$info->search_text}%' OR UPPER({$this->_table}.primary_email) LIKE '%{$info->search_text}%' OR UPPER({$this->_table}.secondary_email) LIKE '%{$info->search_text}%')";
				} else {
					$sql .= " AND (UPPER(vs_visa_pax.fullname) LIKE '%{$info->search_text}%' OR UPPER(vs_visa_pax.passport) LIKE '%{$info->search_text}%' OR {$this->_table}.id = '{$ID}' OR {$this->_table}.order_ref = '{$ID}' OR {$this->_table}.promotion_code LIKE '%{$info->search_text}%')";
				}
			}
			if (!empty($info->visa_type)) {
				$sql .= " AND {$this->_table}.visa_type = '{$info->visa_type}'";
			}
			if (!empty($info->visit_purpose)) {
				$sql .= " AND {$this->_table}.visit_purpose = '{$info->visit_purpose}'";
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
			if (!empty($info->promotion_code) && $info->promotion_code == "*") {
				$sql .= " AND {$this->_table}.promotion_code <> ''";
			}
			if (!empty($info->arrival_date)) {
				$sql .= " AND DATE({$this->_table}.arrival_date) = '{$info->arrival_date}'";
			}
			if (!empty($info->booking_date)) {
				$sql .= " AND DATE({$this->_table}.booking_date) = '{$info->booking_date}'";
			}
			if (!empty($info->status)) {
				$sql .= " AND {$this->_table}.status = '{$info->status}'";
			}
			if (!empty($info->agents_id)) {
				$sql .= " AND {$this->_table}.agents_id = '{$info->agents_id}'";
			}
		}
		if (!is_null($info) && !empty($info->sortby)) {
			$sql .= " ORDER BY {$this->_table}.{$info->sortby} {$info->orderby}";
		} else {
			$sql .= " ORDER BY {$this->_table}.booking_date DESC";
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
	
	function total_bookings($info=NULL, $limit=NULL, $offset=NULL, $status=NULL)
	{
		$sql  = "SELECT COUNT(*) AS 'total' FROM (";
		$sql .= "SELECT DISTINCT {$this->_table}.id FROM {$this->_table} INNER JOIN vs_visa_pax ON (vs_visa_pax.book_id = {$this->_table}.id) WHERE 1=1";
		if (!is_null($info)) {
			if (!empty($info->search_text)) {
				$info->search_text = strtoupper(trim($info->search_text));
				$ID = preg_replace("/[^0-9]/", "", $info->search_text);
				if ($this->email->valid_email($info->search_text)) {
					$sql .= " AND (UPPER(vs_visa_pax.fullname) LIKE '%{$info->search_text}%' OR UPPER(vs_visa_pax.passport) LIKE '%{$info->search_text}%' OR {$this->_table}.id = '{$ID}' OR {$this->_table}.order_ref = '{$ID}' OR {$this->_table}.promotion_code LIKE '%{$info->search_text}%' OR UPPER({$this->_table}.primary_email) LIKE '%{$info->search_text}%' OR UPPER({$this->_table}.secondary_email) LIKE '%{$info->search_text}%')";
				} else {
					$sql .= " AND (UPPER(vs_visa_pax.fullname) LIKE '%{$info->search_text}%' OR UPPER(vs_visa_pax.passport) LIKE '%{$info->search_text}%' OR {$this->_table}.id = '{$ID}' OR {$this->_table}.order_ref = '{$ID}' OR {$this->_table}.promotion_code LIKE '%{$info->search_text}%')";
				}
			}
			if (!empty($info->visa_type)) {
				$sql .= " AND {$this->_table}.visa_type = '{$info->visa_type}'";
			}
			if (!empty($info->visit_purpose)) {
				$sql .= " AND {$this->_table}.visit_purpose = '{$info->visit_purpose}'";
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
			if (!empty($info->promotion_code) && $info->promotion_code == "*") {
				$sql .= " AND {$this->_table}.promotion_code <> ''";
			}
		}
		if (!empty($status)) {
			$sql .= " AND {$this->_table}.status = '{$status}'";
		}
		if (!is_null($info) && !empty($info->sortby)) {
			$sql .= " ORDER BY {$this->_table}.{$info->sortby} {$info->orderby}";
		} else {
			$sql .= " ORDER BY {$this->_table}.booking_date DESC";
		}
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
	
	function payments($info=NULL, $limit=NULL, $offset=NULL)
	{
		$w1 = "";
		$w2 = "";
		$w3 = "";
		
		if (!is_null($info)) {
			if (!empty($info->fromdate))
			{
				$w1 .= " AND DATE(B.booking_date)>='{$info->fromdate}'";
				$w2 .= " AND DATE(P.payment_date)>='{$info->fromdate}'";
				$w3 .= " AND DATE(E.booking_date)>='{$info->fromdate}'";
			}
			if (!empty($info->todate))
			{
				$w1 .= " AND DATE(B.booking_date)<='{$info->todate}'";
				$w2 .= " AND DATE(P.payment_date)<='{$info->todate}'";
				$w3 .= " AND DATE(E.booking_date)<='{$info->todate}'";
			}
			if (!empty($info->from_paid_date))
			{
				$w1 .= " AND DATE(B.paid_date)>='{$info->from_paid_date}'";
				$w2 .= " AND DATE(P.payment_date)>='{$info->from_paid_date}'";
				$w3 .= " AND DATE(E.paid_date)>='{$info->from_paid_date}'";
			}
			if (!empty($info->to_paid_date))
			{
				$w1 .= " AND DATE(B.paid_date)<='{$info->to_paid_date}'";
				$w2 .= " AND DATE(P.payment_date)<='{$info->to_paid_date}'";
				$w3 .= " AND DATE(E.paid_date)<='{$info->to_paid_date}'";
			}
			if (!empty($info->search_text))
			{
				$info->search_text = strtoupper(trim($info->search_text));
				$w1 .= " AND (UPPER(B.primary_email) LIKE '%{$info->search_text}%' OR UPPER(B.secondary_email) LIKE '%{$info->search_text}%')";
				$w2 .= " AND (UPPER(P.primary_email) LIKE '%{$info->search_text}%' OR UPPER(P.secondary_email) LIKE '%{$info->search_text}%')";
				$w3 .= " AND (UPPER(E.primary_email) LIKE '%{$info->search_text}%')";
			}
			if (!empty($info->payment_method))
			{
				$w1 .= " AND B.payment_method='{$info->payment_method}'";
				$w2 .= " AND P.payment_method='{$info->payment_method}'";
				$w3 .= " AND E.payment_method='{$info->payment_method}'";
			}
			if (!empty($info->payment_status))
			{
				$info->payment_status = ((strtoupper($info->payment_status) != 'UNPAID') ? 1 : 0);
				$w1 .= " AND B.status='{$info->payment_status}'";
				$w2 .= " AND P.status='{$info->payment_status}'";
				$w3 .= " AND E.status='{$info->payment_status}'";
			}
		}
		
		$sql = "(SELECT B.id AS 'order_id',B.booking_type_id,B.platform AS 'platform', '' AS 'booking_id', B.booking_key AS 'key', '".BOOKING_PREFIX."' AS 'payment_type', B.user_id AS 'customer_id', B.contact_fullname AS 'fullname', B.primary_email, B.secondary_email, B.total_fee AS 'amount', B.payment_method, B.status, B.booking_date AS 'payment_date', B.capital, B.refund, B.client_ip, B.full_package, B.private_visa, B.fast_checkin, B.car_pickup, B.stamp_fee, B.group_size, B.rush_type, B.arrival_date, B.arrival_port, B.exit_port, B.visa_type, B.visit_purpose, B.exit_date,  B.contact_title, B.contact_phone, B.special_request, B.refund, B.capital, B.promotion_code FROM vs_visa_booking AS B WHERE 1=1 ".$w1." ORDER BY B.booking_date DESC)
				UNION
				(SELECT P.id AS 'order_id','','' AS 'platform', P.booking_id, P.payment_key AS 'key', '".BOOKING_PREFIX_PO."' AS 'payment_type', '' AS 'customer_id', P.fullname, P.primary_email, P.secondary_email, P.amount, P.payment_method, P.status, P.payment_date AS 'payment_date', P.capital AS 'capital', P.refund AS 'refund', P.client_ip, '' AS 'full_package', '' AS 'private_visa', '' AS 'fast_checkin', '' AS 'car_pickup', '' AS 'stamp_fee', '' AS 'group_size', '' AS 'rush_type', '' AS 'arrival_date', '' AS 'arrival_port', '' AS 'exit_port', '' AS 'visa_type', '' AS 'visit_purpose', '' AS 'exit_date', '' AS 'contact_title', '' AS 'contact_phone', '' AS 'special_request', '' AS 'refund', P.capital, '' AS 'promotion_code' FROM vs_payment AS P WHERE 1=1 ".$w2." ORDER BY P.payment_date DESC)
				UNION
				(SELECT E.id AS 'order_id','','' AS 'platform', '' AS 'booking_id', E.booking_key AS 'key', '".BOOKING_PREFIX_EX."' AS 'payment_type', '' AS 'customer_id', E.contact_name AS 'fullname', E.primary_email, '' AS 'secondary_email', E.total_fee AS 'amount', E.payment_method, E.status, E.booking_date AS 'payment_date', E.capital, E.refund, E.client_ip, '' AS 'full_package', '' AS 'private_visa', '' AS 'fast_checkin', '' AS 'car_pickup', '' AS 'stamp_fee', '' AS 'group_size', '' AS 'rush_type', '' AS 'arrival_date', '' AS 'arrival_port', '' AS 'exit_port', '' AS 'visa_type', '' AS 'visit_purpose', '' AS 'exit_date', '' AS 'contact_title', '' AS 'contact_phone', '' AS 'special_request', '' AS 'refund', E.capital, '' AS 'promotion_code' FROM vs_service_booking AS E WHERE 1=1 ".$w3." ORDER BY E.booking_date DESC)
				ORDER BY payment_date DESC";
		
		if (!is_null($limit)) {
			$sql .= " LIMIT {$limit}";
		}
		if (!is_null($offset)) {
			$sql .= " OFFSET {$offset}";
		}
		
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function total_payments($info=NULL)
	{
		$w1 = "";
		$w2 = "";
		$w3 = "";
		
		if (!is_null($info)) {
			if (!empty($info->fromdate))
			{
				$w1 .= " AND DATE(B.booking_date)>='{$info->fromdate}'";
				$w2 .= " AND DATE(P.payment_date)>='{$info->fromdate}'";
				$w3 .= " AND DATE(E.booking_date)>='{$info->fromdate}'";
			}
			if (!empty($info->todate))
			{
				$w1 .= " AND DATE(B.booking_date)<='{$info->todate}'";
				$w2 .= " AND DATE(P.payment_date)<='{$info->todate}'";
				$w3 .= " AND DATE(E.booking_date)<='{$info->todate}'";
			}
			if (!empty($info->search_text))
			{
				$info->search_text = strtoupper(trim($info->search_text));
				$w1 .= " AND (UPPER(B.primary_email) LIKE '%{$info->search_text}%' OR UPPER(B.secondary_email) LIKE '%{$info->search_text}%')";
				$w2 .= " AND (UPPER(P.primary_email) LIKE '%{$info->search_text}%' OR UPPER(P.secondary_email) LIKE '%{$info->search_text}%')";
				$w3 .= " AND (UPPER(E.primary_email) LIKE '%{$info->search_text}%')";
			}
			if (!empty($info->payment_method))
			{
				$w1 .= " AND B.payment_method='{$info->payment_method}'";
				$w2 .= " AND P.payment_method='{$info->payment_method}'";
				$w3 .= " AND E.payment_method='{$info->payment_method}'";
			}
		}
		
		$sql = "SELECT COUNT(*) AS 'total' FROM 
				((SELECT B.id AS 'order_id', B.booking_key AS 'key', 'Apply Visa' AS 'payment_type', B.user_id AS 'customer_id', B.contact_fullname AS 'fullname', B.primary_email, B.secondary_email, B.total_fee AS 'amount', B.payment_method, B.status, B.booking_date AS 'payment_date' FROM vs_visa_booking AS B WHERE 1=1 ".$w1." ORDER BY B.booking_date DESC)
				UNION
				(SELECT P.id AS 'order_id', P.payment_key AS 'key', 'Payment Online' AS 'payment_type', '' AS 'customer_id', P.fullname, P.primary_email, P.secondary_email, P.amount, P.payment_method, P.status, P.payment_date AS 'payment_date' FROM vs_payment AS P WHERE 1=1 ".$w2." ORDER BY P.payment_date DESC)
				ORDER BY payment_date DESC) AS payment";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->total;
		}
		
		return 0;
	}
	
	function all_booking_success($info=NULL, $limit=NULL, $offset=NULL)
	{
		$w1 = " AND (B.status=1 OR B.other_payment=1) AND B.booking_status NOT IN (3,4)";
		$w2 = " AND P.status=1";
		$w3 = " AND (E.status=1 OR E.other_payment=1) AND E.booking_status NOT IN (3,4)";
		
		if (!is_null($info)) {
			if (!empty($info->fromdate))
			{
				$w1 .= " AND (B.paid_date)>='{$info->fromdate}'";
				$w2 .= " AND (P.paid_date)>='{$info->fromdate}'";
				$w3 .= " AND (E.paid_date)>='{$info->fromdate}'";
			}
			if (!empty($info->todate))
			{
				$w1 .= " AND (B.paid_date)<='{$info->todate}'";
				$w2 .= " AND (P.paid_date)<='{$info->todate}'";
				$w3 .= " AND (E.paid_date)<='{$info->todate}'";
			}
		}
		
		$sql = "(SELECT B.id AS 'order_id', B.booking_type_id, '".BOOKING_PREFIX."' AS 'booking_type', '' AS 'fullname', B.primary_email, B.total_fee AS 'amount', B.payment_method, B.status, B.paid_date, B.rush_type, B.arrival_date, B.arrival_port,B.exit_port , B.visa_type, B.fast_checkin, B.car_pickup, B.car_type, B.seats, B.flight_number, B.arrival_time, B.private_visa, B.full_package, B.promotion_code AS 'promotion_code' FROM vs_visa_booking AS B WHERE 1=1 ".$w1." ORDER BY B.paid_date ASC)
				UNION
				(SELECT P.id AS 'order_id', '', '".BOOKING_PREFIX_PO."' AS 'booking_type', P.fullname, P.primary_email, P.amount, P.payment_method, P.status, P.paid_date, '' AS 'rush_type', '' AS 'arrival_date', '' AS 'arrival_port','', '' AS 'visa_type', '' AS 'fast_checkin', '' AS 'car_pickup', '' AS 'car_type', '' AS 'seats', '' AS 'flight_number', '' AS 'arrival_time', '' AS 'private_visa', '' AS 'full_package', '' AS 'promotion_code' FROM vs_payment AS P WHERE 1=1 ".$w2." ORDER BY P.paid_date ASC)
				UNION
				(SELECT E.id AS 'order_id', '', '".BOOKING_PREFIX_EX."' AS 'booking_type', E.contact_name AS 'fullname', E.primary_email, E.total_fee AS 'amount', E.payment_method, E.status, E.paid_date, '' AS 'rush_type', E.arrival_date, E.arrival_port,'', '' AS 'visa_type', E.fast_checkin, E.car_pickup, E.car_type, E.seats, E.flight_number, '' AS 'arrival_time', '' AS 'private_visa', '' AS 'full_package', '' AS 'promotion_code' FROM vs_service_booking AS E WHERE 1=1 ".$w3." ORDER BY E.paid_date ASC)
				ORDER BY paid_date ASC";
		
		if (!is_null($limit)) {
			$sql .= " LIMIT {$limit}";
		}
		if (!is_null($offset)) {
			$sql .= " OFFSET {$offset}";
		}
		
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function book_by_user($user_id=NULL)
	{
		$sql   = "SELECT *, {$this->_table}.id AS 'book_id' FROM {$this->_table} WHERE 1 = 1";
		if (!is_null($user_id)) {
			$sql .= " AND {$this->_table}.user_id = '{$user_id}'";
		}
		$sql .= " ORDER BY {$this->_table}.booking_date DESC";
		
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function book_by_email($email)
	{
		$sql   = "SELECT * FROM {$this->_table} WHERE primary_email = '{$email}' OR secondary_email = '{$email}'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return null;
	}
	
	function sum_succed_booking($user_id=NULL)
	{
		if (!empty($user_id)) {
			$sql   = "SELECT COUNT(*) AS 'total' FROM {$this->_table} WHERE status = '1' AND user_id = '{$user_id}'";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				$row = $query->row();
				return $row->total;
			}
		}
		return 0;
	}
	
	function booking_travelers($booking_id=NULL)
	{
		$sql   = "SELECT * FROM vs_visa_pax WHERE 1 = 1";
		if (!is_null($booking_id)) {
			if (is_array($booking_id)) {
				$sql .= " AND book_id IN (".implode(",", $booking_id).")";
			} else {
				$sql .= " AND book_id = '{$booking_id}'";
			}
		}
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function add_traveller($data)
	{
		return $this->db->insert("vs_visa_pax", $data);
	}
	
	function update_traveller($data, $where)
	{
		return $this->db->update("vs_visa_pax", $data, $where);
	}
	
	function delete_traveller($where)
	{
		return $this->db->delete("vs_visa_pax", $where);
	}
	public function export_csv($filename,$info){
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename .= '.csv';
		$arr = array();
		$sql = "SELECT DISTINCT primary_email as Email FROM {$this->_table} WHERE 1";
		if (!is_null($info)) {
			foreach ($info as $key => $value) {
				if ($key == 'fromdate') {
					$sql .= " AND DATE(booking_date) >= '{$value}'";
				} elseif ($key == 'todate') {
					$sql .= " AND DATE(booking_date) <= '{$value}'";
				} elseif ($key == 'arrival_date') {
					$sql .= " AND DATE(arrival_date) >= '{$value}'";
				} else if ($key == 'from_arrival') {
					$sql .= " AND DATE(arrival_date) >= '{$value}'";
				} elseif ($key == 'to_arrival') {
					$sql .= " AND DATE(arrival_date) <= '{$value}'";
				} else {
					if ($key == 'status' && $value == 2){
						$sql .= " AND {$key} = '1'";
					} else {
						$sql .= " AND {$key} = '{$value}'";
					}
				}
			}
		}
		// $sql .= " ORDER BY arrival_date DESC";
		$result = $this->db->query($sql);
		$data = $this->dbutil->csv_from_result($result,$delimiter,$newline);
		force_download($filename, $data);
	}
	function get_visa_bookings($info=NULL, $limit=NULL, $offset=NULL, $status=NULL)
	{
		$sql = "SELECT {$this->_table}.*, {$this->_table}.flight_number as vb_flight_number, vs_visa_pax.*, vs_visa_pax.id as pax_id, vs_country.id as nation_id, vs_country.type as nation_type, vs_arrival_port.id as airport_id FROM {$this->_table} INNER JOIN vs_visa_pax ON (vs_visa_pax.book_id = {$this->_table}.id) INNER JOIN vs_country ON (vs_visa_pax.nationality = vs_country.name) INNER JOIN vs_arrival_port ON (vs_arrival_port.short_name = {$this->_table}.arrival_port) WHERE 1=1";
		if (!is_null($info)) {
			if (!empty($info->id)) {
				$sql .= " AND {$this->_table}.id = '{$info->id}'";
			}
			if (!empty($info->fromdate)) {
				$sql .= " AND {$this->_table}.paid_date >= '{$info->fromdate}'";
			}
			if (!empty($info->todate)) {
				$sql .= " AND {$this->_table}.paid_date <= '{$info->todate}'";
			}
			if (!empty($info->agents_id)) {
				$sql .= " AND vs_visa_pax.agents_id = '{$info->agents_id}'";
			}
			if (!empty($info->agents_fc_id)) {
				$sql .= " AND vs_visa_pax.agents_fc_id = '{$info->agents_fc_id}'";
			}
			if (!empty($info->send_approved)) {
				$sql .= " AND vs_visa_pax.send_approved = '{$info->send_approved}'";
			}
			if (!empty($info->send_pickup)) {
				$sql .= " AND vs_visa_pax.send_pickup = '{$info->send_pickup}'";
			}
			if (!empty($info->visit_purpose)) {
				$sql .= " AND {$this->_table}.visit_purpose = '{$info->visit_purpose}'";
			}
			if (!empty($info->from_arrival_date)) {
				$sql .= " AND {$this->_table}.arrival_date >= '{$info->from_arrival_date}'";
			}
			if (!empty($info->to_arrival_date)) {
				$sql .= " AND {$this->_table}.arrival_date <= '{$info->to_arrival_date}'";
			}
			if (!empty($info->send_urgent)) {
				$sql .= " AND vs_visa_pax.send_urgent = '{$info->send_urgent}'";
			}
			if (!empty($info->from_send_approved_date)) {
				$sql .= " AND vs_visa_pax.send_approved_date >= '{$info->from_send_approved_date}'";
			}
			if (!empty($info->to_send_approved_date)) {
				$sql .= " AND vs_visa_pax.send_approved_date <= '{$info->to_send_approved_date}'";
			}
			if (!empty($info->status)) {
				$sql .= " AND ({$this->_table}.status = '{$info->status}' OR {$this->_table}.other_payment = '{$info->status}')";
			}
		}
		if (!is_null($info) && !empty($info->sortby)) {
			$sql .= " ORDER BY {$this->_table}.{$info->sortby} {$info->orderby}";
		} else {
			$sql .= " ORDER BY {$this->_table}.booking_date DESC";
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
	function send_mail_review($info=NULL, $limit=NULL, $offset=NULL)
	{
		$sql  = "SELECT DISTINCT {$this->_table}.*, U.user_registered FROM {$this->_table} INNER JOIN vs_users AS U ON (U.id = {$this->_table}.user_id) WHERE 1=1";
		if (!is_null($info)) {
			if (!empty($info->arrival_date)) {
				$sql .= " AND DATE({$this->_table}.arrival_date) = '{$info->arrival_date}'";
			}
		}

		$sql .= " AND {$this->_table}.fast_checkin = '0' AND {$this->_table}.car_pickup = '0' AND {$this->_table}.full_package = '0' AND {$this->_table}.status = '1'";

		if (!is_null($info) && !empty($info->sortby)) {
			$sql .= " ORDER BY {$this->_table}.{$info->sortby} {$info->orderby}";
		} else {
			$sql .= " ORDER BY {$this->_table}.booking_date DESC";
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
}
?>
