<?php
/*
 * This file is part of the Marsvin package.
 *
 * (c) Vinícius Krolow <krolow@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Marsvin\Persister;

use Marsvin\ResponseInterface;

interface PersisterInterface
{

	public function getAdapter();

    public function persists(ResponseInterface $response);

}
