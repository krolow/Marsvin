<?php
namespace {{ namespace }};

use Marsvin\Persister\AbstractPersister;
use Marsvin\Persister\PersisterInterface;
use Marsvin\ResponseInterface;

class {{ persister }} extends AbstractPersister implements PersisterInterface
{

    public function persists(ResponseInterface $response)
    {
        $adapter = $this->getAdapter();
    }

}
