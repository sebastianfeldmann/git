<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Command\Log;

use PHPUnit\Framework\TestCase;
use SebastianFeldmann\Git\Repository;

/**
 * Class LogTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 0.9.0
 */
class LogTest extends TestCase
{
    /**
     * Tests Commits::withMerges
     */
    public function testWithMerges()
    {
        $cmd = new Commits();
        $cmd->withMerges();

        $this->assertEquals(
            'git log --pretty=format:\'%h -%d %s (%ci) <%an>\' --abbrev-commit',
            (string) $cmd
        );
    }

    /**
     * Tests Commits::withMerges
     */
    public function testExitCodes()
    {
        $cmd = new Commits();
        $cmd->withMerges();

        $this->assertEquals([0], $cmd->getAcceptableExitCodes());
    }

    /**
     * Tests Commits::authoredBy
     */
    public function testByAuthor()
    {
        $cmd = new Commits();
        $cmd->authoredBy('Sebastian Feldmann');

        $this->assertEquals(
            'git log'
            . ' --pretty=format:\'%h -%d %s (%ci) <%an>\''
            . ' --abbrev-commit'
            . ' --author=\'Sebastian Feldmann\''
            . ' --no-merges',
            (string) $cmd
        );
    }


    /**
     * Tests Commits::abbrevCommit
     */
    public function testFullCommits()
    {
        $cmd = new Commits();
        $cmd->abbrevCommit(false);

        $this->assertEquals(
            'git log --pretty=format:\'%h -%d %s (%ci) <%an>\' --no-merges',
            (string) $cmd
        );
    }

    /**
     * Tests Commits::byRevision
     */
    public function testSinceRevision()
    {
        $cmd = new Commits();
        $cmd->byRevision('1.0.1');

        $exe = $cmd->getCommand();

        $this->assertEquals(
            'git log --pretty=format:\'%h -%d %s (%ci) <%an>\' --abbrev-commit --no-merges \'1.0.1\'..',
            $exe
        );
    }

    /**
     * Tests Commits::byRevision
     */
    public function testRevisionRange()
    {
        $cmd = new Commits();
        $cmd->byRevision('1.0.1', '1.0.2');

        $exe = $cmd->getCommand();

        $this->assertEquals(
            'git log --pretty=format:\'%h -%d %s (%ci) <%an>\' --abbrev-commit --no-merges \'1.0.1\'..\'1.0.2\'',
            $exe
        );
    }

    /**
     * Tests Commits::byDate
     */
    public function testSinceDate()
    {
        $date = date('Y-m-d');
        $cmd  = new Commits();
        $cmd->byDate($date);

        //$prefix = DIRECTORY_SEPARATOR == '/' ? 'LC_ALL=en_US.UTF-8 ' : '';
        $exe    = $cmd->getCommand();

        $this->assertEquals(
            'git log --pretty=format:\'%h -%d %s (%ci) <%an>\''
            . ' --abbrev-commit --no-merges --after='
            . escapeshellarg($date),
            $exe
        );
    }


    /**
     * Tests Commits::byDate
     */
    public function testDateRange()
    {
        $from = date('Y-m-d', time() - 3600 * 48);
        $to   = date('Y-m-d');
        $cmd  = new Commits();
        $cmd->byDate($from, $to);

        //$prefix = DIRECTORY_SEPARATOR == '/' ? 'LC_ALL=en_US.UTF-8 ' : '';
        $exe    = $cmd->getCommand();

        $this->assertEquals(
            'git log --pretty=format:\'%h -%d %s (%ci) <%an>\''
            . ' --abbrev-commit --no-merges --after='
            . escapeshellarg($from) . ' --before='
            . escapeshellarg($to),
            $exe
        );
    }

    /**
     * Tests Commits::prettyFormat
     */
    public function testPrettyFormat()
    {
        $cmd = new Commits();
        $cmd->prettyFormat('{"hash": "%h", "name": "%d", "description": "%s", "date": "%ci", "author": "%an"}');

        $exe = $cmd->getCommand();

        $this->assertEquals(
            'git'
            . ' log --pretty=format:\''
            . '{"hash": "%h", "name": "%d", "description": "%s", "date": "%ci", "author": "%an"}'
            . '\''
            . ' --abbrev-commit --no-merges',
            $exe
        );
    }
}
