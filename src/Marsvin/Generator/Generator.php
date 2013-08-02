<?php
/*
 * This file is part of the Marsvin package.
 *
 * (c) Vinícius Krolow <krolow@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Marsvin\Generator;

use RuntimeException;
use SplFileObject;
use InvalidArgumentException;
use Symfony\Component\Filesystem\Filesystem;
use Marsvin\Generator\Exception\FileAlreadyExistInDirectoryException;
use Marsvin\Generator\Exception\TemplateFileDoesNotExistException;
use Marsvin\Generator\Exception\TemplateFileIsNotReadableException;

/**
 * The generator provides an API to create new file structure based on template files.
 * 
 * Basically the Generator will allow users to define his own skeleton of files templates
 * to allow the Generate command create those files automatically in order to setup quickly
 * the Marsvin folder structure
 * 
 * @author Vinícius Krolow <krolow@gmail.com>
 */
class Generator
{
    
    /**
     * The namespace to generate
     * 
     * @var string
     */
    protected $namespace;

    /**
     * The directory where generate
     * 
     * @var string
     */
    protected $directory;

    /**
     * SplFileObject to output
     * 
     * @var SplFileObject
     */
    protected $outputFile;

    /**
     * Filesystem
     * 
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Construct Generator
     * 
     * @param string $namespace The namespace to create the generator
     * @param string $directory The directory where we should create the classes
     * 
     * @api
     */
    public function __construct($namespace, $directory)
    {
        $this->namespace = $namespace;
        $this->directory = $directory;
    }

    /**
     * Define the namespace
     * 
     * @param string $namespace
     * 
     * @return $this
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * Retrive the namespace
     * 
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Define the directory
     * 
     * @param string $directory
     * 
     * @return $this
     */
    public function setDirectory($directory)
    {
        $this->directory = $directory;

        return $this;
    }

    /**
     * Retrive the directory
     * 
     * @return string
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * Define the filesystem to use
     * 
     * @param Filesystem $filesystem
     * 
     * @return $this
     */
    public function setFilesystem(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;

        return $this;
    }

    /**
     * Retrive the filesystem in use OR create one on the fly
     * 
     * @return FileSystem
     */
    public function getFilesystem()
    {
        if (is_null($this->filesystem)) {
            $this->filesystem = new Filesystem();
        }

        return $this->filesystem;
    }

    /**
     * Retrive final directory where files should be created
     * 
     * @return string The final directory path
     */
    public function prepareFinalDirectory()
    {
        $directory = $this->directory
            . DIRECTORY_SEPARATOR
            . implode(DIRECTORY_SEPARATOR, explode('\\', $this->namespace))
            . DIRECTORY_SEPARATOR;

        $patterns = array('/^(\/)?|(\/)+/', '/(\.+\/)/');
        $replacements = array('/', '');
        
        return preg_replace($patterns, $replacements, $directory);
    }

    /**
     * Define the outputFile
     * 
     * 
     * @var SplFileObject $file
     * 
     * @return $this
     */
    public function setOutputFile(SplFileObject $file)
    {
        $this->outputFile = $file;

        return $this;
    }

    /**
     * Retrive the output file
     * 
     * @param string $file when a string is given creates the SplFileObject
     * 
     * @return SplFileObject
     */
    public function getOutputFile($file = null)
    {
        if (is_null($this->outputFile) && !is_null($file)) {
            $this->outputFile = new SplFileObject($file, 'a+');
        }

        return $this->outputFile;
    }

    /**
     * Prepare the className
     * 
     * @param string $generatorName Given generator name
     * 
     * @throws InvalidArgumentException when the generator name is emtpy
     * 
     * @return string ClassName based on namespace and generatorName
     */
    public function prepareClassName($generatorName)
    {
        if (empty($generatorName)) {
            throw new InvalidArgumentException('Generator Name can not be empty');
        }

        return end(explode('\\', $this->namespace)) . $generatorName;
    }

    /**
     * Generaters placeholders for the given parameters
     * 
     * @param array $params a List of 
     * 
     * @throws InvalidArgumentException When one of the values in params it's not a string!
     * 
     * @return array
     */
    public function preparePlaceholders($params)
    {
        $placeholders = array();

        $canWePrint = function ($value) {
            return is_scalar($value) || (is_object($value) && is_callable(array($value, '__toString')));
        };

        foreach ($params as $key => $value) {
            if (!$canWePrint($value)) {
                throw new InvalidArgumentException(
                    'All array entries key + value must be a string or have __toString method'
                );
            }

            array_push(
                $placeholders,
                '{{ ' . $key . ' }}'
            );
        }

        return $placeholders;
    }

    /**
     * Output a file based on the given generator
     * 
     * @param GeneratorInterface $generator The generator schema
     * 
     * @return SplFileObject 
     * @api
     */
    public function generate(GeneratorInterface $generator)
    {
        $className = $this->prepareClassName($generator->getName());

        $defaultParams = array(
            'className' => $className,
            'namespace' => $this->namespace
        );
        $params = $generator->getParams() + $defaultParams;
        $content = $this->prepareContent($generator->getTemplateFile(), $params);

        return $this->writeFile($className . '.php', $content);
    }

    /**
     * Prepare content to post write generator
     * 
     * @param SplFileObject $templateFile The full path for the template file
     * @param array $params that we gonna use as placeholder
     * 
     * @throws TemplateFileDoesNotExistException When we could not find the template file
     * @throws TemplateFileIsNotReadableException When we are not able to read the file
     * 
     * @return string The content prepared
     */
    public function prepareContent(SplFileObject $templateFile, $params)
    {
        if (!$templateFile->isFile()) {
            throw new TemplateFileDoesNotExistException(
                sprintf('We could not find the template file: %s', $templateFile)
            );
        }
        if (!$templateFile->isReadable()) {
            throw new TemplateFileIsNotReadableException(
                sprintf('The template file is not readable file: %s', $templateFile)
            );
        }

        $placeholders = $this->preparePlaceholders($params);
        ob_start();
        $templateFile->fpassthru();
        $content = ob_get_clean();
        $content = str_replace($placeholders, array_values($params), $content);

        return $content;
    }

    /**
     * Create the given filename with the given content at final directory target
     * 
     * - When the final directory does not exists, code try create the folder
     * 
     * @throws FileAlreadyExistInDirectoryException When the file already exists in the directory
     * @throws RuntimeException When we could not write the file
     * 
     * @return SplFileObject Return the output file
     */
    public function writeFile($filename, $content)
    {
        $filesystem = $this->getFilesystem();
        $finalDirectory = $this->prepareFinalDirectory();

        if (!$filesystem->exists($finalDirectory)) {
            $filesystem->mkdir($finalDirectory, 0755);
        }

        $outputFile = $this->getOutputFile($finalDirectory . $filename);

        if ($outputFile->isFile()) {
            throw new FileAlreadyExistInDirectoryException(
                sprintf('The file %s already exists, so we are not touch in him!', $outputFile)
            );
        }

        if (!$outputFile->fwrite($content)) {
            throw new RuntimeException('Something happend and we were not able to write the file');
        }

        return $outputFile;
    }

}