<?php

class Freenom_Domain_Transfer extends Freenom_Service
{
	const TRANSFERPRICE         = 'https://api.freenom.com/v2/domain/transfer/price';
	const TRANSFERDOMAINREQUEST = 'https://api.freenom.com/v2/domain/transfer/request';
	const APPROVEDOMAINREQUEST  = 'https://api.freenom.com/v2/domain/transfer/approve';
	const DECLINEDOMAINREQUEST  = 'https://api.freenom.com/v2/domain/transfer/decline';
	const LISTDOMAINTRANSFERS   = 'https://api.freenom.com/v2/domain/transfer/list';

	public function getTransferPrice($data)
	{
		$api_url = Self::TRANSFERPRICE;

		$params = [
			'domainname' => $data['name'],
			'authcode'   => $data['authCode'],
			'email'      => $this->email,
			'password'   => $this->password
		];

		$response  = $this->curl->executeGetJsonAPI($api_url, $params);

		return $response;
	}

	public function transferDomainRequest($data)
	{
		$api_url = Self::TRANSFERDOMAINREQUEST;

		$params = [
			'domainname' => $data['domainname'],
			'authcode'   => $data['authcode'],
			'period'     => $data['period'],
			'owner_id'   => $data['ownerId'],
			'email'      => $this->email,
			'password'   => $this->password,
		];

		$response  = $this->curl->executePostJsonAPI($api_url, $params);

		return $response;
	}

	public function approveDomainRequest($data)
	{
		$api_url = Self::APPROVEDOMAINREQUEST;

		$params = [
			'domainname' => $data['domainname'],
			'email'      => $this->email,
			'password'   => $this->password,
		];

		$response  = $this->curl->executePostJsonAPI($api_url, $params);

		return $response;
	}

	public function declineDomainRequest($data)
	{
		$api_url = Self::DECLINEDOMAINREQUEST;

		$params = [
			'domainname' => $data['domainname'],
			'reason'     => $data['reason'],
			'email'      => $this->email,
			'password'   => $this->password,
		];

		$response  = $this->curl->executePostJsonAPI($api_url, $params);

		return $response;
	}

	public function listDomainRequest()
	{
		$api_url = Self::LISTDOMAINTRANSFERS;

		$params = [
			'email'      => $this->email,
			'password'   => $this->password,
		];

		$response  = $this->curl->executeGetJsonAPI($api_url, $params);

		return $response;
	}
}