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
use SebastianFeldmann\Git\Command\DiffIndex\GetStagedFiles;
use SebastianFeldmann\Git\Command\DiffIndex\GetStagedFiles\FilterByStatus;
use SebastianFeldmann\Git\Command\RevParse\GetCommitHash;

/**
 * Class StagedFilesTest
 *
 * @package SebastianFeldmann\Git\Operator
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

        $repo->method('getRoot')->willReturn(realpath(__FILE__ . '/../../..'));

        $runner->expects($this->exactly(2))
               ->method('run')
               ->withConsecutive(
                [
                    $this->equalTo(new GetCommitHash($repo->getRoot()))
                ],
                [
                   $this->equalTo(new GetStagedFiles($repo->getRoot())),
                   $this->equalTo(new FilterByStatus(['A', 'M']))
                ]
               )
               ->will(
                   $this->onConsecutiveCalls($result, $result)
               );
               //->willReturn($result);

        $operator = new Index($runner, $repo);
        $files    = $operator->getStagedFiles();

        $this->assertTrue(is_array($files));
        $this->assertEquals(4, count($files));
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

        $repo->method('getRoot')->willReturn(realpath(__FILE__ . '/../../..'));
        $runner->method('run')->willReturn($result);

        $operator = new Index($runner, $repo);
        $files    = $operator->getStagedFilesOfType('php');

        $this->assertTrue(is_array($files));
        $this->assertEquals(2, count($files));
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

        $repo->method('getRoot')->willReturn(realpath(__FILE__ . '/../../..'));
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

        $repo->method('getRoot')->willReturn(realpath(__FILE__ . '/../../..'));
        $runner->method('run')->will($this->throwException(new RuntimeException));

        $operator = new Index($runner, $repo);
        $files    = $operator->getStagedFiles();

        $this->assertEquals([], $files);
    }
}
