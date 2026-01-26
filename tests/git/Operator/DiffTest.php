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
use SebastianFeldmann\Git\Command\Apply\ApplyPatch;
use SebastianFeldmann\Git\Command\Diff\ChangedFiles as DiffChangedFiles;
use SebastianFeldmann\Git\Command\Diff\Compare;
use SebastianFeldmann\Git\Command\Diff\Compare\FullDiffList;
use SebastianFeldmann\Git\Command\DiffIndex\GetUnstagedPatch;
use SebastianFeldmann\Git\Command\DiffTree\ChangedFiles as DiffTreeChangedFiles;
use SebastianFeldmann\Git\Command\WriteTree\CreateTreeObject;
use SebastianFeldmann\Git\Diff\File;

/**
 * Class DiffTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 1.2.0
 */
class DiffTest extends OperatorTest
{
    /**
     * Tests Diff::compare
     */
    public function testCompare()
    {
        $root = (string) realpath(__FILE__ . '/../../..');
        $out  = [
            new File('foo', File::OP_MODIFIED),
            new File('bar', File::OP_MODIFIED)
        ];

        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmdRes = new CommandResult('git ...', 0);
        $runRes = new RunnerResult($cmdRes, $out);
        $gitCmd = (new Compare($root))->revisions('1.0.0', '1.1.0')->ignoreWhitespacesAtEndOfLine();

        $repo->method('getRoot')->willReturn($root);
        $runner->expects($this->once())
               ->method('run')
               ->with(
                   $this->equalTo($gitCmd),
                   $this->equalTo(new Compare\FullDiffList())
               )
               ->willReturn($runRes);

        $diff  = new Diff($runner, $repo);
        $files = $diff->compare('1.0.0', '1.1.0');

        $this->assertIsArray($files);
        $this->assertCount(2, $files);
    }

    /**
     * Tests Diff::compareIndexTo
     */
    public function testCompareIndexTo()
    {
        $root = (string) realpath(__FILE__ . '/../../..');
        $out  = [
            new File('foo', File::OP_MODIFIED),
            new File('bar', File::OP_MODIFIED)
        ];

        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmdRes = new CommandResult('git ...', 0);
        $runRes = new RunnerResult($cmdRes, $out);

        $repo->method('getRoot')->willReturn($root);
        $runner->expects($this->once())
               ->method('run')
               ->willReturn($runRes);

        $diff  = new Diff($runner, $repo);
        $files = $diff->compareIndexTo();

        $this->assertIsArray($files);
        $this->assertCount(2, $files);
    }

    /**
     * Tests Diff::changedFiles
     */
    public function testChangedFiles()
    {
        $root = (string) realpath(__FILE__ . '/../../..');
        $out  = 'foo.php' . PHP_EOL . 'bar.php' . PHP_EOL;

        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmdRes = new CommandResult('git ...', 0, $out);
        $runRes = new RunnerResult($cmdRes);
        $gitCmd = (new DiffTreeChangedFiles($root))->fromRevision('1.0.0')->toRevision('1.1.0')->useFilter([]);

        $repo->method('getRoot')->willReturn($root);
        $runner->expects($this->once())
            ->method('run')
            ->with(
                $this->equalTo($gitCmd)
            )
            ->willReturn($runRes);

        $diff  = new Diff($runner, $repo);
        $files = $diff->getChangedFiles('1.0.0', '1.1.0');

        $this->assertIsArray($files);
        $this->assertCount(2, $files);
    }

    public function testChangedFilesBlocksZeroHashes(): void
    {
        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $diff   = new Diff($runner, $repo);
        $files  = $diff->getChangedFiles('0000000000000000000000', '1.1.0');

        $this->assertCount(0, $files);
    }

    /**
     * Tests Diff::changedFilesSinceBranch
     */
    public function testChangedFilesSinceBranch()
    {
        $root = (string) realpath(__FILE__ . '/../../..');
        $out  = 'foo.php' . PHP_EOL . 'bar.php' . PHP_EOL;

        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmdRes = new CommandResult('git ...', 0, $out);
        $runRes = new RunnerResult($cmdRes);
        $gitCmd = (new DiffChangedFiles($root))->mergeBase()->fromRevision('1.0.0')->toRevision('1.1.0')->useFilter([]);

        $repo->method('getRoot')->willReturn($root);
        $runner->expects($this->once())
            ->method('run')
            ->with(
                $this->equalTo($gitCmd)
            )
            ->willReturn($runRes);

        $diff  = new Diff($runner, $repo);
        $files = $diff->getChangedFilesSinceBranch('1.0.0', '1.1.0');

        $this->assertIsArray($files);
        $this->assertCount(2, $files);
    }

