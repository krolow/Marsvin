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

use Marsvin\Generator\Generator;
use Marsvin\Generator\Exception\FileAlreadyExistInDirectoryException;
use Marsvin\Generator\Exception\TemplateFileIsNotReadableException;
use Marsvin\Generator\Exception\TemplateFileDoesNotExistException;
use SplFileObject;
use RunTimeException;
use InvalidArgumentException;

class FakeToString
{
    public function __toString()
    {
        return 'yeah!';
    }
}

class FakeSplFileObject extends SplFileObject
{

    public function __construct()
    {
        parent::__construct('php://memory');
    }

    public function setIsFile($isFile)
    {
        $this->isFile = $isFile;

        return $this;
    }

    public function isFile()
    {
        return $this->isFile;
    }

    public function setIsReadable($isReadable)
    {
        $this->isReadable = $isReadable;

        return $this;
    }

    public function isReadable()
    {
        return $this->isReadable;
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function fwrite($content, $length = null)
    {
        if ($content == false) {
            return false;
        }

        $this->setContent($content);

        return true;
    }

    public function fpassthru()
    {
        echo $this->content;
    }

}
/**
 * GeneratorTest Unit Test
 * 
 * 
 * @author Vinícius Krolow <krolow@gmail.com>
 */
class GeneratorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Generator object to test
     * 
     * @var Generator
     */
    private $generator;

    /**
     * Setup
     * 
     * @var void
     */
    public function setUp()
    {
        $this->generator = new Generator('Marsvin\\Testing', '/home/marsvin');
    }

    /**
     * tearDown
     * 
     * @var void
     */
    public function tearDown()
    {
        $this->generator = null;
    }

    /**
     * Test get and setters and some creations
     * 
     * @var void
     */
    public function testGetThatCreateInstances()
    {
        $this->assertInstanceOf(
            'Symfony\Component\Filesystem\Filesystem',
            $this->generator->getFilesystem()
        );
        $this->assertInstanceOf(
            'SplFileObject',
            $this->generator->getOutputFile(__FILE__)
        );
        $this->assertEquals('Marsvin\\Testing', $this->generator->getNamespace());
        $this->assertEquals('/home/marsvin', $this->generator->getDirectory());
    }

    /**
     * Test the Gerator::prepareFinalDirectory
     * 
     * @var void
     */
    public function testPrepareFinalDirectory()
    {
        $result = $this->generator->prepareFinalDirectory();
        $expected = '/home/marsvin/Marsvin/Testing/';
        $this->assertEquals($expected, $result);

        $result = $this->generator->setNamespace('\\A\\Crazy\\Namespace\\Let\\See')
            ->setDirectory('/the/path/')
            ->prepareFinalDirectory();
        $expected = '/the/path/A/Crazy/Namespace/Let/See/';
        $this->assertEquals($expected, $result);

        $result = $this->generator->setNamespace('TheNameSpace')
            ->setDirectory('/the/path//')
            ->prepareFinalDirectory();
        $expected = '/the/path/TheNameSpace/';
        $this->assertEquals($expected, $result);
    }

    /**
     * Test the Gerator::prepareClass
     * 
     * @var void
     */
    public function testPrepareClassName()
    {
        $result = $this->generator->prepareClassName('Provider');
        $expected = 'TestingProvider';
        $this->assertEquals($expected, $result);
        $result = $this->generator
            ->setNamespace('Xavante\\Vinicius')
            ->prepareClassName('Krolow');
        $expected = 'ViniciusKrolow';
        $this->assertEquals($expected, $result);

        $excetion = false;
        try {
            $result = $this->generator
                ->setNamespace('what-will-happens')
                ->prepareClassName('');
        } catch (InvalidArgumentException $e) {
            $exception = true;
        }

        if (!$exception) {
            $this->fail('Should raise InvalidArgumentException');
        }
    }

    /**
     * Generator::preparePlaceholders
     * 
     * @var void
     */
    public function testPreparePlaceholders()
    {
        $result = $this->generator->preparePlaceholders(array('name' => 'test', 'class' => 'working'));
        $expected = array('{{ name }}', '{{ class }}');
        $this->assertEquals($result, $expected);

        $result = $this->generator->preparePlaceholders(array('name' => 'test', 'class' => new FakeToString));
        $expected = array('{{ name }}', '{{ class }}');
        $this->assertEquals($result, $expected);

        $exception = false;
        try {
            $this->generator->preparePlaceholders(array('test' => new \stdClass));
        } catch (InvalidArgumentException $e) {
            $exception = true;
        }

        if (!$exception) {
            $this->fail('Should raise InvalidArgumentException');
        }
    }

