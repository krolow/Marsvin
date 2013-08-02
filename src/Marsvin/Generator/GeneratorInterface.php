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

/**
 * Interface to create new Generators
 * 
 * 
 * @author Vinícius Krolow <krolow@gmail.com>
 */
interface GeneratorInterface
{
	/**
	 * Retrive the name of generator
	 * 
	 * @return string
	 */
	public function getName();

	/**
	 * Retrive the skeleton template file
	 * 
	 * @return SplFileObject
	 */
	public function getTemplateFile();

	/**
	 * Retrive aditional params to replace in template
	 * 
	 * @return array
	 */
	public function getParams();
}