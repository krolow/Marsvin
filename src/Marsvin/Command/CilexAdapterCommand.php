<?php
namespace Marsvin\Command;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Cilex\Command\Command as CilexCommand;


class CilexAdapterCommand extends CilexCommand
{

    private $command;
    
    public function __construct(SymfonyCommand $command)
    {
        $this->command = $command;
    }

    public static function __callStatic($name, $arguments)
    {
        // Note: value of $name is case sensitive.
        echo "Calling static method '$name' "
             . implode(', ', $arguments). "\n";
    }

    public function __call($name, $args = array())
    {
        var_dump($name);
        var_dump($args);
        //$this->command->{$name}()
    }

}