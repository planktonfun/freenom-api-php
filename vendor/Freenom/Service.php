<?php

require_once 'Exception.php';

class Freenom_Service
{
	const PING = 'https://api.freenom.com/v2/service/ping';

	public function __construct(Freenom_Client $client)
	{
		$this->email     = $client->getApiLoginId();
		$this->password  = $client->getApiPassword();
		$this->curl      = new Freenom_IO_Curl;
	}

	public function ping()
	{
		$api_url  = Self::PING;
		$response = json_decode($this->curl->executeGetAPI($api_url),true);

		if(isset($response['status']) && $response['status'] != 'OK')
			throw new Freenom_Exception('500 Server Error', 500);

		if(!isset($response['status']))
			throw new Freenom_Exception('No Connection to API', 403);
	}
}