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

    public function request()
    {

    }

    public function parse()
    {

    }

    public function persist()
    {

    }


    public function import()
    {

    }

}