<?php
namespace Marsvin\Requester;

use Marsvin\AbstractLayer;
use Marsvin\Requester\Adapter\AdapterInterface;
use Evenement\EventEmitter;
use Spork\ProcessManager;

abstract class AbstractRequester extends AbstractLayer
{

    const EVENT_NAME = 'requester.done';

    protected $adapter;

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
