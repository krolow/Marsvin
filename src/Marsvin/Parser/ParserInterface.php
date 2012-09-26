<?php
namespace Marsvin\Parser;

use Marsvin\ResponseInterface;

interface ParserInterface
{

	public function getAdapter();

    public function parse(ResponseInterface $response);

}
