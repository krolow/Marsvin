<?php
namespace Test\Marsvin\Provider;

use Marsvin\Provider\Provider;

class ProviderTest extends \PHPUnit_Framework_TestCase
{

    private $marsvin;

    protected function setup()
    {
        $this->event    = $this->getMock('Evenement\EventEmitter');
        $this->process  = $this->getMock(
            'Spork\ProcessManager', 
            array(), 
            array(
                $this->getMock('Spork\EventDispatcher\EventDispatcher')
            )
        );
        $this->provider = new Provider($this->event, $this->process);
    }

    protected function tearDown()
    {
        $this->provider = null;
    }

    public function testInstanceOfAdapters()
    {
        $this->assertInstanceOf('Marsvin\\Requester\\Adapter\\AdapterInterface', $this->provider->getRequesterAdapter());
        $this->assertInstanceOf('Marsvin\\Parser\\Adapter\\AdapterInterface', $this->provider->getParserAdapter());
        $this->assertInstanceOf('Marsvin\\Persister\\Adapter\\AdapterInterface', $this->provider->getPersisterAdapter());
    }

    public function testCreationOfRequester()
    {
        $this->assertInstanceOf('Marsvin\\Requester\\RequesterInterface', $this->provider->getRequester());
        $this->assertInstanceOf('Marsvin\\Parser\\ParserInterface', $this->provider->getParser());
        $this->assertInstanceOf('Marsvin\\Persister\\PersisterInterface', $this->provider->getPersister());
    }

}
