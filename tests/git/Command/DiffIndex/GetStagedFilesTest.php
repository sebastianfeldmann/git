<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Command\DiffIndex;

use PHPUnit\Framework\TestCase;

/**
 * Class GetStagedFilesTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 0.9.0
 */
class GetStagedFilesTest extends TestCase
{
    /**
     * Tests GetStagedFiles::getGitCommand
     */
    public function testGetGitCommand()
    {
        $cmd = new GetStagedFiles();
        $exe = $cmd->getCommand();

        $this->assertEquals('git diff-index --no-ext-diff --cached --name-status HEAD', $exe);
    }
}
