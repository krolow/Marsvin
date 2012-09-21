<?php
namespace Marsvin;

use Evenement\EventEmitter;
use Spork\ProcessManager;

class Marsvin
{
    
    public function __construct(EventEmitter $eventManager, ProcessManager $processManager)
    {
        $this->eventManager = $eventManager;
        $this->processManager = $processManager;

    }

    public function request($callback)
    {
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