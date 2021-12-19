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

use RuntimeException;
use SebastianFeldmann\Cli\Command\Result as CommandResult;
use SebastianFeldmann\Cli\Command\Runner\Result as RunnerResult;
use SebastianFeldmann\Git\Command\Add\AddFiles;
use SebastianFeldmann\Git\Command\DiffIndex\GetStagedFiles;
use SebastianFeldmann\Git\Command\DiffIndex\GetStagedFiles\FilterByStatus;
use SebastianFeldmann\Git\Command\RevParse\GetCommitHash;
use SebastianFeldmann\Git\Command\Rm\RemoveFiles;

/**
 * Class IndexTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 0.9.0
 */
class IndexTest extends OperatorTest
{
    /**
     * Tests StagedFiles::getStagedFiles
     */
    public function testGetStagedFiles()
    {
        $out = [
            '/foo/bar.txt',
            '/fiz/baz.txt',
            '/foo/bar.php',
            '/fiz/baz.php',
        ];

        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmd    = new CommandResult('git ...', 0);
        $result = new RunnerResult($cmd, $out);

        $repo->method('getRoot')->willReturn((string) realpath(__FILE__ . '/../../..'));

        $runner->expects($this->exactly(3))
               ->method('run')
               ->withConsecutive(
                   [
                       $this->equalTo(new GetCommitHash($repo->getRoot()))
                   ],
                   [
                      $this->equalTo(new GetStagedFiles($repo->getRoot())),
                      $this->equalTo(new FilterByStatus(['A', 'C', 'M', 'R']))
                   ],
                   [
                       $this->equalTo(new GetCommitHash($repo->getRoot()))
                   ]
               )
               ->will(
                   $this->onConsecutiveCalls($result, $result, $result)
               );

        $operator = new Index($runner, $repo);
        $files1   = $operator->getStagedFiles();
        $files2   = $operator->getStagedFiles();

        $this->assertIsArray($files1);
        $this->assertCount(4, $files1);
        $this->assertCount(4, $files2);
    }

    /**
     * Tests StagedFiles::getStagedFilesOfType
     */
    public function testGetStagedFilesOfType()
    {
        $out = [
            '/foo/bar.txt',
            '/fiz/baz.txt',
            '/foo/bar.php',
            '/fiz/baz.php',
        ];

        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmd    = new CommandResult('git ...', 0);
        $result = new RunnerResult($cmd, $out);

        $repo->method('getRoot')->willReturn((string) realpath(__FILE__ . '/../../..'));
        $runner->method('run')->willReturn($result);

        $operator = new Index($runner, $repo);
        $files    = $operator->getStagedFilesOfType('php');

        $this->assertIsArray($files);
        $this->assertCount(2, $files);
    }

    /**
     * Tests StagedFiles::getStagedFilesOfType
     */
    public function testHasStagedFilesOfType()
    {
        $out = [
            '/foo/bar.txt',
            '/fiz/baz.txt',
            '/foo/bar.php',
            '/fiz/baz.php',
        ];

        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmd    = new CommandResult('git ...', 0);
        $result = new RunnerResult($cmd, $out);

        $repo->method('getRoot')->willReturn((string) realpath(__FILE__ . '/../../..'));
        $runner->method('run')->willReturn($result);

        $operator = new Index($runner, $repo);

        $this->assertTrue($operator->hasStagedFilesOfType('php'));
        $this->assertFalse($operator->hasStagedFilesOfType('xml'));
    }

    /**
     * Tests StagedFiles::getStagedFiles
     */
    public function testHasStagedFilesInvalidHead()
    {
        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmd    = new CommandResult('git ...', 1);
        $result = new RunnerResult($cmd, []);

        $repo->method('getRoot')->willReturn((string) realpath(__FILE__ . '/../../..'));
        $runner->method('run')->will($this->throwException(new RuntimeException()));

        $operator = new Index($runner, $repo);
        $files    = $operator->getStagedFiles();

        $this->assertEquals([], $files);
    }

