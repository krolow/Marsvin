<?php
namespace Marsvin\Parser;

use Marsvin\Parser\Adapter\AdapterInterface;
use Marsvin\AbstractLayer;
use Evenement\EventEmitter;
use Spork\ProcessManager;

abstract class AbstractParser extends AbstractLayer
{

    const EVENT_NAME = 'parser.done';

    public function __construct(EventEmitter $event, ProcessManager $process, AdapterInterface $adapter)
    {
    	$this->adapter = $adapter;
        parent::__construct($event, $process);
    }

    public function getAdapter()
    {
    	return $this->adapter;
    }

}
