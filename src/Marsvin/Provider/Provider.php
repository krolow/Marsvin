<?php
namespace Marsvin;

use Marsvin\Provider\ProviderInterface;
use Marsvin\Provider\AbstractProvider;

class Provider extends AbstractProvider implements ProviderInterface
{

    public function __construct(
        EventEmitter $event, 
        ProcessManager $process,
        ProviderAdapterInterface $adapter
    ) {
        $this->event   = $event;
        $this->process = $process;
        $this->adapter = $adapter;
    }

}