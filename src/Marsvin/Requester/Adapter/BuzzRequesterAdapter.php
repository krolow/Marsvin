<?php
namespace Marsvins\Requester\Adapter;

class BuzzRequesterAdapter implements RequesterAdapterInterface
{

	public function __construct(\Buzz\Browser $httpClient)
	{
		$this->httpClient = $httpClient;
	}

	public function request($url)
	{
		return $this->httpClient->get($url);
	}
	
}