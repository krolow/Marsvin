<?php
namespace Marsvins\Parser;

class Parser extends AbstractParser implements ParserInterface
{
    
    private $parser = $parser;

    public function __construct($parser)
    {
        if (!is_callable($parser)) {
            throw new \InvalidArgumentException(
                'The given parser must be anonymous function'
            );
        }
        $this->parser = $parser;
    }
    
}