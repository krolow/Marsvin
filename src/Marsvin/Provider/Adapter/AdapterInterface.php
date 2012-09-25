<?php
namespace Marsvin\Provider\Adapter;

interface AdapterInterface
{

    public function getEvent();

    public function getProcess();

    public function getPersisterAdapter();

    public function getParserAdapter();

    public function getRequesterAdapter();

}
