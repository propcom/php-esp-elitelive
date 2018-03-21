<?php

namespace Propcom\ESP\EliteLive\Authentication;

class ApiClient
{
	protected $apiEndpoint;
	protected $apiUsername;
	protected $apiPassword;

	protected $log;

	public function __construct(\Psr\Log\LoggerInterface $log)
	{
		$this->log = $log;
	}

	public function setApiEndpoint($apiEndpoint)
	{
		$this->apiEndpoint = $apiEndpoint;

		return $this;
	}

	public function setApiUsername($apiUsername)
	{
		$this->apiUsername = $apiUsername;

		return $this;
	}

	public function setApiClientKey($apiClientKey)
	{
		$this->apiClientKey = $apiClientKey;

		return $this;
	}

	public function getApiEndpoint()
	{
		return $this->apiEndpoint;
	}

	public function getApiUsername()
	{
		return $this->apiUsername;
	}

	public function getApiClientKey()
	{
		return $this->apiClientKey;
	}

	protected function doRequest($command, $parameters=[], $token=null)
	{
		$client = new \GuzzleHttp\Client();

		$request = [
			'Command' => $command,
			'Params' => $parameters,
		];

		if ($token && $token instanceof AuthenticationToken) {
			$request['Token'] = $token->getToken();
		}

		$this->log->debug('doRequest', [ 'url' => $_SERVER['REQUEST_URI'], 'request' => $request ]);

		try {
			$result = $client->post(
				$this->getApiEndpoint(),
				[
					'body' => [
						'ELREQUEST' => json_encode($request),
					],
				]
			);
		} catch (\Guzzle\Http\RequestException $ex) {
			$this->log->error('doRequest', [ 'exception' => $ex ]);
			// log, and throw a wrapped exception here
		}

		$requestBody = (string)$result->getBody();

		$this->log->debug('doRequest', [ 'url' => $_SERVER['REQUEST_URI'], 'result' => $requestBody ]);

		return json_decode($requestBody);
	}

	public function generateNewToken()
	{
		$response = $this->doRequest(
			'RequestToken',
			[
				'Username' => $this->getApiUsername(),
				'ClientKey' => $this->getApiClientKey(),
			]
		);

		if ($response->Ack === -1) {
			throw new ApiException($response);
		}

		$token = AuthenticationToken::createFromRequestTokenResponse($response->Data);
		return $token;
	}

	public function getUserDetails(AuthenticationToken $token)
	{
		$response = $this->doRequest(
			'TokenCustomerDetail',
			[],
			$token
		);

		if ($response->Ack === -1) {
			throw new ApiException($response);
		}

		$user = User::createFromArray($response->Data);
		return $user;
	}
}