<?php
namespace {{ namespace }};

use Marsvin\Persister\AbstractPersister;
use Marsvin\Persister\PersisterInterface;
use Marsvin\Response;
use Marsvin\ResponseInterface;

class {{ className }} extends AbstractPersister implements PersisterInterface
{
    /**
     * Perform the persistence
     * 
     * @param ResponseInterface $response
     * 
     * @return void
     */
    public function persists(ResponseInterface $response)
    {
        $adapter = $this->getAdapter();
    }
}
