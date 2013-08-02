<?php
/*
 * This file is part of the Marsvin package.
 *
 * (c) Vinícius Krolow <krolow@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Marsvin\Requester;

use Marsvin\ResponseInterface;
use Marsvin\Requester\RequesterInterface;

class Requester extends AbstractRequester implements RequesterInterface
{

    private $handle;

    public function setHandle($handle)
    {
        $this->handle = $handle;
    }

    public function request()
    {
        $this->handle($this, $response);
    }

}
