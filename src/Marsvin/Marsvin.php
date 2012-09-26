<?php
namespace Marsvin;

use Evenement\EventEmitter;
use Spork\ProcessManager;
use Marsvin\Provider;

class Marsvin
{

    private $process;

    public function __construct(ProviderInterface $provider = null)
    {
        $this->provider = $provider ?: new Provider($this->event, $this->process);
    }

    public function request($handle)
    {
        $this->provider->getRequester()->setHandle($handle);

        return $this;
    }

    public function parse($handle)
    {
        $this->provider->getParser()->setHandle($handle);

        return $this;
    }

    public function persist($handle)
    {
        $this->provider->getPersister()->setHandle($handle);

        return $this;
    }

    public function run()
    {
        $this->provider->import();
    }

}
