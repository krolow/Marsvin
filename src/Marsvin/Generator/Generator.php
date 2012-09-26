<?php
namespace Marsvin\Generator;

use SplFileObject;

class Generator
{
    
    protected $namespace;

    protected $name;

    public function __construct($namespace, $dir, SplFileObject $skeleton)
    {
        $this->namespace = $namespace;
        $this->dir = $dir;
        $this->skeleton = $skeleton;
    }

    public function getDir()
    {
        return $this->dir . DIRECTORY_SEPARATOR . strstr($this->namespace, '\\', '/');
    }

    public function getClassName()
    {
        return end(explode('\\', $this->namespace));
    }

    public function renderFile($path, $parameters)
    {
        $content = file_get_contents($this->skeleton);
        $content = str_replace(array_keys($parameters), array_values($parameters), $content);

        var_dump($content);
    }

}