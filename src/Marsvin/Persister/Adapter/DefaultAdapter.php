<?php
namespace Marsvin\Persister\Adapter;

use Marsvin\Persister\Adapter\AdapterInterface;

class DefaultAdapter implements AdapterInterface
{
	
	private $entities = array();

	public function persist($entity)
	{
		array_push(
			$this->entities,
			$entity
		);
	}

	public function flush()
	{
		$this->entities;
	}

}