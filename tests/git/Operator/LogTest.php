<?php
/**
 * This file is part of SebastianFeldmann\Cli.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Git\Operator;

use SebastianFeldmann\Cli\Command\Result as CommandResult;
use SebastianFeldmann\Cli\Process\Runner\Result as RunnerResult;
use SebastianFeldmann\Git\Command\Log\Commits;
use SebastianFeldmann\Git\Command\Log\Commits\Jsonized;

/**
 * Class LogTest
 *
 * @package SebastianFeldmann\Git
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

        $repo->method('getRoot')->willReturn(realpath(__FILE__ . '/../../..'));
        $runner->method('run')->willReturn($result);

        $log   = new Log($runner, $repo);
        $files = $log->getChangedFilesSince('b1ef1997291');

        $this->assertEquals(1, count($files));
        $this->assertEquals('tests/bootstrap.php', $files[0]);
    }

    /**
     * Tests Log::getChangedFilesSince
     */
    public function testGetCommitsSince()
    {
        $root = realpath(__FILE__ . '/../../..');
        $out  = [
            (object)[
                'hash'        => 'a9d9ac5',
                'name'        => ' (HEAD -> master, origin/master, origin/HEAD)',
                'description' => 'Fix case in path',
                'date'        => '2017-01-16 02:16:13 +0100',
                'author'      => 'Sebastian Feldmann'
            ]
        ];

        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmdRes = new CommandResult('git ...', 0);
        $runRes = new RunnerResult($cmdRes, $out);
        $gitCmd = (new Commits($root))->byRevision('b1ef1997291')->prettyFormat(Commits\Jsonized::FORMAT);

        $repo->method('getRoot')->willReturn($root);
        $runner->expects($this->once())
               ->method('run')
               ->with(
                   $this->equalTo($gitCmd),
                   $this->equalTo(new Jsonized())
               )
               ->willReturn($runRes);

        $log     = new Log($runner, $repo);
        $commits = $log->getCommitsSince('b1ef1997291');

        $this->assertTrue(is_array($commits));
        $this->assertEquals('Sebastian Feldmann', $commits[0]->author);
    }
}
