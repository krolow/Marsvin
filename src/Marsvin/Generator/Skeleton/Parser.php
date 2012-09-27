<?php
namespace {{ namespace }};

use Marsvin\Parser\AbstractParser;
use Marsvin\Parser\ParserInterface;
use Marsvin\ResponseInterface;

class {{ parser }} extends AbstractParser implements ParserInterface
{
    
    public function parse(ResponseInterface $response)
    {
        $adapter = $this->getAdapter();
    }

}
