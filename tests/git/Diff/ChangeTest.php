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
 * Class ChangeTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 1.2.0
 */
class ChangeTest extends TestCase
{
    /**
     * Tests Change::__construct
     */
    public function testNewChangeOk()
    {
        $change = new Change('-0,5 +0,10', 'foo bar');

        $this->assertEquals(['from' => 0, 'to' => 5], $change->getPre());
        $this->assertEquals(['from' => 0, 'to' => 10], $change->getPost());
        $this->assertEquals('foo bar', $change->getHeader());
    }

    /**
     * Tests Change::addLine
     */
    public function testAddLine()
    {
        $change = new Change('-0,5 +0,10', 'foo bar');
        $change->addLine(new Line(Line::ADDED, 'fiz baz'));

        $this->assertCount(1, $change->getLines());
    }

    /**
     * Tests Change::__construct
     */
    public function testNewChangeFail()
    {
        $this->expectException(\RuntimeException::class);

        $change = new Change('@@ +5 -10 @@', 'foo bar');
    }
}
