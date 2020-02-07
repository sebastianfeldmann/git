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
 * Class FileTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 1.1.1
 */
class FileTest extends TestCase
{
    /**
     * Tests File::getName
     */
    public function testGetName()
    {
        $file = new File('foo', File::OP_MODIFIED);

        $this->assertEquals('foo', $file->getName());
    }

    /**
     * Tests File::getOperation
     */
    public function testGetOperation()
    {
        $file = new File('foo', File::OP_MODIFIED);

        $this->assertEquals(File::OP_MODIFIED, $file->getOperation());
    }

    /**
     * Tests File::getChanges
     */
    public function testChangesEmptyOnInit()
    {
        $file = new File('foo', File::OP_MODIFIED);

        $this->assertEquals([], $file->getChanges());
    }

    /**
     * Tests File::addChange
     */
    public function testAddChangeWithoutChangedLines()
    {
        $file = new File('foo', File::OP_MODIFIED);
        $file->addChange(new Change('-1,1 +2,2', 'foo'));

        $changes = $file->getChanges();
        $change  = $changes[0];

        $this->assertCount(1, $changes);
        $this->assertEquals('foo', $change->getHeader());
    }

    /**
     * Tests File::addChangedLine
     */
    public function testAddChangeWithChangedLines()
    {
        $changeIndex = '-1,1 +2,2';
        $file        = new File('foo', File::OP_MODIFIED);
        $change      = new Change($changeIndex, 'bar');
        $change->addLine(new Line(Line::ADDED, 'baz'));
        $file->addChange($change);

        $changes = $file->getChanges();
        $change  = $changes[0];

        $this->assertCount(1, $changes);
        $this->assertEquals('bar', $change->getHeader());
        $this->assertCount(1, $change->getLines());
        $this->assertEquals(Line::ADDED, $change->getLines()[0]->getOperation());
        $this->assertEquals('baz', $change->getLines()[0]->getContent());
    }
}
