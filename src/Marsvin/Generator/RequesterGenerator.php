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

use SplFileObject;
use Marsvin\Generator\GeneratorInterface;

/**
 * Define basic info to generate one RequesterClass based on the Requester Skeleton
 * 
 * 
 * @author Vinícius Krolow <krolow@gmail.com>
 */
class RequesterGenerator implements GeneratorInterface
{
    /**
     * Template file to generate
     * 
     * @return SplFileObject Template File
     */
    public function getTemplateFile()
    {
        return new SplFileObject(
            __DIR__
            . DIRECTORY_SEPARATOR 
            . 'Skeleton' 
            . DIRECTORY_SEPARATOR 
            . 'Requester.php.tpl'
        );
    }
    
    /**
     * Retrive the generator name
     * 
     * @return string Generator name
     */
    public function getName()
    {
        return 'Requester';
    }

    /**
     * Additional params to parse
     * 
     * @return array List of aditional params to replace
     */
    public function getParams()
    {
        return array();
    }
}