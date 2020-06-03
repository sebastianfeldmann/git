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
use SebastianFeldmann\Git\Command\Diff\Compare;
use SebastianFeldmann\Git\Command\DiffTree\ChangedFiles;
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
     * Tests Diff::compare
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
     * Tests Diff::compare
     */
    public function testChangedFiles()
    {
        $root = (string) realpath(__FILE__ . '/../../..');
        $out  = 'foo.php' . PHP_EOL . 'bar.php' . PHP_EOL;

        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmdRes = new CommandResult('git ...', 0, $out);
        $runRes = new RunnerResult($cmdRes);
        $gitCmd = (new ChangedFiles($root))->fromRevision('1.0.0')->toRevision('1.1.0');

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
}
