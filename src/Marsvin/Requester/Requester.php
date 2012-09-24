<?php
namespace Marsvin\Requester;

use Marsvin\Requester\AbstractPersister;
use Marsvin\Persister\PersisterInterface;
use Marsvin\ResponseInterface;

class Requester extends AbstractRequester implements RequesterInterface
{
	
    private $handle;

    public function setHandle($handle) {
        $this->handle = $handle;
    }

    public function parse(ResponseInterface $response)
    {
        $this->handle($this, $response);
    }

}