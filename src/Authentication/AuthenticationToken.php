<?php

namespace Propcom\ESP\EliteLive\Authentication;

class AuthenticationToken
{
	public static function createFromRequestTokenResponse($tokenData)
	{
		$instance = (new self())
			->setToken($tokenData->Token)
			->setExpiry(\DateTime::createFromFormat('Y-m-d H:i:s', $tokenData->Expiry, new \DateTimeZone('UTC')));

		return $instance;
	}

	protected $token;
	protected $expiry;

	public function setToken($token)
	{
		$this->token = $token;

		return $this;
	}

	public function setExpiry($expiry)
	{
		if ($expiry instanceof \DateTime) {
			$this->expiry = $expiry;
		} else if (is_integer($expiry)) {
			$this->expiry = \DateTime::createFromFormat('U', $expiry);
		}

		return $this;
	}

	public function getToken()
	{
		return $this->token;
	}

	public function getExpiry()
	{
		return $this->expiry;
	}

	public function hasExpired()
	{
		return ($this->expiry <= (new \DateTime('now')));
	}
}