    /**
     * Generator::prepareContent
     * 
     * @var void
     */
    public function testPrepareContent()
    {
        $file = $this->createSplFileMock(true, true, '{{ className }}{{ namespace }}');
        $result = $this->generator->prepareContent($file, array('className' => 'test', 'namespace' => 'name'));
        $expected = 'testname';
        $this->assertEquals($expected, $result);

        $file = $this->createSplFileMock(false, true, '{{ className }}{{ namespace }}');
        $expected = false;
        try {
            $this->generator->prepareContent($file, array());
        } catch (TemplateFileDoesNotExistException $e) {
            $exception = true;
        }

        if (!$exception) {
            $this->fail('Should raise TemplateFileDoesNotExistException');
        }

        $file = $this->createSplFileMock(true, false, '{{ className }}{{ namespace }}');
        $expected = false;
        try {
            $this->generator->prepareContent($file, array());
        } catch (TemplateFileIsNotReadableException $e) {
            $exception = true;
        }

        if (!$exception) {
            $this->fail('Should raise TemplateFileIsNotReadableException');
        }
    }

    /**
     * Generator::writeFile
     * 
     * @var void
     */
    public function testWriteFile()
    {
        $this->generator->setFilesystem($this->createFilesystemMock())
            ->setOutputFile($this->createSplFileMock(false, false));
        $file = $this->generator->writeFile(
            'testing.txt',
            'testing'
        );
        $this->assertEquals('testing', $this->getFileOutput($file));

        $exception = false;
        $this->generator->setOutputFile($this->createSplFileMock(true, true));
        try {
            $this->generator->writeFile('test', 'testing');
        } catch (FileAlreadyExistInDirectoryException $e) {
            $exception = true;
        }

        if (!$exception) {
            $this->fail('Should raise FileAlreadyExistInDirectoryException');
        }

        $exception = false;
        $this->generator->setOutputFile($this->createSplFileMock(false, false));
        try {
            $this->generator->writeFile('test', false);
        } catch (RunTimeException $e) {
            $exception = true;
        }

        if (!$exception) {
            $this->fail('Should raise RunTimeException');
        }        
    }

    /**
     * Generator::generate
     * 
     * @var void
     */
    public function testGenerate()
    {
        $file = $this->generator
            ->setOutputFile($this->createSplFileMock(false, false))
            ->setFilesystem($this->createFilesystemMock())
            ->generate(
                $this->createGeneratorMock(
                    'Provider',
                    $this->createSplFileMock(
                        true,
                        true,
                        '{{ namespace }} {{ className }} {{ customParam }}'
                    ),
                    array(
                        'customParam' => 'Works'
                    )
                )
            );
        $result = $this->getFileOutput($file);
        $expected = 'Marsvin\Testing TestingProvider Works';
        $this->assertEquals($expected, $result);

        $file = $this->generator->setNamespace('Cobaia\\Krolow')
            ->generate(
                $this->createGeneratorMock(
                    'Parser',
                    $this->createSplFileMock(
                        true,
                        true,
                        '{{ namespace }} {{ className }}'
                    ),
                    array()
                )
            );
        $result = $this->getFileOutput($file);
        $expected = 'Cobaia\Krolow KrolowParser';
        $this->assertEquals($expected, $result);
    }

    /**
     * Retrive the output by simulate the behaves.
     * 
     * @var string
     */
    protected function getFileOutput(SplFileObject $file)
    {
        ob_start();
        $file->fpassthru();
        return ob_get_clean();
    }

    /**
     * Retrive a GeneratorInterface mock
     * 
     * @var string $name The generator name
     * @var SplFileObject $template The template file
     * @var array $params The params to parse
     * 
     * @return GeneratorInterface
     */
    protected function createGeneratorMock($name, SplFileObject $template, $params)
    {
        $generator = $this->getMock('Marsvin\Generator\GeneratorInterface');
        $generator->expects($this->any())
            ->method('getName')
            ->will($this->returnValue($name));
        $generator->expects($this->any())
            ->method('getTemplateFile')
            ->will($this->returnValue($template));
        $generator->expects($this->any())
            ->method('getParams')
            ->will($this->returnValue($params));

        return $generator;
    }

    /**
     * Retrive a SplFileObject Fake/Mock
     * 
     * @todo find a way to mock this object by phpunit
     * 
     * @var bool $isFile Should isFile return what?
     * @var bool $isReadable Should isReadable return what?
     * @var string|bool $content Should fpassthru/fwrite return what?
     * 
     * @return SplFileObjecy
     */
    protected function createSplFileMock($isFile = false, $isReadable = false, $content = '')
    {
        $file = new FakeSplFileObject;

        return $file->setIsFile($isFile)
            ->setIsReadable($isReadable)
            ->setContent($content);
    }

    /**
     * Retrive a Filesystem Mock
     * 
     * @var bool $mkdir Should return what?
     * @var bool $exists Should return what?
     * 
     * @return Filesystem
     */
    protected function createFilesystemMock($mkdir = true, $exists = false)
    {
        $filesystem = $this->getMock('Symfony\Component\Filesystem\Filesystem');
        $filesystem->expects($this->any())
            ->method('mkdir')
            ->will($this->returnValue($mkdir));
        $filesystem->expects($this->any())
            ->method('exists')
            ->will($this->returnValue($exists));

        return $filesystem;
    }
}