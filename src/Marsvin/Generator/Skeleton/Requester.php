<?php
namespace {{ namespace }};

use Marsvin\Requester\AbstractRequester;
use Marsvin\Requester\RequesterInterface;
use Marsvin\Response;

class {{ requester }} extends AbstractRequester implements RequesterInterface
{
    
    public function request()
    {
        $adapter = $this->getAdapter();
    }

}
