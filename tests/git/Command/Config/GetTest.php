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
 * @since   Class available since Release 1.0.2
 */
class GetTest extends TestCase
{
    /**
     * Tests Get::getGitCommand
     */
    public function testDefault()
    {
        $cmd = new Get();
        $exe = $cmd->name('user.name')->getCommand();

        $this->assertEquals("git config --get 'user.name'", $exe);
    }
}
