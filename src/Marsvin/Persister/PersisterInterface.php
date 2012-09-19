<?php
namespace Marsvin;

use Marsvin\ResponseInterface;

interface PersisterInterface
{
    
    public function persists(ResponseInterface $response);

}