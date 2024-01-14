<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Command\RevLog;

use PHPUnit\Framework\TestCase;
use SebastianFeldmann\Git\Command\RefLog\BranchRevs;

/**
 * Class BranchRevsTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 3.10.0
 */
class BranchRevsTest extends TestCase
{
    /**
     * Tests BranchRevs::getGitCommand
     */
    public function testDefault()
    {
        $cmd = new BranchRevs();
        $exe = $cmd->fromBranch('demo')->getCommand();

        $this->assertEquals('git reflog demo', $exe);
    }

    /**
     * Tests BranchRevs::getGitCommand
     */
    public function testWithFormat()
    {
        $cmd = new BranchRevs();
        $exe = $cmd->fromBranch('demo')->format('%H')->getCommand();

        $this->assertEquals('git reflog --format=\'%H\' demo', $exe);
    }
}
