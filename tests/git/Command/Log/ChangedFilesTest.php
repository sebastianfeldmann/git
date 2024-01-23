<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Command\Log;

use PHPUnit\Framework\TestCase;

/**
 * Class ChangedFilesTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 0.9.0
 */
class ChangedFilesTest extends TestCase
{
    /**
     * Tests ChangedFiles::getCommand
     */
    public function testDefault()
    {
        $cmd    = new ChangedFiles();
        $exe    = $cmd->getCommand();

        $this->assertEquals(
            'git log --format=\'\' --name-only --no-merges',
            $exe
        );
    }

    /**
     * Tests ChangedFiles::getCommand
     */
    public function testWithFilter()
    {
        $cmd = new ChangedFiles();
        $cmd->withDiffFilter(['A']);
        $exe = $cmd->getCommand();

        $this->assertEquals(
            'git log --format=\'\' --name-only --diff-filter=A --no-merges',
            $exe
        );
    }
}
