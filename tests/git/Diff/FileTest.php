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

    /**
     * Tests File::getAddedContent
     */
    public function testGetAddedContent()
    {
        $changeIndex = '-1,1 +2,2';
        $file        = new File('foo', File::OP_MODIFIED);

        $change1 = new Change($changeIndex, 'bar');
        $change1->addLine(new Line(Line::ADDED, 'fiz'));
        $change1->addLine(new Line(Line::ADDED, 'baz'));
        $file->addChange($change1);

        $change2 = new Change($changeIndex, 'bar');
        $change2->addLine(new Line(Line::ADDED, 'foo'));
        $change2->addLine(new Line(Line::ADDED, 'bar'));
        $file->addChange($change2);

        $content = $file->getAddedContent();

        $this->assertCount(4, $content);
        $this->assertEquals(['fiz', 'baz', 'foo', 'bar'], $content);
    }

    /**
     * Tests File::getAddedContent
     */
    public function testGetAddedContentOfDeletedFile()
    {

        $file    = new File('foo', File::OP_DELETED);
        $content = $file->getAddedContent();

        $this->assertCount(0, $content);
        $this->assertEquals([], $content);
    }
}
