<?php
namespace Marsvin\Provider;

use Marsvin\Response;
use Marsvin\AbstractLayer;
use Marsvin\Provider\ProviderInterface;
use Marsvin\Provider\ProviderFactory;
use Evenement\EventEmitter;
use Spork\ProcessManager;
use Spork\EventDispatcher\EventDispatcher;

abstract class AbstractProvider extends AbstractLayer implements ProviderInterface
{

    protected $event;

    protected $process;

    public function __construct(EventEmitter $event = null, ProcessManager $process = null)
    {
        $this->event = $event ?: new EventEmitter();
        $this->process = $process ?: new ProcessManager(new EventDispatcher());
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
                $this->getRequesterAdapter()
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
                $this->getParserAdapter()
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
                $this->getPersisterAdapter()
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
            $this->getClassName($type),
            $type,
            $arguments
        );
    }

    public function getClassName($type)
    {
        $class = explode('\\', get_called_class());
        array_pop($class);

        $provider = end($class);

        if ($provider === 'Provider') {
            $type = ucfirst($type);

            return reset($class) . '\\' .  $type . '\\';
        }

        return implode('\\', $class) . '\\' . $provider;
    }

}
