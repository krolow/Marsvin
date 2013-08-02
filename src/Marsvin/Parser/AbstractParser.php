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

use Marsvin\Parser\Adapter\AdapterInterface;
use Marsvin\AbstractLayer;
use Evenement\EventEmitter;
use Spork\ProcessManager;
use Symfony\Component\Console\Helper\HelperSet;

abstract class AbstractParser extends AbstractLayer
{

    const EVENT_NAME = 'parser.done';

    public function __construct(HelperSet $helperSet, EventEmitter $event, ProcessManager $process, AdapterInterface $adapter)
    {
    	$this->adapter = $adapter;
        parent::__construct($helperSet, $event, $process);
    }

    public function getAdapter()
    {
    	return $this->adapter;
    }

}
