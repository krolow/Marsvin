<?php
namespace Marsvin\Requester;

use Marsvin\AbstractLayer;
use Marsvin\Requester\Adapter\AdapterInterface;
use Evenement\EventEmitter;
use Spork\ProcessManager;
use Symfony\Component\Console\Helper\HelperSet;

abstract class AbstractRequester extends AbstractLayer
{

    const EVENT_NAME = 'requester.done';

    protected $adapter;

    public function __construct(HelperSet $helperSet, EventEmitter $event, ProcessManager $process, AdapterInterface $adapter)
    {
    	$this->adapter = $adapter;
        parent::__construct($helperSet, $event, $process);
    }

    public function getAdapter()
    {
    	return $this->adapter;
    }

}