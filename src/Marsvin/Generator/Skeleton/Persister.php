<?php
namespace {{ namespace }}\Persister;

use Marsvin\Persister\AbstractPersister;
use Marsvin\Persister\PersisterInterface;
use Marsvin\ResponseInterface;

class {{ persister }} extends AbstractPersister implements PersisterInterface
{

    public function persister(ResponseInterface $response)
    {
        $adapter = $this->getAdapter();
    }

}
