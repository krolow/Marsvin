<?php
namespace Marsvin\Requester;

use Marsvin\AbstractLayer;
use Marsvin\Requester\Adapter\AdapterInterface;

abstract class AbstractRequester extends AbstractLayer
{

    const EVENT_NAME = 'requester.done';

    public function __construct(EventEmmiter $event, ProcessManager $process, AdapterInterface $adapter)
    {
        parent::__construct($event, $process, $adapter);
    }

}
