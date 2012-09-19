<?php
namespace Marsvin;

use Marsvin\ProviderInterface;
use Marsvin\FactoryProvider;
use Marsvin\RequesterResponse;
use Marsvin\Response;
use Evenement\EventEmitter;
use Spork\ProcessManager;

abstract class AbstractProvider implements ProviderInterface
{

    /**
     * Dependecy Injection Container
     * 
     * @var \Evenement\EventEmitter
     */
    protected $eventManager;

    public function __construct(
        EventEmitter $event, 
        ProcessManager $process, 
        ProviderAdapterInterface $providerAdapter
    ) {
        $this->event           = $event;
        $this->process         = $process;
        $this->providerAdapter = $providerAdapter;
    }

    /**
     * Import the Provider
     * 
     * @return void
     */
    public function import()
    {
        $self = $this;

        $this->event->on(
            'requester.done', 
            function (ResponseInterface $response) use ($self) {
                $self->getParser()->parse($response);
            }
        );
        $this->event->on(
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
                $adpter,
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
                $this->event,
                $this->process
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
                $this->event,
                $this->process
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