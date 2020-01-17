<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mail extends CI_Email {

	var $_mail;
	 
	function __construct()
	{
		parent::__construct();
	}
	
	public function config($data)
	{
		$this->_mail=array(
			'from_sender'       => !empty($data['from_sender']) ? $data['from_sender'] : MAIL_INFO,
			'name_sender'       => !empty($data['name_sender']) ? $data['name_sender'] : MAIL_INFO,
			'to_receiver'       => !empty($data['to_receiver']) ? $data['to_receiver'] : '',
			'cc'       			=> !empty($data['cc']) ? $data['cc'] : '',
			'bcc'       		=> !empty($data['bcc']) ? $data['bcc'] : '',
			'subject_sender'    => !empty($data['subject']) ? $data['subject'] : 'No reply',
			'message'       	=> !empty($data['message']) ? $data['message'] : '',
			'attachment'		=> !empty($data['attachment']) ? $data['attachment'] : '',
		);
	}
	
	public function sendmail($mail = null, $password = null)
	{
		$CI =& get_instance();
		$CI->load->library('util');
		$CI->load->model('m_mail');
		
		$config = array();
		$config['protocol']		= 'smtp';
		$config['useragent']	= COMPANY;
		$config['smtp_host']	= 'smtp.gmail.com';
		$config['mailpath']		= '';
		$config['smtp_port']    = '465';
		$config['smtp_timeout'] = '10';
		if (!empty($mail) && !empty($password)) {
			$config['smtp_user']    = $mail;
			$config['smtp_pass']    = $password;
		} else {
			$config['smtp_user']    = 'noreply@vietnam-visa.org.vn';
			$config['smtp_pass']    = 'iKWh-Li>l$-gjKlo2-';
		}
		$config['charset']    	= 'utf-8';
		$config['newline']    	= "\r\n";
		$config['mailtype'] 	= 'html';
		$config['validation'] 	= TRUE;
		$config['smtp_crypto'] 	= 'ssl';
		
		if ($this->_mail['from_sender'] == CDN_MAIL_NOREPLY_USER) {
			$config['smtp_user'] = CDN_MAIL_NOREPLY_USER;
			$config['smtp_pass'] = CDN_MAIL_NOREPLY_PASS;
		}

		$this->initialize($config);

		$this->from($this->_mail['from_sender'], $this->_mail['name_sender']);
		if (empty($mail) && !empty($password)) {
		$this->reply_to($this->_mail['from_sender'], $this->_mail['name_sender']);
		}
		$this->to($this->_mail['to_receiver']);
		
		if (!empty($this->_mail['cc'])) {
			$this->cc($this->_mail['cc']);
		}
		
		if (!empty($this->_mail['bcc'])) {
			$this->bcc($this->_mail['bcc']);
		}
		
		if (!empty($this->_mail['attachment'])) {
			if (is_array($this->_mail['attachment'])) {
				foreach ($this->_mail['attachment'] as $attachment) {
					$this->attach($attachment);
				}
			}
			else {
				$this->attach($this->_mail['attachment']);
			}
		}
		
		if ($this->_mail['to_receiver'] == MAIL_INFO) {
		}

		$this->subject($this->_mail['subject_sender']);
		$this->message($this->_mail['message']);
		
		if (!$this->send()) {
			// $config['smtp_user']    = 'noreply@visa-vietnam.org.vn';
			// $config['smtp_pass']    = 'GmailVs2016Orgvn';
			if (!empty($mail) && !empty($password)) {
				$config['smtp_user']    = $mail;
				$config['smtp_pass']    = $password;
			} else {
				$config['smtp_user']    = 'noreply@vietnam-visa.org.vn';
				$config['smtp_pass']    = 'iKWh-Li>l$-gjKlo2-';
			}
			$this->initialize($config);
			
			$this->from($this->_mail['from_sender'], $this->_mail['name_sender']);
			if (empty($mail) && !empty($password)) {
			$this->reply_to($this->_mail['from_sender'], $this->_mail['name_sender']);
			}
			$this->to($this->_mail['to_receiver']);
			
			if (!empty($this->_mail['cc'])) {
				$this->cc($this->_mail['cc']);
			}
			
			if (!empty($this->_mail['bcc'])) {
				$this->bcc($this->_mail['bcc']);
			}
			
			if (!empty($this->_mail['attachment'])) {
				if (is_array($this->_mail['attachment'])) {
					foreach ($this->_mail['attachment'] as $attachment) {
						$this->attach($attachment);
					}
				}
				else {
					$this->attach($this->_mail['attachment']);
				}
			}
			
			if ($this->_mail['to_receiver'] == MAIL_INFO) {
			}
			$this->subject($this->_mail['subject_sender']);
			$this->message($this->_mail['message']);
			$this->send();
		}
		
		if ($this->_mail['to_receiver'] == MAIL_INFO) {
			$data = array (
							"sender"		=> $this->_mail['from_sender'],
							"receiver"		=> $this->_mail['to_receiver'],
							"title"			=> $this->_mail['subject_sender'],
							"message"		=> $this->_mail['message'],
							'created_date' 	=> date("Y-m-d H:i:s")
			);
			$CI->m_mail->add($data);
		}
		
		$this->clear(TRUE);
	}
}