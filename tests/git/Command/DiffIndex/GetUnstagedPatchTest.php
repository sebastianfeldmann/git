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
 * Class GetUnstagedPatchTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 3.7.0
 */
class GetUnstagedPatchTest extends TestCase
{
    public function testGetAcceptableExitCodes()
    {
        $cmd = new GetUnstagedPatch();

        $this->assertSame([0, 1], $cmd->getAcceptableExitCodes());
    }

    public function testGetUnstagedPatchWithoutTree()
    {
        $cmd = new GetUnstagedPatch();

        $this->assertSame(
            'git diff-index --ignore-submodules --binary --exit-code --no-color --no-ext-diff -- ',
            $cmd->getCommand()
        );
    }

    public function testGetUnstagedPatchWithTree()
    {
        $cmd = (new GetUnstagedPatch())->tree('1234567890');

        $this->assertSame(
            'git diff-index --ignore-submodules --binary --exit-code --no-color --no-ext-diff \'1234567890\' -- ',
            $cmd->getCommand()
        );
    }
}
