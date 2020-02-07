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

use PHPUnit\Framework\TestCase;
use SebastianFeldmann\Git\Command\Tag\GetTags;

/**
 * Class GetTagsTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 2.3.0
 */
class GetTagsTest extends TestCase
{
    /**
     * Tests GetTags::getGitCommand
     */
    public function testGetTagsDefault()
    {
        $cmd = new GetTags();
        $exe = $cmd->getCommand();

        $this->assertEquals('git tag --points-at \'HEAD\'', $exe);
    }

    /**
     * Tests GetTags::getGitCommand
     */
    public function testGetTagsFromHash()
    {
        $cmd = new GetTags();
        $cmd->pointingTo('1234567890');
        $exe = $cmd->getCommand();

        $this->assertEquals('git tag --points-at \'1234567890\'', $exe);
    }
}
