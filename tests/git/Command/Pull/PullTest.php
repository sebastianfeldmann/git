<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Command\Pull;

use PHPUnit\Framework\TestCase;

/**
 * Class PullTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 3.9.4
 */
class PullTest extends TestCase
{
    public function testDryRun(): void
    {
        $cmd = new Pull();
        $cmd->dryRun();

        $this->assertSame('git pullBranch --dry-run', $cmd->getCommand());
    }

    public function testFastForward(): void
    {
        $cmd = new Pull();
        $cmd->mergeFastForward();

        $this->assertSame('git pullBranch --ff', $cmd->getCommand());
    }

    public function testNoFastForward(): void
    {
        $cmd = new Pull();
        $cmd->mergeFastForward(false);

        $this->assertSame('git pullBranch --no-ff', $cmd->getCommand());
    }


    public function testFastForwardOnlyNoFastForward(): void
    {
        $cmd = new Pull();
        $cmd->mergeFastForward(false)->fastForwardOnly();

        $this->assertSame('git pullBranch --no-ff --ff-only', $cmd->getCommand());
    }

    public function testRemote(): void
    {
        $cmd = new Pull();
        $cmd->remote('origin');

        $this->assertSame('git pullBranch origin', $cmd->getCommand());
    }

    public function testBranch(): void
    {
        $cmd = new Pull();
        $cmd->remote('some')->branch('main');

        $this->assertSame('git pullBranch some main', $cmd->getCommand());
    }

    public function testBranchDefaultRemote(): void
    {
        $cmd = new Pull();
        $cmd->branch('main');

        $this->assertSame('git pullBranch origin main', $cmd->getCommand());
    }
}
