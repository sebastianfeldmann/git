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
use SebastianFeldmann\Git\Command\Log\Commits\Jsonized;
use SebastianFeldmann\Git\Log\Commit;

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

        $repo->method('getRoot')->willReturn(realpath(__FILE__ . '/../../..'));
        $runner->method('run')->willReturn($result);

        $log   = new Log($runner, $repo);
        $files = $log->getChangedFilesSince('b1ef1997291');

        $this->assertEquals(1, count($files));
        $this->assertEquals('tests/bootstrap.php', $files[0]);
    }

    /**
     * Tests Log::getCommitsBetween
     */
    public function testGetCommitsSince()
    {
        $root = realpath(__FILE__ . '/../../..');
        $out  = [
            new Commit(
                'a9d9ac5',
                ['HEAD -> master', 'origin/master', 'origin/HEAD'],
                'Fix case in path',
                new \DateTimeImmutable('2017-01-16 02:16:13 +0100'),
                'Sebastian Feldmann'
            )
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
        $this->assertEquals('Sebastian Feldmann', $commits[0]->getAuthor());
    }

    /**
     * Tests Log::getCommitsBetween
     */
    public function testGetCommitsBetween()
    {
        $root = realpath(__FILE__ . '/../../..');
        $out  = [
            new Commit(
                'a9d9ac5',
                ['HEAD -> master', 'origin/master', 'origin/HEAD'],
                'Fix case in path',
                new \DateTimeImmutable('2017-01-16 02:16:13 +0100'),
                'Sebastian Feldmann'
            )
        ];

        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmdRes = new CommandResult('git ...', 0);
        $runRes = new RunnerResult($cmdRes, $out);
        $gitCmd = (new Commits($root))->byRevision('b1ef1997291', 'a1ef1577fe1')->prettyFormat(Commits\Jsonized::FORMAT);

        $repo->method('getRoot')->willReturn($root);
        $runner->expects($this->once())
               ->method('run')
               ->with(
                  $this->equalTo($gitCmd),
                  $this->equalTo(new Jsonized())
               )
               ->willReturn($runRes);

        $log     = new Log($runner, $repo);
        $commits = $log->getCommitsBetween('b1ef1997291', 'a1ef1577fe1');

        $this->assertTrue(is_array($commits));
        $this->assertEquals('Sebastian Feldmann', $commits[0]->getAuthor());
    }
}
