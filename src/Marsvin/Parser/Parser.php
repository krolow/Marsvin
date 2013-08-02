<?php
/*
 * This file is part of the Marsvin package.
 *
 * (c) Vinícius Krolow <krolow@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Marsvin\Parser;

use Marsvin\Parser\AbstractParser;
use Marsvin\Parser\ParserInterface;
use Marsvin\ResponseInterface;

class Parser extends AbstractParser implements ParserInterface
{

    private $handle;

    public function setHandle($handle)
    {
        $this->handle = $handle;
    }

    public function parse(ResponseInterface $response)
    {
        $this->handle($this, $response);
    }

}
