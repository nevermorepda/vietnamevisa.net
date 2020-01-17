<?php
class M_check_step extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_check_step";
	}
	
	function items($info=NULL, $limit=NULL, $offset=NULL, $orderby=NULL, $sortby=NULL)
	{
		$sql   = "SELECT * FROM {$this->_table} WHERE 1=1";
		if (!is_null($info)) {
			if (!empty($info->email)) {
				$sql .= " AND email = '{$info->email}'";
			}
			if (!empty($info->created_date)) {
				$sql .= " AND DATE({$this->_table}.created_date) = '{$info->created_date}'";
			}
			if (!empty($info->fromdate) && !empty($info->todate)) {
				$sql .= " AND DATE({$this->_table}.created_date) >= '{$info->fromdate}' AND DATE({$this->_table}.created_date) <= '{$info->todate}'";
			}
			if (!empty($info->null_step3)) {
				$sql .= " AND step3 <> '{$info->null_step3}'";
			}
			if (!empty($info->status)) {
				$sql .= " AND status = '{$info->status}'";
			}
			if (!empty($info->type)) {
				$sql .= " AND type = '{$info->type}'";
			}
			if (!empty($info->booking_id)) {
				$sql .= " AND booking_id = '{$info->booking_id}'";
			}
			if (!empty($info->check_po)) {
				$sql .= " AND check_po = '{$info->check_po}'";
			}
			if (!empty($info->search_text)) {
				$sql .= " AND email LIKE '%{$info->search_text}%'";
			}
			if (!empty($info->send_mail)) {
				$sql .= " AND send_mail = '{$info->send_mail}'";
			}
		}
		if (!is_null($orderby) && !is_null($sortby)) {
			$sql .= " ORDER BY {$orderby} {$sortby}, created_date DESC";
		}
		else {
			$sql .= " ORDER BY created_date DESC";
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
	public function export_csv($filename,$str_select,$info) {
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename .= '.csv';
		$arr = array();
		$sql = "SELECT DISTINCT email as Email, {$str_select} FROM {$this->_table} WHERE 1";
		if (!is_null($info)) {
			foreach ($info as $key => $value) {
				if ($key == 'fromdate') {
					$sql .= " AND DATE(created_date) >= '{$value}'";
				} elseif ($key == 'todate') {
					$sql .= " AND DATE(created_date) <= '{$value}'";
				} else {
					$sql .= " AND {$key} = '{$value}'";
				}
			}
		}
		$result = $this->db->query($sql);
		$data = $this->dbutil->csv_from_result($result,$delimiter,$newline);
		force_download($filename, $data);
	}
}
?>