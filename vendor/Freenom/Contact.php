<?php

class Freenom_Contact extends Freenom_Service
{
	const CONTACTS = 'https://api.freenom.com/v2/contact/list';

	public function getList()
	{
		$api_url = Self::CONTACTS;

		$params = [
			'email'            => $this->email,
			'password'         => $this->password
		];

		$response  = $this->curl->executeGetJsonAPI($api_url, $params);

		return $response;
	}

	public function getInfo($data)
	{
		$api_url = Self::CONTACTS;

		$params = [
			'contact_id' => $data['contactId'],
			'email'      => $this->email,
			'password'   => $this->password,
		];

		$response  = $this->curl->executeGetJsonAPI($api_url, $params);

		return $response;
	}
}