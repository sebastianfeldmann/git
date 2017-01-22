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

class CommitsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests Commits::getCommand
     */
    public function testDefault()
    {
        $cmd    = new Commits();
        $exe    = $cmd->getCommand();

        $this->assertEquals(
            'git log --pretty=format:\'%h -%d %s (%ci) <%an>\' --abbrev-commit --no-merges',
            $exe
        );
    }
}
