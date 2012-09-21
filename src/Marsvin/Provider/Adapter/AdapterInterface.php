<?php
namespace Marsven\Adapter;

interface AdapterInterface
{
	
	public function getPersisterAdapter();

	public function getParserAdapter();

	public function getRequesterAdapter();

}