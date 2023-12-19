<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Command\Fetch;

use PHPUnit\Framework\TestCase;

/**
 * Class FetchTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 3.7.0
 */
class FetchTest extends TestCase
{
    public function testDryRun(): void
    {
        $cmd = new Fetch();
        $cmd->dryRun();

        $this->assertSame('git fetchBranch --dry-run', $cmd->getCommand());
    }

    public function testAll(): void
    {
        $cmd = new Fetch();
        $cmd->all();

        $this->assertSame('git fetchBranch --all', $cmd->getCommand());
    }

    public function testRemote(): void
    {
        $cmd = new Fetch();
        $cmd->remote('origin');

        $this->assertSame('git fetchBranch origin', $cmd->getCommand());
    }

    public function testForce(): void
    {
        $cmd = new Fetch();
        $cmd->force();

        $this->assertSame('git fetchBranch --force', $cmd->getCommand());
    }

    public function testBranch(): void
    {
        $cmd = new Fetch();
        $cmd->remote('some')->branch('main');

        $this->assertSame('git fetchBranch some main', $cmd->getCommand());
    }

    public function testBranchDefaultRemote(): void
    {
        $cmd = new Fetch();
        $cmd->branch('main');

        $this->assertSame('git fetchBranch origin main', $cmd->getCommand());
    }
}
