<?php
/*
 * This file is part of the Marsvin package.
 *
 * (c) Vinícius Krolow <krolow@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Marsvin\Persister;

use Marsvin\Persister\AbstractPersister;
use Marsvin\Persister\PersisterInterface;
use Marsvin\ResponseInterface;

class Persister extends AbstractPersister implements PersisterInterface
{

    private $handle;

    public function setHandle($handle)
    {
        $this->handle = $handle;
    }

    public function persists(ResponseInterface $response)
    {
        $this->handle($this, $response);
    }

}
