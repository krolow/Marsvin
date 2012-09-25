<?php
namespace Marsvin\Parser\Adapter;

use Marsvin\ResponseInterface;

interface AdapterInterface
{

    public function parse(ResponseInterface $response);

}
