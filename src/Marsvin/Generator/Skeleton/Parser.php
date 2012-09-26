<?php
namespace {{ namespace }}\Parser;

use Marsvin\Provider\AbstractParser;
use Marsvin\Provider\ParserInterface;
use Marsvin\ResponseInterface;

class {{ parser }} extends AbstractParser implements ParserInterface
{
    
    public function parser(ResponseInterface $response)
    {
        $adapter = $this->getAdapter();
    }

}