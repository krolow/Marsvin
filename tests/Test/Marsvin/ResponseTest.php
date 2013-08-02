<?php
/*
 * This file is part of the Marsvin package.
 *
 * (c) Vinícius Krolow <krolow@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use Marsvin\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase {
    /**
     * Testing Response
     * 
     * @return void
     */
    public function testSetAndGet()
    {
        $expected = 'test';
        $response = new Response($expected);
        $this->assertEquals($expected, $response->get());
        $expected = array(1, 2, 3);
        $response->set($expected);
        $this->assertEquals($expected, $response->get());
    }
}