<?php
namespace Marsvin\Persister;

use Marsvin\AbastractLayer;
use Marsvin\Persister\Adapter\AdapterInterface;


abstract class AbstractPersister extends AbstractLayer
{

	const EVENT_NAME = 'persister.done';

    public function __construct(EventEmmiter $event, ProcessManager $process, AdapterInterface $parser)
    {
        parent::__construct($event, $process, $parser);
    }

}