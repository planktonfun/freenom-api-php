<?php

class Freenom_IO_Curl
{
	public function executeGetAPI($api_url)
	{
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);

        curl_close($ch);

        return $output;
	}

	public function executePutAPI($api_url, $params)
	{
        $ch = curl_init($api_url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }

    public function executeDeleteAPI($api_url, $params)
	{
        $ch = curl_init();

	    curl_setopt($ch, CURLOPT_URL, $api_url);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
	    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	    $response = curl_exec($ch);

	    curl_close($ch);

	    return $response;
    }

	public function executePostAPI($api_url, $params)
	{
	    $curl_handler = curl_init();

	    curl_setopt($curl_handler, CURLOPT_URL, $api_url);
	    curl_setopt($curl_handler, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36');
	    curl_setopt($curl_handler, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl_handler, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($curl_handler, CURLOPT_HEADER, false);
	    curl_setopt($curl_handler, CURLOPT_FOLLOWLOCATION, false);
	    curl_setopt($curl_handler, CURLOPT_POST, 1);
	    curl_setopt($curl_handler, CURLOPT_POSTFIELDS, $params);
	    curl_setopt($curl_handler, CURLOPT_FORBID_REUSE, true);
	    curl_setopt($curl_handler, CURLOPT_FRESH_CONNECT, true);

	    $response = curl_exec($curl_handler);

	    curl_close($curl_handler);

	    return $response;
	}

	public function executePostJsonAPI($api_url, $params)
	{
		return $this->parseJSON($this->executePostAPI($api_url, $params));
	}

	public function executeGetJsonAPI($api_url, $params = [])
	{
		return $this->parseJSON($this->executeGetAPI($api_url.$this->parseGetParams($params)));
	}

	public function executePutJsonAPI($api_url, $params)
	{
		return $this->parseJSON($this->executePutAPI($api_url, $params));
	}

	public function executeDeleteJsonAPI($api_url, $params)
	{
		return $this->parseJSON($this->executeDeleteAPI($api_url, $params));
	}

	public function parseGetParams($data)
	{
		$parsed = '?';
		$params = [];

		foreach ($data as $name => $value) {
			$params[] = $name.'='.$value;
		}

		return $parsed . implode('&', $params);
	}

	public function parseJSON($rawData)
	{
		$response = json_decode($rawData,TRUE);

		if(isset($response['status']) && $response['status'] == 'error') {
			switch($response['error']) {
				case "No anonymous access, authorization required":
				case "Login credentials do not match any account":
					throw new Freenom_Authorize_Exception($response['error'], 400);
					break;

				case "No function called or function not supported":
					throw new Freenom_Service_Exception($response['error'], 500);
					break;

				default:
					if(stripos($response['error'],'Invalid')!=-1)
						throw new Freenom_Request_Exception($response['error'], 400);
					else
						throw new Freenom_Exception($response['error'], 400);
					break;
			}
		}

		return (is_null($response)) ? $rawData : $response;
	}
}