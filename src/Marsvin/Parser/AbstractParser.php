<?php
namespace Marsvin\Parser;

use Marsvin\Parser\AdapterInterface;

abstract class AbstractParser
{

	const EVENT_NAME = 'parser.done';

    public function __construct(EventEmmiter $event, ProcessManager $process, AdapterInterface $parser)
    {
        parent::__construct($event, $process, $parser);
    }    

}