<?php
namespace Marsvin\Provider\Adapter;

use Evenement\EventEmmiter;
use Spork\ProcessManager;
use Marsvin\Provider\Adapter\AdapterInterface;
use Marsvin\Requester\Adapter\BuzzAdapter as RequesterDefaultAdapter;
use Marsvin\Parser\Adapter\DomAdapter as ParserDefaultAdapter;
use Marsvin\Persister\Adapter\DefaultAdapter as PersisterDefaultAdapter;
use Marsvin\AdapterInterface as DefaultAdapterInterface;

class DefaultAdapter implements AdapterInterface, DefaultAdapterInterface
{

    private $event;

    private $process;

    public function __construct(EventEmmiter $event, ProcessManager $process)
    {
        $this->event   = $event;
        $this->process = $process;
    }

    public function getEvent()
    {
        return $this->event;
    }

    public function getProcess()
    {
        return $this->process;
    }

    public function getRequesterAdapter()
    {
        return new Requester(
            $this->event,
            $this->process,
            new RequesterDefaultAdapter()
        );
    }

    public function getParserAdapter()
    {
        return new Parser(
            $this->event,
            $this->process,
            new ParserDefaultAdapter()
        );
    }

    public function getPersisterAdapter()
    {
        return new Persister(
            $this->event,
            $this->process,
            new PersisterDefaultAdapter()
        );
    }

}
