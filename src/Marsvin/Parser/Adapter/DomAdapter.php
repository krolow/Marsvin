<?php
/*
 * This file is part of the Marsvin package.
 *
 * (c) Vinícius Krolow <krolow@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Marsvin\Parser\Adapter;

use Marsvin\Parser\Adapter\AdapterInterface;
use DOMDocument;
use InvalidArgumentException;

class DomAdapter implements AdapterInterface
{

    private $dom;

    public function __construct()
    {
        $this->dom = new DomDocument();
    }

    public function parse($content)
    {
        @$this->dom->loadHTML($content);
        return $this->dom;

        if (!$this->fillDOM($content, true)) {
            $this->fillDOM($content, false);
        }
        
        if (!$this->dom->validate()) {
            throw new InvalidArgumentException('The given response is not HTML/XML!');
        }

        return $this->dom;
    }

    private function fillDOM($content, $xml = true)
    {
        $method = 'loadXML';

        if (!$xml) {
            $method = 'loadHTML';
        }

        $this->dom->{$method}($content);

        return $this->dom->validate();
    }

}
