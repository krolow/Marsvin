<?php
namespace Marsvin\Parser;

abstract class AbstractParser
{
    
    protected $eventManager;

    protected $httpClient;

    protected $processManager;

    public function __construct(
        \Evenement\EventEmitter $eventManager,
        \Spork\ProcessManager $processManager
    ) {
        $this->eventManager   = $eventManager;
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

    public function getProcessManager()
    {
        return $this->processManager;
    }


    protected function process($result)
    {
        $self = $this;

        $this->processManager
            ->fork($result)
            ->then(
                function (\Spork\Fork $fork) {
                    var_dump($fork->getPid());

                    $this->eventManager->emit(
                        'parser.done', 
                        array(
                            new Response($fork->getResult())
                        )
                    );
                }
            );
    }

    protected function createDOM(ResponseInteface $response)
    {
        $dom = new \DOMDocument('1.0');
        $dom->loadXML($response->get());

        return $dom;
    }

}