    public function testChangedFilesSinceBranchBlocksZeroHashes(): void
    {
        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $diff   = new Diff($runner, $repo);
        $files  = $diff->getChangedFilesSinceBranch('0000000000000000000000', '1.1.0');

        $this->assertCount(0, $files);
    }

    /**
     * Tests Diff::changedFilesOfType
     */
    public function testChangedFilesOfType()
    {
        $root = (string) realpath(__FILE__ . '/../../..');
        $out  = 'foo.php' . PHP_EOL . 'bar.txt' . PHP_EOL;

        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmdRes = new CommandResult('git ...', 0, $out);
        $runRes = new RunnerResult($cmdRes);
        $gitCmd = (new DiffTreeChangedFiles($root))->fromRevision('1.0.0')->toRevision('1.1.0')->useFilter([]);

        $repo->method('getRoot')->willReturn($root);
        $runner->expects($this->once())
            ->method('run')
            ->with(
                $this->equalTo($gitCmd)
            )
            ->willReturn($runRes);

        $diff  = new Diff($runner, $repo);
        $files = $diff->getChangedFilesOfType('1.0.0', '1.1.0', 'php');

        $this->assertIsArray($files);
        $this->assertCount(1, $files);
    }

    public function testChangedFilesOfTypeBlocksZeroHashes(): void
    {
        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $diff   = new Diff($runner, $repo);
        $files  = $diff->getChangedFilesOfType('0000000000000000000000', '1.1.0', 'php');

        $this->assertCount(0, $files);
    }

    public function testGetUnstagedPatchWithNoChangesReturnsNull(): void
    {
        $root = (string) realpath(__FILE__ . '/../../..');

        $repo = $this->getRepoMock();
        $runner = $this->getRunnerMock();

        $treeCmdRes = new CommandResult('git ...', 0, '1234567890');
        $treeRunRes = new RunnerResult($treeCmdRes, []);
        $treeCmd = new CreateTreeObject($root);

        $patchCmdRes = new CommandResult('git ...', 0);
        $patchRunRes = new RunnerResult($patchCmdRes, []);
        $patchCmd = (new GetUnstagedPatch($root))->tree('1234567890');

        $repo->method('getRoot')->willReturn($root);

        $runner->expects($this->exactly(2))
            ->method('run')
            ->withConsecutive([$this->equalTo($treeCmd)], [$this->equalTo($patchCmd)])
            ->willReturnOnConsecutiveCalls($treeRunRes, $patchRunRes);

        $operator = new Diff($runner, $repo);
        $response = $operator->getUnstagedPatch();

        $this->assertNull($response);
    }

    public function testGetUnstagedPatchWithChanges(): void
    {
        $root = (string) realpath(__FILE__ . '/../../..');

        $repo = $this->getRepoMock();
        $runner = $this->getRunnerMock();

        $treeCmdRes = new CommandResult('git ...', 0, '0987654321');
        $treeRunRes = new RunnerResult($treeCmdRes, []);
        $treeCmd = new CreateTreeObject($root);

        $patchCmdRes = new CommandResult('git ...', 1, 'foo bar baz');
        $patchRunRes = new RunnerResult($patchCmdRes, []);
        $patchCmd = (new GetUnstagedPatch($root))->tree('0987654321');

        $repo->method('getRoot')->willReturn($root);

        $runner->expects($this->exactly(2))
            ->method('run')
            ->withConsecutive([$this->equalTo($treeCmd)], [$this->equalTo($patchCmd)])
            ->willReturnOnConsecutiveCalls($treeRunRes, $patchRunRes);

        $operator = new Diff($runner, $repo);
        $response = $operator->getUnstagedPatch();

        $this->assertSame('foo bar baz', $response);
    }

