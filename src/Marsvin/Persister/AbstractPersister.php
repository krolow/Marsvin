<?php
namespace Marsvin\Persister;

use Marsvin\AbstractLayer;
use Marsvin\Persister\Adapter\AdapterInterface;
use Evenement\EventEmitter;
use Spork\ProcessManager;
use Symfony\Component\Console\Helper\HelperSet;

abstract class AbstractPersister extends AbstractLayer
{

    const EVENT_NAME = 'persister.done';

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
