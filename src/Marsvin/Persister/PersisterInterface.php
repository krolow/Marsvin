<?php
namespace Marsvin\Persister;

use Marsvin\ResponseInterface;

interface PersisterInterface
{

	public function getAdapter();

    public function persists(ResponseInterface $response);

}
