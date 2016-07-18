<?php

class email extends Form{
	
	private $headers;
	
	public $to;
	public $bcc;
	public $cc;
	public $from;
	public $replyto;
	public $subject;
	public $body;
	
	public function init(){
	}
	
	public function send(){
		//setup ini
		ini_set('SMTP', App::$config->email->host);
		ini_set('sendmail_path', '/usr/sbin/sendmail');

		//set headers
		$this->headers  = 'MIME-Version: 1.0' .  "\r\n";
		$this->headers .= 'Content-Type: text/html; charset=utf-8' .  "\r\n";
		$this->headers .= 'X-Mailer: php' .  "\r\n";
//		$this->headers .= 'Content-Type: text/html; charset=utf-8' . "\n\r";
		$this->headers .= 'From: ' . $this->from .  "\r\n";
		$this->headers .= 'Bcc: ' . $this->bcc .  "\r\n";
		$this->headers .= 'Cc: ' . $this->cc .  "\r\n";

		try {
			return @mail($this->to, $this->subject, $this->body, $this->headers);
		}catch (Exception $e){
			var_dump($e->getMessage());
			return false;
		}
	}
}