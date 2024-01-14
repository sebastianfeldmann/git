<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Operator;

use SebastianFeldmann\Cli\Command\Result as CommandResult;
use SebastianFeldmann\Cli\Command\Runner\Result as RunnerResult;
use SebastianFeldmann\Git\Command\Log\Commits;

/**
 * Class LogTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 0.9.0
 */
class LogTest extends OperatorTest
{
    /**
     * Tests Log::getChangedFilesSince
     */
    public function testGetChangedFilesSince()
    {
        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmd    = new CommandResult('git ...', 0, 'tests/bootstrap.php');
        $result = new RunnerResult($cmd);

        $repo->method('getRoot')->willReturn((string) realpath(__FILE__ . '/../../..'));
        $runner->method('run')->willReturn($result);

        $log   = new Log($runner, $repo);
        $files = $log->getChangedFilesSince('b1ef1997291');

        $this->assertCount(1, $files);
        $this->assertEquals('tests/bootstrap.php', $files[0]);
    }

    /**
     * Tests Log::getChangedFilesInRevision
     */
    public function testGetChangedFilesInRevision()
    {
        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmd    = new CommandResult('git ...', 0, 'tests/bootstrap.php');
        $result = new RunnerResult($cmd);

        $repo->method('getRoot')->willReturn((string) realpath(__FILE__ . '/../../..'));
        $runner->method('run')->willReturn($result);

        $log   = new Log($runner, $repo);
        $files = $log->getChangedFilesInRevisions(['b1ef1997291']);

        $this->assertCount(1, $files);
        $this->assertEquals('tests/bootstrap.php', $files[0]);
    }

    /**
     * Tests Log::getRefLogBranchRevs
     */
    public function testRefLogFeatureBranchRevs()
    {
        $reflogOutput = "98b4c42<--<|>-->commit: Finish baz\n"
                      . "b78325f<--<|>-->commit: Improve baz\n"
                      . "ae8fa00<--<|>-->commit: Add baz\n"
                      . "b89f2f2<--<|>-->branch: Created from HEAD\n";

        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmd    = new CommandResult('git ...', 0, $reflogOutput);
        $result = new RunnerResult($cmd);

        $repo->method('getRoot')->willReturn((string) realpath(__FILE__ . '/../../..'));
        $runner->method('run')->willReturn($result);

        $log   = new Log($runner, $repo);
        $revs = $log->getRefLogBranchRevs('demo');

        $this->assertCount(3, $revs);
        $this->assertEquals('98b4c42', $revs[0]);
        $this->assertEquals('ae8fa00', $revs[2]);
    }

    /**
     * Tests Log::getRefLogBranchRevs
     */
    public function testRefLogInitialBranchRevs()
    {
        $reflogOutput = "7279a97<--<|>-->commit: Add fiz\n"
                      . "b89f2f2<--<|>-->commit: Add bar\n"
                      . "b4e8b0b<--<|>-->commit (initial): Add foo\n";

        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmd    = new CommandResult('git ...', 0, $reflogOutput);
        $result = new RunnerResult($cmd);

        $repo->method('getRoot')->willReturn((string) realpath(__FILE__ . '/../../..'));
        $runner->method('run')->willReturn($result);

        $log   = new Log($runner, $repo);
        $revs = $log->getRefLogBranchRevs('demo');

        $this->assertCount(3, $revs);
        $this->assertEquals('7279a97', $revs[0]);
        $this->assertEquals('b4e8b0b', $revs[2]);
    }

    /**
     * Tests Log::getCommitsBetween
     */
    public function testGetCommitsSince()
    {
        $root = (string) realpath(__FILE__ . '/../../..');
        $out  = '<commit>
<hash>11cd79f</hash>
<names><![CDATA[ (HEAD -> master, tag: 1.1.4, origin/master)]]></names>
<date>2020-01-17 22:10:30 +0100</date>
<author><![CDATA[Sebastian Feldmann]]></author>
<subject><![CDATA[Major fixup]]></subject>
<body><![CDATA[
]]></body>
</commit>';

        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmdRes = new CommandResult('git ... just fake', 0, $out);
        $runRes = new RunnerResult($cmdRes);
        $gitCmd = (new Commits($root))->byRange('b1ef1997291')->prettyFormat(Commits\XML::FORMAT);

        $repo->method('getRoot')->willReturn($root);
        $runner->expects($this->once())
               ->method('run')
               ->with($this->equalTo($gitCmd))
               ->willReturn($runRes);

        $log     = new Log($runner, $repo);
        $commits = $log->getCommitsSince('b1ef1997291');

        $this->assertIsArray($commits);
        $this->assertEquals('Sebastian Feldmann', $commits[0]->getAuthor());
    }

    /**
     * Tests Log::getCommitsBetween
     */
    public function testGetCommitsBetween()
    {
        $root = (string) realpath(__FILE__ . '/../../..');
        $out  = '<commit>
<hash>11cd79f</hash>
<names><![CDATA[ (HEAD -> master, tag: 1.1.4, origin/master)]]></names>
<date>2020-01-17 22:10:30 +0100</date>
<author><![CDATA[Sebastian Feldmann]]></author>
<subject><![CDATA[Major fixup]]></subject>
<body><![CDATA[
]]></body>
</commit>';

        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmdRes = new CommandResult('git ...', 0, $out);
        $runRes = new RunnerResult($cmdRes);
        $gitCmd = (new Commits($root))->byRange('b1ef1997291', 'a1ef1577fe1')->prettyFormat(Commits\Xml::FORMAT);

        $repo->method('getRoot')->willReturn($root);
        $runner->expects($this->once())
               ->method('run')
               ->with($this->equalTo($gitCmd))
               ->willReturn($runRes);

        $log     = new Log($runner, $repo);
        $commits = $log->getCommitsBetween('b1ef1997291', 'a1ef1577fe1');

        $this->assertIsArray($commits);
        $this->assertEquals('Sebastian Feldmann', $commits[0]->getAuthor());
    }
}
