<?php
class M_user_online extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_user_online";
	}
	
	function items($info=NULL, $limit=NULL, $offset=NULL)
	{
		$sql = "SELECT * FROM {$this->_table} WHERE 1 = 1";
		
		if (!is_null($info)) {
			if (!empty($info->fromdate)) {
				$sql .= " AND DATE(created_date)>='{$info->fromdate}'";
			}
			if (!empty($info->todate)) {
				$sql .= " AND DATE(created_date)<='{$info->todate}'";
			}
			if (!empty($info->text)) {
				$sql .= " AND (ip LIKE '%{$info->text}%' OR url LIKE '%{$info->text}%')";
			}
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
	
	function track_ip()
	{
		$request_uri = $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
		
		if (stripos($request_uri, "/template/") !== false
			|| stripos($request_uri, "/ajax") !== false
			|| stripos($request_uri, "/ip-tracking") !== false) {
			return;
		}
		
		if (strtolower($this->router->fetch_class()) == "syslog") {
			$user = $this->session->userdata("admin");
		}
		
		$usr_online = $this->session->userdata("user_online");
		
		// Close old page
		if (!empty($usr_online)) {
			$data = array(
				"open_time"		=> strtotime(date('Y-m-d H:i:s')) - strtotime($usr_online->created_date),
			);
			$where = array(
				"ip"			=> $usr_online->ip,
				"url"			=> $usr_online->url,
				"created_date"	=> $usr_online->created_date
			);
			$this->update($data, $where);
		}
		
		$usr_online = new stdClass();
		$usr_online->ip 			= $this->util->realIP();
		$usr_online->url 			= $request_uri;
		$usr_online->created_date 	= date($this->config->item("log_date_format"));
		
		$this->session->set_userdata("user_online", $usr_online);
		
		// Open new page
		$data = array(
			"user_id"		=> !empty($user->id) ? $user->id : 0,
			"ip"			=> $usr_online->ip,
			"url"			=> $usr_online->url,
			"created_date"	=> $usr_online->created_date
		);
		
		$this->add($data);
	}
	
	function delete_all()
	{
		return $this->db->empty_table($this->_table);
	}
}
?>