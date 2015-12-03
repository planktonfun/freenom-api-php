<?php

class Freenom_Exception extends Exception
{
	public $errorArray = [];

	public function addErrorArray($message)
	{
		$this->errorArray[] = $message;
	}

	public function getErrorArray()
	{
		return $this->errorArray;
	}
}

class Freenom_Authorize_Exception extends Freenom_Exception
{

}

class Freenom_Service_Exception extends Freenom_Exception
{

}

class Freenom_Request_Exception extends Freenom_Exception
{

}
