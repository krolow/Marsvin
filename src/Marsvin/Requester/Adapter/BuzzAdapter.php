<?php
namespace Marsvin\Requester\Adapter;

use Buzz\Browser;
use Buzz\Client\Curl;
use Marsvin\Requester\Adapter\AdapterInterface;

class BuzzAdapter implements AdapterInterface
{

    public function __construct(Browser $httpClient = null)
    {
        $this->httpClient = $httpClient ?: new Browser(new Curl());
    }

    public function request($url)
    {
        return $this->httpClient->get($url);
    }

}
