<?php
namespace Marsvin\Generator;

use SplFileObject;
use RuntimeException;

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

    public function getNamespace()
    {
        return $this->namespace;
    }

    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    public function getDir()
    {
        return $this->dir . DIRECTORY_SEPARATOR . $this->getClassName() . DIRECTORY_SEPARATOR;
    }

    public function setDir($dir)
    {
        $this->dir = $dir;
    }

    public function getClassName()
    {
        return end(explode('\\', $this->namespace));
    }

    public function renderFile($parameters)
    {
        if (!is_dir($this->getDir())) {
            mkdir($this->getDir(), 0777, true);
        }

        $content = file_get_contents($this->skeleton);

        $placeholders = $this->preparePlaceholders($parameters);
        $content = str_replace($placeholders, array_values($parameters), $content);

        $sufix = '';

        if (static::SUFIX) {
            $sufix = static::SUFIX;
        }

        file_put_contents($this->getDir() . $this->getClassName() . $sufix . '.php', $content);
    }

    protected function preparePlaceholders($parameters)
    {
        $placeholders = array();

        foreach ($parameters as $key => $value)
        {
            array_push(
                $placeholders,
                '{{ ' . $key . ' }}'
            );
        }

        return $placeholders;
    }

}