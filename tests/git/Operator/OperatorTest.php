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

use SebastianFeldmann\Cli\Command\Runner;
use SebastianFeldmann\Git\Repository;
use PHPUnit\Framework\TestCase;

/**
 * Class OperatorTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 0.9.0
 */
abstract class OperatorTest extends TestCase
{
    /**
     * Return repository mock.
     *
     * @return \SebastianFeldmann\Git\Repository
     */
    protected function getRepoMock()
    {
        $repo = $this->getMockBuilder(Repository::class)
                     ->disableOriginalConstructor()
                     ->getMock();

        return $repo;
    }

    /**
     * Return runner mock.
     *
     * @return \SebastianFeldmann\Cli\Command\Runner
     */
    protected function getRunnerMock()
    {
        $runner = $this->getMockBuilder(Runner::class)
                       ->disableOriginalConstructor()
                       ->getMock();

        return $runner;
    }
}
