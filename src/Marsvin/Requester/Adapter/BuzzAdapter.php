<?php
namespace Marsvins\Requester\Adapter;

use Buzz\Browser;
use Marsvin\Requester\AdapterInterface;

class BuzzAdapter implements AdapterInterface
{

    public function __construct(Browser $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function request($url)
    {
        return $this->httpClient->get($url);
    }

}
