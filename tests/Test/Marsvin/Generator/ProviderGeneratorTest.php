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

use Marsvin\Generator\ProviderGenerator;

/**
 * ProviderGenerator Unit Test
 * 
 * 
 * @author Vinícius Krolow <krolow@gmail.com>
 */
class ProviderGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * ProviderGenerator
     * 
     * @var ProviderGenerator
     */
    private $generator;

    /**
     * SetUp
     * 
     * @var void
     */
    public function setUp()
    {
        $this->generator = new ProviderGenerator();
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
     * Testing ProviderGenerator::getTemplateFile
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
     * Testing ProviderGenerator::getName
     * 
     * @var void
     */
    public function testGetName()
    {
        $this->assertNotEmpty($this->generator->getName());
    }

    /**
     * Testing ProviderGenerator::getParams
     * 
     * @return void
     */
    public function testGetParams()
    {
        $this->assertTrue(is_array($this->generator->getParams()));
    }
}