<?php
/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Git\Command\Describe;

/**
 * Class GetCurrentTagTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 1.0.8
 */
class GetCurrentTagTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests GetCurrentTag::getGitCommand
     */
    public function testGetCurrentTag()
    {
        $cmd = new GetCurrentTag();
        $exe = $cmd->getCommand();

        $this->assertEquals('git describe --tags', $exe);
    }
}
