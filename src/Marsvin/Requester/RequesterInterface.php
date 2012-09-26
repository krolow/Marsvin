<?php
namespace Marsvin\Requester;

interface RequesterInterface
{

	public function getAdapter();

    public function request();

}
