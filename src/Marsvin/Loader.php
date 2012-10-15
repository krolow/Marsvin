<?php
namespace Marsvin;

use Symfony\Component\Console\Helper\HelperSet;
use Evenement\EventEmitter;
use Spork\ProcessManager;

class Loader
{

    private $providerClass;

    public function __construct($providerClass)
    {
        $this->providerClass = $providerClass;
    }

    public function load(HelperSet $helperSet, EventEmitter $event = null, ProcessManager $process = null)
    {
        if (!class_exists($this->providerClass)) {
            throw new \InvalidArgumentException(
                   sprintf(
                       'It was not possible to load the given provider class %s',
                       $this->providerClass
                   )
               );
        }

        $provider = new $this->providerClass($helperSet, $event, $process);

        $interface = 'Marsvin\\Provider\\ProviderInterface';

        if ($provider instanceof $interface) {
            return $provider;
        }

        throw new \InvalidArgumentException(
            sprintf('The given provider must implements the Marsvin\Provider\ProviderInterface')
        );
    }

}
