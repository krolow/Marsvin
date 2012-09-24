<?php
namespace Marsvins\Parser;

use Marsvin\ResponseInterface;

class Parser extends AbstractParser implements ParserInterface
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