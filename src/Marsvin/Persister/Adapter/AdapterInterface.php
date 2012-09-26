<?php
namespace Marsvin\Persister\Adapter;

interface AdapterInterface
{

    public function persist($entity);

    public function flush();

}
