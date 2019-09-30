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

use PHPUnit\Framework\TestCase;

/**
 * Class GetCommitHashTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 2.3.1
 */
class GetBranchTest extends TestCase
{
    /**
     * Tests GetBranch::getGitCommand
     */
    public function testGetGitCommand()
    {
        $cmd = new GetBranch();
        $exe = $cmd->getCommand();

        $this->assertEquals('git rev-parse --abbrev-ref HEAD', $exe);
    }
}
