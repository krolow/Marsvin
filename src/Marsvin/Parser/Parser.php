<?php
namespace Marsvin\Parser;

use Marsvin\Parser\AbstractParser;
use Marsvin\Parser\ParserInterface;
use Marsvin\ResponseInterface;

class Parser extends AbstractParser implements ParserInterface
{

    private $handle;

    public function setHandle($handle)
    {
        $this->handle = $handle;
    }

    public function parse(ResponseInterface $response)
    {
        $this->handle($this, $response);
    }

}
