<?php
/*
 * This file is part of the Marsvin package.
 *
 * (c) Vinícius Krolow <krolow@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Generator;

use Marsvin\Generator\PersisterGenerator;

/**
 * PersisterGenerator Unit Test
 * 
 * 
 * @author Vinícius Krolow <krolow@gmail.com>
 */
class PersisterGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * PersisterGenerator
     * 
     * @var PersisterGenerator
     */
    private $generator;

    /**
     * SetUp
     * 
     * @var void
     */
    public function setUp()
    {
        $this->generator = new PersisterGenerator();
    }

    /**
     * TearDown
     * 
     * @var void
     */
    public function tearDown()
    {
        $this->generator = null;
    }

    /**
     * Testing PersisterGenerator::getTemplateFile
     * 
     * @var void
     */
    public function testGetTemplateFile()
    {
        $templateFile = $this->generator->getTemplateFile();
        $this->assertInstanceOf('SplFileObject', $templateFile);
        $this->assertTrue($templateFile->isFile());
        $this->assertTrue($templateFile->isReadable());
    }

    /**
     * Testing PersisterGenerator::getName
     * 
     * @var void
     */
    public function testGetName()
    {
        $this->assertNotEmpty($this->generator->getName());
    }

    /**
     * Testing PersisterGenerator::getParams
     * 
     * @return void
     */
    public function testGetParams()
    {
        $this->assertTrue(is_array($this->generator->getParams()));
    }
}