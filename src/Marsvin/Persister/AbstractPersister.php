<?php
namespace Marsvin\Persister;

abstract class AbstractPersister
{
    
    protected $eventManager;

    protected $processManager;

    public function __construct(
        \Evenement\EventEmitter $eventManager,
        \Spork\ProcessManager $processManager,
        Marsvin\Persister\AdapterPersisterInterface $adapter
    ) {
        $this->eventManager     = $eventManager;
        $this->processManager   = $processManager;
        $this->adpter           = $adapter;
    }

    public function getProcessManager()
    {
        return $this->processManager;
    }

    public function getEventManager()
    {
        return $this->eventManager;
    }

    public function getAdapter()
    {
        return $this->adapter;
    }
}