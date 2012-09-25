<?php
namespace Marsvin\Provider;

use Marsvin\Response;
use Marsvin\AbstractLayer;
use Marsvin\Provider\ProviderInterface;
use Marsvin\Provider\Adapter\AdapterInterface as ProviderAdapterInterface;
use Evenement\EventEmitter;
use Spork\ProcessManager;

abstract class AbstractProvider extends AbstractLayer implements ProviderInterface
{

    /**
     * Dependecy Injection Container
     *
     * @var \Evenement\EventEmitter
     */
    protected $eventManager;

    public function __construct(
        ProviderAdapterInterface $adapter
    ) {
        parent::__construct($adapter->getEvent(), $adapter->getProcess(), $adapter);
    }

    /**
     * Import the Provider
     *
     * @return void
     */
    public function import()
    {
        $self = $this;

        $parser = $this->getParser();
        $requester = $this->getRequester();
        $persister = $this->getPersister();

        $this->event->on(
            $parser->getEventName(),
            function (ResponseInterface $response) use ($parser) {
                $parser->parse($response);
            }
        );
        $this->event->on(
            $parser->getEventName(),
            function (ResponseInterface $response) use ($self) {
                $persister->persist($response);
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
                $this->event,
                $this->process,
                $this->adapter->getRequesterAdapter()
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
                $this->process,
                $this->adapter->getParserAdapter()
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
                $this->process,
                $this->adapter->getPersisterAdapter()
            )
        );
    }

    /**
     * Call factory to create the given type of object
     *
     * @param string $type Given type to be created
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
