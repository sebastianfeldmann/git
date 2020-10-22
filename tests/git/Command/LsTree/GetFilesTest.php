<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Command\LsTree;

use PHPUnit\Framework\TestCase;

/**
 * Class TestGetFiles
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 3.4.0
 */
class GetFilesTest extends TestCase
{
    /**
     * Tests GetFiles::getGitCommand
     */
    public function testDefault()
    {
        $cmd = new GetFiles();
        $exe = $cmd->getCommand();

        $this->assertEquals("git ls-tree --name-only -r HEAD", $exe);
    }

    /**
     * Tests GetFiles::getGitCommand
     */
    public function testSupplyingEmptyPath()
    {
        $cmd = new GetFiles();
        $exe = $cmd->inPath('')->getCommand();

        $this->assertEquals("git ls-tree --name-only -r HEAD", $exe);
    }

    /**
     * Tests GetFiles::getGitCommand
     */
    public function testDifferentTree()
    {
        $cmd = new GetFiles();
        $exe = $cmd->fromTree('2e88138da4a')->getCommand();

        $this->assertEquals("git ls-tree --name-only -r 2e88138da4a", $exe);
    }

    /**
     * Tests GetFiles::getGitCommand
     */
    public function testGetInPath()
    {
        $cmd = new GetFiles();
        $exe = $cmd->inPath('test/**/*.Test.php')->getCommand();

        $this->assertEquals("git ls-tree --name-only -r HEAD test/**/*.Test.php", $exe);
    }
}
