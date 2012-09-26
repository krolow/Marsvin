<?php
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
