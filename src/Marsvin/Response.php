<?php
/*
 * This file is part of the Marsvin package.
 *
 * (c) Vinícius Krolow <krolow@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Marsvin;

use Marsvin\ResponseInterface;

class Response implements ResponseInterface
{

    private $response;

    public function __construct($response)
    {
        $this->set($response);
    }

    public function set($response)
    {
        $this->response = $response;
    }

    public function get()
    {
        return $this->response;
    }

}
