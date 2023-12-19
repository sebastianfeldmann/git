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
 * Class RemoteTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 3.9.4
 */
class RemoteTest extends OperatorTest
{
    /**
     * Tests Remote::fetchBranch
     */
    public function testFetch()
    {
        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmd    = new CommandResult('git fetch origin main', 0, '');
        $result = new RunnerResult($cmd);

        $repo->method('getRoot')->willReturn((string) realpath(__FILE__ . '/../../..'));

        $runner->expects($this->once())
               ->method('run')
               ->willReturn($result);

        $operator = new Remote($runner, $repo);
        $operator->fetchBranch('origin', 'main');
    }

    /**
     * Tests Remote::pullBranch
     */
    public function testPull()
    {
        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmd    = new CommandResult('git pull origin main', 0, '');
        $result = new RunnerResult($cmd);

        $repo->method('getRoot')->willReturn((string) realpath(__FILE__ . '/../../..'));
        $runner->expects($this->once())
               ->method('run')
               ->willReturn($result);

        $operator = new Remote($runner, $repo);
        $operator->pullBranch('origin', 'main');
    }
}
