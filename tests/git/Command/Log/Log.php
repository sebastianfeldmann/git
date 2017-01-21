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

class LogTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests CommitsSince::withMerges
     */
    public function testWithMerges()
    {
        $cmd = new CommitsSince();
        $cmd->withMerges();

        $prefix = DIRECTORY_SEPARATOR == '/' ? 'LC_ALL=en_US.UTF-8 ' : '';
        $exe    = $cmd->getCommand();

        $this->assertEquals(
            $prefix . 'git log --pretty=format:\'%h -%d %s (%ci) <%an>\' --abbrev-commit',
            $exe
        );
    }

    /**
     * Tests CommitsSince::revision
     */
    public function testSinceRevision()
    {
        $cmd = new CommitsSince();
        $cmd->revision('1.0.1');

        $exe = $cmd->getCommand();

        $this->assertEquals(
             'git log --pretty=format:\'%h -%d %s (%ci) <%an>\' --abbrev-commit --no-merges \'1.0.1\'..',
            $exe
        );
    }

    /**
     * Tests CommitsSince::revision
     */
    public function testSinceDate()
    {
        $date = date('Y-m-d');
        $cmd  = new CommitsSince();
        $cmd->date($date);

        $prefix = DIRECTORY_SEPARATOR == '/' ? 'LC_ALL=en_US.UTF-8 ' : '';
        $exe    = $cmd->getCommand();

        $this->assertEquals(
            'git log --pretty=format:\'%h -%d %s (%ci) <%an>\''
            . ' --abbrev-commit --no-merges --since='
            . escapeshellarg($date),
            $exe
        );
    }

    /**
     * Tests CommitsSince::prettyFormat
     */
    public function testPrettyFormat()
    {
        $cmd = new CommitsSince();
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
        echo $exe . "\n\n";
    }
}
