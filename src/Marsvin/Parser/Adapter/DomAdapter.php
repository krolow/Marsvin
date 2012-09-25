<?php
namespace Marsvin\Parser\Adapter;

use Marsvin\Parser\Adapter\AdapterInterface;
use Marsvin\ResponseInterface;
use DOMDocument;

class DomAdapter implements AdapterInterface
{

    private $dom;

    public function __construct()
    {
        $this->dom = new DomDocument('1.0', 'UTF-8');
    }

    public function parse(ResponseInterface $response)
    {
        if (!$this->fillDOM($result, true)) {
            $this->fillDOM($result, false);
        }
        
        if (!$this->dom->validate()) {
            throw \InvalidArgument('The given response is not HTML/XML!');
        }
    }

    private function fillDOM(ResponseInterface $response, $xml = true)
    {
        $method = 'loadXML';

        if (!$xml) {
            $method = 'loadHTML';
        }

        $this->dom->{$method}($result->get());

        return $this->dom->validate();
    }


}
