<?php

namespace Propcom\ESP\EliteLive\Authentication;

class ApiException extends \RuntimeException
{
	protected $json;

	public function getJson()
	{
		return $this->json;
	}

	public function __construct($json)
	{
		$this->json = $json;
		$this->message = 'An error occurred while communicating with the ESP EliteLive API.';
	}
}