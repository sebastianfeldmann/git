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

class ChangedFilesSinceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests CommitsSince::getCommand
     */
    public function testDefault()
    {
        $cmd    = new ChangedFilesSince();
        $exe    = $cmd->getCommand();

        $this->assertEquals(
            'git log --format=\'\' --name-only --no-merges',
            $exe
        );
    }
}
