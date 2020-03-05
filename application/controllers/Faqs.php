<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faqs extends CI_Controller {
	
	var $_breadcrumb = array();
	
	public function __construct()
	{
		parent::__construct();
		
		$this->_breadcrumb = array_merge($this->_breadcrumb, array("Faqs" => site_url($this->util->slug($this->router->fetch_class()))));
	}
	
	public function index($alias=NULL,$id=NULL)
	{
		// $this->output->cache(CACHE_TIME);
		$this->util->block_ip();
		// 
		$info = new stdClass();
		$info->parent_id = 0;
		$categories = $this->m_faqs_category->items($info,1);
		
		if (!empty($alias)) {
			if(!empty($id)) {
				$item = $this->m_faqs->load($id);
				$this->m_faqs->view($item->id);
				
				$breadcrumb = array("Vietnam Visa Faqs" => site_url("faqs"), $item->title => '');
				
				$view_data = array();
				$view_data['item']		= $item;
				$view_data['breadcrumb']= $breadcrumb;
				
				$tmpl_content = array();
				$tmpl_content['meta']['title'] = $this->util->getMetaTitle($item);
				$view_data["categories"] = $categories;
				$tmpl_content['meta']['keywords'] = $item->meta_key;
				$tmpl_content['meta']['description'] = $item->meta_desc;
				$tmpl_content['tabindex']  = "faqs";
				$tmpl_content['content']   = $this->load->view("faqs/detail", $view_data, TRUE);
				$this->load->view('layout/view', $tmpl_content);

			} else {
				$category = $this->m_faqs_category->load($alias);
				$info = new stdClass();
				$info->catid = $category->id;
				
				$items = $this->m_faqs->items($info, 1);
				
				$this->_breadcrumb = array_merge($this->_breadcrumb, array("{$category->name}" => site_url("{$this->util->slug($this->router->fetch_class())}")));
				
				$page = (!empty($_GET["page"]) ? max($_GET["page"], 1) : 1);
				$pagination = $this->util->pagination(site_url("{$this->util->slug($this->router->fetch_class())}"), sizeof($items), 5);
				
				$latest_items_info = new stdClass();
				$latest_items_info->category_id = $category->id;
				$latest_items = $this->m_faqs->items($latest_items_info,1,4,1,'created_date','DESC');
				
				$view_data = array();
				$view_data["items"] = $this->m_faqs->items($info, 1, 5, ($page - 1) * 5);
				$view_data["pagination"] = $pagination;
				$view_data["categories"] = $categories;
				$view_data["latest_items"] = $latest_items;
				$view_data["breadcrumb"] = $this->_breadcrumb;
				
				$tmpl_content = array();
				$tmpl_content["meta"]["title"] = "Vietnam Visa Faqs";
				$tmpl_content["content"] = $this->load->view("faqs/index", $view_data, TRUE);
				$this->load->view("layout/main", $tmpl_content);
			}
		}
		else {
			$items = $this->m_faqs->items(null, 1);
			
			$breadcrumb = array("Vietnam Visa Faqs" => site_url("{$this->util->slug($this->router->fetch_class())}"));
			
			$latest_items_info = new stdClass();
			$latest_items = $this->m_faqs->items($latest_items_info,1,4,1,'created_date','DESC');
			
			$page = (!empty($_GET["page"]) ? max($_GET["page"], 1) : 1);
			$pagination = $this->util->pagination(site_url("{$this->util->slug($this->router->fetch_class())}"), sizeof($items), 5);
			
			$view_data = array();
			$view_data['items']  = $this->m_faqs->items(null, 1, 5, ($page - 1) * 5);
			$view_data["pagination"] = $pagination;
			$view_data["categories"] = $categories;
			$view_data["latest_items"] = $latest_items;
			$view_data['breadcrumb']= $breadcrumb;
			
			$tmpl_content = array();
			$tmpl_content['meta']['title'] = "Vietnam Visa Faqs";
			$tmpl_content['meta']['keywords'] = "Visa faqs, visa, vietnam, visa vietnam, vietnam visa";
			$tmpl_content['tabindex']  = "faqs";
			$tmpl_content['content']   = $this->load->view("faqs/index", $view_data, TRUE);
			$this->load->view('layout/view', $tmpl_content);
		}
	}
}
?>