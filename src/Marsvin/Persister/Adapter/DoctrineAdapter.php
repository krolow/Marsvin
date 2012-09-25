<?php
namespace Marsvin\Persister\Adapter;

use Doctrine\ORM\EntityManager;
use Marsvin\Persister\AdapterInterface;

class DoctrineAdapter implements AdapterInterface
{

    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function persist($entity)
    {
        $this->em->persist($entity);
    }

    public function flush()
    {
        $this->em->flush();
    }

}
