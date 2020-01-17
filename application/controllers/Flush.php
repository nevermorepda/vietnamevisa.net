<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flush extends CI_Controller {

	public function index()
	{
	}
	
	public function all_user_mail()
	{
		$info = new stdClass();
		$info->todate = date("Y-m-d", strtotime("-2 days"));
		
		$mails = $this->m_mail->items($info);
		foreach ($mails as $mail) {
			$where = array("id" => $mail->id);
			$this->m_mail->delete($where);
		}
	}
	
	public function all_user_dir()
	{
		$path = "./files/upload/user/";
		if (file_exists($path)) {
			$user_files = scandir($path);
			foreach ($user_files as $user_file) {
				if (in_array($user_file, array(".","..")) || !is_dir($path.$user_file)) continue;
				if (!empty($user_file)) {
					$this->rrmdir($path.$user_file);
				}
			}
		}
	}
	
	function rrmdir($dir)
	{
		if (is_dir($dir)) {
			$expired_time = mktime(date("H"), date("i"), date("s"), date("m"), date("d")-1, date("Y"));
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if (filetype($dir."/".$object) == "dir") {
						$this->rrmdir($dir."/".$object);
					} else {
						if ($expired_time > filectime($dir."/".$object)) {
							unlink($dir."/".$object);
							// Inform by mail
							$content = "<p>System deleted</p>
										<p>File name: ".$dir."/".$object."</p>";
							$mail = array(
				            		"subject"		=> "[CVT] System alert",
									"from_sender"	=> "noreply@vietnam-visa.org.vn",
				            		"name_sender"	=> SITE_NAME,
									"to_receiver"   => MAIL_INFO,
									"message"       => $content
							);
							// $this->mail->config($mail);
							// $this->mail->sendmail();
						}
					}
				}
			}
			reset($objects);
			
			// Remove empty dir
			$objects = scandir($dir);
			$nfile = 0;
			foreach ($objects as $object) {
				if (in_array($object, array(".",".."))) continue;
				$nfile++;
			}
			
			if (!$nfile) {
				rmdir($dir);
			}
			reset($objects);
		}
	}
}

?>