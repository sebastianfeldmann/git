<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Command\Diff;

use PHPUnit\Framework\TestCase;

/**
 * Class CompareTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 1.2.0
 */
class CompareTest extends TestCase
{
    /**
     * Tests Compare::revision
     */
    public function testCompareRevisions()
    {
        $compare = new Compare();
        $compare->revisions('1.0.0', '1.1.0');

        $this->assertEquals(
            'git diff --no-ext-diff --diff-algorithm=myers \'1.0.0\' \'1.1.0\' -- ',
            $compare->getCommand()
        );
    }

    /**
     * Tests Compare::statsOnly
     */
    public function testCompareStats()
    {
        $compare = new Compare();
        $compare->revisions('1.0.0', '1.1.0');
        $compare->statsOnly();

        $this->assertEquals(
            'git diff --no-ext-diff --diff-algorithm=myers --numstat \'1.0.0\' \'1.1.0\' -- ',
            $compare->getCommand()
        );
    }

    /**
     * Tests Compare::ignoreWhitespacesAtEndOfLine
     */
    public function testIgnoreWhitespacesAtEndOfLine()
    {
        $compare = new Compare();
        $compare->revisions('1.0.0', '1.1.0');
        $compare->ignoreWhitespacesAtEndOfLine();

        $this->assertEquals(
            'git diff --no-ext-diff --diff-algorithm=myers --ignore-space-at-eol \'1.0.0\' \'1.1.0\' -- ',
            $compare->getCommand()
        );
    }

    /**
     * Tests Compare::indexTo
     */
    public function testIndexTo()
    {
        $compare = new Compare();
        $compare->indexTo();

        $this->assertEquals(
            'git diff --no-ext-diff --diff-algorithm=myers --staged \'HEAD\' -- ',
            $compare->getCommand()
        );
    }

    /**
     * Tests Compare::withContextLines
     */
    public function testContextLines()
    {
        $compare = new Compare();
        $compare->indexTo()->withContextLines(2);


        $this->assertEquals(
            'git diff --no-ext-diff --diff-algorithm=myers --unified=2 --staged \'HEAD\' -- ',
            $compare->getCommand()
        );
    }

    /**
     * Tests Compare::ignoreWhitespaces
     */
    public function testIgnoreWhitespaces()
    {
        $compare = new Compare();
        $compare->revisions('1.0.0', '1.1.0');
        $compare->ignoreWhitespaces();

        $this->assertEquals(
            'git diff --no-ext-diff --diff-algorithm=myers -w \'1.0.0\' \'1.1.0\' -- ',
            $compare->getCommand()
        );
    }

    /**
     * Tests Compare::ignoreWhitespaces
     */
    public function testIgnoreWhitespacesAndEOL()
    {
        $compare = new Compare();
        $compare->revisions('1.0.0', '1.1.0')
                ->ignoreWhitespacesAtEndOfLine()
                ->ignoreWhitespaces();

        $this->assertEquals(
            'git diff --no-ext-diff --diff-algorithm=myers -w --ignore-space-at-eol \'1.0.0\' \'1.1.0\' -- ',
            $compare->getCommand()
        );
    }

    public function testIgnoreSubmodules(): void
    {
        $compare = new Compare();
        $compare->ignoreSubmodules();

        $this->assertEquals(
            'git diff --no-ext-diff --diff-algorithm=myers --ignore-submodules  -- ',
            $compare->getCommand()
        );
    }

    public function testStaged(): void
    {
        $compare = new Compare();
        $compare->staged();

        $this->assertEquals(
            'git diff --no-ext-diff --diff-algorithm=myers --staged  -- ',
            $compare->getCommand()
        );
    }

    public function testToWithDefaultParam(): void
    {
        $compare = new Compare();
        $compare->to();

        $this->assertEquals(
            'git diff --no-ext-diff --diff-algorithm=myers \'HEAD\' -- ',
            $compare->getCommand()
        );
    }

    public function testToWithPassedParam(): void
    {
        $compare = new Compare();
        $compare->to('foobar');

        $this->assertEquals(
            'git diff --no-ext-diff --diff-algorithm=myers \'foobar\' -- ',
            $compare->getCommand()
        );
    }
}
