<?php
namespace Marsvin;

abstract class AbstractRequester
{

    protected $eventManager;

    protected $httpClient;

    public function __construct(
        \Evenement\EventEmitter $eventManager,
        \Buzz\Browser $httpClient,
        \Spork\ProcessManager $processManager
    ) {
        $this->eventManager = $eventManager;
        $this->httpClient = $httpClient;
        $this->processManager = $processManager;
    }

    public function getHttpClient()
    {
        return $this->httpClient;
    }

    public function getEventManager()
    {
        return $this->eventManager;
    }

}
