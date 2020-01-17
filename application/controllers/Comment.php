<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comment extends CI_Controller {

	public function index()
	{
		$comment 	= $this->input->post('comment');
		$parent_id 	= !empty($this->input->post('parent_id')) ? $this->input->post('parent_id') : 0;
		$user_id 	= !empty($this->session->userdata('user')->id) ? $this->session->userdata('user')->id : 0;

		$data = array(
			"comment" 	=> $comment,
			"parent_id" => $parent_id,
			"user_id" 	=> $user_id,
		);
		if ($this->m_comment->add($data)) {
			echo 1;
		} else {
			echo 0;
		}
	}
	public function ajax_update_comment() {
		$id 	= $this->input->post('id');
		$comment = $this->m_comment->load($id);
		if ($this->session->userdata('user')->id == $comment->user_id) {
			$comment 	= $this->input->post('comment');
			$this->m_comment->update(array("comment" => $comment),array("id" => $id));
			echo $comment;
		}
	}
	public function ajax_delete_comment() {
		$id 	= $this->input->post('id');
		$comment = $this->m_comment->load($id);
		if ($this->session->userdata('user')->id == $comment->user_id) {
			if ($this->m_comment->delete(array("id" => $id))){
				echo 1;
			} else {
				echo 0;
			}
		}
	}
	public function ajax_get_comment() {
		$info = new stdClass();
		$info->parent_id = 0;
		$comments = $this->m_comment->items($info,1);
		foreach ($comments as $comment) {
			$info_child = new stdClass();
			$info_child->parent_id = $comment->id;
			$comment->child = $this->m_comment->items($info_child,1);
		}
		$user_login = !empty($this->session->userdata('user')) ? $this->session->userdata('user')->id : 0;
		echo json_encode(array($comments,$user_login));
	}
}

?>