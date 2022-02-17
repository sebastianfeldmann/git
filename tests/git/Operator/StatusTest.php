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
use SebastianFeldmann\Git\Command\Checkout\RestoreWorkingTree;
use SebastianFeldmann\Git\Command\Status\Porcelain\PathList;
use SebastianFeldmann\Git\Command\Status\WorkingTreeStatus;
use SebastianFeldmann\Git\Status\Path;

/**
 * Class StatusTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release ?.?.?
 */
class StatusTest extends OperatorTest
{
    public function testGetWorkingTreeStatus(): void
    {
        $root = (string) realpath(__FILE__ . '/../../..');
        $out = [
            new Path('M ', 'file1.ext'),
            new Path('A ', 'file2.ext'),
        ];

        $repo = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmdRes = new CommandResult('git ...', 0);
        $runRes = new RunnerResult($cmdRes, $out);
        $gitCmd = (new WorkingTreeStatus($root))->ignoreSubmodules();

        $repo->method('getRoot')->willReturn($root);
        $runner->expects($this->once())
            ->method('run')
            ->with(
                $this->equalTo($gitCmd),
                $this->equalTo(new PathList())
            )
            ->willReturn($runRes);

        $status = new Status($runner, $repo);
        $paths = $status->getWorkingTreeStatus();

        $this->assertIsArray($paths);
        $this->assertCount(2, $paths);
        $this->assertContainsOnlyInstancesOf(Path::class, $paths);
    }

    public function testRestoreWorkingTreeWithDefaultPathsParameter(): void
    {
        $root = (string) realpath(__FILE__ . '/../../..');

        $repo = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmdRes = new CommandResult('git ...', 0);
        $runRes = new RunnerResult($cmdRes, ['foobar']);
        $gitCmd = new RestoreWorkingTree($root);
        $gitCmd->skipHooks();

        $repo->method('getRoot')->willReturn($root);
        $runner->expects($this->once())
            ->method('run')
            ->with($this->equalTo($gitCmd))
            ->willReturn($runRes);

        $status = new Status($runner, $repo);

        $this->assertTrue($status->restoreWorkingTree());
    }

    public function testRestoreWorkingTreeWithPassedPathsAndErrorResponse(): void
    {
        $root = (string) realpath(__FILE__ . '/../../..');

        $repo = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmdRes = new CommandResult('git ...', 1);
        $runRes = new RunnerResult($cmdRes, ['foobar']);
        $gitCmd = (new RestoreWorkingTree($root))->skipHooks()->files(['foo', 'bar']);

        $repo->method('getRoot')->willReturn($root);
        $runner->expects($this->once())
            ->method('run')
            ->with($this->equalTo($gitCmd))
            ->willReturn($runRes);

        $status = new Status($runner, $repo);

        $this->assertFalse($status->restoreWorkingTree(['foo', 'bar']));
    }
}
