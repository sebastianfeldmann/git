<?php
/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Git\Command\RevParse;

/**
 * Class GetCommitHashTest
 *
 * @package SebastianFeldmann\Git
 */
class GetCommitHashTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests GetCommitHash::getGitCommand
     */
    public function testGetGitCommand()
    {
        $cmd = new GetCommitHash();
        $exe = $cmd->revision('1.0.0')->getCommand();

        $this->assertEquals('git rev-parse --verify 1.0.0', $exe);
    }
}
