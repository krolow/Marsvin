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

use Marsvin\Generator\ParserGenerator;

/**
 * ParserGenerator Unit Test
 * 
 * 
 * @author Vinícius Krolow <krolow@gmail.com>
 */
class ParserGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * ParserGenerator
     * 
     * @var ParserGenerator
     */
    private $generator;

    /**
     * SetUp
     * 
     * @var void
     */
    public function setUp()
    {
        $this->generator = new ParserGenerator();
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
     * Testing ParserGenerator::getTemplateFile
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
     * Testing ParserGenerator::getName
     * 
     * @var void
     */
    public function testGetName()
    {
        $this->assertNotEmpty($this->generator->getName());
    }

    /**
     * Testing ParserGenerator::getParams
     * 
     * @return void
     */
    public function testGetParams()
    {
        $this->assertTrue(is_array($this->generator->getParams()));
    }
}