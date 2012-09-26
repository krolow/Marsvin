<?php
namespace Marsvin\Generator;

use Marsvin\Generator\Generator;
use SplFileObject;
use RuntimeException;

class RequesterGenerator extends Generator
{

    const SUFIX = 'Requester';

    public function __construct($namespace, $name)
    {
        parent::__construct(
            $namespace,
            $name,
            new SplFileObject(
                __DIR__ . DIRECTORY_SEPARATOR . 'Skeleton' . DIRECTORY_SEPARATOR . self::SUFIX . '.php'
            )
        );
    }

    public function generate()
    {
        $dir = $this->getDir();

        if (!is_dir($dir)) {
            throw new RuntimeException(
                sprintf(
                    'It\'s not possible to generate the requester as the dir %s is empty',
                    $dir
                )
            );
        }

        $parameters = array(
            'namespace' => $this->getNamespace(),
            'requester' => $this->getClassName() . self::SUFIX
        );

        $this->renderFile($parameters);
    }

}