    public function testAddFilesToIndexReturnsTrue(): void
    {
        $root = (string) realpath(__FILE__ . '/../../..');

        $repo = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmdRes = new CommandResult('git ...', 0);
        $runRes = new RunnerResult($cmdRes, ['foobar']);
        $gitCmd = (new AddFiles($root))->files(['foo', 'bar']);

        $repo->method('getRoot')->willReturn($root);
        $runner->expects($this->once())
            ->method('run')
            ->with($this->equalTo($gitCmd))
            ->willReturn($runRes);

        $operator = new Index($runner, $repo);
        $result = $operator->addFilesToIndex(['foo', 'bar']);

        $this->assertTrue($result);
    }

    public function testAddFilesToIndexReturnsFalseForNonZeroExitCode(): void
    {
        $root = (string) realpath(__FILE__ . '/../../..');

        $repo = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmdRes = new CommandResult('git ...', 127);
        $runRes = new RunnerResult($cmdRes, ['foobar']);
        $gitCmd = (new AddFiles($root))->files(['foo', 'bar']);

        $repo->method('getRoot')->willReturn($root);
        $runner->expects($this->once())
            ->method('run')
            ->with($this->equalTo($gitCmd))
            ->willReturn($runRes);

        $operator = new Index($runner, $repo);
        $result = $operator->addFilesToIndex(['foo', 'bar']);

        $this->assertFalse($result);
    }

    public function testUpdateIndexReturnsTrue(): void
    {
        $root = (string) realpath(__FILE__ . '/../../..');

        $repo = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmdRes = new CommandResult('git ...', 0);
        $runRes = new RunnerResult($cmdRes, ['foobar']);
        $gitCmd = (new AddFiles($root))->files(['foo', 'bar'])->update();

        $repo->method('getRoot')->willReturn($root);
        $runner->expects($this->once())
            ->method('run')
            ->with($this->equalTo($gitCmd))
            ->willReturn($runRes);

        $operator = new Index($runner, $repo);
        $result = $operator->updateIndex(['foo', 'bar']);

        $this->assertTrue($result);
    }

    public function testUpdateIndexReturnsFalseForNonZeroExitCode(): void
    {
        $root = (string) realpath(__FILE__ . '/../../..');

        $repo = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmdRes = new CommandResult('git ...', 42);
        $runRes = new RunnerResult($cmdRes, ['foobar']);
        $gitCmd = (new AddFiles($root))->files(['foo', 'bar'])->update();

        $repo->method('getRoot')->willReturn($root);
        $runner->expects($this->once())
            ->method('run')
            ->with($this->equalTo($gitCmd))
            ->willReturn($runRes);

        $operator = new Index($runner, $repo);
        $result = $operator->updateIndex(['foo', 'bar']);

        $this->assertFalse($result);
    }

    public function testUpdateIndexToMatchIndexReturnsTrue(): void
    {
        $root = (string) realpath(__FILE__ . '/../../..');

        $repo = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmdRes = new CommandResult('git ...', 0);
        $runRes = new RunnerResult($cmdRes, ['foobar']);
        $gitCmd = (new AddFiles($root))->files(['foo', 'bar'])->all();

        $repo->method('getRoot')->willReturn($root);
        $runner->expects($this->once())
            ->method('run')
            ->with($this->equalTo($gitCmd))
            ->willReturn($runRes);

        $operator = new Index($runner, $repo);
        $result = $operator->updateIndexToMatchWorkingTree(['foo', 'bar']);

        $this->assertTrue($result);
    }

    public function testUpdateIndexToMatchIndexReturnsFalseForNonZeroExitStatus(): void
    {
        $root = (string) realpath(__FILE__ . '/../../..');

        $repo = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmdRes = new CommandResult('git ...', 89);
        $runRes = new RunnerResult($cmdRes, ['foobar']);
        $gitCmd = (new AddFiles($root))->files(['foo', 'bar'])->all();

        $repo->method('getRoot')->willReturn($root);
        $runner->expects($this->once())
            ->method('run')
            ->with($this->equalTo($gitCmd))
            ->willReturn($runRes);

        $operator = new Index($runner, $repo);
        $result = $operator->updateIndexToMatchWorkingTree(['foo', 'bar']);

        $this->assertFalse($result);
    }

