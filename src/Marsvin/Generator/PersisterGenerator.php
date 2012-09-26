<?php
namespace Marsvin\Generator;

use Marsvin\Generator\Generator;
use SplFileObject;
use RuntimeException;

class PersisterGenerator extends Generator
{

    const SUFIX = 'Persister';

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
                    'It\'s not possible to generate the Persister as the dir %s is empty',
                    $dir
                )
            );
        }
        
        $parameters = array(
            'namespace' => $this->getNamespace(),
            'persister' => $this->getClassName() . self::SUFIX
        );

        $this->renderFile($parameters);
    }

}