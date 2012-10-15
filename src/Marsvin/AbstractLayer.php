<?php
namespace Marsvin;

use Symfony\Component\Console\Helper\HelperSet;
use Evenement\EventEmitter;
use Spork\ProcessManager;
use Spork\Fork;
use UnexpectedTypeException;

abstract class AbstractLayer
{

    protected $helperSet;

    protected $event;

    protected $process;

    protected $adapter;

    protected $eventName;

    public function __construct(HelperSet $helperSet, EventEmitter $event, ProcessManager $process)
    {
        $this->helperSet = $helperSet;
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

    public function getHelperSet()
    {
        return $this->helperSet;
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
        if (!is_callable($process)) {
            throw new UnexpectedTypeException($process, 'callable');
        }
        
        $this->process->fork($process);
    }

    public function done($params, $name = null) {
        if (is_null($name)) {
            $name = $this->getEventName();    
        }

        if (!is_array($params)) {
            $params = array($params);    
        }

        $this->getEvent()->emit($name, $params);
    }

}