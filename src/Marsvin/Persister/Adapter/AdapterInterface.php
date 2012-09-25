<?php
namespace Marsvin\Persister\Adapter;

interface AdapterInterface
{

    public function persist();

    public function flush();

}
