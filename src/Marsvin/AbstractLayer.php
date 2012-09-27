<?php
namespace Marsvin;

use Evenement\EventEmitter;
use Spork\ProcessManager;
use Spork\Fork;

abstract class AbstractLayer
{

    protected $event;

    protected $process;

    protected $adapter;

    protected $eventName;

    public function __construct(EventEmitter $event, ProcessManager $process)
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
                function (Fork $fork) use ($self) {
                    $self->getEvent()->emit(
                        $self->getEventName(), 
                        array($fork->getResult())
                    );
                }
            );
    }

}
