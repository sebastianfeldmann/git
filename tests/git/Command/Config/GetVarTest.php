<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Command\Config;

use PHPUnit\Framework\TestCase;

/**
 * Class GetTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 3.14.0
 */
class GetVarTest extends TestCase
{
    /**
     * Tests GetVar::getGitCommand
     */
    public function testDefault()
    {
        $cmd = new GetVar();
        $exe = $cmd->name('user.name')->getCommand();

        $this->assertEquals("git var 'user.name'", $exe);
    }
}
