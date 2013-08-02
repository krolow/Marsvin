<?php
namespace {{ namespace }};

use Marsvin\Provider\AbstractProvider;
use Marsvin\Provider\ProviderInterface;

class {{ className }} extends AbstractProvider implements ProviderInterface
{
    /**
     * Retrive the class that will handle requests
     * 
     * @return Marsvin\Requester\Adapter\AdapterInterface
     */
    public function getRequesterAdapter()
    {
        
    }

    /**
     * Retrive the class that will handle parsers
     * 
     * @return Marsvin\Parser\Adapter\AdapterInterface
     */
    public function getParserAdapter()
    {
        
    }

    /**
     * Retrive the class that will handle persistence
     * 
     * @return Marsvin\Persister\Adapter\AdapterInterface
     */
    public function getPersisterAdapter()
    {
        
    }
}