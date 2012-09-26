<?php
namespace Marsvin\Persister;

use Marsvin\Persister\AbstractPersister;
use Marsvin\Persister\PersisterInterface;
use Marsvin\ResponseInterface;

class Persister extends AbstractPersister implements PersisterInterface
{

    private $handle;

    public function setHandle($handle)
    {
        $this->handle = $handle;
    }

    public function persists(ResponseInterface $response)
    {
        $this->handle($this, $response);
    }

}
