<?php
namespace Marsvin\Persister\Adapter;

interface PersisterAdapterInterface
{
	
	public function persist();

	public function flush();

}