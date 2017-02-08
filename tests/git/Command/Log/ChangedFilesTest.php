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

/**
 * Class ChangedFilesTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 0.9.0
 */
class ChangedFilesTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests Commits::getCommand
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
}
