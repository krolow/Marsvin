<?php
/*
 * This file is part of the Marsvin package.
 *
 * (c) Vinícius Krolow <krolow@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Marsvin\Provider;

interface ProviderInterface
{

	public function getRequesterAdapter();

	public function getPersisterAdapter();

	public function getParserAdapter();

    public function import();

}
