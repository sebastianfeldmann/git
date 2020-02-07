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

        $this->assertEquals('git diff \'1.0.0\' \'1.1.0\'', $compare->getCommand());
    }

    /**
     * Tests Compare::statsOnly
     */
    public function testCompareStats()
    {
        $compare = new Compare();
        $compare->revisions('1.0.0', '1.1.0');
        $compare->statsOnly();

        $this->assertEquals('git diff --numstat \'1.0.0\' \'1.1.0\'', $compare->getCommand());
    }

    /**
     * Tests Compare::ignoreWhitespacesAtEndOfLine
     */
    public function testIgnoreWhitespacesAtEndOfLine()
    {
        $compare = new Compare();
        $compare->revisions('1.0.0', '1.1.0');
        $compare->ignoreWhitespacesAtEndOfLine();

        $this->assertEquals('git diff --ignore-space-at-eol \'1.0.0\' \'1.1.0\'', $compare->getCommand());
    }

    /**
     * Tests Compare::ignoreWhitespaces
     */
    public function testIgnoreWhitespaces()
    {
        $compare = new Compare();
        $compare->revisions('1.0.0', '1.1.0');
        $compare->ignoreWhitespaces();

        $this->assertEquals('git diff -w \'1.0.0\' \'1.1.0\'', $compare->getCommand());
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

        $this->assertEquals('git diff -w --ignore-space-at-eol \'1.0.0\' \'1.1.0\'', $compare->getCommand());
    }
}
