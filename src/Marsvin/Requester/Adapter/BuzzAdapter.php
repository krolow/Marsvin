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

use Buzz\Browser;
use Buzz\Client\Curl;
use Marsvin\Requester\Adapter\AdapterInterface;

class BuzzAdapter implements AdapterInterface
{

    public function __construct(Browser $httpClient = null)
    {
        $this->httpClient = $httpClient ?: new Browser(new Curl());
    }

    public function request($url)
    {
        return $this->httpClient->get($url);
    }

}
