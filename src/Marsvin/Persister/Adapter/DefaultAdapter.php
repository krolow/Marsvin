<?php
/*
 * This file is part of the Marsvin package.
 *
 * (c) Vinícius Krolow <krolow@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Marsvin\Persister\Adapter;

use Marsvin\Persister\Adapter\AdapterInterface;

class DefaultAdapter implements AdapterInterface
{

    private $entities = array();

    public function persist($entity)
    {
        array_push(
            $this->entities,
            $entity
        );
    }

    public function flush()
    {
        return $this->entities;
    }

}
