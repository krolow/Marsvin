<?php
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
