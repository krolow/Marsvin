<?php
namespace Marsvin;

use Evenement\EventEmitter;
use Spork\ProcessManager;
use Marsvin\Requester\Request;
use Marsvin\Provider;

class Marsvin
{
 
    private $event;

    private $provider;

    private $process;

    public function __construct(EventEmitter $event = null, ProcessManager $process = null, ProviderInterface $provider = null)
    {
        $this->event = $event ?: new EventEmitter();
        $this->process = $process ?: new ProcessManager();
        $this->provider = $provider ?: new Provider();
    }

    public function request($callback)
    {
        $request = new Request()
        $callback()
    }

    public function parse(Parse $parse)
    {
        $parser->parse();
    }

    public function persist(Persist $persist)
    {
        $persist->persist();
    }


    public function run()
    {

    }

}