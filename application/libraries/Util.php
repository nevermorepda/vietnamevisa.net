<?php
class Util {

	function Util()
	{
		$this->ci = &get_instance();
	}
	
	function value($input, $default=NULL)
	{
		if (is_null($input)) {
			return $default;
		}
		if ($input == 0) {
			return $input;
		}
		return !empty($input) ? $input : $default;
	}
	
	function realIP()
	{
		// Check ip from share internet
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		// Check ip is pass from proxy
		else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		// Check X4b proxy
		else if (isset($_SERVER['HTTP_X_REAL_IP'])) {
			$ip = $_SERVER['HTTP_X_REAL_IP'];
		}
		// Natural
		else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		
		$pieces = explode(",", $ip);
		$ip = trim($pieces[0]);
		if (!empty($pieces[1])) {
			$ip = trim($pieces[1]);
		}
		
		return $ip;
	}
	
	function slug($str)
	{
	    $str = trim(mb_strtolower($str));
		$str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
		$str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
		$str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
		$str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
		$str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
		$str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
		$str = preg_replace('/(đ)/', 'd', $str);
		$str = preg_replace('/[^a-z0-9-\s]/', '-', $str);
		$str = preg_replace('/([\s]+)/', '-', $str);
		$str = '-'.$str.'-';
		$str = str_replace('--', '-', $str);
		$str = substr($str, 1, -1);
		return $str;
	}

	function createSecurityCode()
	{
		if ($this->ci->session->userdata("security_code")) {
			return $this->ci->session->userdata("security_code");
		} else {
			$code = strtoupper(substr(md5(date("Y-m-d H:i:s")."h-o-l-y-s-p-i-r-i-t"), 0, 6));
			$this->ci->session->set_userdata("security_code", $code);
			return $code;
		}
	}

	function getSecurityCode()
	{
		if ($this->ci->session->userdata("security_code")) {
			return $this->ci->session->userdata("security_code");
		}
		return "";
	}

	function autoBlockIP()
	{
		$ip			= $this->realIP();
		$url 		= $_SERVER['REQUEST_URI'];
		$fromdate	= date('Y-m-d H:i:s', strtotime("-5 seconds"));
		$todate		= date('Y-m-d H:i:s');

		$num_of_request = 0;
		$sql  = " SELECT COUNT(*) AS 'total' FROM vs_user_online WHERE 1 = 1 ";
		$sql .= " AND ip = '{$ip}'";
		$sql .= " AND created_date >= '{$fromdate}'";
		$sql .= " AND created_date <= '{$todate}'";
		$sql .= " AND url = '{$url}' ";

		$query = $this->ci->db->query($sql);
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$num_of_request = $row->total;
		}

