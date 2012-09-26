<?php
namespace Marsvin\Provider;

use Marsvin\Provider\ProviderInterface;
use Marsvin\Provider\AbstractProvider;
use Marsvin\Requester\Adapter\BuzzAdapter;
use Marsvin\Parser\Adapter\DomAdapter;
use Marsvin\Persister\Adapter\DefaultAdapter;

class Provider extends AbstractProvider implements ProviderInterface
{

    public function getRequesterAdapter()
    {
        return new BuzzAdapter();
    }

    public function getParserAdapter()
    {
        return new DomAdapter();
    }

    public function getPersisterAdapter()
    {
        return new DefaultAdapter();
    }

}
