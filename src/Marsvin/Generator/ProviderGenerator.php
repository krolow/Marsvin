<?php
namespace Marsvin\Generator;

class ProviderGenerator extends Generator
{

    public function __construct($namespace, $name)
    {
        parent::__construct(
            $namespace,
            $name,
            new SplFile(
                __DIR__ . 'Skeleton' . DIRECTORY_SEPARATOR . 'Provider.php'
            )
        );
    }

    public function generate()
    {
        $dir = $this->getDir();

        if (is_dir($dir)) {
            throw \RuntimeException(
                sprintf(
                    'It\'s not possible to generate the provider as the dir %s is not empty',
                    $dir
                )
            );
        }
        
        $parameters = array(
            'namespace' => $this->getNamespace(),
            'provider' => $this->getClassName() . 'Provider'
        )

        $this->renderFile($parameters);
    }

}