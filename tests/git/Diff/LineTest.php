<?php
/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Git\Diff;

use PHPUnit\Framework\TestCase;

/**
 * Class LineTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 1.2.0
 */
class LineTest extends TestCase
{
    /**
     * Tests Line::__construct
     */
    public function testNewLine()
    {
        $line = new Line(Line::ADDED, 'foo');

        $this->assertEquals(Line::ADDED, $line->getOperation());
        $this->assertEquals('foo', $line->getContent());
    }

    /**
     * Tests Line::__construct
     *
     * @expectedException \RuntimeException
     */
    public function testInvalidOperation()
    {
        $line = new Line('foo', 'bar');
    }
}
