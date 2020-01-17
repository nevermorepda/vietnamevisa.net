<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Answer extends CI_Controller {

	public function post()
	{
		$author			= $this->input->post("author");
		$email			= $this->input->post("email");
		$nationality	= $this->input->post("nationality");
		$title			= $this->input->post("title");
		$content		= $this->input->post("content");
		$category_id	= $this->input->post("category_id");
		$ref_id			= $this->input->post("ref_id");
		$security_code	= $this->input->post("code");
		$alias			= $this->util->slug($title)."-".$this->m_question->get_next_value();
		
		if ($security_code == $this->util->getSecurityCode())
		{
			// Save
			$data = array (
				'author'		=> $author,
				'email'			=> $email,
				'nationality'	=> $nationality,
				'title'			=> $title,
				'alias' 		=> $alias,
				'content'		=> nl2br($content),
				'category_id'	=> $category_id,
				'ref_id'		=> $ref_id,
				'active'		=> 0,
			);
			$this->m_question->add($data);
		}
	}
}

?>