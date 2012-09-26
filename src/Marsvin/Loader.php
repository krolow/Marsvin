<?php
namespace Marsvin;

class Loader
{

    private $providerClass;

    public function __construct($providerClass)
    {
        $this->providerClass = $providerClass;
    }

    public function load()
    {
        if (!class_exists($this->providerClass)) {
            throw new \InvalidArgumentException(
                   sprintf(
                       'It was not possible to load the given provider class %s',
                       $this->providerClass
                   )
               );
        }

        $provider = new $this->providerClass($container);

        $interface = 'Marsvin\\Provider\\ProviderInterface';

        if ($provider instanceof $interface) {
            return $provider;
        }

        throw new \InvalidArgumentException(
            sprintf('The given provider must implements the Marsvin\Provider\ProviderInterface')
        );
    }

}
