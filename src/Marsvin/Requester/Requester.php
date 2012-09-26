<?php
namespace Marsvin\Requester;

use Marsvin\ResponseInterface;
use Marsvin\Requester\RequesterInterface;

class Requester extends AbstractRequester implements RequesterInterface
{

    private $handle;

    public function setHandle($handle)
    {
        $this->handle = $handle;
    }

    public function request()
    {
        $this->handle($this, $response);
    }

}
