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

use Marsvin\Generator\RequesterGenerator;

/**
 * RequesterGenerator Unit Test
 * 
 * 
 * @author Vinícius Krolow <krolow@gmail.com>
 */
class RequesterGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * RequesterGenerator
     * 
     * @var RequesterGenerator
     */
    private $generator;

    /**
     * SetUp
     * 
     * @var void
     */
    public function setUp()
    {
        $this->generator = new RequesterGenerator();
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
     * Testing RequesterGenerator::getTemplateFile
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
     * Testing RequesterGenerator::getName
     * 
     * @var void
     */
    public function testGetName()
    {
        $this->assertNotEmpty($this->generator->getName());
    }

    /**
     * Testing RequesterGenerator::getParams
     * 
     * @return void
     */
    public function testGetParams()
    {
        $this->assertTrue(is_array($this->generator->getParams()));
    }
}