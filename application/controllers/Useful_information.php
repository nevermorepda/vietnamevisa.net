<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Useful_information extends CI_Controller {
	
	var $_breadcrumb = array();
	
	public function __construct()
	{
		parent::__construct();
		
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Vietnam Visa" => site_url($this->util->slug($this->router->fetch_class()))));
	}
	
	public function index($alias=NULL,$id=NULL)
	{
		// $this->output->cache(CACHE_TIME);
		$this->util->block_ip();
		// 
		$info = new stdClass();
		$info->parent_id = 0;
		$categories = $this->m_useful_category->items($info,1);
		
		if (!empty($alias)) {
			$category = $this->m_useful_category->load($alias);
			$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$category->name}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$alias}")));

			if(!empty($id)) {
				$item = $this->m_useful->load($id);
				$this->m_useful->view($item->id);
				
				$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$item->title}" => site_url("{$this->util->slug($this->router->fetch_class())}/{$alias}/{$item->alias}")));
				
				$view_data = array();
				$view_data['item']		= $item;
				$view_data['breadcrumb']= $this->_breadcrumb;
				$view_data["alias"] = $alias;
				$view_data["categories"] = $categories;
				
				$tmpl_content = array();
				$tmpl_content['meta']['title'] = $this->util->getMetaTitle($item);
				$tmpl_content['meta']['keywords'] = $item->meta_key;
				$tmpl_content['meta']['description'] = $item->meta_desc;
				$tmpl_content['tabindex']  = "useful";
				$tmpl_content['content']   = $this->load->view("useful_information/detail", $view_data, TRUE);
				$this->load->view('layout/view', $tmpl_content);
			} else {
				$info = new stdClass();
				$info->catid = $category->id;
				
				$items = $this->m_useful->items($info, 1);

				$page = (!empty($_GET["page"]) ? max($_GET["page"], 1) : 1);
				$offset = ($page - 1) * 9;
				$pagination = $this->util->pagination(site_url("{$this->util->slug($this->router->fetch_class())}/{$alias}"), sizeof($items), 9);
				
				$latest_items_info = new stdClass();
				$latest_items_info->category_id = $category->id;
				$latest_items = $this->m_useful->items($latest_items_info,1,4,1,'created_date','DESC');
				
				$view_data = array();
				$view_data["items"] = $this->m_useful->items($info, 1, 9, $offset);
				$view_data["offset"] = $offset;
				$view_data["pagination"] = $pagination;
				$view_data["categories"] = $categories;
				$view_data["category"] = $category;
				$view_data["alias"] = $alias;
				$view_data["latest_items"] = $latest_items;
				$view_data["breadcrumb"] = $this->_breadcrumb;
				
				$tmpl_content = array();
				$tmpl_content['tabindex']  = "useful";
				$tmpl_content["meta"]["title"] = "Vietnam Visa useful";
				$tmpl_content["content"] = $this->load->view("useful_information/index", $view_data, TRUE);
				$this->load->view("layout/main", $tmpl_content);
			}
		}
		else {
			$info = new stdClass();
			if(isset($_GET) && !empty($_GET['search_text'])){
				$info->search_text = $_GET['search_text'];
			}

			$items = $this->m_useful->items($info, 1);
			$page = (!empty($_GET["page"]) ? max($_GET["page"], 1) : 1);
			$offset = ($page - 1) * 9;
			$latest_items_info = new stdClass();
			$latest_items = $this->m_useful->items($latest_items_info,1,4,1,'created_date','DESC');
			
			$pagination = $this->util->pagination(site_url("{$this->util->slug($this->router->fetch_class())}"), sizeof($items), 9);
			
			$view_data = array();
			$view_data['items']  = $this->m_useful->items($info, 1, 9, $offset);
			$view_data["pagination"] = $pagination;
			$view_data["categories"] = $categories;
			$view_data["latest_items"] = $latest_items;
			$view_data["offset"] = $offset;
			$view_data["alias"] = $alias;
			$view_data['breadcrumb']= $this->_breadcrumb;
			
			$tmpl_content = array();
			$tmpl_content['meta']['title'] = "Vietnam Visa useful";
			$tmpl_content['meta']['keywords'] = "Visa useful, visa, vietnam, visa vietnam, vietnam visa";
			$tmpl_content['tabindex']  = "useful";
			$tmpl_content['content']   = $this->load->view("useful_information/index", $view_data, TRUE);
			$this->load->view('layout/view', $tmpl_content);
		}
	}
}
?>