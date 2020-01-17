<?
class M_user extends M_db
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = "vs_users";
	}
	
	function user($info=null, $active=NULL, $provider="immi")
	{
		if (!is_null($info)) {
			$info->username = addslashes(trim($info->username));
			$info->password = addslashes(trim($info->password));
			
			if (empty($info->username) || empty($info->password)) {
				return null;
			}
			
			$sql  = " SELECT * FROM {$this->_table} WHERE 1 = 1";
			$sql .= " AND LOWER(user_login) = '".strtolower($info->username)."'";
			$sql .= " AND user_pass = '".md5($info->password)."'";
			
			if (!empty($active)) {
				$sql .= " AND active = '{$active}'";
			}
			if (!empty($provider)) {
				$sql .= " AND provider = '{$provider}'";
			}
			
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				return $query->row();
			}
		}
		
		return null;
	}
	
	public function users($info=null, $active=null, $limit=null, $offset=null)
	{
		$sql = "SELECT * FROM {$this->_table} WHERE 1 = 1";
		if (!is_null($info)) {
			if (!empty($info->user_type)) {
				$sql .= " AND user_type = '{$info->user_type}'";
			}
			if (!empty($info->user_types)) {
				$sql .= " AND user_type IN (".implode(",", $info->user_types).")";
			}
			if (!empty($info->level)) { 
				$sql .= " AND amount > {$info->level[0]}";
				if (!empty($info->level[1])) {
					$sql .= " AND amount < {$info->level[1]}";
				}
			}
			if (!empty($info->search_text)) {
				$info->search_text = strtoupper(trim($info->search_text));
				$sql .= " AND (UPPER(user_email) = '{$info->search_text}' OR UPPER(user_fullname) LIKE '%{$info->search_text}%')";
			}
		}
		if (!is_null($active)) {
			$sql .= " AND active = '{$active}'";
		}
		
		$sql .= " ORDER BY user_registered DESC";
		
		if (!is_null($limit)) {
			$sql .= " LIMIT {$limit}";
		}
		if (!is_null($limit)) {
			$sql .= " OFFSET {$offset}";
		}
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	public function count($info=null, $active=null)
	{
		$sql = "SELECT COUNT(*) AS 'total' FROM {$this->_table} WHERE 1 = 1";
		if (!is_null($info)) {
			if (!empty($info->user_type)) {
				$sql .= " AND user_type = '{$info->user_type}'";
			}
			if (!empty($info->user_types)) {
				$sql .= " AND user_type IN (".implode(",", $info->user_types).")";
			}
			if (!empty($info->level)) { 
				$sql .= " AND amount > {$info->level[0]}";
				if (!empty($info->level[1])) {
					$sql .= " AND amount < {$info->level[1]}";
				}
			}
			if (!empty($info->search_text)) {
				$info->search_text = strtoupper(trim($info->search_text));
				$sql .= " AND (UPPER(user_email) = '{$info->search_text}' OR UPPER(user_fullname) LIKE '%{$info->search_text}%')";
			}
		}
		if (!is_null($active)) {
			$sql .= " AND active = '{$active}'";
		}
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->row()->total;
		}
		
		return 0;
	}
	
	public function is_user_exist($email, $active=null, $provider="immi")
	{
		$email = addslashes(trim($email));
		
		$sql = "SELECT * FROM {$this->_table} WHERE 1 = 1";
		if (!is_null($email)) {
			$sql .= " AND LOWER(user_login) = '".strtolower($email)."'";
		}
		if (!is_null($active)) {
			$sql .= " AND active = '{$active}'";
		}
		if (!empty($provider)) {
			$sql .= " AND provider = '{$provider}'";
		}
		
		$query = $this->db->query($sql);
		return ($query->num_rows() > 0);
	}
	
	public function get_user_by_email($email, $active=null, $provider="immi")
	{
		$email = addslashes(trim($email));
		
		if (empty($email)) {
			return null;
		}
		
		$sql = "SELECT * FROM {$this->_table} WHERE LOWER(user_login) = '".strtolower($email)."'";
		
		if (!is_null($active)) {
			$sql .= " AND active = '{$active}'";
		}
		if (!empty($provider)) {
			$sql .= " AND provider = '{$provider}'";
		}
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		
		return null;
	}
	
	public function get_social_user($uid=null, $provider=null, $email=null, $active=null)
	{
		if (empty($provider)) {
			return null;
		}
		
		$email = addslashes(trim($email));
		
		if (empty($email)) {
			return null;
		}
		
		$sql = "SELECT * FROM {$this->_table} WHERE 1 = 1";
		if (!empty($uid)) {
			$sql .= " AND uid = '{$uid}'";
		}
		
		if (!is_null($email)) {
			$sql .= " AND LOWER(user_email) = '".strtolower($email)."'";
		}
		
		$sql .= " AND provider = '{$provider}'";
		
		if (!is_null($active)) {
			$sql .= " AND active = '{$active}'";
		}
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		
		return null;
	}
	
	public function login($email, $password, $user_type="user")
	{
		$email    = addslashes(trim($email));
		$password = addslashes(trim($password));
		
		if (empty($email) || empty($password)) {
			return false;
		}
		
		$email    = strtoupper($email);
		$password = md5($password);
		$sql      = "SELECT * FROM {$this->_table} WHERE UPPER(user_login)='{$email}' AND user_pass='{$password}' AND active=1";
		$query    = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$user = $query->row();
			$this->session->set_userdata($user_type, $user);
			if ($user_type == "admin") {
				$this->session->set_userdata("agent_id", ADMIN_AGENT_ID);
			}
			return true;
		}
		
		return false;
	}
	
	function cp_login($id, $user_type="user")
	{
		if (empty($id)) {
			return false;
		}
		
		$sql      = "SELECT * FROM {$this->_table} WHERE id='{$id}'";
		$query    = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			$user = $query->row();
			$this->session->set_userdata($user_type, $user);
			if ($user_type == "admin") {
				$this->session->set_userdata("agent_id", ADMIN_AGENT_ID);
			}
			return true;
		}
		
		return false;
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
	}
	
	public function last_activity($user_id)
	{
		$data = array("last_activity" => date($this->config->item("log_date_format")));
		$where = array("id" => $user_id);
		$this->db->update($this->_table, $data, $where);
	}
}
?>
