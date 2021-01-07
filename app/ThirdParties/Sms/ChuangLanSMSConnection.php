<?php

namespace App\ThirdParties\Sms;

class ChuangLanSMSConnection
{
    protected $userKey = '';
    protected $passKey = '';
	protected $url = '';
    protected $targetPhone = '';
    protected $message = '';

	public function __construct() 
	{
		$this->url = env('CHUANGLANSMS_URL', '');
		$this->userKey = env('CHUANGLANSMS_USERKEY', '');
        $this->passKey = env('CHUANGLANSMS_PASSKEY', '');
		$this->senderId = env('CHUANGLANSMS_SENDERID', '');
		return $this;
	}

	public function setMessage($targetPhone = '', $message = '') 
	{
        $this->targetPhone = $targetPhone;
        $this->message = $message;
		return $this;
	}

	public function send() 
	{

        $url = $this->url;
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url);
		$payload = json_encode([
			'account' 	=> $this->userKey,
			'password' 	=> $this->passKey,
			'msg' 		=> $this->message,
			'mobile'	=> $this->targetPhone // format: 6281234567890
		]);
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		# Return response instead of printing.
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		# Send request.
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
	}
}