    public function testGetUnstagedPatchWhenTreeObjectCannotBeCreated(): void
    {
        $root = (string) realpath(__FILE__ . '/../../..');

        $repo = $this->getRepoMock();
        $runner = $this->getRunnerMock();

        $treeCmdRes = new CommandResult('git ...', 1);
        $treeRunRes = new RunnerResult($treeCmdRes, []);
        $treeCmd = new CreateTreeObject($root);

        $patchCmdRes = new CommandResult('git ...', 1, 'foo bar baz');
        $patchRunRes = new RunnerResult($patchCmdRes, []);
        $patchCmd = (new GetUnstagedPatch($root))->tree(null);

        $repo->method('getRoot')->willReturn($root);

        $runner->expects($this->exactly(2))
            ->method('run')
            ->withConsecutive([$this->equalTo($treeCmd)], [$this->equalTo($patchCmd)])
            ->willReturnOnConsecutiveCalls($treeRunRes, $patchRunRes);

        $operator = new Diff($runner, $repo);
        $response = $operator->getUnstagedPatch();

        $this->assertSame('foo bar baz', $response);
    }

    public function testApplyPatchesReturnsTrue(): void
    {
        $root = (string) realpath(__FILE__ . '/../../..');

        $repo = $this->getRepoMock();
        $runner = $this->getRunnerMock();

        $cmdRes = new CommandResult('git ...', 0);
        $runRes = new RunnerResult($cmdRes, []);
        $cmd = (new ApplyPatch($root))->patches(['foo.patch'])->whitespace('nowarn');

        $repo->method('getRoot')->willReturn($root);

        $runner->expects($this->once())
            ->method('run')
            ->with($this->equalTo($cmd))
            ->willReturn($runRes);

        $operator = new Diff($runner, $repo);

        $this->assertTrue($operator->applyPatches(['foo.patch']));
    }

    public function testApplyPatchesReturnsFalse(): void
    {
        $root = (string) realpath(__FILE__ . '/../../..');

        $repo = $this->getRepoMock();
        $runner = $this->getRunnerMock();

        $cmdRes = new CommandResult('git ...', 1);
        $runRes = new RunnerResult($cmdRes, []);
        $cmd = (new ApplyPatch($root))->patches(['foo.patch'])->whitespace('nowarn');

        $repo->method('getRoot')->willReturn($root);

        $runner->expects($this->once())
            ->method('run')
            ->with($this->equalTo($cmd))
            ->willReturn($runRes);

        $operator = new Diff($runner, $repo);

        $this->assertFalse($operator->applyPatches(['foo.patch']));
    }

    public function testApplyPatchesSetsAutoCrlfParameter(): void
    {
        $root = (string) realpath(__FILE__ . '/../../..');

        $repo = $this->getRepoMock();
        $runner = $this->getRunnerMock();

        $cmdRes = new CommandResult('git ...', 0);
        $runRes = new RunnerResult($cmdRes, []);
        $cmd = (new ApplyPatch($root))
            ->patches(['foo.patch'])
            ->whitespace('nowarn')
            ->setConfigParameter('core.autocrlf', false);

        $repo->method('getRoot')->willReturn($root);

        $runner->expects($this->once())
            ->method('run')
            ->with($this->equalTo($cmd))
            ->willReturn($runRes);

        $operator = new Diff($runner, $repo);

        $this->assertTrue($operator->applyPatches(['foo.patch'], true));
    }

    public function testCompareTo()
    {
        $root = (string) realpath(__FILE__ . '/../../..');
        $out  = [
            new File('foo', File::OP_MODIFIED),
            new File('bar', File::OP_MODIFIED)
        ];

        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmdRes = new CommandResult('git ...', 0);
        $runRes = new RunnerResult($cmdRes, $out);
        $cmd    = (new Compare($root))->to('HEAD')->ignoreSubmodules()->withContextLines(0);

        $repo->method('getRoot')->willReturn($root);
        $runner->expects($this->once())
            ->method('run')
            ->with(
                $this->equalTo($cmd),
                $this->equalTo(new FullDiffList())
            )
            ->willReturn($runRes);

        $diff  = new Diff($runner, $repo);
        $files = $diff->compareTo();

        $this->assertIsArray($files);
        $this->assertCount(2, $files);
    }
}
