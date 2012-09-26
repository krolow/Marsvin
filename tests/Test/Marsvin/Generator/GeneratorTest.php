<?php
namespace Test\Generator;

use Marsvin\Generator\Generator;

class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    
    protected function setUp()
    {
        $this->file = $this->getMock(
            '\SplFileObject',
            array(),
            array(
                str_replace(
                    '/',
                    DIRECTORY_SEPARATOR,
                    dirname(dirname(dirname(dirname(__DIR__)))) . '/src/Marsvin/Generator/Skeleton/Provider.php'
                )
            )
        );
    }

    public function testDir()
    {
        $namespace = 'Test\Cobaia\Krolow';
        $dir = 'src/';

        $generator = new Generator($namespace, $dir, $this->file);
        $this->assertEquals($generator->getClassName(), 'Krolow');
        var_dump($generator->getDir());
        exit;
    }

}