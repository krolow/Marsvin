<?php
namespace {{ namespace }};

use Marsvin\Parser\AbstractParser;
use Marsvin\Parser\ParserInterface;
use Marsvin\Response;
use Marsvin\ResponseInterface;

class {{ className }} extends AbstractParser implements ParserInterface
{
    /**
     * Perform the parser
     * 
     * @param ResponseInterface $response
     * 
     * @return void
     */
    public function parse(ResponseInterface $response)
    {
        $adapter = $this->getAdapter();
    }
}
