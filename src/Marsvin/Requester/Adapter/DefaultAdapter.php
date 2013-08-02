<?php
/*
 * This file is part of the Marsvin package.
 *
 * (c) Vinícius Krolow <krolow@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Marsvin\Requester\Adapter;

class DefaultAdapter implements AdapterInterface
{

    private $url;

    public function request($url)
    {
        $this->url = $url;
    }

    public function getUrl()
    {
        return $this->url;
    }

}
