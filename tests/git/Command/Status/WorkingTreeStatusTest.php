<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Command\Status;

use PHPUnit\Framework\TestCase;

/**
 * Class GetWorkingTreeStatusTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release ?.?.?
 */
class WorkingTreeStatusTest extends TestCase
{
    public function testWorkingTreeStatus()
    {
        $status = new WorkingTreeStatus();

        $this->assertSame('git status --porcelain=v1 -z', $status->getCommand());
    }

    public function testWorkingTreeStatusIgnoringSubmodules()
    {
        $status = (new WorkingTreeStatus())->ignoreSubmodules();

        $this->assertSame('git status --porcelain=v1 -z --ignore-submodules', $status->getCommand());
    }
}
