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

/**
 * Class InfoTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 1.0.8
 */
class InfoTest extends OperatorTest
{
    /**
     * Tests Info::getCurrentTag
     */
    public function testGetCurrentTagSuccess()
    {
        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmd    = new CommandResult('git describe --tags', 0, '1.0.1' . PHP_EOL);
        $result = new RunnerResult($cmd);

        $repo->method('getRoot')->willReturn(realpath(__FILE__ . '/../../..'));

        $runner->expects($this->once())
               ->method('run')
               ->willReturn($result);

        $operator = new Info($runner, $repo);
        $tag      = $operator->getCurrentTag();

        $this->assertEquals('1.0.1', $tag);
    }

    /**
     * Tests Info::getCurrentTag
     */
    public function testGetCurrentTagFail()
    {
        $this->expectException(RuntimeException::class);

        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();

        $repo->method('getRoot')->willReturn(realpath(__FILE__ . '/../../..'));
        $runner->method('run')->will($this->throwException(new RuntimeException()));

        $operator = new Info($runner, $repo);
        $tag      = $operator->getCurrentTag();

        // should never get asserted and fail in error case
        $this->assertEquals('1.0.0', $tag);
    }

    /**
     * Tests Info::getMostRecentTag
     */
    public function testMostRecentTagSuccess()
    {
        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmd    = new CommandResult('git describe --tags --abbrev=0', 0, '1.0.1' . PHP_EOL);
        $result = new RunnerResult($cmd);

        $repo->method('getRoot')->willReturn(realpath(__FILE__ . '/../../..'));

        $runner->expects($this->once())
               ->method('run')
               ->willReturn($result);

        $operator = new Info($runner, $repo);
        $tag      = $operator->getMostRecentTag();

        $this->assertEquals('1.0.1', $tag);
    }

    /**
     * Tests Info::getMostRecentTagBefore
     */
    public function testMostRecentTagBeforeSuccess()
    {
        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmd    = new CommandResult('git describe --tags --abbrev=0 1.0.2^', 0, '1.0.1' . PHP_EOL);
        $result = new RunnerResult($cmd);

        $repo->method('getRoot')->willReturn(realpath(__FILE__ . '/../../..'));

        $runner->expects($this->once())
               ->method('run')
               ->willReturn($result);

        $operator = new Info($runner, $repo);
        $tag      = $operator->getMostRecentTagBefore('1.0.2');

        $this->assertEquals('1.0.1', $tag);
    }

    /**
     * Tests Info::getTagsFrom
     */
    public function testTagsFromSuccess()
    {
        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmd    = new CommandResult('tag --points-at \'HEAD\'', 0, '1.0.1' . PHP_EOL . '1.0.2' . PHP_EOL);
        $result = new RunnerResult($cmd);

        $repo->method('getRoot')->willReturn(realpath(__FILE__ . '/../../..'));

        $runner->expects($this->once())
               ->method('run')
               ->willReturn($result);

        $operator = new Info($runner, $repo);
        $tags     = $operator->getTagsPointingTo('HEAD');

        $this->assertCount(2, $tags);
        $this->assertEquals('1.0.1', $tags[0]);
        $this->assertEquals('1.0.2', $tags[1]);
    }

    /**
     * Tests Info::getCurrentCommitHash
     */
    public function testGetCurrentCommitHashSuccess()
    {
        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmd    = new CommandResult('git rev-parse --verify 6b1cb23', 0, '6b1cb23' . PHP_EOL);
        $result = new RunnerResult($cmd);

        $repo->method('getRoot')->willReturn(realpath(__FILE__ . '/../../..'));

        $runner->expects($this->once())
            ->method('run')
            ->willReturn($result);

        $operator = new Info($runner, $repo);
        $tag      = $operator->getCurrentCommitHash();

        $this->assertEquals('6b1cb23', $tag);
    }

    /**
     * Tests Info::getCurrentCommitHash
     */
    public function testGetCurrentBranchSuccess()
    {
        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmd    = new CommandResult('git rev-parse --abbrev-ref HEAD', 0, 'master' . PHP_EOL);
        $result = new RunnerResult($cmd);

        $repo->method('getRoot')->willReturn(realpath(__FILE__ . '/../../..'));

        $runner->expects($this->once())
               ->method('run')
               ->willReturn($result);

        $operator = new Info($runner, $repo);
        $branch   = $operator->getCurrentBranch();

        $this->assertEquals('master', $branch);
    }
}