    public function testUpdateIndexToMatchIndexIgnoringRemovalReturnsTrue(): void
    {
        $root = (string) realpath(__FILE__ . '/../../..');

        $repo = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmdRes = new CommandResult('git ...', 0);
        $runRes = new RunnerResult($cmdRes, ['foobar']);
        $gitCmd = (new AddFiles($root))->files(['foo', 'bar'])->noAll();

        $repo->method('getRoot')->willReturn($root);
        $runner->expects($this->once())
            ->method('run')
            ->with($this->equalTo($gitCmd))
            ->willReturn($runRes);

        $operator = new Index($runner, $repo);
        $result = $operator->updateIndexToMatchWorkingTree(['foo', 'bar'], true);

        $this->assertTrue($result);
    }

    public function testUpdateIndexToMatchIndexIgnoringRemovalReturnsFalseForNonZeroExitStatus(): void
    {
        $root = (string) realpath(__FILE__ . '/../../..');

        $repo = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmdRes = new CommandResult('git ...', 254);
        $runRes = new RunnerResult($cmdRes, ['foobar']);
        $gitCmd = (new AddFiles($root))->files(['foo', 'bar'])->noAll();

        $repo->method('getRoot')->willReturn($root);
        $runner->expects($this->once())
            ->method('run')
            ->with($this->equalTo($gitCmd))
            ->willReturn($runRes);

        $operator = new Index($runner, $repo);
        $result = $operator->updateIndexToMatchWorkingTree(['foo', 'bar'], true);

        $this->assertFalse($result);
    }

    public function testRecordIntentToAddFilesReturnsTrue(): void
    {
        $root = (string) realpath(__FILE__ . '/../../..');

        $repo = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmdRes = new CommandResult('git ...', 0);
        $runRes = new RunnerResult($cmdRes, ['foobar']);
        $gitCmd = (new AddFiles($root))->files(['foo', 'bar'])->intentToAdd();

        $repo->method('getRoot')->willReturn($root);
        $runner->expects($this->once())
            ->method('run')
            ->with($this->equalTo($gitCmd))
            ->willReturn($runRes);

        $operator = new Index($runner, $repo);
        $result = $operator->recordIntentToAddFiles(['foo', 'bar']);

        $this->assertTrue($result);
    }

    public function testRecordIntentToAddFilesReturnsFalseForNonZeroExitCode(): void
    {
        $root = (string) realpath(__FILE__ . '/../../..');

        $repo = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmdRes = new CommandResult('git ...', 127);
        $runRes = new RunnerResult($cmdRes, ['foobar']);
        $gitCmd = (new AddFiles($root))->files(['foo', 'bar'])->intentToAdd();

        $repo->method('getRoot')->willReturn($root);
        $runner->expects($this->once())
            ->method('run')
            ->with($this->equalTo($gitCmd))
            ->willReturn($runRes);

        $operator = new Index($runner, $repo);
        $result = $operator->recordIntentToAddFiles(['foo', 'bar']);

        $this->assertFalse($result);
    }

    public function testRemoveFilesReturnsTrue(): void
    {
        $root = (string) realpath(__FILE__ . '/../../..');

        $repo = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmdRes = new CommandResult('git ...', 0);
        $runRes = new RunnerResult($cmdRes, ['foobar']);
        $gitCmd = (new RemoveFiles($root))->files(['foo', 'bar'])->recursive()->cached();

        $repo->method('getRoot')->willReturn($root);
        $runner->expects($this->once())
            ->method('run')
            ->with($this->equalTo($gitCmd))
            ->willReturn($runRes);

        $operator = new Index($runner, $repo);
        $result = $operator->removeFiles(['foo', 'bar'], true, true);

        $this->assertTrue($result);
    }

    public function testRemoveFilesReturnsFalseWhenCommandHasNonZeroExitCode(): void
    {
        $root = (string) realpath(__FILE__ . '/../../..');

        $repo = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmdRes = new CommandResult('git ...', 127);
        $runRes = new RunnerResult($cmdRes, ['foobar']);
        $gitCmd = (new RemoveFiles($root))->files(['foo', 'bar']);

        $repo->method('getRoot')->willReturn($root);
        $runner->expects($this->once())
            ->method('run')
            ->with($this->equalTo($gitCmd))
            ->willReturn($runRes);

        $operator = new Index($runner, $repo);
        $result = $operator->removeFiles(['foo', 'bar']);

        $this->assertFalse($result);
    }
}
