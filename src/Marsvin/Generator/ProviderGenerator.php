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
 * Define basic info to generate one ProviderClass based on the Provider Skeleton
 * 
 * 
 * @author Vinícius Krolow <krolow@gmail.com>
 */
class ProviderGenerator implements GeneratorInterface
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
            . 'Provider.php.tpl'
        );
    }
    
    /**
     * Retrive the generator name
     * 
     * @return string Generator name
     */
    public function getName()
    {
        return 'Provider';
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