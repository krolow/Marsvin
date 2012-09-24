<?php
namespace Marsvin\Requester\Adapter;

class DefaultAdapter implements AdapterInterface
{

	private $url;

	public function request($url)
	{
		$this->url = $url;
	}

	public function getUrl()
	{
		return $this->url;
	}
	
}