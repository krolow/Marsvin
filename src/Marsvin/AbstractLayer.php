<?php
namespace Marsvin;

use Evenement\EventEmitter;
use Spork\ProcessManager;

abstract class AbstractLayer
{

    protected $event;

    protected $process;

    protected $adapter;

    protected $eventName;

    public function __construct(EventEmitter $event, ProcessManager $process, AdapterInterface $adapter)
    {
        $this->event   = $event;
        $this->process = $process;
        $this->adapter = $adapter;
    }

    public function getEvent($event)
    {
        return $this->event;
    }

    public function getProcess($process)
    {
        return $this->process;
    }

    public function getAdapter()
    {
        return $this->adapter;
    }

    public function setEventName($eventName)
    {
        $this->eventName = $eventName;
    }

    public function getEventName()
    {
        if (empty($this->eventName)) {
            if (!static::EVENT_NAME) {
                throw \RuntimeException('Your must have set one event name');
            }

            return static::EVENT_NAME;
        }

        return $this->eventName;
    }

    public function process($process)
    {
        $self = $this;

        $this->process
            ->fork($process)
            ->then(
                function (Spork\Fork $fork) use ($self) {
                    $self->event->emit(
                        $self->getEventName(), 
                        array($fork->getResult())
                    );
                }
            );
    }

}
