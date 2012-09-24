<?php
namespace Marsvin;

use Marsvin\Provider\ProviderInterface;
use Marsvin\Provider\AbstractProvider;

class Provider extends AbstractProvider implements ProviderInterface
{

	private $requester;

	private $parser;

	private $persister;

    /**
     * Create requester Object
     * 
     * @return RequesterInterface
     */
    public function getRequester()
    {
    	if (!$this->requester) {
    		$this->requester = new Requester(
    			$this->event, 
    			$this->process, 
    			$this->adapter->getRequesterAdapter()
    		);
    	}

    	return $this->requester;
    }
    
    /**
     * Create parser object
     * 
     * @return ParserInterface
     */
    public function getParser()
    {
    	if (!$this->parser) {
    		$this->parser =  new Parser(
    			$this->event,
    			$this->process,
    			$this->adapter->getParserAdapter()
    		);
    	}

    	return $this->parser;
    }

    /**
     * Create persister object
     * 
     * @return PersisterInterface
     */
    public function getPersister()
    {
    	if (!$this->persister) {
    		$this->persister = new Persister(
    			$this->event,
    			$this->process,
    			$this->adpter->getPersisterAdapter()
    		);
    	}

    	return $this->persister;
    }  

}