		if ($num_of_request > 10) {
			$this->blockIP($ip);
			$where = array('ip' => $ip);
			$this->ci->db->delete("vs_user_online", $where);
		}
	}

	function blockIP($ip)
	{
		$deny = "\r\ndeny from ".$ip;
		$file = fopen(".htaccess", "a");
		fwrite($file, $deny);
		fclose($file);
	}
	
	function order_ref($ref_id, $length=16)
	{
		$prefix = date('ymd04');
		$str = '0000000000000000'.$ref_id;
		$str = $prefix.substr($str, -($length - strlen($prefix)));
	    //return $str;
		return date('ymd').strtotime(date('His'));
	}

	function requireUserLogin($login_page=NULL)
	{
		if (!$this->checkUserLogin()){
			if (!is_null($login_page)) {
				$this->ci->session->set_userdata("return_url", current_url());
				redirect($login_page);
			} else {
				redirect(BASE_URL);
			}
			die();
		}
	}
	
	function checkUserLogin()
	{
		if ($this->ci->session->userdata("user")) {
			return true;
		}
		return false;
	}
	
	function requireAdminLogin($login_page=null)
	{
		if ($this->ci->session->userdata("agent_id") != ADMIN_AGENT_ID
			|| !$this->ci->session->userdata("admin")
			|| (!in_array($this->ci->session->userdata("admin")->user_type, array(USR_ADMIN, USR_SUPPER_ADMIN)))) {
			$this->ci->session->set_userdata("return_url", current_url());
			if (!is_null($login_page)) {
				redirect($login_page);
			} else {
				redirect(ADMIN_URL);
			}
		}
	}
	
	function requireSupperAdminLogin($login_page=null)
	{
		if ($this->ci->session->userdata("agent_id") != ADMIN_AGENT_ID
			|| !$this->ci->session->userdata("admin")
			|| ($this->ci->session->userdata("admin")->user_type != USR_SUPPER_ADMIN)) {
			$this->ci->session->set_userdata("return_url", current_url());
			if (!is_null($login_page)) {
				redirect($login_page);
			} else {
				redirect(ADMIN_URL);
			}
		}
	}

	function pagination($base_url, $total_rows=1, $per_page=10)
	{
		$this->ci->load->library('pagination');
		if (preg_match('/&page=.*/', $base_url)) {
			$base_url = preg_replace('/&page=.*/', NULL, $base_url);
		}
		
		$config = array();
		$config['base_url']				= $base_url;
		$config['total_rows']			= $total_rows;
		$config['per_page']				= $per_page;
		$config['page_query_string']	= TRUE;
		$config['query_string_segment']	= "page";
		$config['use_page_numbers']		= TRUE;
		
		$config['full_tag_open'] 		= '<ul class="pagination">';
		$config['full_tag_close'] 		= '</ul>';
		
		$config['first_link']			= 'First';
		$config['first_tag_open'] 		= '<li>';
		$config['first_tag_close'] 		= '</li>';
		
		$config['prev_link']			= '&lt;';
		$config['prev_tag_open'] 		= '<li>';
		$config['prev_tag_close'] 		= '</li>';
		
		$config['cur_tag_open'] 		= '<li class="active"><a href="#">';
		$config['cur_tag_close'] 		= '<span class="sr-only">(current)</span></a></li>';
		
		$config['num_tag_open'] 		= '<li>';
		$config['num_tag_close'] 		= '</li>';
		
		$config['next_link']			= '&gt;';
		$config['next_tag_open'] 		= '<li>';
		$config['next_tag_close'] 		= '</li>';
		
		$config['last_link']			= 'Last';
		$config['last_tag_open'] 		= '<li>';
		$config['last_tag_close'] 		= '</li>';
		
		$this->ci->pagination->initialize($config);
		
		return $this->ci->pagination->create_links();
	}

	function timesince($tsmp)
	{
		$diffu = array('seconds' => 2, 'minutes' => 60, 'hours' => 3600, 'days' => 86400, 'months' => 2592000,  'years' =>  31104000);
		$diff = time() - strtotime($tsmp);
		$dt = '0 seconds ago';
		foreach($diffu as $u => $n){ if($diff>$n) {$dt = floor($diff/$n).' '.$u.' ago';} }
		return $dt;
	}

	function checkPageError($val)
	{
		if (empty($val)) {
			redirect("error404");
		}
	}

	function getLang()
	{
		if ($this->ci->session->userdata("lang")) {
			return $this->ci->session->userdata("lang");
		}
		return "EN";
	}

	function setLang($lang)
	{
		$this->ci->session->set_userdata("lang", $lang);
	}

	function getMetaTitle($item = NULL)
	{
		if (!is_null($item)) {
			if (!empty($item->meta_title)) {
				return $item->meta_title;
			} else if (!empty($item->title)) {
				return $item->title;
			}
		}
		return "Vietnam Visa On Arrival";
	}

	function vip($level)
	{
		$data = new stdClass();

		switch ($level)
		{
			case 1: 	$data->level	= $level;
						$data->name		= "Silver";
						$data->discount	= 10;
						break;
			case 2: 	$data->level	= $level;
						$data->name		= "Gold";
						$data->discount	= 15;
						break;
			case 3: 	$data->level	= $level;
						$data->name		= "Diamon";
						$data->discount	= 20;
						break;
			default:	$data->level	= $level;
						$data->name		= "Normal";
						$data->discount	= 0;
						break;
		}

		return $data;
	}
	
	function random_password()
	{
		$pattern = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*";
		$strlen = rand(6,10);
		$password = "";
		for ($i = 1; $i <= $strlen; $i++) {
			$password .= substr($pattern,rand(0,strlen($pattern)),1);
		}
		return $password;
	}
	
	function detect_rush_visa($date, $type, $purpose)
	{
		if ($type == 'ev1ms') {
			return $this->detect_rush_evisa($date, $type, $purpose);
		}
		
		$t = 2;
		
		$current_date = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
		$arrival_date = mktime(0, 0, 0, date("m", strtotime($date)), date("d", strtotime($date)), date("Y", strtotime($date)));
		
		$_3ms = $this->ci->m_visa_type->load("3ms");
		$_3mm = $this->ci->m_visa_type->load("3mm");
		
		// 3m tourist
		if (in_array($type, array($_3ms->code, $_3mm->code, $_3ms->name, $_3mm->name)) && stripos(strtolower($purpose), "business") === false) {
		// if (in_array($type, array($_3ms->code, $_3mm->code, $_3ms->name, $_3mm->name))) {
			$t += 2;
		}
		else if (stripos(strtolower($purpose), "business") !== false) {
			$t += 2;
		}
		
		$special_date = new stdClass();
		$special_date->fr = $current_date;
		$special_date->to = $current_date;
		
		$holiday_info = new stdClass();
		$holiday_info->current_date = date("Y-m-d");
		$holidays = $this->ci->m_holiday->items($holiday_info, 1);
		if (!empty($holidays)) {
			$holiday = array_shift($holidays);
			$special_date->fr = strtotime($holiday->start_date);
			$special_date->to = strtotime($holiday->end_date);
		}
		else {
			// Look for next event
			for ($i=1; $i<=$t; $i++) {
				$holiday_info->current_date = date("Y-m-d", strtotime("+{$i} day"));
				$holidays = $this->ci->m_holiday->items($holiday_info, 1);
				if (!empty($holidays)) {
					$holiday = array_shift($holidays);
					$special_date->fr = strtotime($holiday->start_date);
					$special_date->to = strtotime($holiday->end_date);
					// Ignore first day
					if ($special_date->fr < $special_date->to) {
						$special_date->fr = strtotime("+1 day", strtotime($holiday->start_date));
					}
					break;
				}
			}
		}
		
		for ($i=1; $i<=$t; $i++) {
			$approve_date = mktime(0, 0, 0, date("m", strtotime("+{$i} days")), date("d", strtotime("+{$i} days")), date("Y", strtotime("+{$i} days")));
			if ((date("w", $approve_date) == 6) || (date("w", $approve_date) == 0)
				|| ($approve_date >= $special_date->fr && $approve_date < $special_date->to)) {
				$t++;
			}
		}
		
		$approve_date = mktime(0, 0, 0, date("m", strtotime("+{$t} days")), date("d", strtotime("+{$t} days")), date("Y", strtotime("+{$t} days")));
		
		// 3m tourist
		if (in_array($type, array($_3ms->code, $_3mm->code, $_3ms->name, $_3mm->name)) && stripos(strtolower($purpose), "business") === false) {
			if ($arrival_date < $approve_date) {
				//return -1;
			}
		}
		
		$rush = 0;
		
		if ($arrival_date < $current_date) {
			$rush = -1;
		}
		else if ($arrival_date < $approve_date) {
			$current_time = mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"));
			$special_time = mktime(14, 30, 0, date("m", $special_date->fr), date("d", $special_date->fr), date("Y", $special_date->fr));
			if (((date("H") >= 15) && ($arrival_date == $current_date))
				|| ((date("w") == 5 && (date("H") >= 15 || (date("H") == 14 && date("i") >= 30)) || date("w") == 6 || date("w") == 0) && ($arrival_date < strtotime("next monday")))
				|| (($current_time >= $special_time && $current_time < $special_date->to) && ($arrival_date >= $special_date->fr && $arrival_date < $special_date->to))) {
				$rush = 3;
			} else {
				$rush = 2;
			}
		}
		
		return $rush;
	}
	public function upload_file($file_path=null,$name=null,$file_deleted=null,$allow_type='rar|zip|pdf|doc|docx|PDF|DOC|DOCX|xls|xlsx|csv',$file_name)
	{
		$this->config = array(
			'upload_path'	=> $file_path,
			'upload_url'	=> base_url().str_replace('./','',$file_path),
			'allowed_types'	=> $allow_type,
			'overwrite'		=> TRUE,
			'max_size'		=> 8000,
			);
		$this->ci->load->library("upload", $this->config);
		if (!empty($name)){
			if($this->ci->upload->do_upload($name)){
				
				if (file_exists($file_deleted)){
					unlink($file_deleted);
				}
				$file_data = $this->ci->upload->data();
				$temp = explode('.',$_FILES[$name]["name"]);
				rename($file_data['full_path'],$file_data['file_path'].$this->slug($temp[0]).'.'.$temp[1]);
				//$this->watermark_main($file_path.'/'.$file_name);
			}
			return $file_data;
		}else{
			return false;
		}
	}
	function getVisaType2String($visa_type)
	{
		$str = "";
		switch ($visa_type) {
			case "1mm":
			case "1 month multiple":
				$str = "1 month multiple";
				break;
			case "3ms":
			case "3 months single":
				$str = "3 months single";
				break;
			case "3mm":
			case "3 months multiple":
				$str = "3 months multiple";
				break;
			case "6mm":
			case "6 months multiple":
				$str = "6 months multiple";
				break;
			case "1ym":
			case "1 year multiple":
				$str = "1 year multiple";
				break;
			default:
				$str = "1 month single";
				break;
		}
		return $str;
	}
	
	function getVisaString2Type($str)
	{
		$type = "";
		switch ($str) {
			case "1mm":
			case "1 month multiple":
				$type = "1mm";
				break;
			case "3ms":
			case "3 months single":
				$type = "3ms";
				break;
			case "3mm":
			case "3 months multiple":
				$type = "3mm";
				break;
			case "6mm":
			case "6 months multiple":
				$type = "6mm";
				break;
			case "1ym":
			case "1 year multiple":
				$type = "1ym";
				break;
			default:
				$type = "1ms";
				break;
		}
		return $type;
	}
	function sort_date_file($fileList) {
		$count = count($fileList);
		for ($i = 0; $i < ($count - 1); $i++)
		{
			$idate = date ("Y-m-d H:i:s", filectime($fileList[$i]));
			for ($j = $i + 1; $j < $count; $j++)
			{
				$jdate = date ("Y-m-d H:i:s", filectime($fileList[$j]));
				if ($idate < $jdate)
				{
					$tmp = $fileList[$j];
					$fileList[$j] = $fileList[$i];
					$fileList[$i] = $tmp;
				}
			}
		}
		return $fileList;
	}
	function block_ip() {
		$this->ci->load->model('m_setting');
		$ip_list = explode(',', str_replace(' ','',$this->ci->m_setting->load(1)->ban_ip));
		if (in_array($this->realIP(),$ip_list))
		redirect(BASE_URL.'/destroy.html');
	}
	function fc($full_package, $fast_checkin, $car_pickup,$type=1) {
		if ($type == 1) {
			if (!empty($full_package) && !empty($car_pickup)) {
				$fc = 5;
				$note_fc = 'Đón + Phí + Xe';
			} elseif (!empty($full_package)) {
				$fc = 4;
				$note_fc = 'Đón + Phí';
			} elseif (!empty($fast_checkin) && !empty($car_pickup)) {
				$fc = 3;
				$note_fc = 'Đón + Xe';
			} elseif (!empty($car_pickup)) {
				$fc = 2;
				$note_fc = 'Xe';
			} elseif (!empty($fast_checkin)) {
				$fc = 1;
				$note_fc = 'Đón';
			} else {
				$fc = 0;
				$note_fc = '';
			}
		} else {
			if (!empty($fast_checkin) && !empty($car_pickup)) {
				$fc = 3;
				$note_fc = 'Đón + Xe';
			} elseif (!empty($car_pickup)) {
				$fc = 2;
				$note_fc = 'Xe';
			} elseif (!empty($fast_checkin)) {
				$fc = 1;
				$note_fc = 'Đón';
			} else {
				$fc = 0;
				$note_fc = '';
			}
		}
		return array($fc,$note_fc);
	}
	function ex_fc($full_package, $fast_checkin, $car_pickup) {
		if (($full_package == 0) && ($fast_checkin == 0) && ($car_pickup == 1)) {
			$fc = 1;
			$note_fc = 'Xe';
		} elseif (($full_package == 0) && ($fast_checkin == 1) && ($car_pickup == 0)) {
			$fc = 2;
			$note_fc = 'Đón';
		} elseif (($full_package == 0) && ($fast_checkin == 2) && ($car_pickup == 0)) {
			$fc = 3;
			$note_fc = 'Đón Vip';
		} elseif (($full_package == 0) && ($fast_checkin == 1) && ($car_pickup == 1)) {
			$fc = 4;
			$note_fc = 'Đón + Xe';
		} elseif (($full_package == 0) && ($fast_checkin == 2) && ($car_pickup == 1)) {
			$fc = 5;
			$note_fc = 'Đón Vip + Xe';
		} elseif (($full_package == 1) && ($fast_checkin == 0) && ($car_pickup == 0)) {
			$fc = 6;
			$note_fc = 'Đón + Phí';
		} elseif (($full_package == 2) && ($fast_checkin == 0) && ($car_pickup == 0)) {
			$fc = 7;
			$note_fc = 'Đón Vip + Phí';
		} elseif (($full_package == 1) && ($fast_checkin == 0) && ($car_pickup == 1)) {
			$fc = 8;
			$note_fc = 'Đón + Phí + Xe';
		} elseif (($full_package == 2) && ($fast_checkin == 0) && ($car_pickup == 1)) {
			$fc = 9;
			$note_fc = 'Đón Vip + Phí + Xe';
		}
		return array($fc,$note_fc); 
	}
	function note_fc($note_fc) {
		switch ($note_fc) {
			case 0:
				$note_fc = '';
				break;
			case 1:
				$note_fc = 'Đón';
				break;
			case 2:
				$note_fc = 'Xe';
				break;
			case 3:
				$note_fc = 'Đón + Xe';
				break;
			case 4:
				$note_fc = 'Đón + Phí';
				break;
			case 5:
				$note_fc = 'Đón + Phí + Xe';
				break;
		}
		return $note_fc;
	}
	function level_account($user_id=null){
		$level = '';
		if (empty($user_id)) {
			if (!empty($this->ci->session->userdata('user'))){
				$user_id = $this->ci->session->userdata('user')->id;
			}
		}

		if (!empty($user_id)) {
			$user = $this->ci->m_user->load($user_id);
			if (($user->amount >= 0) && ($user->amount < 100)) {
				$level = array(1,'Normal',0,$user->amount);
			} else if (($user->amount >= 100) && ($user->amount < 200)) {
				$level = array(2,'Silver',20,$user->amount);
			} else if (($user->amount >= 200) && ($user->amount < 500)) {
				$level = array(3,'Gold',30,$user->amount);
			} else if (($user->amount >= 500) && ($user->amount < 2000)) {
				$level = array(4,'Diamond',40,$user->amount);
			} else if ($user->amount >= 2000) {
				$level = array(5,'VIP',50,$user->amount);
			}
			return $level;
		} else {
			return null;
		}
	}
}
?>