<?php
/*
 * This file is part of the Marsvin package.
 *
 * (c) Vinícius Krolow <krolow@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Marsvin\Provider;

use ReflectionClass;

class ProviderFactory
{

    /**
     * Create the classes needed for Provider
      *
     * @param string $class [description]
     * @param string $type  [description]
     * @param  array [description]
     *
     * @return RequesterInterface|ParserInterface|PersisterInterface
     */
    public static function create($class, $type, $args)
    {
        $class = $class . ucfirst($type);

        $refClass = new ReflectionClass($class);
        $object = $refClass->newInstanceArgs($args);

        return $object;
    }

}
