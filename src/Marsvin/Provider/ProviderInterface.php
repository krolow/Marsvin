<?php
namespace Marsvin\Provider;

interface ProviderInterface
{

	public function getRequesterAdapter();

	public function getPersisterAdapter();

	public function getParserAdapter();

    public function import();

}
