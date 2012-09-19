<?php
namespace Marsvin;

use Marsvin\ProviderInterface;
use Marsvin\FactoryProvider;
use Marsvin\RequesterResponse;
use Marsvin\Response;


abstract class AbstractProvider implements ProviderInterface
{

    /**
     * Dependecy Injection Container
     * 
     * @var \Evenement\EventEmitter
     */
    protected $eventManager;

    public function __construct(Marsvin\Adapter\AdapterProviderInterface $adapter)
    {
        $this->eventManager = $eventManager;
    }

    /**
     * Import the Provider
     * 
     * @return void
     */
    public function import()
    {
        $self = $this;

        $this->adapter->getEventManager()->on(
            'requester.done', 
            function (ResponseInterface $response) use ($self) {
                $self->getParser()->parse($response);
            }
        );
        $this->adapter->getEventManager()->on(
            'parser.done',
            function (ResponseInterface $response) use ($self) {
                $self->getPersister()->persists($response);
            }
        );

        $this->getRequester()->request();
    }

    /**
     * Create requester Object
     * 
     * @return RequesterInterface
     */
    public function getRequester()
    {
        return $this->factoryCreate(
            'requester', 
            array(
                $this->container['evenement.emitter'],
                $this->container['buzz'],
                $this->container['spork']
            )
        );
    }
    
    /**
     * Create parser object
     * 
     * @return ParserInterface
     */
    public function getParser()
    {
        return $this->factoryCreate(
            'parser',
            array(
                $this->container['evenement.emitter'],
                $this->container['spork']
            )
        );
    }

    /**
     * Create persister object
     * 
     * @return PersisterInterface
     */
    public function getPersister()
    {
        return $this->factoryCreate(
            'persister',
            array(
                $this->container['evenement.emitter'],
                $this->container['spork']
            )
        );
    }        

    /**
     * Call factory to create the given type of object
     * 
     * @param  string $type Given type to be created
     * 
     * @return PersisterInterface|ParserInterface|RequesterInterface
     */
    private function factoryCreate($type, $arguments = array())
    {
        return ProviderFactory::create(
            $this->getClassName(),
            $type,
            $arguments
        );
    }

    public function getClassName()
    {
        $class = explode('\\', get_called_class());
        array_pop($class);

        $provider = end($class);


        return implode('\\', $class) . '\\' . $provider;
    }

}