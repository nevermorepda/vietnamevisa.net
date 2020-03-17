<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Syslog extends CI_Controller {

	var $_breadcrumb = array();
	
	public function __construct()
	{
		parent::__construct();
		
		$method = $this->util->slug($this->router->fetch_method());
		
		if (!in_array($method, array("login", "logout"))) {
			$this->util->requireAdminLogin();
			$user = $this->session->userdata("admin");
			if (!$user->active) {
				$this->session->set_flashdata("error", "Your account is under review.");
				redirect(ADMIN_URL);
			}
			
			if (in_array($method, array("users", "payment-report", "passport-types", "visa-types", "visit-purposes", "arrival-ports", "page-meta-tags", "page-redirects", "settings", "history", "debt", "scheduler", "holiday"))) {
				$this->util->requireSupperAdminLogin();
			}
			
			if (substr($method, 0, 4) === "adm-") {
				$this->util->requireSupperAdminLogin();
			}
			
			$this->m_user->last_activity($user->id);
		}
		
		$this->m_user_online->track_ip();
		
		if (!empty($user)) {
			if ($user->user_type == USR_ADMIN) {
				if (!$this->check_schedule($user->id)) {
					//$this->session->set_flashdata("error", "Sorry, access denied.");
					//redirect(ADMIN_URL);
				}
			}
		}
		
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Syslog" => site_url($this->util->slug($this->router->fetch_class()))));
	}
	
	public function index()
	{
		$this->payment_report();
		$view_data = array();
		$view_data["breadcrumb"] = $this->_breadcrumb;
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/index", $view_data, true);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	
	//------------------------------------------------------------------------------
	// Login
	//------------------------------------------------------------------------------
	
	public function login()
	{
		if (!empty($_POST))
		{
			$agent_id = trim($this->util->value($this->input->post("agent_id"), ""));
			$email = trim($this->util->value($this->input->post("email"), ""));
			$password = trim($this->util->value($this->input->post("password"), ""));
			
			if (strtoupper($agent_id) == ADMIN_AGENT_ID) {
				if ($this->m_user->login($email, $password, "admin") == false) {
					$this->session->set_flashdata("error", "Invalid email or password.");
					redirect(site_url("syslog/login"), "back");
				} else {
					redirect(site_url("syslog"));
				}
			} else {
				$this->session->set_flashdata("error", "Invalid Agent ID.");
				redirect(site_url("syslog/login"), "back");
			}
		}
		
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Login" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$view_data = array();
		$view_data["breadcrumb"] = $this->_breadcrumb;
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/login", $view_data, true);
		$this->load->view("layout/admin/login", $tmpl_content);
	}

	public function logout()
	{
		$this->m_user->logout();
		redirect(site_url("syslog"));
	}
	
	//------------------------------------------------------------------------------
	// Sitemap
	//------------------------------------------------------------------------------
	
	public function create_sitemap()
	{
		$url80 = array();
		$url64 = array();
		
		$xmlstr  = '<?xml version="1.0" encoding="UTF-8"?>';
		$xmlstr .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">';
		
		$url80[] = BASE_URL;
		$url80[] = site_url("processing");
		$url80[] = site_url("apply-visa");
		$url80[] = site_url("visa-fee");
		$url80[] = site_url("services");
		$url80[] = site_url("faqs");
		//$url80[] = site_url("answers");
		$url80[] = site_url("vietnam-embassies");
		$url80[] = site_url("news");
		$url80[] = site_url("news/travel");
		$url80[] = site_url("member");
		$url80[] = site_url("check-visa-status");
		$url80[] = site_url("download-visa-application-forms");
		$url80[] = site_url("contact");
		$url80[] = site_url("about-us");
		$url80[] = site_url("why-us");
		$url80[] = site_url("terms-and-conditions");
		$url80[] = site_url("policy");
		$url80[] = site_url("payment-instruction");
		$url80[] = site_url("vietnam-visa-tips");
		$url80[] = site_url("visa-requirements");
		$url80[] = site_url("vietnam-e-visa");
		
		$nations = $this->m_country->items();
		$contents = $this->m_content->items();
		$legal_category = $this->m_category->load("legal");
		$news_category = $this->m_category->load("news");
		$travel_category = $this->m_category->load("travel-news");
		$service_category = $this->m_category->load("extra-service");
		
		foreach ($nations as $nation) {
			if ($nation->active) {
				$url64[] = site_url("visa-requirements/{$nation->alias}");
				$url64[] = site_url("vietnam-embassies/view/{$nation->alias}");
				//$url64[] = site_url("vietnam-visa-tips/view/{$nation->alias}");
				$url64[] = site_url("visa-fee/{$nation->alias}");
			}
		}
		
		foreach ($contents as $content) {
			if ($content->active) {
				if ($content->catid == $legal_category->id) {
					$url64[] = site_url("legal/{$content->alias}");
				}
				else if ($content->catid == $news_category->id) {
					$url64[] = site_url("news/view/{$content->alias}");
				}
				else if ($content->catid == $travel_category->id) {
					$url64[] = site_url("news/travel/view/{$content->alias}");
				}
				else if ($content->catid == $service_category->id) {
					$url64[] = site_url("services/view/{$content->alias}");
				}
			}
		}
		
		$contents = $this->m_tips->items();
		foreach ($contents as $content) {
			$url64[] = site_url("vietnam-visa-tips/view/{$content->alias}");
		}
		
		$info = new stdClass();
		$info->topLevel = 1;
		$contents = $this->m_question->items($info, 1);
		foreach ($contents as $content) {
			//$url64[] = site_url("answers/view/{$content->alias}");
		}
		
		foreach ($url80 as $url) {
			$xmlstr .= '<url>';
			$xmlstr .= '<loc>'.$url.'</loc>';
			$xmlstr .= '<changefreq>daily</changefreq>';
			$xmlstr .= '<priority>0.80</priority>';
			$xmlstr .= '</url>';
		}
		
		foreach ($url64 as $url) {
			$xmlstr .= '<url>';
			$xmlstr .= '<loc>'.$url.'</loc>';
			$xmlstr .= '<changefreq>daily</changefreq>';
			$xmlstr .= '<priority>0.64</priority>';
			$xmlstr .= '</url>';
		}
		
		$xmlstr .= '</urlset>';
		
		chmod('sitemap.xml', 0777);
		
		$fp = fopen('sitemap.xml', 'w');
		fwrite($fp, $xmlstr);
		fclose($fp);
		
		chmod('sitemap.xml', 0664);
	}
	
	//------------------------------------------------------------------------------
	// Settings
	//------------------------------------------------------------------------------
	
	public function settings($action=null)
	{
		$settings = $this->m_setting->items();
		
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "save") {
				$company_name		= $this->util->value($this->input->post("company_name"), "");
				$company_address	= $this->util->value($this->input->post("company_address"), "");
				$company_email		= $this->util->value($this->input->post("company_email"), "");
				$company_hotline_vn	= $this->util->value($this->input->post("company_hotline_vn"), "");
				$company_hotline_au	= $this->util->value($this->input->post("company_hotline_au"), "");
				$company_hotline_us	= $this->util->value($this->input->post("company_hotline_us"), "");
				$company_tollfree	= $this->util->value($this->input->post("company_tollfree"), "");
				$facebook_url		= $this->util->value($this->input->post("facebook_url"), "");
				$googleplus_url		= $this->util->value($this->input->post("googleplus_url"), "");
				$twitter_url		= $this->util->value($this->input->post("twitter_url"), "");
				$youtube_url		= $this->util->value($this->input->post("youtube_url"), "");
				$ban_ip			= $this->util->value($this->input->post("ban_ip"), "");
				$ban_name			= $this->util->value($this->input->post("ban_name"), "");
				$ban_email			= $this->util->value($this->input->post("ban_email"), "");
				$ban_passport		= $this->util->value($this->input->post("ban_passport"), "");
				
				$data = array (
					"company_name"			=> $company_name,
					"company_address"		=> $company_address,
					"company_email"			=> $company_email,
					"company_hotline_vn"	=> $company_hotline_vn,
					"company_hotline_au"	=> $company_hotline_au,
					"company_hotline_us"	=> $company_hotline_us,
					"company_tollfree"		=> $company_tollfree,
					"facebook_url"			=> $facebook_url,
					"googleplus_url"		=> $googleplus_url,
					"twitter_url"			=> $twitter_url,
					"youtube_url"			=> $youtube_url,
					"ban_ip"				=> $ban_ip,
					"ban_name"				=> $ban_name,
					"ban_email"				=> $ban_email,
					"ban_passport"			=> $ban_passport,
				);
				
				if (!is_null($settings) && sizeof($settings)) {
					$setting = array_shift($settings);
					$where = array("id" => $setting->id);
					$this->m_setting->update($data, $where);
				} else {
					$this->m_setting->add($data);
				}
			}
			
			redirect(site_url("syslog/settings"));
		}
		
		$action = !is_null($action) ? $action : "index";
		
		if (!is_null($settings) && sizeof($settings)) {
			$setting = array_shift($settings);
		} else {
			$setting = $this->m_setting->instance();
		}
		
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Settings" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$view_data = array();
		$view_data["setting"] = $setting;
		$view_data["breadcrumb"] = $this->_breadcrumb;
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/settings/{$action}", $view_data, true);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	
	//------------------------------------------------------------------------------
	// Users
	//------------------------------------------------------------------------------
	
	public function users($action=null, $id=null)
	{
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task) && $task != "search") {
			$ids = $this->util->value($this->input->post("cid"), array());
			foreach ($ids as $id) {
				$user = $this->m_user->load($id);
				if (($user->user_type == USR_SUPPER_ADMIN && $this->session->userdata("admin")->user_type != USR_SUPPER_ADMIN)
				|| ($user->user_type == USR_ADMIN && $this->session->userdata("admin")->user_type == USR_ADMIN && $this->session->userdata("admin")->id != $user->id)) {
					$this->session->set_flashdata("error", "Sorry, you don't have permission to edit the selected users.");
					redirect(site_url("syslog/users"));
				} else {
					if ($task == "publish") {
						$data = array("active" => 1);
						$where = array("id" => $id);
						$this->m_user->update($data, $where);
					}
					else if ($task == "unpublish") {
						$data = array("active" => 0);
						$where = array("id" => $id);
						$this->m_user->update($data, $where);
					}
					else if ($task == "delete") {
						$where = array("id" => $id);
						$this->m_user->delete($where);
					}
				}
			}
			redirect(site_url("syslog/users"));
		}
		
		if ($action == "signin") {
			$user = $this->m_user->load($id);
			if (($user->user_type == USR_SUPPER_ADMIN && $this->session->userdata("admin")->user_type != USR_SUPPER_ADMIN)
			|| ($user->user_type == USR_ADMIN && $this->session->userdata("admin")->user_type == USR_ADMIN && $this->session->userdata("admin")->id != $user->id)) {
				$this->session->set_flashdata("error", "Sorry, you don't have permission to edit the selected users.");
				redirect(site_url("syslog/users"));
			} else {
				$this->m_user->cp_login($id);
				redirect(site_url("member"));
			}
		}
		else {
			$search_text = $this->util->value($this->input->post("search_text"), "");
			$info = new stdClass();
			if (!empty($search_text)) {
				$info->search_text = $search_text;
			}
			$level = '';
			if (!empty($_GET['level'])) {
				if ($_GET['level'] == 'silver') {
					$info->level = array(99, 200);
					$level = '?level=silver&';
				} else if ($_GET['level'] == 'gold') {
					$info->level = array(199, 500);
					$level = '?level=gold&';
				} else if ($_GET['level'] == 'diamond') {
					$info->level = array(499, 2000);
					$level = '?level=diamond&';
				} else if ($_GET['level'] == 'vip') {
					$info->level = array(1999);
					$level = '?level=vip&';
				}
			}

			
			$page = (!empty($_GET["page"]) ? max($_GET["page"], 1) : 1);
			$pagination = $this->util->pagination(site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}"). "?$_SERVER[QUERY_STRING]", $this->m_user->count($info), ADMIN_ROW_PER_PAGE);
			
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("Users" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
			
			$users	= $this->m_user->users($info, null, ADMIN_ROW_PER_PAGE, ($page - 1) * ADMIN_ROW_PER_PAGE);

			$view_data = array();
			$view_data["breadcrumb"] 	= $this->_breadcrumb;
			$view_data["users"]			= $users;
			$view_data["search_text"]	= $search_text;
			$view_data["page"]			= $page;
			$view_data["pagination"]	= $pagination;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/account/index", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
	}
	
	//------------------------------------------------------------------------------
	// Content
	//------------------------------------------------------------------------------
	
	public function content_categories($action=null, $id=null)
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Content Categories" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "save") {
				$name			= $this->util->value($this->input->post("name"), "");
				$alias			= $this->util->value($this->input->post("alias"), "");
				$parent_id		= $this->util->value($this->input->post("parent_id"), 0);
				$active			= $this->util->value($this->input->post("active"), 1);
				
				if (empty($alias)) {
					$alias = $this->util->slug($name);
				}
				
				$data = array (
					"name"		=> $name,
					"alias"		=> $alias,
					"parent_id"	=> $parent_id,
					"active"	=> $active
				);
				
				if ($action == "add") {
					$this->m_category->add($data);
				}
				else if ($action == "edit") {
					$where = array("id" => $id);
					$this->m_category->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/content-categories"));
			}
			else if ($task == "cancel") {
				redirect(site_url("syslog/content-categories"));
			}
			else if ($task == "orderup") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$this->m_category->order_up($id);
				}
				redirect(site_url("syslog/content-categories"));
			}
			else if ($task == "orderdown") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$this->m_category->order_down($id);
				}
				redirect(site_url("syslog/content-categories"));
			}
			else if ($task == "saveorder") {
				$order = $this->util->value($this->input->post("order"), array());
				$cids  = $this->util->value($this->input->post("cids"), array());
				for ($i=0; $i<sizeof($cids); $i++) {
					$data = array("order_num" => $order[$i]);
					$where = array("id" => $cids[$i]);
					$this->m_category->update($data, $where);
				}
				redirect(site_url("syslog/content-categories"));
			}
			else if ($task == "publish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 1);
					$where = array("id" => $id);
					$this->m_category->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/content-categories"));
			}
			else if ($task == "unpublish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 0);
					$where = array("id" => $id);
					$this->m_category->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/content-categories"));
			}
			else if ($task == "delete") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$where = array("id" => $id);
					$this->m_category->delete($where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/content-categories"));
			}
		}
		
		if ($action == "add") {
			$item = $this->m_category->instance();
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("Add Content Category" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/content/category/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else if ($action == "edit") {
			$item = $this->m_category->load($id);
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$item->name}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}/{$id}")));
		
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/content/category/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else {
			$category_info = new stdClass();
			$category_info->parent_id = 0;
			$categories = $this->m_category->items($category_info);
			
			$view_data = array();
			$view_data["breadcrumb"] 	= $this->_breadcrumb;
			$view_data["items"]			= $categories;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/content/category/index", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
	}
	
	public function content($category_id, $action=null, $id=null)
	{
		$category = $this->m_category->load($category_id);
		
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Content Categories" => site_url("{$this->util->slug($this->router->fetch_class())}/content-categories")));
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$category->name}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$category_id}")));
		
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "save") {
				$title			= $this->util->value($this->input->post("title"), "");
				$alias			= $this->util->value($this->input->post("alias"), "");
				$catid			= $this->util->value($this->input->post("catid"), 0);
				$icon 			= !empty($_FILES['icon']['name']) ? explode('.',$_FILES['icon']['name']) : $this->m_content->load($id)->icon;
				$thumbnail 		= !empty($_FILES['thumbnail']['name']) ? explode('.',$_FILES['thumbnail']['name']) : $this->m_content->load($id)->thumbnail;
				$meta_title		= $this->util->value($this->input->post("meta_title"), "");
				$meta_key		= $this->util->value($this->input->post("meta_key"), "");
				$meta_desc		= $this->util->value($this->input->post("meta_desc"), "");
				$summary		= $this->util->value($this->input->post("summary"), "");
				$content		= $this->util->value($this->input->post("content"), "");
				//$order_num		= $this->util->value($this->input->post("order_num"), 1);
				$active			= $this->util->value($this->input->post("active"), 1);
				
				if (empty($alias)) {
					$alias = $this->util->slug($title);
				}
				
				$data = array (
					"title"			=> $title,
					"alias"			=> $alias,
					"catid"			=> $catid,
					"icon"			=> $icon,
					"thumbnail"		=> $thumbnail,
					"meta_title"	=> $meta_title,
					"meta_key"		=> $meta_key,
					"meta_desc"		=> $meta_desc,
					"summary"		=> $summary,
					"content"		=> $content,
					//"order_num"		=> $order_num,
					"active"		=> $active
				);
				if (!empty($_FILES['icon']['name'])){
					$data['icon'] = "/files/upload/content/{$id}/{$this->util->slug($icon[0])}.{$icon[1]}";
				}
				if (!empty($_FILES['thumbnail']['name'])){
					$data['thumbnail'] = "/files/upload/content/{$id}/{$this->util->slug($thumbnail[0])}.{$thumbnail[1]}";
				}
				$file_deleted = '';
				
				if ($action == "add") {
					$file_deleted = "./files/upload/content/{$id}/{$this->m_content->load($id)->name}";
					$this->m_content->add($data);
				}
				else if ($action == "edit") {
					$where = array("id" => $id);
					$this->m_content->update($data, $where);
				}
				$path = "./files/upload/content/{$id}";
				if (!file_exists($path)) {
					mkdir($path, 0755, true);
				}
				$allow_type = 'JPG|PNG|jpg|jpeg|png';
				$this->util->upload_file($path,'icon',$file_deleted,$allow_type,$this->util->slug($icon[0]).'.'.$icon[1]);
				$this->util->upload_file($path,'thumbnail',$file_deleted,$allow_type,$this->util->slug($thumbnail[0]).'.'.$thumbnail[1]);
				$this->create_sitemap();
				redirect(site_url("syslog/content/{$category->alias}"));
			}
			else if ($task == "cancel") {
				redirect(site_url("syslog/content/{$category->alias}"));
			}
			else if ($task == "orderup") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$this->m_content->order_up($id);
				}
				redirect(site_url("syslog/content/{$category->alias}"));
			}
			else if ($task == "orderdown") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$this->m_content->order_down($id);
				}
				redirect(site_url("syslog/content/{$category->alias}"));
			}
			else if ($task == "saveorder") {
				$order = $this->util->value($this->input->post("order"), array());
				$cids  = $this->util->value($this->input->post("cids"), array());
				for ($i=0; $i<sizeof($cids); $i++) {
					$data = array("order_num" => $order[$i]);
					$where = array("id" => $cids[$i]);
					$this->m_content->update($data, $where);
				}
				redirect(site_url("syslog/content/{$category->alias}"));
			}
			else if ($task == "publish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 1);
					$where = array("id" => $id);
					$this->m_content->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/content/{$category->alias}"));
			}
			else if ($task == "unpublish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 0);
					$where = array("id" => $id);
					$this->m_content->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/content/{$category->alias}"));
			}
			else if ($task == "delete") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$where = array("id" => $id);
					$this->m_content->delete($where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/content/{$category->alias}"));
			}
		}
		
		if ($action == "add") {
			$item = $this->m_content->instance();
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("Add Content" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$category_id}/{$action}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			$view_data["category"] = $category;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/content/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else if ($action == "edit") {
			$item = $this->m_content->load($id);
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$item->title}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$category_id}/{$action}/{$id}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			$view_data["category"] = $category;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/content/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else {
			$info = new stdClass();
			$info->catid = $category->id;
			
			$view_data = array();
			$view_data["breadcrumb"]	= $this->_breadcrumb;
			$view_data["items"]			= $this->m_content->items($info, null, null, null);
			$view_data["category"]		= $category;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/content/index", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
	}
	
	//------------------------------------------------------------------------------
	// Q&A
	//------------------------------------------------------------------------------
	
	public function questions($action=null, $id=null)
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Q&A" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "save") {
				$title		= $this->util->value($this->input->post("title"), "");
				$author		= $this->util->value($this->input->post("author"), "");
				$email		= $this->util->value($this->input->post("email"), "");
				$content	= $this->util->value($this->input->post("content"), "");
				$active		= $this->util->value($this->input->post("active"), 1);
				
				$id = (empty($id) ? $this->m_question->get_next_value() : $id);
				$alias = $this->util->slug($title)."-".$id;
				
				if ($action == "answer") {
					$data = array (
						"parent_id"	=> $id,
						"author"	=> "Vietnam Evisa Support",
						"email"		=> MAIL_INFO,
						"content"	=> $content
					);
					
					$this->m_question->add($data);
					
					$question = $this->m_question->load($id);
					
					$mail_data = array(
						"fullname"	=> $question->author,
						"question"	=> $question,
						"answer"	=> $content,
					);
					
					$mail_tpl = $this->mail_tpl->question_reply($mail_data);
					
					// Mail to author
					$mail = array(
	            		"subject"		=> $question->title,
						"from_sender"	=> MAIL_INFO,
	            		"name_sender"	=> SITE_NAME,
						"to_receiver"   => $question->email,
						"message"       => $mail_tpl
					);
					$this->mail->config($mail);
					$this->mail->sendmail();
				}
				else if ($action == "edit") {
					$data = array (
						"title"		=> $title,
						"alias"		=> $alias,
						"author"	=> $author,
						"email"		=> $email,
						"content"	=> $content,
						"active"	=> $active
					);
					
					$where = array("id" => $id);
					$this->m_question->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/questions"));
			}
			else if ($task == "cancel") {
				redirect(site_url("syslog/questions"));
			}
			else if ($task == "orderup") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$this->m_question->order_up($id);
				}
				redirect(site_url("syslog/questions"));
			}
			else if ($task == "orderdown") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$this->m_question->order_down($id);
				}
				redirect(site_url("syslog/questions"));
			}
			else if ($task == "saveorder") {
				$order = $this->util->value($this->input->post("order"), array());
				$cids  = $this->util->value($this->input->post("cids"), array());
				for ($i=0; $i<sizeof($cids); $i++) {
					$data = array("order_num" => $order[$i]);
					$where = array("id" => $cids[$i]);
					$this->m_question->update($data, $where);
				}
				redirect(site_url("syslog/questions"));
			}
			else if ($task == "publish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 1);
					$where = array("id" => $id);
					$this->m_question->update($data, $where);
				}
				redirect(site_url("syslog/questions"));
			}
			else if ($task == "unpublish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 0);
					$where = array("id" => $id);
					$this->m_question->update($data, $where);
				}
				redirect(site_url("syslog/questions"));
			}
			else if ($task == "delete") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$where = array("id" => $id);
					$this->m_question->delete($where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/questions"));
			}
		}
		
		if ($action == "answer") {
			$item = $this->m_question->load($id);
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("Add Answer" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}/{$id}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/question/answer", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else if ($action == "edit") {
			$item = $this->m_question->load($id);
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$item->title}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}/{$id}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/question/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else {
			$info = new stdClass();
			$info->topLevel = TRUE;
			$info->orderby = "updated_date";
			$info->sortby = "DESC";
			
			$page = (!empty($_GET["page"]) ? max($_GET["page"], 1) : 1);
			$pagination = $this->util->pagination(site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}"), $this->m_question->count($info, null, $info->orderby, $info->sortby), ADMIN_ROW_PER_PAGE);
			
			$view_data = array();
			$view_data["breadcrumb"] 	= $this->_breadcrumb;
			$view_data["items"]			= $this->m_question->items($info, null, ADMIN_ROW_PER_PAGE, ($page - 1) * ADMIN_ROW_PER_PAGE, $info->orderby, $info->sortby);
			$view_data["page"]			= $page;
			$view_data["pagination"]	= $pagination;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/question/index", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
	}
	//------------------------------------------------------------------------------
	// Tour
	//------------------------------------------------------------------------------
	public function tour_categories($action=null, $id=null)
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Content Categories" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "save") {
				$name			= $this->util->value($this->input->post("name"), "");
				$alias			= $this->util->value($this->input->post("alias"), "");
				$description	= $this->util->value($this->input->post("description"), "");
				$active			= $this->util->value($this->input->post("active"), 1);
				
				if (empty($alias)) {
					$alias = $this->util->slug($name);
				}
				
				$data = array (
					"name"			=> $name,
					"alias"			=> $alias,
					"description"	=> $description,
					"active"		=> $active
				);
				
				if ($action == "add") {
					$this->m_category_tour->add($data);
				}
				else if ($action == "edit") {
					$where = array("id" => $id);
					$this->m_category_tour->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/tour-categories"));
			}
			else if ($task == "cancel") {
				redirect(site_url("syslog/tour-categories"));
			}
			else if ($task == "orderup") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$this->m_category_tour->order_up($id);
				}
				redirect(site_url("syslog/tour-categories"));
			}
			else if ($task == "orderdown") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$this->m_category_tour->order_down($id);
				}
				redirect(site_url("syslog/tour-categories"));
			}
			else if ($task == "saveorder") {
				$order = $this->util->value($this->input->post("order"), array());
				$cids  = $this->util->value($this->input->post("cids"), array());
				for ($i=0; $i<sizeof($cids); $i++) {
					$data = array("order_num" => $order[$i]);
					$where = array("id" => $cids[$i]);
					$this->m_category_tour->update($data, $where);
				}
				redirect(site_url("syslog/tour-categories"));
			}
			else if ($task == "publish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 1);
					$where = array("id" => $id);
					$this->m_category_tour->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/tour-categories"));
			}
			else if ($task == "unpublish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 0);
					$where = array("id" => $id);
					$this->m_category_tour->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/tour-categories"));
			}
			else if ($task == "delete") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$where = array("id" => $id);
					$this->m_category_tour->delete($where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/tour-categories"));
			}
		}
		
		if ($action == "add") {
			$item = $this->m_category_tour->instance();
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("Add Tour Category" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/tour/category/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else if ($action == "edit") {
			$item = $this->m_category_tour->load($id);
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$item->name}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}/{$id}")));
		
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/tour/category/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else {
			$categories = $this->m_category_tour->items();
			
			$view_data = array();
			$view_data["breadcrumb"] 	= $this->_breadcrumb;
			$view_data["items"]			= $categories;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/tour/category/index", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
	}

	public function tour_rates($tour_id, $action=null, $id=null)
	{
		$expl_type_passenger = 1;
		if (!empty($id)) {
			$id = base64_decode($id);
			$explode = explode("_",$id);
			$expl_type_passenger = $explode[1];
			$expl_name = $explode[0];
		}
		
		$tour = $this->m_tour->load($tour_id);
		$category = $this->m_category_tour->load($tour->catid);
		
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Tour Categories" => site_url("{$this->util->slug($this->router->fetch_class())}/tour-categories")));
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$category->name}" => site_url("{$this->util->slug($this->router->fetch_class())}/tour/{$category->id}")));
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Tour Rates" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$tour_id}")));
		
		$task = $this->util->value($this->input->post("task"));
		if (!empty($task)) {
			if ($task == "save") {
				$name = $this->util->value($this->input->post("name"));
				$type_passenger = $this->util->value($this->input->post("type_passenger"),1);
				
				$is_supplement_updated = FALSE;
				if ($action == "edit" && !empty($id)) {
					$info = new stdClass();
					$info->tour_id = $tour_id;
					$info->type_passenger = $expl_type_passenger;// 1: Adults; 2:Children;3 : Infants
					$info->name = str_replace("%20", " ", $expl_name);
					$items = $this->m_tour_rate->items($info);
					
					// gia ri da ton tai trong db
					foreach ($items as $item) {
						$group_size = 1;
						if ($item->single_supplement==0) {
							$group_size = $this->util->value($this->input->post("group_size_".$item->id), 1);
							$price = $this->util->value($this->input->post("price_".$item->id), 0);
						} else {
							$price = $this->util->value($this->input->post("single_supplement"), 0);
							$is_supplement_updated = TRUE;
						}
						// empty($group_size) tuong ung la $group_size==0
						if (empty($group_size) || strlen($price) == 0 || $group_size <=0 || $price < 0) {
							$this->m_tour_rate->delete(array ("id" => $item->id));
						}
						else {
							$data = array(
								'name' => $name,
								'group_size' => trim($group_size),
								'price' => trim($price),
								'type_passenger' => $type_passenger
							);
							$where = array ("id" => $item->id);
							$this->m_tour_rate->update($data, $where);
						}
					}
				}
				
				// them moi vao db neu chua ton tai
				for ($i=0; $i<12; $i++) {
					$group_size = $this->util->value($this->input->post("group_size_-".$i), 1);
					$price = $this->util->value($this->input->post("price_-".$i), -1);
					
					if (!empty($group_size) && strlen($price) > 0 && $group_size > 0 && $price >= 0) {
						$data = array(
							'name' => $name,
							'tour_id' => $tour_id,
							'group_size' => trim($group_size),
							'price' => trim($price),
							'type_passenger' => $type_passenger
						);
						$this->m_tour_rate->add($data);
					}
				}
				
				// them moi db neu ton tai gia tri single_supplement co price>0
				if (!$is_supplement_updated) {
					$group_size = 1;
					$price = $this->util->value($this->input->post("single_supplement"), 0);
						
					if (strlen($price) > 0 && $price > 0) {
						$data = array(
							'name' => $name,
							'tour_id' => $tour_id,
							'group_size' => trim($group_size),
							'single_supplement' => 1,
							'price' => trim($price),
							'type_passenger' => $type_passenger
						);
						$this->m_tour_rate->add($data);
					}
				}
				redirect(site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$tour_id}"));
			}
			else if ($task == "cancel") {
				redirect(site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$tour_id}"));
			}
		}
		
		if ($action == "add") {
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("Add Tour rates" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$tour_id}/{$action}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["tour"] = $tour;
			$view_data["type_passenger"] = $expl_type_passenger;

			$tmpl_content = array();
			$tmpl_content['content'] = $this->load->view("admin/tour/rates/edit", $view_data, TRUE);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else if ($action == "edit") {
			$info = new stdClass();
			$info->tour_id = $tour_id;
			$info->name = str_replace("%20", " ", $expl_name);
			$info->type_passenger = $expl_type_passenger;
			$items = $this->m_tour_rate->items($info);
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("Edit Tour rates" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$tour_id}/{$action}/{$id}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["items"] = $items;
			$view_data["type_passenger"] = $expl_type_passenger;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/tour/rates/edit", $view_data, TRUE);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else {
			$info = new stdClass();
			$info->tour_id = $tour_id;
			$items = $this->m_tour_rate->items($info);

			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["items"] = $items;
			$view_data["tour"] = $tour;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/tour/rates/index", $view_data, TRUE);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
	}

	public function tour_booking($action=NULL,$id=NULL)
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Tour booking" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));

		$task	= $this->util->value($this->input->post("task"), "");
		// if (!empty($task)) {
		// 	if ($task == "delete") {
		// 		$ids = $this->util->value($this->input->post("cid"), array());
		// 		foreach ($ids as $id) {
		// 			$where = array("id" => $id);
		// 			$this->m_tour->delete_booking($where);
		// 		}
		// 		$this->session->set_flashdata("success","You have successfully deleted.");
		// 	}
		// }
		// if ($action == "edit") {
		// 	$item = $this->m_tour->getBooking($id);
		// 	echo $this->load->view("admin/tours/booking/detail", array("item"=>$item), TRUE);
		// }
		// else {
			// $sortby  				= $this->util->value($this->input->post("sortby"), "booking_date");
			// $orderby 				= $this->util->value($this->input->post("orderby"), "DESC");
			// $original_search_text	= $this->util->value($this->input->post("search_text"), "");
			$fromdate				= $this->util->value($this->input->post("fromdate"), date("Y-m-d"));
			$todate					= $this->util->value($this->input->post("todate"), date("Y-m-d"));
			// $search_by				= $this->util->value($this->input->post("search_by"), "");
			// $search_text			= strtoupper(trim($original_search_text));
			// $search_text			= str_replace(array(BOOKING_TOUR_PREFIX), "", $search_text);

			// if (!empty($search_text)) {
			// 	$fromdate = "";
			// 	$todate = "";
			// }

			// if (!empty($fromdate)) {
			// 	$fromdate = date("Y-m-d", strtotime($fromdate));
			// }
			// if (!empty($todate)) {
			// 	$todate = date("Y-m-d", strtotime($todate));
			// }

			$info = new stdClass();
			// $info->search_text	= $search_text;
			$info->fromdate		= $fromdate;
			$info->todate		= $todate;
			// $info->sortby		= $sortby;
			// $info->orderby		= $orderby;
			// if (!empty($_GET['tour_id'])) {
			// 	$info->tour_id		= $_GET['tour_id'];
			// 	$info->departure_id	= $_GET['departure_id'];
			// }

			$total_items = $this->m_tour_booking->items($info,null,null);

			$page = (!empty($_GET["page"]) ? max($_GET["page"], 1) : 1);
			$offset = ($page - 1) * ADMIN_ROW_PER_PAGE;
			$pagination = $this->util->pagination(site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}"), sizeof($total_items), ADMIN_ROW_PER_PAGE);

			$view_data = array();
			// $view_data["task"]				= $task;
			// $view_data["sortby"]			= $sortby;
			// $view_data["orderby"]			= $orderby;
			// $view_data["search_text"]		= $original_search_text;
			// $view_data["edited_search_text"]= $search_text;
			$view_data["fromdate"]			= $fromdate;
			$view_data["todate"]			= $todate;
			$view_data["items"]				= $this->m_tour_booking->items($info, ADMIN_ROW_PER_PAGE, ($page - 1) * ADMIN_ROW_PER_PAGE);
			$view_data['total_items']		= $total_items;
			$view_data["breadcrumb"]		= $this->_breadcrumb;
			// $view_data["page"]				= $page;
			$view_data["pagination"]		= $pagination;

			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/report/tour_booking", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		// }
	}

	public function tour($categories_id,$action=null,$id=null) 
	{
		
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Tour" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "save") {
				$title			= $this->util->value($this->input->post("title"), "");
				$alias			= $this->util->value($this->input->post("alias"), "");
				$catid			= $this->util->value($this->input->post("catid"), 0);
				$price			= $this->util->value($this->input->post("price"), 0);
				$child_price	= $this->util->value($this->input->post("child_price"), 0);
				$infants_price	= $this->util->value($this->input->post("infants_price"), 0);
				$location		= $this->util->value($this->input->post("location"), "");
				$duration		= $this->util->value($this->input->post("duration"), "");
				$thumbnail 		= !empty($_FILES['thumbnail']['name']) ? explode('.',$_FILES['thumbnail']['name']) : $this->m_tour->load($id)->thumbnail;
				$highlights		= $this->util->value($this->input->post("highlights"), "");
				$itinerary		= $this->util->value($this->input->post("itinerary"), "");
				$description	= $this->util->value($this->input->post("description"), "");
				$inclusion		= $this->util->value($this->input->post("inclusion"), "");
				$exclusion		= $this->util->value($this->input->post("exclusion"), "");
				$meta_title		= $this->util->value($this->input->post("meta_title"), "");
				$meta_key		= $this->util->value($this->input->post("meta_key"), "");
				$meta_desc		= $this->util->value($this->input->post("meta_desc"), "");
				
				//$order_num		= $this->util->value($this->input->post("order_num"), 1);
				$active			= $this->util->value($this->input->post("active"), 1);
				
				if (empty($alias)) {
					$alias = $this->util->slug($title);
				}
				
				$data = array (
					"title"			=> $title,
					"alias"			=> $alias,
					"price"			=> $price,
					"child_price"	=> $child_price,
					"infants_price"	=> $infants_price,
					"catid"			=> $catid,
					"location"		=> $location,
					"duration"		=> $duration,
					"thumbnail"		=> $thumbnail,
					"highlights"	=> $highlights,
					"itinerary"		=> $itinerary,
					"description"	=> $description,
					"inclusion"		=> $inclusion,
					"exclusion"		=> $exclusion,
					"meta_title"	=> $meta_title,
					"meta_key"		=> $meta_key,
					"meta_desc"		=> $meta_desc,

					//"order_num"		=> $order_num,
					"active"		=> $active
				);
				if (!empty($_FILES['thumbnail']['name'])){
					$data['thumbnail'] = "/files/upload/content/{$id}/{$this->util->slug($thumbnail[0])}.{$thumbnail[1]}";
				}
				$file_deleted = '';
				
				if ($action == "add") {
					$file_deleted = "./files/upload/content/{$id}/{$this->m_tour->load($id)->name}";
					$this->m_tour->add($data);
				}
				else if ($action == "edit") {
					$where = array("id" => $id);
					$this->m_tour->update($data, $where);
				}
				$path = "./files/upload/content/{$id}";
				if (!file_exists($path)) {
					mkdir($path, 0755, true);
				}
				$allow_type = 'JPG|PNG|jpg|jpeg|png';
				$this->util->upload_file($path,'thumbnail',$file_deleted,$allow_type,$this->util->slug($thumbnail[0]).'.'.$thumbnail[1]);
				$this->create_sitemap();
				redirect(site_url("syslog/tour/{$categories_id}"));
			}
			else if ($task == "cancel") {
				redirect(site_url("syslog/tour/{$categories_id}"));
			}
			else if ($task == "orderup") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$this->m_tour->order_up($id);
				}
				redirect(site_url("syslog/tour/{$categories_id}"));
			}
			else if ($task == "orderdown") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$this->m_tour->order_down($id);
				}
				redirect(site_url("syslog/tour/{$categories_id}"));
			}
			else if ($task == "saveorder") {
				$order = $this->util->value($this->input->post("order"), array());
				$cids  = $this->util->value($this->input->post("cids"), array());
				for ($i=0; $i<sizeof($cids); $i++) {
					$data = array("order_num" => $order[$i]);
					$where = array("id" => $cids[$i]);
					$this->m_tour->update($data, $where);
				}
				redirect(site_url("syslog/tour/{$categories_id}"));
			}
			else if ($task == "publish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 1);
					$where = array("id" => $id);
					$this->m_tour->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/tour/{$categories_id}"));
			}
			else if ($task == "unpublish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 0);
					$where = array("id" => $id);
					$this->m_tour->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/tour/{$categories_id}"));
			}
			else if ($task == "delete") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$where = array("id" => $id);
					$this->m_tour->delete($where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/tour/{$categories_id}"));
			}
		}
		if ($action == "add") {
			$item = $this->m_tour->instance();
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("Add" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));

			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/tour/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else if ($action == "edit") {
			$item = $this->m_tour->load($id);
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("Edit" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$item->title}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}/{$id}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/tour/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else {
			$info = new stdClass();
			$info->catid = $categories_id;

			$view_data = array();
			$view_data["breadcrumb"]	= $this->_breadcrumb;
			$view_data["items"]			= $this->m_tour->items($info, null, null, null);
			$view_data["categories_id"]	= $categories_id;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/tour/index", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
	}
	
	//------------------------------------------------------------------------------
	// Reviews
	//------------------------------------------------------------------------------
	
	public function reviews($action=null, $id=null)
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Reviews" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "publish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 1);
					$where = array("id" => $id);
					$this->m_review->update($data, $where);
				}
				//$this->create_sitemap();
				redirect(site_url("syslog/reviews"));
			}
			else if ($task == "unpublish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 0);
					$where = array("id" => $id);
					$this->m_review->update($data, $where);
				}
				//$this->create_sitemap();
				redirect(site_url("syslog/reviews"));
			}
			else if ($task == "delete") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$where = array("id" => $id);
					$this->m_review->delete($where);
				}
				//$this->create_sitemap();
				redirect(site_url("syslog/reviews"));
			}
		}
		
		$page = (!empty($_GET["page"]) ? max($_GET["page"], 1) : 1);
		$pagination = $this->util->pagination(site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}"), $this->m_review->count(), ADMIN_ROW_PER_PAGE);
		
		$view_data = array();
		$view_data["breadcrumb"] 	= $this->_breadcrumb;
		$view_data["items"]			= $this->m_review->items(null, null, ADMIN_ROW_PER_PAGE, ($page - 1) * ADMIN_ROW_PER_PAGE);
		$view_data["page"]			= $page;
		$view_data["pagination"]	= $pagination;
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/review/index", $view_data, true);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	
	//------------------------------------------------------------------------------
	// Nations
	//------------------------------------------------------------------------------
	
	public function nations($action=null, $id=null)
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Nations" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "save") {
				$name	= $this->util->value($this->input->post("name"), "");
				$code	= $this->util->value($this->input->post("code"), "");
				$alias	= $this->util->value($this->input->post("alias"), "");
				$region	= $this->util->value($this->input->post("region"), "");
				$active	= $this->util->value($this->input->post("active"), 1);
				$type	= $this->util->value($this->input->post("type"), 1);
				
				if (empty($alias)) {
					$alias = $this->util->slug($name);
				}
				
				$data = array (
					"name"		=> $name,
					"code"		=> $code,
					"alias"		=> $alias,
					"alias"		=> $alias,
					"region"	=> $region,
					"active"	=> $active,
					"type"		=> $type
				);
				
				if ($action == "add") {
					$this->m_country->add($data);
				}
				else if ($action == "edit") {
					$where = array("id" => $id);
					$this->m_country->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/nations"));
			}
			else if ($task == "cancel") {
				redirect(site_url("syslog/nations"));
			}
			else if ($task == "orderup") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$this->m_country->order_up($id);
				}
				redirect(site_url("syslog/nations"));
			}
			else if ($task == "orderdown") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$this->m_country->order_down($id);
				}
				redirect(site_url("syslog/nations"));
			}
			else if ($task == "saveorder") {
				$order = $this->util->value($this->input->post("order"), array());
				$cids  = $this->util->value($this->input->post("cids"), array());
				for ($i=0; $i<sizeof($cids); $i++) {
					$data = array("order_num" => $order[$i]);
					$where = array("id" => $cids[$i]);
					$this->m_country->update($data, $where);
				}
				redirect(site_url("syslog/nations"));
			}
			else if ($task == "publish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 1);
					$where = array("id" => $id);
					$this->m_country->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/nations"));
			}
			else if ($task == "unpublish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 0);
					$where = array("id" => $id);
					$this->m_country->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/nations"));
			}
			else if ($task == "delete") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$where = array("id" => $id);
					$this->m_country->delete($where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/nations"));
			}
		}
		
		if ($action == "add") {
			$item = $this->m_country->instance();
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("Add Nation" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/nation/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else if ($action == "edit") {
			$item = $this->m_country->load($id);
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$item->name}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}/{$id}")));
		
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/nation/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else {
			$view_data = array();
			$view_data["breadcrumb"] 	= $this->_breadcrumb;
			$view_data["items"]			= $this->m_country->items(null, null, null, null);
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/nation/index", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
	}
	public function nation_type($action=null, $id=null)
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Nation type" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "save") {
				$name	= $this->util->value($this->input->post("name"), "");
				
				$data = array (
					"name"		=> $name,
				);
				
				if ($action == "add") {
					$this->m_nation_type->add($data);
				}
				else if ($action == "edit") {
					$where = array("id" => $id);
					$this->m_nation_type->update($data, $where);
				}
				redirect(site_url("syslog/nation-type"));
			}
			else if ($task == "cancel") {
				redirect(site_url("syslog/nation-type"));
			}
			else if ($task == "orderup") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$this->m_nation_type->order_up($id);
				}
				redirect(site_url("syslog/nation-type"));
			}
			else if ($task == "orderdown") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$this->m_nation_type->order_down($id);
				}
				redirect(site_url("syslog/nation-type"));
			}
			else if ($task == "saveorder") {
				$order = $this->util->value($this->input->post("order"), array());
				$cids  = $this->util->value($this->input->post("cids"), array());
				for ($i=0; $i<sizeof($cids); $i++) {
					$data = array("order_num" => $order[$i]);
					$where = array("id" => $cids[$i]);
					$this->m_nation_type->update($data, $where);
				}
				redirect(site_url("syslog/nation-type"));
			}
			else if ($task == "publish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 1);
					$where = array("id" => $id);
					$this->m_nation_type->update($data, $where);
				}
				redirect(site_url("syslog/nation-type"));
			}
			else if ($task == "unpublish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 0);
					$where = array("id" => $id);
					$this->m_nation_type->update($data, $where);
				}
				redirect(site_url("syslog/nation-type"));
			}
			else if ($task == "delete") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$where = array("id" => $id);
					$this->m_nation_type->delete($where);
				}
				redirect(site_url("syslog/nation-type"));
			}
		}
		
		if ($action == "add") {
			$item = $this->m_nation_type->instance();
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("Add Nation type" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/nation/type/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else if ($action == "edit") {
			$item = $this->m_nation_type->load($id);
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$item->name}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}/{$id}")));
		
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/nation/type/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else {
			$view_data = array();
			$view_data["breadcrumb"] 	= $this->_breadcrumb;
			$view_data["items"]			= $this->m_nation_type->items();
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/nation/type/index", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
	}
	
	public function provinces($action=null, $id=null)
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Provinces" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "save") {
				$name	= $this->util->value($this->input->post("name"), "");
				$code	= $this->util->value($this->input->post("code"), "");
				$alias	= $this->util->value($this->input->post("alias"), "");
				$active	= $this->util->value($this->input->post("active"), 1);
				
				if (empty($alias)) {
					$alias = $this->util->slug($name);
				}
				
				$data = array (
					"name"		=> $name,
					"code"		=> $code,
					"alias"		=> $alias,
					"alias"		=> $alias,
					"active"	=> $active
				);
				
				if ($action == "add") {
					$this->m_province->add($data);
				}
				else if ($action == "edit") {
					$where = array("id" => $id);
					$this->m_province->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/provinces"));
			}
			else if ($task == "cancel") {
				redirect(site_url("syslog/provinces"));
			}
			else if ($task == "orderup") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$this->m_province->order_up($id);
				}
				redirect(site_url("syslog/provinces"));
			}
			else if ($task == "orderdown") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$this->m_province->order_down($id);
				}
				redirect(site_url("syslog/provinces"));
			}
			else if ($task == "saveorder") {
				$order = $this->util->value($this->input->post("order"), array());
				$cids  = $this->util->value($this->input->post("cids"), array());
				for ($i=0; $i<sizeof($cids); $i++) {
					$data = array("order_num" => $order[$i]);
					$where = array("id" => $cids[$i]);
					$this->m_province->update($data, $where);
				}
				redirect(site_url("syslog/provinces"));
			}
			else if ($task == "publish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 1);
					$where = array("id" => $id);
					$this->m_province->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/provinces"));
			}
			else if ($task == "unpublish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 0);
					$where = array("id" => $id);
					$this->m_province->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/provinces"));
			}
			else if ($task == "delete") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$where = array("id" => $id);
					$this->m_province->delete($where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/provinces"));
			}
		}
		
		if ($action == "add") {
			$item = $this->m_province->instance();
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("Add Province" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/province/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else if ($action == "edit") {
			$item = $this->m_province->load($id);
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$item->name}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}/{$id}")));
		
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/province/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else {
			$page = (!empty($_GET["page"]) ? max($_GET["page"], 1) : 1);
			$pagination = $this->util->pagination(site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}"), $this->m_redirect->count(), ADMIN_ROW_PER_PAGE);
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["items"]			= $this->m_province->items(null, null, ADMIN_ROW_PER_PAGE, ($page - 1) * ADMIN_ROW_PER_PAGE);
			$view_data["page"]			= $page;
			$view_data["pagination"]	= $pagination;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/province/index", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
	}
	
	//------------------------------------------------------------------------------
	// Requirements
	//------------------------------------------------------------------------------
	
	public function requirements($action=null, $id=null)
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Vietnam Visa Requirements" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "save") {
				$nation_id			= $this->util->value($this->input->post("nation_id"), 0);
				$title				= $this->util->value($this->input->post("title"), "");
				$alias				= $this->util->value($this->input->post("alias"), "");
				$meta_title			= $this->util->value($this->input->post("meta_title"), "");
				$meta_key			= $this->util->value($this->input->post("meta_key"), "");
				$meta_desc			= $this->util->value($this->input->post("meta_desc"), "");
				$content			= $this->util->value($this->input->post("content"), "");
				$active				= $this->util->value($this->input->post("active"), 1);
				$type				= $this->util->value($this->input->post("type"), 1);
				
				if (empty($alias)) {
					$alias = $this->util->slug($title);
				}
				
				$data = array (
					"nation_id"			=> $nation_id,
					"title"				=> $title,
					"alias"				=> $alias,
					//"meta_title"		=> $meta_title,
					//"meta_key"		=> $meta_key,
					//"meta_desc"		=> $meta_desc,
					"content"			=> $content,
					"active"			=> $active,
					"type"				=> $type,
				);
				
				if ($action == "add") {
					$this->m_requirement->add($data);
				}
				else if ($action == "edit") {
					$where = array("id" => $id);
					$this->m_requirement->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/requirements"));
			}
			else if ($task == "cancel") {
				redirect(site_url("syslog/requirements"));
			}
			else if ($task == "publish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 1);
					$where = array("id" => $id);
					$this->m_requirement->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/requirements"));
			}
			else if ($task == "unpublish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 0);
					$where = array("id" => $id);
					$this->m_requirement->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/requirements"));
			}
			else if ($task == "delete") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$where = array("id" => $id);
					$this->m_requirement->delete($where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/requirements"));
			}
		}
		
		if ($action == "add") {
			$item = $this->m_requirement->instance();
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("Add Requirement" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			$view_data["nations"] = $this->m_country->items();
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/requirement/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else if ($action == "edit") {
			$item = $this->m_requirement->load($id);
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$item->title}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}/{$id}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			$view_data["nations"] = $this->m_country->items();
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/requirement/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else {
			$view_data = array();
			$view_data["breadcrumb"]	= $this->_breadcrumb;
			$view_data["items"]			= $this->m_requirement->items(null, null, null, null);
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/requirement/index", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
	}
	
	//------------------------------------------------------------------------------
	// Embassies
	//------------------------------------------------------------------------------
	
	public function embassies($action=null, $id=null)
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Vietnam Embassies" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "save") {
				$nation_id		= $this->util->value($this->input->post("nation_id"), 0);
				$title			= $this->util->value($this->input->post("title"), "");
				$alias			= $this->util->value($this->input->post("alias"), "");
				$meta_title		= $this->util->value($this->input->post("meta_title"), "");
				$meta_key		= $this->util->value($this->input->post("meta_key"), "");
				$meta_desc		= $this->util->value($this->input->post("meta_desc"), "");
				$content		= $this->util->value($this->input->post("content"), "");
				$active			= $this->util->value($this->input->post("active"), 1);
				
				if (empty($alias)) {
					$alias = $this->util->slug($title);
				}
				
				$data = array (
					"nation_id"		=> $nation_id,
					"title"			=> $title,
					"alias"			=> $alias,
					//"meta_title"	=> $meta_title,
					//"meta_key"		=> $meta_key,
					//"meta_desc"		=> $meta_desc,
					"content"		=> $content,
					"active"		=> $active,
				);
				
				if ($action == "add") {
					$this->m_embassy->add($data);
				}
				else if ($action == "edit") {
					$where = array("id" => $id);
					$this->m_embassy->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/embassies"));
			}
			else if ($task == "cancel") {
				redirect(site_url("syslog/embassies"));
			}
			else if ($task == "publish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 1);
					$where = array("id" => $id);
					$this->m_embassy->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/embassies"));
			}
			else if ($task == "unpublish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 0);
					$where = array("id" => $id);
					$this->m_embassy->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/embassies"));
			}
			else if ($task == "delete") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$where = array("id" => $id);
					$this->m_embassy->delete($where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/embassies"));
			}
		}
		
		if ($action == "add") {
			$item = $this->m_embassy->instance();
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("Add Embassy" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			$view_data["nations"] = $this->m_country->items();
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/embassy/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else if ($action == "edit") {
			$item = $this->m_embassy->load($id);
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$item->title}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}/{$id}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			$view_data["nations"] = $this->m_country->items();
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/embassy/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else {
			$view_data = array();
			$view_data["breadcrumb"]	= $this->_breadcrumb;
			$view_data["items"]			= $this->m_embassy->items(null, null, null, null);
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/embassy/index", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
	}
	
	//------------------------------------------------------------------------------
	// Guide
	//------------------------------------------------------------------------------
	
	public function guide($action=null, $id=null)
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Vietnam Visa Guide" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "save") {
				$nation_id		= $this->util->value($this->input->post("nation_id"), 0);
				$title			= $this->util->value($this->input->post("title"), "");
				$alias			= $this->util->value($this->input->post("alias"), "");
				$meta_title		= $this->util->value($this->input->post("meta_title"), "");
				$meta_key		= $this->util->value($this->input->post("meta_key"), "");
				$meta_desc		= $this->util->value($this->input->post("meta_desc"), "");
				$content		= $this->util->value($this->input->post("content"), "");
				$active			= $this->util->value($this->input->post("active"), 1);
				
				if (empty($alias)) {
					$alias = $this->util->slug($title);
				}
				
				$data = array (
					"nation_id"		=> $nation_id,
					"title"			=> $title,
					"alias"			=> $alias,
					//"meta_title"	=> $meta_title,
					//"meta_key"		=> $meta_key,
					//"meta_desc"		=> $meta_desc,
					"content"		=> $content,
					"active"		=> $active,
				);
				
				if ($action == "add") {
					$this->m_tips->add($data);
				}
				else if ($action == "edit") {
					$where = array("id" => $id);
					$this->m_tips->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/guide"));
			}
			else if ($task == "cancel") {
				redirect(site_url("syslog/guide"));
			}
			else if ($task == "publish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 1);
					$where = array("id" => $id);
					$this->m_tips->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/guide"));
			}
			else if ($task == "unpublish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 0);
					$where = array("id" => $id);
					$this->m_tips->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/guide"));
			}
			else if ($task == "delete") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$where = array("id" => $id);
					$this->m_tips->delete($where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/guide"));
			}
		}
		
		if ($action == "add") {
			$item = $this->m_tips->instance();
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("Add Guidance" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			$view_data["nations"] = $this->m_country->items();
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/tips/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else if ($action == "edit") {
			$item = $this->m_tips->load($id);
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$item->title}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}/{$id}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			$view_data["nations"] = $this->m_country->items();
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/tips/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else {
			$view_data = array();
			$view_data["breadcrumb"]	= $this->_breadcrumb;
			$view_data["items"]			= $this->m_tips->items(null, null, null, null);
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/tips/index", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
	}
	
	//------------------------------------------------------------------------------
	// Options
	//------------------------------------------------------------------------------
	
	public function passport_types($action=null, $id=null)
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Passport Types" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "save") {
				$name		= $this->util->value($this->input->post("name"), "");
				$code		= $this->util->value($this->input->post("code"), "");
				$active		= $this->util->value($this->input->post("active"), 1);
				
				$data = array (
					"name"			=> $name,
					"code"			=> $code,
					"active"		=> $active,
				);
	
				if ($action == "add") {
					$this->m_passport_type->add($data);
				}
				else if ($action == "edit") {
					$where = array("id" => $id);
					$this->m_passport_type->update($data, $where);
				}
				redirect(site_url("syslog/passport-types"));
			}
			else if ($task == "cancel") {
				redirect(site_url("syslog/passport-types"));
			}
			else if ($task == "publish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 1);
					$where = array("id" => $id);
					$this->m_passport_type->update($data, $where);
				}
				redirect(site_url("syslog/passport-types"));
			}
			else if ($task == "unpublish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 0);
					$where = array("id" => $id);
					$this->m_passport_type->update($data, $where);
				}
				redirect(site_url("syslog/passport-types"));
			}
			else if ($task == "delete") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$where = array("id" => $id);
					$this->m_passport_type->delete($where);
				}
				redirect(site_url("syslog/passport-types"));
			}
		}
		
		if ($action == "add") {
			$item = $this->m_passport_type->instance();
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("Add Passport Type" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/options/passport/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else if ($action == "edit") {
			$item = $this->m_passport_type->load($id);
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$item->name}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}/{$id}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/options/passport/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else {
			$view_data = array();
			$view_data["breadcrumb"]	= $this->_breadcrumb;
			$view_data["items"]			= $this->m_passport_type->items(null, null, null, null);
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/options/passport/index", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
	}
	
	public function visa_types($action=null, $id=null)
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Visa Types" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "save") {
				$name		= $this->util->value($this->input->post("name"), "");
				$short_name	= $this->util->value($this->input->post("short_name"), "");
				$code		= $this->util->value($this->input->post("code"), "");
				$active		= $this->util->value($this->input->post("active"), 1);
				
				$data = array (
					"name"			=> $name,
					"short_name"	=> $short_name,
					"code"			=> $code,
					"active"		=> $active,
				);
	
				if ($action == "add") {
					$this->m_visa_type->add($data);
				}
				else if ($action == "edit") {
					$where = array("id" => $id);
					$this->m_visa_type->update($data, $where);
				}
				redirect(site_url("syslog/visa-types"));
			}
			else if ($task == "cancel") {
				redirect(site_url("syslog/visa-types"));
			}
			else if ($task == "publish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 1);
					$where = array("id" => $id);
					$this->m_visa_type->update($data, $where);
				}
				redirect(site_url("syslog/visa-types"));
			}
			else if ($task == "unpublish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 0);
					$where = array("id" => $id);
					$this->m_visa_type->update($data, $where);
				}
				redirect(site_url("syslog/visa-types"));
			}
			else if ($task == "delete") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$where = array("id" => $id);
					$this->m_visa_type->delete($where);
				}
				redirect(site_url("syslog/visa-types"));
			}
		}
		
		if ($action == "add") {
			$item = $this->m_visa_type->instance();
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("Add Visa Type" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/options/type/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else if ($action == "edit") {
			$item = $this->m_visa_type->load($id);
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$item->name}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}/{$id}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/options/type/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else {
			$view_data = array();
			$view_data["breadcrumb"]	= $this->_breadcrumb;
			$view_data["items"]			= $this->m_visa_type->items(null, null, null, null);
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/options/type/index", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
	}
	
	public function visit_purposes($action=null, $id=null)
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Visit Purposes" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "save") {
				$name		= $this->util->value($this->input->post("name"), "");
				$short_name	= $this->util->value($this->input->post("short_name"), "");
				$code		= $this->util->value($this->input->post("code"), "");
				$active		= $this->util->value($this->input->post("active"), 1);
				
				$data = array (
					"name"			=> $name,
					"short_name"	=> $short_name,
					"code"			=> $code,
					"active"		=> $active,
				);
	
				if ($action == "add") {
					$this->m_visit_purpose->add($data);
				}
				else if ($action == "edit") {
					$where = array("id" => $id);
					$this->m_visit_purpose->update($data, $where);
				}
				redirect(site_url("syslog/visit-purposes"));
			}
			else if ($task == "cancel") {
				redirect(site_url("syslog/visit-purposes"));
			}
			else if ($task == "publish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 1);
					$where = array("id" => $id);
					$this->m_visit_purpose->update($data, $where);
				}
				redirect(site_url("syslog/visit-purposes"));
			}
			else if ($task == "unpublish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 0);
					$where = array("id" => $id);
					$this->m_visit_purpose->update($data, $where);
				}
				redirect(site_url("syslog/visit-purposes"));
			}
			else if ($task == "delete") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$where = array("id" => $id);
					$this->m_visit_purpose->delete($where);
				}
				redirect(site_url("syslog/visit-purposes"));
			}
		}
		
		if ($action == "add") {
			$item = $this->m_visit_purpose->instance();
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("Add Visit Purpose" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/options/purpose/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else if ($action == "edit") {
			$item = $this->m_visit_purpose->load($id);
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$item->name}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}/{$id}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/options/purpose/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else {
			$view_data = array();
			$view_data["breadcrumb"]	= $this->_breadcrumb;
			$view_data["items"]			= $this->m_visit_purpose->items(null, null, null, null);
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/options/purpose/index", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
	}
	
	function ajax_visit_purpose_type()
	{
		$visit_purpose = $this->input->post("visit_purpose");
		$visa_type = $this->input->post("visa_type");
		$val = $this->input->post("val");
		
		$purpose_type = $this->m_visit_purpose_types->search($visit_purpose, $visa_type);
		
		if ($val) {
			if (empty($purpose_type)) {
				$data = array(
					"visit_purpose_id"	=> $visit_purpose,
					"visa_type_id"		=> $visa_type
				);
				$this->m_visit_purpose_types->add($data);
			}
		}
		else {
			if (!empty($purpose_type)) {
				$data = array(
					"visit_purpose_id"	=> $visit_purpose,
					"visa_type_id"		=> $visa_type
				);
				$this->m_visit_purpose_types->delete($data);
			}
		}
		
		echo "";
	}
	
	public function arrival_ports($category_id, $action=null, $id=null)
	{
		$category = $this->m_arrival_port_category->load($category_id);
		
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Arrial Ports" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$category->name}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$category_id}")));
		
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "save") {
				$airport		= $this->util->value($this->input->post("airport"), "");
				$short_name		= $this->util->value($this->input->post("short_name"), "");
				$code			= $this->util->value($this->input->post("code"), "");
				$active			= $this->util->value($this->input->post("active"), 1);
				$category_id	= $this->util->value($this->input->post("category_id"), 0);
				
				$data = array (
					"airport"		=> $airport,
					"short_name"	=> $short_name,
					"code"			=> $code,
					"active"		=> $active,
					"category_id"	=> $category_id
				);
	
				if ($action == "add") {
					$this->m_arrival_port->add($data);
				}
				else if ($action == "edit") {
					$where = array("id" => $id);
					$this->m_arrival_port->update($data, $where);
				}
				redirect(site_url("syslog/arrival-ports/{$category->id}"));
			}
			else if ($task == "cancel") {
				redirect(site_url("syslog/arrival-ports/{$category->id}"));
			}
			else if ($task == "publish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 1);
					$where = array("id" => $id);
					$this->m_arrival_port->update($data, $where);
				}
				redirect(site_url("syslog/arrival-ports/{$category->id}"));
			}
			else if ($task == "unpublish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 0);
					$where = array("id" => $id);
					$this->m_arrival_port->update($data, $where);
				}
				redirect(site_url("syslog/arrival-ports/{$category->id}"));
			}
			else if ($task == "delete") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$where = array("id" => $id);
					$this->m_arrival_port->delete($where);
				}
				redirect(site_url("syslog/arrival-ports/{$category->id}"));
			}
		}
		
		if ($action == "add") {
			$item = $this->m_arrival_port->instance();
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("Add {$category->name}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			$view_data["category"] = $category;
			$view_data["categories"] = $this->m_arrival_port_category->items();
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/options/port/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else if ($action == "edit") {
			$item = $this->m_arrival_port->load($id);
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$item->airport}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}/{$id}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			$view_data["category"] = $category;
			$view_data["categories"] = $this->m_arrival_port_category->items();
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/options/port/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else {
			$info = new stdClass();
			$info->category_id = $category->id;
			
			$view_data = array();
			$view_data["breadcrumb"]	= $this->_breadcrumb;
			$view_data["items"]			= $this->m_arrival_port->items($info, null, null, null);
			$view_data["category"] = $category;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/options/port/index", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
	}
	
	//------------------------------------------------------------------------------
	// Pricing
	//------------------------------------------------------------------------------
	
	public function visa_fees()
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Vietnam Visa Fees" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$view_data = array();
		$view_data["breadcrumb"] = $this->_breadcrumb;
		$view_data["default"] = $this->m_visa_fee->instance();
		$view_data["items"] = $this->m_visa_fee->items();
		$view_data["nations"] = $this->m_country->items();
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/pricing/visa", $view_data, true);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	
	function ajax_visa_fee()
	{
		$nation_id = $this->input->post("nation_id");
		$visa_type = $this->input->post("visa_type");
		$val = $this->input->post("val");
		
		if (empty($this->m_visa_fee->search($nation_id))) {
			$default = $this->m_visa_fee->instance();
			$data  = array(
				"nation_id"		=> $nation_id,
				"tourist_1ms"	=> $default->tourist_1ms,
				"tourist_1mm"	=> $default->tourist_1mm,
				"tourist_3ms"	=> $default->tourist_3ms,
				"tourist_3mm"	=> $default->tourist_3mm,
				"tourist_6mm"	=> $default->tourist_6mm,
				"tourist_1ym"	=> $default->tourist_1ym,
				"business_1ms"	=> $default->business_1ms,
				"business_1mm"	=> $default->business_1mm,
				"business_3ms"	=> $default->business_3ms,
				"business_3mm"	=> $default->business_3mm,
				"business_6mm"	=> $default->business_6mm,
				"business_1ym"	=> $default->business_1ym,
			);
			$this->m_visa_fee->add($data);
		}
		
		$data  = array(
			"{$visa_type}" => $val
		);
		$where = array(
			"nation_id" => $nation_id
		);
		
		$this->m_visa_fee->update($data, $where);
		
		echo "";
	}
	
	public function processing_fees()
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Processing Fees" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$fees = $this->m_processing_fee->items();
		if (!empty($fees)) {
			$fee = array_shift($fees);
		} else {
			$fee = $this->m_processing_fee->instance();
		}
		
		$view_data = array();
		$view_data["breadcrumb"] = $this->_breadcrumb;
		$view_data["fee"] = $fee;
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/pricing/processing", $view_data, true);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	
	function ajax_processing_fee()
	{
		$visa_type = $this->input->post("visa_type");
		$val = $this->input->post("val");
		
		$fees = $this->m_processing_fee->items();
		
		if (empty($fees)) {
			$default = $this->m_processing_fee->instance();
			$data  = array(
				"tourist_1ms_urgent"		=> $default->tourist_1ms_urgent,
				"tourist_1ms_emergency"		=> $default->tourist_1ms_emergency,
				"tourist_1ms_holiday"		=> $default->tourist_1ms_holiday,
				"tourist_1mm_urgent"		=> $default->tourist_1mm_urgent,
				"tourist_1mm_emergency"		=> $default->tourist_1mm_emergency,
				"tourist_1mm_holiday"		=> $default->tourist_1mm_holiday,
				"tourist_3ms_urgent"		=> $default->tourist_3ms_urgent,
				"tourist_3ms_emergency"		=> $default->tourist_3ms_emergency,
				"tourist_3ms_holiday"		=> $default->tourist_3ms_holiday,
				"tourist_3mm_urgent"		=> $default->tourist_3mm_urgent,
				"tourist_3mm_emergency"		=> $default->tourist_3mm_emergency,
				"tourist_3mm_holiday"		=> $default->tourist_3mm_holiday,
				"tourist_6mm_urgent"		=> $default->tourist_6mm_urgent,
				"tourist_6mm_emergency"		=> $default->tourist_6mm_emergency,
				"tourist_6mm_holiday"		=> $default->tourist_6mm_holiday,
				"tourist_1ym_urgent"		=> $default->tourist_1ym_urgent,
				"tourist_1ym_emergency"		=> $default->tourist_1ym_emergency,
				"tourist_1ym_holiday"		=> $default->tourist_1ym_holiday,
				"business_1ms_urgent"		=> $default->business_1ms_urgent,
				"business_1ms_emergency"	=> $default->business_1ms_emergency,
				"business_1ms_holiday"		=> $default->business_1ms_holiday,
				"business_1mm_urgent"		=> $default->business_1mm_urgent,
				"business_1mm_emergency"	=> $default->business_1mm_emergency,
				"business_1mm_holiday"		=> $default->business_1mm_holiday,
				"business_3ms_urgent"		=> $default->business_3ms_urgent,
				"business_3ms_emergency"	=> $default->business_3ms_emergency,
				"business_3ms_holiday"		=> $default->business_3ms_holiday,
				"business_3mm_urgent"		=> $default->business_3mm_urgent,
				"business_3mm_emergency"	=> $default->business_3mm_emergency,
				"business_3mm_holiday"		=> $default->business_3mm_holiday,
				"business_6mm_urgent"		=> $default->business_6mm_urgent,
				"business_6mm_emergency"	=> $default->business_6mm_emergency,
				"business_6mm_holiday"		=> $default->business_6mm_holiday,
				"business_1ym_urgent"		=> $default->business_1ym_urgent,
				"business_1ym_emergency"	=> $default->business_1ym_emergency,
				"business_1ym_holiday"		=> $default->business_1ym_holiday,
			);
			$this->m_processing_fee->add($data);
		}
		
		$fees = $this->m_processing_fee->items();
		if (!empty($fees)) {
			$fee = array_shift($fees);
		}
		
		$data  = array(
			"{$visa_type}" => $val
		);
		$where = array(
			"id" => $fee->id
		);
		
		$this->m_processing_fee->update($data, $where);
		
		echo "";
	}

	public function car_plus_fees($action=null, $id=null)
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Processing Fees" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "save") {
				$port			= $this->util->value($this->input->post("port"), 0);
				$distance		= $this->util->value($this->input->post("distance"), 0);
				$distance_plus	= $this->util->value($this->input->post("distance_plus"), 0);
				$seat_4			= $this->util->value($this->input->post("seat_4"), 0);
				$seat_7			= $this->util->value($this->input->post("seat_7"), 0);
				$seat_16		= $this->util->value($this->input->post("seat_16"), 0);
				$seat_24		= $this->util->value($this->input->post("seat_24"), 0);
				
				$data = array (
					"port"			=> $port,
					"distance"		=> $distance,
					"distance_plus"	=> $distance_plus,
					"seat_4"		=> $seat_4,
					"seat_7"		=> $seat_7,
					"seat_16"		=> $seat_16,
					"seat_24"		=> $seat_24
				);
				if ($action == "add") {
					$this->m_car_plus_fee->add($data);
				}
				else if ($action == "edit") {
					$where = array("id" => $id);
					$this->m_car_plus_fee->update($data, $where);
				}
				redirect(site_url("syslog/car-plus-fees"));
			}
			else if ($task == "cancel") {
				redirect(site_url("syslog/car-plus-fees"));
			}
			else if ($task == "delete") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$where = array("id" => $id);
					$this->m_car_plus_fee->delete($where);
				}
				redirect(site_url("syslog/car-plus-fees"));
			}
		}
		if ($action == 'add') {
			$item = $this->m_car_plus_fee->instance();
		
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/pricing/edit_car_plus", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		} else if ($action == 'edit') {
			$item = $this->m_car_plus_fee->load($id);
		
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/pricing/edit_car_plus", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		} else {
			$items = $this->m_car_plus_fee->items();
		
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["items"] = $items;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/pricing/car_plus", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
	}
	function ajax_car_plus_fees()
	{
		$visa_type 	= $this->input->post("visa_type");
		$val 		= $this->input->post("val");
		$id 		= $this->input->post("id");

		$data  = array(
			"{$visa_type}" => $val
		);
		$where = array(
			"id" => $id
		);
		
		$this->m_car_plus_fee->update($data, $where);
		
		echo "";
	}
	
	public function private_letter_fees()
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Private Letter Fees" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$fees = $this->m_private_letter_fee->items();
		if (!empty($fees)) {
			$fee = array_shift($fees);
		} else {
			$fee = $this->m_private_letter_fee->instance();
		}
		
		$view_data = array();
		$view_data["breadcrumb"] = $this->_breadcrumb;
		$view_data["fee"] = $fee;
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/pricing/private", $view_data, true);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	
	function ajax_private_letter_fee()
	{
		$visa_type = $this->input->post("visa_type");
		$val = $this->input->post("val");
		
		$fees = $this->m_private_letter_fee->items();
		
		if (empty($fees)) {
			$default = $this->m_private_letter_fee->instance();
			$data  = array(
				"tourist_1ms"	=> $default->tourist_1ms,
				"tourist_1mm"	=> $default->tourist_1mm,
				"tourist_3ms"	=> $default->tourist_3ms,
				"tourist_3mm"	=> $default->tourist_3mm,
				"tourist_6mm"	=> $default->tourist_6mm,
				"tourist_1ym"	=> $default->tourist_1ym,
				"business_1ms"	=> $default->business_1ms,
				"business_1mm"	=> $default->business_1mm,
				"business_3ms"	=> $default->business_3ms,
				"business_3mm"	=> $default->business_3mm,
				"business_6mm"	=> $default->business_6mm,
				"business_1ym"	=> $default->business_1ym,
			);
			$this->m_private_letter_fee->add($data);
		}
		
		$fees = $this->m_private_letter_fee->items();
		if (!empty($fees)) {
			$fee = array_shift($fees);
		}
		
		$data  = array(
			"{$visa_type}" => $val
		);
		$where = array(
			"id" => $fee->id
		);
		
		$this->m_private_letter_fee->update($data, $where);
		
		echo "";
	}
	
	public function car_fees()
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Car Fees" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$fees = $this->m_car_fee->items();
		if (!empty($fees)) {
			$fee = array_shift($fees);
		} else {
			$fee = $this->m_car_fee->instance();
		}
		
		$view_data = array();
		$view_data["breadcrumb"] = $this->_breadcrumb;
		$view_data["port_categories"] = $this->m_arrival_port_category->items();
		$view_data["fee"] = $fee;
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/pricing/car", $view_data, true);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	
	function ajax_car_fee()
	{
		$car_type = $this->input->post("car_type");
		$airport = $this->input->post("airport");
		$val = $this->input->post("val");
		
		$info = new stdClass();
		$info->airport = $airport;
		$fees = $this->m_car_fee->items($info);
		if (!empty($fees)) {
			$fee = array_shift($fees);
		}
		
		$data = array(
			"{$car_type}"	=> $val,
			"airport"		=> $airport
		);
		
		if (empty($fee)) {
			$this->m_car_fee->add($data);
		} else {
			$this->m_car_fee->update($data, array("id" => $fee->id));
		}
		
		echo "";
	}
	
	public function fast_checkin_fees()
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Fast Check-in Fees" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$fees = $this->m_fast_checkin_fee->items();
		if (!empty($fees)) {
			$fee = array_shift($fees);
		} else {
			$fee = $this->m_fast_checkin_fee->instance();
		}
		
		$view_data = array();
		$view_data["breadcrumb"] = $this->_breadcrumb;
		$view_data["port_categories"] = $this->m_arrival_port_category->items();
		$view_data["fee"] = $fee;
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/pricing/fc", $view_data, true);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	
	function ajax_fast_checkin_fee()
	{
		$fc_type = $this->input->post("fc_type");
		$airport = $this->input->post("airport");
		$val = $this->input->post("val");
		
		$info = new stdClass();
		$info->airport = $airport;
		$fees = $this->m_fast_checkin_fee->items($info);
		if (!empty($fees)) {
			$fee = array_shift($fees);
		}
		
		$data = array(
			"{$fc_type}"	=> $val,
			"airport"		=> $airport
		);
		
		if (empty($fee)) {
			$this->m_fast_checkin_fee->add($data);
		} else {
			$this->m_fast_checkin_fee->update($data, array("id" => $fee->id));
		}
		
		echo "";
	}
	
	//------------------------------------------------------------------------------
	// Report
	//------------------------------------------------------------------------------
	
	function check_list()
	{
		$task		= $this->util->value($this->input->post("task"), "");
		$fromdate	= $this->util->value($this->input->post("fromdate"), date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), date('d'), date('Y'))));
		$todate		= $this->util->value($this->input->post("todate"), date('Y-m-d H:i:s', mktime(date('H'), date('i'), 59, date('m'), date('d'), date('Y'))));
		
		if (!empty($fromdate)) {
			$fromdate = date("Y-m-d H:i:s", strtotime($fromdate));
		}
		if (!empty($todate)) {
			$todate = date("Y-m-d H:i:59", strtotime($todate));
		}
		
		$info = new stdClass();
		$info->fromdate = $fromdate;
		$info->todate = $todate;
		
		$items = $this->m_visa_booking->all_booking_success($info);
		
		$booking_ids = array();
		for ($idx = 0; $idx < sizeof($items); $idx++) {
			$booking_ids[] = $items[$idx]->order_id;
		}
		if (sizeof($booking_ids)) {
			$paxs = $this->m_visa_booking->booking_travelers($booking_ids);
		} else {
			$paxs = array();
		}
		
		if ($task == "download") {
			$this->load->library("PHPExcel");
			$objPHPExcel = new PHPExcel();
			
			// Set document properties
			$objPHPExcel->getProperties()->setCreator(SITE_NAME)
										 ->setLastModifiedBy(SITE_NAME)
										 ->setTitle("Check List ".date('M-d-Y', strtotime($fromdate))." to ".date('M-d-Y', strtotime($todate)))
										 ->setSubject("Check List ".date('M-d-Y', strtotime($fromdate))." to ".date('M-d-Y', strtotime($todate)))
										 ->setDescription("Check List ".date('M-d-Y', strtotime($fromdate))." to ".date('M-d-Y', strtotime($todate)))
										 ->setKeywords("")
										 ->setCategory("");
			
			$row = 1;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row, 'App No');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row, 'Fullname');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row, 'Gender');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$row, 'Date of Birth ');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$row, 'Nationality');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$row, 'Passport No');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$row, 'Arrival Date');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$row, 'Arrival Port');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$row, 'Type');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$row, 'Private');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$row, 'Full Package');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$row, 'FC');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$row, 'Car');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$row, 'Flight');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$row, 'Status');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$row, 'Price');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$row, 'Email');
			
			$rowHead = array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '5CB85C')
				)
			);
			$rowEVS = array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFFDD')
				)
			);
			$rowEX = array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FF9900')
				)
			);
			$rowPO = array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFFDD')
				)
			);
			
			$prss0 = '';
			$prss1 = 'FF6600';
			$prss2 = 'FF0000';
			$prss3 = '0000FF';
			
			$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':Q'.$row)->applyFromArray($rowHead);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':Q'.$row)->getFont()->setBold(TRUE);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':Q'.$row)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

			if (!empty($items) && sizeof($items)) {
				$row++;
				foreach ($items as $item) {
					if ($item->booking_type == BOOKING_PREFIX) {
						$arrival_port = "";
						switch ($item->arrival_port) {
							case 'Ho Chi Minh':
								$arrival_port = 'HCM';
								break;
							case 'Ha Noi':
								$arrival_port = 'HN';
								break;
							case 'Da Nang':
								$arrival_port = 'DN';
								break;
							case 'Cam Ranh':
								$arrival_port = 'CR';
								break;
							default:
								$arrival_port = '';
								break;
						}
						
						$visa_type = "";
						switch ($item->visa_type) {
							case '1 month single':
								$visa_type = '1T1L';
								break;
							case '3 months single':
								$visa_type = '3T1L';
								break;
							case '6 months single':
								$visa_type = '6T1L';
								break;
							case '1 month multiple':
								$visa_type = '1TNL';
								break;
							case '3 months multiple':
								$visa_type = '3TNL';
								break;
							case '6 months multiple':
								$visa_type = '6TNL';
								break;
							case '1 year multiple':
								$visa_type = '1NNL';
								break;
							default:
								$visa_type = '';
								break;
						}
						
						$private_visa = ($item->private_visa ? 'Yes' : '');
						
						$full_package = ($item->full_package ? 'Yes' : '');
						
						$fast_checkin = "";
						if ($item->full_package) {
							$fast_checkin = 'NOR';
						}
						else {
							switch ($item->fast_checkin) {
								case '1':
									$fast_checkin = 'NOR';
									break;
								case '2':
									$fast_checkin = 'VIP';
									break;
								default:
									$fast_checkin = '';
									break;
							}
						}
						
						$car_pickup = "";
						if ($item->car_pickup) {
							$car_pickup = $item->car_type." (".$item->seats." seats)";
						}
						
						$flight_number = "";
						if (!empty($item->flight_number)) {
							$flight_number = $item->flight_number;
						}
						if (!empty($item->arrival_time)) {
							$flight_number .= " (".$item->arrival_time.")";
						}
						
						$rush_type = "";
						switch ($item->rush_type) {
							case '1':
								$rush_type = 'URG';
								break;
							case '2':
								$rush_type = 'EME';
								break;
							case '3':
								$rush_type = 'HOL';
								break;
							default:
								$rush_type = 'NOR';
								break;
						}
						
						foreach ($paxs as $pax) {
							if ($pax->book_id == $item->order_id) {
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row, $item->booking_type.$item->order_id);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row, $pax->fullname);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row, $pax->gender);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$row, date('M/d/Y', strtotime($pax->birthday)));
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$row, $pax->nationality);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$row, $pax->passport);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$row, date('M/d/Y', strtotime($item->arrival_date)));
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$row, $arrival_port);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$row, $visa_type);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$row, $private_visa);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$row, $full_package);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$row, $fast_checkin);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$row, $car_pickup);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$row, $flight_number);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$row, $rush_type);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$row, '');
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$row, '');
								
								if ($item->rush_type == 1) {
									$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':Q'.$row)->getFont()->getColor()->setRGB($prss1);
								}
								else if ($item->rush_type == 2) {
									$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':Q'.$row)->getFont()->getColor()->setRGB($prss2);
								}
								else if ($item->rush_type == 3) {
									$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':Q'.$row)->getFont()->getColor()->setRGB($prss3);
								}
								
								$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':Q'.$row)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
								$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->getStyle('H'.$row.':L'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
								$objPHPExcel->getActiveSheet()->getStyle('O'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
								$objPHPExcel->getActiveSheet()->getStyle('P'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								
								$row++;
							}
						}
					}
					else if ($item->booking_type == BOOKING_PREFIX_EX) {
						$arrival_port = "";
						switch ($item->arrival_port) {
							case 'Ho Chi Minh':
								$arrival_port = 'HCM';
								break;
							case 'Ha Noi':
								$arrival_port = 'HN';
								break;
							case 'Da Nang':
								$arrival_port = 'DN';
								break;
							case 'Cam Ranh':
								$arrival_port = 'CR';
								break;
							default:
								$arrival_port = '';
								break;
						}
						
						$fast_checkin = "";
						switch ($item->fast_checkin) {
							case '1':
								$fast_checkin = 'NOR';
								break;
							case '2':
								$fast_checkin = 'VIP';
								break;
							default:
								$fast_checkin = '';
								break;
						}
						
						$car_pickup = "";
						if ($item->car_pickup) {
							$car_pickup = $item->car_type." (".$item->seats." seats)";
						}
						
						$flight_number = "";
						if (!empty($item->flight_number)) {
							$flight_number = $item->flight_number;
						}
						if (!empty($item->arrival_time)) {
							$flight_number .= " (".$item->arrival_time.")";
						}
						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row, $item->booking_type.$item->order_id);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row, '');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row, '');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$row, '');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$row, '');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$row, '');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$row, $item->arrival_date);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$row, $arrival_port);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$row, '');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$row, '');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$row, '');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$row, $fast_checkin);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$row, $car_pickup);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$row, $flight_number);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$row, '');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$row, '');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$row, '');
						
						$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':Q'.$row)->applyFromArray($rowEX);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':Q'.$row)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
						$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$row.':L'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('O'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('P'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						
						$row++;
					}
					else if ($item->booking_type == BOOKING_PREFIX_PO) {
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row, $item->booking_type.$item->order_id);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row, $item->fullname);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row, '');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$row, '');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$row, '');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$row, '');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$row, '');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$row, '');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$row, '');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$row, '');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$row, '');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$row, '');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$row, '');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$row, '');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$row, '');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$row, $item->amount);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$row, '');
						
						$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':Q'.$row)->applyFromArray($rowPO);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':Q'.$row)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
						$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$row.':L'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('O'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('P'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						
						$row++;
					}
				}
			}
			
			foreach(range('A','Q') as $columnID) {
				$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
			}
			
			// Rename worksheet
			$objPHPExcel->getActiveSheet()->setTitle('Check List');
			
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);
			
			// Redirect output to a clientâ€™s web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="List '.date('M-d-Y H:i:s', strtotime($fromdate)).' to '.date('M-d-Y H:i:s', strtotime($todate)).'.xls"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');
			
			// If you're serving to IE over SSL, then the following may be needed
			header ('Expires: Mon, 26 Jul 1997 00:00:00 GMT'); // Date in the past
			header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
			header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header ('Pragma: public'); // HTTP/1.0
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
		}
		
		$view_data = array();
		$view_data['fromdate']	= $fromdate;
		$view_data['todate']	= $todate;
		$view_data['items']		= $items;
		$view_data['paxs']		= $paxs;
		
		$tmpl_content = array();
		$tmpl_content["content"]	= $this->load->view("admin/report/checklist", $view_data, TRUE);
		$this->load->view("layout/admin/main", $tmpl_content);
	}

	function export_list()
	{
		$task		= $this->util->value($this->input->post("task"), "");
		$fromdate	= $this->util->value($this->input->post("fromdate"), date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), date('d'), date('Y'))));
		$todate		= $this->util->value($this->input->post("todate"), date('Y-m-d H:i:s', mktime(date('H'), date('i'), 59, date('m'), date('d'), date('Y'))));
		
		if (!empty($fromdate)) {
			$fromdate = date("Y-m-d H:i:s", strtotime($fromdate));
		}
		if (!empty($todate)) {
			$todate = date("Y-m-d H:i:s", strtotime($todate));
		}
		
		$info = new stdClass();
		$info->fromdate = $fromdate;
		$info->todate = $todate;
		
		$items = $this->m_visa_booking->all_booking_success($info);
		$booking_ids = array();
		for ($idx = 0; $idx < sizeof($items); $idx++) {
			$booking_ids[] = $items[$idx]->order_id;
		}
		if (sizeof($booking_ids)) {
			$paxs = $this->m_visa_booking->booking_travelers($booking_ids);
		} else {
			$paxs = array();
		}
		
		$view_data = array();
		$view_data['fromdate']	= $fromdate;
		$view_data['todate']	= $todate;
		$view_data['items']		= $items;
		$view_data['paxs']		= $paxs;
		
		$tmpl_content = array();
		$tmpl_content["content"]	= $this->load->view("admin/report/export_list", $view_data, TRUE);
		$this->load->view("layout/admin/main", $tmpl_content);

	}
	
	function visa_booking()
	{
		require_once(APPPATH."libraries/ip2location/IP2Location.php");
		$loc = new IP2Location(FCPATH . '/application/libraries/ip2location/databases/IP-COUNTRY-SAMPLE.BIN', IP2Location::FILE_IO);
		
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Visa Bookings" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task	= $this->util->value($this->input->post("task"), "cancel");
		$ids	= $this->util->value($this->input->post("cid"), array());
		
		foreach ($ids as $id) {
			if ($task == "remove") {
				$this->m_visa_booking->delete(array ("id" => $id));
				$this->m_visa_booking->delete_traveller(array ("book_id" => $id));
			} else if ($task == "paid") {
				$data = array ("status" => 1);
				$where = array ("id" => $id);
				$this->m_visa_booking->update($data, $where);
			} else if ($task == "unpaid") {
				$data = array ("status" => 0);
				$where = array ("id" => $id);
				$this->m_visa_booking->update($data, $where);
			}
		}
		
		$sortby  				= $this->util->value($this->input->post("sortby"), "booking_date");
		$orderby 				= $this->util->value($this->input->post("orderby"), "DESC");
		$original_search_text	= $this->util->value($this->input->post("search_text"), "");
		$search_visa_type		= $this->util->value($this->input->post("search_visa_type"), "");
		$search_visit_purpose	= $this->util->value($this->input->post("search_visit_purpose"), "");
		$search_country  		= $this->util->value($this->input->post("search_country"), "");
		$fromdate				= $this->util->value($this->input->post("fromdate"), date("Y-m-d"));
		$todate					= $this->util->value($this->input->post("todate"), date("Y-m-d"));
		
		$search_text = strtoupper(trim($original_search_text));
		$search_text = str_replace(array(BOOKING_PREFIX), "", $search_text);
		
		if (!empty($search_text)) {
			$fromdate = "";
			$todate = "";
		}
		
		if (!empty($fromdate)) {
			$fromdate = date("Y-m-d", strtotime($fromdate));
		}
		if (!empty($todate)) {
			$todate = date("Y-m-d", strtotime($todate));
		}
		
		$info = new stdClass();
		$info->search_text		= $search_text;
		if (!empty($search_visa_type)) {
			$info->visa_type	= $this->m_visa_type->load($search_visa_type)->name;
		}
		$info->visit_purpose	= $search_visit_purpose;
		$info->fromdate			= $fromdate;
		$info->todate			= $todate;
		$info->sortby			= $sortby;
		$info->orderby			= $orderby;
		
		$pre_items = $this->m_visa_booking->bookings($info);
		
		$countries = array();
		foreach ($pre_items as $item) {
			if (!empty($item->client_ip)) {
				$country_code = $loc->lookup($item->client_ip, IP2Location::COUNTRY_CODE);
				$country_name = $loc->lookup($item->client_ip, IP2Location::COUNTRY_NAME);
				$country_flag = ADMIN_IMG_URL.'flags/'.strtolower($country_code).'.png';
				if ($country_code == '-') {
					$country_flag = ADMIN_IMG_URL.'flags/default.png';
				}
				$item->country_name = ucwords(strtolower($country_name));
				$item->country_flag = $country_flag;
				if ($item->status) {
					if (array_key_exists($item->country_name, $countries)) {
						$countries[$item->country_name] += 1;
					} else {
						$countries[$item->country_name] = 1;
					}
				}
			}
		}
		ksort($countries);
		
		$items = array();
		
		$sum_vs = 0;
		$sum_px = 0;
		$sum_op = 0;
		$sum_pp = 0;
		$sum_gs = 0;
		
		$sum_pr = 0;
		$sum_fp = 0;
		$sum_fc = 0;
		$sum_cr = 0;
		$sum_cp = 0;
		$sum_rf = 0;
		$sum_st = 0;

		$sum_voa = 0;
		$sum_vev = 0;
		
		foreach ($pre_items as $item) {
			if (!empty($search_country) && $search_country != $item->country_name) {
				continue;
			}
			$items[] = $item;
			if ($item->status == 1) {
				$sum_vs += 1;
				$sum_px += $item->group_size;
				
				if ($item->private_visa) {
					$sum_pr ++;
				}
				if ($item->full_package) {
					$sum_fp ++;
				}
				if ($item->fast_checkin) {
					$sum_fc ++;
				}
				if ($item->car_pickup) {
					$sum_cr ++;
				}
				if ($item->full_package || $item->rush_type == 3) {
					$sum_st += ($item->stamp_fee * $item->group_size);
				}
				if ($item->payment_method == "OnePay") {
					$sum_op += $item->total_fee;
				} else if ($item->payment_method == "Paypal") {
					$sum_pp += $item->total_fee;
				} else if ($item->payment_method == "Credit Card") {
					$sum_gs += $item->total_fee;
				}
				if ($item->refund != $item->total_fee) {
					$sum_cp += $item->capital;
				}
				$sum_rf += $item->refund;

				if($item->booking_type_id == 1) {
					$sum_voa++;
				} else {
					$sum_vev++;
				}
			}
		}
		
		$page = (!empty($_GET["page"]) ? max($_GET["page"], 1) : 1);
		$pagination = $this->util->pagination(site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}"), sizeof($items), ADMIN_ROW_PER_PAGE);
		
		$view_data = array();
		$view_data["task"]					= $task;
		$view_data["sortby"]				= $sortby;
		$view_data["orderby"]				= $orderby;
		$view_data["search_text"]			= $original_search_text;
		$view_data["edited_search_text"]	= $search_text;
		$view_data["search_visa_type"]		= $search_visa_type;
		$view_data["search_visit_purpose"]	= $search_visit_purpose;
		$view_data["search_country"]		= $search_country;
		$view_data["fromdate"]				= $fromdate;
		$view_data["todate"]				= $todate;
		$view_data["items"]					= $items;
		$view_data["sum_vs"]				= $sum_vs;
		$view_data["sum_px"]				= $sum_px;
		$view_data["sum_op"]				= $sum_op;
		$view_data["sum_pp"]				= $sum_pp;
		$view_data["sum_gs"]				= $sum_gs;
		$view_data["sum_pr"]				= $sum_pr;
		$view_data["sum_fp"]				= $sum_fp;
		$view_data["sum_fc"]				= $sum_fc;
		$view_data["sum_cr"]				= $sum_cr;
		$view_data["sum_cp"]				= $sum_cp;
		$view_data["sum_rf"]				= $sum_rf;
		$view_data["sum_st"]				= $sum_st;
		$view_data["breadcrumb"]			= $this->_breadcrumb;
		$view_data["page"]					= $page;
		$view_data["pagination"]			= $pagination;
		$view_data["all_countries"]			= $countries;
		$view_data["sum_voa"]				= $sum_voa;
		$view_data["sum_vev"]				= $sum_vev;
		
		$booking_ids = array();
		for ($idx = (($page - 1) * ADMIN_ROW_PER_PAGE); $idx < sizeof($items) && $idx < ($page * ADMIN_ROW_PER_PAGE); $idx++) {
			$booking_ids[] = $items[$idx]->id;
		}
		if (sizeof($booking_ids)) {
			$view_data["paxs"] = $this->m_visa_booking->booking_travelers($booking_ids);
		} else {
			$view_data["paxs"] = array();
		}
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/report/visa_booking", $view_data, TRUE);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	
	function ajax_get_booking_download_files()
	{
		$user_id	= $this->input->post("user_id");
		$id			= $this->input->post("id");
		$field		= $this->input->post("field");
		
		$path  = "./files/upload/".BOOKING_PREFIX."/{$field}/{$user_id}/approval/{$id}/";
		$fields = array("path" => $path, "agent" => CDN_AGENT_ID);
		$curl = curl_init(CDN_URL."/cdn/browse/letter.html");
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
		$data = curl_exec($curl);
		curl_close($curl);
		
		if (!empty($data)) {
			$files = explode(",", $data);
			foreach ($files as $file) {
				$path_parts = pathinfo($file);
				$extension  = array("psb","bmp","rle","dib","gif","eps","iff","tdi","jpg","jpeg","jpe","jpf","jpx","jp2","j2c","j2k","jpc","jps","mpo","pcx","raw","pxr","png","pns","pbm"); 
			?>
				<a class="file select" target="_blank" href="<?=$file?>" title="<?=$path_parts["basename"]?>">	
			<?	if (in_array($path_parts['extension'], $extension)) { ?>
					<div class="thumb" style="background-image: url('/files/upload/user/<?=$item->user_id?>/approval/<?=$item->id?>/<?=$path_parts["basename"]?>')"></div>	
			<?  } else { ?>	
					<div class="thumb" style="background-image: url('/files/themes/default/img/files/big/<?=$path_parts['extension']?>.png')"></div>
			<?  } ?>
				<div class="name"><?=$path_parts["basename"]?></div></a>
			<?
			}
			?>
			<script>$(".fa-attachment-<?=$id?>").show();</script>
			<?
		} else {
			echo "<p>No file exist.</p>";
			?>
			<script>$(".fa-attachment-<?=$id?>").hide();</script>
			<?
		}
	}
	
	function ajax_mkdir()
	{
		$user_path = $_POST["user_path"];
		$path = "./files/upload/user/".$user_path;
		
		if (!file_exists($path)) {
		   mkdir($path, 0775, TRUE);
		}
		echo "";
	}
	
	function remove_empty_dir()
	{
		$path = "./files/upload/user/";
		
		if (file_exists($path)) {
			$user_files = scandir($path);
			
			$cnt = 0;
			foreach ($user_files as $user_file) {
				if (in_array($user_file, array(".","..")) || !is_dir($path.$user_file)) continue;
				
				$nfile = 0;
				
				$approval_path = $path.$user_file."/approval/";
				$bookings = scandir($approval_path);
				
				foreach ($bookings as $booking) {
					if (in_array($booking, array(".","..")) || !is_dir($approval_path.$booking)) continue;
					
					$booking_path = $path.$user_file."/approval/".$booking;
					$files = scandir($booking_path);
					
					foreach ($files as $file) {
						if (in_array($file, array(".",".."))) continue;
						$nfile++;
					}
				}
				
				if (!$nfile && !empty($user_file)) {
					echo ++$cnt .". ". $user_file."<br/>";
				}
			}
		}
	}
	
	function remove_all_user_dir()
	{
		$path = "./files/upload/user/";
		
		if (file_exists($path)) {
			$user_files = scandir($path);
			
			$cnt = 0;
			foreach ($user_files as $user_file) {
				if (in_array($user_file, array(".","..")) || !is_dir($path.$user_file)) continue;
				if (!empty($user_file)) {
					$this->rrmdir($path.$user_file);
					echo ++$cnt .". ". $user_file."<br/>";
				}
			}
		}
	}
	
	function rrmdir($dir)
	{
		if (is_dir($dir)) {
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if (filetype($dir."/".$object) == "dir") $this->rrmdir($dir."/".$object); else unlink($dir."/".$object);
				}
			}
			reset($objects);
			rmdir($dir);
		}
	}
	
	function ajax_visa_booking_capital()
	{
		$booking_id = $this->input->post("booking_id");
		$capital = $this->input->post("capital");
		
		$data  = array(
			"capital" => $capital
		);
		$where = array(
			"id" => $booking_id
		);
		
		$this->m_visa_booking->update($data, $where);
		
		echo "";
	}
	
	function ajax_visa_booking_refund()
	{
		$booking_id = $this->input->post("booking_id");
		$refund = $this->input->post("refund");
		
		$data  = array(
			"refund" => $refund
		);
		$where = array(
			"id" => $booking_id
		);
		
		$this->m_visa_booking->update($data, $where);
		
		echo "";
	}
	
	function ajax_visa_payment_status()
	{
		$booking_id = $this->input->post("booking_id");
		$status_id = $this->input->post("status_id");
		
		$booking = $this->m_visa_booking->load($booking_id);
		$user = $this->m_user->load($booking->user_id);
		if ($status_id == '1') {
			$this->m_user->update(array('amount' => $user->amount+$booking->total_fee), array('id' => $booking->user_id));
		} else {
			$this->m_user->update(array('amount' => $user->amount-$booking->total_fee), array('id' => $booking->user_id));
		}
		////////////////////////////////////////////////////
		$agents = $this->m_agents->items();

		$info = new stdClass();
		$info->id = $booking->id;
		$booking_pax = $this->m_visa_booking->get_visa_bookings($info);
		$c_booking_pax = count($booking_pax);
		////////////////////////////////////////////////////
		if (((date('Y-m-d',strtotime($booking->arrival_date)) >= date('Y-m-d',strtotime($booking->booking_date))) && (date('Y-m-d',strtotime($booking->arrival_date)) <= date('Y-m-d',strtotime("{$booking->booking_date} + 2days"))) && ($booking->fast_checkin == 1)) ||
			((date('Y-m-d',strtotime($booking->arrival_date)) >= date('Y-m-d',strtotime($booking->booking_date))) && (date('Y-m-d',strtotime($booking->arrival_date)) <= date('Y-m-d',strtotime("{$booking->booking_date} + 2days"))) && ($booking->car_pickup == 1)) ||
			((date('Y-m-d',strtotime($booking->arrival_date)) >= date('Y-m-d',strtotime($booking->booking_date))) && (date('Y-m-d',strtotime($booking->arrival_date)) <= date('Y-m-d',strtotime("{$booking->booking_date} + 2days"))) && ($booking->full_package == 1))){
			$arr_agents = array();
			$agents_id = 1;
			foreach ($agents as $agent) {
				$arr_port = explode(',',$agent->arr_port);
				$arr_port_pickup = explode(',',$agent->arr_port_pickup);
				$info = new stdClass();
				$info->agents_id = $agent->id;
				$info->send_approved = 1;
				$info->fromdate = date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), date('d'), date('Y')));
				$info->todate 	= date('Y-m-d H:i:s', mktime(date('H'), date('i'), 59, date('m'), date('d'), date('Y')));
				$paxs = $this->m_visa_booking->get_visa_bookings($info);
				$qty = $c_booking_pax + count($paxs);
				if ($booking->fast_checkin == 1 || $booking->car_pickup == 1 || $booking->full_package == 1) {
					if ($qty <= $agent->qty && in_array($booking->arrival_port, $arr_port_pickup) && in_array($booking->arrival_port, $arr_port))
						array_push($arr_agents, $agent);
					elseif (in_array($booking->arrival_port, $arr_port_pickup) && in_array($booking->arrival_port, $arr_port))
						$agents_id = $agent->id;
				} else {
					if ($qty <= $agent->qty && in_array($booking->arrival_port, $arr_port))
						array_push($arr_agents, $agent);
					elseif (in_array($booking->arrival_port, $arr_port))
						$agents_id = $agent->id;
				}
			}

			foreach ($booking_pax as $value) {
				$min_fee = 100000;
				$type = '';
				switch ($value->visit_purpose) {
					case 'For tourist':
						$type .= 'tourist_';
						break;
					case 'For business':
						$type .= 'business_';
						break;
				}
				switch ($value->visa_type) {
					case '1 month single':
						$type .= '1ms';
						break;
					case '1 month multiple':
						$type .= '1mm';
						break;
					case '3 months single':
						$type .= '3ms';
						break;
					case '3 months multiple':
						$type .= '3mm';
						break;
					case '6 months multiple':
						$type .= '6mm';
						break;
					case '1 year multiple':
						$type .= '1ym';
						break;
				}
				//
				switch ($value->rush_type) {
					case '0':
						$processing = '';
						break;
					case '1':
						if ($value->visit_purpose == 'For tourist')
							$processing = $type.'_4h';
						elseif ($value->visit_purpose == 'For business')
							$processing = $type.'_8h';
						break;
					case '2':
						$processing = $type.'_1h';
						break;
					case '3':
						$processing = $type.'_dng';
						break;
				}
				foreach ($arr_agents as $arr_agent) {
					$arr_port = explode(',',$arr_agent->arr_port);
					$total_fee = 0;
					$err = 0;
					// add visa fee
					$info = new stdClass();
					$info->nation_id = $value->nation_id;
					$info->agents_id = $arr_agent->id;
					$visa_fee = $this->m_agent_visa_fee->items($info);
					$total_fee += $visa_fee[0]->{$type};
					if (empty($visa_fee[0]->{$type})) {
						$err++;
					}
					// add processing fee
					if (!empty($processing)) {
						$processing_fee = $this->m_agent_processing_fee->item($arr_agent->id,$value->nation_type);
						$total_fee += $processing_fee->{$processing};
						if (empty($processing_fee->{$processing})) {
							$err++;
						}
					}
					// add private letter fee
					if (!empty($value->private_visa)) {
						$info = new stdClass();
						$info->agents_id = $arr_agent->id;
						$private_letter_fee = $this->m_agent_private_letter_fee->items($info);
						$total_fee += $private_letter_fee[0]->{$type};
						if (empty($private_letter_fee[0]->{$type})) {
							$err++;
						}
					}
					// add fast checkin fee
					if (!empty($value->full_package)) {
						$info = new stdClass();
						$info->airport = $value->airport_id;
						$info->agents_id = $arr_agent->id;
						$agent_fast_checkin_fee = $this->m_agent_fast_checkin_fee->items($info);
						$total_fee += $agent_fast_checkin_fee[0]->fc;

					} else {
						if (!empty($value->fast_checkin)) {
							$info = new stdClass();
							$info->airport = $value->airport_id;
							$info->agents_id = $arr_agent->id;
							$agent_fast_checkin_fee = $this->m_agent_fast_checkin_fee->items($info);
							$total_fee += $agent_fast_checkin_fee[0]->fc;
							if (empty($agent_fast_checkin_fee[0]->fc)) {
								$err++;
							}
						}
					}
					// add car fee
					if (!empty($value->car_pickup)) {
						$seats = "seat_{$value->seats}";
						$info = new stdClass();
						$info->airport = $value->airport_id;
						$info->agents_id = $arr_agent->id;
						$agent_car_fee = $this->m_agent_car_fee->items($info);
						$total_fee += $agent_car_fee[0]->{$seats};
						if (empty($agent_car_fee[0]->{$seats})) {
							$err++;
						}
					}
					// add total fee
					if ($total_fee < $min_fee) {
						if ($err == 0) {
							$min_fee = $total_fee;
							$agents_id = $arr_agent->id;
						}
					}
				}
				$this->m_visa_pax->update(array("agents_id"=>$agents_id,"agents_fc_id"=>$agents_id),array("id" => $value->pax_id));
			}
		} else {

			$arr_agents = array();
			$arr_agents_fc = array();
			$agents_id = 1;
			$agents_fc_id = 1;
			foreach ($agents as $agent) {
				$arr_port = explode(',',$agent->arr_port);
				$arr_port_pickup = explode(',',$agent->arr_port_pickup);
				$info = new stdClass();
				$info->agents_id = $agent->id;
				$info->send_approved = 1;
				$info->fromdate = date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), date('d'), date('Y')));
				$info->todate 	= date('Y-m-d H:i:s', mktime(date('H'), date('i'), 59, date('m'), date('d'), date('Y')));
				$paxs = $this->m_visa_booking->get_visa_bookings($info);
				$qty = $c_booking_pax + count($paxs);
				if ($booking->fast_checkin == 1 || $booking->car_pickup == 1 || $booking->full_package == 1) {
					if ($qty <= $agent->qty && in_array($booking->arrival_port, $arr_port_pickup) && in_array($booking->arrival_port, $arr_port))
						array_push($arr_agents, $agent);
					elseif (in_array($booking->arrival_port, $arr_port_pickup) && in_array($booking->arrival_port, $arr_port))
						$agents_id = $agent->id;
				} else {
					if ($qty <= $agent->qty && in_array($booking->arrival_port, $arr_port))
						array_push($arr_agents, $agent);
					elseif (in_array($booking->arrival_port, $arr_port))
						$agents_id = $agent->id;
				}
				//
				$info = new stdClass();
				$info->agents_id = $agent->id;
				$info->send_pickup = 1;
				$info->from_arrival_date = date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), date('d'), date('Y')));
				$info->to_arrival_date 	= date('Y-m-d H:i:s', mktime(date('H'), date('i'), 59, date('m',strtotime("+ 2days")), date('d',strtotime("+ 2days")), date('Y',strtotime("+ 2days"))));
				$fc_paxs = $this->m_visa_booking->get_visa_bookings($info);
				$qty_fc = $c_booking_pax + count($fc_paxs);
				if ($qty_fc <= $agent->qty_fc && in_array($booking->arrival_port, $arr_port_pickup))
					array_push($arr_agents_fc, $agent);
				elseif (in_array($booking->arrival_port, $arr_port_pickup))
					$arr_agents_fc = $agent->id;
			}

			foreach ($booking_pax as $value) {
				$min_fee = 100000;
				$min_fc_fee = 100000;
				$type = '';
				switch ($value->visit_purpose) {
					case 'For tourist':
						$type .= 'tourist_';
						break;
					case 'For business':
						$type .= 'business_';
						break;
				}
				switch ($value->booking_type_id) {
					case '1':
						$type .= '1ms';
						break;
					case '2':
						$type .= '1mm';
						break;
					case '3':
						$type .= '3ms';
						break;
					case '4':
						$type .= '3mm';
						break;
					case '5':
						$type .= '6mm';
						break;
					case '6':
						$type .= '1ym';
						break;
				}
				//
				switch ($value->rush_type) {
					case '0':
						$processing = '';
						break;
					case '1':
						if ($value->visit_purpose == 'For tourist')
							$processing = $type.'_4h';
						elseif ($value->visit_purpose == 'For business')
							$processing = $type.'_8h';
						break;
					case '2':
						$processing = $type.'_1h';
						break;
					case '3':
						$processing = $type.'_dng';
						break;
				}
				foreach ($arr_agents as $arr_agent) {
					$arr_port = explode(',',$arr_agent->arr_port);
					$total_fee = 0;
					$err = 0;
					// add visa fee
					$info = new stdClass();
					$info->nation_id = $value->nation_id;
					$info->agents_id = $arr_agent->id;
					$visa_fee = $this->m_agent_visa_fee->items($info);
					$total_fee += $visa_fee[0]->{$type};
					if (empty($visa_fee[0]->{$type})) {
						$err++;
					}
					// add processing fee
					if (!empty($processing)) {
						$processing_fee = $this->m_agent_processing_fee->item($arr_agent->id,$value->nation_type);
						$total_fee += $processing_fee->{$processing};
						if (empty($processing_fee->{$processing})) {
							$err++;
						}
					}
					// add private letter fee
					if (!empty($value->private_visa)) {
						$info = new stdClass();
						$info->agents_id = $arr_agent->id;
						$private_letter_fee = $this->m_agent_private_letter_fee->items($info);
						$total_fee += $private_letter_fee[0]->{$type};
						if (empty($private_letter_fee[0]->{$type})) {
							$err++;
						}
					}
					// add total fee
					if ($total_fee < $min_fee) {
						if ($err == 0) {
							$min_fee = $total_fee;
							$agents_id = $arr_agent->id;
						}
					}
				}
				foreach ($arr_agents_fc as $arr_agent_fc) {
					$arr_port = explode(',',$arr_agent_fc->arr_port);
					$total_fc_fee = 0;
					$err = 0;
					// add fast checkin fee
					if (!empty($value->full_package)) {
						$info = new stdClass();
						$info->airport = $value->airport_id;
						$info->agents_id = $arr_agent_fc->id;
						$agent_fast_checkin_fee = $this->m_agent_fast_checkin_fee->items($info);
						$total_fc_fee += $agent_fast_checkin_fee[0]->fc;

					} else {
						if (!empty($value->fast_checkin)) {
							$info = new stdClass();
							$info->airport = $value->airport_id;
							$info->agents_id = $arr_agent_fc->id;
							$agent_fast_checkin_fee = $this->m_agent_fast_checkin_fee->items($info);
							$total_fc_fee += $agent_fast_checkin_fee[0]->fc;
							if (empty($agent_fast_checkin_fee[0]->fc)) {
								$err++;
							}
						}
					}
					// add car fee
					if (!empty($value->car_pickup)) {
						$seats = "seat_{$value->seats}";
						$info = new stdClass();
						$info->airport = $value->airport_id;
						$info->agents_id = $arr_agent_fc->id;
						$agent_car_fee = $this->m_agent_car_fee->items($info);
						$total_fc_fee += $agent_car_fee[0]->{$seats};
						if (empty($agent_car_fee[0]->{$seats})) {
							$err++;
						}
					}
					// add total fee
					if ($total_fc_fee < $min_fc_fee) {
						if ($err == 0) {
							$min_fc_fee = $total_fc_fee;
							$agents_fc_id = $arr_agent_fc->id;
						}
					}

				}
				$this->m_visa_pax->update(array("agents_id"=>$agents_id,"agents_fc_id"=>$agents_fc_id),array("id" => $value->pax_id));
			}
		}
		////////////////////////////////////////////////////

		// $info = new stdClass();
		// $info->email = $booking->primary_email;
		// $info->created_date = date('Y-m-d',strtotime($booking->booking_date));

		// $step_item = $this->m_check_step->items($info);
		// if ($status_id == '1') {
		// 	$status = 'paid';
		// 	$send_mail = 2;
		// } else {
		// 	$status = 'unpaid';
		// 	$send_mail = 1;
		// }
		// $this->m_check_step->update(array("status" => $status, "send_mail" => $send_mail), array("id" => $step_item[0]->id));

		$data  = array(
			"status" => $status_id
		);
		if ($status_id) {
			$data["paid_date"] = date($this->config->item("log_date_format"));
		}
		$where = array(
			"id" => $booking_id
		);
		
		$this->m_visa_booking->update($data, $where);
		echo "";
	}
	
	function ajax_visa_other_payment()
	{
		$booking_id = $this->input->post("booking_id");
		$status_id = $this->input->post("status_id");
		// $email = $this->input->post("email");

		// $info = new stdClass();
		// $info->email= $email;
		// $check_steps = $this->m_check_step->items($info);
		// foreach ($check_steps as $check_step) {
		// 	if ((int)$status_id == 1) {
		// 		$this->m_check_step->update(array("status" => 'paid',"send_mail" => 2), array("id" => $check_step->id));
		// 	} else {
		// 		$this->m_check_step->update(array("status" => 'unpaid',"send_mail" => 1), array("id" => $check_step->id));
		// 	}
		// }
		////////////////////////////////////////////////////
		$booking = $this->m_visa_booking->load($booking_id);
		$user = $this->m_user->load($booking->user_id);
		if ($status_id == '1') {
			$this->m_user->update(array('amount' => $user->amount+$booking->total_fee), array('id' => $booking->user_id));
		} else {
			$this->m_user->update(array('amount' => $user->amount-$booking->total_fee), array('id' => $booking->user_id));
		}
		$agents = $this->m_agents->items();

		$info = new stdClass();
		$info->id = $booking->id;
		$booking_pax = $this->m_visa_booking->get_visa_bookings($info);
		$c_booking_pax = count($booking_pax);
		////////////////////////////////////////////////////
		if (((date('Y-m-d',strtotime($booking->arrival_date)) >= date('Y-m-d',strtotime($booking->booking_date))) && (date('Y-m-d',strtotime($booking->arrival_date)) <= date('Y-m-d',strtotime("{$booking->booking_date} + 2days"))) && ($booking->fast_checkin == 1)) ||
			((date('Y-m-d',strtotime($booking->arrival_date)) >= date('Y-m-d',strtotime($booking->booking_date))) && (date('Y-m-d',strtotime($booking->arrival_date)) <= date('Y-m-d',strtotime("{$booking->booking_date} + 2days"))) && ($booking->car_pickup == 1)) ||
			((date('Y-m-d',strtotime($booking->arrival_date)) >= date('Y-m-d',strtotime($booking->booking_date))) && (date('Y-m-d',strtotime($booking->arrival_date)) <= date('Y-m-d',strtotime("{$booking->booking_date} + 2days"))) && ($booking->full_package == 1))){
			$arr_agents = array();
			$agents_id = 1;
			foreach ($agents as $agent) {
				$arr_port = explode(',',$agent->arr_port);
				$arr_port_pickup = explode(',',$agent->arr_port_pickup);
				$info = new stdClass();
				$info->agents_id = $agent->id;
				$info->send_approved = 1;
				$info->fromdate = date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), date('d'), date('Y')));
				$info->todate 	= date('Y-m-d H:i:s', mktime(date('H'), date('i'), 59, date('m'), date('d'), date('Y')));
				$paxs = $this->m_visa_booking->get_visa_bookings($info);
				$qty = $c_booking_pax + count($paxs);
				if ($booking->fast_checkin == 1 || $booking->car_pickup == 1 || $booking->full_package == 1) {
					if ($qty <= $agent->qty && in_array($booking->arrival_port, $arr_port_pickup) && in_array($booking->arrival_port, $arr_port))
						array_push($arr_agents, $agent);
					elseif (in_array($booking->arrival_port, $arr_port_pickup) && in_array($booking->arrival_port, $arr_port))
						$agents_id = $agent->id;
				} else {
					if ($qty <= $agent->qty && in_array($booking->arrival_port, $arr_port))
						array_push($arr_agents, $agent);
					elseif (in_array($booking->arrival_port, $arr_port))
						$agents_id = $agent->id;
				}
			}

			foreach ($booking_pax as $value) {
				$min_fee = 100000;
				$type = '';
				switch ($value->visit_purpose) {
					case 'For tourist':
						$type .= 'tourist_';
						break;
					case 'For business':
						$type .= 'business_';
						break;
				}
				switch ($value->visa_type) {
					case '1 month single':
						$type .= '1ms';
						break;
					case '1 month multiple':
						$type .= '1mm';
						break;
					case '3 months single':
						$type .= '3ms';
						break;
					case '3 months multiple':
						$type .= '3mm';
						break;
					case '6 months multiple':
						$type .= '6mm';
						break;
					case '1 year multiple':
						$type .= '1ym';
						break;
				}
				//
				switch ($value->rush_type) {
					case '0':
						$processing = '';
						break;
					case '1':
						if ($value->visit_purpose == 'For tourist')
							$processing = $type.'_4h';
						elseif ($value->visit_purpose == 'For business')
							$processing = $type.'_8h';
						break;
					case '2':
						$processing = $type.'_1h';
						break;
					case '3':
						$processing = $type.'_dng';
						break;
				}
				foreach ($arr_agents as $arr_agent) {
					$arr_port = explode(',',$arr_agent->arr_port);
					$total_fee = 0;
					$err = 0;
					// add visa fee
					$info = new stdClass();
					$info->nation_id = $value->nation_id;
					$info->agents_id = $arr_agent->id;
					$visa_fee = $this->m_agent_visa_fee->items($info);
					$total_fee += $visa_fee[0]->{$type};
					if (empty($visa_fee[0]->{$type})) {
						$err++;
					}
					// add processing fee
					if (!empty($processing)) {
						$processing_fee = $this->m_agent_processing_fee->item($arr_agent->id,$value->nation_type);
						$total_fee += $processing_fee->{$processing};
						if (empty($processing_fee->{$processing})) {
							$err++;
						}
					}
					// add private letter fee
					if (!empty($value->private_visa)) {
						$info = new stdClass();
						$info->agents_id = $arr_agent->id;
						$private_letter_fee = $this->m_agent_private_letter_fee->items($info);
						$total_fee += $private_letter_fee[0]->{$type};
						if (empty($private_letter_fee[0]->{$type})) {
							$err++;
						}
					}
					// add fast checkin fee
					if (!empty($value->full_package)) {
						$info = new stdClass();
						$info->airport = $value->airport_id;
						$info->agents_id = $arr_agent->id;
						$agent_fast_checkin_fee = $this->m_agent_fast_checkin_fee->items($info);
						$total_fee += $agent_fast_checkin_fee[0]->fc;

					} else {
						if (!empty($value->fast_checkin)) {
							$info = new stdClass();
							$info->airport = $value->airport_id;
							$info->agents_id = $arr_agent->id;
							$agent_fast_checkin_fee = $this->m_agent_fast_checkin_fee->items($info);
							$total_fee += $agent_fast_checkin_fee[0]->fc;
							if (empty($agent_fast_checkin_fee[0]->fc)) {
								$err++;
							}
						}
					}
					// add car fee
					if (!empty($value->car_pickup)) {
						$seats = "seat_{$value->seats}";
						$info = new stdClass();
						$info->airport = $value->airport_id;
						$info->agents_id = $arr_agent->id;
						$agent_car_fee = $this->m_agent_car_fee->items($info);
						$total_fee += $agent_car_fee[0]->{$seats};
						if (empty($agent_car_fee[0]->{$seats})) {
							$err++;
						}
					}
					// add total fee
					if ($total_fee < $min_fee) {
						if ($err == 0) {
							$min_fee = $total_fee;
							$agents_id = $arr_agent->id;
						}
					}
				}
				if ($value->booking_type_id == 1) {
					$this->m_visa_pax->update(array("agents_id"=>$agents_id,"agents_fc_id"=>$agents_id),array("id" => $value->pax_id));
				} else if ($value->booking_type_id == 2) {
					$this->m_visa_pax->update(array("agents_id"=> 4,"agents_fc_id"=> 4),array("id" => $value->pax_id));
				}
				
			}
		} else {

			$arr_agents = array();
			$arr_agents_fc = array();
			$agents_id = 1;
			$agents_fc_id = 1;
			foreach ($agents as $agent) {
				$arr_port = explode(',',$agent->arr_port);
				$arr_port_pickup = explode(',',$agent->arr_port_pickup);
				$info = new stdClass();
				$info->agents_id = $agent->id;
				$info->send_approved = 1;
				$info->fromdate = date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), date('d'), date('Y')));
				$info->todate 	= date('Y-m-d H:i:s', mktime(date('H'), date('i'), 59, date('m'), date('d'), date('Y')));
				$paxs = $this->m_visa_booking->get_visa_bookings($info);
				$qty = $c_booking_pax + count($paxs);
				if ($booking->fast_checkin == 1 || $booking->car_pickup == 1 || $booking->full_package == 1) {
					if ($qty <= $agent->qty && in_array($booking->arrival_port, $arr_port_pickup) && in_array($booking->arrival_port, $arr_port))
						array_push($arr_agents, $agent);
					elseif (in_array($booking->arrival_port, $arr_port_pickup) && in_array($booking->arrival_port, $arr_port))
						$agents_id = $agent->id;
				} else {
					if ($qty <= $agent->qty && in_array($booking->arrival_port, $arr_port))
						array_push($arr_agents, $agent);
					elseif (in_array($booking->arrival_port, $arr_port))
						$agents_id = $agent->id;
				}
				//
				$info = new stdClass();
				$info->agents_id = $agent->id;
				$info->send_pickup = 1;
				$info->from_arrival_date = date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), date('d'), date('Y')));
				$info->to_arrival_date 	= date('Y-m-d H:i:s', mktime(date('H'), date('i'), 59, date('m',strtotime("+ 2days")), date('d',strtotime("+ 2days")), date('Y',strtotime("+ 2days"))));
				$fc_paxs = $this->m_visa_booking->get_visa_bookings($info);
				$qty_fc = $c_booking_pax + count($fc_paxs);
				if ($qty_fc <= $agent->qty_fc && in_array($booking->arrival_port, $arr_port_pickup))
					array_push($arr_agents_fc, $agent);
				elseif (in_array($booking->arrival_port, $arr_port_pickup))
					$arr_agents_fc = $agent->id;
			}

			foreach ($booking_pax as $value) {
				$min_fee = 100000;
				$min_fc_fee = 100000;
				$type = '';
				switch ($value->visit_purpose) {
					case 'For tourist':
						$type .= 'tourist_';
						break;
					case 'For business':
						$type .= 'business_';
						break;
				}
				switch ($value->booking_type_id) {
					case '1':
						$type .= '1ms';
						break;
					case '2':
						$type .= '1mm';
						break;
					case '3':
						$type .= '3ms';
						break;
					case '4':
						$type .= '3mm';
						break;
					case '5':
						$type .= '6mm';
						break;
					case '6':
						$type .= '1ym';
						break;
				}
				//
				switch ($value->rush_type) {
					case '0':
						$processing = '';
						break;
					case '1':
						if ($value->visit_purpose == 'For tourist')
							$processing = $type.'_4h';
						elseif ($value->visit_purpose == 'For business')
							$processing = $type.'_8h';
						break;
					case '2':
						$processing = $type.'_1h';
						break;
					case '3':
						$processing = $type.'_dng';
						break;
				}
				foreach ($arr_agents as $arr_agent) {
					$arr_port = explode(',',$arr_agent->arr_port);
					$total_fee = 0;
					$err = 0;
					// add visa fee
					$info = new stdClass();
					$info->nation_id = $value->nation_id;
					$info->agents_id = $arr_agent->id;
					$visa_fee = $this->m_agent_visa_fee->items($info);
					$total_fee += $visa_fee[0]->{$type};
					if (empty($visa_fee[0]->{$type})) {
						$err++;
					}
					// add processing fee
					if (!empty($processing)) {
						$processing_fee = $this->m_agent_processing_fee->item($arr_agent->id,$value->nation_type);
						$total_fee += $processing_fee->{$processing};
						if (empty($processing_fee->{$processing})) {
							$err++;
						}
					}
					// add private letter fee
					if (!empty($value->private_visa)) {
						$info = new stdClass();
						$info->agents_id = $arr_agent->id;
						$private_letter_fee = $this->m_agent_private_letter_fee->items($info);
						$total_fee += $private_letter_fee[0]->{$type};
						if (empty($private_letter_fee[0]->{$type})) {
							$err++;
						}
					}
					// add total fee
					if ($total_fee < $min_fee) {
						if ($err == 0) {
							$min_fee = $total_fee;
							$agents_id = $arr_agent->id;
						}
					}
				}
				foreach ($arr_agents_fc as $arr_agent_fc) {
					$arr_port = explode(',',$arr_agent_fc->arr_port);
					$total_fc_fee = 0;
					$err = 0;
					// add fast checkin fee
					if (!empty($value->full_package)) {
						$info = new stdClass();
						$info->airport = $value->airport_id;
						$info->agents_id = $arr_agent_fc->id;
						$agent_fast_checkin_fee = $this->m_agent_fast_checkin_fee->items($info);
						$total_fc_fee += $agent_fast_checkin_fee[0]->fc;

					} else {
						if (!empty($value->fast_checkin)) {
							$info = new stdClass();
							$info->airport = $value->airport_id;
							$info->agents_id = $arr_agent_fc->id;
							$agent_fast_checkin_fee = $this->m_agent_fast_checkin_fee->items($info);
							$total_fc_fee += $agent_fast_checkin_fee[0]->fc;
							if (empty($agent_fast_checkin_fee[0]->fc)) {
								$err++;
							}
						}
					}
					// add car fee
					if (!empty($value->car_pickup)) {
						$seats = "seat_{$value->seats}";
						$info = new stdClass();
						$info->airport = $value->airport_id;
						$info->agents_id = $arr_agent_fc->id;
						$agent_car_fee = $this->m_agent_car_fee->items($info);
						$total_fc_fee += $agent_car_fee[0]->{$seats};
						if (empty($agent_car_fee[0]->{$seats})) {
							$err++;
						}
					}
					// add total fee
					if ($total_fc_fee < $min_fc_fee) {
						if ($err == 0) {
							$min_fc_fee = $total_fc_fee;
							$agents_fc_id = $arr_agent_fc->id;
						}
					}

				}
				if ($value->booking_type_id == 1) {
					$this->m_visa_pax->update(array("agents_id"=>$agents_id,"agents_fc_id"=>$agents_fc_id),array("id" => $value->pax_id));
				} else if ($value->booking_type_id == 2) {
					$this->m_visa_pax->update(array("agents_id"=> 4,"agents_fc_id"=> 4),array("id" => $value->pax_id));
				}
			}
		}
		////////////////////////////////////////////////////
		
		$data  = array(
			"other_payment" => $status_id
		);
		if ($status_id) {
			$data["paid_date"] = date($this->config->item("log_date_format"));
		}
		$where = array(
			"id" => $booking_id
		);
		
		$this->m_visa_booking->update($data, $where);
		
		echo "";
	}
	
	function ajax_visa_booking_status()
	{
		$booking_id = $this->input->post("booking_id");
		$status_id = $this->input->post("status_id");
		
		$data  = array(
			"booking_status" => $status_id
		);
		$where = array(
			"id" => $booking_id
		);
		
		$this->m_visa_booking->update($data, $where);
		
		echo "";
	}
	
	function ajax_visa_options($action)
	{
		if ($action == "edit") {
			$booking_id = $this->input->post("id");
			$booking = $this->m_visa_booking->booking($booking_id);
			echo json_encode(array($booking->visa_type, $booking->visit_purpose, date('m/d/Y', strtotime($booking->arrival_date)), date('m/d/Y', strtotime($booking->exit_date)), $booking->arrival_port, $booking->flight_number, $booking->arrival_time, $booking->rush_type, $booking->private_visa, $booking->full_package, $booking->fast_checkin, ($booking->car_pickup ? $booking->seats : $booking->car_pickup)));
		}
		else if ($action == "update") {
			$data = array(
				"visa_type"		=> $this->input->post("visa_type"),
				"visit_purpose"	=> $this->input->post("visit_purpose"),
				"arrival_date"	=> date("Y-m-d", strtotime($this->input->post("arrival_date"))),
				//"exit_date"		=> date("Y-m-d", strtotime($this->input->post("exit_date"))),
				"arrival_port"	=> $this->input->post("arrival_port"),
				"flight_number"	=> $this->input->post("flight_number"),
				"arrival_time"	=> $this->input->post("arrival_time"),
				//"rush_type"		=> $this->input->post("rush_type"),
				//"private_visa"	=> $this->input->post("private_visa"),
				//"full_package"	=> $this->input->post("full_package"),
				//"fast_checkin"	=> (!empty($this->input->post("full_package"))?0:$this->input->post("fast_checkin")),
				//"car_pickup"	=> (!empty($this->input->post("car_pickup"))?1:0),
				//"seats"			=> (!empty($this->input->post("car_pickup"))?$this->input->post("car_pickup"):0)
			);
			$where = array(
				"id" => $this->input->post("id")
			);
			$this->m_visa_booking->update($data, $where);
		}
	}
	
	function ajax_visa_passport($action)
	{
		if ($action == "edit") {
			$id = $this->input->post("id");
			$pax = $this->m_visa_pax->load($id);
			echo json_encode(array($pax->fullname, $pax->gender, date('m/d/Y', strtotime($pax->birthday)), $pax->nationality, $pax->passport));
		}
		else if ($action == "update") {
			$data = array(
				"fullname"		=> $this->input->post("fullname"),
				"gender"		=> $this->input->post("gender"),
				"birthday"		=> date("Y-m-d", strtotime($this->input->post("birthday"))),
				"nationality"	=> $this->input->post("nationality"),
				"passport"		=> $this->input->post("passport")
			);
			$where = array(
				"id" => $this->input->post("id")
			);
			$this->m_visa_pax->update($data, $where);
		}
	}
	
	function ajax_visa_contact($action)
	{
		if ($action == "edit") {
			$booking_id = $this->input->post("id");
			$booking = $this->m_visa_booking->booking($booking_id);
			echo json_encode(array($booking->contact_title, $booking->contact_fullname, $booking->primary_email, $booking->secondary_email, $booking->contact_phone));
		}
		else if ($action == "update") {
			$data = array(
				"contact_title"		=> $this->input->post("contact_title"),
				"contact_fullname"	=> $this->input->post("contact_fullname"),
				"primary_email"		=> $this->input->post("primary_email"),
				"secondary_email"	=> $this->input->post("secondary_email"),
				"contact_phone"		=> $this->input->post("contact_phone")
			);
			$where = array(
				"id" => $this->input->post("id")
			);
			$this->m_visa_booking->update($data, $where);
		}
	}
	
	function service_booking()
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Service Bookings" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task	= $this->util->value($this->input->post("task"), "cancel");
		$ids	= $this->util->value($this->input->post("cid"), array());
		
		foreach ($ids as $id) {
			if ($task == "remove") {
				$this->m_service_booking->delete(array ("id" => $id));
			} else if ($task == "paid") {
				$data = array ("status" => 1);
				$where = array ("id" => $id);
				$this->m_service_booking->update($data, $where);
			} else if ($task == "unpaid") {
				$data = array ("status" => 0);
				$where = array ("id" => $id);
				$this->m_service_booking->update($data, $where);
			}
		}
		
		$sortby  				= $this->util->value($this->input->post("sortby"), "booking_date");
		$orderby 				= $this->util->value($this->input->post("orderby"), "DESC");
		$original_search_text	= $this->util->value($this->input->post("search_text"), "");
		$fromdate				= $this->util->value($this->input->post("fromdate"), date("Y-m-d"));
		$todate					= $this->util->value($this->input->post("todate"), date("Y-m-d"));
		
		$search_text = strtoupper(trim($original_search_text));
		$search_text = str_replace(array(BOOKING_PREFIX_EX), "", $search_text);
		
		if (!empty($search_text)) {
			$fromdate = "";
			$todate = "";
		}
		
		if (!empty($fromdate)) {
			$fromdate = date("Y-m-d", strtotime($fromdate));
		}
		if (!empty($todate)) {
			$todate = date("Y-m-d", strtotime($todate));
		}
		
		$info = new stdClass();
		$info->search_text		= $search_text;
		$info->fromdate			= $fromdate;
		$info->todate			= $todate;
		$info->sortby			= $sortby;
		$info->orderby			= $orderby;
		
		$total_items = $this->m_service_booking->total_bookings($info);
		
		$page = (!empty($_GET["page"]) ? max($_GET["page"], 1) : 1);
		$pagination = $this->util->pagination(site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}"), $total_items, ADMIN_ROW_PER_PAGE);
		
		$view_data = array();
		$view_data["task"]					= $task;
		$view_data["sortby"]				= $sortby;
		$view_data["orderby"]				= $orderby;
		$view_data["search_text"]			= $original_search_text;
		$view_data["edited_search_text"]	= $search_text;
		$view_data["fromdate"]				= $fromdate;
		$view_data["todate"]				= $todate;
		$view_data["items"]					= $this->m_service_booking->bookings($info, ADMIN_ROW_PER_PAGE, ($page - 1) * ADMIN_ROW_PER_PAGE);
		$view_data["breadcrumb"]			= $this->_breadcrumb;
		$view_data["page"]					= $page;
		$view_data["pagination"]			= $pagination;
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/report/service_booking", $view_data, TRUE);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	
	function ajax_service_booking_capital()
	{
		$booking_id = $this->input->post("booking_id");
		$capital = $this->input->post("capital");
		
		$data  = array(
			"capital" => $capital
		);
		$where = array(
			"id" => $booking_id
		);
		
		$this->m_service_booking->update($data, $where);
		
		echo "";
	}
	
	function ajax_service_booking_refund()
	{
		$booking_id = $this->input->post("booking_id");
		$refund = $this->input->post("refund");
		
		$data  = array(
			"refund" => $refund
		);
		$where = array(
			"id" => $booking_id
		);
		
		$this->m_service_booking->update($data, $where);
		
		echo "";
	}
	
	function ajax_service_payment_status()
	{
		$booking_id = $this->input->post("booking_id");
		$status_id = $this->input->post("status_id");
		
		$data  = array(
			"status" => $status_id
		);
		if ($status_id) {
			$data["paid_date"] = date($this->config->item("log_date_format"));
		}
		$where = array(
			"id" => $booking_id
		);
		
		$this->m_service_booking->update($data, $where);
		
		echo "";
	}
	
	function ajax_service_other_payment()
	{
		$booking_id = $this->input->post("booking_id");
		$status_id = $this->input->post("status_id");
		
		$data  = array(
			"other_payment" => $status_id
		);
		if ($status_id) {
			$data["paid_date"] = date($this->config->item("log_date_format"));
		}
		$where = array(
			"id" => $booking_id
		);
		
		$this->m_service_booking->update($data, $where);
		
		echo "";
	}
	
	function ajax_service_booking_status()
	{
		$booking_id = $this->input->post("booking_id");
		$status_id = $this->input->post("status_id");
		
		$data  = array(
			"booking_status" => $status_id
		);
		$where = array(
			"id" => $booking_id
		);
		
		$this->m_service_booking->update($data, $where);
		
		echo "";
	}
	
	function payment_online()
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Payment Online" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task	= $this->util->value($this->input->post("task"), "cancel");
		$ids	= $this->util->value($this->input->post("cid"), array());
		
		foreach ($ids as $id) {
			if ($task == "remove") {
				$this->m_payment->delete(array ("id" => $id));
			} else if ($task == "paid") {
				$data = array ("status" => 1);
				$where = array ("id" => $id);
				$this->m_payment->update($data, $where);
			} else if ($task == "unpaid") {
				$data = array ("status" => 0);
				$where = array ("id" => $id);
				$this->m_payment->update($data, $where);
			}
		}
		
		$sortby  				= $this->util->value($this->input->post("sortby"), "payment_date");
		$orderby 				= $this->util->value($this->input->post("orderby"), "DESC");
		$original_search_text	= $this->util->value($this->input->post("search_text"), "");
		$fromdate				= $this->util->value($this->input->post("fromdate"), date("Y-m-d"));
		$todate					= $this->util->value($this->input->post("todate"), date("Y-m-d"));
		
		$search_text = strtoupper(trim($original_search_text));
		$search_text = str_replace(array(BOOKING_PREFIX_PO), "", $search_text);
		
		if (!empty($search_text)) {
			$fromdate = "";
			$todate = "";
		}
		
		if (!empty($fromdate)) {
			$fromdate = date("Y-m-d", strtotime($fromdate));
		}
		if (!empty($todate)) {
			$todate = date("Y-m-d", strtotime($todate));
		}
		
		$info = new stdClass();
		$info->search_text		= $search_text;
		$info->fromdate			= $fromdate;
		$info->todate			= $todate;
		$info->sortby			= $sortby;
		$info->orderby			= $orderby;
		
		$total_items = $this->m_payment->total_items($info);
		
		$page = (!empty($_GET["page"]) ? max($_GET["page"], 1) : 1);
		$pagination = $this->util->pagination(site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}"), $total_items, ADMIN_ROW_PER_PAGE);
		
		$view_data = array();
		$view_data["task"]					= $task;
		$view_data["sortby"]				= $sortby;
		$view_data["orderby"]				= $orderby;
		$view_data["search_text"]			= $original_search_text;
		$view_data["edited_search_text"]	= $search_text;
		$view_data["fromdate"]				= $fromdate;
		$view_data["todate"]				= $todate;
		$view_data["items"]					= $this->m_payment->items($info, NULL, ADMIN_ROW_PER_PAGE, ($page - 1) * ADMIN_ROW_PER_PAGE);
		$view_data["breadcrumb"]			= $this->_breadcrumb;
		$view_data["page"]					= $page;
		$view_data["pagination"]			= $pagination;
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/report/payment_online", $view_data, TRUE);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	
	function ajax_payment_capital()
	{
		$payment_id = $this->input->post("payment_id");
		$capital = $this->input->post("capital");
		
		$data  = array(
			"capital" => $capital
		);
		$where = array(
			"id" => $payment_id
		);
		
		$this->m_payment->update($data, $where);
		
		echo "";
	}
	
	function ajax_payment_refund()
	{
		$payment_id = $this->input->post("payment_id");
		$refund = $this->input->post("refund");
		
		$data  = array(
			"refund" => $refund
		);
		$where = array(
			"id" => $payment_id
		);
		
		$this->m_payment->update($data, $where);
		
		echo "";
	}
	
	function ajax_payment_status()
	{
		$payment_id = $this->input->post("payment_id");
		$status_id = $this->input->post("status_id");
		
		$data  = array(
			"status" => $status_id
		);
		if ($status_id) {
			$data["paid_date"] = date($this->config->item("log_date_format"));
		}
		$where = array(
			"id" => $payment_id
		);
		
		$this->m_payment->update($data, $where);
		
		echo "";
	}
	
	function payment_report()
	{
		require_once(APPPATH."libraries/ip2location/IP2Location.php");
		$loc = new IP2Location(FCPATH . '/application/libraries/ip2location/databases/IP-COUNTRY-SAMPLE.BIN', IP2Location::FILE_IO);
		
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Payment Report" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task	= $this->util->value($this->input->post("task"), "cancel");
		
		$sortby  				= $this->util->value($this->input->post("sortby"), "booking_date");
		$orderby 				= $this->util->value($this->input->post("orderby"), "DESC");
		$original_search_text	= $this->util->value($this->input->post("search_text"), "");
		$search_payment_method	= $this->util->value($this->input->post("search_payment_method"), "");
		$search_country			= $this->util->value($this->input->post("search_country"), "");
		$fromdate				= $this->util->value($this->input->post("fromdate"), date("Y-m-d"));
		$todate					= $this->util->value($this->input->post("todate"), date("Y-m-d"));
		
		$search_text = strtoupper(trim($original_search_text));
		$search_text = str_replace(array(BOOKING_PREFIX), "", $search_text);
		
		if (!empty($search_text)) {
			$fromdate = "";
			$todate = "";
		}
		
		if (!empty($fromdate)) {
			$fromdate = date("Y-m-d", strtotime($fromdate));
		}
		if (!empty($todate)) {
			$todate = date("Y-m-d", strtotime($todate));
		}
		
		$info = new stdClass();
		$info->search_text		= $search_text;
		$info->payment_method	= $search_payment_method;
		$info->fromdate	= $fromdate;
		$info->todate		= $todate;
		$info->sortby			= $sortby;
		$info->orderby			= $orderby;
		
		$pre_items = $this->m_visa_booking->payments($info);
		
		$countries = array();
		foreach ($pre_items as $item) {
			if (!empty($item->client_ip)) {
				$country_code = $loc->lookup($item->client_ip, IP2Location::COUNTRY_CODE);
				$country_name = $loc->lookup($item->client_ip, IP2Location::COUNTRY_NAME);
				$country_flag = ADMIN_IMG_URL.'flags/'.strtolower($country_code).'.png';
				if ($country_code == '-') {
					$country_flag = ADMIN_IMG_URL.'flags/default.png';
				}
				$item->country_name = ucwords(strtolower($country_name));
				$item->country_flag = $country_flag;
				if ($item->status && ($item->payment_type == BOOKING_PREFIX)) {
					if (array_key_exists($item->country_name, $countries)) {
						$countries[$item->country_name] += 1;
					} else {
						$countries[$item->country_name] = 1;
					}
				}
			}
		}
		ksort($countries);
		
		$items = array();
		
		$sum_vs = 0;
		$sum_px = 0;
		$sum_op = 0;
		$sum_pp = 0;
		$sum_gs = 0;
		
		$sum_pr = 0;
		$sum_fp = 0;
		$sum_fc = 0;
		$sum_cr = 0;
		$sum_cp = 0;
		$sum_rf = 0;
		$sum_st = 0;
		$sum_vt = 0;

		// count devices
		//Desktop
		$sum_pc = 0;
		$sum_vs_pc = 0;
		$sum_cp_pc = 0;
		$sum_op_pc = 0;
		$sum_pp_pc = 0;
		$sum_gs_pc = 0;
		$captital_pc = 0;
		$sum_rf_pc = 0;
		$sum_vt_pc = 0;
		//Mobile
		$sum_mb = 0;
		$sum_vs_mb = 0;
		$sum_cp_mb = 0;
		$sum_op_mb = 0;
		$sum_pp_mb = 0;
		$sum_gs_mb = 0;
		$captital_mb = 0;
		$sum_rf_mb = 0;
		$sum_vt_mb = 0;
		//Orther devices
		$sum_oth = 0;
		$sum_vs_oth = 0;
		$sum_cp_oth = 0;
		$sum_op_oth = 0;
		$sum_pp_oth = 0;
		$sum_gs_oth = 0;
		$captital_oth = 0;
		$sum_rf_oth = 0;
		$sum_vt_oth = 0;
		//
		$sum_voa = 0;
		$sum_vev = 0;
		
		$devices_pc = explode('|',DEVICES_PC);
		$devices_mb = explode('|',DEVICES_MB);
		
		foreach ($pre_items as $item) {
			if (!empty($search_country) && $search_country != $item->country_name) {
				continue;
			}
			if ($item->status == 1) {
				if ($item->payment_type == BOOKING_PREFIX) {
					$sum_vs += 1;
					$sum_px += $item->group_size;
					
					if ($item->private_visa) {
						$sum_pr ++;
					}
					if ($item->full_package) {
						$sum_fp ++;
					}
					if ($item->fast_checkin) {
						$sum_fc ++;
					}
					if ($item->car_pickup) {
						$sum_cr ++;
					}
					if ($item->full_package || $item->rush_type == 2) {
						$sum_st += ($item->stamp_fee * $item->group_size);
					}
				}
				
				if ($item->payment_method == "OnePay") {
					$sum_op += $item->amount;
					
					if (!empty($item->vat)) {
						$sum_vt += $item->vat;
					} else {
						$st = 0;
						if ($item->full_package || $item->rush_type == 3 || $item->booking_type_id == 2) {
							$st = $item->stamp_fee * $item->group_size;
						}
						$sum_vt += ($item->amount - $st) - (($item->amount - $st) / 1.1);
					}
				} else if ($item->payment_method == "Paypal") {
					$sum_pp += $item->amount;
				} else if ($item->payment_method == "Credit Card") {
					$sum_gs += $item->amount;
				}
				
				if ($item->refund != $item->amount) {
					if ($item->payment_type == BOOKING_PREFIX_PO && empty($item->capital)) {
						$sum_cp += $item->amount;
					} else {
						$sum_cp += $item->capital;
					}
				}
				
				$sum_rf += $item->refund;

				if (in_array($item->platform, $devices_pc)) {
					$sum_pc++;

					switch ($item->payment_method) {
						case 'OnePay':
							$sum_op_pc += $item->amount;
							break;
						case 'Paypal':
							$sum_pp_pc += $item->amount;
							break;
						case 'Credit Card':
							$sum_gs_pc += $item->amount;
							break;
					}

					if ($item->payment_type == BOOKING_PREFIX) {
						$sum_vs_pc += 1;
					}
					if ($item->refund != $item->amount) {
						if ($item->payment_type == BOOKING_PREFIX_PO && empty($item->capital)) {
							$sum_cp_pc += $item->amount;
						} else {
							$sum_cp_pc += $item->capital;
						}
					}

					$sum_rf_pc += $item->refund;

					if (!empty($item->vat)) {
						$sum_vt_pc += $item->vat;
					} else {
						$st_pc = 0;
						if ($item->full_package || $item->rush_type == 3 || $item->booking_type_id == 2) {
							$st_pc = $item->stamp_fee * $item->group_size;
						}
						$sum_vt_pc += ($item->amount - $st_pc) - (($item->amount - $st_pc) / 1.1);
					}

				} else if (in_array($item->platform, $devices_mb)) {
					$sum_mb++;

					switch ($item->payment_method) {
						case 'OnePay':
							$sum_op_mb += $item->amount;
							break;
						case 'Paypal':
							$sum_pp_mb += $item->amount;
							break;
						case 'Credit Card':
							$sum_gs_mb += $item->amount;
							break;
					}

					if ($item->payment_type == BOOKING_PREFIX) {
						$sum_vs_mb += 1;
					}
					if ($item->refund != $item->amount) {
						if ($item->payment_type == BOOKING_PREFIX_PO && empty($item->capital)) {
							$sum_cp_mb += $item->amount;
						} else {
							$sum_cp_mb += $item->capital;
						}
					}

					$sum_rf_mb += $item->refund;

					if (!empty($item->vat)) {
						$sum_vt_mb += $item->vat;
					} else {
						$st_mb = 0;
						if ($item->full_package || $item->rush_type == 3 || $item->booking_type_id == 2) {
							$st_mb = $item->stamp_fee * $item->group_size;
						}
						$sum_vt_mb += ($item->amount - $st_mb) - (($item->amount - $st_mb) / 1.1);
					}
				} else {
					$sum_oth++;

					switch ($item->payment_method) {
						case 'OnePay':
							$sum_op_oth += $item->amount;
							break;
						case 'Paypal':
							$sum_pp_oth += $item->amount;
							break;
						case 'Credit Card':
							$sum_gs_oth += $item->amount;
							break;
					}

					if ($item->payment_type == BOOKING_PREFIX) {
						$sum_vs_oth += 1;
					}
					if ($item->refund != $item->amount) {
						if ($item->payment_type == BOOKING_PREFIX_PO && empty($item->capital)) {
							$sum_cp_oth += $item->amount;
						} else {
							$sum_cp_oth += $item->capital;
						}
					}

					$sum_rf_oth += $item->refund;

					if ($item->vat) {
						$sum_vt_oth += $item->vat;
					} else {
						$st_oth = 0;
						if ($item->full_package || $item->rush_type == 3 || $item->booking_type_id == 2) {
							$st_oth = $item->stamp_fee * $item->group_size;
						}
						$sum_vt_oth += ($item->amount - $st_oth) - (($item->amount - $st_oth) / 1.1);
					}
				}
				if($item->booking_type_id == 1) {
					$sum_voa++;
				} else if ($item->booking_type_id == 2) {
					$sum_vev++;
				}

			}

			if ($sum_vs_pc < 10) {
				$ratio_pc = 5/100;
			} else {
				$ratio_pc = 5/100;
			}
			$captital_pc = $sum_cp_pc;
			if ($captital_pc) {
				$captital_pc += round(($sum_op_pc+$sum_pp_pc+$sum_gs_pc) * $ratio_pc);
			}

			if ($sum_vs_mb < 10) {
				$ratio_mb = 5/100;
			} else {
				$ratio_mb = 5/100;
			}
			$captital_mb = $sum_cp_mb;
			if ($captital_mb) {
				$captital_mb += round(($sum_op_mb+$sum_pp_mb+$sum_gs_mb) * $ratio_mb);
			}

			if ($sum_vs_oth < 10) {
				$ratio_oth = 5/100;
			} else {
				$ratio_oth = 5/100;
			}
			$captital_oth = $sum_cp_oth;
			if ($captital_oth) {
				$captital_oth += round(($sum_op_oth+$sum_pp_oth+$sum_gs_oth) * $ratio_oth);
			}

			$items[] = $item;
		}
		
		$page = (!empty($_GET["page"]) ? max($_GET["page"], 1) : 1);
		$pagination = $this->util->pagination(site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}"), sizeof($items), ADMIN_ROW_PER_PAGE);
		
		$view_data = array();
		$view_data["task"]					= $task;
		$view_data["sortby"]				= $sortby;
		$view_data["orderby"]				= $orderby;
		$view_data["search_text"]			= $original_search_text;
		$view_data["edited_search_text"]	= $search_text;
		$view_data["search_country"]		= $search_country;
		$view_data["search_payment_method"]	= $search_payment_method;
		$view_data["fromdate"]				= $fromdate;
		$view_data["todate"]				= $todate;
		$view_data["items"]					= $items;
		$view_data["sum_vs"]				= $sum_vs;
		$view_data["sum_px"]				= $sum_px;
		$view_data["sum_op"]				= $sum_op;
		$view_data["sum_pp"]				= $sum_pp;
		$view_data["sum_gs"]				= $sum_gs;
		$view_data["sum_pr"]				= $sum_pr;
		$view_data["sum_fp"]				= $sum_fp;
		$view_data["sum_fc"]				= $sum_fc;
		$view_data["sum_cr"]				= $sum_cr;
		$view_data["sum_cp"]				= $sum_cp;
		$view_data["sum_rf"]				= $sum_rf;
		$view_data["sum_st"]				= $sum_st;
		$view_data["sum_vt"]				= $sum_vt;
		$view_data["sum_pc"]				= $sum_pc;
		$view_data["sum_op_pc"]				= $sum_op_pc;
		$view_data["sum_pp_pc"]				= $sum_pp_pc;
		$view_data["sum_gs_pc"]				= $sum_gs_pc;
		$view_data["captital_pc"]			= $captital_pc;
		$view_data["sum_rf_pc"]				= $sum_rf_pc;
		$view_data["sum_vt_pc"]				= $sum_vt_pc;
		$view_data["sum_mb"]				= $sum_mb;
		$view_data["sum_op_mb"]				= $sum_op_mb;
		$view_data["sum_pp_mb"]				= $sum_pp_mb;
		$view_data["sum_gs_mb"]				= $sum_gs_mb;
		$view_data["captital_mb"]			= $captital_mb;
		$view_data["sum_rf_mb"]				= $sum_rf_mb;
		$view_data["sum_vt_mb"]				= $sum_vt_mb;
		$view_data["sum_oth"]				= $sum_oth;
		$view_data["sum_op_oth"]			= $sum_op_oth;
		$view_data["sum_pp_oth"]			= $sum_pp_oth;
		$view_data["sum_gs_oth"]			= $sum_gs_oth;
		$view_data["captital_oth"]			= $captital_oth;
		$view_data["sum_rf_oth"]			= $sum_rf_oth;
		$view_data["sum_vt_oth"]			= $sum_vt_oth;
		$view_data["breadcrumb"]			= $this->_breadcrumb;
		$view_data["page"]					= $page;
		$view_data["pagination"]			= $pagination;
		$view_data["countries"]				= $countries;
		$view_data["sum_voa"]				= $sum_voa;
		$view_data["sum_vev"]				= $sum_vev;
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/report/payment_report", $view_data, TRUE);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	
	function unpaid_list()
	{
		require_once(APPPATH."libraries/ip2location/IP2Location.php");
		$loc = new IP2Location(FCPATH . '/application/libraries/ip2location/databases/IP-COUNTRY-SAMPLE.BIN', IP2Location::FILE_IO);
		
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Unpaid List" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task = $this->util->value($this->input->post("task"), "cancel");
		
		$sortby  				= $this->util->value($this->input->post("sortby"), "booking_date");
		$orderby 				= $this->util->value($this->input->post("orderby"), "DESC");
		$original_search_text	= $this->util->value($this->input->post("search_text"), "");
		$search_payment_method	= $this->util->value($this->input->post("search_payment_method"), "");
		$search_country			= $this->util->value($this->input->post("search_country"), "");
		$fromdate				= $this->util->value($this->input->post("fromdate"), date("Y-m-d"));
		$todate					= $this->util->value($this->input->post("todate"), date("Y-m-d"));
		
		$search_text = strtoupper(trim($original_search_text));
		$search_text = str_replace(array(BOOKING_PREFIX), "", $search_text);
		
		if (!empty($search_text)) {
			$fromdate = "";
			$todate = "";
		}
		
		if (!empty($fromdate)) {
			$fromdate = date("Y-m-d", strtotime($fromdate));
		}
		if (!empty($todate)) {
			$todate = date("Y-m-d", strtotime($todate));
		}
		
		$info = new stdClass();
		$info->search_text		= $search_text;
		$info->payment_method	= $search_payment_method;
		$info->payment_status	= 'UNPAID';
		$info->fromdate			= $fromdate;
		$info->todate			= $todate;
		$info->sortby			= $sortby;
		$info->orderby			= $orderby;
		
		$pre_items = $this->m_visa_booking->payments($info);
		
		$countries = array();
		foreach ($pre_items as $item) {
			if (!empty($item->client_ip)) {
				$country_code = $loc->lookup($item->client_ip, IP2Location::COUNTRY_CODE);
				$country_name = $loc->lookup($item->client_ip, IP2Location::COUNTRY_NAME);
				$country_flag = ADMIN_IMG_URL.'flags/'.strtolower($country_code).'.png';
				if ($country_code == '-') {
					$country_flag = ADMIN_IMG_URL.'flags/default.png';
				}
				$item->country_name = ucwords(strtolower($country_name));
				$item->country_flag = $country_flag;
				if (!$item->status && ($item->payment_type == BOOKING_PREFIX)) {
					if (array_key_exists($item->country_name, $countries)) {
						$countries[$item->country_name] += 1;
					} else {
						$countries[$item->country_name] = 1;
					}
				}
			}
		}
		ksort($countries);
		
		$items = array();
		
		foreach ($pre_items as $item) {
			if (!empty($search_country) && $search_country != $item->country_name) {
				continue;
			}
			$items[] = $item;
		}
		
		if ($task == "download") {
			$this->load->library("PHPExcel");
			$objPHPExcel = new PHPExcel();
			
			// Set document properties
			$objPHPExcel->getProperties()->setCreator(SITE_NAME)
										 ->setLastModifiedBy(SITE_NAME)
										 ->setTitle("Unpaid List ".date('M-d-Y', strtotime($fromdate))." to ".date('M-d-Y', strtotime($todate)))
										 ->setSubject("Unpaid List ".date('M-d-Y', strtotime($fromdate))." to ".date('M-d-Y', strtotime($todate)))
										 ->setDescription("Unpaid List ".date('M-d-Y', strtotime($fromdate))." to ".date('M-d-Y', strtotime($todate)))
										 ->setKeywords("")
										 ->setCategory("");
			
			$row = 1;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row, 'Payment ID');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row, 'Fullname');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row, 'Email');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$row, 'Amount');
			
			$rowHead = array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '5CB85C')
				)
			);
			$rowPO = array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFFDD')
				)
			);
			
			$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':D'.$row)->applyFromArray($rowHead);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':D'.$row)->getFont()->setBold(TRUE);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':D'.$row)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

			if (!empty($items) && sizeof($items)) {
				$row++;
			 	foreach ($items as $item) {
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row, $item->payment_type.$item->order_id);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row, $item->fullname);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row, '');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$row, '$'.$item->amount);
					
					$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':D'.$row)->applyFromArray($rowPO);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':D'.$row)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					
					$row++;
				}
			}
			
			foreach(range('A','D') as $columnID) {
				$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
			}
			
			// Rename worksheet
			$objPHPExcel->getActiveSheet()->setTitle('Unpaid List');
			
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);
			
			// Redirect output to a clientâ€™s web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="Unpaid List '.date('M-d-Y', strtotime($fromdate)).' to '.date('M-d-Y', strtotime($todate)).'.xls"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');
			
			// If you're serving to IE over SSL, then the following may be needed
			header ('Expires: Mon, 26 Jul 1997 00:00:00 GMT'); // Date in the past
			header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
			header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header ('Pragma: public'); // HTTP/1.0
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
		}
		
		$page = (!empty($_GET["page"]) ? max($_GET["page"], 1) : 1);
		$pagination = $this->util->pagination(site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}"), sizeof($items), ADMIN_ROW_PER_PAGE);
		
		$view_data = array();
		$view_data["task"]					= $task;
		$view_data["sortby"]				= $sortby;
		$view_data["orderby"]				= $orderby;
		$view_data["search_text"]			= $original_search_text;
		$view_data["edited_search_text"]	= $search_text;
		$view_data["search_country"]		= $search_country;
		$view_data["search_payment_method"]	= $search_payment_method;
		$view_data["fromdate"]				= $fromdate;
		$view_data["todate"]				= $todate;
		$view_data["items"]					= $items;
		$view_data["breadcrumb"]			= $this->_breadcrumb;
		$view_data["page"]					= $page;
		$view_data["pagination"]			= $pagination;
		$view_data["countries"]				= $countries;
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/report/unpaid_list", $view_data, TRUE);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	
	//------------------------------------------------------------------------------
	// Mail
	//------------------------------------------------------------------------------
	
	public function mail($action=null, $id=null)
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Mail" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "save") {
				$sender			= $this->util->value($this->input->post("sender"), "");
				$receiver		= $this->util->value($this->input->post("receiver"), "");
				$subject		= $this->util->value($this->input->post("subject"), "");
				$message		= $this->util->value($this->input->post("message"), "");
				$reply_id		= $this->util->value($this->input->post("reply_id"), 0);
				$read			= $this->util->value($this->input->post("read"), 0);
				
				$data = array (
					"sender"	=> $sender,
					"receiver"	=> $receiver,
					"subject"	=> $subject,
					"message"	=> $message,
					"reply_id"	=> $reply_id,
					"read"		=> $read
				);
				
				if ($action == "add") {
					$this->m_mail->add($data);
				}
				else if ($action == "edit") {
					$where = array("id" => $id);
					$this->m_mail->update($data, $where);
				}
				redirect(site_url("syslog/mail"));
			}
			else if ($task == "cancel") {
				redirect(site_url("syslog/mail"));
			}
			else if ($task == "read") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("read" => 1);
					$where = array("id" => $id);
					$this->m_mail->update($data, $where);
				}
				redirect(site_url("syslog/mail"));
			}
			else if ($task == "unread") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("read" => 0);
					$where = array("id" => $id);
					$this->m_mail->update($data, $where);
				}
				redirect(site_url("syslog/mail"));
			}
			else if ($task == "delete") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$where = array("id" => $id);
					$this->m_mail->delete($where);
				}
				redirect(site_url("syslog/mail"));
			}
			else if ($task == "delete-all") {
				$this->m_mail->delete_all();
				redirect(site_url("syslog/mail"));
			}
		}
		
		if ($action == "add") {
			$view_data = array();
			$view_data["item"] = $this->m_mail->instance();
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/mail/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else if ($action == "detail") {
			$item = $this->m_mail->load($id);
			
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$item->title}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}/{$id}")));
			
			$view_data = array();
			$view_data["item"]			= $item;
			$view_data["breadcrumb"]	= $this->_breadcrumb;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/mail/detail", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else {
			$page = (!empty($_GET["page"]) ? max($_GET["page"], 1) : 1);
			$pagination = $this->util->pagination(site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}"), $this->m_mail->count(), ADMIN_ROW_PER_PAGE);
			
			$view_data = array();
			$view_data["items"]			= $this->m_mail->items(null, null, ADMIN_ROW_PER_PAGE, ($page - 1) * ADMIN_ROW_PER_PAGE);
			$view_data["breadcrumb"]	= $this->_breadcrumb;
			$view_data["page"]			= $page;
			$view_data["pagination"]	= $pagination;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/mail/index", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
	}
	
	public function review_audio($action=null, $id=null)
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Review audio" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "save") {

			}
			else if ($task == "cancel") {
				redirect(site_url("syslog/review-audio"));
			}
			else if ($task == "read") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 1);
					$where = array("id" => $id);
					$this->m_review_audio->update($data, $where);
				}
				redirect(site_url("syslog/review-audio"));
			}
			else if ($task == "unread") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 0);
					$where = array("id" => $id);
					$this->m_review_audio->update($data, $where);
				}
				redirect(site_url("syslog/review-audio"));
			}
			else if ($task == "delete") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					unlink("./files/upload/review_audio/{$this->m_review_audio->load($id)->name}.wav");
					$where = array("id" => $id);
					$this->m_review_audio->delete($where);
				}
				redirect(site_url("syslog/review-audio"));
			}
			else if ($task == "delete-all") {
				$this->m_review_audio->delete_all();
				redirect(site_url("syslog/review-audio"));
			}
		}
		
		if ($action == "add") {
			$view_data = array();
			$view_data["item"] = $this->m_review_audio->instance();
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/review_audio/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else if ($action == "detail") {
			$item = $this->m_review_audio->load($id);
			
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$item->name}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}/{$id}")));
			
			$view_data = array();
			$view_data["item"]			= $item;
			$view_data["breadcrumb"]	= $this->_breadcrumb;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/review_audio/detail", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else {
			$page = (!empty($_GET["page"]) ? max($_GET["page"], 1) : 1);
			$pagination = $this->util->pagination(site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}"), 5, ADMIN_ROW_PER_PAGE);
			
			$view_data = array();
			$view_data["items"]			= $this->m_review_audio->items(null, null, ADMIN_ROW_PER_PAGE, ($page - 1) * ADMIN_ROW_PER_PAGE);
			$view_data["breadcrumb"]	= $this->_breadcrumb;
			$view_data["page"]			= $page;
			$view_data["pagination"]	= $pagination;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/review_audio/index", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
	}

	function ajax_mail_forward($action)
	{
		if ($action == "send") {
			$to_receiver = $this->input->post("to_receiver");
			$subject = $this->input->post("subject");
			$message = $this->input->post("message");
			
			$mail_data = array(
				"subject"		=> $subject,
				"from_sender"	=> MAIL_INFO,
				"name_sender"	=> SITE_NAME,
				"to_receiver"   => explode(";", $to_receiver),
				"bcc"   		=> "phonglt@vietnam-media.vn",
				"message"       => $message
			);
			$this->mail->config($mail_data);
			$this->mail->sendmail();
			echo "Mail is sent.";
		}
		else if ($action == "compose") {
			$id = $this->input->post("id");
			$item = $this->m_mail->load($id);
			echo json_encode(array($item->sender, $item->title, $item->message));
		}
	}
	
	//------------------------------------------------------------------------------
	// History
	//------------------------------------------------------------------------------
	
	public function history($action=null, $id=null)
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("History" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "delete") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$where = array("id" => $id);
					$this->m_history->delete($where);
				}
				redirect(site_url("syslog/history"));
			}
			else if ($task == "delete-all") {
				$this->m_history->delete_all();
				redirect(site_url("syslog/history"));
			}
		}
		
		$page = (!empty($_GET["page"]) ? max($_GET["page"], 1) : 1);
		$pagination = $this->util->pagination(site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}"), $this->m_history->count(), ADMIN_ROW_PER_PAGE);
		
		$view_data = array();
		$view_data["items"]			= $this->m_history->items(null, ADMIN_ROW_PER_PAGE, ($page - 1) * ADMIN_ROW_PER_PAGE);
		$view_data["breadcrumb"]	= $this->_breadcrumb;
		$view_data["page"]			= $page;
		$view_data["pagination"]	= $pagination;
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/history/index", $view_data, true);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	
	public function ajax_history()
	{
		$id = $this->util->value($this->input->post("id"), 0);
		
		$view_data = array();
		$view_data["item"] = $this->m_history->load($id);
		echo $this->load->view("admin/history/ajax/detail", $view_data, true);
	}
	
	//------------------------------------------------------------------------------
	// Meta tags
	//------------------------------------------------------------------------------
	
	public function page_meta_tags($action=null, $id=null)
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Page Meta Tags" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "save") {
				$url			= $this->util->value($this->input->post("url"), "");
				$title			= $this->util->value($this->input->post("title"), "");
				$keywords		= $this->util->value($this->input->post("keywords"), "");
				$description	= $this->util->value($this->input->post("description"), "");
				$active			= $this->util->value($this->input->post("active"), 1);
				
				$data = array (
					"url"			=> $url,
					"title"			=> $title,
					"keywords"		=> $keywords,
					"description"	=> $description,
					"active"		=> $active,
				);
	
				if ($action == "add") {
					$this->m_meta->add($data);
				}
				else if ($action == "edit") {
					$where = array("id" => $id);
					$this->m_meta->update($data, $where);
				}
				redirect(site_url("syslog/page-meta-tags"));
			}
			else if ($task == "cancel") {
				redirect(site_url("syslog/page-meta-tags"));
			}
			else if ($task == "publish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 1);
					$where = array("id" => $id);
					$this->m_meta->update($data, $where);
				}
				redirect(site_url("syslog/page-meta-tags"));
			}
			else if ($task == "unpublish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 0);
					$where = array("id" => $id);
					$this->m_meta->update($data, $where);
				}
				redirect(site_url("syslog/page-meta-tags"));
			}
			else if ($task == "delete") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$where = array("id" => $id);
					$this->m_meta->delete($where);
				}
				redirect(site_url("syslog/page-meta-tags"));
			}
		}
		
		if ($action == "add") {
			$item = $this->m_meta->instance();
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("Add Meta Tags" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/meta/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else if ($action == "edit") {
			$item = $this->m_meta->load($id);
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$item->title}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}/{$id}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/meta/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else {
			$page = (!empty($_GET["page"]) ? max($_GET["page"], 1) : 1);
			$pagination = $this->util->pagination(site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}"), $this->m_meta->count(), ADMIN_ROW_PER_PAGE);
			
			$view_data = array();
			$view_data["breadcrumb"]	= $this->_breadcrumb;
			$view_data["items"]			= $this->m_meta->items(null, null, ADMIN_ROW_PER_PAGE, ($page - 1) * ADMIN_ROW_PER_PAGE);
			$view_data["page"]			= $page;
			$view_data["pagination"]	= $pagination;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/meta/index", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
	}
	
	//------------------------------------------------------------------------------
	// Redirects
	//------------------------------------------------------------------------------
	
	public function page_redirects($action=null, $id=null)
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Page Redirects" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "save") {
				$from_url	= $this->util->value($this->input->post("from_url"), "");
				$to_url		= $this->util->value($this->input->post("to_url"), "");
				$active		= $this->util->value($this->input->post("active"), 1);
				
				$data = array (
					"from_url"	=> $from_url,
					"to_url"	=> $to_url,
					"active"	=> $active,
				);
	
				if ($action == "add") {
					$this->m_redirect->add($data);
				}
				else if ($action == "edit") {
					$where = array("id" => $id);
					$this->m_redirect->update($data, $where);
				}
				redirect(site_url("syslog/page-redirects"));
			}
			else if ($task == "cancel") {
				redirect(site_url("syslog/page-redirects"));
			}
			else if ($task == "publish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 1);
					$where = array("id" => $id);
					$this->m_redirect->update($data, $where);
				}
				redirect(site_url("syslog/page-redirects"));
			}
			else if ($task == "unpublish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 0);
					$where = array("id" => $id);
					$this->m_redirect->update($data, $where);
				}
				redirect(site_url("syslog/page-redirects"));
			}
			else if ($task == "delete") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$where = array("id" => $id);
					$this->m_redirect->delete($where);
				}
				redirect(site_url("syslog/page-redirects"));
			}
		}
		
		if ($action == "add") {
			$item = $this->m_redirect->instance();
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("Add Page Redirect" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/redirect/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else if ($action == "edit") {
			$item = $this->m_redirect->load($id);
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$item->from_url}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}/{$id}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/redirect/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else {
			$page = (!empty($_GET["page"]) ? max($_GET["page"], 1) : 1);
			$pagination = $this->util->pagination(site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}"), $this->m_redirect->count(), ADMIN_ROW_PER_PAGE);
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["items"]			= $this->m_redirect->items(null, null, ADMIN_ROW_PER_PAGE, ($page - 1) * ADMIN_ROW_PER_PAGE);
			$view_data["page"]			= $page;
			$view_data["pagination"]	= $pagination;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/redirect/index", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
	}
	
	//------------------------------------------------------------------------------
	// Promotion
	//------------------------------------------------------------------------------
	
	public function promotion_codes($action=null, $id=null)
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Promotion Codes" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "save") {
				$code			= $this->util->value(trim($this->input->post("code")), "");
				$start_date		= $this->util->value(date("Y-m-d", strtotime($this->input->post("start_date"))), date("Y-m-d"));
				$end_date		= $this->util->value(date("Y-m-d", strtotime($this->input->post("end_date"))), date("Y-m-d"));
				$discount		= $this->util->value($this->input->post("discount"), 0);
				$discount_unit	= $this->util->value($this->input->post("discount_unit"), "%");
				$active			= $this->util->value($this->input->post("active"), 1);
				
				$data = array (
					"code"			=> $code,
					"start_date"	=> $start_date,
					"end_date"		=> $end_date,
					"discount"		=> $discount,
					"discount_unit"	=> $discount_unit,
					"active"		=> $active,
				);
	
				if ($action == "add") {
					$this->m_promotion->add($data);
				}
				else if ($action == "edit") {
					$where = array("code" => $id);
					$this->m_promotion->update($data, $where);
				}
				redirect(site_url("syslog/promotion-codes"));
			}
			else if ($task == "cancel") {
				redirect(site_url("syslog/promotion-codes"));
			}
			else if ($task == "publish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 1);
					$where = array("code" => $id);
					$this->m_promotion->update($data, $where);
				}
				redirect(site_url("syslog/promotion-codes"));
			}
			else if ($task == "unpublish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 0);
					$where = array("code" => $id);
					$this->m_promotion->update($data, $where);
				}
				redirect(site_url("syslog/promotion-codes"));
			}
			else if ($task == "delete") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$where = array("code" => $id);
					$this->m_promotion->delete($where);
				}
				redirect(site_url("syslog/promotion-codes"));
			}
		}
		
		if ($action == "add") {
			$item = $this->m_promotion->instance();
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("Add Promotion Code" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/promotion/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else if ($action == "edit") {
			$item = $this->m_promotion->load($id);
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$item->code}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}/{$id}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/promotion/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else {
			$search_status = $this->util->value($this->input->post("search_status"), "");
			$search_text = $this->util->value($this->input->post("search_text"), "");
			$search_text = strtoupper(trim($search_text));
			
			$info = new stdClass();
			if (!empty($search_text)) {
				$info->search_text = $search_text;
			}
			if (!empty($search_status)) {
				$info->search_status = $search_status;
			}
			
			$page = (!empty($_GET["page"]) ? max($_GET["page"], 1) : 1);
			$pagination = $this->util->pagination(site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}"), $this->m_promotion->count($info), ADMIN_ROW_PER_PAGE);
			
			$view_data = array();
			$view_data["task"]			= $task;
			$view_data["breadcrumb"]	= $this->_breadcrumb;
			$view_data["items"]			= $this->m_promotion->items($info, null, ADMIN_ROW_PER_PAGE, ($page - 1) * ADMIN_ROW_PER_PAGE);
			$view_data["search_text"]	= $search_text;
			$view_data["search_status"]	= $search_status;
			$view_data["page"]			= $page;
			$view_data["pagination"]	= $pagination;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/promotion/index", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
	}
	
	public function promotion_templates($action=null, $id=null)
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Promotion Templates" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "save") {
				$sender			= $this->util->value($this->input->post("sender"), "");
				$sender_email	= $this->util->value($this->input->post("sender_email"), "");
				$emails			= $this->util->value($this->input->post("emails"), "");
				$subject		= $this->util->value($this->input->post("subject"), "");
				$content		= $this->util->value($this->input->post("content"), "");
				
				$data = array (
					"sender"		=> $sender,
					"sender_email"	=> $sender_email,
					"emails"		=> $emails,
					"subject"		=> $subject,
					"content"		=> $content
				);
	
				if ($action == "add") {
					$this->m_promotion_txt->add($data);
				}
				else if ($action == "edit") {
					$where = array("id" => $id);
					$this->m_promotion_txt->update($data, $where);
				}
				redirect(site_url("syslog/promotion-templates"));
			}
			else if ($task == "cancel") {
				redirect(site_url("syslog/promotion-templates"));
			}
			else if ($task == "publish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 1);
					$where = array("id" => $id);
					$this->m_promotion_txt->update($data, $where);
				}
				redirect(site_url("syslog/promotion-templates"));
			}
			else if ($task == "unpublish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 0);
					$where = array("id" => $id);
					$this->m_promotion_txt->update($data, $where);
				}
				redirect(site_url("syslog/promotion-templates"));
			}
			else if ($task == "delete") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$where = array("id" => $id);
					$this->m_promotion_txt->delete($where);
				}
				redirect(site_url("syslog/promotion-templates"));
			}
		}
		
		if ($action == "add") {
			$item = $this->m_promotion_txt->instance();
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("Add Promotion Template" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/promotion/template/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else if ($action == "edit") {
			$item = $this->m_promotion_txt->load($id);
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$item->subject}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}/{$id}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/promotion/template/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else {
			$view_data = array();
			$view_data["breadcrumb"]	= $this->_breadcrumb;
			$view_data["items"]			= $this->m_promotion_txt->items(null, null, null, null);
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/promotion/template/index", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
	}
	
	function promotion_booking()
	{
		require_once(APPPATH."libraries/ip2location/IP2Location.php");
		$loc = new IP2Location(FCPATH . '/application/libraries/ip2location/databases/IP-COUNTRY-SAMPLE.BIN', IP2Location::FILE_IO);
		
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Visa Bookings with Codes" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task	= $this->util->value($this->input->post("task"), "cancel");
		$ids	= $this->util->value($this->input->post("cid"), array());
		
		foreach ($ids as $id) {
			if ($task == "remove") {
				$this->m_visa_booking->delete(array ("id" => $id));
				$this->m_visa_booking->delete_traveller(array ("book_id" => $id));
			} else if ($task == "paid") {
				$data = array ("status" => 1);
				$where = array ("id" => $id);
				$this->m_visa_booking->update($data, $where);
			} else if ($task == "unpaid") {
				$data = array ("status" => 0);
				$where = array ("id" => $id);
				$this->m_visa_booking->update($data, $where);
			}
		}
		
		$sortby 				= $this->util->value($this->input->post("sortby"), "booking_date");
		$orderby 				= $this->util->value($this->input->post("orderby"), "DESC");
		$original_search_text	= $this->util->value($this->input->post("search_text"), "");
		$search_visa_type		= $this->util->value($this->input->post("search_visa_type"), "");
		$search_visit_purpose	= $this->util->value($this->input->post("search_visit_purpose"), "");
		$search_country 		= $this->util->value($this->input->post("search_country"), "");
		$fromdate				= $this->util->value($this->input->post("fromdate"), date("Y-m-d"));
		$todate					= $this->util->value($this->input->post("todate"), date("Y-m-d"));
		
		$search_text = strtoupper(trim($original_search_text));
		$search_text = str_replace(array(BOOKING_PREFIX), "", $search_text);
		
		if (!empty($search_text)) {
			$fromdate = "";
			$todate = "";
		}
		
		if (!empty($fromdate)) {
			$fromdate = date("Y-m-d", strtotime($fromdate));
		}
		if (!empty($todate)) {
			$todate = date("Y-m-d", strtotime($todate));
		}
		
		$info = new stdClass();
		$info->search_text		= $search_text;
		if (!empty($search_visa_type)) {
			$info->visa_type	= $this->m_visa_type->load($search_visa_type)->name;
		}
		$info->visit_purpose	= $search_visit_purpose;
		$info->fromdate			= $fromdate;
		$info->todate			= $todate;
		$info->sortby			= $sortby;
		$info->orderby			= $orderby;
		$info->promotion_code	= "*";
		
		$pre_items = $this->m_visa_booking->bookings($info);
		
		$countries = array();
		foreach ($pre_items as $item) {
			if (!empty($item->client_ip)) {
				$country_code = $loc->lookup($item->client_ip, IP2Location::COUNTRY_CODE);
				$country_name = $loc->lookup($item->client_ip, IP2Location::COUNTRY_NAME);
				$country_flag = ADMIN_IMG_URL.'flags/'.strtolower($country_code).'.png';
				if ($country_code == '-') {
					$country_flag = ADMIN_IMG_URL.'flags/default.png';
				}
				$item->country_name = ucwords(strtolower($country_name));
				$item->country_flag = $country_flag;
				if ($item->status) {
					if (array_key_exists($item->country_name, $countries)) {
						$countries[$item->country_name] += 1;
					} else {
						$countries[$item->country_name] = 1;
					}
				}
			}
		}
		ksort($countries);
		
		$items = array();
		
		$sum_vs = 0;
		$sum_px = 0;
		$sum_op = 0;
		$sum_pp = 0;
		$sum_gs = 0;
		
		$sum_pr = 0;
		$sum_fp = 0;
		$sum_fc = 0;
		$sum_cr = 0;
		$sum_cp = 0;
		$sum_rf = 0;
		$sum_st = 0;
		
		foreach ($pre_items as $item) {
			if (!empty($search_country) && $search_country != $item->country_name) {
				continue;
			}
			$items[] = $item;
			if ($item->status == 1) {
				$sum_vs += 1;
				$sum_px += $item->group_size;
				
				if ($item->private_visa) {
					$sum_pr ++;
				}
				if ($item->full_package) {
					$sum_fp ++;
				}
				if ($item->fast_checkin) {
					$sum_fc ++;
				}
				if ($item->car_pickup) {
					$sum_cr ++;
				}
				if ($item->full_package || $item->rush_type == 2) {
					$sum_st += ($item->stamp_fee * $item->group_size);
				}
				if ($item->payment_method == "OnePay") {
					$sum_op += $item->total_fee;
				} else if ($item->payment_method == "Paypal") {
					$sum_pp += $item->total_fee;
				} else if ($item->payment_method == "Credit Card") {
					$sum_gs += $item->total_fee;
				}
				if ($item->refund != $item->total_fee) {
					$sum_cp += $item->capital;
				}
				$sum_rf += $item->refund;
			}
		}
		
		$page = (!empty($_GET["page"]) ? max($_GET["page"], 1) : 1);
		$pagination = $this->util->pagination(site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}"), sizeof($items), ADMIN_ROW_PER_PAGE);
		
		$view_data = array();
		$view_data["task"]					= $task;
		$view_data["sortby"]				= $sortby;
		$view_data["orderby"]				= $orderby;
		$view_data["search_text"]			= $original_search_text;
		$view_data["edited_search_text"]	= $search_text;
		$view_data["search_visa_type"]		= $search_visa_type;
		$view_data["search_visit_purpose"]	= $search_visit_purpose;
		$view_data["search_country"]		= $search_country;
		$view_data["fromdate"]				= $fromdate;
		$view_data["todate"]				= $todate;
		$view_data["items"]					= $items;
		$view_data["sum_vs"]				= $sum_vs;
		$view_data["sum_px"]				= $sum_px;
		$view_data["sum_op"]				= $sum_op;
		$view_data["sum_pp"]				= $sum_pp;
		$view_data["sum_gs"]				= $sum_gs;
		$view_data["sum_pr"]				= $sum_pr;
		$view_data["sum_fp"]				= $sum_fp;
		$view_data["sum_fc"]				= $sum_fc;
		$view_data["sum_cr"]				= $sum_cr;
		$view_data["sum_cp"]				= $sum_cp;
		$view_data["sum_rf"]				= $sum_rf;
		$view_data["sum_st"]				= $sum_st;
		$view_data["breadcrumb"]			= $this->_breadcrumb;
		$view_data["page"]					= $page;
		$view_data["pagination"]			= $pagination;
		$view_data["all_countries"]			= $countries;
		
		$booking_ids = array();
		for ($idx = (($page - 1) * ADMIN_ROW_PER_PAGE); $idx < sizeof($items) && $idx < ($page * ADMIN_ROW_PER_PAGE); $idx++) {
			$booking_ids[] = $items[$idx]->id;
		}
		if (sizeof($booking_ids)) {
			$view_data["paxs"] = $this->m_visa_booking->booking_travelers($booking_ids);
		} else {
			$view_data["paxs"] = array();
		}
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/promotion/booking/visa_booking", $view_data, TRUE);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	//------------------------------------------------------------------------------
	// XLS Compare
	//------------------------------------------------------------------------------
	
	public function debt()
	{
		require_once dirname(__FILE__) . '/../libraries/SimpleXLSX.class.php';
		
		$debt = $this->session->userdata("debt");
		if (empty($debt)) {
			$debt->fl = "";
			$debt->fr = "";
			$debt->sl = 0;
			$debt->sr = 0;
			$debt->cl = array();
			$debt->cr = array();
		}
		
		$matched_left = array();
		$matched_right = array();
		$duplicated_left = array();
		$duplicated_right = array();
		$missed_left = array();
		$missed_right = array();
		
		if (!empty($_POST)) {
			$task = $_POST["task"];
			if ($task == "change-file-left") {
				$path = "./debt";
				if(!file_exists($path)) {
					mkdir($path, 0775, TRUE);
				}
				
				$config = array();
				$config['upload_path'] = $path;
				$config['allowed_types'] = 'xls|xlsx';
				$config['max_size']	= '20000';
				$config['overwrite'] = TRUE;
				
				$this->load->library('upload', $config);
				
				if ($_FILES['file-left']['name'] != '') {
					if (!$this->upload->do_upload('file-left')) {
						$this->session->set_flashdata('message', $this->upload->display_errors());
						redirect(site_url("syslog/debt"));
					}
					else {
						$data = array('upload_data' => $this->upload->data());
						$file_data = $this->upload->data();
						$debt->fl = "./debt/".$file_data['orig_name'];
						$debt->sl = 0;
						$debt->cl = array();
					}
				}
			}
			else if ($task == "change-file-right") {
				$path = "./debt";
				if(!file_exists($path)) {
					mkdir($path, 0775, TRUE);
				}
				
				$config = array();
				$config['upload_path'] = $path;
				$config['allowed_types'] = 'xls|xlsx';
				$config['max_size']	= '20000';
				$config['overwrite'] = TRUE;
				
				$this->load->library('upload', $config);
				
				if ($_FILES['file-right']['name'] != '') {
					if (!$this->upload->do_upload('file-right')) {
						$this->session->set_flashdata('message', $this->upload->display_errors());
						redirect(site_url("syslog/debt"));
					}
					else {
						$data = array('upload_data' => $this->upload->data());
						$file_data = $this->upload->data();
						$debt->fr = "./debt/".$file_data['orig_name'];
						$debt->sr = 0;
						$debt->cr = array();
					}
				}
			}
			else if ($task == "change-sheet-left") {
				$debt->sl = $_POST["sheet"];
				$debt->cl = array();
			}
			else if ($task == "change-sheet-right") {
				$debt->sr = $_POST["sheet"];
				$debt->cr = array();
			}
			else if ($task == "compare") {
				$fl = new SimpleXLSX($debt->fl);
				$fr = new SimpleXLSX($debt->fr);
				
				// Start to compare
				list($num_cols_left, $num_rows_left) = $fl->dimension($debt->sl+1);
				list($num_cols_right, $num_rows_right) = $fr->dimension($debt->sr+1);
				
				if (empty($debt->fl) || empty($debt->fr)) {
					$this->session->set_flashdata('message', "Please select the left file and the right file to compare.");
					redirect(site_url("syslog/debt"));
				}
				
				if ((($num_cols_left - sizeof($debt->cl)) != ($num_cols_right - sizeof($debt->cr))) || (($num_cols_left - sizeof($debt->cl)) == 0)) {
					$this->session->set_flashdata('message', "Selected columns is not equal in left and right to compare.");
					redirect(site_url("syslog/debt"));
				}
				
				// Sort column from low to height
				asort($debt->cl);
				asort($debt->cr);
				
				$cols_left = array();
				$cols_right = array();
				
				$tospace = array(PHP_EOL, "\r", "\n", "\t", "\0", "  ");
				$toempty = array("\'", "\"", "=");
				
				for ($c=0; $c<$num_cols_left; $c++) {
					if (!in_array($c, $debt->cl)) {
						array_push($cols_left, $c);
					}
				}
				for ($c=0; $c<$num_cols_right; $c++) {
					if (!in_array($c, $debt->cr)) {
						array_push($cols_right, $c);
					}
				}
				
				$rows_left = $fl->rows($debt->sl+1);
				$rows_right = $fr->rows($debt->sr+1);
				
				// Check duplicated in left side
				$tmp_rows_left_result = array();
				for ($rl=0; $rl<sizeof($rows_left); $rl++) {
					$vals = array();
					for ($c=0; $c<sizeof($cols_left); $c++) {
						$val = strtoupper(trim(str_replace($tospace, " ", $rows_left[$rl][$cols_left[$c]])));
						$val = str_replace($toempty, "", $val);
						array_push($vals, $val);
					}
					array_push($tmp_rows_left_result, implode(",", $vals));
				}
				for ($rl=0; $rl<(sizeof($tmp_rows_left_result)-1); $rl++) {
					for ($rl2=$rl+1; $rl2<sizeof($tmp_rows_left_result); $rl2++) {
						if ($tmp_rows_left_result[$rl] == $tmp_rows_left_result[$rl2]) {
							array_push($duplicated_left, $rl);
							array_push($duplicated_left, $rl2);
						}
					}
				}
				
				// Check duplicated in right side
				$tmp_rows_right_result = array();
				for ($rr=0; $rr<sizeof($rows_right); $rr++) {
					$vals = array();
					for ($c=0; $c<sizeof($cols_right); $c++) {
						$val = strtoupper(trim(str_replace($tospace, " ", $rows_right[$rr][$cols_right[$c]])));
						$val = str_replace($toempty, "", $val);
						array_push($vals, $val);
					}
					array_push($tmp_rows_right_result, implode(",", $vals));
				}
				for ($rr=0; $rr<(sizeof($tmp_rows_right_result)-1); $rr++) {
					for ($rr2=$rr+1; $rr2<sizeof($tmp_rows_right_result); $rr2++) {
						if ($tmp_rows_right_result[$rr] == $tmp_rows_right_result[$rr2]) {
							array_push($duplicated_right, $rr);
							array_push($duplicated_right, $rr2);
						}
					}
				}
				
				// Check missed in left side
				for ($rl=0; $rl<sizeof($rows_left); $rl++) {
					$rr_idx = -1;
					for ($c=0; $c<sizeof($cols_left); $c++) {
						$is_matched = FALSE;
						if (0) {
							$vl = strtoupper(trim(str_replace($tospace, " ", $rows_left[$rl][$cols_left[$c]])));
							$vl = str_replace($toempty, "", $vl);
							$vr = strtoupper(trim(str_replace($tospace, " ", $rows_right[$rr_idx][$cols_right[$c]])));
							$vr = str_replace($toempty, "", $vr);
							if ($vl == $vr) {
								$is_matched = TRUE;
							}
						}
						else {
							for ($rr=0; $rr<sizeof($rows_right); $rr++) {
								$vl = strtoupper(trim(str_replace($tospace, " ", $rows_left[$rl][$cols_left[$c]])));
								$vl = str_replace($toempty, "", $vl);
								$vr = strtoupper(trim(str_replace($tospace, " ", $rows_right[$rr][$cols_right[$c]])));
								$vr = str_replace($toempty, "", $vr);
								if ($vl == $vr) {
									$is_matched = TRUE;
									if (!$c) {
										$rr_idx = $rr;
									}
								}
							}
						}
						if (!$is_matched) {
							array_push($missed_left, $rl.",".$cols_left[$c]);
						}
					}
				}
				
				// Check missed in right side
				for ($rr=0; $rr<sizeof($rows_right); $rr++) {
					$rl_idx = -1;
					for ($c=0; $c<sizeof($cols_right); $c++) {
						$is_matched = FALSE;
						if (0) {
							$vl = strtoupper(trim(str_replace($tospace, " ", $rows_left[$rl_idx][$cols_left[$c]])));
							$vl = str_replace($toempty, "", $vl);
							$vr = strtoupper(trim(str_replace($tospace, " ", $rows_right[$rr][$cols_right[$c]])));
							$vr = str_replace($toempty, "", $vr);
							if ($vl == $vr) {
								$is_matched = TRUE;
							}
						}
						else {
							for ($rl=0; $rl<sizeof($rows_left); $rl++) {
								$vl = strtoupper(trim(str_replace($tospace, " ", $rows_left[$rl][$cols_left[$c]])));
								$vl = str_replace($toempty, "", $vl);
								$vr = strtoupper(trim(str_replace($tospace, " ", $rows_right[$rr][$cols_right[$c]])));
								$vr = str_replace($toempty, "", $vr);
								if ($vl == $vr) {
									$is_matched = TRUE;
									if (!$c) {
										$rl_idx = $rl;
									}
								}
							}
						}
						if (!$is_matched) {
							array_push($missed_right, $rr.",".$cols_right[$c]);
						}
					}
				}
			}
		}
		
		if (!empty($debt->fl)) {
			$fl = new SimpleXLSX($debt->fl);
		} else {
			$fl = NULL;
		}
		if (!empty($debt->fr)) {
			$fr = new SimpleXLSX($debt->fr);
		} else {
			$fr = NULL;
		}
		
		$this->session->set_userdata("debt", $debt);
		
		$view_data = array();
		$view_data["fl"] = $fl;
		$view_data["fr"] = $fr;
		$view_data["debt"] = $debt;
		
		$view_data["matched_left"] 		= $matched_left;
		$view_data["matched_right"] 	= $matched_right;
		$view_data["duplicated_left"] 	= $duplicated_left;
		$view_data["duplicated_right"] 	= $duplicated_right;
		$view_data["missed_left"] 		= $missed_left;
		$view_data["missed_right"] 		= $missed_right;
		
		$tmpl_content = array();
		$tmpl_content["mnindex"] = "debt";
		$tmpl_content["content"] = $this->load->view("admin/debt/index", $view_data, TRUE);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	
	public function debt_cl_selection_changed()
	{
		$col = $_POST["col"];
		$hidden = $_POST["hidden"];
		
		$debt = $this->session->userdata("debt");
		
		if ($hidden == "true") {
			if (!in_array($col, $debt->cl)) {
				array_push($debt->cl, $col);
			}
		} else {
			$debt->cl = array_diff($debt->cl, array($col));
		}
		
		$this->session->set_userdata("debt", $debt);
	}
	
	public function debt_cr_selection_changed()
	{
		$col = $_POST["col"];
		$hidden = $_POST["hidden"];
		
		$debt = $this->session->userdata("debt");
		
		if ($hidden == "true") {
			if (!in_array($col, $debt->cr)) {
				array_push($debt->cr, $col);
			}
		} else {
			$debt->cr = array_diff($debt->cr, array($col));
		}
		
		$this->session->set_userdata("debt", $debt);
	}
	
	public function debt_reset()
	{
		$this->session->unset_userdata("debt");
		redirect(site_url("syslog/debt"));
	}
	
	public function ajax_user_action()
	{
		require_once(APPPATH."libraries/ip2location/IP2Location.php");
		$loc = new IP2Location(FCPATH . '/application/libraries/ip2location/databases/IP-COUNTRY-SAMPLE.BIN', IP2Location::FILE_IO);
		
		$users_online = $this->m_user_online->items(NULL, 3);
		
		$str = '';
		foreach ($users_online as $user_online) {
			if (!empty($user_online)) {
				$user = $this->m_user->load($user_online->user_id);
				
				$country_code = $loc->lookup($user_online->ip, IP2Location::COUNTRY_CODE);
				$country_name = $loc->lookup($user_online->ip, IP2Location::COUNTRY_NAME);
				$country_flag = ADMIN_IMG_URL.'flags/'.strtolower($country_code).'.png';
				if ($country_code == '-') {
					$country_flag = ADMIN_IMG_URL.'flags/default.png';
				}
				
				$str .= '<div class="media">
							<div class="media-left">
								<img class="media-object" src="'.(!empty($user->avatar)?$user->avatar:IMG_URL."no-avatar.gif.png").'" alt="'.$user->user_fullname.'">
							</div>
							<div class="media-body">
								<h4 class="media-heading">'.$user->user_fullname.'</h4>
								<p>
									<a target="_blank" href="http://whatismyipaddress.com/ip/'.$user_online->ip.'" style="color:#fff;"><img src="'.$country_flag.'" alt="'.$country_name.'" title="'.$country_name.'" /> '.$user_online->ip.'</a>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-clock-o"></i> '.date('Y-m-d H:i:s', strtotime($user_online->created_date)).'
								</p>
								<p>'.$user_online->url.'</p>
							</div>
						</div>';
			}
		}
		
		echo $str;
	}
	
	//------------------------------------------------------------------------------
	// Scheduler
	//------------------------------------------------------------------------------
	
	public function scheduler()
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Time Table" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task = $this->util->value($this->input->post("task"), "");
		
		$search_text = $this->util->value($this->input->post("search_text"), "");
		$fromdate = $this->util->value($this->input->post("fromdate"), date("Y-m-d"));
		$todate = $this->util->value($this->input->post("todate"), date("Y-m-d"));
		
		$search_text = strtoupper(trim($search_text));
		
		if (!empty($search_text)) {
			$fromdate = "";
			$todate = "";
		}
		
		if (!empty($fromdate)) {
			$fromdate = date("Y-m-d", strtotime($fromdate));
		}
		if (!empty($todate)) {
			$todate = date("Y-m-d", strtotime($todate));
		}
		
		$info = new stdClass();
		$info->search_text = $search_text;
		$info->fromdate = $fromdate;
		$info->todate = $todate;
		$info->user_types = array(USR_ADMIN);
		$users = $this->m_user->users($info, 1);
		
		$view_data = array();
		$view_data["breadcrumb"] 	= $this->_breadcrumb;
		$view_data["users"]			= $users;
		$view_data["task"]			= $task;
		$view_data["search_text"]	= $search_text;
		$view_data["fromdate"]		= $fromdate;
		$view_data["todate"]		= $todate;
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/scheduler/index", $view_data, true);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	
	public function ajax_scheduler($action)
	{
		if ($action == "add") {
			$start_date = date('m/d/Y H:i');
			$end_date = date('m/d/Y H:i');
			echo json_encode(array($start_date, $end_date));
		}
		else if ($action == "edit") {
			$id = $this->input->post("id");
			$schedule = $this->m_work_schedule->load($id);
			$start_date = date('m/d/Y H:i', strtotime($schedule->start_date));
			$end_date = date('m/d/Y H:i', strtotime($schedule->end_date));
			echo json_encode(array($start_date, $end_date));
		}
		else if ($action == "save") {
			$data = array(
				"user_id"		=> $this->input->post("user_id"),
				"start_date"	=> date("Y-m-d H:i:s", strtotime($this->input->post("start_date"))),
				"end_date"		=> date("Y-m-d H:i:s", strtotime($this->input->post("end_date")))
			);
			$this->m_work_schedule->add($data);
		}
		else if ($action == "update") {
			$data = array(
				"start_date"	=> date("Y-m-d H:i:s", strtotime($this->input->post("start_date"))),
				"end_date"		=> date("Y-m-d H:i:s", strtotime($this->input->post("end_date")))
			);
			$where = array("id" => $this->input->post("id"));
			$this->m_work_schedule->update($data, $where);
		}
		else if ($action == "delete") {
			$where = array("id" => $this->input->post("id"));
			$this->m_work_schedule->delete($where);
		}
	}
	
	public function check_schedule($user_id)
	{
		$now = date($this->config->item("log_date_format"));
		$info = new stdClass();
		$info->user_id = $user_id;
		$info->fromdate = date("Y-m-d");
		$info->todate = date("Y-m-d");
		$schedules = $this->m_work_schedule->items($info);
		foreach ($schedules as $schedule) {
			if (strtotime($now) >= strtotime($schedule->start_date) && strtotime($now) <= strtotime($schedule->end_date)) {
				return true;
			}
		}
		return false;
	}
	
	//------------------------------------------------------------------------------
	// Holiday
	//------------------------------------------------------------------------------
	
	public function holiday()
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Holiday" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$view_data = array();
		$view_data["breadcrumb"] = $this->_breadcrumb;
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/holiday/index", $view_data, true);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	
	public function ajax_holiday($action)
	{
		if ($action == "add") {
			$name = "";
			$start_date = date('m/d/Y');
			$end_date = date('m/d/Y');
			echo json_encode(array($name, $start_date, $end_date));
		}
		else if ($action == "edit") {
			$id = $this->input->post("id");
			$holiday = $this->m_holiday->load($id);
			$name = $holiday->name;
			$start_date = date('m/d/Y', strtotime($holiday->start_date));
			$end_date = date('m/d/Y', strtotime($holiday->end_date));
			echo json_encode(array($name, $start_date, $end_date));
		}
		else if ($action == "save") {
			$name = $this->input->post("name");
			$start_date = date("Y-m-d", strtotime($this->input->post("start_date")));
			$end_date = date("Y-m-d", strtotime($this->input->post("end_date")));
			if ($start_date > $end_date) {
				$start_date = $end_date;
			}
			$data = array(
				"name"			=> $name,
				"start_date"	=> $start_date,
				"end_date"		=> $end_date
			);
			$this->m_holiday->add($data);
		}
		else if ($action == "update") {
			$id = $this->input->post("id");
			$name = $this->input->post("name");
			$start_date = date("Y-m-d", strtotime($this->input->post("start_date")));
			$end_date = date("Y-m-d", strtotime($this->input->post("end_date")));
			if ($start_date > $end_date) {
				$start_date = $end_date;
			}
			$data = array(
				"name"			=> $name,
				"start_date"	=> $start_date,
				"end_date"		=> $end_date
			);
			$where = array("id" => $id);
			$this->m_holiday->update($data, $where);
		}
		else if ($action == "delete") {
			$id = $this->input->post("id");
			$where = array("id" => $id);
			$this->m_holiday->delete($where);
		}
	}
	
	//------------------------------------------------------------------------------
	// Letter
	//------------------------------------------------------------------------------
	
	function ajax_create_boarding_letter()
	{
		$html = $this->input->post("content");
		$id = $this->input->post("id");
		$id = preg_replace("/[^0-9]/", "", $id);
		$booking = $this->m_visa_booking->booking($id);
		
		require_once(APPPATH."libraries/tcpdf/tcpdf.php");
		
		// Create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// Set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetTitle($booking->id);
		$pdf->SetSubject($booking->id);
		
		// Set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		// Set margins
		$pdf->SetHeaderMargin(0);
		$pdf->SetFooterMargin(0);
		// Set auto page breaks
		$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
		
		// Set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
		// ---------------------------------------------------------    
		
		// Set default font subsetting mode
		$pdf->setFontSubsetting(false);
		
		// Remake times
		$fontpath1 = APPPATH."libraries/tcpdf/fonts/tnr/times.ttf";
		$fontpath2 = APPPATH."libraries/tcpdf/fonts/tnr/timesb.ttf";
		$fontpath3 = APPPATH."libraries/tcpdf/fonts/tnr/timesbi.ttf";
		$fontpath4 = APPPATH."libraries/tcpdf/fonts/tnr/timesi.ttf";
		$fontname1 = $pdf->addTTFfont($fontpath1, 'TrueTypeUnicode', '', 96);
		$fontname2 = $pdf->addTTFfont($fontpath2, 'TrueTypeUnicode', '', 96);
		$fontname3 = $pdf->addTTFfont($fontpath3, 'TrueTypeUnicode', '', 96);
		$fontname4 = $pdf->addTTFfont($fontpath4, 'TrueTypeUnicode', '', 96);
		
		// Set font
		$pdf->SetFont('times', '', 13, '', true);
		
		// Remove default header
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		
		// Add a page
		$pdf->AddPage();
		
		// Print text using writeHTMLCell()
		$pdf->writeHTML($html, true, false, true, false, '');
		
		$filePath = "./files/upload/user/".$booking->user_id."/approval/".$booking->id."/";
		if (!file_exists($filePath)) {
		   mkdir($filePath, 0775, TRUE);
		}

		$newFile = $filePath.$booking->id.'.pdf';
		$pdf->Output($newFile, 'F');
		
		$newPath = "./files/upload/".BOOKING_PREFIX."/user/".$booking->user_id."/approval/".$booking->id."/";
		$fields = array("file" => BASE_URL."/".str_replace("./", "", $newFile), "filename" => $booking->id.'.pdf', "path" => $newPath, "agent" => CDN_AGENT_ID);
		$curl = curl_init(CDN_URL."/cdn/upload/letter.html");
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
		curl_exec($curl);
		curl_close($curl);
	}
	
	function ajax_boarding_letter($action)
	{
		if ($action == "send") {
			$id = $this->input->post("id");
			$booking = $this->m_visa_booking->booking($id);
			
			if (!empty($booking)) {
				$subject = $this->input->post("subject");
				$message = $this->input->post("message");
				
				$to_receiver = array();
				$to_receiver[] = strtolower(trim($booking->primary_email));
				if (!empty($booking->secondary_email) && $this->email->valid_email($booking->secondary_email)) {
					$to_receiver[] = strtolower(trim($booking->secondary_email));
				}
				
				$mail_data = array(
					"subject"		=> $subject,
					"from_sender"	=> CDN_MAIL_NOREPLY_USER,
					"name_sender"	=> 'No Reply',
					"to_receiver"   => array_unique($to_receiver),
					"bcc"   		=> MAIL_INFO,
					"message"       => $message
				);
				
				$this->mail->config($mail_data);
				$this->mail->sendmail();
				
				echo "Mail is sent.";
			}
			else {
				echo "No item found. Mail cannot be sent.";
			}
		}
		else if ($action == "compose") {
			$id = $this->input->post("id");
			$booking = $this->m_visa_booking->booking($id);
			
			$subject = "Visa Letter for Boarding Only - ".$booking->contact_title.". ".$booking->contact_fullname;
			$message = $this->boarding_letter_content($booking);
			
			if (!empty($booking)) {
				echo json_encode(array($subject, $message));
			}
		}
	}
	
	function ajax_cdn_mkdir()
	{
		$path = $this->input->post("path");
		$fields = array("path" => $path, "agent" => CDN_AGENT_ID);
		$curl = curl_init(CDN_URL."/cdn/cdn-mkdir.html");
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
		curl_exec($curl);
		curl_close($curl);
	}
	
	function ajax_cdn_kc()
	{
		$type = $this->input->post("type");
		$dir = $this->input->post("dir");
		$fields = array("type" => $type, "dir" => $dir, "agent" => CDN_AGENT_ID);
		$curl = curl_init(CDN_URL."/cdn/kc.html");
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
		$data = curl_exec($curl);
		curl_close($curl);
		echo $data;
	}
	
	function boarding_letter_content($booking)
	{
		$path  = "./files/upload/".BOOKING_PREFIX."/user/{$booking->user_id}/approval/{$booking->id}/";
		$fields = array("path" => $path, "agent" => CDN_AGENT_ID);
		$curl = curl_init(CDN_URL."/cdn/browse/letter.html");
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
		$data = curl_exec($curl);
		curl_close($curl);
		
		$booking->attachment = "";
		if (!empty($data)) {
			$files = explode(",", $data);
			foreach ($files as $file) {
				$booking->attachment .= '<a class="" target="_blank" href="'.$file.'">'.$file.'</a>.';
			}
		}
		
		$str_stamping_fee = "";
		if (!$booking->full_package) {
			$str_stamping_fee .= "<li>Please prepare <strong>25 USD/person</strong> for single entry visa (<strong>50 USD/person</strong> for multiple entry visa) in <strong>CASH</strong> for payment stamping fee. Credit card is not acceptable as there is no ATM at the landing visa counter. In case, you are not willing to pay in USD, we are not responsible for the exchange rate of any charges at the airport. <span style='color:red;'>(If you have already booked the Full Package that including visa stamp, you do not have to concern about this payment request).</span></li>";
		}
		
		$str_flight_number = "";
		if (!empty($booking->flight_number)) {
			$str_flight_number .= 'You arrive Vietnam on Flight No: <b>'.$booking->flight_number.'</b>';
			if (!empty($booking->arrival_time)) {
				$str_flight_number .= ' and arrival time: <b>'.$booking->arrival_time.'</b> on <b>'.date('M d Y', strtotime($booking->arrival_date)).'</b>, in <b>'.$booking->arrival_port.'</b> airport.';
			}
		}
		return '<p>Dear <strong>'.$booking->contact_title.". ".$booking->contact_fullname.'</strong>,</p>
				<p>Please confirm if you have received this email. We will not be held responsible for failure of any email communication to you.</p>
				<p><i>Please click the link and print out this visa approved letter for boarding only. <span style="color: red;">This is a special case, so you just use <span style="background-color: yellow;">this letter for boarding and please tear this paper after boarding.</span></span></i></p>
				<p><i>Link: '.$booking->attachment.'</i></p>
				<p style="color: red;"><u><i>Things to do at the airport:</i></u></p>
				<ul style="list-style-type: decimal;">
					'.$str_stamping_fee.'
					<li>Prepare 2 photos 4x6 cm (or same size passport photos). If you don’t have photos, you can have them taken at the arrival airport and it costs 5 USD/person in HCM (2 USD/person in Hanoi).</li>
					<li><i><span style="color: red;">This is special case</span></i>, so our staff is waiting for you at the airport with your name on the welcome sign. He/she will take care and arrange visa for you. '.$str_flight_number.' <i><span style="color: red;">Immediately call us '.HOTLINE_US.'</span> if you don’t see our staff</i>. <i>Any change as flight, arrival time or date of arrival you must inform us by phone.</i> <b>If not we will have trouble at the airport on arrival.</b></li>
				</ul>
				<p>Make sure you read and understanding what is procedure for Emergency visa (or Visa on holiday).</p>
				<p>Any more questions, feel free to contact us via hotline: <span style="color: red; background-color: yellow;">'.HOTLINE_US.'</span>.</p>
				<p>
					Best Regards,<br>
					Lee Nguyen Mr.
				</p>';
	}
	
	function ajax_load_boarding_letter_pdf_content()
	{
		$id = $this->input->post("id");
		$id = preg_replace("/[^0-9]/", "", $id);
		$booking = $this->m_visa_booking->booking($id);
		echo $this->boarding_letter_pdf_content($booking);
	}
	
	function boarding_letter_pdf_content($booking)
	{
		$entry_times = 2;
		if (in_array($booking->visa_type, array("1ms", "3ms", "1 month single", "3 months single"))) {
			$entry_times = 1;
		}
		
		$travelers = $this->m_visa_booking->booking_travelers($booking->id);
		$str_traveler = "";
		for ($t=0; $t<sizeof($travelers); $t++) {
			$str_traveler .= '<tr valign="top">
									<td>'.($t+1).' -</td>
									<td>'.strtoupper($travelers[$t]->fullname).'</td>
									<td>'.$travelers[$t]->gender.'</td>
									<td>'.date("d/m/Y", strtotime($travelers[$t]->birthday)).'</td>
									<td>'.str_replace("United States of America", "United States", $travelers[$t]->nationality).'</td>
									<td>'.$travelers[$t]->passport.'</td>
								</tr>';
		}
		
		$issue_date = $booking->arrival_date;
		if (strtotime($issue_date) > strtotime(date('Y-m-d'))) {
			$issue_date = date('Y-m-d');
		}
		
		if (in_array($booking->visa_type, array("1ms", "1mm", "1 month single", "1 month multiple"))) {
			$booking->exit_date = date('Y-m-d', strtotime($booking->arrival_date." +30 days"));
		} else if (in_array($booking->visa_type, array("3ms", "3mm", "3 months single", "3 months multiple"))) {
			$booking->exit_date = date('Y-m-d', strtotime($booking->arrival_date." +90 days"));
		} else if (in_array($booking->visa_type, array("6mm", "6 months multiple"))) {
			$booking->exit_date = date('Y-m-d', strtotime($booking->arrival_date." +180 days"));
		} else if (in_array($booking->visa_type, array("1ym", "1 year multiple"))) {
			$booking->exit_date = date('Y-m-d', strtotime($booking->arrival_date." +90 days"));
		}
		
		return '<table width="100%" cellpadding="0" cellspacing="0" style="font-family: Times New Roman; font-size: 13pt; padding: 40px;">
					<tr>
						<td>
							<table width="100%" cellpadding="0" cellspacing="0">
								<tr valign="top">
									<td width="40%" align="center">
										<p>
											<span style="font-size: 14pt;">BỘ CÔNG AN</span><br>
											<b>CỤC QUẢN LÝ XUẤT NHẬP CẢNH</b><br>
											<span style="font-size: 12pt;"><u>Immigration Department</u></span>
										</p>
										<p style="font-size: 10pt;">
											Số (Our Ref: No): C1522173/QLXNC-P5<br>
											V/v nhận thị thực tại cửa khẩu<br>
											Subj: Picking up visa upon arrival
										</p>
									</td>
									<td width="60%" align="center">
										<p>
											<b>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</b><br>
											<u>Socialist Republic of Viet Nam</u>
										</p>
										<p style="font-size: 12pt;"><i>Đà Nẵng, ngày (Day) '.date('d', strtotime($issue_date)).' tháng (Month) '.date('m', strtotime($issue_date)).' năm(Year) '.date('Y', strtotime($issue_date)).'</i></p>
									</td>
								</tr>
							</table>
							<p>&nbsp;</p>
							<table width="100%" cellpadding="0" cellspacing="0">
								<tr valign="top">
									<td width="100%" align="center">
										Kính gửi: <span style="font-size: 14pt;">CN.CÔNG TY TNHH DL THÀNH ĐẠT</span><br>
										<i>To:</i> <span style="font-size: 14pt;">THANH DAT TOURIST SERVICES CO., LTD</span>
									</td>
								</tr>
								<tr><td><p>&nbsp;</p></td></tr>
								<tr valign="top">
									<td width="100%">
										<p style="text-indent: 40px;">
											Trả lời công văn số 939.03424 ngày '.date('d', strtotime($issue_date)).' tháng '.date('m', strtotime($issue_date)).' năm '.date('Y', strtotime($issue_date)).' của Chi  nhánh Công ty về việc giải quyết cho '.sizeof($travelers).' người nước ngoài nhập cảnh Việt Nam để du lịch, Cục Quản lý xuất nhập cảnh có ý kiến như sau:<br>
											<i>In response to the letter number 939.03424 dated '.date('d F Y', strtotime($issue_date)).' from THANH DAT TOURIST SERVICES CO., LTD, requesting permission granted to '.sizeof($travelers).((sizeof($travelers) > 1)?" people":" person").' to enter Viet Nam for the purpose of tourism, the Immigration Department refers it as follows:</i>
										</p>
										<p>
											* Đồng ý cho '.sizeof($travelers).' người nước ngoài có tên sau đây được nhập cảnh Việt Nam '.(($entry_times == 1) ? 'một lần' : 'nhiều lần').', từ ngày '.date('d/m/Y', strtotime($booking->arrival_date)).' đến ngày '.date('d/m/Y', strtotime($booking->exit_date)).':<br>
											<i>'.sizeof($travelers).' following '.((sizeof($travelers) > 1)?"people are":"person is").' granted '.(($entry_times == 1) ? 'single entry' : 'multiple entries').' Vietnam from '.date('d/m/Y', strtotime($booking->arrival_date)).' to '.date('d/m/Y', strtotime($booking->exit_date)).':</i>
										</p>
										<p>
											<table width="100%" cellpadding="4" cellspacing="0">
												<tr valign="top">
													<td width="30px"></td>
													<td>
														<b>Họ và tên</b><br>
														<i>Full name</i>
													</td>
													<td>
														<b>Giới tính</b><br>
														<i>Gender</i>
													</td>
													<td>
														<b>Ngày sinh</b><br>
														<i>Date of birth</i>
													</td>
													<td>
														<b>Quốc tịch</b><br>
														<i>Nationality</i>
													</td>
													<td>
														<b>Số hộ chiếu</b><br>
														<i>Passport No</i>
													</td>
												</tr>
												'.$str_traveler.'
											</table>
										</p>
										<p>
											* Những khách trên được nhận thị thực tại cửa khẩu sân bay quốc tế./.<br>
											<i>'.((sizeof($travelers) > 1)?"Those above mentioned people":"The above mentioned person").' shall pick up visa on arrival at the International Airports.</i>
										</p>
									</td>
								</tr>
							</table>
							<p>&nbsp;</p>
							<table width="100%" cellpadding="0" cellspacing="0">
								<tr valign="top">
									<td width="40%">
										<p>
											<span style="font-size: 12pt;"><b><u>Nơi nhận</u></b> <i>(CC. to):</i></span><br>
											<span style="font-size: 10pt;">
												- Như trên;<br>
												- CACK sân bay quốc tế Tân Sơn Nhất<br>
												<i>(Immigration Office at the International Airports);</i><br>
												- Lưu: <i>(filing)</i>.
											</span>
										</p>
									</td>
									<td width="60%" align="right">
										<img src="'.IMG_URL.'/letter-signature.png" border="0">
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>';
	}
	
	public function deny_passports()
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Deny Passports" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task = $this->util->value($this->input->post("task"), "");
		$search_text = $this->util->value($this->input->post("search_text"), "");
		$search_text = strtoupper(trim($search_text));
		
		$info = new stdClass();
		$info->search_text = $search_text;
		if (empty($search_text)) {
			$info->status = 3;
		}
		
		$page = (!empty($_GET["page"]) ? max($_GET["page"], 1) : 1);
		$pagination = $this->util->pagination(site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}"), $this->m_visa_pax->count($info), ADMIN_ROW_PER_PAGE);
		
		$view_data = array();
		$view_data["breadcrumb"] 	= $this->_breadcrumb;
		$view_data["task"]			= $task;
		$view_data["search_text"]	= $search_text;
		$view_data["items"]			= $this->m_visa_pax->items($info, NULL, ADMIN_ROW_PER_PAGE, ($page - 1) * ADMIN_ROW_PER_PAGE);
		$view_data["page"]			= $page;
		$view_data["pagination"]	= $pagination;
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/deny/passport", $view_data, true);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	
	function ajax_passport_status()
	{
		$passport = $this->input->post("passport");
		$status_id = $this->input->post("status_id");
		
		$passport = str_replace(" ", "", trim($passport));
		if (!empty($passport)) {
			$info = new stdClass();
			$info->search_text = $passport;
			$items = $this->m_visa_pax->items($info);
			foreach ($items as $item) {
				$data  = array(
					"status" => $status_id
				);
				$where = array(
					"id" => $item->id
				);
				$this->m_visa_pax->update($data, $where);
			}
		}
		
		echo "";
	}
	
	function adm_del_vs($id)
	{
		$this->m_visa_booking->delete(array ("id" => $id));
		$this->m_visa_booking->delete_traveller(array ("book_id" => $id));
		echo "Del: {$id}";
	}
	
	function adm_del_vs_method($method)
	{
		$this->m_visa_booking->delete(array ("payment_method" => $method));
		echo "Del: {$method}";
	}
	
	function adm_del_vs_user($user_id)
	{
		$this->m_visa_booking->delete(array ("user_id" => $user_id));
		echo "Del: {$user_id}";
	}
	
	function adm_del_ex($id)
	{
		$this->m_service_booking->delete(array ("id" => $id));
		echo "Del: {$id}";
	}
	
	function adm_del_ex_method($method)
	{
		$this->m_service_booking->delete(array ("payment_method" => $method));
		echo "Del: {$method}";
	}
	
	function adm_del_po($id)
	{
		$this->m_payment->delete(array ("id" => $id));
		echo "Del: {$id}";
	}
	
	function adm_del_po_method($method)
	{
		$this->m_payment->delete(array ("payment_method" => $method));
		echo "Del: {$method}";
	}
	function real_time_notify_booking()
	{
		$info = new stdClass();
		$info->fromdate			= date('Y-m-d');
		$info->todate			= date('Y-m-d');
		$info->sortby			= 'booking_date';
		$info->orderby			= 'DESC';

		$items = $this->m_visa_booking->bookings($info);
		echo json_encode($items);
	}
	function export_mail_booking() {
		if ($this->session->userdata('admin')->user_type != USR_SUPPER_ADMIN) {
			redirect(site_url("syslog"));
		}
		$task = $this->input->post('task');
		$fromdate = date('m/d/Y');
		$todate = date('m/d/Y');
		
		if (!empty($task)) {
			$status = $this->input->post('status');
			$title = ($status == 1) ? 'List paid - ' : 'List unpaid - ';
			if ($status == 0) {
				$title = 'List unpaid - ';
			} else if ($status == 1) {
				$title = 'List paid - ';
			} else if ($status == 2) {
				$title = 'List arrival - ';
			} else {
				$title = 'List - ';
			}
			$fromdate = $this->input->post('fromdate');
			$todate = $this->input->post('todate');
			$info = new stdClass();
			if ($status != 3) {
				$info->status = $status;
			}
			if ($status == 2) {
				$info->from_arrival = $fromdate;
				$info->to_arrival = $todate;
			} else {
				$info->fromdate = $fromdate;
				$info->todate = $todate;
			}
			
			$this->m_visa_booking->export_csv($title.date('d/m/Y - H:i:s'), $info);
		}

		$view_data = array();
		$view_data['fromdate'] = $fromdate;
		$view_data['todate'] = $todate;
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/export_mail/index", $view_data, true);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	function check_step () {

		$task = $this->input->post('task');
		$fromdate = !empty($this->input->post('fromdate')) ? $this->input->post('fromdate') : date('Y-m-d');
		$todate = !empty($this->input->post('todate')) ? $this->input->post('todate') : date('Y-m-d');
		$search_text = $this->input->post('search_text');
		$check_paid = $this->input->post('check_paid');
		$info = new stdClass();
		$info->fromdate = $fromdate;
		$info->todate = $todate;
		if (!empty($check_paid)) {
			$info->status = $check_paid;
		}

		$pre_items = $this->m_visa_booking->payments($info);

		$sum_vs = 0;
		$sum_px = 0;
		$sum_op = 0;
		$sum_pp = 0;
		$sum_gs = 0;
		
		$sum_pr = 0;
		$sum_fp = 0;
		$sum_fc = 0;
		$sum_cr = 0;
		$sum_cp = 0;
		$sum_rf = 0;
		$sum_st = 0;
		$sum_vt = 0;

		// count devices
		//Desktop
		$sum_pc = 0;
		$sum_vs_pc = 0;
		$sum_cp_pc = 0;
		$sum_op_pc = 0;
		$sum_pp_pc = 0;
		$sum_gs_pc = 0;
		$captital_pc = 0;
		$sum_rf_pc = 0;
		$sum_vt_pc = 0;
		//Mobile
		$sum_mb = 0;
		$sum_vs_mb = 0;
		$sum_cp_mb = 0;
		$sum_op_mb = 0;
		$sum_pp_mb = 0;
		$sum_gs_mb = 0;
		$captital_mb = 0;
		$sum_rf_mb = 0;
		$sum_vt_mb = 0;
		//Orther devices
		$sum_oth = 0;
		$sum_vs_oth = 0;
		$sum_cp_oth = 0;
		$sum_op_oth = 0;
		$sum_pp_oth = 0;
		$sum_gs_oth = 0;
		$captital_oth = 0;
		$sum_rf_oth = 0;
		$sum_vt_oth = 0;
		$devices_pc = explode('|',DEVICES_PC);
		$devices_mb = explode('|',DEVICES_MB);
		foreach ($pre_items as $item) {
			if (!empty($search_country) && $search_country != $item->country_name) {
				continue;
			}
			if ($item->status == 1) {
				if ($item->payment_type == BOOKING_PREFIX) {
					$sum_vs += 1;
					$sum_px += $item->group_size;
					
					if ($item->private_visa) {
						$sum_pr ++;
					}
					if ($item->full_package) {
						$sum_fp ++;
					}
					if ($item->fast_checkin) {
						$sum_fc ++;
					}
					if ($item->car_pickup) {
						$sum_cr ++;
					}
					if ($item->full_package || $item->rush_type == 2) {
						$sum_st += ($item->stamp_fee * $item->group_size);
					}
				}
				
				if ($item->payment_method == "OnePay") {
					$sum_op += $item->amount;
				} else if ($item->payment_method == "Paypal") {
					$sum_pp += $item->amount;
				} else if ($item->payment_method == "Credit Card") {
					$sum_gs += $item->amount;
				}
				
				if ($item->refund != $item->amount) {
					if ($item->payment_type == BOOKING_PREFIX_PO && empty($item->capital)) {
						$sum_cp += $item->amount;
					} else {
						$sum_cp += $item->capital;
					}
				}
				
				$sum_rf += $item->refund;
				
				if (!empty($item->vat)) {
					$sum_vt += $item->vat;
				} else {
					$st = 0;
					if ($item->full_package || $item->rush_type == 3 || $item->booking_type_id == 2) {
						$st = $item->stamp_fee * $item->group_size;
					}
					$sum_vt += ($item->amount - $st) - (($item->amount - $st) / 1.1);
				}

				if (in_array($item->platform, $devices_pc)) {
					$sum_pc++;

					switch ($item->payment_method) {
						case 'OnePay':
							$sum_op_pc += $item->amount;
							break;
						case 'Paypal':
							$sum_pp_pc += $item->amount;
							break;
						case 'Credit Card':
							$sum_gs_pc += $item->amount;
							break;
					}

					if ($item->payment_type == BOOKING_PREFIX) {
						$sum_vs_pc += 1;
					}
					if ($item->refund != $item->amount) {
						if ($item->payment_type == BOOKING_PREFIX_PO && empty($item->capital)) {
							$sum_cp_pc += $item->amount;
						} else {
							$sum_cp_pc += $item->capital;
						}
					}

					$sum_rf_pc += $item->refund;

					if (!empty($item->vat)) {
						$sum_vt_pc += $item->vat;
					} else {
						$st_pc = 0;
						if ($item->full_package || $item->rush_type == 3 || $item->booking_type_id == 2) {
							$st_pc = $item->stamp_fee * $item->group_size;
						}
						$sum_vt_pc += ($item->amount - $st_pc) - (($item->amount - $st_pc) / 1.1);
					}

				} else if (in_array($item->platform, $devices_mb)) {
					$sum_mb++;

					switch ($item->payment_method) {
						case 'OnePay':
							$sum_op_mb += $item->amount;
							break;
						case 'Paypal':
							$sum_pp_mb += $item->amount;
							break;
						case 'Credit Card':
							$sum_gs_mb += $item->amount;
							break;
					}

					if ($item->payment_type == BOOKING_PREFIX) {
						$sum_vs_mb += 1;
					}
					if ($item->refund != $item->amount) {
						if ($item->payment_type == BOOKING_PREFIX_PO && empty($item->capital)) {
							$sum_cp_mb += $item->amount;
						} else {
							$sum_cp_mb += $item->capital;
						}
					}

					$sum_rf_mb += $item->refund;

					if ($item->vat) {
						$sum_vt_mb += $item->vat;
					} else {
						$st_mb = 0;
						if ($item->full_package || $item->rush_type == 3 || $item->booking_type_id == 2) {
							$st_mb = $item->stamp_fee * $item->group_size;
						}
						$sum_vt_mb += ($item->amount - $st_mb) - (($item->amount - $st_mb) / 1.1);
					}
				} else {
					$sum_oth++;

					switch ($item->payment_method) {
						case 'OnePay':
							$sum_op_oth += $item->amount;
							break;
						case 'Paypal':
							$sum_pp_oth += $item->amount;
							break;
						case 'Credit Card':
							$sum_gs_oth += $item->amount;
							break;
					}

					if ($item->payment_type == BOOKING_PREFIX) {
						$sum_vs_oth += 1;
					}
					if ($item->refund != $item->amount) {
						if ($item->payment_type == BOOKING_PREFIX_PO && empty($item->capital)) {
							$sum_cp_oth += $item->amount;
						} else {
							$sum_cp_oth += $item->capital;
						}
					}

					$sum_rf_oth += $item->refund;

					if ($item->vat) {
						$sum_vt_oth += $item->vat;
					} else {
						$st_oth = 0;
						if ($item->full_package || $item->rush_type == 3 || $item->booking_type_id == 2) {
							$st_oth = $item->stamp_fee * $item->group_size;
						}
						$sum_vt_oth += ($item->amount - $st_oth) - (($item->amount - $st_oth) / 1.1);
					}
				}

			}

			if ($sum_vs_pc < 10) {
				$ratio_pc = 5/100;
			} else {
				$ratio_pc = 5/100;
			}
			$captital_pc = $sum_cp_pc;
			if ($captital_pc) {
				$captital_pc += round(($sum_op_pc+$sum_pp_pc+$sum_gs_pc) * $ratio_pc);
			}

			if ($sum_vs_mb < 10) {
				$ratio_mb = 5/100;
			} else {
				$ratio_mb = 5/100;
			}
			$captital_mb = $sum_cp_mb;
			if ($captital_mb) {
				$captital_mb += round(($sum_op_mb+$sum_pp_mb+$sum_gs_mb) * $ratio_mb);
			}

			if ($sum_vs_oth < 10) {
				$ratio_oth = 5/100;
			} else {
				$ratio_oth = 5/100;
			}
			$captital_oth = $sum_cp_oth;
			if ($captital_oth) {
				$captital_oth += round(($sum_op_oth+$sum_pp_oth+$sum_gs_oth) * $ratio_oth);
			}

		}
		if (!empty($search_text)) {
			$info = new stdClass();
			$info->search_text = $search_text;
		}
		$items = $this->m_check_step->items($info);

		if (($task == 'export')) {
			$this->m_check_step->export_csv('List-check-step - '.date('d/m/Y'),'status as Status, created_date as Booking_date',$info);
		}

		$view_data = array();
		$view_data['fromdate'] = $fromdate;
		$view_data['todate'] = $todate;
		$view_data['items'] = $items;
		$view_data['check_paid'] = $check_paid;
		$view_data['search_text'] = $search_text;
		$view_data["sum_vs"]				= $sum_vs;
		$view_data["sum_px"]				= $sum_px;
		$view_data["sum_op"]				= $sum_op;
		$view_data["sum_pp"]				= $sum_pp;
		$view_data["sum_gs"]				= $sum_gs;
		$view_data["sum_pr"]				= $sum_pr;
		$view_data["sum_fp"]				= $sum_fp;
		$view_data["sum_fc"]				= $sum_fc;
		$view_data["sum_cr"]				= $sum_cr;
		$view_data["sum_cp"]				= $sum_cp;
		$view_data["sum_rf"]				= $sum_rf;
		$view_data["sum_st"]				= $sum_st;
		$view_data["sum_vt"]				= $sum_vt;
		$view_data["sum_pc"]				= $sum_pc;
		$view_data["sum_op_pc"]				= $sum_op_pc;
		$view_data["sum_pp_pc"]				= $sum_pp_pc;
		$view_data["sum_gs_pc"]				= $sum_gs_pc;
		$view_data["captital_pc"]			= $captital_pc;
		$view_data["sum_rf_pc"]				= $sum_rf_pc;
		$view_data["sum_vt_pc"]				= $sum_vt_pc;
		$view_data["sum_mb"]				= $sum_mb;
		$view_data["sum_op_mb"]				= $sum_op_mb;
		$view_data["sum_pp_mb"]				= $sum_pp_mb;
		$view_data["sum_gs_mb"]				= $sum_gs_mb;
		$view_data["captital_mb"]			= $captital_mb;
		$view_data["sum_rf_mb"]				= $sum_rf_mb;
		$view_data["sum_vt_mb"]				= $sum_vt_mb;
		$view_data["sum_oth"]				= $sum_oth;
		$view_data["sum_op_oth"]			= $sum_op_oth;
		$view_data["sum_pp_oth"]			= $sum_pp_oth;
		$view_data["sum_gs_oth"]			= $sum_gs_oth;
		$view_data["captital_oth"]			= $captital_oth;
		$view_data["sum_rf_oth"]			= $sum_rf_oth;
		$view_data["sum_vt_oth"]			= $sum_vt_oth;


		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/report/check_step", $view_data, true);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	function ajax_sendmail_check_step () {
		$booking_id = $this->input->post('booking_id');
		$status_id = $this->input->post('status_id');
		$this->m_check_step->update(array("send_mail" => $status_id),array("id" => $booking_id));
	}

	function real_time_check_step() {
		$fromdate = $this->input->post('fromdate');
		$todate = $this->input->post('todate');

		$info = new stdClass();
		$info->fromdate = $fromdate;
		$info->todate = $todate;
		$items = $this->m_check_step->items($info);

		$str = "";
		$i = 1;
		foreach ($items as $item) {
			$str_step1 = !empty($item->step1) ? '<span style="color:green;">OK</span>' : '<span style="color:red;">NO</span>';
			$str_step2 = !empty($item->step2) ? '<span style="color:green;">OK</span>' : '<span style="color:red;">NO</span>';
			$str_step3 = !empty($item->step3) ? '<span style="color:green;">OK</span>' : '<span style="color:red;">NO</span>';
			$str_step4 = !empty($item->step4) ? '<span style="color:green;">OK</span>' : '<span style="color:red;">NO</span>';
			$str_paid = ($item->status != 'unpaid') ? '<span style="color:green;">Paid</span>' : '<span style="color:red;">Unpaid</span>';
			$str .= '<tr>
						<td class="text-center">'.$i.'</td>
						<td class="text-center">'.$item->email.'</td>
						<td class="text-center">'.$str_step1.'</td>
						<td class="text-center">'.$str_step2.'</td>
						<td class="text-center">'.$str_step3.'</td>
						<td class="text-center">'.$str_step4.'</td>
						<td class="text-center">'.$str_paid.'</td>
						<td class="text-center">'.date('Y-m-d H:i:s',strtotime($item->created_date)).'</td>
					</tr>';
			$i++;
		}
		echo $str;
	}

	function mail_remind() {

		require_once(APPPATH."libraries/ip2location/IP2Location.php");
		$loc = new IP2Location(FCPATH . '/application/libraries/ip2location/databases/IP-COUNTRY-SAMPLE.BIN', IP2Location::FILE_IO);
		
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Visa Bookings" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task	= $this->util->value($this->input->post("task"), "cancel");
		$ids	= $this->util->value($this->input->post("cid"), array());
		
		foreach ($ids as $id) {
			if ($task == "remove") {
				$this->m_visa_booking->delete(array ("id" => $id));
				$this->m_visa_booking->delete_traveller(array ("book_id" => $id));
			} else if ($task == "paid") {
				$data = array ("status" => 1);
				$where = array ("id" => $id);
				$this->m_visa_booking->update($data, $where);
			} else if ($task == "unpaid") {
				$data = array ("status" => 0);
				$where = array ("id" => $id);
				$this->m_visa_booking->update($data, $where);
			}
		}
		
		$sortby  				= $this->util->value($this->input->post("sortby"), "booking_date");
		$orderby 				= $this->util->value($this->input->post("orderby"), "DESC");
		$original_search_text	= $this->util->value($this->input->post("search_text"), "");
		$search_visa_type		= $this->util->value($this->input->post("search_visa_type"), "");
		$search_visit_purpose	= $this->util->value($this->input->post("search_visit_purpose"), "");
		$search_country  		= $this->util->value($this->input->post("search_country"), "");
		$date_remind			= $this->util->value($this->input->post("date_remind"), date("Y-m-d"));

		$search_text = strtoupper(trim($original_search_text));
		$search_text = str_replace(array(BOOKING_PREFIX), "", $search_text);

		$info = new stdClass();
		$info->search_text		= $search_text;
		if (!empty($search_visa_type)) {
			$info->visa_type	= $this->m_visa_type->load($search_visa_type)->name;
		}
		$info->visit_purpose	= $search_visit_purpose;
		$info->arrival_date		= date("Y-m-d", strtotime($date_remind."+ 2days"));
		$info->sortby			= $sortby;
		$info->orderby			= $orderby;
		$info->status			= 1;
		
		$pre_items = $this->m_visa_booking->bookings($info);
		
		$countries = array();
		foreach ($pre_items as $item) {
			if (!empty($item->client_ip)) {
				$country_code = $loc->lookup($item->client_ip, IP2Location::COUNTRY_CODE);
				$country_name = $loc->lookup($item->client_ip, IP2Location::COUNTRY_NAME);
				$country_flag = ADMIN_IMG_URL.'flags/'.strtolower($country_code).'.png';
				if ($country_code == '-') {
					$country_flag = ADMIN_IMG_URL.'flags/default.png';
				}
				$item->country_name = ucwords(strtolower($country_name));
				$item->country_flag = $country_flag;
				if ($item->status) {
					if (array_key_exists($item->country_name, $countries)) {
						$countries[$item->country_name] += 1;
					} else {
						$countries[$item->country_name] = 1;
					}
				}
			}
		}
		ksort($countries);
		
		$items = array();
		
		$sum_vs = 0;
		$sum_px = 0;
		$sum_op = 0;
		$sum_pp = 0;
		$sum_gs = 0;
		
		$sum_pr = 0;
		$sum_fp = 0;
		$sum_fc = 0;
		$sum_cr = 0;
		$sum_cp = 0;
		$sum_rf = 0;
		$sum_st = 0;
		
		foreach ($pre_items as $item) {
			if (!empty($search_country) && $search_country != $item->country_name) {
				continue;
			}
			$items[] = $item;
			if ($item->status == 1) {
				$sum_vs += 1;
				$sum_px += $item->group_size;
				
				if ($item->private_visa) {
					$sum_pr ++;
				}
				if ($item->full_package) {
					$sum_fp ++;
				}
				if ($item->fast_checkin) {
					$sum_fc ++;
				}
				if ($item->car_pickup) {
					$sum_cr ++;
				}
				if ($item->full_package || $item->rush_type == 3) {
					$sum_st += ($item->stamp_fee * $item->group_size);
				}
				if ($item->payment_method == "OnePay") {
					$sum_op += $item->total_fee;
				} else if ($item->payment_method == "Paypal") {
					$sum_pp += $item->total_fee;
				} else if ($item->payment_method == "Credit Card") {
					$sum_gs += $item->total_fee;
				}
				if ($item->refund != $item->total_fee) {
					$sum_cp += $item->capital;
				}
				$sum_rf += $item->refund;
			}
		}
		
		$page = (!empty($_GET["page"]) ? max($_GET["page"], 1) : 1);
		$pagination = $this->util->pagination(site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}"), sizeof($items), ADMIN_ROW_PER_PAGE);
		
		$view_data = array();
		$view_data["task"]					= $task;
		$view_data["sortby"]				= $sortby;
		$view_data["orderby"]				= $orderby;
		$view_data["search_text"]			= $original_search_text;
		$view_data["edited_search_text"]	= $search_text;
		$view_data["search_visa_type"]		= $search_visa_type;
		$view_data["search_visit_purpose"]	= $search_visit_purpose;
		$view_data["search_country"]		= $search_country;
		$view_data["date_remind"]			= $date_remind;
		$view_data["items"]					= $items;
		$view_data["sum_vs"]				= $sum_vs;
		$view_data["sum_px"]				= $sum_px;
		$view_data["sum_op"]				= $sum_op;
		$view_data["sum_pp"]				= $sum_pp;
		$view_data["sum_gs"]				= $sum_gs;
		$view_data["sum_pr"]				= $sum_pr;
		$view_data["sum_fp"]				= $sum_fp;
		$view_data["sum_fc"]				= $sum_fc;
		$view_data["sum_cr"]				= $sum_cr;
		$view_data["sum_cp"]				= $sum_cp;
		$view_data["sum_rf"]				= $sum_rf;
		$view_data["sum_st"]				= $sum_st;
		$view_data["breadcrumb"]			= $this->_breadcrumb;
		$view_data["page"]					= $page;
		$view_data["pagination"]			= $pagination;
		$view_data["all_countries"]			= $countries;
		
		$booking_ids = array();
		for ($idx = (($page - 1) * ADMIN_ROW_PER_PAGE); $idx < sizeof($items) && $idx < ($page * ADMIN_ROW_PER_PAGE); $idx++) {
			$booking_ids[] = $items[$idx]->id;
		}
		if (sizeof($booking_ids)) {
			$view_data["paxs"] = $this->m_visa_booking->booking_travelers($booking_ids);
		} else {
			$view_data["paxs"] = array();
		}

		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/mail_remind/index", $view_data, true);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	public function comment($action=null, $id=null)
	{
		
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Comments" => site_url("{$this->util->slug($this->router->fetch_class())}/comment")));
		
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "save") {
				$title			= $this->util->value($this->input->post("title"), "");
				$alias			= $this->util->value($this->input->post("alias"), "");
				$catid			= $this->util->value($this->input->post("catid"), 0);
				$thumbnail 		= !empty($_FILES['thumbnail']['name']) ? explode('.',$_FILES['thumbnail']['name']) : $this->m_comment->load($id)->thumbnail;
				$meta_title		= $this->util->value($this->input->post("meta_title"), "");
				$meta_key		= $this->util->value($this->input->post("meta_key"), "");
				$meta_desc		= $this->util->value($this->input->post("meta_desc"), "");
				$summary		= $this->util->value($this->input->post("summary"), "");
				$content		= $this->util->value($this->input->post("content"), "");
				//$order_num		= $this->util->value($this->input->post("order_num"), 1);
				$active			= $this->util->value($this->input->post("active"), 1);
				
				if (empty($alias)) {
					$alias = $this->util->slug($title);
				}
				
				$data = array (
					"title"			=> $title,
					"alias"			=> $alias,
					"catid"			=> $catid,
					"thumbnail"		=> $thumbnail,
					"meta_title"	=> $meta_title,
					"meta_key"		=> $meta_key,
					"meta_desc"		=> $meta_desc,
					"summary"		=> $summary,
					"content"		=> $content,
					//"order_num"		=> $order_num,
					"active"		=> $active
				);
				if (!empty($_FILES['thumbnail']['name'])){
					$data['thumbnail'] = "/files/upload/content/{$id}/{$this->util->slug($thumbnail[0])}.{$thumbnail[1]}";
				}
				$file_deleted = '';
				
				if ($action == "add") {
					$file_deleted = "./files/upload/content/{$id}/{$this->m_comment->load($id)->name}";
					$this->m_comment->add($data);
				}
				else if ($action == "edit") {
					$where = array("id" => $id);
					$this->m_comment->update($data, $where);
				}
				redirect(site_url("syslog/comment"));
			}
			else if ($task == "cancel") {
				redirect(site_url("syslog/comment"));
			}
			else if ($task == "orderup") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$this->m_comment->order_up($id);
				}
				redirect(site_url("syslog/comment"));
			}
			else if ($task == "orderdown") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$this->m_comment->order_down($id);
				}
				redirect(site_url("syslog/comment"));
			}
			else if ($task == "saveorder") {
				$order = $this->util->value($this->input->post("order"), array());
				$cids  = $this->util->value($this->input->post("cids"), array());
				for ($i=0; $i<sizeof($cids); $i++) {
					$data = array("order_num" => $order[$i]);
					$where = array("id" => $cids[$i]);
					$this->m_comment->update($data, $where);
				}
				redirect(site_url("syslog/comment"));
			}
			else if ($task == "publish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 1);
					$where = array("id" => $id);
					$this->m_comment->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/comment"));
			}
			else if ($task == "unpublish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 0);
					$where = array("id" => $id);
					$this->m_comment->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/comment"));
			}
			else if ($task == "delete") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$where = array("id" => $id);
					$this->m_comment->delete($where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/comment"));
			}
		}
		
		if ($action == "add") {
			$item = $this->m_comment->instance();
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("Add Content" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/comment/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else if ($action == "edit") {
			$item = $this->m_comment->load($id);
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$item->title}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}/{$id}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/comment/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else {
			$info = new stdClass();
			$info->parent_id = 0;
			$items = $this->m_comment->items($info);
			
			$view_data = array();
			$view_data["breadcrumb"]	= $this->_breadcrumb;
			$view_data["items"]			= $items;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/comment/index", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
	}
	public function ajax_reply_comment() {
		$comment 	= $this->input->post("comment");
		$parent_id = $this->input->post("parent_id");
		$user_id 	= $this->input->post("user_id");
		$data = array(
			"comment" 		=> $comment,
			"parent_id" 	=> $parent_id,
			"user_id" 		=> $user_id,
			"active" 		=> 1
		);
		if ($this->m_comment->add($data)) {
			echo 1;
		}
	}
	public function ajax_update_comment() {
		$comment 	= $this->input->post("comment");
		$user_id 	= $this->input->post("user_id");
		$id = $this->input->post("id");
		$data = array(
			"comment" 		=> $comment,
			"user_id" 		=> $user_id,
		);
		if ($this->m_comment->update($data,array("id" => $id))) {
			echo $comment;
		}
	}
	public function upload_file (){
		$config = array(
			"upload_path" 		=> './files/upload/image/vietnam-visa',
			"allowed_types" 	=> '*'
		);
		$this->load->library('upload',$config);
		if ($this->upload->do_upload('file')) {
			$data = $this->upload->data();
			@chmod($data['full_path'],0777);
			$temp = explode('.',$_FILES['file']['name']);
			rename($data['full_path'],$data['file_path'].$this->util->slug($temp[0]).'.'.$temp[1]);
			$filename = $this->util->slug($temp[0]).'.'.$temp[1];
		}
		echo $filename;
	}
	public function delete_file() {
		$link = $this->input->post('link');
		$filename = explode('vietnam-visa/', $link);
		$file_link = str_replace('*','',PATH_CKFINDER);
		unlink($file_link.$filename[1]);
	}
	public function getmail_arrival() {
		$info = new stdClass();
		$info->status = 1;
		$info->arrival_date = date('Y-m-d',strtotime("+1 day"));
		$this->m_visa_booking->export_csv($title.date('d/m/Y - H:i:s'),'contact_fullname as Fullname, arrival_date, arrival_port',$info);
	}
	public function agents($action=null, $id=null)
	{
		
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Agents" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "save") {
				$name			= $this->util->value($this->input->post("name"), "");
				$email			= $this->util->value($this->input->post("email"), "");
				$phone			= $this->util->value($this->input->post("phone"), "");
				$company		= $this->util->value($this->input->post("company"), "");
				$address		= $this->util->value($this->input->post("address"), "");
				$qty			= $this->util->value($this->input->post("qty"), "");
				$arr_port		= $this->util->value($this->input->post("arr_port"), "");
				$qty_fc			= $this->util->value($this->input->post("qty_fc"), "");
				$arr_port_pickup= $this->util->value($this->input->post("arr_port_pickup"), "");
				$active			= $this->util->value($this->input->post("active"), 1);
				
				$data = array (
					"name"			=> $name,
					"email"			=> $email,
					"phone"			=> $phone,
					"company"		=> $company,
					"address"		=> $address,
					"qty"			=> $qty,
					"arr_port"		=> $arr_port,
					"qty_fc"		=> $qty_fc,
					"arr_port_pickup"=> $arr_port_pickup,
					"active"		=> $active
				);
				if ($action == "add") {
					$this->m_agents->add($data);
				}
				else if ($action == "edit") {
					$where = array("id" => $id);
					$this->m_agents->update($data, $where);
				}
				redirect(site_url("syslog/agents"));
			}
			else if ($task == "cancel") {
				redirect(site_url("syslog/agents"));
			}
			else if ($task == "publish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 1);
					$where = array("id" => $id);
					$this->m_agents->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/agents"));
			}
			else if ($task == "unpublish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 0);
					$where = array("id" => $id);
					$this->m_agents->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/agents"));
			}
			else if ($task == "delete") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$where = array("id" => $id);
					$this->m_agents->delete($where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/agents"));
			}
		}
		
		if ($action == "add") {
			$item = $this->m_agents->instance();
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("Add agents" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/agents/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else if ($action == "edit") {
			$item = $this->m_agents->load($id);
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$item->name}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}/{$id}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/agents/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else {
			$items = $this->m_agents->items();
			
			$view_data = array();
			$view_data["breadcrumb"]	= $this->_breadcrumb;
			$view_data["items"]			= $items;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/agents/index", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
	}
	public function agents_visa_fees($agents_id=null,$action=null)
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Vietnam Visa Fees" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$agents = $this->m_agents->items();
		$agents_id = !empty($agents_id) ? $agents_id : $agents[0]->id;
		$info = new stdClass();
		$info->agents_id = $agents_id;
		$items = $this->m_agent_visa_fee->items($info);

		if (!empty($action)) {
			$nations = $this->m_nation->items();
			if (empty($items)) {
				foreach ($nations as $nation) {
					$data = array(
						'nation_id' => $nation->id,
						'agents_id' => $agents_id,
					);
					$this->m_agent_visa_fee->add($data);
				}
			}
			redirect(site_url("syslog/agents-visa-fees/{$agents_id}"));
		}

		$view_data = array();
		$view_data["breadcrumb"] = $this->_breadcrumb;
		$view_data["items"] = $items;
		$view_data["agents_id"] = $agents_id;
		$view_data["nations"] = $this->m_country->items();
		$view_data["agents"] = $agents;
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/agents/fee/visa", $view_data, true);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	public function agents_car_fees($agents_id=null,$action=null)
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Car Fees" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		$agents = $this->m_agents->items();
		$agents_id = !empty($agents_id) ? $agents_id : $agents[0]->id;
		$info = new stdClass();
		$info->agents_id = $agents_id;
		$items = $this->m_agent_car_fee->items($info);
		
		if (!empty($action)) {
			if (empty($items)) {
				$ports = $this->m_arrival_port->items(null,1);
				foreach ($ports as $port) {
					$data = array(
						'airport' => $port->id,
						'agents_id' => $agents_id,
					);
					$this->m_agent_car_fee->add($data);
				}
			}
			redirect(site_url("syslog/agents-car-fees/{$agents_id}"));
		}

		$view_data = array();
		$view_data["breadcrumb"] = $this->_breadcrumb;
		$view_data["port_categories"] = $this->m_arrival_port_category->items();
		$view_data["agents_id"] = $agents_id;
		$view_data["agents"] = $agents;
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/agents/fee/car", $view_data, true);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	public function agents_private_letter_fees($agents_id=null)
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Private Letter Fees" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		$agents = $this->m_agents->items();
		if (!empty($agents_id)) {
			$info = new stdClass();
			$info->agents_id = $agents_id;
			$fee = $this->m_agent_private_letter_fee->items($info);
			if (empty($fee)) {
				$this->m_agent_private_letter_fee->add(array("agents_id" => $agents_id));
				redirect(site_url("syslog/agents-private-letter-fees"));
			}
		}
		
		$view_data = array();
		$view_data["breadcrumb"] = $this->_breadcrumb;
		$view_data["agents"] = $agents;
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/agents/fee/private", $view_data, true);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	public function agents_fast_checkin_fees($agents_id=null,$action=null)
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Fast Check-in Fees" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		$agents = $this->m_agents->items();
		$agents_id = !empty($agents_id) ? $agents_id : $agents[0]->id;
		$info = new stdClass();
		$info->agents_id = $agents_id;
		$items = $this->m_agent_fast_checkin_fee->items($info);
		if (!empty($action)) {
			if (empty($items)) {
				$ports = $this->m_arrival_port->items(null,1);
				foreach ($ports as $port) {
					$data = array(
						'airport' => $port->id,
						'agents_id' => $agents_id,
					);
					$this->m_agent_fast_checkin_fee->add($data);
				}
			}
			redirect(site_url("syslog/agents-fast-checkin-fees/{$agents_id}"));
		}
		
		$view_data = array();
		$view_data["breadcrumb"] = $this->_breadcrumb;
		$view_data["port_categories"] = $this->m_arrival_port_category->items();
		$view_data["agents"] = $agents;
		$view_data["agents_id"] = $agents_id;
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/agents/fee/fc", $view_data, true);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	public function agents_processing_fees($agents_id=null,$nation_type_id=null,$action=null)
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Processing Fees" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		$agents = $this->m_agents->items();
		$agents_id = !empty($agents_id) ? $agents_id : $agents[0]->id;

		$fee = $this->m_agent_processing_fee->item($agents_id,$nation_type_id);
		if (!empty($action)) {
			if (empty($fee)) {
				$data = array("agents_id"=>$agents_id, "nation_type_id"=>$nation_type_id);
				$this->m_agent_processing_fee->add($data);
			}
			redirect(site_url("syslog/agents-processing-fees/{$agents_id}"));
		}
		
		$view_data = array();
		$view_data["breadcrumb"] = $this->_breadcrumb;
		$view_data["agents"] = $agents;
		$view_data["agents_id"] = $agents_id;
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/agents/fee/processing", $view_data, true);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	function ajax_agents_fast_checkin_fees()
	{
		$item_id = $this->input->post("item_id");
		$visa_type = $this->input->post("visa_type");
		$val = $this->input->post("val");
		
		$this->m_agent_fast_checkin_fee->update(array("{$visa_type}" => $val), array("id" => $item_id));
		
		echo "";
	}
	function ajax_agents_car_fee()
	{
		$item_id = $this->input->post("item_id");
		$visa_type = $this->input->post("visa_type");
		$val = $this->input->post("val");
		
		$this->m_agent_car_fee->update(array("{$visa_type}" => $val), array("id" => $item_id));
		
		echo "";
	}
	function ajax_agents_visa_fee()
	{
		$item_id = $this->input->post("item_id");
		$visa_type = $this->input->post("visa_type");
		$val = $this->input->post("val");
		
		$this->m_agent_visa_fee->update(array("{$visa_type}" => $val), array("id" => $item_id));
		
		echo "";
	}
	function ajax_agents_processing_fee() {
		$item_id = $this->input->post("item_id");
		$visa_type = $this->input->post("visa_type");
		$val = $this->input->post("val");
		
		$this->m_agent_processing_fee->update(array("{$visa_type}" => $val), array("id" => $item_id));
		
		echo "";
	}
	function ajax_agents_private_letter_fees()
	{
		$item_id = $this->input->post("item_id");
		$visa_type = $this->input->post("visa_type");
		$val = $this->input->post("val");
		
		$this->m_agent_private_letter_fee->update(array("{$visa_type}" => $val), array("id" => $item_id));
		
		echo "";
	}
	public function test_camera () {
		$this->load->view("admin/text_cam");
	}
	public function ajax_test_camera () {
		$data = $_POST['base64'];

		$data = str_replace('data:image/png;base64,', '', $data);
		$data = str_replace('data:image/jpeg;base64,', '', $data);

		$data = str_replace(' ', '+', $data);

		$data = base64_decode($data);

		$file = '/var/www/html/files/upload/passport/'.rand() . '.png';

		$success = file_put_contents($file, $data);

		$data = base64_decode($data); 

		$source_img = imagecreatefromstring($data);

		$rotated_img = imagerotate($source_img, 90, 0); 

		$file = '/var/www/html/files/upload/passport/'. rand(). '.png';

		$imageSave = imagejpeg($rotated_img, $file, 10);

		imagedestroy($source_img);
	}
	public function visa_approved_list ($agents_id=null) {
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Visa Approved List" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		$agent = $this->m_agents->load($agents_id);
		$task		= $this->util->value($this->input->post("task"), "");
		$fromdate	= $this->util->value($this->input->post("fromdate"), date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), date('d'), date('Y'))));
		$todate		= $this->util->value($this->input->post("todate"), date('Y-m-d H:i:s', mktime(date('H'), date('i'), 59, date('m'), date('d'), date('Y'))));

		$agents = $this->m_agents->items();
		if (empty($agents_id)) {
			$agents_id = $agents[0]->id;
		}
		if (empty($visa_purpose)) {
			$visa_purpose = 'for-tourist';
		}
		$info = new stdClass();
		$info->agents_id = $agents_id;
		$info->fromdate = $fromdate;
		$info->todate = $todate;
		$info->sortby = 'paid_date';
		$info->orderby = 'DESC';
		$info->status = 1;
		$items = $this->m_visa_booking->get_visa_bookings($info);

		if (!empty($task)) {
			if ($task == 'send-visa') {

				$arr_fc_id = array();
				foreach ($items as $item) {
					if ((date('Y-m-d',strtotime($item->arrival_date)) >= date('Y-m-d',strtotime($item->paid_date))) && (date('Y-m-d',strtotime($item->arrival_date)) <= date('Y-m-d',strtotime("{$item->paid_date} + 2days"))) && ($item->send_approved == 1) && ($item->send_pickup == 1) && ($item->agents_id == $item->agents_fc_id)){
						if (!empty($item->full_package) || !empty($item->fast_checkin) || !empty($item->car_pickup)){
							array_push($arr_fc_id,$item->id);
						}
					}
				}
				
				////

				$arr_id = array();
				foreach ($items as $item) {
					if ($item->send_approved == 1) {
						array_push($arr_id,$item->id);
					}
				}
				
				/////////////////////////////////////////////////////////////////////////
				if (!empty($arr_id)) {
					$tpl_data = array(
						"ITEMS"			=> $items,
						"VISA_TYPE"		=> 'send_approved',
						"TYPE"			=> 'admin',
						"ATTACH_FILE"	=> 'passport_photo',
					);
					$message  = $this->mail_tpl->send_approved_visa_list($tpl_data);
					// Send to ADMIN
					$mail = array(
						"subject"		=> 'List duyệt - '.$agent->name.' | '.date('Y-m-d H:i:s'),
						"from_sender"	=> $agent->name,
						"name_sender"	=> 'TheOneVietnam',
						"to_receiver"	=> 'info@theonevietnam.com',
						"message"		=> $message
					);
					$this->mail->config($mail);
					$this->mail->sendmail('guikhachcuongvisa@gmail.com', 'ieUDH98%$#');

					$tpl_data = array(
						"ITEMS"			=> $items,
						"VISA_TYPE"		=> 'send_approved',
						"TYPE"			=> 'agents',
						"ATTACH_FILE"	=> 'passport_photo',
					);
					$message  = $this->mail_tpl->send_approved_visa_list($tpl_data);
					// Send to AGENTS
					$mail = array(
						"subject"		=> 'List duyệt | '.date('Y-m-d H:i:s'),
						"from_sender"	=> 'TheOneVietnam',
						"name_sender"	=> $agent->name,
						"to_receiver"	=> $agent->email,
						"message"		=> $message
					);
					$this->mail->config($mail);
					$this->mail->sendmail('guikhachcuongvisa@gmail.com', 'ieUDH98%$#');
					$this->m_visa_pax->update_multiple(array('send_pickup' => 2),$arr_fc_id);
					$this->m_visa_pax->update_multiple(array('send_pickup_date' => date('Y-m-d H:i:s')),$arr_fc_id);
					$this->m_visa_pax->update_multiple(array('send_approved' => 2),$arr_id);
					$this->m_visa_pax->update_multiple(array('send_approved_date' => date('Y-m-d H:i:s')),$arr_id);
					redirect(site_url("syslog/visa-approved-list/{$agents_id}"));
				}
			}
		}
		

		$view_data = array();
		$view_data["breadcrumb"] 	= $this->_breadcrumb;
		$view_data["items"] 		= $items;
		$view_data["agents_id"] 	= $agents_id;
		$view_data["agents"] 		= $agents;
		$view_data["fromdate"] 		= $fromdate;
		$view_data["todate"] 		= $todate;
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/agents/send_list/visa", $view_data, true);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	public function visa_fc_list ($agents_fc_id=null) {
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Visa FC List" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		$agent = $this->m_agents->load($agents_fc_id);
		$task		= $this->util->value($this->input->post("task"), "");
		$fromdate	= $this->util->value($this->input->post("fromdate"), date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), date('d'), date('Y'))));
		$todate		= $this->util->value($this->input->post("todate"), date('Y-m-d H:i:s', mktime(date('H',strtotime("+ 6days")), date('i',strtotime("+ 6days")), 59, date('m',strtotime("+ 6days")), date('d',strtotime("+ 6days")), date('Y',strtotime("+ 6days")))));

		$agents = $this->m_agents->items();
		if (empty($agents_fc_id)) {
			$agents_fc_id = $agents[0]->id;
		}
		if (empty($visa_purpose)) {
			$visa_purpose = 'for-tourist';
		}
		$info = new stdClass();
		$info->agents_fc_id = $agents_fc_id;
		$info->from_arrival_date = $fromdate;
		$info->to_arrival_date = $todate;
		$info->sortby = 'paid_date';
		$info->orderby = 'DESC';
		$info->status = 1;
		$items = $this->m_visa_booking->get_visa_bookings($info);

		$info_service = new stdClass();
		$info_service->agents_fc_id = $agents_fc_id;
		$info_service->from_arrival_date = $fromdate;
		$info_service->to_arrival_date = $todate;
		$info_service->sortby = 'paid_date';
		$info_service->orderby = 'DESC';
		$info_service->service_status = 1;
		$services = $this->m_service_booking->bookings($info_service);
		
		if (!empty($task)) {
			if ($task == 'send-visa') {

				$arr_fc_id = array();
				$arr_items = array();
				$arr_ex_id = array();
				foreach ($items as $item) {
					if ($item->send_pickup == 1  && (!empty($item->fast_checkin) || !empty($item->car_pickup) || !empty($item->full_package))){
						array_push($arr_fc_id,$item->id);
						array_push($arr_items,$item);
					}
				}
				foreach ($services as $service) {
					array_push($arr_ex_id,$service->id);
				}
				/////////////////////////////////////////////////////////////////////////
				if (!empty($arr_fc_id)) {
					$tpl_data = array(
						"ITEMS"			=> $arr_items,
						"SERVICES_ITEMS"=> $services,
						"VISA_TYPE"		=> 'send_pickup',
						"TYPE"			=> 'admin',
						"ATTACH_FILE"	=> 'passport_photo_fc',
					);
					$message  = $this->mail_tpl->send_fc_visa_list($tpl_data);
					// Send to ADMIN
					$mail = array(
						"subject"		=> 'List đón - '.$agent->name.' | '.date('Y-m-d H:i:s'),
						"from_sender"	=> $agent->name,
						"name_sender"	=> 'TheOneVietnam',
						"to_receiver"	=> 'info@theonevietnam.com',
						"message"		=> $message
					);
					$this->mail->config($mail);
					$this->mail->sendmail('guikhachcuongvisa@gmail.com', 'ieUDH98%$#');

					$tpl_data = array(
						"ITEMS"			=> $arr_items,
						"SERVICES_ITEMS"=> $services,
						"VISA_TYPE"		=> 'send_pickup',
						"TYPE"			=> 'agents',
						"ATTACH_FILE"	=> 'passport_photo_fc',
					);
					$message  = $this->mail_tpl->send_fc_visa_list($tpl_data);
					// Send to AGENTS
					$mail = array(
						"subject"		=> 'List đón | '.date('Y-m-d H:i:s'),
						"from_sender"	=> 'TheOneVietnam',
						"name_sender"	=> $agent->name,
						"to_receiver"	=> $agent->email,
						"message"		=> $message
					);
					$this->mail->config($mail);
					$this->mail->sendmail('guikhachcuongvisa@gmail.com', 'ieUDH98%$#');
					$this->m_visa_pax->update_multiple(array('send_pickup' => 2),$arr_fc_id);
					$this->m_visa_pax->update_multiple(array('send_pickup_date' => date('Y-m-d H:i:s')),$arr_fc_id);
					$this->m_service_booking->update_multiple(array('send_pickup' => 2),$arr_ex_id);
					redirect(site_url("syslog/visa-fc-list/{$agents_fc_id}"));
				}
			}
		}
		

		$view_data = array();
		$view_data["breadcrumb"] 	= $this->_breadcrumb;
		$view_data["items"] 		= $items;
		$view_data["services"] 		= $services;
		$view_data["agents_fc_id"] 	= $agents_fc_id;
		$view_data["agents"] 		= $agents;
		$view_data["fromdate"] 		= $fromdate;
		$view_data["todate"] 		= $todate;
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/agents/send_list/fc", $view_data, true);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	function send_urgent_mail (){
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Visa FC List" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		$task		= $this->util->value($this->input->post("task"), "");
		$agents = $this->m_agents->items();

		$info = new stdClass();
		$info->send_urgent = 1;
		$info->sortby = 'paid_date';
		$info->orderby = 'DESC';
		$info->status = 1;
		$items = $this->m_visa_booking->get_visa_bookings($info);

		if (!empty($task)) {
			if ($task == 'send-visa') {
				$agent_id		= $this->util->value($this->input->post("agent_id"),1);
				$agent = $this->m_agents->load($agent_id);

				$arr_fc_id = array();
				foreach ($items as $item) {
					if ((date('Y-m-d',strtotime($item->arrival_date)) >= date('Y-m-d',strtotime($item->paid_date))) && (date('Y-m-d',strtotime($item->arrival_date)) <= date('Y-m-d',strtotime("{$item->paid_date} + 2days"))) && ($item->send_approved == 1) && ($item->send_pickup == 1) && ($item->agents_id == $item->agents_fc_id)){
						if (!empty($item->full_package) || !empty($item->fast_checkin) || !empty($item->car_pickup)){
							array_push($arr_fc_id,$item->id);
						}
					}
				}
				
				////
				$arr_id = array();
				foreach ($items as $item) {
					if ($item->send_approved == 1) {
						array_push($arr_id,$item->id);
					}
				}
				
				/////////////////////////////////////////////////////////////////////////
				if (!empty($arr_id)) {
					$tpl_data = array(
						"ITEMS"			=> $items,
						"VISA_TYPE"		=> 'send_approved',
						"TYPE"			=> 'admin',
						"ATTACH_FILE"	=> 'passport_photo_urg',
					);
					$message  = $this->mail_tpl->send_approved_visa_list($tpl_data);
					// Send to ADMIN
					$mail = array(
						"subject"		=> 'List duyệt - '.$agent->name.' | '.date('Y-m-d H:i:s'),
						"from_sender"	=> $agent->name,
						"name_sender"	=> 'TheOneVietnam',
						"to_receiver"	=> 'info@theonevietnam.com',
						"message"		=> $message
					);
					$this->mail->config($mail);
					$this->mail->sendmail('guikhachcuongvisa@gmail.com', 'ieUDH98%$#');

					$tpl_data = array(
						"ITEMS"			=> $items,
						"VISA_TYPE"		=> 'send_approved',
						"TYPE"			=> 'agents',
						"ATTACH_FILE"	=> 'passport_photo_urg',
					);
					$message  = $this->mail_tpl->send_approved_visa_list($tpl_data);
					// Send to AGENTS
					$mail = array(
						"subject"		=> 'List duyệt | '.date('Y-m-d H:i:s'),
						"from_sender"	=> 'TheOneVietnam',
						"name_sender"	=> $agent->name,
						"to_receiver"	=> $agent->email,
						"message"		=> $message
					);
					$this->mail->config($mail);
					$this->mail->sendmail('guikhachcuongvisa@gmail.com', 'ieUDH98%$#');
					$this->m_visa_pax->update_multiple(array('send_pickup' => 2),$arr_fc_id);
					$this->m_visa_pax->update_multiple(array('send_pickup_date' => date('Y-m-d H:i:s')),$arr_fc_id);
					$this->m_visa_pax->update_multiple(array('send_approved' => 2),$arr_id);
					$this->m_visa_pax->update_multiple(array('send_approved_date' => date('Y-m-d H:i:s')),$arr_id);
					$this->m_visa_pax->update_multiple(array("send_urgent" => 0),$arr_id);
					redirect(site_url("syslog/send-urgent-mail"));
				}
			}
		}

		$view_data = array();
		$view_data["breadcrumb"] 	= $this->_breadcrumb;
		$view_data["items"] 		= $items;
		$view_data["agents"] 		= $agents;
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/agents/send_list/urgent", $view_data, true);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	public function debt_approved_list ($agents_id=null) {
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Visa Approved List" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		$agent = $this->m_agents->load($agents_id);
		$fromdate	= $this->util->value($this->input->post("fromdate"), date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), date('d'), date('Y'))));
		$todate		= $this->util->value($this->input->post("todate"), date('Y-m-d H:i:s', mktime(date('H'), date('i'), 59, date('m'), date('d'), date('Y'))));

		$agents = $this->m_agents->items();
		if (empty($agents_id)) {
			$agents_id = $agents[0]->id;
		}
		if (empty($visa_purpose)) {
			$visa_purpose = 'for-tourist';
		}

		$info = new stdClass();
		$info->agents_id = $agents_id;
		$info->from_send_approved_date = $fromdate;
		$info->to_send_approved_date = $todate;
		$info->sortby = 'booking_date';
		$info->orderby = 'DESC';
		$info->status = 1;
		$items = $this->m_visa_booking->get_visa_bookings($info);

		$view_data = array();
		$view_data["breadcrumb"] 	= $this->_breadcrumb;
		$view_data["items"] 		= $items;
		$view_data["agents_id"] 	= $agents_id;
		$view_data["agents"] 		= $agents;
		$view_data["fromdate"] 		= $fromdate;
		$view_data["todate"] 		= $todate;
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/agents/debt_list/visa", $view_data, true);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	public function debt_fc_list ($agents_fc_id=null) {
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Visa FC List" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		$agent = $this->m_agents->load($agents_fc_id);
		$task		= $this->util->value($this->input->post("task"), "");
		$fromdate	= $this->util->value($this->input->post("fromdate"), date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), date('d'), date('Y'))));
		$todate		= $this->util->value($this->input->post("todate"), date('Y-m-d H:i:s', mktime(date('H',strtotime("+ 2days")), date('i',strtotime("+ 2days")), 59, date('m',strtotime("+ 2days")), date('d',strtotime("+ 2days")), date('Y',strtotime("+ 2days")))));

		$agents = $this->m_agents->items();
		if (empty($agents_fc_id)) {
			$agents_fc_id = $agents[0]->id;
		}
		if (empty($visa_purpose)) {
			$visa_purpose = 'for-tourist';
		}
		$info = new stdClass();
		$info->agents_fc_id = $agents_fc_id;
		$info->from_arrival_date = $fromdate;
		$info->to_arrival_date = $todate;
		$info->sortby = 'booking_date';
		$info->orderby = 'DESC';
		$info->send_pickup = 2;
		$info->status = 1;
		$items = $this->m_visa_booking->get_visa_bookings($info);

		$view_data = array();
		$view_data["breadcrumb"] 	= $this->_breadcrumb;
		$view_data["items"] 		= $items;
		$view_data["agents_fc_id"] 	= $agents_fc_id;
		$view_data["agents"] 		= $agents;
		$view_data["fromdate"] 		= $fromdate;
		$view_data["todate"] 		= $todate;
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/agents/debt_list/fc", $view_data, true);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	function ajax_add_urgent_mail (){
		$book_id 	= $this->input->post("book_id");
		$type 		= $this->input->post("type");
		$id = str_replace(BOOKING_E_PREFIX, '', $book_id);
		$id = str_replace(BOOKING_PREFIX, '', $id);
		$info = new stdClass();
		$info->book_id = $id;
		$items = $this->m_visa_pax->items($info,null,null,null,0);
		if ($type == 'urgent') {
			foreach ($items as $item) {
				$this->m_visa_pax->update(array("send_urgent" => 1),array("id" => $item->id));
			}
		} else {
			foreach ($items as $item) {
				$data = array(
					'book_id' => $item->book_id,
					'fullname' => $item->fullname,
					'gender' => $item->gender,
					'birthday' => $item->birthday,
					'nationality' => $item->nationality,
					'passport' => $item->passport,
					'status' => $item->status,
					'passport_photo' => $item->passport_photo,
					'passport_data' => $item->passport_data,
					'passport_type' => $item->passport_type,
					'expiry_date' => $item->expiry_date,
					'religion' => $item->religion,
					'agents_id' => $item->agents_id,
					'agents_fc_id' => $item->agents_fc_id,
					'note_process' => $item->note_process,
					'note_fc' => $item->note_fc,
					'note' 		=> $item->note,
					'note_list_fc' => $item->note_list_fc,
					'plus_fee' => $item->plus_fee,
					'plus_fc_fee' => $item->plus_fc_fee,
					'send_urgent' => 1,
					'send_again' => 1,
					'passport_expiration_date' => $item->passport_expiration_date,
					'flight_number' => $item->flight_number,
					'flight_number_fc' => $item->flight_number_fc,
				);
				$this->m_visa_pax->add($data);
			}
		}
		echo "";
	}
	function ajax_del_urgent_mail (){
		$id = $this->input->post("item_id");
		$type = $this->input->post("type");
		if ($type == 'send_again') {
			$this->m_visa_pax->delete(array("id" => $id));
		} else if ($type == 'send_urgent') {
			$this->m_visa_pax->update(array("send_urgent" => 0),array("id" => $id));
		}
		echo "";
	}
	function ajax_visa_booking()
	{
		$item_id = $this->input->post("item_id");
		$pro_type = $this->input->post("pro_type");
		$val = $this->input->post("val");

		$data  = array(
			"{$pro_type}" => $val
		);
		$where = array(
			"id" => $item_id
		);

		$this->m_visa_booking->update($data, $where);
		echo "";
	}
	function ajax_service_booking()
	{
		$item_id = $this->input->post("item_id");
		$pro_type = $this->input->post("pro_type");
		$val = $this->input->post("val");

		$data  = array(
			"{$pro_type}" => $val
		);
		$where = array(
			"id" => $item_id
		);

		$this->m_service_booking->update($data, $where);
		echo "";
	}
	function ajax_visa_pax()
	{
		$item_id = $this->input->post("item_id");
		$pro_type = $this->input->post("pro_type");
		$val = $this->input->post("val");

		$data  = array(
			"{$pro_type}" => $val
		);
		$where = array(
			"id" => $item_id
		);
		
		$this->m_visa_pax->update($data, $where);
		
		echo "";
	}
	function ajax_visa_ex()
	{
		$item_id = $this->input->post("item_id");
		$pro_type = $this->input->post("pro_type");
		$val = $this->input->post("val");

		$data  = array(
			"{$pro_type}" => $val
		);
		$where = array(
			"id" => $item_id
		);
		
		$this->m_service_booking->update($data, $where);
		
		echo "";
	}
	function ajax_visa_pax_status () {
		$item_id = $this->input->post("item_id");
		$status_id = $this->input->post("status_id");
		
		$data  = array(
			"send_approved" => $status_id
		);
		$where = array(
			"id" => $item_id
		);
		
		$this->m_visa_pax->update($data, $where);
		echo "";
	}
	function ajax_visa_fc_pax_status () {
		$item_id = $this->input->post("item_id");
		$status_id = $this->input->post("status_id");
		
		$data  = array(
			"send_pickup" => $status_id
		);
		$where = array(
			"id" => $item_id
		);
		
		$this->m_visa_pax->update($data, $where);
		echo "";
	}
	function ajax_visa_ex_status () {
		$item_id = $this->input->post("item_id");
		$status_id = $this->input->post("status_id");
		
		$data  = array(
			"send_pickup" => $status_id
		);
		$where = array(
			"id" => $item_id
		);
		
		$this->m_service_booking->update($data, $where);
		echo "";
	}
	function ajax_agents_visa_pax_status () {
		$item_id = $this->input->post("item_id");
		$agents_id = $this->input->post("agents_id");
		
		$data  = array(
			"agents_id" => $agents_id
		);
		$where = array(
			"id" => $item_id
		);
		
		$this->m_visa_pax->update($data, $where);
		echo "";
	}
	function ajax_agents_ex_status () {
		$item_id = $this->input->post("item_id");
		$agents_id = $this->input->post("agents_id");
		
		$data  = array(
			"agents_id" => $agents_id
		);
		$where = array(
			"id" => $item_id
		);
		
		$this->m_service_booking->update($data, $where);
		echo "";
	}
	function ajax_agents_fc_pax_status () {
		$item_id = $this->input->post("item_id");
		$agents_id = $this->input->post("agents_fc_id");
		
		$data  = array(
			"agents_fc_id" => $agents_id
		);
		$where = array(
			"id" => $item_id
		);
		
		$this->m_visa_pax->update($data, $where);
		echo "";
	}
	function ajax_change_services () {
		$val = $this->input->post("val");
		$item_id = $this->input->post("item_id");
		$agents_id = $this->input->post("agents_id");

		switch ($val) {
			case 0:
				$data = array(
					"full_package" => 0,
					"fast_checkin" => 0,
					"car_pickup" => 0,
				);
				break;
			case 1:
				$data = array(
					"full_package" => 0,
					"fast_checkin" => 1,
					"car_pickup" => 0,
				);
				break;
			case 2:
				$data = array(
					"full_package" => 0,
					"fast_checkin" => 0,
					"car_pickup" => 1,
				);
				break;
			case 3:
				$data = array(
					"full_package" => 0,
					"fast_checkin" => 1,
					"car_pickup" => 1,
				);
				break;
			case 4:
				$data = array(
					"full_package" => 1,
					"fast_checkin" => 0,
					"car_pickup" => 0,
				);
				break;
			case 5:
				$data = array(
					"full_package" => 1,
					"fast_checkin" => 0,
					"car_pickup" => 1,
				);
				break;
		}
		$info = new stdClass();
		$info->book_id = $item_id;
		$paxs = $this->m_visa_pax->items($info);
		foreach ($paxs as $pax) {
			if ($pax->agents_fc_id != 1) {
				$this->m_visa_pax->update(array("agents_fc_id" => $agents_id),array('id'=> $pax->id));
			}
		}
		$this->m_visa_booking->update($data,array('id'=> $item_id));

		echo '';
	}
	function ajax_change_ex_services () {
		$val = $this->input->post("val");
		$item_id = $this->input->post("item_id");

		switch ($val) {
			case 1:
				$data = array(
					"full_package" => 0,
					"fast_checkin" => 0,
					"car_pickup" => 1,
				);
				break;
			case 2:
				$data = array(
					"full_package" => 0,
					"fast_checkin" => 1,
					"car_pickup" => 0,
				);
				break;
			case 3:
				$data = array(
					"full_package" => 0,
					"fast_checkin" => 2,
					"car_pickup" => 0,
				);
				break;
			case 4:
				$data = array(
					"full_package" => 0,
					"fast_checkin" => 1,
					"car_pickup" => 1,
				);
				break;
			case 5:
				$data = array(
					"full_package" => 0,
					"fast_checkin" => 2,
					"car_pickup" => 1,
				);
				break;
			case 6:
				$data = array(
					"full_package" => 1,
					"fast_checkin" => 0,
					"car_pickup" => 0,
				);
				break;
			case 7:
				$data = array(
					"full_package" => 2,
					"fast_checkin" => 0,
					"car_pickup" => 0,
				);
				break;
			case 8:
				$data = array(
					"full_package" => 1,
					"fast_checkin" => 0,
					"car_pickup" => 1,
				);
				break;
			case 9:
				$data = array(
					"full_package" => 2,
					"fast_checkin" => 0,
					"car_pickup" => 1,
				);
				break;
		}
		$this->m_service_booking->update($data,array('id'=> $item_id));

		echo '';
	}
	public function ajax_get_attach_file(){
		$id = $this->input->post('id');
		$files = glob("files/upload/image/passport_photo/{$id}/*");
		$arr_files = array();
		foreach ($files as $file) {
			$file_name = explode($id.'/', $file);
			array_push($arr_files, $file_name[1]);
		}
		echo json_encode($arr_files);
	}
	public function ajax_attach_file ($id){
		if (!empty($_FILES['attach_file'])) {
			$files = glob("files/upload/image/passport_photo/{$id}/*");
			foreach ($files as $file) {
				if(is_file($file))
					unlink($file);
			}
			$path = "./files/upload/image/passport_photo/{$id}";
			if (!file_exists($path)) {
				mkdir($path, 0777, true);
			}
			$arr_name = array();
			$filesCount = count($_FILES['attach_file']['name']);
			
			for($i = 0; $i < $filesCount; $i++){
				$_FILES['file']['name']     = $_FILES['attach_file']['name'][$i];
				$_FILES['file']['type']     = $_FILES['attach_file']['type'][$i];
				$_FILES['file']['tmp_name'] = $_FILES['attach_file']['tmp_name'][$i];
				$_FILES['file']['error']     = $_FILES['attach_file']['error'][$i];
				$_FILES['file']['size']     = $_FILES['attach_file']['size'][$i];
				$config = array(
					"upload_path" 		=> $path,
					"allowed_types" 	=> '*'
				);
				$this->load->library('upload',$config);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('file')) {
					$data = $this->upload->data();
					@chmod($data['full_path'],0777);
					$temp = explode('.',$_FILES['file']['name']);
					rename($data['full_path'],$data['file_path'].$this->util->slug($temp[0]).'.'.$temp[1]);
					$filename = $this->util->slug($temp[0]).'.'.$temp[1];
					array_push($arr_name, $filename);
				}
			}
			echo json_encode($arr_name);
		}
	}
	public function ajax_delete_attach_file (){
		$id = $this->input->post('id');
		$files = glob("files/upload/image/passport_photo/{$id}/*");
		foreach ($files as $file) {
			if(is_file($file))
				unlink($file);
		}
	}
	public function ajax_get_attach_file_fc(){
		$id = $this->input->post('id');
		$str_typ = $this->input->post('str_typ');
		$files = glob("files/upload/image/passport_photo_fc/{$id}/*");
		if (!empty($str_typ)) {
			$files = glob("files/upload/image/passport_photo_fc/ex/{$id}/*");
		}
		$arr_files = array();
		foreach ($files as $file) {
			$file_name = explode($id.'/', $file);
			array_push($arr_files, $file_name[1]);
		}
		echo json_encode($arr_files);
	}
	public function ajax_attach_file_fc ($id,$type=null){
		$str_type = '';
		if (!empty($type)) {
			$str_type .= 'ex/';
		}
		if (!empty($_FILES['attach_file'])) {
			$files = glob("files/upload/image/passport_photo_fc/{$str_type}{$id}/*");
			foreach ($files as $file) {
				if(is_file($file))
					unlink($file);
			}
			$path = "./files/upload/image/passport_photo_fc/{$str_type}{$id}";
			if (!file_exists($path)) {
				mkdir($path, 0777, true);
			}
			$arr_name = array();
			$filesCount = count($_FILES['attach_file']['name']);
			
			for($i = 0; $i < $filesCount; $i++){
				$_FILES['file']['name']     = $_FILES['attach_file']['name'][$i];
				$_FILES['file']['type']     = $_FILES['attach_file']['type'][$i];
				$_FILES['file']['tmp_name'] = $_FILES['attach_file']['tmp_name'][$i];
				$_FILES['file']['error']     = $_FILES['attach_file']['error'][$i];
				$_FILES['file']['size']     = $_FILES['attach_file']['size'][$i];
				$config = array(
					"upload_path" 		=> $path,
					"allowed_types" 	=> '*'
				);
				$this->load->library('upload',$config);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('file')) {
					$data = $this->upload->data();
					@chmod($data['full_path'],0777);
					$temp = explode('.',$_FILES['file']['name']);
					rename($data['full_path'],$data['file_path'].$this->util->slug($temp[0]).'.'.$temp[1]);
					$filename = $this->util->slug($temp[0]).'.'.$temp[1];
					array_push($arr_name, $filename);
				}
			}
			echo json_encode($arr_name);
		}
	}
	public function ajax_delete_attach_file_fc (){
		$id = $this->input->post('id');
		$str_typ = $this->input->post('str_typ');
		$files = glob("files/upload/image/passport_photo_fc/{$id}/*");
		if (!empty($str_typ)) {
			$files = glob("files/upload/image/passport_photo_fc/ex/{$id}/*");
		}
		foreach ($files as $file) {
			if(is_file($file))
				unlink($file);
		}
	}
	public function ajax_get_attach_file_urg(){
		$id = $this->input->post('id');
		$files = glob("files/upload/image/passport_photo_urg/{$id}/*");
		$arr_files = array();
		foreach ($files as $file) {
			$file_name = explode($id.'/', $file);
			array_push($arr_files, $file_name[1]);
		}
		echo json_encode($arr_files);
	}
	public function ajax_attach_file_urg ($id){
		if (!empty($_FILES['attach_file'])) {
			$files = glob("files/upload/image/passport_photo_urg/{$id}/*");
			foreach ($files as $file) {
				if(is_file($file))
					unlink($file);
			}
			$path = "./files/upload/image/passport_photo_urg/{$id}";
			if (!file_exists($path)) {
				mkdir($path, 0777, true);
			}
			$arr_name = array();
			$filesCount = count($_FILES['attach_file']['name']);
			
			for($i = 0; $i < $filesCount; $i++){
				$_FILES['file']['name']     = $_FILES['attach_file']['name'][$i];
				$_FILES['file']['type']     = $_FILES['attach_file']['type'][$i];
				$_FILES['file']['tmp_name'] = $_FILES['attach_file']['tmp_name'][$i];
				$_FILES['file']['error']     = $_FILES['attach_file']['error'][$i];
				$_FILES['file']['size']     = $_FILES['attach_file']['size'][$i];
				$config = array(
					"upload_path" 		=> $path,
					"allowed_types" 	=> '*'
				);
				$this->load->library('upload',$config);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('file')) {
					$data = $this->upload->data();
					@chmod($data['full_path'],0777);
					$temp = explode('.',$_FILES['file']['name']);
					rename($data['full_path'],$data['file_path'].$this->util->slug($temp[0]).'.'.$temp[1]);
					$filename = $this->util->slug($temp[0]).'.'.$temp[1];
					array_push($arr_name, $filename);
				}
			}
			echo json_encode($arr_name);
		}
	}
	public function ajax_delete_attach_file_urg (){
		$id = $this->input->post('id');
		$files = glob("files/upload/image/passport_photo_urg/{$id}/*");
		foreach ($files as $file) {
			if(is_file($file))
				unlink($file);
		}
	}
	public function visa_approval_letter() {
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Visa Approval Letter" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		if (!empty($_POST)) {
			$book_id = $this->input->post('book_id');
			$file_name = $this->input->post('file_name');
			$id_items = preg_replace('/\s+/', '', $book_id);
			$id_items = explode(',', $id_items);
			$id_items = array_filter($id_items);
			$data = array(
						'book_id_list' 	=> $book_id,
						'file_name'		=> $file_name,
						'user_id' 		=> $this->session->userdata('admin')->id
					);
			$this->m_letter_log->add($data);
			foreach ($id_items as $id_item) {
				$book_id = str_replace(BOOKING_E_PREFIX,'', $id_item);
				$book_id = str_replace(BOOKING_PREFIX,'', $book_id);
				$booking = $this->m_visa_booking->load($book_id);

				if ($booking->booking_type_id == 1) {
					$message = '<p>Dear <strong>'.$booking->contact_title.". ".$booking->contact_fullname.'</strong>,</p>
								<p>Thanks for booking with us, your visa application ID: <strong>'.BOOKING_PREFIX.$booking->id.'</strong></p>
								<p>We would like to confirm that your visa is approved by Vietnam Immigration Department. Please open the attached file and print out this visa approved letter.</p>
								<p style="color:red;background-color:yellow">You must check all your information on the given approval letter and inform us immediately if any mistakes. If not, we will not take any responsibility. Furthermore, please notice that you will not able to enter Vietnam if the detail is incorrect.</p>
								<p style="color:red"><u><i>Things to do at the airport:</i></u></p>
								<ul style="list-style-type:decimal">
									<li>Please prepare <strong>25 USD/person</strong> for single entry visa (<strong>50 USD/person</strong> for multiple entry visa) in <strong>CASH</strong> for payment stamping fee. Credit card is not acceptable as there is no ATM at the landing visa counter. In case, you are not willing to pay in USD, we are not responsible for the exchange rate of any charges at the airport. <span style="color:red;">(If you have already booked the Full Package that including visa stamp, you do not have to concern about this payment request).</span></li>
									<li>Prepare 2 photos 4x6 cm (or same size passport photos). If you don’t have photos, you can have them taken at the arrival airport and it costs 5 USD/person in HCM (2 USD/person in Hanoi).</li>
									<li>Please click this link to download and fill in this Immigration form in advance to avoid wasting time at the airport: <a href="https://'.DOMAIN.'/files/upload/file/Documents/Form-XNC.pdf">https://'.DOMAIN.'/files/upload/file/Documents/Form-XNC.pdf</a>. This form will be dropped at the visa counter when you arrive, no need to send to Embassy.</li>
								</ul>
								<p>Any more questions, feel free to contact us via hotline: <span style="color:red;background-color:yellow">+84.327.117.119</span>, <span style="color:red;background-color:yellow">'.HOTLINE.'</span> or <a href="mailto:'.MAIL_INFO.'" target="_blank">'.MAIL_INFO.'</a> to email us.</p>
								<p style="color:red;background-color:yellow">When you get the Visa stamp at a Vietnam int’l airport, please check your Visa carefully to make sure that everything is correct.</p>
								<p>
									Best Regards,<br>
									Lee Nguyen Mr.
								</p>';
				} else {
					$message = '<p>Dear <strong>'.$booking->contact_title.". ".$booking->contact_fullname.'</strong>,</p>
								<p>Thanks for booking with us, your visa application ID: <strong>'.BOOKING_E_PREFIX.$booking->id.'</strong></p>
								<p>We would like to confirm that your eVisa is approved by the Vietnam Immigration Department. Please find attached the Vietnam eVisa.</p>
								<p style="color:red"><u><i>Things to do:</i></u></p>
								<ul style="list-style-type:decimal">
									<li>Check the information carefully and print out the eVisa.</li>
									<li>Present your passport and eVisa at the indicated port of entry.</li>
								</ul>
								<p style="color:red"><u><i>Be noted:</i></u></p>
								<ul style="list-style-type:decimal">
									<li>The eVisa is valid for 30 days with single entry.</li>
									<li>The eVisa once issued cannot be amended for any reason.</li>
									<li>The eVisa fee is non-refundable.</li>
									<li>Travelers using the e-Visa must enter Vietnam via designated port of arrival.</li>
									<li>Please double check to make sure your given information is the same as in your passport.</li>
									<li>We are not responsible for incorrect passport details provided by applicants.</li>
								</ul>
								<p style="color:red;background-color:yellow">When you get the Visa stamp at arrival port, please check again to make sure that everything is correct. Otherwise, we will not take any responsibility. Furthermore, please notice that you will not able to enter Vietnam if the detail is incorrect.</p>
								<p>Should you have any inquiry, please feel free to contact us via: <span style="color:red;background-color:yellow">+84.327.117.119</span>, <span style="color:red;background-color:yellow">'.HOTLINE.'</span> or email us at: <a href="mailto:'.MAIL_INFO.'" target="_blank">'.MAIL_INFO.'</a>.</p>
								<p>
									Best Regards,<br>
									Lee Nguyen Mr.
								</p>';
				}
				$attachment = array();
				$files_name = explode(',',$file_name);
				foreach ($files_name as $value) {
					if (!empty($value))
					array_push($attachment,BASE_URL.'/files/upload/image/visa_letter/'.$value);
				}
				
				$mail = array(
					"subject"		=> 'Vietnam Visa Approval Letter For '.$booking->contact_title.'. '.$booking->contact_fullname,
					"from_sender"	=> MAIL_INFO,
					"name_sender"	=> SITE_NAME,
					"to_receiver"	=> $booking->primary_email,
					"attachment"	=> $attachment,
					"message"		=> $message,
				);
				$this->mail->config($mail);
				$this->mail->sendmail();

				$mail = array(
					"subject"		=> 'Vietnam Visa Approval Letter For '.$booking->contact_title.'. '.$booking->contact_fullname,
					"from_sender"	=> $booking->primary_email,
					"name_sender"	=> $booking->contact_fullname,
					"to_receiver"	=> MAIL_INFO,
					"attachment"	=> $attachment,
					"message"		=> $message,
				);
				$this->mail->config($mail);
				$this->mail->sendmail();
			}
			redirect(site_url('syslog/visa-approval-letter'));
		}

		$view_data = array();
		$view_data["items"] 		= $this->m_letter_log->items(null,30);
		$view_data["breadcrumb"] 		= $this->_breadcrumb;
		
		$tmpl_content = array();
		$tmpl_content["content"] = $this->load->view("admin/letter/index", $view_data, true);
		$this->load->view("layout/admin/main", $tmpl_content);
	}
	public function ajax_visa_approval_letter() {
		if (!empty($_FILES['attach_file'])) {
			$path = "./files/upload/image/visa_letter";
			$arr_name = array();
			$filesCount = count($_FILES['attach_file']['name']);
			
			for($i = 0; $i < $filesCount; $i++){
				$_FILES['file']['name']     = $_FILES['attach_file']['name'][$i];
				$_FILES['file']['type']     = $_FILES['attach_file']['type'][$i];
				$_FILES['file']['tmp_name'] = $_FILES['attach_file']['tmp_name'][$i];
				$_FILES['file']['error']     = $_FILES['attach_file']['error'][$i];
				$_FILES['file']['size']     = $_FILES['attach_file']['size'][$i];
				$config = array(
					"upload_path" 		=> $path,
					"allowed_types" 	=> '*'
				);
				$this->load->library('upload',$config);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('file')) {
					$data = $this->upload->data();
					@chmod($data['full_path'],0777);
					$temp = explode('.',$_FILES['file']['name']);
					rename($data['full_path'],$data['file_path'].$this->util->slug($temp[0]).'.'.$temp[1]);
					$filename = $this->util->slug($temp[0]).'.'.$temp[1];
					array_push($arr_name, $filename);
				}
			}
			echo json_encode($arr_name);
		}
	}
	function ajax_payment_report_capital()
	{
		$booking_id = $this->input->post("booking_id");
		$capital = $this->input->post("capital");
		$payment_type = $this->input->post("typ");
		
		$data  = array(
			"capital" => $capital
		);
		$where = array(
			"id" => $booking_id
		);
		if($payment_type == 'VISA') {
			$this->m_visa_booking->update($data, $where);
		}elseif($payment_type == 'PO-VISA-') {
			$this->m_payment->update($data, $where);
		}else{
			$this->m_service_booking->update($data, $where);
		}
		echo "";
	}
	
	function ajax_payment_report_refund()
	{
		$booking_id = $this->input->post("booking_id");
		$refund = $this->input->post("refund");
		$payment_type = $this->input->post("typ");
		
		$data  = array(
			"refund" => $refund
		);
		$where = array(
			"id" => $booking_id
		);
		
		if($payment_type == 'VISA') {
			$this->m_visa_booking->update($data, $where);
		}elseif($payment_type == 'PO-VISA-') {
			$this->m_payment->update($data, $where);
		}else{
			$this->m_service_booking->update($data, $where);
		}
		
		echo "";
	}

	//------------------------------------------------------------------------------
	// FAQs
	//------------------------------------------------------------------------------
	public function faqs_categories($action=null, $id=null)
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Content Categories" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "save") {
				$name			= $this->util->value($this->input->post("name"), "");
				$alias			= $this->util->value($this->input->post("alias"), "");
				$parent_id		= $this->util->value($this->input->post("parent_id"), 0);
				$active			= $this->util->value($this->input->post("active"), 1);
				
				if (empty($alias)) {
					$alias = $this->util->slug($name);
				}
				
				$data = array (
					"name"		=> $name,
					"alias"		=> $alias,
					"parent_id"	=> $parent_id,
					"active"	=> $active
				);
				
				if ($action == "add") {
					$this->m_faqs_category->add($data);
				}
				else if ($action == "edit") {
					$where = array("id" => $id);
					$this->m_faqs_category->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/faqs-categories"));
			}
			else if ($task == "cancel") {
				redirect(site_url("syslog/faqs-categories"));
			}
			else if ($task == "orderup") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$this->m_faqs_category->order_up($id);
				}
				redirect(site_url("syslog/faqs-categories"));
			}
			else if ($task == "orderdown") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$this->m_faqs_category->order_down($id);
				}
				redirect(site_url("syslog/faqs-categories"));
			}
			else if ($task == "saveorder") {
				$order = $this->util->value($this->input->post("order"), array());
				$cids  = $this->util->value($this->input->post("cids"), array());
				for ($i=0; $i<sizeof($cids); $i++) {
					$data = array("order_num" => $order[$i]);
					$where = array("id" => $cids[$i]);
					$this->m_faqs_category->update($data, $where);
				}
				redirect(site_url("syslog/faqs-categories"));
			}
			else if ($task == "publish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 1);
					$where = array("id" => $id);
					$this->m_faqs_category->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/faqs-categories"));
			}
			else if ($task == "unpublish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 0);
					$where = array("id" => $id);
					$this->m_faqs_category->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/faqs-categories"));
			}
			else if ($task == "delete") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$where = array("id" => $id);
					$this->m_faqs_category->delete($where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/faqs-categories"));
			}
		}
		
		if ($action == "add") {
			$item = $this->m_faqs_category->instance();
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("Add Faqs Category" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/faqs/category/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else if ($action == "edit") {
			$item = $this->m_faqs_category->load($id);
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$item->name}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}/{$id}")));
		
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/faqs/category/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else {
			$category_info = new stdClass();
			$category_info->parent_id = 0;
			$categories = $this->m_faqs_category->items($category_info);
			
			$view_data = array();
			$view_data["breadcrumb"] 	= $this->_breadcrumb;
			$view_data["items"]			= $categories;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/faqs/category/index", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
	}
	
	public function faqs($category_id, $action=null, $id=null)
	{
		$faqs_category = $this->m_faqs_category->load($category_id);
		
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Faqs Categories" => site_url("{$this->util->slug($this->router->fetch_class())}/faqs-categories")));
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$faqs_category->name}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$category_id}")));
		
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "save") {
				$title			= $this->util->value($this->input->post("title"), "");
				$alias			= $this->util->value($this->input->post("alias"), "");
				$catid			= $this->util->value($this->input->post("catid"), 0);
				$thumbnail 		= !empty($_FILES['thumbnail']['name']) ? explode('.',$_FILES['thumbnail']['name']) : $this->m_faqs->load($id)->thumbnail;
				$meta_title		= $this->util->value($this->input->post("meta_title"), "");
				$meta_key		= $this->util->value($this->input->post("meta_key"), "");
				$meta_desc		= $this->util->value($this->input->post("meta_desc"), "");
				$summary		= $this->util->value($this->input->post("summary"), "");
				$content		= $this->util->value($this->input->post("content"), "");
				//$order_num		= $this->util->value($this->input->post("order_num"), 1);
				$active			= $this->util->value($this->input->post("active"), 1);
				
				if (empty($alias)) {
					$alias = $this->util->slug($title);
				}
				
				$data = array (
					"title"			=> $title,
					"alias"			=> $alias,
					"catid"			=> $catid,
					"thumbnail"		=> $thumbnail,
					"meta_title"	=> $meta_title,
					"meta_key"		=> $meta_key,
					"meta_desc"		=> $meta_desc,
					"summary"		=> $summary,
					"content"		=> $content,
					//"order_num"		=> $order_num,
					"active"		=> $active
				);
				if (!empty($_FILES['thumbnail']['name'])){
					$data['thumbnail'] = "/files/upload/image/faqs/{$this->util->slug($thumbnail[0])}.{$thumbnail[1]}";
				}
				$file_deleted = '';
				
				if ($action == "add") {
					$file_deleted = "./files/upload/image/faqs/{$this->m_faqs->load($id)->name}";
					$this->m_faqs->add($data);
				}
				else if ($action == "edit") {
					$where = array("id" => $id);
					$this->m_faqs->update($data, $where);
				}
				$path = "./files/upload/image/faqs";
				if (!file_exists($path)) {
					mkdir($path, 0755, true);
				}
				$allow_type = 'JPG|PNG|jpg|jpeg|png';
				$this->util->upload_file($path,'thumbnail',$file_deleted,$allow_type,$this->util->slug($thumbnail[0]).'.'.$thumbnail[1]);
				$this->create_sitemap();
				redirect(site_url("syslog/faqs/{$faqs_category->alias}"));
			}
			else if ($task == "cancel") {
				redirect(site_url("syslog/faqs/{$faqs_category->alias}"));
			}
			else if ($task == "orderup") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$this->m_faqs->order_up($id);
				}
				redirect(site_url("syslog/faqs/{$faqs_category->alias}"));
			}
			else if ($task == "orderdown") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$this->m_faqs->order_down($id);
				}
				redirect(site_url("syslog/faqs/{$faqs_category->alias}"));
			}
			else if ($task == "saveorder") {
				$order = $this->util->value($this->input->post("order"), array());
				$cids  = $this->util->value($this->input->post("cids"), array());
				for ($i=0; $i<sizeof($cids); $i++) {
					$data = array("order_num" => $order[$i]);
					$where = array("id" => $cids[$i]);
					$this->m_faqs->update($data, $where);
				}
				redirect(site_url("syslog/faqs/{$faqs_category->alias}"));
			}
			else if ($task == "publish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 1);
					$where = array("id" => $id);
					$this->m_faqs->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/faqs/{$faqs_category->alias}"));
			}
			else if ($task == "unpublish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 0);
					$where = array("id" => $id);
					$this->m_faqs->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/faqs/{$faqs_category->alias}"));
			}
			else if ($task == "delete") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$where = array("id" => $id);
					$this->m_faqs->delete($where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/faqs/{$faqs_category->alias}"));
			}
		}
		
		if ($action == "add") {
			$item = $this->m_faqs->instance();
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("Add Content" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$category_id}/{$action}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			$view_data["category"] = $faqs_category;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/faqs/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else if ($action == "edit") {
			$item = $this->m_faqs->load($id);
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$item->title}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$category_id}/{$action}/{$id}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			$view_data["category"] = $faqs_category;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/faqs/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else {
			$info = new stdClass();
			$info->catid = $faqs_category->id;
			
			$view_data = array();
			$view_data["breadcrumb"]	= $this->_breadcrumb;
			$view_data["items"]			= $this->m_faqs->items($info, null, null, null);
			$view_data["category"]		= $faqs_category;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/faqs/index", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
	}

	//------------------------------------------------------------------------------
	// Useful Information
	//------------------------------------------------------------------------------
	public function useful_categories($action=null, $id=null)
	{
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Content Categories" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}")));
		
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "save") {
				$name			= $this->util->value($this->input->post("name"), "");
				$alias			= $this->util->value($this->input->post("alias"), "");
				$parent_id		= $this->util->value($this->input->post("parent_id"), 0);
				$active			= $this->util->value($this->input->post("active"), 1);
				
				if (empty($alias)) {
					$alias = $this->util->slug($name);
				}
				
				$data = array (
					"name"		=> $name,
					"alias"		=> $alias,
					"parent_id"	=> $parent_id,
					"active"	=> $active
				);
				
				if ($action == "add") {
					$this->m_useful_category->add($data);
				}
				else if ($action == "edit") {
					$where = array("id" => $id);
					$this->m_useful_category->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/useful-categories"));
			}
			else if ($task == "cancel") {
				redirect(site_url("syslog/useful-categories"));
			}
			else if ($task == "orderup") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$this->m_useful_category->order_up($id);
				}
				redirect(site_url("syslog/useful-categories"));
			}
			else if ($task == "orderdown") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$this->m_useful_category->order_down($id);
				}
				redirect(site_url("syslog/useful-categories"));
			}
			else if ($task == "saveorder") {
				$order = $this->util->value($this->input->post("order"), array());
				$cids  = $this->util->value($this->input->post("cids"), array());
				for ($i=0; $i<sizeof($cids); $i++) {
					$data = array("order_num" => $order[$i]);
					$where = array("id" => $cids[$i]);
					$this->m_useful_category->update($data, $where);
				}
				redirect(site_url("syslog/useful-categories"));
			}
			else if ($task == "publish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 1);
					$where = array("id" => $id);
					$this->m_useful_category->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/useful-categories"));
			}
			else if ($task == "unpublish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 0);
					$where = array("id" => $id);
					$this->m_useful_category->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/useful-categories"));
			}
			else if ($task == "delete") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$where = array("id" => $id);
					$this->m_useful_category->delete($where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/useful-categories"));
			}
		}
		
		if ($action == "add") {
			$item = $this->m_useful_category->instance();
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("Add useful Category" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/useful_information/category/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else if ($action == "edit") {
			$item = $this->m_useful_category->load($id);
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$item->name}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$action}/{$id}")));
		
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/useful_information/category/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else {
			$category_info = new stdClass();
			$category_info->parent_id = 0;
			$categories = $this->m_useful_category->items($category_info);
			
			$view_data = array();
			$view_data["breadcrumb"] 	= $this->_breadcrumb;
			$view_data["items"]			= $categories;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/useful_information/category/index", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
	}
	
	public function useful($category_id, $action=null, $id=null)
	{
		$useful_category = $this->m_useful_category->load($category_id);
		
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Useful Categories" => site_url("{$this->util->slug($this->router->fetch_class())}/useful-categories")));
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$useful_category->name}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$category_id}")));
		
		$task = $this->util->value($this->input->post("task"), "");
		if (!empty($task)) {
			if ($task == "save") {
				$title			= $this->util->value($this->input->post("title"), "");
				$alias			= $this->util->value($this->input->post("alias"), "");
				$catid			= $this->util->value($this->input->post("catid"), 0);
				$thumbnail 		= !empty($_FILES['thumbnail']['name']) ? explode('.',$_FILES['thumbnail']['name']) : $this->m_useful->load($id)->thumbnail;
				$meta_title		= $this->util->value($this->input->post("meta_title"), "");
				$meta_key		= $this->util->value($this->input->post("meta_key"), "");
				$meta_desc		= $this->util->value($this->input->post("meta_desc"), "");
				$summary		= $this->util->value($this->input->post("summary"), "");
				$content		= $this->util->value($this->input->post("content"), "");
				//$order_num		= $this->util->value($this->input->post("order_num"), 1);
				$active			= $this->util->value($this->input->post("active"), 1);
				
				if (empty($alias)) {
					$alias = $this->util->slug($title);
				}
				
				$data = array (
					"title"			=> $title,
					"alias"			=> $alias,
					"catid"			=> $catid,
					"thumbnail"		=> $thumbnail,
					"meta_title"	=> $meta_title,
					"meta_key"		=> $meta_key,
					"meta_desc"		=> $meta_desc,
					"summary"		=> $summary,
					"content"		=> $content,
					//"order_num"		=> $order_num,
					"active"		=> $active
				);
				if (!empty($_FILES['thumbnail']['name'])){
					$data['thumbnail'] = "/files/upload/image/useful/{$this->util->slug($thumbnail[0])}.{$thumbnail[1]}";
				}
				$file_deleted = '';
				
				if ($action == "add") {
					$file_deleted = "./files/upload/image/useful/{$this->m_useful->load($id)->name}";
					$this->m_useful->add($data);
				}
				else if ($action == "edit") {
					$where = array("id" => $id);
					$this->m_useful->update($data, $where);
				}
				$path = "./files/upload/image/useful";
				if (!file_exists($path)) {
					mkdir($path, 0755, true);
				}
				$allow_type = 'JPG|PNG|jpg|jpeg|png';
				$this->util->upload_file($path,'thumbnail',$file_deleted,$allow_type,$this->util->slug($thumbnail[0]).'.'.$thumbnail[1]);
				$this->create_sitemap();
				redirect(site_url("syslog/useful/{$useful_category->alias}"));
			}
			else if ($task == "cancel") {
				redirect(site_url("syslog/useful/{$useful_category->alias}"));
			}
			else if ($task == "orderup") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$this->m_useful->order_up($id);
				}
				redirect(site_url("syslog/useful/{$useful_category->alias}"));
			}
			else if ($task == "orderdown") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$this->m_useful->order_down($id);
				}
				redirect(site_url("syslog/useful/{$useful_category->alias}"));
			}
			else if ($task == "saveorder") {
				$order = $this->util->value($this->input->post("order"), array());
				$cids  = $this->util->value($this->input->post("cids"), array());
				for ($i=0; $i<sizeof($cids); $i++) {
					$data = array("order_num" => $order[$i]);
					$where = array("id" => $cids[$i]);
					$this->m_useful->update($data, $where);
				}
				redirect(site_url("syslog/useful/{$useful_category->alias}"));
			}
			else if ($task == "publish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 1);
					$where = array("id" => $id);
					$this->m_useful->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/useful/{$useful_category->alias}"));
			}
			else if ($task == "unpublish") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$data = array("active" => 0);
					$where = array("id" => $id);
					$this->m_useful->update($data, $where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/useful/{$useful_category->alias}"));
			}
			else if ($task == "delete") {
				$ids = $this->util->value($this->input->post("cid"), array());
				foreach ($ids as $id) {
					$where = array("id" => $id);
					$this->m_useful->delete($where);
				}
				$this->create_sitemap();
				redirect(site_url("syslog/useful/{$useful_category->alias}"));
			}
		}
		
		if ($action == "add") {
			$item = $this->m_useful->instance();
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("Add Content" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$category_id}/{$action}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			$view_data["category"] = $useful_category;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/useful_information/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else if ($action == "edit") {
			$item = $this->m_useful->load($id);
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$item->title}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$category_id}/{$action}/{$id}")));
			
			$view_data = array();
			$view_data["breadcrumb"] = $this->_breadcrumb;
			$view_data["item"] = $item;
			$view_data["category"] = $useful_category;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/useful_information/edit", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
		else {
			$info = new stdClass();
			$info->catid = $useful_category->id;
			
			$view_data = array();
			$view_data["breadcrumb"]	= $this->_breadcrumb;
			$view_data["items"]			= $this->m_useful->items($info, null, null, null);
			$view_data["category"]		= $useful_category;
			
			$tmpl_content = array();
			$tmpl_content["content"] = $this->load->view("admin/useful_information/index", $view_data, true);
			$this->load->view("layout/admin/main", $tmpl_content);
		}
	}
}

?>