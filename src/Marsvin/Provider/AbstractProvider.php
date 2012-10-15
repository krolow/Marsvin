<?php
namespace Marsvin\Provider;

use Marsvin\ResponseInterface;
use Marsvin\AbstractLayer;
use Marsvin\Provider\ProviderInterface;
use Marsvin\Provider\ProviderFactory;
use Evenement\EventEmitter;
use Spork\ProcessManager;
use Spork\EventDispatcher\EventDispatcher;
use Symfony\Component\Console\Helper\HelperSet;

abstract class AbstractProvider extends AbstractLayer implements ProviderInterface
{

    protected $requester;

    protected $persister;

    protected $parser;

    public function __construct(HelperSet $helperSet, EventEmitter $event = null, ProcessManager $process = null)
    {
        $event = $event ?: new EventEmitter();
        $process = $process ?: new ProcessManager(new EventDispatcher());
        parent::__construct($helperSet, $event, $process);
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
            $requester->getEventName(),
            function (ResponseInterface $response) use ($parser) {
                $parser->parse($response);
            }
        );
        $this->event->on(
            $parser->getEventName(),
            function (ResponseInterface $response) use ($persister) {
                $persister->persists($response);
            }
        );

        $this->getRequester()->request();

        $this->process->wait();
    }

    /**
     * Create requester Object
     *
     * @return RequesterInterface
     */
    public function getRequester()
    {
        $this->requester = $this->factoryCreate(
            'requester',
            array(
                $this->helperSet,
                $this->event,
                $this->process,
                $this->getRequesterAdapter()
            )
        );

        return $this->requester;
    }

    /**
     * Create parser object
     *
     * @return ParserInterface
     */
    public function getParser()
    {
        $this->parser = $this->factoryCreate(
            'parser',
            array(
                $this->helperSet,
                $this->event,
                $this->process,
                $this->getParserAdapter()
            )
        );

        return $this->parser;
    }

    /**
     * Create persister object
     *
     * @return PersisterInterface
     */
    public function getPersister()
    {
        $this->persister = $this->factoryCreate(
            'persister',
            array(
                $this->helperSet,
                $this->event,
                $this->process,
                $this->getPersisterAdapter()
            )
        );

        return $this->persister;
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
