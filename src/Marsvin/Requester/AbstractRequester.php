<?php
namespace Marsvin;

abstract class AbstractRequester
{

    protected $eventManager;

    protected $httpClient;

    protected $adapter;

    public function __construct(
        \Evenement\EventEmitter $eventManager,
        \Spork\ProcessManager $processManager,
        RequesterAdapterInterface $adapter
    ) {
        $this->eventManager   = $eventManager;
        $this->processManager = $processManager;
        $this->adapter        = $adapter;
    }

    public function getHttpClient()
    {
        return $this->httpClient;
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