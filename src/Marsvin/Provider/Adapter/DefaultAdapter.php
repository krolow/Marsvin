<?php
namespace Marsvin\Provider\Adapter;

use Evenement\EventEmmiter;
use Spork\ProcessManager;
use Marsvin\Requester\Adapter\DefaultAdapter as RequesterDefaultAdapter;
use Marsvin\Parser\Adapter\DefaultAdapter as ParserDefaultAdapter;
use Marsvin\Persister\Adapter\DefaultAdapter as PersisterDefaultAdapter;


class DefaultAdapter implements AdapterInterface
{
	
	private $event;

	private $process;

	public function __construct(EventEmmiter $event, ProcessManager $process)
	{
		$this->event = $event;
		$this->process = $process;
	}

	public function getRequester()
	{
		return new Requester(
			$this->event, 
			$this->process, 
			new RequesterDefaultAdapter()
		);
	}

	public function getParser()
	{
		return new Parser(
			$this->event, 
			$this->process, 
			new ParserDefaultAdapter()
		);
	}

	public function getPersister()
	{
		return new Persister(
			$this->event, 
			$this->process, 
			new PersisterDefaultAdapter()
		);
	}

}